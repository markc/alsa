SquisherAsoundRc
================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

squisher's .asoundrc
--------------------

` `

    # 2008-02-17: 8-channel card required
    #
    # This .asoundrc will allow the following:
    #
    # - upmix stereo files to 5.1 speakers.
    # - playback real 5.1 sounds, on 5.1 speakers,
    # - allow the playback of both stere(oupmixed) and surround(5.1) sources at the same time.
    # - use the 6th and 7th channel (side speakers) as a separate soundcard, i.e. for headphones
    #   (This is called the "alternate" output throughout the file, device names prefixed with 'a')
    # - play mono sources in stereo (like skype & ekiga) on the alterate output
    #
    # Make sure you have "8 Channels" and NOT "6 Channels" selected in alsamixer!
    # This file was tested on an nforce board with realtek alc888 chipset, but should work on
    # any 8-channel card. Read through the comments if you have a different soundcard though!
    #
    # Please try the following commands, to make sure everything is working as it should.
    #
    # To test stereo upmix :      speaker-test -c2 -Ddefault -twav
    # To test surround(5.1):      speaker-test -c6 -Dplug:dmix6 -twav
    # To test alternative output: speaker-test -c2 -Daduplex -twav
    # To test mono upmix:         speaker-test -c1 -Dmonoduplex -twav
    #
    #
    # It may not work out of the box for all cards. If it doesnt work for you, read the comments throughout the file.
    # The basis of this file was written by wishie of #alsa, and then modified with info from various sources by 
    # squisher.

    #Define the soundcard to use
    pcm.snd_card {
        type hw
        card 0
        device 0
    }

    # 8 channel dmix - output whatever audio, to all 8 speakers
    pcm.dmix8 {
        type dmix
        ipc_key 1024
        ipc_key_add_uid false
        ipc_perm 0660
        slave {
            pcm "snd_card"
            rate 48000
            channels 8
            period_time 0
            period_size 1024
            buffer_time 0
            buffer_size 5120
        }

    # Some cards, like the "nforce" variants require the following to be uncommented. It routes the audio to t he correct speakers.
        bindings {
            0 0
            1 1
            2 4
            3 5
            4 2
            5 3
            6 6
            7 7
        }
    }

    # upmixing - duplicate stereo data to all 6 channels
    pcm.ch51dup {
        type route
        slave.pcm dmix8
        slave.channels 8
        ttable.0.0 1
        ttable.1.1 1
        ttable.0.2 1
        ttable.1.3 1
        ttable.0.4 0.5
        ttable.1.4 0.5
        ttable.0.5 0.5
        ttable.1.5 0.5
    }

    # this creates a six channel soundcard
    # and outputs to the eight channel one
    # i.e. for usage in mplayer I had to define in ~/.mplayer/config:
    #   ao=alsa:device=dmix6
    #   channels=6
    pcm.dmix6 {
        type route
        slave.pcm dmix8
        slave.channels 8
        ttable.0.0 1
        ttable.1.1 1
        ttable.2.2 1
        ttable.3.3 1
        ttable.4.4 1
        ttable.5.5 1
    }

    # rate conversion, needed i.e. for wine
    pcm.2chplug {
        type plug
        slave.pcm "ch51dup"
    }
    pcm.a2chplug {
        type plug
        slave.pcm "dmix8"
    }

    # routes the channel for the alternative
    # 2 channel output, which becomes the 7th and 8th channel 
    # on the real soundcard
    pcm.alt2ch {
        type route
        slave.pcm "a2chplug"
        slave.channels 8
        ttable.0.6    1
        ttable.1.7    1
    }

    # skype and ekiga are only mono, so route left channel to the right channel
    # note: this gets routed to the alternative 2 channels
    pcm.mono_playback {
        type route
        slave.pcm "a2chplug"
        slave.channels 8
        # Send Skype channel 0 to the L and R speakers at full volume
        ttable.0.6    1
        ttable.0.7    1
    }

    # 'full-duplex' device for use with aoss
    pcm.duplex {
        type asym
        playback.pcm "2chplug"
        capture.pcm "hw:0"
    }

    pcm.aduplex {
        type asym
        playback.pcm "alt2ch"
        capture.pcm "hw:0"
    }

    pcm.monoduplex {
        type asym
        playback.pcm "mono_playback"
        capture.pcm "hw:0"
    }

    # for aoss
    pcm.dsp0 "duplex"
    ctl.mixer0 "duplex"

    # softvol manages volume in alsa
    # on my card wine needs the softvol to work
    pcm.mainvol {
        type softvol
        slave.pcm "duplex"
        control {
            name "2ch-Upmix Master"
            card 0
        }
    }

    #pcm.!default "mainvol"

    # set the default device according to the environment
    # variable ALSA_DEFAULT_PCM and default to mainvol
    # this is needed for ekiga, if you want to use the
    # alternative output, as pwlib (ekiga's backend) doesn't
    # support asoundrcs directly.
    # Instead run: 'ALSA_DEFAULT_PCM=monoduplex ekiga'
    pcm.!default {
        @func refer
        name { @func concat 
               strings [ "pcm."
                         { @func getenv
                           vars [ ALSA_DEFAULT_PCM ]
                           default "mainvol"
                         }
               ]
             }
    }

    # uncomment the following if you want to be able to control
    # the mixer device through environment variables as well
    #ctl.!default {
    #    @func refer
    #    name { @func concat 
    #           strings [ "ctl."
    #                     { @func getenv
    #                       vars [ ALSA_DEFAULT_CTL
    #                              ALSA_DEFAULT_PCM
    #                       ]
    #                       default "duplex"
    #                     }
    #           ]
    #         }
    #}

An updated version might be found at
[http://da.mcbf.net/wiki/DotAsoundrc](http://da.mcbf.net/wiki/DotAsoundrc)
.

Retrieved from
"[http://alsa.opensrc.org/SquisherAsoundRc](http://alsa.opensrc.org/SquisherAsoundRc)"

