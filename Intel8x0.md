Intel8x0
========

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

See also [Official intel8x0
Page](http://www.alsa-project.org/alsa-doc/doc-php/template.php?module=intel8x0)
| [DmixPlugin](/DmixPlugin "DmixPlugin") | [Intel8x0 user
comments](/Intel8x0_user_comments "Intel8x0 user comments")

Contents
--------

-   [1 Troubleshooting](#Troubleshooting)
    -   [1.1 SDL Sound Latency](#SDL_Sound_Latency)
    -   [1.2 Multichannel Mixing](#Multichannel_Mixing)
    -   [1.3 Teamspeak, Quake3](#Teamspeak.2C_Quake3)
    -   [1.4 IEC958 controls in the mixer have no effect on sound output
        on SPDIF connection (Shuttle XPC
        SS51G)](#IEC958_controls_in_the_mixer_have_no_effect_on_sound_output_on_SPDIF_connection_.28Shuttle_XPC_SS51G.29)
    -   [1.5 Digital output not working (Realtek
        ALC850)](#Digital_output_not_working_.28Realtek_ALC850.29)
    -   [1.6 Sound not working on Fujitsu-Siemens Desktops with
        ICH845](#Sound_not_working_on_Fujitsu-Siemens_Desktops_with_ICH845)

-   [2 Installation/Configuration](#Installation.2FConfiguration)
    -   [2.1 Debian with KDE](#Debian_with_KDE)
    -   [2.2 Dell Laptops](#Dell_Laptops)
    -   [2.3 Dell Inspiron 8600 (and probably
        others)](#Dell_Inspiron_8600_.28and_probably_others.29)
    -   [2.4 Dell Inspiron Laptops (4150, 8200?,
        others?)](#Dell_Inspiron_Laptops_.284150.2C_8200.3F.2C_others.3F.29)
    -   [2.5 Shuttle XPC SS51G](#Shuttle_XPC_SS51G)

-   [3 Device configuration
    (.asound)](#Device_configuration_.28.asound.29)
    -   [3.1 Generic configuration](#Generic_configuration)
    -   [3.2 Intel 845 (Dell Inspiron 1100
        laptop)](#Intel_845_.28Dell_Inspiron_1100_laptop.29)
    -   [3.3 NForce 1 MSI K7N420](#NForce_1_MSI_K7N420)
    -   [3.4 ASUS A7N8X Deluxe](#ASUS_A7N8X_Deluxe)
    -   [3.5 Shuttle SN41G2](#Shuttle_SN41G2)
    -   [3.6 nForce 4 digital output](#nForce_4_digital_output)
    -   [3.7 Fujitsu Siemens Lifebook E8020 intel8x0 +
        snd-usb-audio](#Fujitsu_Siemens_Lifebook_E8020_intel8x0_.2B_snd-usb-audio)

Troubleshooting
---------------

### SDL Sound Latency

When using libSDL under gentoo linux with an SiS chip and the intel8x0
driver, make sure you compile with the oss use flag on. Without this
flag, oss support is not compiled into libsdl and some sound
applications lag by up to half a second.

### Multichannel Mixing

I run into this problem with my IBM T40. For example, you want to play
music in a flash movie during a mozilla session while you also listen to
your mp3s with mplayer or xmms. MPlayer and XMMS provides particular
plugins you can load to use ALSA, but this wouldn't solve the problem at
all. In fact, you have to use the dmix plugin to get the multiple
streams mixed before they access the soundcard. Alsa can do this for
you, but you need to tell ALSA to forward the streams first through the
dmix plugin. Setup an .asoundrc in your home and follow the first two
steps at Dmix Plugin. You should be able to play your mp3s with the dmix
plugin. If this isn't working try to unload the ALSA OSS emulation
modules, to make sure, that the application really uses alsa. If this
works, add this example to your .asoundrc: ` `

     # this is IBM T40 specific, which 
     # uses the snd_intel8x0, and may
     # not work on other laptops

     pcm.amix {
       type dmix
       ipc_key 50557
       slave {
           pcm "hw:0,0"
           period_time 0
           period_size 1024
           buffer_size 8192
       }
       bindings {
           0 0
           1 1
       }
     }

     # route ALSA software through pcm.amix
     pcm.!default {
       type plug
       slave.pcm "amix"
     }

Now try to use eg. mplayer with the alsa plugin to play your mp3s. You
should be able to play several mp3s in several mplayer instances. If not
try to start your mplayer by defining which device alsa should use:

` `

     mplayer -ao alsa:device=amix foobar.mp3

Remember, we setup the amix device in the .asoundrc first, which uses
dmix (pcm.amix). If this device is called pcm.foobar, you then use this
instead...

` `

     mplayer -ao alsa:device=foobar foobar.mp3

\

### Teamspeak, Quake3

See DmixPlugin to get it working.

### IEC958 controls in the mixer have no effect on sound output on SPDIF connection (Shuttle XPC SS51G)

Thanks to a tip from Ole Andre Schistad (oschista@chello.no) on the
alsa-project.org web site under documentation for the Intel i820 card
options. The solution is to compile the ALSA drivers, libs and utils
with "cvscompile". According to Ole, "The S/PDIF support in this chipset
currently requires a CVS version of ALSA...the required device under
/dev/alsa is not created with the "release" drivers..." I'm using ALSA
version 0.9.6.

### Digital output not working (Realtek ALC850)

This driver also works for the Realtek ALC850 chip (as used in nForce4
boards). To use the digital output there you just have to connect a
optical cable and set the output volume of the **IEC958 Playback
AC97-SPSA** to zero. This is a bit counter-intuitive, but it works
because with a digital output you cannot control the volume from within
ALSA, but rather set the output mode. Zero means here output, whereas
other values mean no output. You may have to go to the very far right in
alsamixer or some graphical mixer to find the slider.

### Sound not working on Fujitsu-Siemens Desktops with ICH845

There might be problems with sound not working on workstations by
Fujitsu-Siemens with ICH845-based AC97 soundcard onboard. This problem
confirmed to occur on Fedora Core 6. Symptoms are sound isn't working,
and entries like this appear in dmesg/syslog:

` `

     PCI: Enabling device 0000:00:1f.5 (0000 -> 0003)
     ACPI: PCI Interrupt 0000:00:1f.5[B] -> GSI 17 (level, low) -> IRQ 201
     PCI: Setting latency timer of device 0000:00:1f.5 to 64
     AC'97 0 access is not valid [0xffffffff], removing mixer.
     Unable to initialize codec #0
     ACPI: PCI interrupt for device 0000:00:1f.5 disabled
     Intel ICH: probe of 0000:00:1f.5 failed with error -5

The solution found to overcome a problem is to use the following options
for intel8x0 module:

` `

     # modprobe -r snd-intel8x0
     # modprobe snd-index8x0 ac97_quirk=1 xbox=1

This parameters were found in source code for intel8x0 module in
alsa-drivers package. Looks like there's no information about them in
official docs as for now (Jule 2007).

Installation/Configuration
--------------------------

### Debian with KDE

Quick start instructions for Debian with KDE. (verified with Si S 7012 +
Realtek codec and nForce2 MCP + Realtek codec)

1.  Install alsa-base
2.  Select intel8x0 in configuration screen
3.  Enable OSS/Free emulation
4.  In KDE, go to control panel-\> sound system
5.  Select 'toss' (Threaded Open Sound System). If you select anything
    else a lot of the output will be scratchy
6.  Restart KDE
7.  Rock'n'Roll

### Dell Laptops

The new batches of DELL computers all have this chipset on the
motherboard that does everything. The OSS driver is \*very\* sub-par.
Try to watch a DVD or a DIVX movie with it and you'll see what I mean:
the audio skips, loses sync, etc. However the ALSA driver solves all
problems. [Not for some laptops -- see below.] I compiled it with a
brand new Red Hat 7.3 distribution. Things to look for:

-   you need the kernel source as per documentation, the SRPM is what
    you want, as Red Hat makes significant changes to the stock kernel.
    No matter what, you'll need the source of the kernel you are
    running.
-   if using the SRPM from Red Hat you'll need to edit the top-level
    makefile of the kernel distribution, and you'll need to change the
    EXTRAVERSION variable (4th line) to the version you are running. By
    default it is something like:

` `

     EXTRAVERSION=-4custom

type `uname -a` and check the name of your kernel, it should be
something like

` `

     Linux caravan 2.4.18-4 #1 Thu May 2 18:47:38 EDT 2002 i686 unknown

if you have an SMP kernel you'll get 2.4.18-4smp. Change the
EXTRAVERSION to match that, i.e: -4 or -4smp

-   Compile and install as per instructions, load the kernel modules.
    Check `/proc/asound` that the chipset was correctly detected.
-   Note that you can now use an OSS mixer, but that no matter what you
    do no sound comes out of the speakers. Don't despair, this is
    normal!
-   you'll NEED to compile the ALSA library and the ALSA tools, and to
    install them
-   once this is done, use `amixer` to unmute the Headphone, ie:

` `

     amixer -c 0 sset Headphone,0 55 unmute

you should get: ` `

     Simple mixer control 'Headphone',0
     Capabilities: pvolume pswitch pswitch-joined
     Playback channels: Front Left - Front Right
     Limits: Playback 0 - 63
     Front Left: Playback 55 [87%] [on]
     Front Right: Playback 55 [87%] [on]

In order to unmute the default speaker jacks do: ` `

     amixer set PCM 100 unmute

-   be aware that you need the snd-mixer-oss module to be loaded if you
    wish to adjust the volume with an OSS legacy mixer. This also means
    programs like xmms!
-   from now on you should be able to play sounds with any applications,
    OSS or ALSA, and OSS mixers should be able to handle your card.
    remember you must install an oss mixer to get oss applications to
    work correctly - i recommend aumix.
-   for the best sound quality (at least on my dell smartstep) make sure
    master and pcm are about two bars below their maximum, and correct
    volume with the wheel on the side of your computer. otherwise you
    will notice some frequency range problems.

### Dell Inspiron 8600 (and probably others)

To get sound out of the regular laptop speakers, you must MUTE the
"External Amplifier Power Down" slider by pressing M. (On mine, it is
the farthest slider to the right.)

-   Mute = sound
-   Unmute = no sound.

### Dell Inspiron Laptops (4150, 8200?, others?)

**2003-05-07**

NEWSFLASH (Jun 3, 2003): The newly-released BIOS version A06 for the
Inspiron 4150 solves this problem completely! I expect that new BIOSes
for the other Dell laptops will solve the problem too. I'm leaving the
rest of this here just in case anybody else has this problem and wants
to understand it, but if you upgrade to a new bios and try the "while
/bin/true; ..." test listed below and don't have any problems then you
can disregard this issue entirely!

This is one case where the OSS intel8x0 driver works much better than
the ALSA snd-intel8x0 driver (at least as of ALSA version 0.9.2). If all
you care about is listening to music/CDs/sound-effects in games then
just stick with the OSS driver -- it works well for those purposes. If
you care about the more advanced features of the ALSA drivers (because
you want to use Jack, for example) then you're in for a bumpy ride.
Symptoms of the problem:

-   You find that your sound output often gets polluted with noise.

-   Start playing a sound or music file with, say, xmms (using the ALSA
    output plugin) and then run "while /bin/true; do cat /proc/apm;
    done". The sound will very quickly become heavily polluted with
    static and noise, which continues even after you stop accessing
    /proc/apm. Stopping the sound file and restarting it may or may not
    make the noise go away.

**Details about the problem:**

-   It seems to be caused by a bad APM implementation in the BIOS. If
    you're running apmd, klaptopdaemon, or anything else that reads from
    /proc/apm periodically it will trigger this problem quite often.

-   You might have also noticed that your clock runs slow. In fact,
    running the "while /bin/true..." script causes my clock to run at
    about 1/2 speed. Here's a link that discusses this aspect of the
    problem:
    [http://math.stanford.edu/\~carlton/i8200/time.html](http://math.stanford.edu/~carlton/i8200/time.html)

**Remedies:**

-   BIOS A06 solves this issue for the Inspiron 4150.

-   You can switch from APM to ACPI for power management. I haven't done
    much experimentation with this yet because some preliminary
    investigation suggests that suspend to RAM won't work for 2.4
    kernels, which is a showstopper for me. If you're interested in
    going this route, be sure to see this link:
    [http://acpi.sourceforge.net/wiki/index.php/FixedDsdts](http://acpi.sourceforge.net/wiki/index.php/FixedDsdts)

-   Compile APM with CONFIG\_APM\_ALLOW\_INTS=y. This allows interrupts
    during APM calls.

-   Compile APM as a module instead of compiling it into the kernel.
    This way you can unload the apm module while you're doing music and
    reload it when you're done. Unfortunately I haven't been able to get
    the use-count of the apm module down to 0 without exiting X (I
    stopped apmd and killed all battery monitor applets). If I remove
    the apm module before starting X and modprobe it after starting X
    then I can subsequently get the use count back down to 0, but
    suspend/resume doesn't work properly. So AFAICT you have to restart
    X to go between apm-enabled and apm-disabled states. It's better
    than rebooting, but still annoying.

Using the two APM options above (allow interrupts and compile as module)
helps somewhat, even when the apm module is loaded. I can now play songs
in XMMS with occasional skips but I almost never get the noise pollution
that used to show up about once per song. I can even almost use Jack
successfully.

### Shuttle XPC SS51G

To record with the microphone jack on the front, you need to select
"Mic2" in the amixer "Mic Select" field. The default is to use "Mic1",
which is the input on the back.

Device configuration (.asound)
------------------------------

### Generic configuration

All examples in **/etc/asound.conf** or **\~/.asoundrc**

` `

     pcm.nforce-hw {
       type hw
       card 0
     }
     pcm.!default {
       type plug
       slave.pcm "nforce"
     }
     pcm.nforce {
       type dmix
       ipc_key 1234
       slave {
           pcm "hw:0,0"
           period_time 0
           period_size 1024
           buffer_size 4096
           rate 44100
       }
     }
     ctl.nforce-hw {
       type hw
       card 0
     }

### Intel 845 (Dell Inspiron 1100 laptop)

` `

     pcm.nforce-hw {
       type hw
       card 0
     }
     pcm.!default {
       type plug
       slave.pcm "nforce"
     }
     pcm.nforce {
       type dmix
       ipc_key 1234
       slave {
           pcm "hw:0,0"
           period_time 0
           period_size 1024
           buffer_size 8192
           rate 44100
       }
       bindings {
           0 0
           1 1
       }
     }
     ctl.nforce-hw {
       type hw
       card 0
     }

### NForce 1 MSI K7N420

` `

     pcm.nforce-hw {
       type hw
       card 0
     }
     pcm.!default {
       type plug
       slave.pcm "nforce"
     }
     pcm.nforce {
       type dmix
       ipc_key 1234
       slave {
           pcm "hw:0,0"
           period_time 0
           period_size 512
           buffer_size 4096
           rate 44100
       }
     }
     ctl.nforce-hw {
       type hw
       card 0
     }

### ASUS A7N8X Deluxe

` `

     pcm.nforce-hw {
       type hw
       card 0
     }
     pcm.!default {
       type plug
       slave.pcm "nforce"
     }
     pcm.nforce {
       type dmix
       ipc_key 1234
       slave {
           pcm "hw:0,0"
           period_time 0
           period_size 1024
           buffer_size 32768
           rate 48000
       }
     }
     ctl.nforce-hw {
       type hw
       card 0
     }

### Shuttle SN41G2

` `

     pcm.nforce-hw {
       type hw
       card 0
     }
     pcm.!default {
       type plug
       slave.pcm "nforce"
     }
     pcm.nforce {
       type dmix
       ipc_key 1234
       slave {
           pcm "hw:0,1"
           period_time 0
           period_size 1024
           buffer_size 4096
           rate 44100
       }
     }
     ctl.nforce-hw {
       type hw
       card 0
     }

### nForce 4 digital output

Mainboard is an Asus K8N Deluxe with nForce 4.

` `

    cat /proc/asound/pcm 
    00-02: Intel ICH - IEC958 : NVidia CK804 - IEC958 : playback 1
    00-01: Intel ICH - MIC ADC : NVidia CK804 - MIC ADC : capture 1
    00-00: Intel ICH : NVidia CK804 : playback 1 : capture 1

Mixer settings:

` `

    amixer set IEC958 unmute
    amixer set 'IEC958 Playback AC97-SPSA' 0
    amixer set 'IEC958 Playback Source' PCM

AC3/DTS passthrough on S/P-DIF should now work with mplayer:

` `

    mplayer -ao alsa:device=hw=0.0 -ac hwdts,hwac3, FILE

### Fujitsu Siemens Lifebook E8020 intel8x0 + snd-usb-audio

I have worked on asoundrc that provides duplex functionality i.e. I can
play more than one sound sources. I need this to watch TV over mplayer
and listen music over xmms, but other progs work as well

\

` `

    # Set default sound card
    # Useful so that all settings can be changed to a different card here.
    pcm.snd_card0 {
         type hw
         card 0
         device 0
    }

    pcm.snd_card1 {
         type hw
         card 1
         device 0
    }

    # Allow mixing of multiple output streams to this device
    pcm.output {
         type dmix
         ipc_key 1024
         ipc_perm 0660 # Sound for everybody in your group!
         slave.pcm "snd_card0"

         slave {
              # This stuff provides some fixes for latency issues.
              # buffer_size should be set for your audio chipset.
              period_time 0
              period_size 1024
              buffer_size 8192
              # buffer_size 4096
              # buffer_size 2048
         }

         bindings {
              0 0
              1 1
         }
    }

    pcm.input {
         type dsnoop
         ipc_key 2048
         slave.pcm "snd_card0"

    ## Possible artsd full duplex fix:
    #     slave {
    #          period_time 0
    #          period_size 1024
    #          buffer_size 8192
    #     }

         bindings {
              0 0
              1 1
         }
    }
    # Allow reading from the default device.
    # Also known as record or capture.
    pcm.input1 {
         type dsnoop
         ipc_key 2049
         slave.pcm "snd_card1"

    ## Possible artsd full duplex fix:
         slave {
              period_time 0
              period_size 1024
              buffer_size 8192
              # buffer_size 4096
              # buffer_size 2048
         }

         bindings {
              0 0
              1 1
         }
    }
    # This is what we want as our default device
    # a fully duplex (read/write) audio device.
    pcm.duplex {
         type asym
         playback.pcm "output"
         capture.pcm "input"
    #     capture.pcm "input1"
    }

    ###################
    # CONVERSION PLUG #
    ###################
    # Setting the default pcm device allows the conversion
    # rate to be selected on the fly.
    # duplex mode allows any alsa enabled app to read/write
    # to the dmix plug (Fixes a problem with wine).
    pcm.!default {
         type plug
         slave.pcm "duplex"
    }
    ########
    # AOSS #
    ########
    # OSS dsp0 device (OSS needs only output support, duplex will break some stuff)
    pcm.dsp0 {
         type plug
         slave.pcm "output"
    }

    #
    pcm.dsp1 {
         type plug
         slave.pcm "output1"
    }

Below I define some input options as described in the mplayers man page

Unfortunately the output is not working so I use sox to copy the sound
and resample it and v4lctl to unmute the tv input

` `

    v4lctl volume mute off

This is how I run the mplayer in tv mode

` `

    TV_DRV="driver=v4l2:outfmt=yuy2:width=640:height=480"
    TV_DEV="device=/dev/video0:input=1"
    TV_NORM="norm=PAL:normid=0:chanlist=europe-west"
    TV_AUD="alsa:audiorate=48000:forceaudio:amode=1:adevice=input1:volume=75:immediatemode=0"
    AUD_O="driver=alsa:noblock:forceaudio:forcechan=2:audiorate=48000:device=output"
    VID_O="gl2,pp=lb,denoise3d"

    mplayer -ontop -framedrop -stop-xscreensaver  \
                -vf scale \
                -input conf=$HOME/.mplayer/input.conf \
                -tv $TV_DRV:$TV_DEV:$TV_AUD:$TV_NORM\
                -vo $VID_O \
                -ao $AUD_O \
                tv:// 2>&1>/dev/null

And this is how I copy and resample the sound from the tv(usb)card to
the intel8x0 card

` `

    sox -q -r 48000 -w -s -c 2 -t ossdsp /dev/dsp1 -t alsa -w -s -c 2 duplex

There is a problem to copy/capture the sound from the tv card and
(internelly in mplayer) to output it to the other card. If you have any
suggestions please write to deloptes at yahoo dot com.

Retrieved from
"[http://alsa.opensrc.org/Intel8x0](http://alsa.opensrc.org/Intel8x0)"

[Category](/Special:Categories "Special:Categories"): [ALSA
modules](/Category:ALSA_modules "Category:ALSA modules")

