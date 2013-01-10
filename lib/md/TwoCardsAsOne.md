TwoCardsAsOne
=============

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Contents
--------

-   [1 From the Linux Audio Devel mailing
    list](#From_the_Linux_Audio_Devel_mailing_list)
-   [2 Notes](#Notes)
-   [3 Hardware mod](#Hardware_mod)
-   [4 Multiple ice1712](#Multiple_ice1712)

From the Linux Audio Devel mailing list
---------------------------------------

Message posted to
[LinuxAudioDevel](?title=LinuxAudioDevel&action=edit&redlink=1 "LinuxAudioDevel (page does not exist)")
by [Joern
Nettingsmeier](/User:JoernNettingsmeier "User:JoernNettingsmeier"):

Richard Guenther asked: *I'd like to create a virtual 2-(stereo)-channel
alsa device from one ISA SB AWE and one on-board VIA alsa device. Has
anyone figured out how to do this using
[.asoundrc](/.asoundrc ".asoundrc") magic? (I know Jaroslav knows and
told Joern, but I think this is of greater interest) Joern/Jaroslav, can
you post a quick howto on this topic? Preferrably including some
[.asoundrc](/.asoundrc ".asoundrc") quoting...*

Just to clarify, this will not create the mythical "multi-channel
soundcard out of el-cheapo consumer cards". You will drift out of sync
over time unless a hardware syncing mechanism like
[wordclock](/Wordclock "Wordclock") is in place.

Still, it is sometimes helpful to make applications see one 4channel
card to allow for flexible routing if they can't easily be made to talk
to multiple cards ( [jack](/Jack "Jack") being one example). Here's how
you do it (thanks to jaroslav and takashi for explaining it to me).
Here's an [.asoundrc](/.asoundrc ".asoundrc") example...

Create a virtual four-channel device with two soundcards: IIUC, this is
in fact two interleaved stereo streams in different memory locations, so
[jack](/Jack "Jack") will complain that it cannot get mmap-based access.
See below.

` `

    pcm.multi {
        type multi;
        slaves.a.pcm "hw:0,0";
        slaves.a.channels 2;
        slaves.b.pcm "hw:1,0";
        slaves.b.channels 2;
        bindings.0.slave a;
        bindings.0.channel 0;
        bindings.1.slave a;
        bindings.1.channel 1;
        bindings.2.slave b;
        bindings.2.channel 0;
        bindings.3.slave b;
        bindings.3.channel 1;
    }

I do not really understand what it means to have a ctl interface to a
multi device, but [jack](/Jack "Jack") will be unhappy if there is no
mixer to talk to, so we set this to card 0.

` `

    ctl.multi {
        type hw;
        card 0;
    }

This creates a 4channel interleaved pcm stream based on the multi
device, [jack](/Jack "Jack") will work with this one...

` `

    pcm.ttable {
        type route;
        slave.pcm "multi";
        ttable.0.0 1;
        ttable.1.1 1;
        ttable.2.2 1;
        ttable.3.3 1;
    }
    ctl.ttable {
        type hw;
        card 0;
    }

A syntax description is in [ALSA lib
config](http://alsa-project.org/alsa-doc/alsa-lib/conf.html). The
available plugins (i.e. the "type" entries) are described in the doxygen
docs at
[pcm\_plugins](http://alsa-project.org/alsa-doc/alsa-lib/pcm_plugins.html).
It seems there is now also a LADSPA plugin plugin :) I have not tried it
yet, but it looks interesting. To test the above setting, I feed a
signal to both soundcards, play it back and listen to it via with my
external mixer:

` `

    arecord -f cd -D multi -c 4 | aplay -D multi

This will give you loads of xruns, but it's probably ok for testing. To
start [jack](/Jack "Jack") with the new device, use:

` `

    jackd [-a] -R [-v] -d alsa -d ttable [-p 1024]

I hope I got it right... the settings Work For Me (tm), although I can't
get [ardour](/Ardour "Ardour") to record from the device, but then I
can't get it to record at all at the moment. [jack](/Jack "Jack") starts
ok, though.

Notes
-----

**WARNING NOTE added by LudwigSchwardt:** (comments welcome!)

Be careful when using this scheme for **capturing** (recording) audio
data. It might work with multiple sample-synchronized cards (i.e.
Hammerfall/ICE1712) that have a single sample clock signal driving all
of them, or when the dummy soundcard is combined with another soundcard
for testing. It will definitely fail when combining two or more unlinked
soundcards. When using [JACK](/JACK "JACK"), I typically got an error
message of

**snd\_pcm\_mmap\_commit: Assertion \`frames \<=
snd\_pcm\_mmap\_avail(pcm)' failed**

and jackd hangs in the process. This error may take a while to pop up,
but it is inevitable, since this is a basic hardware limitation.

Each soundcard has its own sample clock. If these aren't linked to the
same clock in some way (eg. [wordclock](/Wordclock "Wordclock")), the
clock frequencies will differ, sometimes substantially, due to
manufacturing tolerances on the crystals, etc. This means that the
hardware interrupts announcing the availability of new data will be out
of sync. Even worse, the cards with faster clocks will produce more data
than the slower cards during the same time interval. Therefore, even if
a program like [JACK](/JACK "JACK") waited until all the soundcards had
audio data available and then presented this data to its callback, at
some stage data from the soundcard with a faster sample clock will have
to be discarded to keep up with the rest. At the very least
[xruns](/Xruns "Xruns") will occur.

It might be possible to write a software layer (ALSA driver/plugin?) to
hide the clock differences by effectively resampling the streams to a
common frequency. This will be the only way to keep programs like
[JACK](/JACK "JACK") completely happy. As this will inevitably involve
the discarding and/or generation of samples, it is still not a pretty
solution. It will probably also increase the latency of the system.

On the other hand, this [.asoundrc](/.asoundrc ".asoundrc") trick seems
to work OK for **playback**. During playback, programs dump audio data
into soundcard buffers and let the hardware decide when the data will
reach the output terminals. These buffers in effect hide the difference
in clock frequencies. However, xruns are probably still going to happen,
for instance when the faster card runs out of data or the slower card's
buffer is full.

regards, Ludwig

Hardware mod
------------

With a small hw mod multiple cards can be made running in sync and hence
use the above alsa device for recording.

Have a look at
[http://quicktoots.linuxaudio.org/toots/el-cheapo/](http://quicktoots.linuxaudio.org/toots/el-cheapo/)

br, Timo

Multiple ice1712
----------------

At the other end of the scale (el-expensivo?), here's a guide to using
multiple ice1712 (Delta 1010) cards for pro recording. Nothing fancy,
just lots of channels in and out.

[http://www.jrigg.co.uk/linuxaudio/ice1712multi.html](http://www.jrigg.co.uk/linuxaudio/ice1712multi.html)

John

Retrieved from
"[http://alsa.opensrc.org/TwoCardsAsOne](http://alsa.opensrc.org/TwoCardsAsOne)"

[Category](/Special:Categories "Special:Categories"):
[Howto](/Category:Howto "Category:Howto")

