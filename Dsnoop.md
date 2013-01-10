Dsnoop
======

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

dsnoop is the equivalent of the [dmix](/DmixPlugin "DmixPlugin") plugin,
but for recording sound. The dsnoop plugin allows several applications
to record from the same device simultaneously.

\

Contents
--------

-   [1 The dsnoop howto](#The_dsnoop_howto)
    -   [1.1 Default Alsa interface](#Default_Alsa_interface)
        -   [1.1.1 Is dsnoop available?](#Is_dsnoop_available.3F)
        -   [1.1.2 Recording from the default dsnoop
            interface](#Recording_from_the_default_dsnoop_interface)

    -   [1.2 Writing a custom dsnoop
        interface](#Writing_a_custom_dsnoop_interface)
        -   [1.2.1 Basic syntax](#Basic_syntax)
        -   [1.2.2 Choosing recording rates](#Choosing_recording_rates)
        -   [1.2.3 Recording from left or right
            channel](#Recording_from_left_or_right_channel)

The dsnoop howto
================

Default Alsa interface
----------------------

By default, Alsa provides a dsnoop interface.

### Is dsnoop available?

Normally, when using a recent system, dsnoop should be available. To
list the available devices, enter:

` arecord -L`

Normally, dsnoop should be part of the available devices, and you should
read a line including the following information: ` `

    dsnoop 'cards.pcm.dsnoop'

### Recording from the default dsnoop interface

If dsnoop is here, let us use it. Plug a sound source (microphone,
line-in) into your sound device, run [amixer](/Amixer "Amixer") to
select the correct input source and type:

` arecord -f cd -c 2 -D dsnoop foobar.wav` This will record from the
dsnoop interface at CD quality level.

Writing a custom dsnoop interface
---------------------------------

### Basic syntax

The syntax is almost identical to the [dmix](/DmixPlugin "DmixPlugin")
plugin: ` `

    pcm.dsnooped {
        type dsnoop
        slave {
            pcm "hw:0,0" 
            channels 2 
        }
    }

### Choosing recording rates

You may also define custom recording rates: ` `

    pcm.dsnooped {
        type dsnoop
        slave {
            pcm "hw:0,0" 
            channels 2 
            period_size 1024
            buffer_size 4096
            rate 48000
            periods 0 
            period_time 0
        }
    }

In this example, the sound is recorded at 48000 Hz.

If the soundcard does not support the requested rate, the sound is
converted at software level.

### Recording from left or right channel

It may be sometimes interesting to record (in mono) from left or right
channel of a stereo sound.

For example, the [Edirol UA-25](/Edirol_UA-25 "Edirol UA-25") audio
device has *two* mono microphones inputs, which are combined into a
*stereo* (right/left) sound during recording. Whenever you record your
voice using one mono microphone, the output is stereo, with a blanck
channel being degraded by noise.

Some software may be able to transform the stereo sound into a mono
sound, mixing the recorded voice (first channel) with noise (second
channel), thus degrading sound quality.

Thanks to the dsnoop [plugin](/ALSA_plugins "ALSA plugins"), it is
possible to overcome this problem.

Let us define two virtual dsnoop interfaces, for left and right channel:
` `

    pcm.record_left {
        type dsnoop
        ipc_key 234884
        slave {
            pcm "hw:0,0"
            channels 2
        }
        bindings.0  0
    }
    pcm.record_right {
        type dsnoop
        ipc_key 2241234
        slave {
            pcm "hw:0,0"
            channels 2
        }    
        bindings.0  1
    } 

Now, you can record from the left channel using the following command:
` `

     arecord -f cd -c 1 -D record_left foobar.wav

Your sound is now **pure mono**, not *fake mono* downmixed from a stereo
sound.

* * * * *

See [.asoundrc](/.asoundrc ".asoundrc") for docs and config examples for
pcm plugins. Also see the [alsa-lib](/Alsa-lib "Alsa-lib") page.

Retrieved from
"[http://alsa.opensrc.org/Dsnoop](http://alsa.opensrc.org/Dsnoop)"

[Category](/Special:Categories "Special:Categories"): [ALSA
plugins](/Category:ALSA_plugins "Category:ALSA plugins")

