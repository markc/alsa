WildMidi
========

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

WildMidi 0.2.0 is now released. Go to
[http://wildmidi.sourceforge.net](http://wildmidi.sourceforge.net) for
more details.

WildMidi is written by Chris Ison and uses the same config file format
and GUS patch sets as [TiMidity](/TiMidity "TiMidity") but as Chris
explains... WildMidi isn't based on [TiMidity](/TiMidity "TiMidity"). It
was written from scratch. The only parts of
[TiMidity](/TiMidity "TiMidity") it has anything to do with are the
config files and patch sets. It does a lot of things very differently to
[TiMidity](/TiMidity "TiMidity") and, as far as I know, there is no
common code. Although some discussions I had with people involved with
[TiMidity](/TiMidity "TiMidity") had common ideas or topics, the way we
approached most problems was different. It's currently only available
via CVS from...

` `

    cvs -d:pserver:anonymous@cvs.quakeforge.net:/project/cvs login (hit enter)
    cvs -d:pserver:anonymous@cvs.quakeforge.net:/project/cvs co wildmidi

    cd wildmidi; ./bootstrap; ./configure; make; make install

Some notes from Chris's emails...

NOTE: There is a known bug in the reverb engine where it produces a lot
of white noise at a sample rate of 11025Hz. Sample rates of 22050Hz and
higher are fine. This is due to the unique nature of the reverb engine
within WildMidi and I will have to look at alternatives to fix it. The
reverb engine is only roughly tuned so it may not sound as you expect,
but it works.

WildMidi is in 2 parts:
[libWildMidi](?title=LibWildMidi&action=edit&redlink=1 "LibWildMidi (page does not exist)")
and `wildmidi` (the command-line executable)...

libWildMidi is the core of WildMidi; it does all the hard work and is
designed to be used in other programs. For example, QuakeForge has a
plugin that uses libWildMidi (without reverb) so that
[MIDI](/MIDI "MIDI") files can be played through the Quakeforge sound
engine. `wildmidi` is a demo program that is just a command-line player.
Use `-c` on the command line to point it to your `timidity.cfg` file.

Example: ` `

    wildmidi -c ~/eawpats/timidity.cfg my_midi.mid

The library only uses Gravis `.pat` files, as used by
[TiMidity](/TiMidity "TiMidity"), and also uses the `timidity.cfg` for
basic MIDI setup. It does not support the XG/GS extentions that
[TiMidity](/TiMidity "TiMidity") does. However, it has extensions that
were added to "fix via config" some bugs in some pats that were
constructed incorrectly (with editors that didn't support the 3 release
envelopes that Gravis `.pat` files contain). If you have samples that
sound wrong, let me know the name, size and where they may be found and
I will endeavor to give you the config settings to play them properly.

If you use the command line program `wildmidi`, these are the keys to
use while a MIDI file is playing...

` `

    r  switch reverb off/on
    n  next midi
    q  exit
    -  decrease volume
    +  increase volume
    v  switch between curved and linear volumes (see below)

(this is because some MIDI files created on computers were mixed with
editors that used linear volumes instead of the curved volumes most MIDI
hardware uses. In some cases you won't notice a difference) You can also
turn off reverb from the command line, just use the `-r` option on the
command line.

Unfortunately I do not have a mailing list. I do however hang out with
the QuakeForge crowd in \#quakeforge on irc.oftc.net if you care to drop
by for some discussion. Many of them help test `wildmidi` and one person
has even created an `xmms` plugin for it (dunno if its valid for the
current version). As stated earlier the wildmidi program only
demonstrates a small fraction of what the library can do.

The library can...

-   Be used in multithreading applications
-   Process multiple MIDI files (which it does in QuakeForge) (in
    QuakeForge you can have 2 different MIDI files playing at the same
    time using the lib)
-   No note cutting ...
    [(TiMidity](?title=(TiMidity&action=edit&redlink=1 "(TiMidity (page does not exist)")
    can cut notes when CPU load if heavy, WildMidi does not and with
    some MIDI files can give better sound quality than
    [TiMidity](/TiMidity "TiMidity") due to this fact)
-   Super-Fast Sampling ... WildMidi actually loads and processes the
    sound samples as they are required. This is able to be done due to
    the speed at which WildMidi does the re-sampling and mixing. Also,
    when run without reverb, there will only be a small amount of CPU
    usage.

WildMidi does not support all MIDI messages at this stage due to the
complex or slow code required. ie: tremolo and vibrato are not supported
at this time but may be supported at a later date. If there is something
you would like to see in the program or library, feel free to suggest or
even discuss what you have in mind. WildMidi is a work-in-progress and
started out as a project to understand MIDI and software synths. But as
you can see, it's grown by demand since then and I'm more than happy to
add functionality to it.

[gus pat
format](?title=Gus_pat_format&action=edit&redlink=1 "Gus pat format (page does not exist)")
is actually quite flexible; it's just mis-understood by many who
implement it.

I've done many many months of research into different sound formats,
from `wav` to `sf2` (and even some `mod` formats). Basically, guspats
are raw audio files in 8 or 16 bit format. Their sample rate can go as
high as 65535Hz (16bit rate entry) but you'll often find that the sample
rates are between 22050Hz and 44100Hz for size economy. Each file can
have 1 or many samples, each sample being tuned to a specific note.

What often occurs is someone has a pat to which they want to add more
samples, and will add more but not at the same quality (or a slightly
different sound) so you end up with bad ranges in some files. (one of
the saxophone pats in eawpats has a good example of this). Also, what
can happen is the software used to edit the pats may not understand the
6 (six) envelopes gus pats have and thus set envelopes badly. (This is
an issue and I've had discussion with [TiMidity](/TiMidity "TiMidity")
and pat authors previously trying to tell them that gus pats have 3
release envelopes and not one, but they said their editors only showed
one).

WildMidi uses the 3 envelopes as intended, going by documentation
managed to scrape off the internet (and with a little bit of playing
with original GUS pats). Unfortunatly pats made for
[TiMidity](/TiMidity "TiMidity") may sound wrong in their released
version so WildMidi has extensions that you can add to the timidity.cfg
file to fix this problem.

Example: in my gravis.cfg ` `

    0 acpiano amp=125 remove=sustain env_time3=4000 env_level3=0

This is REALLY bad in [TiMidity](/TiMidity "TiMidity"). Its piano sound
doesn't decay naturally. It drops so far then holds until it is
released, which is very annoying and wrong. What those settings do is to
remove the sustain bit (which tells wildmidi and
[TiMidity](/TiMidity "TiMidity") to hold the note at a certain amplitude
level) and also ensures the 1st release envelope lasts 4 seconds with
the resulting sound level being at 0 after that time. This may need
tuning of course but that's the example I use (to make sure it's still
working). Basically WildMidi allows you to edit the envelopes within the
pat using the .cfg file itself. Each sample within the pat has a 32bit
length value (in bytes). WildMidi however has a 32bit max filesize limit
(compiler and operating system restriction which is limited even more in
wildmidi by the ammount of RAM your system has available).

*Perhaps a `-v` option to display debug info, if wanted, would be nice
but the progress meter and able to accept keystroke commands while
playing should not be the default (IMHO).*

lol, debugging this thing can be evil to the ears, a single printf in
the main resample/mix loop kills the audio completely, but I've used it
at times to check stuff like the reverb.

*Ah right, `wildmidi -h` does not show the `-r` option... and again, the
default should really be off.*

Sorry about that, 'cause it's a work in progress, some options have
changed and I haven't put them in to the `-h` yet, ie: there is no
surround option now, the reverb engine naturally puts in a surround-like
effect.

Questions
---------

**What about the same MIDI file playing back to two or more instance of
wildmidi each with a different set of soundfiles ?**

Ok, I'll explain this more. The wildmidi library is setup to handle as
many MIDI files as your system would allow you to throw at it (memory
restrictions basically). It uses the same configuration file for all the
MIDI files you throw at it, and each MIDI file is handled individually
without affecting the others. This is achieved with the use of unique
file handles the library passes back to the program each time you load a
file into the lib. If you want to process the same MIDI file more than
once in one go, you have the library load the MIDI file as many times as
you need, recording each file descriptor the library returns. WildMidi
then loads each one into memory and treats them all separately so there
is no cross-over of information and no MIDI file can affect another MIDI
file.

Note: you can pass the library the filename of a MIDI file, or the
memory address of a complete buffered MIDI file in memory (has to be in
MIDI file format). If you do the later, you don't have to worry about
freeing that area, basically it's a "set-and-forget" 'cause the lib will
do the rest. ie: `malloc()` some memory, load a MIDI file into it, and
pass the address to the library -- no need to free it cause the library
then assumes ownership. As for different soundfonts, you would need to
have different instances of the library running. I haven't tried it but
I don't see why you couldn't do it. You could use different banks.
WildMidi will accept up to bank 127 (standard MIDI banks).

*I have the std and eawpats sets and am currently trying to run
[TiMidity](/TiMidity "TiMidity") twice in ALSA-mode sequencer so I can
use sounds from either set at the same time (like the same instrument at
the same time from both patch sets = fuller sound).*

Just playing the same MIDI file twice with a modified program through
the library will achieve this but you may want to reduce the volume of
the mixed output it feeds back to you before mixing together because
unchecked clipping is hell on the ears.

**Is wildmidi anywhere close to being able output more than stereo ?**

It would not be that difficult to add additional output channels to
wildmidi, although the legalities of it could come into play in an
opensource project. ie: Dolby's Digital Surround is very possible in
WildMidi, yet patents and licencing issues are a problem so it's on in
there.

**[Comment from Greg Lee]** I don't think you need to generate Dolby
Digital. At the low end of computer surround setups (that's my end), the
soundcard is hooked up to six (or eight) powered speakers with 3 analog
stereo jacks, and you just send a six channel interleaved stream of
samples to the kernel driver just as you send a two channel stream.
There's no Dolby encoding involved. At the high end, I gather, people
want to use home theater type equipment which does require a DD signal,
but they need a sound card or motherboard with a DD encoder (presumably
duly licensed). In any case, your midi player doesn't have to do DD
encoding. In fact, I've modified two versions of timidity to do 4 or 6
channel surround sound. The Alsa driver and library on Linux know how to
pass on 4/6 channels to my soundcard, an Audigy2 zs. It works.

The reverb engine in wildmidi is a combination of 2 different types of
all-pass filters, with some low-pass filters as well. I can't remember
the types of filters but basically it uses all-pass filters in a matrix
setup whose outputs are arranged in a cross-over array switching the
echoes from left to right and vice versa. As I said it still needs
tuning but for an initial experiment it worked much better than
expected. Basically if I can find out ideal decay times for the
different reverb types (room, hall, ...) that I've seen on keyboards (I
don't actually own any [MIDI
keyboards](/MIDI_keyboards "MIDI keyboards") -- all my stuff is done on
computer) I could fine tune it better.

**I also want to learn MIDI and software synth architecture so I am very
grateful to be able to stand on your shoulders with a better view than
what would otherwise be available :)**

