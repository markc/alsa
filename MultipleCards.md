MultipleCards
=============

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Naming multiple audio devices has always been a hot issue, until
recently. This article tries to clarify the recommended ways to use and
name multiple devices.

If you have multiple sound cards, or audio on the motherboard and an
external sound card, ALSA may not use the devices you prefer.

Contents
--------

-   [1 See what's going on](#See_what.27s_going_on)
-   [2 Strategy](#Strategy)
-   [3 Understanding
    /etc/modprobe.d/alsa.conf](#Understanding_.2Fetc.2Fmodprobe.d.2Falsa.conf)
    -   [3.1 alsa.conf structure](#alsa.conf_structure)
    -   [3.2 Problems with alsa.conf and
        udev](#Problems_with_alsa.conf_and_udev)
        -   [3.2.1 Reordering the driver for a particular
            card](#Reordering_the_driver_for_a_particular_card)
        -   [3.2.2 Module ordering problems](#Module_ordering_problems)

-   [4 Understanding Alsa naming](#Understanding_Alsa_naming)
    -   [4.1 Single device](#Single_device)
    -   [4.2 Multiple devices](#Multiple_devices)
    -   [4.3 Example commands and options for selecting sound
        cards:](#Example_commands_and_options_for_selecting_sound_cards:)

-   [5 How to choose a particular order for multiple installed
    cards](#How_to_choose_a_particular_order_for_multiple_installed_cards)
    -   [5.1 The older "index="
        method](#The_older_.22index.3D.22_method)
    -   [5.2 The newer "slots="
        method](#The_newer_.22slots.3D.22_method)

-   [6 Ordering multiple cards of the same
    type](#Ordering_multiple_cards_of_the_same_type)
-   [7 Why doesn't this code work when using newer ALSA
    versions?](#Why_doesn.27t_this_code_work_when_using_newer_ALSA_versions.3F)
-   [8 Some examples configurations](#Some_examples_configurations)
    -   [8.1 Loading the kernel modules for multiple
        cards](#Loading_the_kernel_modules_for_multiple_cards)
    -   [8.2 Multiple Sound Cards -- Example on Debian
        GNU/Linux](#Multiple_Sound_Cards_--_Example_on_Debian_GNU.2FLinux)
    -   [8.3 RE: How do I select one card or the
        other?](#RE:_How_do_I_select_one_card_or_the_other.3F)
        -   [8.3.1 Example commands and options for selecting sound
            cards:](#Example_commands_and_options_for_selecting_sound_cards:_2)

    -   [8.4 Multiple USB Audio Devices](#Multiple_USB_Audio_Devices)
    -   [8.5 I have all my stuff statically compiled into the
        kernel](#I_have_all_my_stuff_statically_compiled_into_the_kernel)
    -   [8.6 Easy way to do this on Ubuntu
        Dapper](#Easy_way_to_do_this_on_Ubuntu_Dapper)
    -   [8.7 Easy way to do this on Ubuntu
        Edgy](#Easy_way_to_do_this_on_Ubuntu_Edgy)
    -   [8.8 I have a m-audio keystation connected via usb, and it
        hogs](#I_have_a_m-audio_keystation_connected_via_usb.2C_and_it_hogs)

-   [9 See also](#See_also)

See what's going on
-------------------

See [Troubleshooting](/Troubleshooting "Troubleshooting") to play a file
and see which card ALSA uses.

At a low-level, the files `cards`, `modules`, and `devices` in the
directory `/proc/asound` show how ALSA has configured itself.

Strategy
--------

You can either modify a user's [.asoundrc](/.asoundrc ".asoundrc") file
to tell ALSA that user's preferences for cards, or alter how ALSA loads
modules and drivers.

Understanding /etc/modprobe.d/alsa.conf
---------------------------------------

`/etc/modprobe.d/alsa.conf` (or `/etc/modprobe.d/alsa-base.conf` or
similar) is the main ALSA configuration file in most linux systems. Its
syntax and all the options and parameters are explained in
`/usr/src/linux/Documentation/sound/alsa/ALSA-Configuration.txt`. If you
don't have the kernel sources, you will find this file with the
documentation of the `alsa-driver` package.

You will need root permissions to modify this file; one way is to prefix
each command here with `sudo`. After modifying the configuration file,
you need to reboot your computer to see the effect; you may be able to
preview the effect by restarting ALSA with a command like (as root)

    /etc/init.d/alsasound restart

or possibly

    /sbin/alsa force-reload  

### alsa.conf structure

The content of alsa.conf can be separated into a few sections.

    # ALSA portion
    alias char-major-116 snd
    alias snd-card-0 snd-ice1724

This will load the core ALSA module as well as the module for an
Audiophile 192. When more than one card, add a line for each card. (Even
a webcam with a mic is a sound card for ALSA.)

    # module options should go here
    # actual card's number [default=1]
    options snd cards_limit=1
    # card(s) specific options
    options snd-ice1724 index=0 model=ap192

This will load the wanted options for the different modules. Multiples
options for different cards with the same modules can be defined as
follow:

    options snd-usb-audio index=1,2 vid=0x0ccd,0x0d8c pid=0x0028,0x000c

This will define 2 usb sound cards, the first one at index=1, vid=0x0ccd
and pid=0x0028; the second one at index=2, vid=0x0d8c and pid=0x000c.

    # OSS/Free portion
    alias char-major-14 soundcore
    alias sound-slot-0 snd-card-0

This will load the main aliases and modules for OSS-emulation. Add one
`sound-slot-n` line for each subsequent card.

    # OSS/Free portion - card #1
    alias sound-service-0-0 snd-mixer-oss
    alias sound-service-0-1 snd-seq-oss
    alias sound-service-0-3 snd-pcm-oss
    alias sound-service-0-8 snd-seq-oss
    alias sound-service-0-12 snd-pcm-oss

This will load the aliases for the first sound card.

Each subsequent card must have something like the following:

    # OSS/Free portion - card #2
    alias sound-service-1-0 snd-mixer-oss
    alias sound-service-1-3 snd-pcm-oss
    alias sound-service-1-12 snd-pcm-oss

### Problems with alsa.conf and udev

On modern GNU/Linux systems, *udev* takes care of discovering hardware
and loading/unloading Alsa. There is one drawback to udev. Udev will
load Alsa modules in an undefined order. After each reboot or
plugging/unplugging a device, there is no guarantee that a device is
renamed using the same *hw:x,y* numbers. For example, if you have two
USB devices on your systems, for example an Audeon USB and an Edirol
UA-25, after each reboot, a card can be "hw:0,0" and the other "hw:1,0",
each time randomly.

/etc/init.d/alsasound is an udev wrapper that will take care of loading
the ALSA modules during booting. But even with it, a few problems may
still occurs.

#### Reordering the driver for a particular card

You can tell /etc/modprobe.d/alsa.conf (or alsa-base.conf, or similar)
to keep a driver in out of the default slot. For example, if you have a
a Creative Labs soundcard driven by the "emu10k1" driver and you don't
want it to be your default card 0, append

    options snd slots=,snd-emu10k1

Note the comma in this line that moves the driver to the second slot.

#### Module ordering problems

It may be that the sound card order is wrong after booting, but running
(as root)

    /etc/init.d/alsasound restart

or

    /sbin/alsa force-reload

gives the wanted card order.

This can happen because udev is loading some sound driver before
alsasound, and alsasound gets confused. A restart will first unload all
the sound modules and when restarting, alsasound will work as expected.

The solution is to blacklist the module(s) that udev is loading before
alsasound (Typically, the one you get as sound card 0 after booting).
You must do this into

    /etc/modprobe.d/blacklist.conf

You must also report it as a bug to your distribution.

Understanding Alsa naming
-------------------------

### Single device

Originally, Alsa was only able to name an audio device using the
*hw:x,y* syntax, where x and y are numbers.

For example, if there is only one device installed, in most cases, the
device should be named `hw:0,0`. When there is only one device, the
device should always have the same name and numbers.

### Multiple devices

Running `aplay -l` dislays a list of *PLAYBACK Hardware Devices*. For
example, on my system:

    $aplay -l
    **** List of PLAYBACK Hardware Devices ****
    card 0: UA25 [EDIROL UA-25], device 0: USB Audio [USB Audio]
     Subdevices: 1/1
     Subdevice #0: subdevice #0
    card 1: Audio [USB Audio], device 0: USB Audio [USB Audio]
     Subdevices: 1/1
     Subdevice #0: subdevice #0

In this example the audio devices are named "UA25" and "Audio".

### Example commands and options for selecting sound cards:

Note options: `-d device | device_alias` -- Please see `man aplay` and
`man alsaplayer` for an explanation of the options.

-   These two commands play the ogg on `card 0` -- the `ens1371` card:

` `

    alsaplayer -o alsa -d UA25  some_k00!.ogg
    alsaplayer -o alsa -d hw:0,0  some_k00!.ogg

How to choose a particular order for multiple installed cards
-------------------------------------------------------------

Which card is card number 0, 1 and so is by default determined by module
load order. This is particularly useful to choose which card becomes the
default one.

In theory therefore it is possible to choose which of several installed
cards becomes card 0, the default one, by ensuring its driver module is
loaded first. (Note: this assumes that each sound card requires a
different driver. If you have two soundcards of the same type, please
skip to the next section.)

There are two ways to achieve this, the "old" `index=` option of the
card driver module, and the alternative (and new) `slots=` option of the
snd module.

### The older "index=" method

An example configuration for two sound cards is like below:

    # ALSA portion
    options snd cards_limit=2
    alias snd-card-0 snd-interwave
    alias snd-card-1 snd-ens1371
    options snd-interwave index=0
    options snd-ens1371 index=1
    # OSS/Free portion
    alias sound-slot-0 snd-interwave
    alias sound-slot-1 snd-ens1371

### The newer "slots=" method

Alternatively, you can use the slot option instead of the index options:

    options snd slots=snd-interwave,snd-ens1371

Then, the first slot (\#0) is reserved for snd-interwave driver, and the
second (\#1) for snd-ens1371. You can omit index option in each driver
if slots option is used (although you can still have them at the same
time as long as they don't conflict).

According to
[ALSA-Configuration.txt](?title=ALSA-Configuration.txt&action=edit&redlink=1 "ALSA-Configuration.txt (page does not exist)"),
The `slots` option is especially useful for avoiding the possible
hot-plugging and the resultant slot conflict. For example, in the case
above again, the first two slots are already reserved. If any other
driver (e.g. snd-usb-audio) is loaded before snd-interwave or
snd-ens1371, it will be assigned to the third or later slot.

\

Ordering multiple cards of the same type
----------------------------------------

If you have more that one sound cards which use the same modules, you
may want to define the card order. This can be done by specifying index
and ID options to the module being loaded. For example,

    options snd-usb-audio index=1,2 vid=0x0ccd,0x0d8c pid=0x0028,0x000c

This will define 2 usb sound cards, the first one at index=1, vid=0x0ccd
and pid=0x0028; the second one at index=2, vid=0x0d8c and pid=0x000c.
The vid and pid here were discovered using `lsusb`.

The documentation may not be entirely up to date and comprehensive. The
command

    modinfo -p ${modulename}

shows a current list of all parameters of a loadable module.

Example:

    # modinfo -p snd-usb-audio
    ignore_ctl_error:Ignore errors from USB controller for mixer interfaces.
    device_setup:Specific device setup (if needed).
    async_unlink:Use async unlink mode.
    nrpacks:Max. number of packets per URB.
    pid:Product ID for the USB audio device.
    vid:Vendor ID for the USB audio device.
    enable:Enable USB audio adapter.
    id:ID string for the USB audio adapter.
    index:Index value for the USB audio adapter.

In this case, the pid and vid options from `lsusb` can be used. See
[MultipleUSBAudioDevices](/MultipleUSBAudioDevices "MultipleUSBAudioDevices")

But, consider this PCI device,

    # modinfo -p snd-ice1724
    model:Use the given board model.
    enable:Enable ICE1724 soundcard.
    id:ID string for ICE1724 soundcard.
    index:Index value for ICE1724 soundcard.

In this case, there is no option that can be used to define the sound
cards order for multiple ICE1724 sound card. I see no other way than
with a specific `udev` rule. See [Udev](/Udev "Udev").

\

Why doesn't this code work when using newer ALSA versions?
----------------------------------------------------------

The syntax for the module options has changed. Now you have to write all
options without the leading `snd_`. Example: only `index=0` instead of
`snd_index=0`.

Stephan Wurm

Some examples configurations
----------------------------

### Loading the kernel modules for multiple cards

[Frank Barknecht](http://footils.org/) offered this dual card
configuration example to the alsa-devel mailing-list.

See [TwoCardsAsOne](/TwoCardsAsOne "TwoCardsAsOne") for an idea for
setting up an [.asoundrc](/.asoundrc ".asoundrc") to use two cards
together. Read chapter below (a code fix).

` `

    # START
    alias char-major-116 snd
    alias char-major-14 soundcore
    options snd snd_major=116 snd_cards_limit=3 snd_device_mode=0660 snd_device_gid=29 snd_device_uid=0

    # Midiman
    alias sound-slot-0 snd-card-0
    alias sound-service-0-0 snd-mixer-oss
    alias sound-service-0-1 snd-seq-oss
    alias sound-service-0-3 snd-pcm-oss
    alias sound-service-0-8 snd-seq-oss
    alias sound-service-0-12 snd-pcm-osshree 

    # SBLive
    alias sound-slot-1 snd-card-1
    alias sound-service-1-0 snd-mixer-oss
    #alias sound-service-1-1 snd-seq-oss
    alias sound-service-1-3 snd-pcm-oss
    #alias sound-service-1-8 snd-seq-oss
    alias sound-service-1-12 snd-pcm-oss

    # VirMIDI
    alias sound-slot-2 snd-card-2
    #alias sound-service-2-1 snd-seq-oss
    #alias sound-service-2-8 snd-seq-oss

    #alias snd-card-0 snd-card-ice1712
    alias snd-card-0 snd-ice1712
    options snd-card-ice1712 snd_index=0 snd_enable

    #alias snd-card-1 snd-card-emu10k1
    alias snd-card-1 snd-emu10k1
    options snd-card-emu10k1 snd_enable

    #alias snd-card-2 snd-card-virmidi
    alias snd-card-2 snd-virmidi

    post-install snd-synth-emu10k1 /usr/bin/sfxload /dos/audio/sblive/SFBank/8mbgmsfx.sf2
    # END

### Multiple Sound Cards -- Example on Debian GNU/Linux

**RE: How do I use this?**

Lines such as found in the multiple sound card configuration example
from Frank Barknecht
[above](#Loading_the_kernel_modules_for_multiple_cards) must finally be
entered in a configuration file for modprobe
(`/lib/modules/modprobe.conf`, see `man modprobe.conf`) so the boot/init
process can use it. The process of building the configuration in
`modprobe.conf` differs somewhat from distribution to distribution and,
perhaps, also from the 2.4.\* to 2.6.\* kernels. With [Debian
GNU/Linux](http://www.debian.org/) *sid/unstable* and *kernel 2.6.4-rc2*
the component configurations to be included in `modprobe.conf` are found
in several files in `/etc/modprobe.d`:

` `

    jkern@boat:~$ ls -l /etc/modprobe.d
    total 20
    -rw-r--r--    1 root     root         5610 2004-01-30 18:04 aliases
    lrwxr-xr-x    1 root     root           22 2004-02-02 00:07 alsa -> /etc/alsa/modutils/1.0
    drwxr-xr-x    2 root     root         4096 2004-02-23 09:51 arch
    -rw-r--r--    1 root     root          363 2003-02-25 06:57 crypto
    -rw-r--r--    1 root     root           29 2003-12-20 17:15 nvidia-kernel-nkc

On this *Debian* system the `/etc/modprobe.d/alsa` is a symbolic link to
`/etc/alsa/modutils/1.0` wherein I have entered commands for two cards,
as adapted from Frank Barknecht's configuration
[above](#Loading_the_kernel_modules_for_multiple_cards):

` `

    jkern@boat:~$ cat /etc/alsa/modutils/1.0

    alias char-major-116 snd
    alias char-major-14 soundcore

    options snd major=116 cards_limit=4

    # Sound card 0 -- PCI adapter: ens1371 
    # /lib/modules/2.6.4-rc2/kernel/sound/pci/snd-ens1371.ko

    alias sound-service-0-0 snd-mixer-oss
    alias sound-service-0-1 snd-seq-oss
    alias sound-service-0-3 snd-pcm-oss
    alias sound-service-0-8 snd-seq-oss
    alias sound-service-0-12 snd-pcm-oss
    alias /dev/dsp0 snd-pcm-oss

    alias snd-card-0 snd-ens1371

    alias snd-slot-0 snd-card-0
    alias sound-slot-0 snd-slot-0

    # Sound card 1 -- VIA motherboard sound chip: via82xx
    # /lib/modules/2.6.4-rc2/kernel/sound/pci/snd-via82xx.ko

    alias sound-service-1-0 snd-mixer-oss
    alias sound-service-1-1 snd-seq-oss
    alias sound-service-1-3 snd-pcm-oss
    alias sound-service-1-8 snd-seq-oss
    alias sound-service-1-12 snd-pcm-oss
    alias /dev/dsp1 snd-pcm-oss

    alias snd-card-1 snd-via82xx

    alias snd-slot-1 snd-card-1
    alias sound-slot-1 snd-slot-1

    # End /etc/alsa/modutils/1.0

After editing `/etc/alsa/modutils/1.0`, I then run, on this *Debian*
system, `/sbin/update-modules`, which updates
`/lib/modules/modprobe.conf` to make it ready for the boot/init process.
Other *GNU/Linux* distributions probably have a similiar utility. The
aliases are merged with with all the others as specified in the files in
the `/etc/modprobe.d/` directory. (Please take a look at
`/lib/modules/modprobe.conf`.)

The kernel must be configured to build **ALSA modules and also the
modules for your specific sound cards**. In this example system the
specified modules for the two sound cards are thus:

` `

    jkern@boat:~$ grep -i "via82xx\|ens1371" /boot/config-2.6.4-rc2
    CONFIG_SND_ENS1371=m
    CONFIG_SND_VIA82XX=m

After the kernel is installed, these modules are found in
`/lib/modules/2.6.4-rc2/kernel/sound/pci/`:

` `

    jkern@boat:~$ ls /lib/modules/2.6.4-rc2/kernel/sound/pci/snd* 
    /lib/modules/2.6.4-rc2/kernel/sound/pci/snd-ens1371.ko
    /lib/modules/2.6.4-rc2/kernel/sound/pci/snd-via82xx.ko

One can see how these modules correspond to the aliases above in
`/etc/alsa/modutils/1.0`.

On a *Debian GNU/Linux* system the ALSA modules are all loaded from a
script, `/etc/init.d/alsa`, as part of the system initialization. Doing
a `lsmod` will show all the modules loaded on your system.

### RE: How do I select one card or the other?

Doing a `aplay -l` dislays a list of *PLAYBACK Hardware Devices*. A
`~/.asoundrc` is useful for (among other things) making handy aliases
for each sound card. A simple one could look like the following for this
system:

` `

    # Start ~/.asoundrc
    pcm.ens1371 { type  hw  card 0 }
    ctl.ens1371 { type  hw  card 0 }
    pcm.via82xx { type  hw  card 1 }
    ctl.via82xx { type  hw  card 1 }
    # End ~/.asoundrc

#### Example commands and options for selecting sound cards:

Note options: `-d device | device_alias` -- Please see `man aplay` and
`man alsaplayer` for an explanation of the options.

-   These two commands play the ogg on `card 0` -- the `ens1371` card:

` `

    alsaplayer -o alsa -d ens1371  some_k00!.ogg
    alsaplayer -o alsa -d hw:0,0  some_k00!.ogg

-   These commands play the sound files on `card 1` -- the `via82xx`
    card:

` `

    alsaplayer -o alsa -d via82xx  some_k00!.ogg
    alsaplayer -o alsa -d hw:1,0  some_k00!.ogg
    aplay -o alsa -Dplug:via82xx  very_r00d.wav

-   Mixer control commands:

` `

    /usr/bin/alsamixer -c 1     # will control card 1 -- the via82xx card.  
    /usr/bin/gamix              # or
    /usr/bin/gnome-alsamixer    # will provide separate mixer controls for each sound card.

-   Choosing card for SDL apps:

` `

    AUDIODEV="via82xx" mySDLapp

**These capabilities are the results of the configurations found in
`/lib/modules/modprobe.conf` and `~/.asoundrc`.**

As an alternative `modprobe.conf` configuration method, the shell
script, `/usr/sbin/alsaconf` (`man alsaconf`), may or may not work on
your system. If it does, it probably saves a bit of work; otherwise, you
now know what to do instead. `alsaconf` strives to be able to set up
sound cards for ALSA on all the varieties of GNU/Linux distributions.

**N.B.** Please remember that several of the *specific examples* are for
a *Debian GNU/Linux sid/unstable* system with a *2.6.\* kernel*.
Counterparts to these scripts and configuration files should be found on
any *GNU/Linux* distribution.

### Multiple USB Audio Devices

See also:
[MultipleUSBAudioDevices](/MultipleUSBAudioDevices "MultipleUSBAudioDevices")
and [Udev](/Udev "Udev")

I am using Debian SID and found a very simple solution: I edited the
etc/modules document in which the admin can load Modules on boot. First
entry is the card you want to be the card 0 and second the Modules for
the second card, so you can set the module load order. That's it.

-   I am not sure if that is true, because dependencies are calculated
    and system COULD still load modules in wrong order. However, in
    etc/modules it is also possible to add parameters, so you could
    append "index=n" to a module name.

### I have all my stuff statically compiled into the kernel

*I have all my stuff statically compiled into the kernel, so is there a
way to change the order of my cards without using modules?*

I found this in mailing list. This was put in linux boot row (in boot
loader config file). I do not test this. This should setup via8233 as
firs and midi port as second soundcard.

` `

    snd-via82xx.index=0 snd-mpu401.index=1 snd-mpu401.port=0x330 snd-mpu401.irq=10

**Answer:**

OK, thanks, this was easy. For the sake of completeness, here's the
relevant part of my menu.lst (grub config file)

` `

    title           Debian kernel 2.6.14.3
    root            (hd0,0)
    kernel          /boot/vmlinuz-2.6.14.3 root=/dev/hda1 ro snd-emu10k1.index=0 snd-intel8x0.index=1
    savedefault
    boot

I have two cards, a Creative SBLive 5.1 (snd-emu10k1) and a onboard
Intel AC97 (snd-intel8x0). With this, the SBLive becomes card0 and the
AC97 card1.

For GRUB 2 the command line needs to be included in /etc/default/grub
(root privilidges are needed to edit this file). For a Samsung NC10 the
following line works:

` `

    GRUB_CMDLINE_LINUX="vga=ext snd-hda-intel.index=0 snd-hda-intel.model=samsung-nc10 snd-virmidi.index=1"

Then run update-grub. The syntax seems to be important, note the full
stops.

### Easy way to do this on Ubuntu Dapper

1.  run `sudo nano -w /etc/modprobe.d/alsa-base` to edit your alsa
    config, from a terminal.
2.  change the the appropriate `sound-slot-[x] modprobe snd-card-[y]` to
    match your desired order. i.e. if card 0 and card 1 are in reverse
    order from what you would like, make the following edit:

` `

    install sound-slot-0 modprobe snd-card-1
    install sound-slot-1 modprobe snd-card-0

### Easy way to do this on Ubuntu Edgy

Since the above advice for Ubuntu Dapper didn't work for me this is what
I did:

1.  run `sudo nano -w /etc/modprobe.d/alsa-base` to edit your alsa
    config, from a terminal.
2.  then I added the following at the end of the file and left the rest
    intact:

` `

    options snd-intel8x0 index=-2
    options snd-cs46xx index=-1

Which made the Hercules Fortissimo II (snd-[cs46xx](/Cs46xx "Cs46xx"))
the default sound adapter and also made the onboard NFORCE2
(snd-[intel8x0](/Intel8x0 "Intel8x0")) the secondary sound adapter.

### I have a m-audio keystation connected via usb, and it hogs

**Question:**

I have a m-audio keystation connected via usb, and it hogs, if connected
while drivers are loaded via modprobe.conf, card0 regardless of how the
index is configured... which isn't bad by itself as `aconnect -i` only
displays

` `

    client 16: 'USB Keystation 61es' [type=kernel]
        0 'USB Keystation 61es MIDI 1'

if it's card0. This seems to be a "known" problem... at least I read it
somewhere.

The problem I'm facing is that if the keyboard isn't plugged while
drivers are loaded, my soundcard switches from card1 to card0, rendering
all configuration obsolete.

gentoo `modules.conf`:

` `

    alias snd-card-0 snd-usb-audio
    alias snd-card-1 snd-via82xx
    alias sound-slot-0 snd-card-0
    alias sound-slot-1 snd-card-1

     options snd-via82xx snd_index=1

`snd_index=1` or `index=1` doesn't make a difference.

linux 2.6.17-gentoo-r4 (alsa 1.0.11rc4)

Suggestion: Try using `index=-2`, this should solve the problem.

See also
--------

-   [Hotplugging USB audio devices
    (Howto)](/Hotplugging_USB_audio_devices_(Howto) "Hotplugging USB audio devices (Howto)")
-   [Udev](/Udev "Udev")
-   [MultipleUSBAudioDevices](/MultipleUSBAudioDevices "MultipleUSBAudioDevices")

Retrieved from
"[http://alsa.opensrc.org/MultipleCards](http://alsa.opensrc.org/MultipleCards)"

[Categories](/Special:Categories "Special:Categories"):
[Howto](/Category:Howto "Category:Howto") |
[Configuration](/Category:Configuration "Category:Configuration")

