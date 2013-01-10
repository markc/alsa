FedoraCore
==========

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

2005-02-08
----------

I could not get 5.1 sound via USB audio working on Fedora Core 3 until I
added this to [.asoundrc](/.asoundrc ".asoundrc"). I would get errors
from apps saying no way to convert 2 to 6 channels. Fedora Core 3 needed
the part about surround51.

` `

    pcm.!default
    {
        type plug
        slave sl
    }
    ctl.!default
    {
        type hw
        card 0
    }
    pcm.ch51dup {
        type route
        slave.pcm surround51
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
    pcm_slave.sl {
        pcm "hw:0,0"
    }
    cards.pcm.surround51 {
        type plug
        slave sl
    }

2005-02-04
----------

I installed FC3 from scratch and got no sound through my Audiophile 2496
card. I fixed this by running alsamixer from a terminal and settin the
following:

` `

    IEC958   : H/W In 0
    IEC958 M : 100%
    IEC958 M : 100%
    IEC958 I : PCM Out
    DAC      : 100%
    DAC 1    : 100%
    Deemphasis  Off
    H/W      : PCM Out
    H/W 1    : PCM/Out

Xmms still wont play using my ALSA drivers though, I have to switch to
OSS on the preferences. For xmms try to disable mmap mode.

*Are you using the xmms-alsa output plugin ?*

Retrieved from
"[http://alsa.opensrc.org/FedoraCore](http://alsa.opensrc.org/FedoraCore)"

[Category](/Special:Categories "Special:Categories"):
[Howto](/Category:Howto "Category:Howto")

