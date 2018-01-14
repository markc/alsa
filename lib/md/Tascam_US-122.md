Tascam US-122
=============

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Contents
--------

-   [1 IMPORTANT: Tascam US-122 and US-122L are NOT the
    same](#IMPORTANT:_Tascam_US-122_and_US-122L_are_NOT_the_same)
-   [2 Tascam US-122 on Debian and
    Ubuntu](#Tascam_US-122_on_Debian_and_Ubuntu)
    -   [2.1 Initial Setup](#Initial_Setup)
    -   [2.2 Plug and Play](#Plug_and_Play)
    -   [2.3 Audio Recording / Playback](#Audio_Recording_.2F_Playback)
    -   [2.4 Hardy Heron Fix](#Hardy_Heron_Fix)
    -   [2.5 MIDI Example](#MIDI_Example)
    -   [2.6 Mplayer Hint](#Mplayer_Hint)

-   [3 Tascam US-122 on Slackware
    10.2](#Tascam_US-122_on_Slackware_10.2)
    -   [3.1 Adept modprobe.conf](#Adept_modprobe.conf)
    -   [3.2 Install fxload (stage one
        firmware)](#Install_fxload_.28stage_one_firmware.29)
    -   [3.3 Compile usx2yloader tool and firmware (stage
        two)](#Compile_usx2yloader_tool_and_firmware_.28stage_two.29)

-   [4 Troubleshooting Hints](#Troubleshooting_Hints)
    -   [4.1 Audio Playback](#Audio_Playback)

IMPORTANT: Tascam US-122 and US-122L are NOT the same
-----------------------------------------------------

If you are looking for US-122L support check
[[1]](http://www.pps.jussieu.fr/~smimram/tascam/).

Tascam US-122 on Debian and Ubuntu
----------------------------------

### Initial Setup

**2018-01-18** - plug in your US-122 and then simply follow these 
instructions. If you'd like to automate the process you can use this
[Installer](https://github.com/mdnghtman/us122-linux/blob/master/tascam-us_122.sh) 
available on Github to automate the steps below.

    # open up a shell and change to root (or prepend
    # sudo to all instructions) and type in your normal
    # users password (or just "su -" with roots password)

    sudo -i -u root

    # download these eight packages (use the appropriate
    # package manager for your distribution)

    apt-get update
    apt-get install fxload alsa-base alsa-firmware-loaders alsa-tools alsa-tools-gui alsa-utils 
            alsamixergui alien

    # check for the latest package version first
 
    wget ftp://ftp.alsa-project.org/pub/firmware/alsa-firmware-1.0.29.tar.bz2

    # untar the ALSA firmware package

    tar -xvjf alsa-firmware-1.0.29.tar.bz2

    # build and install ALSA Firmware
    
    cd alsa-firmware-1.0.29
    ./configure --prefix=/usr && sudo make install
    
    # reconfigure alsa-base
    
    dpkg-reconfigure alsa-base
    
    # load the firmware
    
    cd usx2yloader/
    lsusb
    
    # output of lsusb should show something like this (Bus and Device number can differ)
    #
    # Bus 003 Device 002: ID 1604:8007 Tascam US-122 Audio/Midi Interface
    #
    # note Bus and Device number and change the last two numbers accordingly
    
    fxload -s ./tascam_loader.ihx -I /usr/share/alsa/firmware/usx2yloader/us122fw.ihx -D /dev/bus/usb/003/002
    
    # This command should initialize the Tascam US-122 and start the green LED on your device.
    # If you don't want to set a special UDEV rule, you're going to have to enter this command
    # after every restart or reconnect of the audio interface. 
    
    usx2yloader
    
    # if you get "no usx2y-compatible cards found" enter the following
    
    ln -s /usr/share/alsa/firmware/usx2yloader /lib/firmware/usx2yloader
    
### Plug and Play

Create a special rule for UDEV to autoload the firmware in
**/etc/udev/rules.d/55-tascam.rules** (requires a kernel \> 2.6.15) by
using any editor. You may need to alter some paths to match exactly
where your system has stored the required files.

    BUS=="usb", ACTION=="add", SYSFS{idProduct}=="8006", SYSFS{idVendor}=="1604", RUN+="/bin/sh -c '/sbin/fxload -D %N -s /usr/share/alsa/firmware/usx2yloader/tascam_loader.ihx -I /usr/share/alsa/firmware/usx2yloader/us122fw.ihx'"
    BUS=="usb", ACTION=="add", SYSFS{idProduct}=="8007", SYSFS{idVendor}=="1604", RUN+="/bin/sh -c '/usr/bin/usx2yloader'"

Now just plug in the USB cable for your US-122 and the top right hand
side green **USB** light should come on.

If you find that connecting the US-122 does *not* initialise it
correctly (i.e. the green USB led does not light up), check the
usb id of the device using lsusb. If it's "1604:8007", it may be
that the second line in the above rules file is invoking usx2yloader
before the hardware dependent interface has been raised. If so,
changing this second line to the following may provide a fix (it
did for the author of this paragraph):

    SUBSYSTEM=="sound", ACTION=="add", ATTR{id}=="USX2Y", RUN+="/bin/sh -c '/usr/bin/usx2yloader'"

### Audio Recording / Playback

It may also be useful to use these **/etc/asound.conf** (or
\~/.asoundrc) settings if you already have an onboard or PCI soundcard
installed so that most ALSA aware audio programs will respect the USB
based soundcard as the default. Older OSS software may not respect this
setting so you would need to specify **hw:1** or **/dev/dsp1** from
within each program. You could use **nano /etc/asound.conf** (as root)
and paste the below directly into the editor if you happen to have a
SBlive card, and have turned off any onboard audio device in your BIOS
so you only have two audio devices. You can check what sound cards have
been detected with **cat /proc/asound/cards**.

    pcm.Live        { type hw; card Live; }
    ctl.Live        { type hw; card Live; }

    pcm.USX2Y       { type hw; card USX2Y; }
    ctl.USX2Y       { type hw; card USX2Y; }

    pcm.!default    pcm.USX2Y
    ctl.!default    ctl.USX2Y

To test recording from the USB device at it's maximum fidelity of 24bits
and 48khtz, using default settings with something similar to the above
asound.conf, obviously plug some mic/line device into the devices
inputs, adjust the input and output gains, and in a shell use
**arecord** and **aplay** from the **alsa-utils** package (as a normal
user). Keep in mind that software mixers (ie; **alsamixer** or **kmix**)
do not work with a US-122.

    arecord -f S24_3LE -r 48000 -c 2 test.wav
    aplay test.wav
    file test.wav
    test.wav: RIFF (little-endian) data, WAVE audio, Microsoft PCM, 24 bit, stereo 48000 Hz

Here is a [short 10 second 3.5 MB wav voice
recording](/images/US122-24bit-48k.wav "US122-24bit-48k.wav") (Signed 24
bit Little Endian in 3bytes, Rate 48000 Hz, Stereo) using a Tascam
US-122 USB external sound card with a pair of Behringer B1 condenser
microphones.

### Hardy Heron Fix

From energymomentum on the Ubuntu forums
([http://ubuntuforums.org/showthread.php?t=734730](http://ubuntuforums.org/showthread.php?t=734730)):

I upgraded from Kubuntu Gutsy to Kubuntu Hardy and found that my US122
USB sound interface didn't work any more.

The main issue was that usx2yloader (in alsa-firmware-loaders package)
in hardy assumes that the necessary files are in
/lib/firmware/usx2yloader, while for the old usx2yloader it was
/usr/share/alsa/firmware/usx2yloader.

I already had everything under /usr/share/alsa/firmware/usx2yloader from
my Gutsy installation, so I just symlinked this to a new location:

    ln -s /usr/share/alsa/firmware/usx2yloader /lib/firmware/usx2yloader

After doing this, a local udev rules file I copied from this thread
([http://ubuntuforums.org/showthread.php?t=431066](http://ubuntuforums.org/showthread.php?t=431066))
took care of everything.

Note on (some?) later builds the link you need is actually:

    ln -s /usr/local/share/alsa/firmware/usx2yloader /lib/firmware/usx2yloader

Somewhat strange thing is, there is a udev rule for Tascam interfaces
(/etc/udev/alsa-firmware-loaders.rules) in udev package, which
apparently doesn't do anything for my US122. I still need to keep my own
udev rules file mentioned above.

NOTE: Works on Ubuntu too.

### MIDI Example

Testing MIDI input from a keyboard requires at least a softsynth (ie;
**fluidsynth**) and a SF2 Soundfont (ie;
[ftp://sf2midi.com/sgm128/SGM180v1.5.zip](ftp://sf2midi.com/sgm128/SGM180v1.5.zip)
80Mb) and **aconnect** from the **alsa-utils** package. From within a
shell as a normal user...

    fluidsynth -m alsa_seq soundfont.sf2

    # then in another shell

    aconnect -i
    ...
    client 20: 'TASCAM US-X2Y' [type=kernel]
        0 'TASCAM US-X2Y MIDI 1'

    aconnect -o
    ...
    client 129: 'FLUID Synth (8308)' [type=user]
        0 'Synth input port (8308:0)'

    aconnect 20 129  # keyboard input should now just work

### Mplayer Hint

Just as an aside, these settings are useful for **mplayer** in
**\~/.mplayer/config** which shows how to use the second sound device
(hw:1) for a program that does not respect the default audio device
(fs=yes is fullscreen and monitoraspect=1.6 suits a typical so called
wide screen LCD monitor).

    aO=alsa:noblock:device=hw=1.0
    fs=yes
    monitoraspect=1.6
    vo=xv

Tascam US-122 on Slackware 10.2
-------------------------------

This is circa stock 2.6.13 kernel, also works on a 2.6.16 kernel.

1.  Adept `modprobe.conf`
2.  Install `fxload` (stage one firmware upload)
3.  Compile
    [usx2yloader](?title=Usx2yloader&action=edit&redlink=1 "Usx2yloader (page does not exist)")
    tool and firmware (stage two firmware upload)

### Adept modprobe.conf

The `/etc/modprobe.conf` looks like:

` `

    alias eth0 ipw2200
    options eth0 debug=0x43fff
    alias eth1 r8169

    # Alsa
    alias snd-card-0 snd-hda-intel
    alias sound-slot-0 snd-hda-intel

    alias snd-card-1 snd-usb-usx2y
    alias sound-slot-1 snd-usb-usx2y
    # OSS / Free
    alias char-major-116 snd
    alias char-major-14 soundcore
    options snd-usb-usx2y enable=1 index=1

    # Card 2
    alias sound-service-1-0 snd-mixer-oss
    alias sound-service-1-1 snd-seq-oss
    alias sound-service-1-3 snd-pcm-oss
    alias sound-service-1-8 snd-seq-oss
    alias sound-service-1-12 snd-pcm-oss

### Install fxload (stage one firmware)

Note that most of these commands need to be performed as the root user.

` `

    mkdir -p ~/source ~/pkg ~/tarballs
    cd ~/source
    wget http://surfnet.dl.sourceforge.net/sourceforge/linux-hotplug/fxload-2002_04_11.tar.gz
    tar xzf fxload-2002_04_11.tar.gz
    cd fxload-2202_04_11

    make

If you get a lot of errors, then you have ignored Patrick's warning to
leave the 2.4 includes alone. Then do:

` `

    removepkg kernel-headers-2.6.13
    removepkg kernel-headers-2.4.31 (got overwritten by 2.6.13)
    slackpkg install kernel-headers-2.4.31

Okay, continue with compile

` `

    make
    checkinstall
    mv fx*.tgz ../pkg

### Compile [usx2yloader](?title=Usx2yloader&action=edit&redlink=1 "Usx2yloader (page does not exist)") tool and firmware (stage two)

` `

    wget ftp://ftp.alsa-project.org/pub/firmware/alsa-firmware-1.0.11.tar.bz2
    wget ftp://ftp.alsa-project.org/pub/tools/alsa-tools-1.0.11.tar.bz2
    tar xjf alsa-driver-1.0.11.tar.bz2
    tar xjf alsa-tools-1.0.11.tar.bz2
    tar xjf alsa-firmware-1.0.11.tar.bz2
    mv *.bz2 tarballs

    cd alsa-tools-1.0.11/usx2yloader
    ./configure;make;checkinstall # Set version to 1.0.11 for clarity
    cd ../../alsa-firmware-1.0.11/
    ./configure
    cd usx2yloader
    checkinstall # Try not to overwrite the tool package

Troubleshooting Hints
---------------------

### Audio Playback

Had some struggle to get the audio-device working. Midi devices are
working properly but when working audio-device it results in:

    Sep 20 13:32:47 afpc19 kernel: [ 5124.040000] Sequence Error!(hcd_frame=5135103 ep=8in;wait=5135080,frame=5135084).
    Sep 20 13:32:47 afpc19 kernel: [ 5124.040000] Most propably some urb of usb-frame 5135080 is still missing.
    Sep 20 13:32:47 afpc19 kernel: [ 5124.040000] Cause could be too long delays in usb-hcd interrupt handling.

The reason is that thinkpad-bios and ubuntu-drivers are working with usb
2.0 and the US-122 is with usb1.1. This can be solved by unloading
usb2.0 functionality:

    sudo rmmod ehci_hcd

\
 You'll have to execute that command at the beginning of a session (i.e.
every restart reverts it). Presumably there are ways to prevent the
module from being loaded upon startup in the first place. Found this at
[http://www.thinkwiki.org/wiki/Problem\_with\_USB\_2.0](http://www.thinkwiki.org/wiki/Problem_with_USB_2.0)

Another thing you can try (maybe in addition to the above) is to modify
the number of packets per URB. In order to do that, have the
snd-usb-usx2y module loaded with the option "nrpacks=1" (This may also
solve problems with distorted or crackling audio output with the
US-122).

For immediate results:

    sudo rmmod snd-usb-usx2y
    sudo modprobe snd-usb-usx2y nrpacks=1

(You may have to remove dependent modules / close playback applications
first). Vary the value of nrpacks (2,3,4..) if it's not working.

To make the change permanent, create (referring to Ubuntu)
/etc/modprobe.d/snd-usb-usx2y with the following content:

    option snd-usb-usx2y nrpacks=1

Retrieved from
"[http://alsa.opensrc.org/Tascam\_US-122](http://alsa.opensrc.org/Tascam_US-122)"

[Category](/Special:Categories "Special:Categories"): [Sound
cards](/Category:Sound_cards "Category:Sound cards")

