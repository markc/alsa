Dmix
====

### From the ALSA wiki

(Redirected from
[DmixPlugin](?title=DmixPlugin&redirect=no "DmixPlugin"))

Jump to: [navigation](#mw-head), [search](#p-search)

PCM plugins extend the functionality of PCM devices allowing low-level
sample conversions and copying between channels, files and soundcard
devices. The dmix plugin provides for direct mixing of multiple streams.

**NOTE: For ALSA 1.0.9rc2 and higher you don't need to setup dmix for
analogue output. Dmix is enabled by default for soundcards which don't
support hardware mixing. You still need to set it up for digital
outputs.**

-   requires creation of a virtual slave device
-   the resolution for 32-bit mixing is only 24-bit
-   the low significant byte is filled with zeros
-   the extra 8 bits are used for the saturation
-   [http://www.alsa-project.org/alsa-doc/alsa-lib/pcm\_plugins.html](http://www.alsa-project.org/alsa-doc/alsa-lib/pcm_plugins.html)

Contents
--------

-   [1 The Dmix Howto](#The_Dmix_Howto)
    -   [1.1 1. Install aoss, alsaplayer,
        mpg321](#1._Install_aoss.2C_alsaplayer.2C_mpg321)
    -   [1.2 2. Test basic dmix on alsa
        with:](#2._Test_basic_dmix_on_alsa_with:)
    -   [1.3 3. configure .asoundrc for
        aoss-testing:](#3._configure_.asoundrc_for_aoss-testing:)
    -   [1.4 4. Test aoss with mpg123 in oss
        mode:](#4._Test_aoss_with_mpg123_in_oss_mode:)
    -   [1.5 5. The simple approach:](#5._The_simple_approach:)
    -   [1.6 6. The complex approach (defining dmix
        parameters)](#6._The_complex_approach_.28defining_dmix_parameters.29)
    -   [1.7 7. Dmixing the ICE1712 chip](#7._Dmixing_the_ICE1712_chip)
    -   [1.8 8. Dmixing the Audiophile 192
        (ice1724)](#8._Dmixing_the_Audiophile_192_.28ice1724.29)
    -   [1.9 Dmixing with Amarok](#Dmixing_with_Amarok)
    -   [1.10 Additional Info](#Additional_Info)
    -   [1.11 Getting mplayer to work](#Getting_mplayer_to_work)

-   [2 KDE](#KDE)
-   [3 Still Hearing Stuttering?](#Still_Hearing_Stuttering.3F)
-   [4 Dmix KDE(arts), ESD and SDL quick and dirty
    HOWTO](#Dmix_KDE.28arts.29.2C_ESD_and_SDL_quick_and_dirty_HOWTO)
-   [5 Gentoo ALSA dmix setup](#Gentoo_ALSA_dmix_setup)
-   [6 Comments](#Comments)
    -   [6.1 dmix & surround sound](#dmix_.26_surround_sound)
    -   [6.2 Dmix Surround7 and more](#Dmix_Surround7_and_more)
    -   [6.3 Does dmix affect sound
        quality?](#Does_dmix_affect_sound_quality.3F)

The Dmix Howto
--------------

Written in large parts by Frank Barknecht (feel free to use it any way
you like). This howto describes how to set up dmix for OSS applications.

### 1. Install aoss, alsaplayer, mpg321

Note: If you use Debian, aoss comes with the alsa-oss package. Just
type:

` `

    apt-get install alsa-oss alsaplayer mpg321 alsaplayer-alsa alsa-base

The aplay command used below comes in the alsa-utils package for Debian,
but this conflicts with the udev package, and thus you'll probably not
want to install it.

### 2. Test basic dmix on alsa with:

` `

    alsaplayer -o alsa -d plug:dmix some.mp3 &
    aplay -D plug:dmix some.wav &
    alsaplayer -o alsa -d plug:dmix some.mp3 &

This should work everywhere with ALSA 0.9.7. (It works also with ALSA
0.9.8 on a snd-intel8x0, eg. on nForce2 audio). If the second and/or
third audiostream stutters, it might be the buffers-problem mentioned
below 7). Don't give up yet.

### 3. configure .asoundrc for aoss-testing:

` `

    # cat ~/.asoundrc:
    pcm.dsp0 {
        type plug
        slave.pcm "hw:0"
    }
    # or:
    # pcm.dsp0 pcm.default
    # if "default" hasn't been redefined
    ctl.mixer0 {
        type hw
        card 0
    }

### 4. Test aoss with mpg123 in oss mode:

` `

    aoss mpg123 some.mp3

This should play the file, but not yet "dmix"ed. Now comes the tricky
and rather difficult part: redefining dsp0 to behave like dmix.

Note that mpg321 (which is a DFSG-free clone of mpg123) uses libao and
has alsa support built-in.

### 5. The simple approach:

` `

    # cat ~/.asoundrc
    pcm.dsp0 {
        type plug
        slave.pcm "dmix"
        # A hint is required for listing the device in some GUIs, e.g. Phonon configuration.
        hint {
             show on
             description "My dmix dsp0"
        }
    }
    # mixer0 can stay unchanged, because
    # it isn't used anyway, I guess ;)
    ctl.mixer0 {
        type hw
        card 0
    }

Test this setup with mpg123 like under 4). This should enable dmix'd OSS
playback, but it will not work on cards like the M-Audio Audiophile or
other Delta cards, that need a certain audio data format for playback on
hw:0 (which dmix uses by default). A fix is below.

### 6. The complex approach (defining dmix parameters)

If a card needs a certain format conversion we need to create a custom
dmix device. Let's call it ossmix.

` `

    pcm.ossmix {
        type dmix
        ipc_key 1024 # must be unique!
    #   ipc_key_add_uid false   # let multiple users share
    #   ipc_perm 0666           # IPC permissions for multi-user sharing (octal, default 0600)
        slave {
            pcm "hw:0,0"      # you cannot use a "plug" device here, darn.
            period_time 0
            period_size 1024 # must be power of 2
            buffer_size 8192  # dito. It
           #format "S32_LE"
           #periods 128 # dito.
           #rate 8000 # with rate 8000 you *will* hear,
           # if ossmix is used :)
        }
        # bindings are cool. This says, that only the first
        # two channels are to be used by dmix, which is
        # enough for (most) oss apps and also lets 
        # multichannel chios work much faster:
        bindings {
            0 0 # from 0 => to 0
            1 1 # from 1 => to 1
        }
    }
    pcm.dsp0 {
        type plug
        slave.pcm "ossmix" # use our new PCM here
    }
    # mixer0 like above
    ctl.mixer0 {
        type hw
        card 0
    }

    # You may want to make your new ossmix the default for alsa.
    # If your alsa programs are complaining that they can't open
    # your sound devices, try uncommenting this next line
    #pcm.default pcm.dsp0

It is important, that this "ossmix" PCM works with your card in ALSA
mode. That is, the following should produce sound:

` `

    alsaplayer -o alsa -d ossmix some.mp3

### 7. Dmixing the ICE1712 chip

The config above does still not work (well) with an Audiophile card
(ICE1712 chip) or a VIA VT82xx (snd-via82xx). The error is:

` `

    $ alsaplayer -d ossmix
    error on set_format SND_PCM_FORMAT_S16_LE
    Unavailable hw params:
    ACCESS: RW_INTERLEAVED
    FORMAT: S32_LE
    SUBFORMAT: ALL
    SAMPLE_BITS: ALL
    FRAME_BITS: ALL
    CHANNELS: 2
    RATE: 48000
    PERIOD_TIME: (21333 21334)
    PERIOD_SIZE: 1024
    PERIOD_BYTES: ALL
    PERIODS: (6 7)
    BUFFER_TIME: (136520 136521)
    BUFFER_SIZE: 6553 <<<<====take a look here!!
    BUFFER_BYTES: ALL
    TICK_TIME: ALL

Jaroslav Kysela did know the reason: The max buffer size of the Delta
card is "6553" as marked above. So we need to specify a buffer size in
our dmix definition that is: a) a power of two and b) less than 6553.
Here's the fixed OSS-dmix .asoundrc for a ICE1712 and VT82xx card:

` `

    # cat ~/.asoundrc
    # our ICE1712 dmix:
    pcm.ossmix {
        type dmix
        ipc_key 1024
        slave {
        pcm "hw:0,0"
            period_time 0
            period_size 1024
            buffer_size 4096 # buffer size < 6653, but pow(x, 2)
            rate 44100 # we want to play CDs only
            format S32_LE # needed in alsa 1.0.10 for some reason
        }
        bindings {
            0 0
            1 1
        }
    }
    # Everything shall be dmixed, so redefine "default":
    pcm.!default {
        type plug
        slave.pcm "ossmix"
    }
    # OSS via aoss should d(mix)stroyed:
    pcm.dsp0 {
        type plug
        slave.pcm "ossmix"
    }
    ctl.mixer0 {
        type hw
        card 0
    }

Comment by Jan. I have an Audiophile (Ice1712) and the above .asoundrc
does not change anything. I still get the same error message "error on
set\_format SND\_PCM\_FORMAT\_S16\_LE". As it seems i am the only one...
If somone has the same problem please write (here).

Comment by Nils: Jan, as it was some time ago last time this page was
updated I suppose that you probably have your sound working right now.
If not, I think that the solution is to prefix your dmix device (ossmix)
by "plug:" when using it. I have an M-Audio Delta 66 and that works for
me except for the KDE4 multimedia settings configuration (using Phonon
in Fedora 11) as Phonon doesn't seem to add the "plug:" prefix to the
dmix device. I worked-around that problem by creating a .asoundrc file
like this: ` `

    pcm.dmixplug {
      type plug
      slave {
        pcm "dmix"
      }
      hint {
        show on
        description "DMix"
      }
    }

Like that you use this device without the "plug:" prefix: ` `

    aplay -D dmixplug yoursound.wav

Comment by Thomas De Schampheleire: I have a VIA VT82xxx chipset, but I
found that a smaller buffer size in .asoundrc caused XMMS to hang on
high load or IO-transfer (presumably because the buffer has run empty).
Making the buffer size bigger resolved this problem, even above 6653. I
currently have 16384 which works well.

` `

    buffer_size 16384

In XMMS I use ALSA output, with Audio device: "pcm.ossmix", and Mixer
device: PCM.

### 8. Dmixing the Audiophile 192 (ice1724)

You can enjoy dmixed sound at a cool 96khz with this card. Here is my
\~/.asoundrc file

` `

    pcm.!default {
       type plug
       slave.pcm "dmixer"
    }

    pcm.dmixer  {
       type dmix
       ipc_key 1024
       slave {
          pcm "hw:0,0"
          format S32_LE
          period_time 0
          period_size 1024
          buffer_size 8192

          rate 96000
       }
       bindings {
          0 0
          1 1
       }
    }

    ctl.dmixer {
       type hw
       card 0
       device 0
    }
    pcm.dsp {
        type plug
        slave.pcm "dmixer"     # use our new PCM here
    }
    ctl.mixer {
        type hw
        card 0
    }

### Dmixing with Amarok

For some strange reason, in Amarok 1.4.4 you will not be able to use
ALSA as output stream with the Envy24HT chip. To overcome this and yet
still enjoy dmixing. Use the aoss application available from HG

` `

    rsync -avz --delete rsync://alsa.alsa-project.org/hg/alsa-oss .

Then simply start Amarok with "aoss amarok" and choose either ALSA or
Autodetect for the sound output. If you use the \~/.asoundrc file I
provided above, you should be in blue skies for years to come. :)

### Additional Info

Bob Rossi asked and Frank Barknecht responded with some useful hints and
tips from the alsa-user mailing-list.

I am \*really\* interested to see if dmix is right for me. I have been
setting up my sound system in Linux for 2 weeks now. I've got it to the
point where I can play sounds and use the MIC. I really want to get all
of the applications to work without using a sound daemon. I am
frustrated with the documentation regarding dmix and so far, have only
heard that people have not got dmix to do what I want it to. I am hoping
that dmix is the solution to my sound daemon problems. My questions
are...

-   1. *Does dmix get between /dev/dsp and the sound driver to do mixing
    at the software level?*

Well, /dev/dsp is part of the old sound architecture on Unix, that has
been implemented on Linux in the OSS kernel sound driver. ALSA is the
new Linux sound system and it still provides backwards compatible
/dev/dsp devices (as well as the other (OSS devices)? required for
OSSEmulation). ALSA also provides its own devices or PCMs, which can be
extended in various ways that in general are much more flexible than the
OSS layer was. One of these devices is the dmix plugin. It enables sound
mixing even on hardware that doesn't support this directly. BUT: to use
ALSA dmix you have to use software that is ALSA enabled. You cannot use
old OSS software with the ALSA devices, unless you convince this
software to use ALSA instead of OSS. There are mainly two way to achieve
this: 1) rewrite the software or 2) swindle and cheat the software to
let it \*think\* that it uses OSS devices when it is in fact using an
ALSA device. 2 is, what the aoss-library does.

So: No, dmix technically does not get between /dev/dsp and the sound
driver, but aoss gets between the application and the real /dev/dsp and
routes the audio data over to ALSA's dmix.

-   2. *Can I set up my machine so that this happens?*

You should be able to set it up like I described.

-   3. *Will this allow "N" applications to open /dev/dsp, so I can run
    more than one application that produces sound at a time.*

Yes, that's the goal. It already works with a lot of software that
directly uses ALSA. Depending on your needs you might want to take a
look at JACK, too, if you're into low latency inter-application sound
sharing.

-   4. *How do the other /dev/ music devices fit into this?*

With ALSA you shouldn't worry so much about the /dev devices, but more
with the PCM definitions. You don't really need to think in terms of
/dev/snd anymore. Better think in terms of plug devices like
\`\`\`hw:0\`\`\`, default or \`\`\`plughw:surround51.\`\`\`

-   5. *Has anyone ever got this to work?*

See below. It works.

Thanks for the answers, Frank.

* * * * *

Elsewhere on the list Frank suggested and Jaroslav Kysela added...

Normally (without hardware mixing) you cannot use /dev/dsp multiple
times directly. Only ALSA's \`\`\`plug:dmix\`\`\` device supports stream
mixing outside of sound servers. It should be possible to run OSS
applications with the aoss wrapper on dmix, but somehow I couldn't get
this to work yet. It's becoming a FAQ: You must set period size and
buffer size to power of two for the dmix plugin, because OSS API does
not allow other values.

### Getting mplayer to work

-   Note: Newer mplayer releases have a unified "alsa" driver instead of
    "alsa9".
-   Henrik Farre wrote to the alsa-user mailing-list saying: "I just
    want to say GOOD work! I can run xmms, aplay, ogg123 and mplayer at
    the same time." Here is his recipe for success:
    -   xmms 1.2.8, using alsa plugin, user defined output: dmixer
    -   mp layer \`\`\`1.0-pre2:\`\`\` using -ao
        \`\`\`alsa9:dmixer\`\`\`
    -   If dmixer doesn't work with your version of the xmms ALSA output
        plugin, try to specify \`\`\`plug:dmix\`\`\` as the output
        device.

-   Marc Thoben only got mplayer to work by specifying -ao
    \`\`\`alsa9:pcm.dsp0\`\`\`
-   For Helmar it works with:
    -   mplayer -ao \`\`\`alsa9:pcm.ossmix\`\`\`
    -   The xmms alsa 0.9 output plugin user defined to pcm.ossmix and
        mixer device PCM (He uses the above \#6 "The complex approach").

-   Mplayer 1.0pre5 has added a new configuration directive for alsa
    devices. In /etc/mplayer.conf use
    -   ao=alsa
    -   adevice=dsp0 (also using the "complex approach" from above)

-   In Mplayer 1.0pre6 you should use
    \`\`\`ao=alsa:device=plug=dmix\`\`\` in /etc/mplayer.conf to be
    completely independent from OSS emulation.
-   You may ask mplayer to resample sound to suit your dmix samplerate :
    \`\`\`mplayer -af resample=44100\`\`\` or the equivalent config file
    line \`\`\`af=resample=44100:0:2\`\`\`.

Gstreamer and gst-plugins 0.8.2 aren't playing nice with the alsasink
output element. However dmix mixing though esd works for now (with help
from the quick and dirty HOWTO). Using gconf-editor, change osssink to
esdsink in /system/gstreamer/0.8/default/audiosink.

` `

    pcm.!default {
        type plug
        slave.pcm "dmixer"
    }
    pcm.dsp0 {
        type plug
        slave.pcm "dmixer"
    }
    pcm.dmixer {
        type dmix
        ipc_key 1024
        slave {
            pcm "hw:0,0"
            period_time 0
            period_size 1024
            buffer_size 8192
            #periods 128
            rate 44100
         }
         bindings {
            0 0
            1 1
         }
    }
    ctl.mixer0 {
        type hw
        card 0
    }

KDE
---

The easiest way to make KDE notifications work as well, together with
other sound, go to Control Center -\> Sounds & Multimedia -\> System
Notifications -\> Player Settings -\> Use external player. The player
you specify should be able to play different kinds of sounds, e.g. mp3,
wav, ogg, ... I currently use mplayer for this.

Still Hearing Stuttering?
-------------------------

I got pretty serious stuttering on mp3 playback in both amaroK via its
builtin xine support, and JuK? via artsd, but increasing the buffer
sizes in the "slave" block fixed it just fine:

` `

    slave {
        pcm "hw:0,0"
        period_time 0
        buffer_time 0
        period_size 2048 # jm: much smoother than 1024/8192!
        buffer_size 32768
        rate 44100
    }

If this isn't harmful, I'd even go as far as suggesting that it should
be part of the default "complex" example...

Dmix KDE(arts), ESD and SDL quick and dirty HOWTO
-------------------------------------------------

moved to separate page [Dmix Kde - arts, ESD and SDL quick and dirty
HOWTO](/Dmix_Kde_-_arts,_ESD_and_SDL_quick_and_dirty_HOWTO "Dmix Kde - arts, ESD and SDL quick and dirty HOWTO").
Always try to use the 'simple approach' of above. The 'complex approach'
can lead to unexpected behaviour in some applications. The examples of
that approach use card specific information that can be different. So
try the simple approach, and then start playing with the complex.

Gentoo ALSA dmix setup
----------------------

[http://gentoo-wiki.com/HOWTO\_ALSA\_sound\_mixer\_aka\_dmix](http://gentoo-wiki.com/HOWTO_ALSA_sound_mixer_aka_dmix)

Comments
--------

NEEDED: an example situation of how the dmix plugin solution can solve a
problem that would otherwise be difficult or impossible any other way ?

(Csan: For example: using quake3 and teamspeak2 at the same time is
still not possible with snd-intel8x0, ALSA 0.9.8 and .asoundrc set up as
instructed below. Starting up teamspeak with aoss ./teamspeak is fine
but running quake3 using aoss quake3 afterwards still hangs at "sound
initialization" until teamspeak exits.

This is because aoss does not support libc's fopen() call which is
utilized by teamspeak. See aoss page for possible fix. The latest
version of aoss does support fopen. Playing back more music files
simultaneously works, though.) I heard this can be solved by altering
some /proc settings for the OSS playback, check this link:

[http://www.linux-gamers.net/modules/wfsection/article.php?articleid=34](http://www.linux-gamers.net/modules/wfsection/article.php?articleid=34)

Also, TakashiIwai comes to the rescue with a new plugin that lets the
user combine dmix/dsnoop into a single PCM device which can then be used
via the aoss script.. More info when it's finished and in cvs.. It is in
1.0.2 and it's called [asym](/Asym "Asym"). See the page.

Question: I have the setup as shown in \#6 Complex example above, and it
works great so far. Just tested with xmms and alsaplayer and it works
great. How can I get any arbitrary application to work with it? --Dave

Multi -\> Dmix support(?)

From what I can see, one can not send output from the multi-plugin to
the dmix-plugin. This would be convenient, for certain setups. Am I
wrong?

Can alsa input be dmixed? If can't do so, for example in glame:

I use \`\`\`plughw:0,0\`\`\` for input, while default (dmixed) for
output. When I record a music, the input and output didn't co-operate
well, there's from 100ms to 2s delay after I speak something. :-(

In some config examples redefined ctl.!default instead ctl.mixer0.
What's better?

This may be a stupid question, but \_why\_ does the plugin not work
transparently? Since ALSA "gets between" the software and the sound
hardware, should it not be possible to arrange so that everyone who
wants output has it routed through software mixing first? This fiddling
with output devices seems kind of pointless to achieve what ought to be
a very simple goal.

For ALSA 1.0.9rc2 and higher you don't need to setup dmix. Dmix is
enabled as default for soundcard which doesn't support hw mixing.

Does that mean one can drop the "-d plug:dmix" part? Is this supposed to
work?

` `

    alsaplayer -o alsa some.mp3

### dmix & surround sound

I wanted to play a DVD with `xine` through the `dmix` plugin, with all 6
channels, and having other ALSA-aware applications mixed in (regardless
of channel count).

I wrote this in my `/etc/asound.conf`: ` `

    pcm.dmixs51 {
        type dmix
        ipc_key 1024
        ipc_key_add_uid false # let multiple users share
        ipc_perm 0660 # IPC permissions (octal, default 0600)
        slave {
            pcm "hw:0,1" # see below
            rate 48000
            channels 6
            period_time 0
            period_size 1024
            buffer_time 0
            buffer_size 4096
        }
    }

    pcm.asym51 {
               type asym
               playback.pcm "dmixs51" 
               capture.pcm "hw:0,0" # this might be "dsnoop:0"
    }

    pcm.dsp0 {
             type plug
             slave.pcm "asym51"
    }

The `"hw:0,1"` in the `dmixs51` `slave` section is because I have a
C-Media PCI CMI8738-MC6, that uses the second device for surround
output.

Then, I configured `xine` to use `plug:dmixs51` for every output, with
these directives (excerpt from `~/.xine/config`):

` `

    audio.device.alsa_default_device:plug:dmixs51
    audio.device.alsa_front_device:plug:dmixs51
    audio.device.alsa_surround40_device:plug:dmixs51
    audio.device.alsa_surround51_device:plug:dmixs51

I also told `mpd` to use that device (excerpt from `/etc/mpd.conf`):

` `

    ao_driver      "alsa09"
    ao_driver_options   "dev=plug:dmixs51"

The only thing I could not get to work in this setup is Skype, but I
think it is Skype's fault. They say an ALSA-aware version is in the
works, let's just hope.

dakkar

I have mixed the concepts and constructed a .asoundrc which has a
default device upmixing Stereo to 5.1 and then putting it into a 5.1
dmix and then to the snd\_card. Mine works on nForce2. Check it out,
hope it helps. Works perfectly for me with MPlayer, XMMS, xine, aoss
mpg123, etc.:

` `

    ----------- Stereo to 5.1 Upmixing, dmixing .asoundrc ---------------
    pcm.snd_card {
         type hw
         card 0 # change to your cards number or name
    }

    # 6 channel dmix:
    pcm.dmix6 {
         type dmix
            ipc_key 1024
            ipc_key_add_uid false # let multiple users share
            ipc_perm 0660 # IPC permissions (octal, default 0600)
            slave {
                    pcm snd_card # see below
                    rate 48000
                    channels 6
                    period_time 0
                    period_size 1024 # try 2048 against skipping
                    buffer_time 0
                    buffer_size 5120 # in case of problems reduce this
                                     # in case of skipping, try increasing
            }
         }

    # upmixing: 
    pcm.ch51dup {
            type route
            slave.pcm dmix6
            slave.channels 6
            ttable.0.0 1
            ttable.1.1 1
            ttable.0.2 1
            ttable.1.3 1
            ttable.0.4 0.5
            ttable.1.4 0.5
            ttable.0.5 0.5
            ttable.1.5 0.5
       }

    pcm.duplex {
         type asym
         playback.pcm "ch51dup" # upmix first
    #     playback.pcm "dmix6"  # just pass to 6 channel dmix
    #     capture.pcm "dsnoop:0" # doesn't work for me
         capture.pcm "snd_card"
    }

    # change default device:
    pcm.!default {
         type plug
         slave.pcm "duplex"
    }

    # for aoss
    pcm.dsp "duplex"

    pcm.dsp1 "duplex"

DJtm

-- Hi, nice try. But I'm getting only "ALSA lib
pcm\_params.c:2152:(snd\_pcm\_hw\_refine\_slave) Slave PCM not usable".
It's just working, when I use "slave.pcm "surround51"" and do not pass
everything to dmix at the ch51dup section. But this isn't desirable,
isn't it? Since the blocking soundcard problem got not solved, it's only
a workaround for a simplier, but also blocking configuration I had
before. Any suggestions would be welcome; I'm using ALSA 1.0.10-ubuntu4
with a ca0106 chip.

### Dmix Surround7 and more

I needed my soundcard to have different dmixed channels so i could
direct my music player and everything on the desktop to my speakers, and
skype to my headset, and myth-frontend to my TV. Now i have dmixed and
stereo on the channels i need, setup as diffent "sound cards" for each
application to use.

` `

    pcm.hda_intel {
        type hw
        card 0
    }

    pcm.dmixer {
       type dmix
       ipc_key 1099
       ipc_perm 0660
       slave {
           pcm hda_intel
           rate 48000
           channels 8
           periods 128
           period_time 0
           period_size 1024
           buffer_size 4096
       }
    }

    pcm.dsnooper {
       type dsnoop
       ipc_key 1098
       ipc_perm 0660
       slave {
           pcm hda_intel
           rate 44100
           periods 128
           period_time 0
           period_size 1024
           buffer_size 4096
       }
       bindings {
           0 0
           1 1
       }
       slowptr true
    }

    pcm.duplexasym {
       type asym
       playback.pcm "dmixer"  # playback on all speakers
       capture.pcm "dsnooper" # recording 
    }

    pcm.duplex { # plug and play on all speakers
       type plug
       slave.pcm "duplexasym"
    }

    pcm.!default {
       type plug
       slave.pcm "duplexasym"
    }

    ctl.duplex {
       type hw
       card 0
    }

    pcm.headset { # playback only on frontpanel headset
     type route
     slave.pcm dmixer
     slave.channels 8
     ttable.0.0 1 # headphones front L
     ttable.1.1 1 # headphones front R
    }

    pcm.speakers { # playback only on desktop speakers
     type route
     slave.pcm dmixer
     slave.channels 8
     ttable.0.4 1 # speakers L
     ttable.1.5 1 # speakers R
    }

    pcm.TV { # playback only on my TV (using Side)
     type route
     slave.pcm dmixer
     slave.channels 8
     ttable.0.6 1 # TV L
     ttable.1.7 1 # TV R
    }

DocNielsen

### Does dmix affect sound quality?

A question more than a comment: how does dmix affect sound quality? I
use a Chaintech AV710, which uses the snd-ice1724 driver. After it was
set to use dmix by default by an upstream ALSA, I noticed that alsamixer
was showing sample rate 48000 while I was playing back a CD (all CDs are
44100). If I forced it to 44100 with rate locking so nothing could
automatically change it and played the CD, it was obviously wrong (too
slow). This suggests to me that something in the chain is forcing audio
played through dmix to be resampled to 48KHz, which is not optimal for
sound quality. When I commented out the parts of ICE1724.conf that
enable dmix, I found this no longer happens - alsamixer now displays
44100 when I'm playing a CD. So for audio geeks like me who deeply care
about audio quality, is dmix not advisable?

* * * * *

**Answer:**

Dmix by default uses 48kHz sample rate. So, if your source is 44.1kHz,
it will be upsampled to 48khz. If you want pure 44.1kHz output, you
should set the rate parameter:

` `

    pcm.swmixer {
        type dmix
        ipc_key 1234
        slave {
            pcm "hw:0,0" #for ICE1724's analog output
            #pcm "hw:0,1" # for ICE1724's digital output
            #format S32_LE # needed only for ICE1724's digital output.
            period_size 1024
            buffer_size 4096
            rate 44100
        }
    }

Also, you should keep in mind, that software mixing is possible only, if
all signals are at the same sample rate. So, if you want to play DVD's,
which use 48kHz sample rate for audio, with this kind of plug,
everything will be downsampled to 44.1kHz. Unfortunatelly it does'nt
work wery well (there are some syncronization problems with some
players). In this case you have two opportunities, either use a separate
plug (and loose ability to playback mp3 and dvd on the same time) or
tell your DVD player to sample audio down to 44.1khz, for example:

` `

    mplayer -af resample=44100

* * * * *

**Saul**: Also a question more than a comment:

Can dmix be used within a single program to effectively mix different
"voices"? Does its latency permit scheduling with (at least)
single-frame accuracy (e.g., I start VoiceA and wish to setup and
schedule VoiceB to be "added to the mix" at a certain point)? If someone
knows how to do this, some guidance or a nudge in the right direction
would be greatly appreciated.

---

**Answer:** Latency depends on period and buffer size. AFAIK dmix is not
designed as sample-accurate (because it is usually not needed on general
purpose audio system and will make the design quite complex). If you
need sample-accurate and fully syncronized mixer/router, you should
consider using the Jack [http://jackaudio.org/](http://jackaudio.org/).
Large number of Linux audio applications, where sample-accurate mixing
is needed, support Jack.

On the other hand, overall latency of the audio system will still mostly
depend on period size. As small as your period size can be, as low
latecy you will get. Of course, low latency needs good task scheduler in
kernel. If you start getting xruns on low latency audio setup, you
should use some low-latency/realtime kernel patches. I reccomend Ingo
Molnar's realtime preempt
[http://people.redhat.com/mingo/realtime-preempt/](http://people.redhat.com/mingo/realtime-preempt/)
or Con Colivas patch set
[http://members.optusnet.com.au/ckolivas/kernel/](http://members.optusnet.com.au/ckolivas/kernel/).

Retrieved from
"[http://alsa.opensrc.org/Dmix](http://alsa.opensrc.org/Dmix)"

[Categories](/Special:Categories "Special:Categories"): [ALSA
plugins](/Category:ALSA_plugins "Category:ALSA plugins") |
[Configuration](/Category:Configuration "Category:Configuration")

