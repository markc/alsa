Pmidi
=====

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

**The `pmidi` MIDI player**

Contents
--------

-   [1 What is pmidi?](#What_is_pmidi.3F)
-   [2 Where can I download pmidi?](#Where_can_I_download_pmidi.3F)
-   [3 How can I use pmidi?](#How_can_I_use_pmidi.3F)
    -   [3.1 Step 1](#Step_1)
    -   [3.2 Step 2](#Step_2)
    -   [3.3 Step 3](#Step_3)

-   [4 Alternative MIDI players](#Alternative_MIDI_players)

What is `pmidi`?
----------------

`pmidi` is a program for playing [MIDI](/MIDI "MIDI") files either on
internal MIDI devices like your [soundcard](/Soundcard "Soundcard") or
external MIDI devices like [MIDI
keyboards](/MIDI_keyboards "MIDI keyboards"). `pmidi` works with ALSA's
sequencer and has a simple command-line user interface.

Please read the general introduction to playing MIDI files on the page
[PlayingMIDIFiles](/PlayingMIDIFiles "PlayingMIDIFiles") and the short
explanation of MIDI is on the page [MIDI](/MIDI "MIDI").

Where can I download `pmidi`?
-----------------------------

You can download `pmidi` from
[http://freshmeat.net/projects/pmidi/](http://freshmeat.net/projects/pmidi/).

How can I use `pmidi`?
----------------------

To play a [MIDI](/MIDI "MIDI") file with `pmidi` you need to do three
things in order:

### Step 1

Firstly, load a [soundfont](/Soundfont "Soundfont") to put a set of
musical instrument sounds into your soundcard's wave memory (if
applicable) using either `asfxload SF8MBGM.SBK` (native ALSA version) or
`sfxload SF8MBGM.SBK` (version for ALSA's
[OSSEmulation](/OSSEmulation "OSSEmulation")).

### Step 2

Secondly, find out which [MIDI](/MIDI "MIDI") ports are available using
`pmidi`:

` `

    pmidi -l

which produces output similar to:

` `

      Port     Client name                       Port name
      64:0     Rawmidi 0 - Sound Blaster 16 M    Sound Blaster 16 MPU-401
      65:0     Emu8000 WaveTable                 Emu8000 Port 0
      65:1     Emu8000 WaveTable                 Emu8000 Port 1
      65:2     Emu8000 WaveTable                 Emu8000 Port 2
      65:3     Emu8000 WaveTable                 Emu8000 Port 3
      66:0     OPL3 FM synth                     OPL3 FM Port

### Step 3

Thirdly, choose a port name like `64:0` (an external
[MIDI](/MIDI "MIDI") device in this case) or `65:0` (the soundcard's
[MIDI](/MIDI "MIDI") synth in this case) and play a [MIDI](/MIDI "MIDI")
file on your chosen port:

` `

    pmidi -p 64:0 MusicFile.mid

Alternative MIDI players
------------------------

There are many alternative MIDI players for Linux/ALSA listed at
[http://freshmeat.net/search/?q=MIDI+player&trove\_cat\_id=1](http://freshmeat.net/search/?q=MIDI+player&trove_cat_id=1).

Takeshi Iwai's `drvmidi` [MIDI](/MIDI "MIDI") player is able to move
forwards and backwards in a [MIDI](/MIDI "MIDI") file while it is being
played as well as dynamically load soundfonts.

The `playmidi/xplaymidi` [MIDI](/MIDI "MIDI") player can adjust the
playback speed of a MIDI file while it is being played.

Look at the page
[PlayingMIDIFiles](/PlayingMIDIFiles "PlayingMIDIFiles") for several
alternative ways of playing [MIDI](/MIDI "MIDI") files.

Retrieved from
"[http://alsa.opensrc.org/Pmidi](http://alsa.opensrc.org/Pmidi)"

[Category](/Special:Categories "Special:Categories"):
[Software](/Category:Software "Category:Software")

