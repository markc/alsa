Record from pcm
===============

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Say you are playing a movie with mplayer, or some other application
that's using alsa output, and you wish to record a sample of what you're
hearing. The following should do the trick.

To record sound that is playing from another application use the 'Mix'
device as the capture device:

`amixer set 'Mix' cap`

Some cards have a seperate 'Capture' device that needs to be activated
for capture and set to a non-zero volume (It's value seems to be an
input gain?).

`amixer set 'Capture' cap`

`amixer set 'Capture' 10%`

The percentage on the 'Capture' device should be raised or lowered to
taste. You could also use [alsamixer](/Alsamixer "Alsamixer") and your
spacebar to select your capture device.

Now you should be able to record what's currently playing through your
soundcard with:

`arecord -t wav -f cd test.wav`

The latest version of [Audacity](/Audacity "Audacity") now has alsa
support and can record from the Mix device.

Retrieved from
"[http://alsa.opensrc.org/Record\_from\_pcm](http://alsa.opensrc.org/Record_from_pcm)"

[Category](/Special:Categories "Special:Categories"):
[Howto](/Category:Howto "Category:Howto")

