Timidity
========

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

TiMidity is a MIDI to WAVE converter and player that uses SoundFonts and
Gravis Ultrasound compatible patch files to generate digital audio data
from general MIDI files. It usually comes packaged with modern linux
distros but also requires a 10Mb plus set of patch files or SoundFonts
to be usable.

Contents
--------

-   [1 Links](#Links)
-   [2 Get CVS version](#Get_CVS_version)
-   [3 Some history](#Some_history)
-   [4 How to use TiMidity with MusE](#How_to_use_TiMidity_with_MusE)
-   [5 How to use Timidity with
    Noteedit](#How_to_use_Timidity_with_Noteedit)

Links
-----

-   [http://timidity.sourceforge.net/](http://timidity.sourceforge.net/)
    - Main development site
-   [http://wiki.debian.net/?Timidity](http://wiki.debian.net/?Timidity)
    In Debian with Graphics interface.
-   [http://timidity.s11.xrea.com/index.en.html](http://timidity.s11.xrea.com/index.en.html)
    - Windows binaries
-   [Bugtraker to report
    problems](http://timidity-docs.sourceforge.jp/cgi-bin/kagemai-en/guest.cgi)
-   [TiMidityConfig](/TiMidityConfig "TiMidityConfig") - more
    information about the config file
-   [FreePats](/FreePats "FreePats") - a project to develop an open set
    of GUS patches
-   The [EawPats](/EawPats "EawPats") which were at
    [http://www.stardate.bc.ca/eawpatches/html/default.htm](http://www.stardate.bc.ca/eawpatches/html/default.htm)
    are gone and have been replaced with the FreePats above.

Get CVS version
---------------

` `

    cvs -d \
     :pserver:anonymous@cvs.timidity.sourceforge.net:/cvsroot/timidity \
     login (just press return)
    cvs -d \
     :pserver:anonymous@cvs.timidity.sourceforge.net:/cvsroot/timidity \
     co timidity

Some history
------------

The original version of this program was written by Tuuka Tiovonen \<tt
at cgs dot fi\> until TiMidity 0.2i (he discontinued development because
he was too busy with work). Masanao Izumo \<mo at goice dot co dot jp\>
and other people began to hack it, then we officially released the new
version, which is called TiMidity++.

Toivonen's original TiMidity is also the basis for the midi player
*Kmidi*, the midi player plugin of *Alsaplayer*, [gt](/Gt "Gt") (see
[GusSoundfont](/GusSoundfont "GusSoundfont")), and the midi player of
[SDL/SDL\_mixer](http://www.libsdl.org/index.php), a popular games
programming library. (The CVS version of the last has Alsa surround
sound support.)

How to use TiMidity with [MusE](/MusE "MusE")
---------------------------------------------

This information is courtesy of BillAllen \<ballen at mail.serve.com\>
who was kind enough to answer my plea for help. TiMidity needs to be run
in server mode with settings similar to this ` `

    timidity -iA -B2,8 -Os -EFreverb=0 2>&1 &

Then run [MusE](/MusE "MusE") and in Config/Midi Ports, it has a list of
channels and the output device associated with that channel. You should
see TiMidity as one of the choices. Choose that for, say, channel 1.
Then, in the Track dialog, you've got to specify the output device for
each track. This is a pain if you're only using one device for all
tracks (maybe there's a way to specify that, but I don't know it), but
in general it is good because you can specify, say, timidity for the
drum, and piano tracks, then one or more soft synths for other tracks.
Be sure to run MusE as root or suid with priority at 98 as in "muse
-RP98".

How to use Timidity with Noteedit
---------------------------------

This is almost the same as Muse above. To configure Noteedit to use the
Timidity thingie go to the menu bar, Settings, Configure Noteedit,
Sound, and click on one of the Timidity ones, and hit okay. It should
work now.

Retrieved from
"[http://alsa.opensrc.org/Timidity](http://alsa.opensrc.org/Timidity)"

[Category](/Special:Categories "Special:Categories"):
[Software](/Category:Software "Category:Software")

