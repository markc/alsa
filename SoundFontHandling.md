SoundFontHandling
=================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Using Soundfonts
----------------

A [soundfont](/Soundfont "Soundfont") is a set of digital samples of the
sounds made by one or more musical instruments (or by anything else)
which can be loaded into your soundcard's ***wavetable memory***. A
soundfont can be used to make your soundcard make sounds like the
sampled musical instruments. This is useful when playing MIDI files.

If you own a Soundblaster [soundcard](/Soundcard "Soundcard") a
soundfont (usually
[8MBGMSFX.SF2](http://www.alsa-project.org/~james/sound-fonts/8MBGMSFX.SF2)
) can be loaded into its wavetable memory. The
[sfxload](/Sfxload "Sfxload") utility works for ALSA's OSS emulation of
soundfont loading. The new [asfxload](/Asfxload "Asfxload") utility
works for ALSA's native soundfont loading.

If you don't have a wavetable card, you can still use a software synth
like [FluidSynth](/FluidSynth "FluidSynth") or
[Timidity](/Timidity "Timidity").

You can find many free soundfonts on the net. Here are some examples:

-   [ftp://ftp.lysator.liu.se/pub/awe32/soundfonts/](ftp://ftp.lysator.liu.se/pub/awe32/soundfonts/)
    has one of the largest collections of soundfonts (over 300 different
    soundfonts). Most of these soundfonts are small enough to fit in
    limited wavetable memory such as 8MB.

-   [http://inanna.ecs.soton.ac.uk/\~swh/fluid-unpacked/](http://inanna.ecs.soton.ac.uk/~swh/fluid-unpacked/)
    has an interesting soundfont with many different instrument samples
    (warning the file is very large 141MBytes). It has a complete GM
    (General Midi) set of instruments. This is nice to have if you want
    to play midi files from the net.

For more details about soundfonts, please see the
[SoundFont](/SoundFont "SoundFont") page.

When using a soundcard that has no MIDI support through ALSA you can use
a combination of FLUIDSYNTH and QSYNTH to make MIDI sounds from for
example Rosegarden.

What you need is:

-   fluidsynth (included in many distributions)
-   qsynth (a graphical interface for fluidsynth)
-   jack and qjackctl (qsynth is jack compatible)
-   a sequencer program such as Rosegarden or just vkeybd (virtual
    keyboard)
-   soundfont files (all files mentioned above will work)

Install all the programs. Compile from source of get distributor
binaries, .rpm etc.

Shut down Artsd in KDE or Esd in Gnome, they are (right now) unnecessary
sound servers. Start jack daemon in xterm or konsole or what ever you
like for a command prompt:

` `

    jack -d alsa -d hw:0 -r 44100 -p 2048

Check out different options for jackd by typing "man jackd".

Start qjackctl. It is a graphical interface for using jackd's virtual
connections.

Start qsynth, like this:

` `

    qsynth path/to/sf2.files

You can check your soundfonts output by starting vkeybd and connecting
it to your ALSA card through qjackctl. Click both "Audio" and "Midi"
tabs to find your programs aka. ALSA clients and connect them to your
soundcards "alsa PCM" output.

For example Terratec Aureon soundcard that has no native MIDI support
with ALSA was available for MIDI sequencer Rosegarden this way. There
are lots of soundfonts available on the Internet for free download that
you can make use of this way.

Retrieved from
"[http://alsa.opensrc.org/SoundFontHandling](http://alsa.opensrc.org/SoundFontHandling)"

[Category](/Special:Categories "Special:Categories"):
[MIDI](/Category:MIDI "Category:MIDI")

