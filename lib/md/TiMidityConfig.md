TiMidityConfig
==============

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

**2004-03-15**

Some notes about the implcations of using the **amp=** setting in a
[TiMidity](/TiMidity "TiMidity") config file from Eric A. Welsh \<ewelsh
at ccb dot wustl dot edu\>:

Just to clarify what amp= does. It amplifies the samples to X percent of
their original amplitude. So amp=200 does NOT equal 2x perceived volume
increase. The human ear has a more logarithmic response. The actual
equation you need to calculate that is: ` `

    X^1.661     where 1.661 is actually 1/log10(4), and X is the volume
                multiplier

So 2\^1.661 = 3.16, which is the number you always see mentioned in
discussion about decibels, so you can know the equation is correct.
amp=316 will give you 2x the perceived volume.

But be careful, it is easy to overamplify the samples beyond 16-bit
amplitudes and introduce clipping.... If you use big amps, you may want
to scale down the final timidity volume so you don't introdue clipping.
Use the -A flag to do this.

* * * * *

From an email exchange with Mikus Grinbergs \<mikus at bga.com\>:

*I'm still not clear how the \*.cfg files include others and how to do
proper bank switching for GS and XG.*

There's two processes involved: 1) Storing the sounds for Timidity to
use (.cfg files organize this); 2) Fetching the sounds during "playing"
(MIDI files specify this). [And there are two kinds of sounds: A)
melodic (voiced) instruments, which can change the frequency (note) of
the sound they produce; B) percussion (drum) instruments, which can emit
only a single sound.

As far as .cfg files go, for melodic (A) instruments: (at the top
organizational level) the "kind" of sounds\_collection is specified by
bank \<number\>; (at the middle organizational level) the particular
instrument within a bank is specified by \<program number\>; and (at the
bottom organizational level) how the instrument sounds at different
frequencies is established by the waveforms within the GUS patch for the
instrument.

And as for .cfg files for percussion (B) instruments: there is no top
"organizational" equivalent for melodic banks (though .sf2 files have
code-values indicating "this is percussion"); (at the middle
organizational level) the "kind" of percussion sounds\_collection (drum
kit) is specified by drumset \<number\>; (at the bottom organizational
level) the particular instrument within a drumkit is specified by \<note
number\>. [By definition, a percussion instrument has only a single
sound (i.e., frequency), so the "note" value is used instead to
\*select\* an instrument within a drumset.] [For percussion instruments
that can change their tuning (e.g., timpani), a \*separate\* "percussion
instrument" is defined for each frequency used.]

As far as MIDI files go, the top organizational level is selected by the
"Bank Select" Controller\_Change MIDI events; the middle organizational
level is selected by the Program\_Change MIDI events; and the bottom
organizational level is selected by Note\_On MIDI events. [This works
out so that for melodic MIDI channels, Note On plays, at a particular
frequency, an instrument selected by a preceding Program\_Change MIDI
event. For drum MIDI channels, Note On sounds a particular percussion
instrument within a drumkit selected by a preceding Program\_Change MIDI
event.]

*Perhaps you could help me with this one.. I have some default set of
pats from Debian plus the eawpats and also at least 4 full GM
soundfonts. What is the best mechanism for me to be able to pull
different GM sets from a midi file ? I can grok changing instruments
within a single GM context (whether pat or soundfont) but how to manage
various complete GM sets is just a complete blank for me ?*

The best way to select between "sets" is to have multiple Timidity
configuration files, one for each "set". [Then those individual
configuration files specify the various GUS patch and/or .sf2 files
which make up that "set".] You then would use a parameter when invoking
Timidity, to indicate \*which\* configuration file you want Timidity to
use.

*And is it possible to have two seperate GM sets playing at the same
time off a single instance of timidity (so the instruments sound
fatter) ?*

Not as far as I know.

*For some midi files, if I could hear play back the eawpats plus this
140Mb gm.sf2 I have then I'm pretty sure it would improve the overall
sound if the two instruments sets could be heard at the same time.*

Remember that Timidity uses ony \_\_one\_\_ set of sounds. If you
specify more than one "set" in the configuration file, Timidity will use
the most recently specified sounds (and ignore duplicate sounds
specified earlier in the configuration file). [Notice what I did - I
specified a .sf2 file to be used to "fill in" those sounds that I did
not have individual GUS patches for.]

*You mention XG, if I understand correctly, there are 1024 sounds and
ALSO the ability for NNPN(?) controls to add some extra effects or
something. Can timidity take advantage of real XG built midi files and
play them back "properly" (assuming the set of sounds were available) ?*

That's a function of how capable the Timidity software is. They
implement some of the controllers but not all of them. [I have not
checked, but I doubt whether they have implemented many of the
controllers introduced by XG.] What makes XG much more "iffy" with
Timidity is that many XG MIDI files set a whole wagonload of SYSEX
parameters. I'm fairly positive that Timidity does \*not\* support XG
SYSEX variants - meaning that Timidity can play back XG MIDI files
(perhaps substituting for those XG instruments it does not have), but
will OMIT much of the "bells and whistles" whereby XG MIDIs typically
"customize" sound playback.

DISCLAIMER: What Mikus wrote here is what he believes. Mikus makes no
claim that it is correct.

(example timidity configs to come)

Thank you for your comments Mikus.

Retrieved from
"[http://alsa.opensrc.org/TiMidityConfig](http://alsa.opensrc.org/TiMidityConfig)"

[Category](/Special:Categories "Special:Categories"):
[Software](/Category:Software "Category:Software")

