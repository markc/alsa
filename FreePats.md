FreePats
========

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

This Wiki page exists to encourage and help coordinate the development
of a completely free and open set of instrument samples, in wav format,
that could be used as a base for a SoundFont or GUS compatible patches,
or any other instrument format if possible.

If anyone has **ANY** unencumbered and freely redistributable instrument
samples that could be used in some sound font format then please email
**freepats at zenvoid dot org** to arrange to upload the samples to the
[Freepats Repository](http://freepats.zenvoid.org) where others can use
them.

Contents
--------

-   [1 Latest News](#Latest_News)
    -   [1.1 2006-02-18](#2006-02-18)
    -   [1.2 2006-02-10](#2006-02-10)
    -   [1.3 2005-02-10](#2005-02-10)
    -   [1.4 2004-06-20](#2004-06-20)
    -   [1.5 2004-06-18](#2004-06-18)
    -   [1.6 2004-03-10](#2004-03-10)

-   [2 Freepat License Example](#Freepat_License_Example)
-   [3 See also](#See_also)

Latest News
-----------

### 2006-02-18

OK. Upload successful. We have a new FreePats release! The new drum
patches and their associated txt files are in the drum subdir, along
with three extra 2006-copr\* files that are referred to from the txt
files. Probably way too much information. But I \*think\* this shows
these patches are GPL compatible. There is a draft revised readme as
2006b18-copr-freepats.txt in the freepats dir. Also a new
2006b18-full.cfg, which is like crude.cfg but adds the drums. Oh, and a
little rant on the copyright situation, which seems like it's really
getting out of hand -- you'll probably want to delete that, we can't
change the world:) Also, I put the zip file there, in case you might
want it. It unzips into the directory structure, so if somebody already
had freepats and downloaded just the little zip, unzipping it would
theoretically add the new patches in the right place, so they'd just
need to update their cfg.

A possible bug would be in the TXT files, I included a line 1 with
amp=100, but I just realized my test config file doesn't include that
after the patches, so i \*hope\* that it's supposd to read 'amp' and not
'amplification' or some such thing, or I'll have to fix the first line
in the text files.

walt@w-gregg.juneau.ak.us

### 2006-02-10

From: walt@w-gregg.juneau.ak.us

To: freepats@opensrc.org

Date: 9 Feb 2006 08:36 pm

I sent you a message the other day inquiring of whether you have
considered the possiblity of using Tom Roscoe's Propats 3.0 from 1994 to
fill out freepats, especially in the drums.

Well, I have some good news and bad news about that idea.

The good news is that I received a reply from Tom Roscoe indicating that
he will allow the use of his sound samples. He just asks attribution for
him and his company. If you'd a like a copy of his message, I can
forward it.

The bad news is that there is a note at the bottom of the readme
indicating the instruments that were sampled. And some of them are
digital synthesizers that have their sound samples 'fixed' in ROM chips.
So there might be a question of whether the recording and sampling of
selected samples from those synthesizers without their maker's
permission is permissible. Personally, I don't see how individual static
sound samples can be considered a creative work. They're certainly not a
performance. They should have the same status as the individual letters
of an alphabetic font. In fact, after you sample a sound and then edit
it, it's not really even clear that it can be considered the \*same\*
sound; it's been modified and no human ear has ever heard that
particular sound until it has been reproduced, so it's not a derivative
sound, it's really a brand new sound. But I can easily imagine a
synthesizer maker claiming otherwise. And who can afford to defend
against such a claim? In short, even though Tom Roscoe will give
permission, it might be necessary to consult an attorney to find out
whether that is actually sufficient authority to use them safely in a
free for all uses package.

Tom Roscoe is doubtful of whether you'll want to use the patches anyway.
He points out that they were rather severely limited because of the
capabilities of the GUS card at the time. But I just thought I would let
you know that they are at least a possibility.

There's also the Dustin McCartney patches. The WOW pats, and the
GSDRUM00 (and more). I don't know whether he would give similar
permission or not. And these don't indicate what they were sampled from,
so they may have the same underlying problem.

I suppose the only foolproof solution would be to make patches from
original analog instruments, so you would know for certain they didn't
come from any digital synthesizer, and who even knows how to do that?

Moved from another page: *Freepats is an excellent idea, and with tonal
instrument substituations, it's almost usable. But the drumkit lacks
tom-toms and various other percussive instruments, and there are no
suitable substitutes. I've found this troubling enough to make some
patches that fill out the drumkit. I think they make freepats much more
usable. The tom-tomes are from free samples of an analog synthesizer,
and the other sounds are from the Wikimedia commons or are modified
freepats sounds. They're not that great, but a lot better than silence.
If you are interested in having copies of these for possible use in
freepats, I can provide more details. Please e-mail me using walt [at]
w-gregg.juneau.ak.us. Bye!*

### 2005-02-10

There is no recent news or additions to the repository but this page has
been cleaned up and I believe the license issue is now resolved. See
modified GPL license below. **Please**, anyone, if you have any
instrument samples lying around that you can donate to this project,
please make contact at the above email address and upload your
instrument sample so we can continue trying to complete at least the GUS
compatible GM font set and start towards other formats. Thanks to Eric
A. Walsh we have a good base to start from... let's continue the effort.

24 bit / 96 kHtz wav samples are most welcome as they can then be
remastered into just any format with maximum fidelity. The ultimate aim
is to have lo-fi AND hi-fi versions of GUS compatible patches (for use
with Timidity) and a v2.01 compatible GM SoundFont.

### 2004-06-20

Copyright attribution issue almost resolved. There will be individual
copright notices for anyone that contributes and cares to UPDATE THE
COPYRIGHT NOTICE THEMSELVES ! :-)

### 2004-06-18

We have an example license offerring down below. It seems the only
remaining issue is the attribution to the FSF so if anyone has comments
or suggestions about this final point then please say so.

### 2004-03-10

Site established and awaiting some patches to be upload from Eric.

Freepat License Example
-----------------------

` `

    FreePats - a set of sound fonts for use in audio synths.
    Copyright (C) 2004 Eric A. Walsh

    This patch set is free software; you can redistribute it
    and/or modify it under the terms of the GNU General Public
    License as published by the Free Software Foundation;
    either version 2 of the License, or (at your option) any
    later version.

    This patch set is distributed in the hope that it will be
    useful, but WITHOUT ANY WARRANTY; without even the implied
    warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR
    PURPOSE. See the GNU General Public License for more
    details.

    As a special exception, if you create a composition which
    uses these patches, and mix these patches or unaltered
    portions of these patches into a composition, these
    patches do not by themselves cause the resulting
    composition to be covered by the GNU General Public
    License. This exception does not however invalidate any
    other reasons why the document might be covered by the GNU
    General Public License. If you modify these patches, you
    may extend this exception to your version of the patches,
    but you are not obligated to do so. If you do not wish to
    do so, delete this exception statement from your version.

    You should have received a copy of the GNU General Public
    License along with this program; if not, write to the
    Free Software Foundation, Inc.,
    59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.

See also
--------

-   [Freepats Repository](http://freepats.opensrc.org)
-   [Timidity](/Timidity "Timidity")
-   [WildMidi](/WildMidi "WildMidi")
-   [GusSoundfont](/GusSoundfont "GusSoundfont")
-   [OpenCubicPlayer](/OpenCubicPlayer "OpenCubicPlayer")

Retrieved from
"[http://alsa.opensrc.org/FreePats](http://alsa.opensrc.org/FreePats)"

[Category](/Special:Categories "Special:Categories"):
[Software](/Category:Software "Category:Software")

