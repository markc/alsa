AlsaTips
========

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

ALSA is a new digital sound architecture for linux and is meant to
replace the OSS modules. It is now shipped with the 2.6.x kernel series.
First, here are some related pages.

-   [Getting oss emulation to work with 2 Sound
    cards](/Getting_oss_emulation_to_work_with_2_Sound_cards "Getting oss emulation to work with 2 Sound cards")
-   [Mapping oss mixer controls to alsa
    mixer](/Mapping_oss_mixer_controls_to_alsa_mixer "Mapping oss mixer controls to alsa mixer")
-   [Plugin Documentation](/Plugin_Documentation "Plugin Documentation")
-   [CompilingTips](/CompilingTips "CompilingTips")
-   [NoOssEmulation](/NoOssEmulation "NoOssEmulation") - if you decide
    not to install OSSLite emulation
-   [Record from mic](/Record_from_mic "Record from mic")

Contents
--------

-   [1 Alsa layers](#Alsa_layers)
-   [2 Getting ALSA to start at system boot with Red Hat
    7.3](#Getting_ALSA_to_start_at_system_boot_with_Red_Hat_7.3)
-   [3 Using the second OSS playback channel on some
    cards](#Using_the_second_OSS_playback_channel_on_some_cards)
-   [4 Using two cards as one](#Using_two_cards_as_one)
-   [5 Order of Installation](#Order_of_Installation)
-   [6 Unresolved Symbols](#Unresolved_Symbols)
-   [7 The .asoundrc file](#The_.asoundrc_file)
-   [8 Change of module directory
    tree](#Change_of_module_directory_tree)
-   [9 Some Sample devfsd.conf
    Entries](#Some_Sample_devfsd.conf_Entries)
-   [10 Some notes on dealing with /dev from Takashi
    (1)](#Some_notes_on_dealing_with_.2Fdev_from_Takashi_.281.29)
-   [11 Some notes on dealing with /proc from Takashi
    (2)](#Some_notes_on_dealing_with_.2Fproc_from_Takashi_.282.29)
-   [12 Device files under
    /proc/asound/dev](#Device_files_under_.2Fproc.2Fasound.2Fdev)
-   [13 Ínfo about OSS emulation](#.C3.8Dnfo_about_OSS_emulation)
-   [14 Card-specific proc files](#Card-specific_proc_files)
-   [15 Compile ALSA modules as a debian
    package](#Compile_ALSA_modules_as_a_debian_package)
-   [16 Share a single card with multiple
    applications](#Share_a_single_card_with_multiple_applications)
-   [17 Removing all ALSA modules](#Removing_all_ALSA_modules)
-   [18 A note for those running
    RedHat](#A_note_for_those_running_RedHat)
-   [19 How to set a certain output as default playback
    device](#How_to_set_a_certain_output_as_default_playback_device)
-   [20 Selecting a device for OSS emu](#Selecting_a_device_for_OSS_emu)
-   [21 Enabling 5+1 outputs on cards with line-out, mic-in and line-in
    jacks](#Enabling_5.2B1_outputs_on_cards_with_line-out.2C_mic-in_and_line-in_jacks)
-   [22 Enabling single output outputs on cards with line-out,mic-in and
    line-in
    jacks](#Enabling_single_output_outputs_on_cards_with_line-out.2Cmic-in_and_line-in_jacks)
-   [23 Tips to Enable Recording](#Tips_to_Enable_Recording)
-   [24 Fighting disturbed sound](#Fighting_disturbed_sound)

Alsa layers
-----------

Alsa consists of several layers:

1.  **The kernel modules** - the kernel modules provide the basic
    infrastructure of Alsa and the hardware drivers. Programs have the
    ability to talk directly to the alsa kernel modules. This is
    discouraged though, since [alsa-lib](/Alsa-lib "Alsa-lib") makes
    life a whole lot easier for the app developer (and for the user).
    Alsa provides an OSS emulation layer to keep legacy OSS apps
    working. Two different mechanisms are available for that. The OSS
    compatibility modules ([OSSEmulation](/OSSEmulation "OSSEmulation"))
    and the [aoss](/Aoss "Aoss") script from the alsa-oss package. All
    alsa modules start with a prefix of either "snd-" or "snd\_". The
    ALSA kernel modules provide a rich interface via /proc/asound
2.  [alsa-lib](/Alsa-lib "Alsa-lib") - is a userspace library that
    provides a level of abstraction over the kernel modules. For audio
    devices there's the "pcm" and "ctl" abstractions. For midi, the
    "seq" interface is avaliable. See the
    [alsa-lib](/Alsa-lib "Alsa-lib") docs for more details.
    -   pcm: the pcm interface is very flexible and allows the
        definition of virtual and hardware devices via a relatively easy
        to understand configuration file (\~/.asoundrc,
        /usr/share/alsa/alsa.conf). You can for example use plugis as
        pcm devices. One notable plugin is the
        [DmixPlugin](/DmixPlugin "DmixPlugin") plugin that makes
        software mixing available to soundcards without hardware mixing.
        This means you can play multiple audio streams with a soundcard
        that doesn't usually allow that. And it is transparent for the
        Application as long as it uses alsa-lib [or even for OSS apps].
        See this wiki for more docs on the [dmix](/Dmix "Dmix") and ther
        plugins and for documentation on how to edit the
        [.asoundrc](/.asoundrc ".asoundrc")..
    -   ctl: this is the control interface which is used to adjust
        volumes and other control functions the soundcard offers. Use
        the program alsamixer to see what you can adjust in your
        soundcard
    -   seq: the seq interface is used for midi applications. Its design
        makes stuff like Hubi's Loopback device unnecessary since it is
        easily possible to connect alsa seq clients to each other using
        tools like [aconnect](/Aconnect "Aconnect") or "aconnectgui" or
        "alsa-patch-bay"

3.  **user space programs** - there's some user space programs provided
    like the aforementioned [aconnect](/Aconnect "Aconnect"). An
    incomplete List [please fill missing in]:
    -   [aplay](/Aplay "Aplay") - playback sounds to pcm devices
    -   [arecord](/Arecord "Arecord") - record sounds from pcm devices
        into wav files
    -   [alsamixer](/Alsamixer "Alsamixer") - the mixer program
    -   [aconnect](/Aconnect "Aconnect") - the midi connecter
    -   [aoss](/Aoss "Aoss") - a script t wrap OSS apps
    -   [alsactl](/Alsactl "Alsactl") - save/restore mixer state
    -   [amidi](/Amidi "Amidi") - a tool to write/read from raw midi
        ports..

So summing it up. ALSA is the superior sound architecture compared to
OSS. Lack of drivers is a problem though. But Linux is gaining momentum,
so maybe hardware producers start to be more generous on card
documentation. If you want to use serious Low-Latency recording with
Linux and ALSA, you need to patch your kernel with Low-Latency patches
and install
[jackd](?title=Jackd&action=edit&redlink=1 "Jackd (page does not exist)").
Then rock solid operation is very much possible. There's a cool
[jack](/Jack "Jack") hard disk recorder called
[ardour](/Ardour "Ardour"). There's several native alsa-sequencers like
[muse](/Muse "Muse") and [rosegarden](/Rosegarden "Rosegarden"). There's
all kinds of softsynths for [jack](/Jack "Jack") like SpiralModularSynth
and
[amSynth](?title=AmSynth&action=edit&redlink=1 "AmSynth (page does not exist)")...
Check the linux audio pages for more. Hope to have cleared up some
stuff. Feel free to modify improve and correct my little text here..

Getting ALSA to start at system boot with Red Hat 7.3
-----------------------------------------------------

After successfully installing ALSA, I was trying to get it to start
automatically at boot time, using '/etc/init.d/alsasound' service start
script (put there by the ALSA installation) but found I had 2 problems,
one was that the format of the sound modules in the ALSA HOWThs is
different from what the alsasound startup script expects, second that
grep -E was not working as (I) expected. For some reason it was not
correctly working with *\^* (start of line marker) in its regexp used to
match the ALSA lines in '/etc/modules.conf'. What I had to do was alter
one line in the alsasound script to fix both problems.

Here is the line as it was ` `

       grep -E "^space:*aliasspace:+snd-card-digit:" | \

and as it is now ` `

       grep -E "alnum:*space:+snd-card-digit:$" | \

And here is my '/etc/module.conf' (ALSA portion, my sound card is an ESS
SOLO1 which uses the snd-es1938 module) ` `

       # ALSA setup of ESS SOLO-1
       alias char-major-116 snd
       alias snd-card-0 snd-es1938
       # OSS/Free setup
       alias char-major-14 soundcore
       alias sound-slot-0 snd-card-0
       alias sound-service-0-0 snd-mixer-oss
       alias sound-service-0-1 snd-seq-oss
       alias sound-service-0-3 snd-pcm-oss
       alias sound-service-0-12 snd-pcm-oss

Using the second OSS playback channel on some cards
---------------------------------------------------

Some cards (es1370, es1371, etc) have a second pcm playback device that
the OSS drivers traditionally access as /dev/dsp1 (major 14, minor 19).
With ALSA this second pcm output is accessable with oss compatability
enabled as /dev/adsp (major 14, minor 12). This device is very useful to
get a nonblocking artsd or esd sound daemon. Many distros will not
create the /dev/adsp device for you so you will have to execute "cd
/dev; mknod adsp c 14 12". If you are using devfs this device will be
automaticaly created by devfsd.

Using two cards as one
----------------------

JoernNettingsmeier posted an [.asoundrc](/.asoundrc ".asoundrc") to
linux-audio-users to use [two cards as
one](/TwoCardsAsOne "TwoCardsAsOne").

Order of Installation
---------------------

First install alsa-driver. After that alsa-library and finally the other
packages. Detailed installation instruction can be found in the INSTALL
file (included in each package). See [Quick
Install](/Quick_Install "Quick Install").

Unresolved Symbols
------------------

Patrick Shirkey has collected some information about fixing [Unresolved
Symbols](/Unresolved_Symbols "Unresolved Symbols")

The [.asoundrc](/.asoundrc ".asoundrc") file
--------------------------------------------

The [.asoundrc](/.asoundrc ".asoundrc") file allows more sophisticated
control over your audio card and some very useful applications will not
work at all without it. A system wide version can be installed as
/etc/asound.conf and a more specific version stored in your home
directory as \$HOME/.asoundrc. Until now, it has been a bit of a black
art getting the details correct.

**A brief example**

Put the following in a file in your home directory named
[.asoundrc](/.asoundrc ".asoundrc"):

` `

       pcm.myfirstcard {
           type hw
           card 0
       }    
       pcm.!default myfirstcard

Change of module directory tree
-------------------------------

*2002-02-26*

From Dave Andruczyk: For those not so well versed in ALSA if you install
0.9beta 11 over a previous release, make sure you DELETE the
/lib/modules/YOUR\_KERNEL/misc/snd\* modules. The beta 11 version
reorganizes the ALSA kernel drivers in a much better and cleaner format,
under /lib/modules/YOUR\_KERNEL/kernel/sound/ ALSO (I didn't check the
docs), but if your module was "snd-card-xxxxx" its now snd-xxxxx. Thus
the older snd-card-emu10k1, is now snd-emu10k1. So edit your
/etc/modules.conf as appropriate and things should be just fine. Make
sure to run "depmod -a" after modifying /etc/modules.conf, or after
deleting/adding kernel modules to your modules tree under
/lib/modules/YOUR\_KERNEL Aside from that beta 11 works wonderfully on
my box (Mandrake 8.1).

Some Sample *devfsd.conf* Entries
---------------------------------

For those of you who use ALSA on the 2.4 kernel, you may also use devfs,
which is a dynamic device filesystem which allows for the creation of
device entries on the fly. However, this can cause problems when moving
from OSS to ALSA on a 2.4 devfs system. Here are some example entries
which may help (these come from my own setup):

` `

       REGISTER  snd/.*  PERMISSIONS root.games 666
       REGISTER  sound/.* PERMISSIONS root.games 666
       LOOKUP    sound/audio EXECUTE mknod -m 666 sound/audio c 14 4
       LOOKUP    sound/dsp EXECUTE mknod -m 666 sound/dsp c 14 3
       LOOKUP    dsp  EXECUTE mknod -m 666 dsp c 14 3
       REGISTER  sound/mixer MKOLDCOMPAT

Some notes on dealing with /dev from Takashi (1)
------------------------------------------------

If you use devfs interface for /dev, you cannot use the 2nd or later
card with the original sound\_core.c on 2.4 kernel. if you use proc
interface for /dev/snd, it works anyway. You can have multiple soundcard
with devfs using a patched sound\_core.c:

` `

       patch /usr/src/linux/drivers/sound_core <  wget -q -O - \  http://hypermail.idiosynkrasia.net/linux-kernel/archived/2001/week50/att-0144/01-sound_core.c.dif 

also if you build the kernel without devfs support and use 2nd or later
cards, then you'll get annoying error messages, even if you use proc
interface. (it's harmless, though.)

*Incorrect advice... should have been "chmod 666 /dev/snd/\*". And to
compliment this insecure setting the directory itself needs to be "chmod
755 /dev/snd".*

This may not work because often, on a non-devfs enabled system, /dev/snd
is symlinked to /proc/asound/dev where the permission cannot be manually
modified. The most reliable way to change the owner/permission is to
pass a proper module option to snd.o when ALSA starts up in
/etc/modules.conf with a line similar to...

` `

       options snd snd_major=116 snd_cards_limit=4 \
       snd_device_mode=0660 snd_device_gid=29 snd_device_uid=0

Some notes on dealing with /proc from Takashi (2)
-------------------------------------------------

Writing a proc file is really easy. you can simply copy the code from
one of the driver. But the proc info, such as usb descriptor dump, is
hardware (driver) dependent. It's up to the driver author. so I cannot
summarize the "general" usage for such files. Ok, let me comment major
proc files... ` `

       /proc/asound/cards (RO)
        the list of registered cards
       
       /proc/asound/version (RO)
        the version and date the driver was built
       
       /proc/asound/devices (RO)
        the list of registered ALSA devices (major=116)
       
       /proc/asound/hwdep (RO)
        the list of hwdep (hardware dependent) controls
       
       /proc/asound/meminfo (RO)
        memory usage information
               this proc file appears only when you build the alsa drivers
               with memory debug (or full) option so the file shows the
               currently allocated memories on kernel space.
       
       /proc/asound/pcm (RO)
        the list of allocated pcm streams
       
       /proc/asound/dev
        the directory containing device files.  device files
        are created dynamically.
        in the case without devfs, this directory is usually
        linked to /dev/snd
       
       /proc/asound/oss
        the directory containing info about oss emulation
       
       /proc/asound/seq
        the directory containing info about sequencer
       
       /proc/asound/cardX (X = 0-7)
        the card-specific directory

Device files under /proc/asound/dev
-----------------------------------

Generally the file is named as aaaCxDy, where aaa is the service name, x
the card number (0-7) and y the device number (0-). ` `

       controlC?  control devices (i.e. mixer, etc.)
       hwC?D?     hwdep devices
       midiC?D?   rawmidi devices
       pcmC?D?p   pcm playback devices
       pcmC?D?c   pcm capture devices
       seq        sequencer device
       timer      timer device

Ínfo about OSS emulation
------------------------

The contents of the files under this directory are changed dynamically.
when no oss emulation modules (snd-pcm-oss, snd-mixer-oss) are loaded,
no pcm nor mixer devices will be listed. ` `

       /proc/asound/oss/devices (RO)
        the list of devices already registered
       
       /proc/asound/oss/sndstat (RO)
        /dev/sndstat compatible list

Card-specific proc files
------------------------

` `

       id (RO)
        the id string of the card
       
       ac97#? (RO)
        AC97 codec information
       
       ac97#?regs (RO)
        (printable) register dump
       
       midi? (RO)
        the current status of input/output on the
        rawmidi device
       
       pcm?p
        the directory status of the given pcm playback stream
       pcm?c
        the directory status of the given pcm capture stream

**PCM stream information**

` `

       pcm??/info (RO)
        the pcm stream general info (card, device, name, etc.)
       
       pcm??/oss (RO)
        oss emulation info (shown only when the pcm is opened
        as an oss device).
       
       pcm??/sub?
        the substream information directory
       
       pcm??/sub?/info (RO)
        the pcm substream general info (card, device, name, etc.)
       
       pcm??/sub?/status (RO)
        the current status of the given pcm substream
        (status, position, delay, tick time, etc.)
       
       pcm??/sub?/hw_params (RO)
        hw_params set-up on the substream
        (buffer size, format, etc.)
       
       pcm??/sub?/sw_params (RO)
        sw_params set-up on the substream
        (threshold, etc.)
       
       pcm??/sub?/prealloc (RW)
        the number of pre-allocated buffer size in kb.
        you can specify the buffer size by writing to this proc file:
       
       # echo 128 > /proc/asound/card0/pcm0p/sub0/prealloc
       
        to allocate 128kbyte for playback, substream #0, stream #0
        on the card #0.

To find all the options for the alsa modules on your machine run this
script...

` `

       modinfo $(modprobe -l snd-*) | cat > ~/modinfo

**2002-08-15**

snd\_\* settings for the OPL3-SA in the Toshiba SP490XCDT and similar.
Look up the current sound settings in the BIOS setup:

-   Press ESC then F1 during boot,
-   Press PgDn for the second page
-   Write down the sound settings (Description in YaST, option name):
    -   WSS I/O Address (WSS port \# for OPL3-SA driver, snd\_wss\_port)
    -   SBPro I/O Address (Soundblaser port \# for OPL3-SA driver,
        snd\_sb\_port)
    -   Synthesiser I/O Address (FM port \# for OPL3-SA driver,
        snd\_fm\_port)
    -   WSS & SBPro & MPU401 IRQ Level (IRQ \# for OPL3-SA driver,
        snd\_irq)
    -   WSS (play) DMA (1st DMA \# for OPL3-SA driver, snd\_dma1)
    -   WSS (rec.) & SBPro DMA (2nd DMA \# for OPL3-SA driver,
        snd\_dma2)
    -   Control I/O Address (Port \# for OPL3-SA driver, snd\_port)
    -   MPU-401 MIDI I/F (MIDI port \# for OPL3-SA driver,
        snd\_midi\_port)

-   Start Linux, YaST
-   Select Hardware \> Sound
-   Add new sound card
-   Next
-   Select Yamaha OPL3-SA, Tecra 8000, Toshiba
-   Next
-   Select Advanced setup with possibility to change options
-   Next
-   Fill in (or select from list) the BIOS values and press Set for each
-   Fill in 0 for "ISA PnP detection for Yamaha OPL3SA2+ soundcard,
    snd\_isapnp"
-   If the next pane is "Sound card volume" everything should work
    (Press "Test" to verify)
-   If the next pane is an error report, see the xconsole for the error.
    "modprobe: modprobe: Can't locate module snd-card-0" is the most
    common one. If you get "kernel: ALSA
    ../alsa-kernel/core/pcm\_native.c:1085: playback drain error (DMA or
    IRQ trouble?" you're close :-).

Compile ALSA modules as a debian package
----------------------------------------

Some notes on compiling ALSA modules [for
Debian](http://www.sonic.net/~rknop/linux/debian_alsa.html) (you may
need to do ./configure after unzipping ALSA), [another
example](http://www.d.kth.se/~d98-jas/debian/debian-install-alsa.txt)
and yet another howto on [the same
subject](http://www.linuxorbit.com/modules.php?op=modload&name=Sections&file=index&req=viewarticle&artid=541&page=1).

Share a single card with multiple applications
----------------------------------------------

NEWS FLASH! Jaroslav's dmix plugin comes to the rescue! See the
[DmixPlugin](/DmixPlugin "DmixPlugin") wiki page. Since ALSA 0.9.1 it
has been possible to use the dmix plugin to share a single device with
multiple applications. This was a puzzling omission from previous ALSA
releases, and a big thanks go out to Jaroslav for implementing this.
Please note that the 'share' plugin, as indicated in various places, is
useless for this task. The ALSA documentation includes an 'Unknown
Reference' to this software mixer ('smix', or 'pcm\_mix') plugin, and
should probably be updated with the information that this plugin is not
part of the current ALSA tree, and will not be without a lot of work.
This plugin has been replaced in functionality with 'dmix'

I will provide details on how to configure this plugin as part of the
'default' ALSA sound path when I figure out how to do it. Here's the
best documentation of dmix that exists at the moment:

-   [http://www.alsa-project.org/alsa-doc/alsa-lib/pcm\_plugins.html](http://www.alsa-project.org/alsa-doc/alsa-lib/pcm_plugins.html)
-   [http://www.alsa-project.org/alsa-doc/doc-php/asoundrc.php3\#softmix](http://www.alsa-project.org/alsa-doc/doc-php/asoundrc.php3#softmix)

This is how you set your card to use the dmix plugin by default: ` `

       pcm.!default {
           type plug
           slave.pcm "dmix:CARD=0,DEVICE=0,RATE=48000"
       }

Removing all ALSA modules
-------------------------

` `

       #!/bin/sh
       awk '/^snd/||/^sound/&&($3==0){system("rmmod " $1)}' /proc/modules /proc/modules /proc/modules

A note for those running RedHat
-------------------------------

Since RedHat doesn't use devfs, you will need to run ./snddevices during
install, no matter which version you are installing. The problem I was
having is that atempting to run alsamixer resulted in the error: ` `

       alsamixer: function snd_ctl_open failed for default: \
        No such file or directory

so if you're on another distro and having the above problem you may want
to give ./snddevices a try. And where do I find snddevices?
[http://cvs.sourceforge.net/viewcvs.py/\*checkout\*/alsa/alsa-driver/snddevices.in](http://cvs.sourceforge.net/viewcvs.py/*checkout*/alsa/alsa-driver/snddevices.in)

How to set a certain output as default playback device
------------------------------------------------------

Have alook at the output of *cat /proc/asound/devices*. ` `

         1:       : sequencer
         0: [0- 0]: ctl
         8: [0- 0]: raw midi
        18: [0- 2]: digital audio playback
        17: [0- 1]: digital audio playback
        16: [0- 0]: digital audio playback
        24: [0- 0]: digital audio capture
        33:       : timer

On my system there's 3 playback devices. If i want to make the third the
default i just add this line to my \~/.asoundrc [counting starts at 0]:

` `

       defaults.pcm.device 2

This selects hw:0,2 as the defaul pcm device.. I figure this might make
trouble when trying to record. But then jut use hw:0,0 as the capture
device [the setup of your software should allow that]. It works here.

Selecting a device for OSS emu
------------------------------

You have to override the definition of pcm.dsp0 and ctl.dsp0 like this
[\~/.asoundrc](/.asoundrc ".asoundrc") and then use the aoss script from
the alsa-oss package: ` `

       pcm.dsp0 {
           type hw
           card 0
           device 2
       }
       ctl.mixer0 {
           type hw
           card 0
       }

The above pcm definition makes the OSS emu use the 2nd device on the
first card [which is in my case the digital out]

Enabling 5+1 outputs on cards with line-out, mic-in and line-in jacks
---------------------------------------------------------------------

I thought this is the place where i can share this, if not please move
it! Ok to the point I have Realtek ALC655/AC'97 card on my gigabyte
mobo, the card has 3 stereo-jacks - out, mic-in and line-in. The problem
was that there is no app for making mic-in and line-in behave like
outputs (this card is 5+1 channels) so that I can plug 6 speakers.. i
made alot of asking and searching w/o an answer even on the ALSA list..
the solution was prety damn easy. I just had to use "\<" and "\>" for :

` `

       Mic As Center/LFE
       Line-In As Surround

instead of arrows, with which u normaly increase the volume... Below is
a description how to do this manualy with amixer (u may need this too to
include in scripts).. Ok here is it : ` `

       #amixer | grep -A 3 As

       Simple mixer control 'Line-In As Surround',0
        Capabilities: pswitch pswitch-joined
        Playback channels: Mono
        Mono: Playback [off]
       --
       Simple mixer control 'Mic As Center/LFE',0
        Capabilities: pswitch pswitch-joined
        Playback channels: Mono
        Mono: Playback [off]
        ------------------------------------------------------------------
        #amixer cset iface=MIXER,name='Line-In As Surround',index=0 95%
        numid=37,iface=MIXER,name='Line-In As Surround'
        ; type=BOOLEAN,access=rw---,values=1
        : values=on
        #amixer cset iface=MIXER,name='Mic As Center/LFE',index=0 95%
        numid=38,iface=MIXER,name='Mic As Center/LFE'
        ; type=BOOLEAN,access=rw---,values=1
        : values=on
       -------------------------------------------------------------------------------------------
       #amixer | grep -A 3 As
        Simple mixer control 'Line-In As Surround',0
        Capabilities: pswitch pswitch-joined
        Playback channels: Mono
        Mono: Playback [on]
       --
       Simple mixer control 'Mic As Center/LFE',0
        Capabilities: pswitch pswitch-joined
        Playback channels: Mono
        Mono: Playback [on]
        -----

Enabling single output outputs on cards with line-out,mic-in and line-in jacks
------------------------------------------------------------------------------

This is pretty much the reverse of the above post where you want a
single output (line-out) to have the full range out sound, not splitting
the sound across all the potential outputs. Useful if you only use your
machine with headphones.

Tips to Enable Recording
------------------------

Sometimes the alsamixer settings needed to control recording are not
obvious, and recording may not be working, recording noise or "snow."
Before complaining that the driver is broken (as I just about did), try
this sensible recipe from Kai Vehmanen, author of the excellent
[ecasound](/Ecasound "Ecasound") system. In one console, issue the
command:

` `

       arecord -r 48000 -c 1 | hexdump

In another console, issue the command:

` `

       alsamixer

In the first console, you should see bytes scrolling by. If they are
very repetitive, they are probably noise or something you don't want. In
the mixer window, change various mixer settings that are likely to
affect the recording. In my case, pressing the Insert key to toggle off
IEC958 capture was all I needed to get mic input working correctly.
Then, changing Capture volume fine-tuned the input. In the first console
window, I would press Ctrl-C and then arecord to a file, and then aplay
the result to hear what it sounded like.

Fighting disturbed sound
------------------------

OK so you get ALSA up and running, but the sound is disturbed. For
instance, playing mono 8bit sound is OK, but stereo is just messed up.
Or you always get some humming background noise. Leaving alone things
you can do with the driver itself (another parameters etc) here is what
you can try:

1.  check for shared interrupts for you sound card (cat
    /proc/interrupts). In the theory, it shouldn't matter whether a
    sound card shares an IRQ. In practice, it does. Check if you can
    give another IRQ via BIOS setup, or driver parameter
2.  if sound disturbance is somehow related to moving windows or cursor,
    look here [[1]](http://www.slinkp.com/LiLAQ/VideoCard) for
    explanation/possible cure
3.  Try another PCI slot (also helps against shared IRQ)
4.  Turn off "PCI burst" in BIOS, try to set PCI latency to higher
    values (i.e. to 64 from 32 etc)
5.  To minimise humming background noise, try another PCI slot. Use
    different outlets for PC and speakers. Check that both are properly
    grounded.
6.  Use PCI sound card instead of the on-board one.
7.  Recording with sox (often done through the provided "rec" utility)
    sometimes gives problem, try arecord (alsa-utils package) or brec
    (bplay package) instead.

Another thing you can try:

Reload the alsa sound modules. Attention: Most often the
/etc/init.d/alsa script won't do that. You have to use the script
alsasound which comes with the alsa packages in that case: Simply run
/etc/init.d/alsasound restart and in two cases (cmipci and cs46xx) it
worked for me. Try the very same if recording gives you distortions or
clippings (in my case SPDIF recording).

Retrieved from
"[http://alsa.opensrc.org/AlsaTips](http://alsa.opensrc.org/AlsaTips)"

[Category](/Special:Categories "Special:Categories"):
[Troubleshooting](/Category:Troubleshooting "Category:Troubleshooting")

