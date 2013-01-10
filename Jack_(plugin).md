Jack (plugin)
=============

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

In short, you can set up your [asoundrc](/Asoundrc "Asoundrc") file to
specify [JACK](/JACK "JACK") as the output, like so:

` `

    pcm.!default {
        type plug
        slave { pcm "jack" }
    }

    pcm.jack {
        type jack
        playback_ports {
            0 alsa_pcm:playback_1
            1 alsa_pcm:playback_2
        }
        capture_ports {
            0 alsa_pcm:capture_1
            1 alsa_pcm:capture_2
        }
    }

    ctl.mixer0 {
        type hw
        card 0
    }

Then, after starting jackd with the appropriate sample rate for what
you're doing, you can use ALSA apps with JACK:

` `

      jackd -d alsa -d hw:0 -r 44100
      aplay -D pcm.jack <filename>

This will direct the ALSA playback stream (from aplay) visible to your
JACK application, rather than sending it directly to the sound card.

\

Non-ALSA JACK audio I/O (e.g. FreeBOB)
--------------------------------------

If `jackd` is using an audio driver other than ALSA (as in FreeBOB, for
example), the port names in the `pcm.jack` definition will be different
from the example above. With `jackd` running, run `jack_lsp` to find out
the port names, for example:

` `

    $ jack_lsp 
    system:capture_1
    system:capture_2
    system:capture_3
    system:capture_4
    system:capture_5
    system:capture_6
    system:playback_1
    system:playback_2
    system:playback_3
    system:playback_4
    system:playback_5
    system:playback_6
    system:playback_7
    system:playback_8

You can then use the appropriate port names in your `.asoundrc`, e.g.

` `

    pcm.jack {
         type jack
         playback_ports {
             0 system:playback_1
             1 system:playback_2
         }
         capture_ports {
             0 system:capture_1
             1 system:capture_2
         }
     }

Retrieved from
"[http://alsa.opensrc.org/Jack\_(plugin)](http://alsa.opensrc.org/Jack_(plugin))"

[Category](/Special:Categories "Special:Categories"): [ALSA
plugins](/Category:ALSA_plugins "Category:ALSA plugins")