Beware the pitfalls of the broken MIDI file ... there is so much sanity
checking done in wildmidi when it's given a MIDI file to play it's not
funny. WildMidi will refuse to play broken MIDI files (even if it's just
a track missing). There is no automatic correction and I don't plan any
because auto corrections can be very wrong when it comes to MIDI files,
and that missing bit of MIDI information could have been crucial.

There is still one problem I'm hunting down a solution for although I
really haven't looked for one yet as it's not critical. A couple of MIDI
files I have for some reason have really large delta times near the end
of them (delta times are MIDI timing units) so when the library
calculates the total playing time, it's WAY off. But it plays the MIDI
file fine, it just doesn't stop when it should because of the extra long
delta time at the end :/ (I really hate hex editing of MIDI files but
I've had to do it at times to make sure that what wildmidi is seeing is
actually in the file and not something random happening elsewhere). It
would appear some editors and players chop off the end of a MIDI file
where they feel the data isn't needed (ie: end at the last event that
ends any active notes, there are a couple, as no more data is required)

**[Answer from Eric]** I've run into this problem some too, and better
yet, I've even caused the problem myself, so I think I may know at least
one thing that could be causing it. When I was writing the MIDI file
output code for the MOD-\>MIDI file conversion routines in TiMidity++, I
had a few screwups calculating/writing the delta-times for the events.
What would happen is that some event somewhere in the midi would have
its delta time value (execute event at delta time since previous event
on that channel) set to some huge incorrect value due to some stupid bug
in my routines. When the midi gets to what would normally be the end of
the MIDI file, it continues to play silence until the event with the
bogus delta time finally gets executed at the time the midi told it to
execute, which may be minutes or hours later depending on the magnitude
of the screwup. Another cause may have been when I was miscalulating the
size of the track to write into the header, so some of the last few
events never got read in (since they were beyond the stated length of
the track). I have an old DOS command line tool called MIDIFIX that does
an excellent job of salvaging screwed up midi files. It told me exactly
what was wrong with the "hung" midi files and was able to easily fix
them (at least I think I remember it being able to handle them). It can
deal with missing or truncated tracks too. I think it was part of an
archive called MIDTOOLS? I can look for it later. I believe it is free
software. No src, so for Linux you'd need to run it under DOSEmu.
(Update) midifix can be found here:
[http://www.gnmidi.com/gnfreeen.htm](http://www.gnmidi.com/gnfreeen.htm)

Retrieved from
"[http://alsa.opensrc.org/WildMidi](http://alsa.opensrc.org/WildMidi)"

[Category](/Special:Categories "Special:Categories"):
[Software](/Category:Software "Category:Software")

