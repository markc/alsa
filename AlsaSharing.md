AlsaSharing
===========

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Contents
--------

-   [1 Sharing a card among multiple
    processes](#Sharing_a_card_among_multiple_processes)
    -   [1.1 The card supports hardware
        mixing](#The_card_supports_hardware_mixing)
    -   [1.2 The card does not support hardware mixing, but all
        processes accessing it run applications that use the ALSA
        library](#The_card_does_not_support_hardware_mixing.2C_but_all_processes_accessing_it_run_applications_that_use_the_ALSA_library)
    -   [1.3 The applications use a sound server to access the
        card](#The_applications_use_a_sound_server_to_access_the_card)
    -   [1.4 The applications use the OSS API to access the
        card](#The_applications_use_the_OSS_API_to_access_the_card)

-   [2 Examples of ALSA lib configurations to use the software mixing
    plugins](#Examples_of_ALSA_lib_configurations_to_use_the_software_mixing_plugins)
    -   [2.1 Simple output only sharing
        example](#Simple_output_only_sharing_example)
    -   [2.2 Sharing both input and
        output](#Sharing_both_input_and_output)

Sharing a card among multiple processes
---------------------------------------

It is often desirable to be able to share a sound card among several
processes running at the same time. This requires the ability to mix the
sound outputs of those processes into a single stream, that is
multiplexing. In order to achieve this with ALSA there are several
different cases and techniques. The cases depend on whether the sound
card/chipset supports hardware mixing or not, and whether the processes
access the sound card/chipset via the ALSA library, a sound server or
OSS emulation.

In the beginning, OSS often did not support sharing even if it was
supported by the hardware. ALSA drivers, as a rule, will support sharing
if the hardware supports it. The ALSA library supports sharing even if
the hardware does not support it, but this requires some explicit
configuration. For applications that use OSS, the [aoss](/Aoss "Aoss")
wrapper can make them use ALSA instead, which improves things. Finally
applications that use sound servers like
[esound](?title=Esound&action=edit&redlink=1 "Esound (page does not exist)")
or
[aRTS](?title=ARTS&action=edit&redlink=1 "ARTS (page does not exist)"),
most sound servers perform software mixing and support ALSA output. The
individual cases are:

-   The card supports hardware mixing
-   The card does not support hardware mixing, but all processes
    accessing it run applications that use the ALSA library
-   The applications use a sound server to access the card
-   The applications use the OSS API to access the card

### The card supports hardware mixing

This is the best case. Most recent cards support hardware mixing, at
least for output, and when they do they support it to up to a maximum
number of streams that is so high that it is unlikely to be ever a
problem. If you can, the simplest way to ensure sharing is to get a card
that supports hardware mixing. Sound cards are cheap, often costing less
than the time to implement workarounds.

### The card does not support hardware mixing, but all processes accessing it run applications that use the ALSA library

In this case, it is fairly easy to create an ALSA library configuration
file (see the [.asoundrc](/.asoundrc ".asoundrc") section) that allows
software mixing. This is achieved using the "dmix" (for output) and
"dsnoop" (for input) plugins, and "asym" to tie them together. The
plugins are described in the [DmixPlugin](/DmixPlugin "DmixPlugin"),
[dsnoop](/Dsnoop "Dsnoop") and [asym](/Asym "Asym") sections, and look
for an example below.

Another way to do it is to use [JACKPlugin](/JACKPlugin "JACKPlugin")
and let [JACK](/JACK "JACK") do the mixing.

### The applications use a sound server to access the card

Sound servers were mainly created to premix multiple streams for OSS,
where even cards that supported hardware mixing did not support
multiplexing. If your system runs a sound servers like "esound" for
GNOME or "aRTS" for KDE, set the sound server to use ALSA as its output,
and applications to use the sound server. For KDE artsd problems see
[this
page](http://people.debian.org/~terpstra/message/20030626.141149.656eb2e9.html).
Try running: ` artsdsp mpg123 mysong.mp3`

### The applications use the OSS API to access the card

Some applications cannot use ALSA or a sound server, but only the OSS
API. In that case you can often make them use ALSA using the
[aoss](/Aoss "Aoss") wrapper. Also check the
[OssEmulation](/OssEmulation "OssEmulation") section. Also check
carefully the description of non blocking options on this page at the
[official ALSA site](http://alsa-project.org/~iwai/OSS-Emulation.html).

* * * * *

Examples of ALSA lib configurations to use the software mixing plugins
----------------------------------------------------------------------

### Simple output only sharing example

` `

    pcm.dmix0 {
        type dmix
        ipc_key 673138
    #   ipc_key_add_uid false   # let multiple users share
    #   ipc_perm 0666           # IPC permissions for multi-user sharing (octal, default 0600)
        slave {
            pcm "hw:0,0"
            rate 48000
            period_time 80000
            buffer_time 320000
            period_size 4096
            buffer_size 16384
        }
        bindings {
            0 0
            1 1
        }
    }
    # 'dsp0' is espected by OSS emulation etc.
    pcm.dsp0 {
        type plug
        slave.pcm "dmix0"
    }
    ctl.dsp0 {
        type hw
        card 0
    }
    pcm.!default {
        type plug
        slave.pcm "dmix0"
    }
    ctl.!default {
        type hw
        card 0
    }

### Sharing both input and output

` `

    pcm.card0 {
        type hw
        card 0
    # mmap_emulation true
    }
    pcm.dmix0 {
        type dmix 
        ipc_key 34521 
        slave {
            pcm "card0" 
        }
    }
    pcm.dsnoop0 {
        type dsnoop 
        ipc_key 34523
        slave {
            pcm "card0" 
        }
    }
    pcm.asym0 {
        type asym 
        playback.pcm "dmix0" 
        capture.pcm "dsnoop0"
    }
    pcm.pasym0 {
        type plug 
        slave.pcm "asym0"
    }
    # 'dsp0' is espected by OSS emulation etc.
    pcm.dsp0 {
        type plug
        slave.pcm "asym0"
    }
    ctl.dsp0 {
        type hw
        card 0
    }
    pcm.!default {
        type plug
        slave.pcm "asym0"
    }
    ctl.!default {
        type hw
        card 0
    }

This defines a virtual ALSA PCM device called *asym0*. This device is
capable of mixing several playback streams and sharing one capture
stream amongst several applications. To get automatic samplerate
conversion, etc, we defined the device *pasym0* which uses alsa's plug
plugin. Furthermore we defined a device called *!default*. This is
equivalent to *pasym0*. The special name *!default* makes this device
the default device for all well coded ALSA apps (sadly not too many are
well coded). And last we defined a device called *dsp0*. This device is
used by the [aoss](/Aoss "Aoss") script from the *alsa-oss* package.
First of all we test this basic setup with the standard ALSA *aplay*
tool. You will need a *.wav* file for this test. If you have none,
create one out of an *MP3* with the following command:

` `

    mpg123 file.mp3 -w file.wav

With this *.wav* file we test the *pasym0* device now:

` `

    aplay -D pasym0 file.wav

This should playback the *.wav*. Even if you run this command in a
second terminal at the same time, because the *pasym0* device does the
mixing. Because we also defined the default alsa device *!default* to
use *asym0*, you should also be able to run the command without the *-D
pasym0* parameter:

` `

    aplay file.wav

Not all apps honour the default device though.
[mplayer](http://WWW.MPlayer.org) for example is one of them. To test
this setup with mplayer use:

` `

    mplayer -ao alsa1x:pasym0 file.avi

So, now is the time to test all your desired alsa apps to work with this
setup.

-   Some will need to be told explicitly to use *pasym0*.
-   Others will happily use the default.

If some alsa apps behave badly with *pasym0* (crackles, stutter), check
the old [DmixPlugin](/DmixPlugin "DmixPlugin") page. It has quite a bit
of troubleshooting. Tips: look at the samplerates of the slave, maybe
play with the *period\_size* parameter, etc.; in particular many cards
have limits on the *period\_size*, usually to 4096 bytes. Some apps use
mmap'ed audio data transfer. If your app complains about not being able
to use mmap, then play around with the "mmap\_emulation" setting in the
"pcm.card0" definition.

Retrieved from
"[http://alsa.opensrc.org/AlsaSharing](http://alsa.opensrc.org/AlsaSharing)"

[Categories](/Special:Categories "Special:Categories"):
[Howto](/Category:Howto "Category:Howto") |
[Configuration](/Category:Configuration "Category:Configuration")

