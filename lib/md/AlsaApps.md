AlsaApps
========

Here's the official ALSA webpage listing various applications:
[http://www.alsa-project.org/main/index.php/Applications](http://www.alsa-project.org/main/index.php/Applications)

1. [Ardour](#Ardour)
2. [Jack](#Jack)
3. [Muse](#Muse)
4. [Hydrogen](#Hydrogen)
5. [LinuxSampler](#LinuxSampler)
6. [Midicomp](#Midicomp)
7. [Rosegarden](#Rosegarden)
8. [RTSynth](#RTSynth)
9. [TiMidity](#TiMidity)
10. [WildMidi](#WildMidi)
11. [XMMS](#XMMS)
12. [Other applications?](#Other_applications.3F)

<a id="Ardour"/>
Ardour
------

See [ardour](/Ardour "Ardour").

<a id="Jack"/>
Jack
----

See [jack](/Jack "Jack").

<a id="Muse"/>
Muse
----

See [muse](/Muse "Muse").

<a id="Hydrogen"/>
Hydrogen
--------

Hydrogen is a pattern based drum sequencer
[http://hydrogen.sourceforge.net/](http://hydrogen.sourceforge.net/).

*How do you get Hydrogen to sync to ardour?*

In the hydrogen preferences, audio driver, select "jack", and check
"jack transport slave". Then click the play button and note that it
isn't playing, then in Ardour, record-enable some tracks, click record,
click play, and note that hydrogen starts playing instantly. Paul
Winkler (from linux-audio-users)

<a id="LinuxSampler"/>
LinuxSampler
------------

LinuxSampler is a SoundFont (DLS2) and GigaSampler compatible softsynth
only available via CVS at this stage. See the LinuxSampler page for more
details.

<a id="Midicomp"/>
Midicomp
--------

[MidiComp](https://github.com/markc/midicomp)
is a SMF MIDI disassembler/compiler which will convert a MIDI
file into plain text and also convert that plain text version back into
a playable MIDI file. Not strictly an ALSA app but uses ALSA to hear the
results.

<a id="Rosegarden"/>
Rosegarden
----------

[Rosegarden](/Rosegarden "Rosegarden") is both a *musical notation
editor* and a *MIDI sequencer*. One of Rosegarden's major features is
that musical notation is created automatically when you play a MIDI
keyboard connected to your PC's soundcard.

<a id="RTSynth"/>
RTSynth
-------

RTSynth a MIDI-event-triggered real-time synth
[http://www.linux-sound.org/rtsynth/](http://www.linux-sound.org/rtsynth/)

1.  start RTsynth.
2.  check the client/port ids via aconnect

       % aconnect -o
       ...
       client 128: 'RTSynth v1.9.2 synthesizer' [type=user]
           0 'RTSynth         '

1.  load the patch from Examples directory.
2.  turn on the power button of rtsynth.
3.  play MIDI, e.g. via pmidi with the ids found above

       % pmidi -p 128:0 foo.wav

- TakashiIwai

<a id="TiMidity"/>
TiMidity
--------

TiMidity is a soft synth that uses Gravis GusPatches and SoundFonts
[http://www.onicos.com/staff/iz/timidity/](http://www.onicos.com/staff/iz/timidity/)

<a id="WildMidi"/>
WildMidi
--------

WildMidi is a soft synth that uses the same configs and patches as
Timidity
[http://wildmidi.sourceforge.net/](http://wildmidi.sourceforge.net/)

<a id="XMMS"/>
XMMS
----

XMMS has an alsa plugin. Configuring XMMS with alsa for digital output
(spdif): In xmms, Options -\> Preferences (Ctrl P) select the tab
**Audio I/O Plugins**, and in the box **Output Plugin** select the
**ALSA 1.2.8 output plugin [libALSA.so]** and press the **Configure**
button. In the **ALSA Driver configuration**, Click the checkbox "[x]
User defined:", and enter **spdif** instead of **default**. Leave the
**Mixer card:** set to "0", and **Mixer device:** set to "PCM". This
will select the digital output for the soundcard, and now
[xmms](/Xmms "Xmms") will send the output to alsa's digital output. For
some unknown reason, "mono" tracks don't play. Only "stereo" tracks work
at the moment.

<a id="Other applications.3F"/>
Other applications?
-------------------

More hints for other applications ?

Please fork this project at Github and send a pull request.
