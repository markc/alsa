SBliveValue
===========

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

This is the result of some considerable time spent tinkering with a
Soundblaster Live Value, reading the ALSA documentation and source code
and comparing the Live to other cheap cards people might be familiar
with. Some of this information might be helpful to people with any type
of Creative Soundblaster Live card, but I don't have any other kind so I
can't be sure. Don't bother reading this if you have an Audigy, the
mixer controls in particular are quite different from a Live of any
kind. If you find any possible mistakes please indicate which ALSA
version you were using, some behaviour of the Live has changed between
ALSA versions and likely will again.

Contents
--------

-   [1 Mixer Controls](#Mixer_Controls)
    -   [1.1 Master](#Master)
    -   [1.2 Headphone](#Headphone)
    -   [1.3 3D Control](#3D_Control)
    -   [1.4 Tone, Bass and Treble](#Tone.2C_Bass_and_Treble)
    -   [1.5 PCM](#PCM)
    -   [1.6 Wave](#Wave)
    -   [1.7 Wave Surround](#Wave_Surround)
    -   [1.8 Music](#Music)
    -   [1.9 Line](#Line)
    -   [1.10 CD](#CD)
    -   [1.11 Mic](#Mic)
    -   [1.12 Video, Phone, Aux](#Video.2C_Phone.2C_Aux)
    -   [1.13 AC97 Controls](#AC97_Controls)
    -   [1.14 SB Live Analog/Digital Output
        Jack](#SB_Live_Analog.2FDigital_Output_Jack)

-   [2 Capture Controls (Recording)](#Capture_Controls_.28Recording.29)
    -   [2.1 Mix](#Mix)

-   [3 Surround sound](#Surround_sound)
-   [4 Comments](#Comments)

Mixer Controls
--------------

Some of the mixer controls on the Soundblaster Live are just like those
on older consumer sound cards like Creative's own SB16. They directly
control an analogue circuit and need to be adjusted carefully to produce
good results without distortion. On the other hand, the Live also has
some controls which are implemented entirely by programmable digital
hardware. The latter type of control may change its meaning if you use
software that re-programs your SB Live. This guide covers playback
controls first (ie those which influence what you hear on your speakers
or headphones) and then explains the capture/ recording controls.

There are many programs for changing ALSA mixer controls, and so the
description below may not precisely correspond to what you see on the
screen in your program. For example a control might be called "Master
Playback" instead of "Master" and there might be separate left & right
controls for stereo channels or a single slider and a left-right pan.

### Master

The controls the first stereo mini-jack Line Out (also doubling as a
headphone out). Settings above \~90% will introduce significant
distortion. If you have an external amplifier you should be able to set
this control once to an acceptable level and then control the volume
from the amplifier. If you don't have an amplifier this control (rather
than PCM, Wave etc. playback controls) could be used instead.

### Headphone

So far as I can tell, on a Value these controls are redundant.
Presumably the Live Drive headphone out levels are controlled by these
mixer settings if you have such a thing.

### 3D Control

This does not seem to be implemented in the ALSA drivers

### Tone, Bass and Treble

The Tone control is an on/ off switch. When it's switched off the Bass
and Treble are bypassed (have no effect). Otherwise Bass controls the
volume of low frequency sounds while Treble does the same for high
frequencies. Their mid-setting is similar to but different from leaving
Tone off. Turning on the Tone control can introduce some distortion, and
it should be left off if possible.

### PCM

On the SB Live PCM doesn't just refer to ALSA's PCM playback (see Wave
for that) but to all PCM signals on the card, which also includes those
created by the EMU10k1 MIDI synth and (if you have installed the
necessary software) the onboard programmable DSP unit. You may want to
set this to its maximum level, since doing so should not introduce
distortion.

Rumour has it that a 12db+ boost is applied when this is above 75%
([https://bugtrack.alsa-project.org/alsa-bug/view.php?id=612](https://bugtrack.alsa-project.org/alsa-bug/view.php?id=612)
). If you are finding that you are getting distortion you could try
lowering this setting to 75%.

### Wave

This directly corresponds to ALSA's default PCM playback (ie your XMMS,
Unreal Tournament etc.). You may want to set this to maximum to preserve
maximum fidelity (there is no distortion in this stage of the mixer
because it's entirely digital).

### Wave Surround

The Wave Surround control duplicates the sound from the front output
channels to the rear. See the surround section below.

### Music

This controls levels for the onboard MIDI wavetable synthesiser. Once
samples are uploaded to the card (see sfxload) you can play the built-in
synthesiser using any ALSA sequencer application. When many notes are
played at once the output is saturated quite easily so you may need to
turn down this control to compensate.

### Line

The analog mini-stereo jack goes through the AC97 part of the Live. If
listening to Line In via the Live you will need to adjust this control
to get suitable results without too much distortion. See Capture
Controls below for information about recording the Line In.

### CD

There are several CD connectors even on the budget SB Live. This mixer
control affects only analogue CD connections, *not* TTL digital found on
many modern drives. See IEC958 TTL for those. It also doesn't affect DAE
(digital audio extraction), if your media player software does DAE then
CD playback is treated the same as any WAV, MP3 or any other PCM audio.
Mute this channel if it's not connected on your system or otherwise
experiment to find a suitable level without distortion.

### Mic

In addition to the Mic control itself which functions much as the Line
In and CD level controls, there is also a Mic Boost switch (which
enables a +20dB amplification, useful if the microphone seems otherwise
much too quiet) and a Mic Select switch which should be left set to Mic
1, since there is no facility to connect an alternate microphone to the
card.

### Video, Phone, Aux

There may be several more analogue connections, most of which probably
aren't connected to anything on your board. The associated mixer
controls should work much like the Line or CD controls. If you don't
have any hardware connected please mute the channel to reduce noise.

### AC97 Controls

The AC97 playback and capture levels are correctly setup by default and
should be left alone. That is, the AC97 playback level should be zero
(other settings cause digital feedback), and the AC97 capture level
should be at its maximum for proper analogue recording.

### SB Live Analog/Digital Output Jack

Some variants (not the one I have) of the SB Live include a mini jack
output which does double duty. With a suitable connector it can be used
as a digital output. If you have such a thing switching this control on
will enable it. In a lot of mixer apps on/off switches are always
labelled as mute controls, so you'll need to unmute it. If you've got a
regular analogue jack plugged in ensure the control is switched off
(muted).

Capture Controls (Recording)
----------------------------

Many of the digital mixer controls for the SB Live are accompanied by
Capture controls, with a separate level control in the mixer. The
recording levels are *independent* of the playback levels, so you can
adjust them separately to suit your application. Using the Wave Capture
you can do â€œloopbackâ€? recording of sounds from software, and using
Music Capture you can record performances with the MIDI synth. Use
recording software with a digital level meter and adjust the capture
levels for best results. Ensure that Capture is switched on only for the
source or sources that you want to record.

The analogue mixer connections, such as Mic In, Line In and the
old-style CD audio connectors are connected via an AC97 codec. Exactly
one of these sources can be captured (but see Mix below), and the choice
will probably be presented either as a list or as radio button controls
next to the playback levels for each of the sources. The AC97 Capture
switch (often just labelled "Capture") can be turned off altogether when
not recording from an analog source.

### Mix

The Mix and Mix Mono capture sources enable loopback capture in the AC97
circuits, recording from the output analogue signal as though it was an
input. These should only be selected if you need to capture multiple
analog inputs which are handled by AC97, such as Line In and Mic In at
the same time. In that case, select the Mix capture source and adjust
*playback* level controls for the inputs needed. You will also need to
turn on the AC97 Capture control. Distortion is fairly inevitable when
using this capture source. Do **not** use this source to capture output
from OSS applications, see the information about Wave Capture above
instead.

Surround sound
--------------

The SB Live Value has a pair of two channel mini-jack outputs suitable
for analogue 4.0 surround. The front left and right should be connected
to the first jack, and the rear left and right to the second jack. If
you just want to drive two extra speakers (or an extra pair of
headphones) with ordinary stereo playback, you can use the mixer setting
Wave Surround playback to control the volume of the rear speakers. When
using applications able to support better than stereo (such as many DVD
players) the ALSA device should be *surround40*, or you should select
the 4.0 surround option if available.

Comments
--------

Very useful page .. learned a bit more about my card and all those
settings in the alsamixer interface. Wonder what all the IEC958 entries
are though (Coaxial/[LiveDrive](/LiveDrive "LiveDrive")/TTL). I came to
this page trying to get my Mic working, and it didn't help in the least
bit however.

Retrieved from
"[http://alsa.opensrc.org/SBliveValue](http://alsa.opensrc.org/SBliveValue)"

[Category](/Special:Categories "Special:Categories"): [Sound
cards](/Category:Sound_cards "Category:Sound cards")

