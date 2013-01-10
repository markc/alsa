PlayingMIDIFiles
================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

**Playing [MIDI](/MIDI "MIDI") files using [ALSA](/ALSA "ALSA")**

\
 There are four ways to play [MIDI](/MIDI "MIDI") files using
[ALSA](/ALSA "ALSA"). For information on [recording MIDI
files](/Recording_MIDI_files "Recording MIDI files") please follow the
link.

Contents
--------

-   [1 Using MIDI keyboards connected to your
    PC](#Using_MIDI_keyboards_connected_to_your_PC)
-   [2 Using a wavetable synth on your
    soundcard](#Using_a_wavetable_synth_on_your_soundcard)
-   [3 Using an FM synth on your
    soundcard](#Using_an_FM_synth_on_your_soundcard)
-   [4 Using a software synthesizer and a PCM device on your
    soundcard](#Using_a_software_synthesizer_and_a_PCM_device_on_your_soundcard)

Using [MIDI keyboards](/MIDI_keyboards "MIDI keyboards") connected to your PC
-----------------------------------------------------------------------------

If you have a musical instrument like one of the [MIDI
keyboards](/MIDI_keyboards "MIDI keyboards") (a.k.a. '*"synthesizer"*),
you can connect it to your soundcard's [MIDI
interface](/MIDI_interface "MIDI interface") and play a MIDI file
directly on the MIDI port where the MIDI keyboard is attached. The MIDI
keyboard should make the sound.

For example, run `pmidi -l` to get a list of available ports, remember
the external port code, and play the MIDI file on the external port
using `pmidi -p 65:0 music.mid` (for an external port of `65:0`).
`pmidi` is quite limited compared to Takeshi Iwai's `drvmidi`, which can
move forwards and backwards in a MIDI file while it is being played as
well as dynamically load [soundfonts](/Soundfont "Soundfont"), and also
compared to `playmidi/xplaymidi`, which can adjust the playback speed of
a MIDI file while it is playing. Both of these programs are for OSS
which means they require ALSA's
[OSSemulation](/OSSemulation "OSSemulation") modules `snd-seq-oss` and
`snd-mixer-oss` to be loaded.

Using a wavetable synth on your [soundcard](/Soundcard "Soundcard")
-------------------------------------------------------------------

Some soundcards have a ***wavetable synth*** which can store a
[soundfont](/Soundfont "Soundfont") which is a set of pre-recorded sound
samples of various musical instruments. When a MIDI file is played using
a wavetable synth, the sounds you hear are the sound samples. The sound
quality can be excellent if you choose a well-made soundfont. Firstly,
you need to load a [soundfont](/Soundfont "Soundfont") using
[asfxload](/Asfxload "Asfxload") or [sfxload](/Sfxload "Sfxload").
Secondly, you should play the MIDI file using a MIDI player program like
[pmidi](/Pmidi "Pmidi"),
[drvmidi](?title=Drvmidi&action=edit&redlink=1 "Drvmidi (page does not exist)"),
etc. The main advantage of a wavetable synth is that it is implemented
in hardware and therefore has very low latency - typically below
150usecs - which is much less than that of any software synth.

Currently, the only supported soundcards with wavetable synths are
Creative Technology's [emu10k1](/Emu10k1 "Emu10k1")-based soundcards
e.g. Audigy and Audigy2.

Using an FM synth on your [soundcard](/Soundcard "Soundcard")
-------------------------------------------------------------

Some soundcards (notably Creative Technology's
[emu10k1](/Emu10k1 "Emu10k1")-based soundcards) have an FM synth. You
can use the FM synth to play MIDI files although the sound quality is
not high. Look at the output of the command

` `

    aconnect -i -o</tt>

to see which MIDI ports you have available. Then try sending a MIDI file
to each of them using a MIDI player program like [pmidi](/Pmidi "Pmidi")
or
[drvmidi](?title=Drvmidi&action=edit&redlink=1 "Drvmidi (page does not exist)").
Make sure the "Synth" volume control in your mixer such as `alsamixer`
is neither muted nor set to a very quiet volume level.

pmidi -l reported an OPL3 FM synth on my machine. In order to use it I
had to

` `

    sbiload -p 65:0 --opl3 std.o3 drums.o3

I found this on
[http://www.parabola.demon.co.uk/alsa/pmidi.html](http://www.parabola.demon.co.uk/alsa/pmidi.html)
search for OPL3 FM synthesizer

Using a software synthesizer and a PCM device on your [soundcard](/Soundcard "Soundcard")
-----------------------------------------------------------------------------------------

If you do not have any [MIDI
keyboards](/MIDI_keyboards "MIDI keyboards") or instruments available,
you can still use a software synthesizer *("softsynth")* like
[TiMidity](/TiMidity "TiMidity") or
[FluidSynth](/FluidSynth "FluidSynth"). A softsynth plays a MIDI file by
converting it (by software) into digital audio samples which are played
on a PCM device of your [soundcard](/Soundcard "Soundcard"). You can
also run both of these programs as virtual synths which will then appear
in the output of "`aconnect -i -o`" and can be used later by MIDI
sequencer software. Make sure the "Synth" volume control in your mixer
such as `alsamixer` is neither muted nor set to a very quiet volume
level.

Although it cannot be used as a virtual synth, the [gt](/Gt "Gt")
utility can play MIDI files in [surround
sound](/SurroundSound "SurroundSound") using extended GUS patch files,
as described on the GusSoundfont page.

Retrieved from
"[http://alsa.opensrc.org/PlayingMIDIFiles](http://alsa.opensrc.org/PlayingMIDIFiles)"

[Categories](/Special:Categories "Special:Categories"):
[Howto](/Category:Howto "Category:Howto") |
[MIDI](/Category:MIDI "Category:MIDI")

