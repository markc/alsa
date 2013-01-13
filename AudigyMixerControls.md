AudigyMixerControls
===================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Here is complete not ordered mapping of the
[AudigyMixer](/AudigyMixer "AudigyMixer") controls so please add any
notes you may be aware of about these controllers and what they actually
do for a Audigy card and/or AudigyDrive.

Based on
[SbLiveMixerControls](/SbLiveMixerControls "SbLiveMixerControls").

Audigy mixer is composed from controls performing various functions and
there are many of them. I split these controls into these categories:

Contents
--------

-   [1 Analog input controls](#Analog_input_controls)
-   [2 Other stereo input controls](#Other_stereo_input_controls)
-   [3 Multichannel playback controls](#Multichannel_playback_controls)
-   [4 Output controls](#Output_controls)
-   [5 Capture controls](#Capture_controls)
-   [6 Per stream controls](#Per_stream_controls)
-   [7 Special controls](#Special_controls)

Analog input controls
---------------------

These analog sources are mixed together and are routed to DSP as one
stereo source. Only this mix can by recorded and not the individal
sources. These controls affect playback and

recording from these sources. All these controls are implemented as
analog in AC97. Audigy 2 Platinium EX doesn't have these controls.

  --------- --------------------------------------------------------------
  Line in   Controls volume from Line in connector on back side of card.
  Aux       Controls volume from internal Aux connector.
  CD        Controls volume from internal CD connector.
  --------- --------------------------------------------------------------

Other stereo input controls
---------------------------

All other inputs (except analog inputs) have playback and capture
controls. All these controls are implemented using DSP. All stereo
sources are mixed together and if needed upmixed to 5.1. After upmixing
only output controls affect signal (tone, master volume).

**For upmixing these controls are used:**

  ---------- -----------------------------------------------------------------------------------------------------------------------
  Front      Controls overall front volume for all stereo sources.
  Surround   Controls overall rear volume for all stereo sources. Actually this performs mirroring from front to rear channels.
  Center     Controls overall center volume for all stereo sources. Actually this performs mirroring from front to center channel.
  LFE        Controls overall LFE volume for all stereo sources. Actually this performs mirroring from front to LFE channel.
  ---------- -----------------------------------------------------------------------------------------------------------------------

**Stereo input sources:**

  ---------------- ---------------------------------------------------------------------------------------------------------------------------------
  PCM              Controls volume of stereo wave playback (for example wav file, mp3 and so on).
  Music            Controls volume of midi playback using internal midi synth.
  Mic              Controls volume of mic. For mic AC97 ADC is used.
  Audigy CD        Controls volume of digital cd from internal spdif connector.
  IEC958 Optical   Controls volume of digital spdif inputs. This controls both spdif volumes (coaxial and optical)
  Line2            Controls volume of Line2 input on AudigyDrive.
  Analog Mix       Controls volume of mix from analog sources (Line In, CD, Aux, ..). For Audigy 2 Platinum Ex this is Line1 input on AudigyDrive.
  Aux2             Controls volume of Aux2 input on AudigyDrive.
  ---------------- ---------------------------------------------------------------------------------------------------------------------------------

Multichannel playback controls
------------------------------

These controls are only used for 5.1 playback. All these controls are
implemented using DSP. Only output controls affect signal (tone, master
volume) after these controls.

  ------------ ----------------------------------------------
  PCM Front    Controls front volume multichannel playback.
  PCM Rear     Controls rear volume multichannel playback
  PCM Center   Controls center volume multichannel playback
  PCM LFE      Controls LFE volume multichannel playback
  ------------ ----------------------------------------------

Output controls
---------------

All sound comes through these controls. All these controls are
implemented using DSP.

  -------- ----------------------------------------------------
  Tone     When muted, the Bass and Treble control is ignored
  Bass     Bass intensity control
  Treble   Treble intensity control
  Master   Controls volume of all 5.1 channels
  -------- ----------------------------------------------------

Capture controls
----------------

These controls sets volume for capture. You don't need set capture
source, just set capture volume for needed source to desired level.
Analog sources (Line In, CD, Aux) are captured as one source. All these
controls are implemented using DSP.

  ------------------------ ---------------------------------------------------------------------------------------------------
  PCM Capture              How much capture from PCM.
  Music Capture            How much capture from music (midi synth).
  Mic Capture              How much capture from mic.
  Audigy CD Capture        How much capture from digital cd input.
  IEC958 Optical Capture   How much capture from optical and coaxial input.
  Line2 Capture            How much capture from Line2 input on AudigyDrive.
  Analog Mix Capture       How much capture from analog sources (Line In, CD, Aux) or for Audigy 2 Platinium Ex from Line 1.
  Aux2 Capture             How much capture from Aux2 input on AudigyDrive.
  ------------------------ ---------------------------------------------------------------------------------------------------

Per stream controls
-------------------

All these controls are implemented in emu10k2 hardware. They are linked
with opened stream. For mono, stereo sound 1 stream is opened. For 4
channel sound 2 streams are opened. for 5.1 channel sound 3 streams are
opened. There are available when stream is opened end go away if stream
is closed.

  -------------------------- --------------------------------------------------------------------------------------------------------------------------------
  EMU10K1 PCM                Controls volume of stream. This is front volume for stereo and mono stream. For 4 and 6 channel sound this depends on routing.
  EMU10K1 PCM Send Routing   Controls stream routing. Don't change this, because this is not simple volume but coded value.
  EMU10K1 PCM Send           Controls stream routing volume. Don't change this.
  -------------------------- --------------------------------------------------------------------------------------------------------------------------------

Special controls
----------------

IEC958 Optical Raw

This switch what goes on spdif output.

Muted - on spdif output is same signal as from front analog speakers.
Unmuted - on spdif output is raw unprocessed stream from spdif device
and this is used for AC3 passhrough. Only 48 KHz is supported.

For normal operations this should be mutted. For Playing Dolby digital
from DVD on external receiver this should by unmuted. When spdif device
is used, this switch is set automatic.

Audigy Live Analog/Digital Output Jack

This sets the output to either digital or analog, with only one output
port.

You must Mute it for analog output (for 5.1: center/subwoofer).

Retrieved from
"[http://alsa.opensrc.org/AudigyMixerControls](http://alsa.opensrc.org/AudigyMixerControls)"

[Category](/Special:Categories "Special:Categories"): [Sound
cards](/Category:Sound_cards "Category:Sound cards")

