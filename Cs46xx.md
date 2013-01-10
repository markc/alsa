Cs46xx
======

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

For games like quake3, support of OSS mmap is available through the
module option mmap\_valid=1. To set this in modules.conf, add the line
"options snd-cs46xx mmap\_valid=1", or for modprobe/insmod, append it to
the end of the command (eg., "modprobe snd-cs46xx mmap\_valid=1)

Digital in/out has been developed, and is known to function on the
following:

-   BlackGold II 5.1 Family: optical in/out, coaxial out, rear-out
-   Hercules Game Theater: optical in/out, coaxial out, rear-out
-   Hercules Gamesurround Fortissimo III: optical in/out, rear-out
-   Terratec DMX XFire 1024: optical in/out
-   Turtle Beach Santa Cruz: coaxial out, rear-out
-   VideoLogic Sonic Fury: coaxial out, rear-out

Dolby Digital and DTS passthrough works with most (all?) cards using
alsa-driver 0.9.1. Multichannel PCM has been integrated, and should work
on all cs46xx based cards. Basically, the chip can be opened up to 31
times for output, without a daemon like ESD or artsd. (Is there an
example somewhere for getting this to work with standard applications?
e.g. XMMS?) ([Addition by Reader] I got it to work nicely. I play
UnrealTournament while at the same time listening to mp3's with xmms and
playing a movie with mplayer) ([Addition by Wawrzek] - It works for me
too. I have IBM ThinkPad T21). It basically works automatically - try
just opening xmms, playing something, and then just doing 'aplay
bla.wav'. Note that with alsa in kernel 2.6, you need to enable
CONFIG\_SND\_CS46XX\_NEW\_DSP=y - this is experimental (I don't know why
- seems to work just fine), so it may be hidden in your kernel config if
you don't specify CONFIG\_EXPERIMENTAL=y as well.

Contents
--------

-   [1 Midiman DMAN](#Midiman_DMAN)
-   [2 BlackGold II 5.1 Family](#BlackGold_II_5.1_Family)
-   [3 Hercules Gamesurround Fortissimo
    II](#Hercules_Gamesurround_Fortissimo_II)
-   [4 Turtle Beach Santa Cruz](#Turtle_Beach_Santa_Cruz)
-   [5 Terratec DMX XFire 1024](#Terratec_DMX_XFire_1024)

Midiman DMAN
------------

If you find you can't record with this card, open up the alsamixer and
set the following 3 channels to "capture": LINE, CAPTURE, and ADC. You
of course have to unmute and set levels, but it takes all 3 of these
channels set to capture mode in order to record on the Midiman DMAN.

BlackGold II 5.1 Family
-----------------------

**Value,Value Plus,Value Fine,Cannon** -- Use the same settings for
recording as with the above (Midiman DMAN) to record audio using this
card (cs4630 chip),codec using stac9750T/66T/56T and cs4294.

Hercules Gamesurround Fortissimo II
-----------------------------------

Use the same settings for recording as with the above (Midiman DMAN) to
record audio using this card (cs4624 chip).

Turtle Beach Santa Cruz
-----------------------

This is a good sound card, and it works great with ALSA, except one
thing: The sound-card does not automatically mirror the Front channel to
the Rear - so stereo sounds (the majority of them) just stay stereo.
This can be gotten around using the asoundrc. As with the Midiman DMAN
above, to record from the input jack on this card you have to set all of
LINE, CAPTURE and ADC to Captur(e), unmute all three, and set levels
appropriately. On my system at least, alsamixer detects two CAPTURE
channels. The leftmost one was the one that I had to adjust to get
recording to work. Looking for information on mirroring output to the
front channels so that it is also played from the rear channels
simultaneously (simulated surround, otherwise playing to the Front
device will only output on the front, leaving the rear silent).

NOTE: as of ALSA 1.0.8, you MUST enable the "External Amplifier" in the
mixer, or you will end up with no sound. This was apparently only
implemented in this version, though the mixer channel has been there
since before 1.0. Since it defaults to "Off", upgrading from an older
vesion to 1.0.8 (or to the 2.6.11 kernel) will leave you with no sound
unless you "unmute" (turn "On") this switch.

Terratec DMX XFire 1024
-----------------------

The sound driver works very good except for one thing. Sometimes under
heavy load switching the capture device distorts he captured sound until
capture is turned off and on once again. Frequency: seldom, once a day
when doing lots of audio stuff. The driver supports harware mixing so i
can use xmms and mplayer and whatnot at the same time, when it has
alsa-support.

Here's my experiences using this driver with the jack-audio-connection
kit. The terratec sound card driver seemingly allows [when starting jack
with *jackd -d alsa -d hw:0 -p PERIODSIZE -n PERIODS*]:

` `

       period sizes: 64, 128, 512
       Number of periods: 2 .. 32

so the default settings of jack don't work. When starting jackd as non
root, reliable xrun free operation is possible only with large buffers.
When starting jackd with

` `

       jackd -d alsa -d hw:0 -p 512 -n 32

realtime softsynths have too much latency with this setting, but it is
still suited for using jackd just as a sound daemon and for basic
hd-recorders that use jack. Of course 32 periods don't make sense,
really, because interrupts are always generated at period boundaries..
So, a setting like:

` `

       jackd -d alsa -d hw:0 -p 512 -n 4

should be ok, too. When using a patched kernel (low-latency patches and
capabilities enabled), it is possible to use jack with

` `

       jackstart -R -d alsa -d hw:0 -p 64 -n 3

or even with 2 periods for use with software synths like amSynth or
funny tools like freqtweak.

Retrieved from
"[http://alsa.opensrc.org/Cs46xx](http://alsa.opensrc.org/Cs46xx)"

[Category](/Special:Categories "Special:Categories"): [ALSA
modules](/Category:ALSA_modules "Category:ALSA modules")

