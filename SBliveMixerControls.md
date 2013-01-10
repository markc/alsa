SBliveMixerControls
===================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Here is complete ordered mapping of the 45 SBliveMixer controls so
please add any notes you may be aware of about these controllers and
what they actually do for a SBlive card and/or
[LiveDrive](/LiveDrive "LiveDrive"). Just start typing whereever you see
the word Unknown. - [Mark
Constable](/User:MarkConstable "User:MarkConstable") 20020711

A page for [AudigyMixer](/AudigyMixer "AudigyMixer") has been started so
I presume the mixer presets of the Audigy is different to the legacy
SBlive, so check out the AudigyMixer page if you have a more recent
SBlive card. - [Mark
Constable](/User:MarkConstable "User:MarkConstable") 20040501

[Emu10k1 mixer in ALSA](http://heim.ifi.uio.no/~haakoh/emu10k1/) -
Guessed mixer map.
--[HaakonHjortland](?title=User:HaakonHjortland&action=edit&redlink=1 "User:HaakonHjortland (page does not exist)")
09:01, 10 June 2006 (EST)

**1 Master**

Master volume control

**2 Master Mono**

Same as previous but mono (?)

**3 Headphone LFE 1**

Headphone Left channel (when muted audio goes to the left speaker, when
unmuted no audio)

**4 Headphone 1**

Headphone output volume

**5 Headphone Center 1**

Headphone Right channel (when muted audio goes to the left speaker, when
unmuted no audio)

**6 Tone**

When muted, the Bass and Treble control is ignored

**7 Bass**

Bass intensity control

**8 Treble**

Treble intensity control

**9 PCM**

Same as wave output volume. However, this control also affects other
digital sources, like the CD-SP/DIF connector and wavetable music, when
played via the analogue front-out.

**10 Surround Digital**

Left surround and right surround volume control (like Master, but for
surround channels only) (Master does not affect surround volume).

**11 Surround Digital Capture**

Unknown

**12 Center**

Center speaker volume and/or toggle

**13 LFE**

LFE stands for Low Frequency Effects which is .1 in 5.1. On my card this
does effect the volume of my sub at least in analog. I'm curious about
headphone lfe... but I have no real idea. The KX drivers (for windows
emu10k1) have a thing that controls the cutoff frequency and the volume
output to the subwoofer..maybe that is it?

**14 Wave**

Wave sound output volume (front left and right) -- Is used as the volume
level for input when the Mix device is picked as the capture device as
well (PCM does not).

**15 Wave Capture**

Record toggle for channel 14

**16 Wave Center**

Unknown

**17 Wave LFE**

Unknown

**18 Wave Surround**

Controls wave sound volume on line-out when in 2-channel mode(s). (When
in 2-channel mode(s), the rear speaker jack is actually supposed to be
line-out.) Is automatically zeroed when card enters 4-channel (surround
sound) mode(s)?

**19 Music**

Hardware MIDI synthesizer volume control

**20 Music Capture**

Record toggle for channel 19

**21 Line**

Line in volume

**22 Line LiveDrive**

LiveDrive Line in connector volume

**23 Line LiveDrive Capture**

Record toggle for channel 22

**24 Line LiveDrive 1**

Has some realation to the S/PDIF input on the LiveDrive. My DVR is
connected via S/PDIF in, and I use this to control the input level for
output to analog speakers. None of the capture controllers work for the
S/PDIF in, but this playback control does.

**25 CD**

CD audio volume (analog internal connector -- for digital internal
connector, see IEC958 TTL)

**26 Mic**

Volume of mic to output to speakers.

**27 Mic Boost (+20dB)**

Increases gain in Mic input so you get a boost in mic recordings,
specially if the recording voice and / or instrument are distant or low
in volume.

**28 Video**

An internal connector for TV or Video capture boards to control volume
without external cables (same as normal CD Audio cables )

**29 Phone**

An internal connector for modem audio / Line output (same as normal CD
Audio cables; same connector, different pinout!)

**30 IEC958 Coaxial**

On the SBLive Classic (no bloody Value, Platinum, etc.), there are
coaxial digital I/Os. This channel (obviously) controls those ports.

**31 IEC958 Coaxial Capture**

Record toggle for channel 30

**32 IEC958 Optical**

Fiber Optic Input devices (normaly connected to the LiveDrive)

**33 IEC958 Optical Capture**

Record toggle for channel 32

**34 IEC958 Optical Raw**

This might be an input to allow the unprocessed incoming stream to be
captured (perhaps to record non-audio data like AC-3 or DTS audio
without the EMU10K chip mangling it first) -- this may also be the only
known method to record an incoming 44.1KHz digital stream without it
being resampled to 48k internally first (but this needs to be tested to
find out for sure -- any volunteers?).

**35 IEC958 TTL**

Volume control for the digital CD input.When using digital CD input the
PCM control also changes the volume.

**36 IEC958 TTL Capture**

Record toggle for channel 35

**37 PC Speaker**

Internal connector that provides volume control for the PC Speaker as
long as its connected to the sound card

**38 Aux**

Auxilary (another internal connector) volume control. On a SBLive Value,
this controls the level of the second (non-CD, non-TAD) internal audio
connector.

**39 Capture**

All capture volumes (more than likely you want it high). It must also be
picked as a capture device or no recording inputs go through at all.

I find that there are only 4-5 discrete gain levels available through
this control -- if you have a recorder running (which displays signal
levels -- gramofile works great) you can easily see the gain increments.
For me, a level of 33 or 40 gives just the right amount of gain for a
line-level input (with Line as the only capture device). Signals that
top out the analog vu meter on my tape deck register \~90% volume on the
digital recording.

When I have only Line set as a capture device, it records the line in
only (as you would expect), but it also allows full-duplex operation. In
this mode, I can mute the Line channel (so I don't hear the audio being
recorded) and listen to the audio of my choice without interfering with
the recording. The level of the Line channel seems to have absolutely no
impact on record levels. This is a very handy feature when there are
lots of tapes to digitize, and you're tired of listening to the material
on them. :) (ALSA 0.9.0beta12 w/ SBLive! Value -- YMMV)

**40 Mix**

When selected as the capture device, all possible input devices are
mixed together.

**41 Mix Mono**

Same as 40 except stereo channels are combined and the result is put out
in both speakers. (It makes the mixed signal mono.)

**42 AC97**

On my SB Live Value when I turn the AC97 level up past the Capture level
I get a high pitched whine. It almost sounds like a digital version of
analog feedback. Not very useful though, I keep it at 0.

**43 AC97 Capture**

On my SB Live Platinum original (no IR ports) this channel seems to have
a strange function. With Mix, Capture, and a reasonable volume for
LiveDrive line in, lowering the volume of this channel from 100%
effectively lowers the maximum volume that the recording can attain
which causes distortion. I recommend 100% volume on this channel.

**44 External Amplifier**

This control isn't connected in most cards, and is used to turn on an
"external amplifier" after the AC97 Codec chip. It's the equivalent of
the SPK/LINE\_OUT jumper on older sound cards.

It's present in any card which uses an AC97 chip.

**45 SB Live Analog/Digital Output Jack**

This sets the output to either digital or analog for Gateway OEM cards,
with only one output port. You must Mute it for analog output (for 5.1:
center/subwoofer), not 0%.

Retrieved from
"[http://alsa.opensrc.org/SBliveMixerControls](http://alsa.opensrc.org/SBliveMixerControls)"

[Category](/Special:Categories "Special:Categories"): [Sound
cards](/Category:Sound_cards "Category:Sound cards")

