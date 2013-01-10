Ecasound
========

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Ecasound is a software package designed for multitrack audio processing.
It can be used for simple tasks like audio playback, recording and
format conversions, as well as for multitrack effect processing, mixing,
recording and signal recycling. Ecasound supports a wide range of audio
inputs, outputs and effect algorithms. Effects and audio objects can be
combined in various ways, and their parameters can be controlled by
operator objects like oscillators and MIDI-CCs.

Ecasound's homepage is at from
[http://www.eca.cx/ecasound/](http://www.eca.cx/ecasound/) and the above
description is taken from there.

A handy magic incantation for testing if jackd and ALSA are working
might be:

` `

    jackd -d alsa -d via -s & \
    ecasound -f s16_le,2,48000 -i XXX.ogg -o jack_alsa jackd -d alsa -d card0 -s & \
    ecasound -i resample,auto,XXX.ogg -o jack_alsa

You'll need to have a test sound file for it to play. In the above
example this is *XXX.ogg*.

Retrieved from
"[http://alsa.opensrc.org/Ecasound](http://alsa.opensrc.org/Ecasound)"

[Category](/Special:Categories "Special:Categories"):
[Software](/Category:Software "Category:Software")

