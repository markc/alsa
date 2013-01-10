TroubleShooting
===============

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Contents
--------

-   [1 Try playing sound](#Try_playing_sound)
-   [2 Troubleshooting ALSA Problems](#Troubleshooting_ALSA_Problems)
-   [3 Check that the ALSA drivers are compiled as
    modules](#Check_that_the_ALSA_drivers_are_compiled_as_modules)
-   [4 Check the ALSA driver version](#Check_the_ALSA_driver_version)
-   [5 Check the ALSA library version](#Check_the_ALSA_library_version)
-   [6 Check the sound drivers for your card are
    active](#Check_the_sound_drivers_for_your_card_are_active)
-   [7 Check that you have the right sound
    devices](#Check_that_you_have_the_right_sound_devices)
-   [8 Check that non-root users can access the sound device special
    files](#Check_that_non-root_users_can_access_the_sound_device_special_files)
-   [9 Check that the sound card mixer channels are
    unmuted](#Check_that_the_sound_card_mixer_channels_are_unmuted)
-   [10 The main channels are unmuted and non zero volume, but not
    sound](#The_main_channels_are_unmuted_and_non_zero_volume.2C_but_not_sound)
-   [11 Check whether your application uses OSS instead of
    ALSA](#Check_whether_your_application_uses_OSS_instead_of_ALSA)
-   [12 Sound can be heard but it is
    distorted](#Sound_can_be_heard_but_it_is_distorted)
-   [13 Compile problem when doing make with alsa-lib with kernel
    2.6.7](#Compile_problem_when_doing_make_with_alsa-lib_with_kernel_2.6.7)
-   [14 When loading modules, it complains of unknown
    symbols.](#When_loading_modules.2C_it_complains_of_unknown_symbols.)
-   [15 Kernel modules load correctly but you get error: Inappropriate
    ioctl for
    device](#Kernel_modules_load_correctly_but_you_get_error:_Inappropriate_ioctl_for_device)
-   [16 Kernel-2.6.17.8 and VT82C686 AC97: "No such
    device"](#Kernel-2.6.17.8_and_VT82C686_AC97:_.22No_such_device.22)
-   [17 alsamixer: function snd\_ctl\_open failed for default: No such
    device](#alsamixer:_function_snd_ctl_open_failed_for_default:_No_such_device)
-   [18 hda-intel: no codecs found!](#hda-intel:_no_codecs_found.21)

Try playing sound
-----------------

This troubleshooting is for ALSA problems. Many other software layers
can be involved in Linux audio. Enter the aplay command in a terminal
with `-vv` (extra-verbose) options to play a .wav file through ALSA.
Your computer may have sample files in /usr/share/sound.

     aplay -vv /path/to/file.wav

If that produces sound then your sound problems may lie in another
package or software layer.

If aplay doesn't produce sound, then use `aplay -L` to list all
soundcards and digital audio devices. If this lists other devices, you
can try playing sound through each in turn using its full name using
aplay's -D option (for example
`aplay -vv -D front:CARD=Audigy2,DEV=0 /path/to/file.wav`).

Another useful command-line utility in the alsa-utils package is
speaker-test. The command

     speaker-test -c 2 -t wav

will play sound through each of two channels (normally front left and
front right) in turn.

Troubleshooting ALSA Problems
-----------------------------

An important first step: compile the relevant information using
[aadebug](/Aadebug "Aadebug"). Also have a look at [FAQ](/FAQ "FAQ"),
[ALSA modules](/ALSA_modules "ALSA modules") and [Sound
cards](/Sound_cards "Sound cards") for troubleshooting your specific
module or soundcard. [AlsaTips](/AlsaTips "AlsaTips") might have useful
stuff too. [ALSA TroubleShooting PDF by
Takashi](http://www.linuxdj.com/audio/lad/contrib/zkm_meeting_2004/slides/thursday/takashi_iwai-alsa_troubleshooting.pdf)
is an offsite troubleshooting presentation given by one of the core alsa
developers.

There are 2 common user-based mailing-lists:

-   [LAU](http://music.columbia.edu/mailman/listinfo/linux-audio-user) -
    ([archive](http://music.columbia.edu/pipermail/linux-audio-user/)) -
    Linux Audio User for general linux audio
-   [alsa-user](http://lists.sourceforge.net/lists/listinfo/alsa-user) -
    ([archive](http://sourceforge.net/mailarchive/forum.php?forum_id=1751))
    - for ALSA specific audio issues

and 2 important developer mailing lists:

-   [LAD](http://music.columbia.edu/mailman/listinfo/linux-audio-dev) -
    ([archive)](http://music.columbia.edu/pipermail/linux-audio-dev/) -
    Linux Audio Development - general development
-   [alsa-devel](http://lists.sourceforge.net/lists/listinfo/alsa-devel)
    -
    ([archive](http://sourceforge.net/mailarchive/forum.php?forum_id=1752))
    - for ALSA-specific development

Check that the ALSA drivers are compiled as modules
---------------------------------------------------

Make sure you have installed ALSA as modules, and not compiled into the
kernel. ALSA fails for all sorts of reasons when compiled into the
kernel (this may no longer be true for kernels after v2.6.5\*). Anything
that mentions sound in the kernel config, even if it is not directly to
do with ALSA, set its option to M if you can. If you compile your own
kernel: when you configure the kernel, make sure you see `M` (for
module) and not `*` (compiled into the kernel).

-   Kernel v2.6.22.9 still doesn't like ALSA compiled into it, modules
    work.

Check the ALSA driver version
-----------------------------

Look at `/proc/asound/version` and that this says something like:

` `

    Advanced Linux Sound Architecture Driver Version 1.0.4.

and that the version is 1.0.4 or above. If it is not, download and
compile newer drivers for kernel v2.4, or update your v2.6 kernel to
version v2.6.5 or later. Check the [Quick
Install](/Quick_Install "Quick Install") instructions or the other
installation instructions on the main page of this Wiki for additional
information.

Check the ALSA library version
------------------------------

How to check your ALSA library version is distribution dependent.
Usually, you can use the package (e.g. RPM or DPKG) or dependency
manager (e.g. APT, `aptitude`, `synaptic`, `yum`, `up2date`, YAST2) used
by your distribution to check the versions of installed packages. You
can also try something like;

` `

    grep VERSION_STR /usr/include/alsa/version.h

and check that the version is at least 1.0.4, and usually it is best if
it matches the driver version. Check the [Quick
Install](/Quick_Install "Quick Install") instructions or the other
installation instructions on the main page of this Wiki for additional
information.

Check the sound drivers for your card are active
------------------------------------------------

First check that the ALSA drivers are installed and have recognized your
card. Make sure that `/proc/asound/cards` lists your card, as card
number zero. If not, make sure that the appropriate driver module is
loaded. To figure out which modules you need, use the
`lspci | egrep -i audio` command. This usually will list the name and
type of your sound chipset. The main ALSA website then contains a [list
of those chipsets and the required
drivers](http://www.alsa-project.org/alsa-doc/).

As a wild guess, for most recent low-cost AC97 based motherboards and
laptops, try the `snd-intel8x0` driver. To make sure your card is
recognized and the right driver is selected you can also try the
`alsaconf` command, and use it to configure your sound card. It can also
be that the ALSA driver has not been loaded but an OSS driver has been
loaded. Check the contents of `/dev/sndstat` (or
`/proc/asound/oss/sndstat`) and if you see your card listed there, and
there is no `ALSA emulation` line, it is being driven by an OSS driver.
Unload it and load the ALSA driver.

If you have multiple sound cards, see the
[MultipleCards](/MultipleCards "MultipleCards") and
[.asoundrc](/.asoundrc ".asoundrc") pages to discover how to configure
ALSA to renumber them if the cards are not in the order you would like
them to be.

Check that you have the right sound devices
-------------------------------------------

Run `alsamixer` as root. If you get

` `

    alsamixer: function snd_ctl_open failed for default: No such device

the right device special files in `/dev/` might be missing. Run
`ls /dev/snd/` and make sure there are several entries there. If the
directory does not exist, or it is empty, use the ALSA `snddevices`
script or similar to create it and the device special files in it.

Also verify that the global config file `/usr/share/alsa/alsa.conf` is
present and readable. It may be a link to `/etc/alsa/alsa.conf`

Check that non-`root` users can access the sound device special files
---------------------------------------------------------------------

Run `alsamixer` both as `root` and as a non-`root` ordinary user. If the
latter fails, the permissions on the device special files don't allow
access by ordinary users. There are several options to fix this,
depending on security requirements, your distribution and how your PC is
set up:

-   Allow all users read and write access to all sound devices, for
    example with `chmod -R a+rwX /dev/snd/.`. This might be slightly
    insecure.
-   Make sure that the sound device files belong to a specific group,
    they have group read/write permissions, and add all the users that
    should have access to the sound cards to that group. In many
    distributions this is the `audio` group.
-   If only one user needs access to the sound card, change the
    ownership of the sound device files to that user.

Check that the sound card mixer channels are unmuted
----------------------------------------------------

If your card's driver is installed and its name appears in
`/proc/asound/cards`, and you still hear no sound, the most likely cause
is that you haven't unmuted the right mixer channels and set their
volume to nonzero. Note that ALSA sort of misnames the channels of the
mixers of many cards. Use `alsamixer` to play around with the settings
of the most obvious sounding channels. [ALSA
modules](/ALSA_modules "ALSA modules") and [Sound
cards](/Sound_cards "Sound cards") may describe what the channels for a
specific sound card. Usually, make sure that the at least the `Master`
and `PCM` (and `Wave` or `Headphone` if present) channels are unmuted
and have non zero volume. For laptop users, try toggling the
`External Amplifier` switch.

The main channels are unmuted and non zero volume, but not sound
----------------------------------------------------------------

Many cards can do both analog and digital (labeled SPDIF/IEC958) output,
but some cannot do both at the same time. If you hear no sound, it may
be because the card is in analog mode and you have digital speakers or
viceversa. To determine which mixer channels controls the switch between
analog and digital for your card look at the [ALSA
modules](/ALSA_modules "ALSA modules") and [Sound
cards](/Sound_cards "Sound cards") pages for your module/card. Often
this is called `Analog/Digital Output Jack`. If present, mute/unmute it
to switch between digital and analog sound output.

Check whether your application uses OSS instead of ALSA
-------------------------------------------------------

If you still hear no sound, your application may be set up to use OSS.
Check with your application's preferences to see if this is the case.
Also check whether other applications are blocking ALSA, by running
(whilst ideally playing sound in them):

` `

    fuser -v /dev/snd/* /dev/dsp*

/dev/snd/\* is ALSA, but /dev/dsp\* is
[OSS](http://en.wikipedia.org/wiki/Open_Sound_System) (or rather, ALSA's
emulation of OSS - [OssEmulation](/OssEmulation "OssEmulation") - which
unfortunately has the side-effect of disabling [Dmix](/Dmix "Dmix")).

The best fix is to set your application up to use ALSA instead of OSS.
If your application does not support ALSA, there are three possible
solutions:

-   Make it use a sound server that uses ALSA for output.
-   Load the OSS compatibility modules for ALSA.
-   Use the [aoss](/Aoss "Aoss") wrapper to run the application.

It is also possible that your application is set up to use the API used
in the ALSA 0.5.x driver series. In that case switch the application to
use the new API, which is often called the ALSA 0.9.x API or the ALSA
1.x API. You can also set the default for applications that use `libao`
(for example `mpg321` and `mpg123` by putting the line

` `

    default_driver=alsa09

in `/etc/libao.conf` and for applications that use
[OpenAL](http://www.openal.org/) the line

` `

    (define devices '(alsa))

in the file `/etc/openalrc` or `~/.openalrc`.
[OssEmulation](/OssEmulation "OssEmulation") provides details on OSS
emulation.

Sound can be heard but it is distorted
--------------------------------------

-   Some cards, notably SB Live! ones, suffer from distortion if the
    volume on some subchannels is higher than 66%. Some suffer
    distortion if the `Master` volume is higher than 66%, for some
    others the threshold is 50%. Reduce all volume setting. If the
    distortion goes away, experiment until you determine which are the
    highest volume settings that don't trigger distortion.
-   Some cards, especially motherboard chipsets, have small limits on
    the fragment size (specified for example in the DMixPlugin
    configuration). Many cards cannot handle fragment sizes greater than
    4096 bytes, and if it is bigger the fragment seems to be truncated
    and the sound becomes choppy.
-   Some cards, especially recent ones, can only handle a fixed set of
    sampling frequencies. Some can only handle a single frequency,
    usually 48000Hz. try to use the *plug:* plugin prefix when playing.
    If your card can only play a single fixed frequency you must ensure
    that the driver is told that (by the use of driver-specific option
    parameters), and the ALSA library is setup up to output sample only
    at that frequency. Usually this will involve using the *plug* plugin
    in */etc/asound.conf*.

Compile problem when doing `make` with alsa-lib with kernel 2.6.7
-----------------------------------------------------------------

If during compilation you get `asm-generic/error.h File not found`
errors, and then `cards.lo Error 1`, go to your kernel source tree and
copy the files in `linux-2.6.x/include/asm-generic`" to
`/usr/include/asm-generic/` and it should work. This is usually however
a very bad thing to do, and you should try instead to fix your library
building process.

When loading modules, it complains of unknown symbols.
------------------------------------------------------

As root, type "lsmod". Look at the "Used by" column. If it has all "-",
this is bad. It should look more like the second output. This is not an
ALSA problem. Unluckily, I don't know how to fix this problem yet. (try
modprobe \<modulename\> on newer kernels to load the module and modprobe
-r \<modulename\> to unload it. kill any sound servers (e.g. artsd)
before attempting to unload)

Bad output:

` `

    Module                  Size  Used by
    nvram                   9036  - 
    snd_mixer_oss          19524  - 
    ipt_LOG                 6340  - 
    ipt_state               1956  - 
    ip_conntrack           35328  - 
    iptable_filter          2692  - 
    ip_tables              16672  - 
    lp                     10724  - 
    parport                40776  - 
    apm                    18032  - 
    uhci_hcd               32692  - 
    usbcore                81504  - 
    snd                    54180  - 
    soundcore               9440  - 
    snd_page_alloc         11596  - 
    intel_agp              19712  - 
    agpgart                33640  - 
    evdev                   9216  - 
    prism54                57212  - 
    firmware_class          9572  - 
    yenta_socket           21316  - 
    eepro100               30032  - 
    mii                     4900  - 

Good Output:

` `

    Module                  Size  Used by
    snd_pcm_oss            54184  0
    snd_mixer_oss          20864  1 snd_pcm_oss
    snd_audigyls           28456  0
    snd_emu10k1           105352  0
    snd_rawmidi            26532  1 snd_emu10k1
    snd_pcm                97796  3 snd_pcm_oss,snd_audigyls,snd_emu10k1
    snd_timer              28932  1 snd_pcm
    snd_seq_device          8584  2 snd_emu10k1,snd_rawmidi
    snd_ac97_codec         71632  2 snd_audigyls,snd_emu10k1
    snd_page_alloc          9992  3 snd_audigyls,snd_emu10k1,snd_pcm
    snd_util_mem            4480  1 snd_emu10k1
    snd_hwdep              10628  1 snd_emu10k1
    snd                    56420  11 snd_pcm_oss,snd_mixer_oss,snd_audigyls,snd_emu10k1,snd_rawmidi,snd_pcm,snd_timer,snd_seq_device,snd_ac97_codec,snd_util_mem,snd_hwdep
    soundcore               8288  1 snd
    nvidia               4818804  12
    md5                     4096  1
    ipv6                  262180  12
    ide_cd                 36896  0
    cdrom                  35228  1 ide_cd
    lp                      8936  0
    parport                36936  1 lp
    usbhid                 23680  0
    uhci_hcd               30224  0
    usbcore               107876  4 usbhid,uhci_hcd
    e1000                  79108  0

One possible fix: Check to make sure that the kernel that is currently
running is the one against which the modules were compiled. You may have
compiled a new kernel and not installed it, or made a mistake in your
bootloader configuration.

Kernel modules load correctly but you get error: Inappropriate ioctl for device
-------------------------------------------------------------------------------

If you run Gentoo or any other source-based distro, please make sure the
only CFLAGS/CXXFLAGS used are -O1 (or -O0), -march, -pipe and
-fomit-frame-pointer if necessary. -freorder-blocks and -malign-doubles
should never be activated. Should get you some errors such as

` `

    ALSA sound/core/control.c:1105: unknown ioctl = 0xc2c85512
    ALSA sound/core/control.c:1105: unknown ioctl = 0xc2c85512

Kernel-2.6.17.8 and VT82C686 AC97: "No such device"
---------------------------------------------------

Problem: kernel-2.6.17.8 with builtin alsa driver from version 1.0.11rc4
provokes a "No such device" message with the following hardware:

` `

    Host bridge: VIA Technologies, Inc. VT8363/8365 [KT133/KM133] (rev 03)
    Multimedia audio controller: VIA Technologies, Inc. VT82C686 AC97 Audio Controller (rev 50)

Solution: As I was just upgrading the linux kernel from 2.6.10 to
2.6.17.8 I already had a working alsa setup. The kernel configuration of
my whole sound subsystem was modular. Therefore neither a recompilation
of the kernel nor a reboot was required. The only thing I had to do was:

Upgrading alsa-driver to alsa-driver-1.0.12rc3:

` `

    ./configure --with-debug=full --with-cards=via82xx

    make -s
    make install

Now I removed all the old and faulty modules and replaced them by
loading the new modules as usual. Then as usual:

` `

    alsaconf
    alsamixer

alsamixer: function snd\_ctl\_open failed for default: No such device
---------------------------------------------------------------------

With kernel-2.6.19 and 2.6.19.1 the hints given above do not help. The
alsa-driver delivered with those kernels is simply not sufficient:

` `

    Cf. linux-2.6.19.1/include/sound/version.h 

    #define CONFIG_SND_VERSION "1.0.13"

The whole driver has to be upgraded to alsa-driver-1.0.14rc1. For me
this was the only way to avoid the error message "No such device".

hda-intel: no codecs found!
---------------------------

The error message "hda-intel: no codecs found!" can be experienced, when
the snd-hda-intel module fails to find the codec chip of your sound
device. This may for example happen if your PCIe 1x sound card is in the
wrong slot. For example on ASUS P5E mainboards, the supplied sound card
is supposed to be inserted in the *top most* PCIe 1x slot. This is the
brown slot on the P5E.

Retrieved from
"[http://alsa.opensrc.org/TroubleShooting](http://alsa.opensrc.org/TroubleShooting)"

[Category](/Special:Categories "Special:Categories"):
[Troubleshooting](/Category:Troubleshooting "Category:Troubleshooting")

