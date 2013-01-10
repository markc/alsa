GusSoundfont
============

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Contents
--------

-   [1 GUS patches vs. AWE Soundfonts](#GUS_patches_vs._AWE_Soundfonts)
-   [2 Extracting GUS patches from
    Soundfonts](#Extracting_GUS_patches_from_Soundfonts)
-   [3 Demonstration software](#Demonstration_software)
-   [4 Extended GUS patches](#Extended_GUS_patches)
-   [5 Config file syntax](#Config_file_syntax)
-   [6 Comments](#Comments)

GUS patches vs. AWE Soundfonts
------------------------------

**by [Greg Lee](mailto:greg@ling.lll.hawaii.edu)**

GUS patches are more convenient to work with, I find, than big
monolithic Soundfonts. You don't need a special utility to reconfigure
your instrument banks or to tune up individual instruments in minor
ways, for instance. And there are some midi players that can read GUS
patches but can't deal with Soundfonts. On the other hand, the GUS patch
world is moribund, and instruments in Soundfonts can have more features
than are implemented in GUS patch files. E.g., velocity layers, stereo
instruments, parameters to control an extra LFO, and so on.

There's a way to have the advantages of both GUS patches and Soundfonts.
We need a tool to break up Soundfonts into sets of GUS patches and, to
keep the musical advantages of Soundfont instruments, a way to extend
the GUS patch format to comprehend the richer characterizations of the
instruments in Soundfonts.

A subsidiary point concerns how config files describe instruments and
banks of instruments for GUS patches and Soundfonts. For midi players
that understand both Soundfonts and GUS patches, it would be convenient
to have a unified config file syntax that characterizes intruments and
banks in the same way for GUS and Sf2.

Extracting GUS patches from Soundfonts
--------------------------------------

George Foot (*gfoot at users dot sourceforge dot net*) already wrote a
program to extract GUS patch files from a Soundfont. It's part of a tool
distributed with the *Allegro* game programming library and is called
*pat2dat*. It didn't quite suit my purposes, so I rewrote parts and
called the new version [unsf](/Unsf "Unsf"). The source code is in the
package of demo programs described below. [unsf](/Unsf "Unsf") finds
each instrument in a given Soundfont, writes out a GUS style config
file, creates a directory for each melodic and percussion bank in the
Soundfont, then creates GUS patches for every instrument and puts the
files into the bank directories it made.

Instruments and percussion banks are named in Soundfonts, but the names
often have troublesome characters in them, so [unsf](/Unsf "Unsf") fixes
up the names before using them as names of files and directories. The
patch files are in the extended GUS format described two sections below.

This utility program and all of the programs mentioned below are for
Linux. Whether they can be used on other systems, I don't know.
[unsf](/Unsf "Unsf") may be useable on bigendian systems, but this is
untested.

If someone knows of a Soundfont whose samples are really freely
distributable, it's possible that [unsf](/Unsf "Unsf") could make some
contribution to the mission of *freepats*.

Demonstration software
----------------------

Source code for the just described tool [unsf](/Unsf "Unsf") and other
related software can be found in this [ftp
archive](ftp://ling.lll.hawaii.edu/pub/greg/gt-0.3.tar.gz). There is:

-   [unsf](/Unsf "Unsf")
-   a primitive utility
    [patinfo](?title=Patinfo&action=edit&redlink=1 "Patinfo (page does not exist)")
    which displays information about a GUS extended patch
-   a utility [sf2cfg](/Sf2cfg "Sf2cfg") to create GUS-type config files
    for Soundfonts (see the section below on config file syntax)
-   a stripped down version of Timidity called [gt](/Gt "Gt") that reads
    Soundfonts, ordinary GUS patches, and extended GUS patches, and also
    understands extended config file syntax. This version has only a
    single sound driver for Linux Alsa and will give you surround 4 or 6
    channel sound if you have a capable soundcard hooked up to speakers
    by analog connections.
-   other utilities to create stereo extended GUS patches and to
    disassemble midi files
-   a little more, sketchy, documentation

There are some example 6 channel ogg files derived from midis using
[gt](/Gt "Gt") and patches extracted from a large soundfont by
[unsf](/Unsf "Unsf") in
[gt-demo](ftp://ling.lll.hawaii.edu/pub/greg/gt-demo.tar.gz)

In addition, the current CVS version of [SDL and
SDL\_mixer](http:////www.libsdl.org/index.php) includes a midi player,
derived from timidity, which I've modified to read extended GUS patches
(and also to do surround sound on Linux).

Extended GUS patches
--------------------

It might not be 100% true that the GUS patch format is insufficient to
describe Soundfont instruments. The are fields in the GUS patch header
characterized as *layers* and *instruments* that could potentially be
made use of. But for practical reasons, extra Soundfont information has
to be hidden inside the patch, so as to be compatible with programs that
know only about ordinary GUS patches. For instance, Timidity's patch
file reader will not even try to load a patch file which says it has
more than one layer or more than one instrument.

Luckily, the GUS format provides several unused, reserved areas, and
extra information can be tucked away there, so that programs unaware of
the sf2 extensions to GUS patches can still read and use the patches.
There are two 40 byte reserved areas in the GUS patch area which I
propose to use for velocity and stereo layer information, and there is a
36 byte reserved area in the GUS sample header which I want to use for
sf2 parameters such as modulation envelope points.

There is room in the reserved areas of GUS patch headers to keep
information about 19 velocity layers (by which I mean sets of sound
samples tuned to timbres produced by making louder or softer notes). I
hope that's enough. The highest number of layers I've encountered so far
in an sf2 instrument is 12. An sf2 velocity layer can have a single set
of samples (each sample for a different key range), or two, in the case
of a stereo instrument. An unaware midi player or synth will see only
the left channel of the first velocity layer, but there will be
additional samples after the first one, and aware programs can find out
about them by examining the hidden information in the patch header.

I've tried out Timidity++, which knows practically nothing about
velocity layers, on the extended GUS patches produced by
[unsf](/Unsf "Unsf"), and it plays them just fine.

Here are details about the extended GUS format: [detailed
format](/Detailed_format "Detailed format")

Config file syntax
------------------

There is no need to extend the syntax of cfg files to accommodate
extended GUS patches, except, I suppose one might want add some options
for sf2 parameters. However, the config syntax worked out by Takashi
Iwai for Soundfonts, which is used in Timidity++, leaves something to be
desired. So far as I know (I confess to never actually having used it),
it doesn't allow choosing or rejecting individual patches within
Soundfonts, or making changes like volume adjustments to specific
patches. The config file reader of my demo version of Timidity, on the
other hand, works for sound fonts almost the same as for GUS patches.
Two differences of detail are:

-   banks of Soundfont instruments have to be designated as such with a
    suffix *sf2*, e.g., instead of *bank 1* in a config file before the
    GUS patches for bank 1, put *bank 1 sf2 bankname*.
-   after having declared some Soundfont banks and patches, add *sf2
    \<filename\>* to what Soundfont file you want to load the preceding
    sf2 banks from.

In the case of GUS patches, of course the names given for patches have
to be pathnames of actually existing files, but for Soundfonts, the
names you give for patches or banks can be anything you make up. The
Soundfont reader digs out the samples by bank and instrument number; the
specific names used don't matter.

The downside to this way of configuring Soundfonts for use is that you
have to declare in the config file the banks and instruments you want,
otherwise they won't be loaded. Using Iwai's method is much simpler in
this respect. And how do you know just what banks and instruments are
there inside the Soundfont so that you can prepare a config file? Since
that's not straightforward, I provided the utility
[sf2cfg](/Sf2cfg "Sf2cfg"), which examines a Soundfont and automatically
constructs a config file for it. You can then edit the config file as
convenient.

Comments
--------

*This is an excellent proposal, thank you Greg!*

*Very nice. Perhaps you might include the JACK sound driver...*

*Very nice. Perhaps you might include your thoughts on the origins of
the universe*

Retrieved from
"[http://alsa.opensrc.org/GusSoundfont](http://alsa.opensrc.org/GusSoundfont)"

[Category](/Special:Categories "Special:Categories"):
[MIDI](/Category:MIDI "Category:MIDI")

