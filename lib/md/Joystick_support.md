Joystick support
================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Contents
--------

-   [1 Howto](#Howto)
    -   [1.1 About Joysticks](#About_Joysticks)
    -   [1.2 How can I enable game port support in
        ALSA?](#How_can_I_enable_game_port_support_in_ALSA.3F)
    -   [1.3 Troubleshooting](#Troubleshooting)

-   [2 Discussion](#Discussion)
    -   [2.1 snd-ens1370 vs. ns558](#snd-ens1370_vs._ns558)
    -   [2.2 via82xx onboard gameport](#via82xx_onboard_gameport)
    -   [2.3 Ens1370 soundcard and
        alsactl](#Ens1370_soundcard_and_alsactl)
    -   [2.4 Centos4](#Centos4)

Howto
=====

About Joysticks
---------------

Most older joysticks come with a so-called game port connector (15 pins
SUB-D) and can be connected with the game port of the sound card.

Newer joysticks typically use USB and therefore do not need any
ALSA/soundcard support.

How can I enable game port support in ALSA?
-------------------------------------------

Make sure the kernel module handling your sound card has game port
support enabled. Many modules disable the game port by default. See
/usr/src/Documentation/sound/alsa/Joystick.txt for a list of options.
*lsmod*/*modinfo* might also help.

Make sure the joystick is plugged in when loading the modules as some
modules disable the game port if they do not find a joystick connected.

Technically, game port functionality is implemented by the *gameport*
kernel module (which the sound card module depends on). Then, there are
modules for each type of joystick (e.g., *analog*/*sidewinder*/...). The
/dev/input/jsX device is backed by the *joydev* kernel module.

For old ISA sound cards, you need the *ns558* module instead of
*gameport*.

Module options typically go into /etc/modutils/ for Linux 2.4.x (run
*update-modules* afterwards to generate modules.conf, syntax see *man
modules.conf*) or /etc/modprobe.d/ for Linux 2.6.x (see *man
modprobe.d*). Make sure you're not changing obsolete configuration files
that are not used by modprobe anyways. Test using *modprobe -vn MODULE*
(when the respective module is not loaded).

ALSA supported enabling/disabling the game port using the ALSA control
API (i.e., *alsactl*) in the past. However, for Linux 2.6.7 and newer,
only static initialization using module parameters is supported.

For special setups (e.g., two two-axis joysticks on one game port using
a Y cable) see parameters of your joystick module (e.g., *analog*).

Troubleshooting
---------------

-   test joysticks using *jstest /dev/input/js0*
-   make sure all needed kernel modules are loaded
-   make sure game port support is enabled in sound card module (e.g.,
    for es1370/1371 cards, this can be seen using *cat
    /proc/asound/AudioPCI/audiopci*)

Discussion
==========

snd-ens1370 vs. ns558
---------------------

This doesn't seem to do the trick. I am using the `ens-1370` module and
`devfs`. When I do `insmod joydev` and `insmod analog js=gameport` I
don't get a `js0` anywhere in `/dev`. What else needs to be done?

You need to load the module `ns558`:

` `

    modprobe ns558
    modprobe gameport
    modprobe sidewinder

The `modprobe sidewinder` is for my MS SW gamepad; change it to the
correct module for your own joystick/gamepad. From `/var/log/syslog`,
you will get something like:

` `

    Oct 28 23:56:05 void kernel: gameport0: NS558 ISA at 0x200 size 8 speed 1065 kHz
    Oct 28 23:56:34 void kernel: input1: Microsoft SideWinder GamePad on gameport0.0

I just spent several hours figuring out that you need to have a joystick
connected, for `ns558` to positively identify the port. `ns558` does
some magic to identify the I/O address, which relies on a joystick being
connected. Check out the source code. If you think that is obvious, it
isn't if you want to use the gameport to read a few bits from external
hardware (which may or may not be connected). If you are just interested
in the button lines, you can connect some resistors between the lines
for the pots and +5V. There is some good information
[here](http://www.epanorama.net/documents/joystick/pc_circuits.html).
Something else that is confusing is that there are lots of documents out
there on the web that talk about `es1371`, as opposed to `snd-ens1371`.
Before you go crazy, make sure that you are really looking at the
relevant module, not something vaguely related from a previous
incarnation of the kernel, like I did for a while.

[User:1370](?title=User:1370&action=edit&redlink=1 "User:1370 (page does not exist)"):
I use *snd-ens1370* with *gameport* but no *ns558* on Linux 2.6.19.
AFAIK *es1370*/*es1371* is OSS, not ALSA. Avoid that driver.

`via82xx` onboard gameport
--------------------------

For the `via82xx` onboard gameport (might be relevant to other hw):

-   Use the option `joystick=1` to the `via82xx` driver in your kernel
    modules config file (example:
    `options snd-via82xx index=0 mpu_port=0x330 joystick=1`) NOTE: This
    option became available in ALSA 1.0.x, it is therefore missing in
    the current Linux-2.6.2 kernel, which still includes ALSA 0.9.7.

Now you only have to modprobe the driver for the actual joystick/pad (in
my case `grip` for a Gravis GamePad Pro). The gameport driver
(`gameport.[k]o`) seems to get automatically loaded with the `via82xx`
driver.

Ens1370 soundcard and alsactl
-----------------------------

I had the joystick working fine in kernel 2.4.19 and 2.6.0 using alsa
and an ens1370 soundcard. Joystick support was broken when I upgraded to
2.6.7, 2.6.8 and 2.6.10. Deleting `/var/lib/asound.state` and running
"alsactl store 0" to create a new `/var/lib/asound.state` would, with
kernels 2.4.19 and 2.6.0, create an asound.state with a control.1 entry
for the joystick. I could then edit this control and run "alsactl
restore 0" to turn the joystick on or off. With kernels 2.6.7 and later
the joystick option was missing. It appears that editing "asound.state"
to enable/disable the joystick is no longer an option with the latest
kernels.

To get the joystick working in kernel 2.6.10 (Debian) I had to do the
following:

​1. I compiled a kernel with the gameport module compiled in. The
ens1370 module (and other alsa modules with joystick support) require
the gameport module to be either compiled in or as a module, otherwise
they don't compile with joystick support. To be safe I built it into the
kernel. I didn't try building gameport as a module, but this might work
as well. YMMV.

​2. Edit `/etc/alsa/modutils/1.0` such that it had the following two
lines: This causes the command `cat /proc/asound/card0/audiopci` (in my
case, with the ens1370 card) to show that the joystick is enabled,
provided that step 3 is added to ensure that the modules are loaded in
the correct order:

` `

    alias snd-card-0 snd-ens1370
    options snd-ens1370 joystick=1

​3. /etc/modutils/joystick should be as follows: (Note: the line
"pre-install snd-ens1370 modprobe analog" may not be necessary.)

` `

    alias char-major-13 analog
    pre-install snd-ens1370 modprobe analog
    pre-install analog modprobe joydev

​4. The file "/etc/modules" should have the following lines (among any
other modules you want installed):

` `

    joydev
    analog

​5. Run "update-modules" to update "/etc/modules.conf".

Note: For kernel 2.6.7 and later the module ns558 (or any other than
analog and joydev) is not required if you're using one of the soundcards
that has joystick support built-in (at least this is the case with the
ens1370). See the kernel config for details. In my case, the driver
configured itself as /dev/input/js0. If you were previously using
/dev/js0 or /dev/js this will need to be changed. **Note:** For me, the
joystick worked in 2.4.19 and 2.6.0. In 2.6.7 and later it was broken
(until the preceding steps fixed it). I don't know what the situation is
in the kernel versions between 2.6.0 and 2.6.7.

[User:1370](?title=User:1370&action=edit&redlink=1 "User:1370 (page does not exist)"):
ALSA kernel docs (joystick.txt) say that alsactl/asound.state
functionality for enabling/disabling gameports was dropped quite a while
ago. BTW /etc/modutils is Linux 2.4.x, use /etc/modprobe.d/ for Linux
2.6.x.

Centos4
-------

I finally got this to work on centos4. Took all day.

1.  Recompile your kernel to turn on analog.ko and gameport.ko
2.  With 1370 it's joystick=1 with 1371 it's joystick\_port=1
3.  There is a several second delay between the module loading and js0
    showing up. If you modprobe then ls /dev/input too fast you won't
    see it there yet.
4.  It's very very very picky.
5.  I had to completely disable my onboard via82xx sound, in the CMOS
    and in modprobe.conf.
6.  alias snd-card-0 snd-ens1371, then options snd-card-0
    joystick(\_port)=1 didn't seem to work, not sure. I made it
    explicit.
7.  gameport can be a module.
8.  Did I mention this whole thing is very flaky?

Working modprobe.conf for 1370/1371 is below, for 1370 just change all
references and also joystick\_port becomes joystick:

` `

    alias snd-card-0 snd-ens1371
    alias char-major-13 analog
    options snd-ens1371 joystick_port=1
    install snd-ens1371 /sbin/modprobe -i joydev; \
     /sbin/modprobe -i analog; \
     /sbin/modprobe --ignore-install snd-ens1371; \
     /usr/sbin/alsactl restore;
    remove snd-ens1371 { /usr/sbin/alsactl store >/dev/null 2>&1 || : ; }; \
     /sbin/modprobe -r --ignore-remove snd-ens1371

Retrieved from
"[http://alsa.opensrc.org/Joystick\_support](http://alsa.opensrc.org/Joystick_support)"

[Categories](/Special:Categories "Special:Categories"):
[Howto](/Category:Howto "Category:Howto") |
[Configuration](/Category:Configuration "Category:Configuration")

