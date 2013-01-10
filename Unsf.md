Unsf
====

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

*Unsf* is a tool to convert [SoundFont](/SoundFont "SoundFont") files
into GUS patches. Some reasons you might want to do such a thing are:
(1) Your midi player can use GUS patches but doesn't know how to read
soundfonts, (2) You want a convenient way of substituting patches or
reassigning banks of instruments by editing GUS config files, or (3) You
need to modify patches by changing amplitude, stripping envelopes, or
make other changes that can easily be done by attaching options in
config files. Or (4), my own reason, you might need to use a version of
[timidity](/Timidity "Timidity") covered under the Lessor GNU Public
License and find that the versions of timidity that can read soundfonts
are protected by the more restrictive GNU Public License (e.g.,
Timidity++ or kmidi, or the Alsaplayer midi plugin).

Instrument samples embedded in soundfonts have a more complicated
structure, and have more features, than GUS patches. So breaking a
soundfont up into GUS patches loses information and quality, unless the
GUS patch format is extended. The patch files produced by unsf do
contain most of the information and structure they had as part of the
original soundfont, but the extensions to GUS format are tucked away in
hidden places, as they must be, to be compatible with programs expecting
to see ordinary GUS patches. I'll describe the extensions below.

*Unsf* is easy to use. If you're using a version of timidity, just put a
soundfont into the directory where you keep patches -- perhaps
/usr/local/lib/timidity -- then cd to that directory and say "unsf
filename.sf2". *Unsf* will create directories for each bank of
instruments in the soundfont and put the patch files for all the
instruments into the appropriate bank directories. The names of the
directories and patch files are derived from the names they were given
inside the soundfont. *Unsf* also creates a GUS type configuration file,
which will be called "\<filename\>.cfg", the \<filename\> part coming
from the name of the original soundfont. Edit timidity.cfg by adding the
line "source \<filename\>.cfg" and you're ready to use the new patches.

However, you won't hear any of the enhancements of sf2 instruments,
unless you use my reference version of timidity, because no other midi
players as yet know how to find the special information in the extended
GUS patch files. How could there be any? I just made up this extension
to GUS patch structure. What you will hear is only the keyrange set of
samples for the left channel of the first velocity layer. Sf2
instruments can have several velocity layers, meaning sets of samples
tuned for the different timbres produced by different note loudness, and
they can also be in stereo, with different sets of samples for the left
and right channels.

\
 This diagram describes the overall structure of sf2 and extended GUS
patches: ` `

                                                    key range 1   sample |GUS
                                    left channel    key range 2   sample |compatible
                 velocity range 1                        ...             |part
                                                    key range 1   sample
                                    right channel   key range 2   sample
                                                            ...

                                    left channel    ...
    Instrument   velocity range 2
                                    right channel   ...

                 velocity range 3   ...

                 ...

                 velocity range 19  ...

In addition to the extra sets of samples for various velocity (loudness)
ranges and for left and right channels, sf2 instruments have parameters
for controlling an extra low frequency modulator and a bandpass filter.
These parameters are also carried over into the extended GUS patches
produced by *unsf*. My reference version of timidity does not interpret
and use all this extra information, by any means, but it does understand
velocity ranges, stereo instruments, and a couple of the extra sf2
parameters: volume-envelope-delay and exclusive-class. The first delays
the beginning of note volume envelopes by a variable amount, and the
second causes notes of certain instruments to be terminated when a new
note of that instrument or an instrument in the same class is begun.

My reference version of timidity is the one contained the the SDL\_mixer
library of the gaming program library SDL (Simple Direct Layer),
[http://www.libsdl.org](http://www.libsdl.org), with my patches applied
to the SDL library and to the SDL\_mixer library. My patches are in the
archive:

[ftp://ling.lll.hawaii.edu/pub/greg/Surround-SDL.tgz](ftp://ling.lll.hawaii.edu/pub/greg/Surround-SDL.tgz)

I haven't convinced the maintainers of SDL to incorporate my changes
into the distributed version of SDL.

*(I have now made another reference timidity, this one free-standing. It
and*unsf*are in
[ftp://ling.lll.hawaii.edu/pub/greg/gt-1.0.tar.gz](ftp://ling.lll.hawaii.edu/pub/greg/gt-1.0.tar.gz).)*

For the details of the extensions to GUS patch structure, there are
three sources of information:

1.  the file GUSSF2-SPEC in the distribution,
2.  the source code of the utility patinfo, in the distribution, which
    illustrates how to loop over extended GUS patch files to retrieve
    the extra patches and parameters,
3.  the source code of my timidity version, mentioned above.

\

Greg Lee, \<greg@ling.lll.hawaii.edu\>

July 1, 2004

Comments
--------

Some Interesting work, I'm looking forward to exploring it further but
was stopped by Dead Links 2-1-06 - JWM This Whole Page is put Useless if
there is no file in
[ftp://ling.lll.hawaii.edu/pub/greg/gt-1.0.tar.gz](ftp://ling.lll.hawaii.edu/pub/greg/gt-1.0.tar.gz)
eariler versions gt-0.3 and gt-0.4 exist there, but no gt-1.0 in the
archive.

*Please fix this page so we can continue to examin the ideas here.*

I am also interested in any variations on timidity - I've been using it
since '96

Retrieved from
"[http://alsa.opensrc.org/Unsf](http://alsa.opensrc.org/Unsf)"

[Category](/Special:Categories "Special:Categories"):
[Software](/Category:Software "Category:Software")

