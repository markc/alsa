Default device from environment variable
========================================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

I wanted to use the
[upmix\_20to51](/Low-pass_filter_for_subwoofer_channel_(HOWTO) "Low-pass filter for subwoofer channel (HOWTO)")
with a music player that would not let me tell it what ALSA PCM I wanted
it to play through. At the same time, I wanted the normal default PCM to
be a [5.1 channel asym dmix pcm](/Dmix "Dmix"). Here's what I came up
with:

` `

    pcm.!default {
        @func refer
        name { @func concat 
               strings [ "pcm."
                         { @func getenv
                           vars [ ALSA_DEFAULT_PCM ]
                           default "pulse"
                         }
               ]
             }
    }

    ctl.!default {
        @func refer
        name { @func concat 
               strings [ "ctl."
                         { @func getenv
                           vars [ ALSA_DEFAULT_CTL
                                  ALSA_DEFAULT_PCM
                           ]
                           default "pulse"
                         }
               ]
             }
    }

    pcm.pulse { type pulse }
    ctl.pulse { type pulse }

A *pulse* type PCM is for the [PulseAudio](http://www.pulseaudio.org)
sound server. I have it configured, via `/etc/pulse/default.pa`, to use
the asym51 PCM as it's source and sink. I have modified the
configuration for the upmix\_21to51 PCM, the final one in the upmix
chain, so that it's slave PCM is dmix51 rather than hw:0. (All of my
PCM's end at that dmix51, so the hardware can be shared among them.)

With the above in my `.asoundrc`, I can run
[Exaile](http://www.exaile.org/) like this:

` `

    env ALSA_DEFAULT_PCM=upmix_20to51 exaile

... and **it totally rocks**! MythTV sounds great that way also.

\

--[KarlHeg](?title=User:KarlHeg&action=edit&redlink=1 "User:KarlHeg (page does not exist)")
10:15, 4 May 2007 (EST)

Retrieved from
"[http://alsa.opensrc.org/Default\_device\_from\_environment\_variable](http://alsa.opensrc.org/Default_device_from_environment_variable)"

[Category](/Special:Categories "Special:Categories"):
[Howto](/Category:Howto "Category:Howto")

