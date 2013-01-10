Ardour
======

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

This is a seed page to encourage anyone to add any information about one
of the most important linux based audio tools.

**2005-03-07**

A LAU mailing-list user wanted to up-sample his 44.1Khtz session files
to 48Khtz and made these observations: *I used Erik de Castro Lopo's
[sndfile-resample](?title=Sndfile-resample&action=edit&redlink=1 "Sndfile-resample (page does not exist)")
from [mega-nerd.com](http://www.mega-nerd.com/SRC/). However when I
started ardour again and played the song, at the beginning of each
inserted WAV the sound was muted (as if it was clipped). It is an ardour
problem because with
[rezound](?title=Rezound&action=edit&redlink=1 "Rezound (page does not exist)")
I checked that the files were perfectly upsampled. Finally, in ardour, I
had to trim some WAVS at the beginning and everything was solved. Weird
but it worked. Here is the script I executed in the "sounds" folder of
ardour's session to upsample my WAVS to 48k. Hope it is useful for
somebody. Warning: don't use it without making a copy of the ardour's
session first.* ` `

    #!/bin/sh
    if [ "$1" = "" ]; then
        RATE=48000
    else
        RATE=$1
    fi
    echo "All wav files will be overwritten & upsampled at ${RATE}Hz"
    echo "be careful. Press Enter to continue..."
    read

    for file in *.wav; do
        echo "Upsampling to ${RATE}Hz $file..."
        sndfile-resample -to $RATE "$file" "$file.tmp"
        mv "$file.tmp" "$file"
    done

**2005-02-08**

JanDepner wrote on the [LAU](/LAU "LAU") mailing-list:

*Do you want to use multiband compression on a single track or on the
mix? If you want to use it on the mix just run Ardour's master bus out
to
[JAMin](?title=JAMin&action=edit&redlink=1 "JAMin (page does not exist)")
and then back into a new stereo track.*

*Speaking of jamin and compression, what are some good books that would
teach a person what these tools are for? Preferably it would be more
than a ProTools book and more of a general recording/mixing techniques
book. I am brand new to the idea of recording so I am pretty lost when
it comes to using any of this stuff for more than the very basics. I
tried using some compression and noise gates in one of my recordings and
just broke stuff. I don't understand things like "write,play,touch" in
the menus so I can't really use any of it effectively.*

I don't understand touch either  ;-) To use the other two just set to
'write' mode, play the track, adjust gain/pan to taste, stop, set to
'play' mode, rewind and play. That's it. For effects, Harmony Central
effects resources is a good place to start.

-   [http://www.harmony-central.com/Effects/](http://www.harmony-central.com/Effects/)
-   [http://www.tcelectronic.com/media/bobkatz.pdf](http://www.tcelectronic.com/media/bobkatz.pdf)
-   [http://www.prorec.com/prorec/articles.nsf/articles/8A133F52D0FD71AB86256C2E005DAF1C](http://www.prorec.com/prorec/articles.nsf/articles/8A133F52D0FD71AB86256C2E005DAF1C)
-   [http://www.theprojectstudiohandbook.com/directory.htm](http://www.theprojectstudiohandbook.com/directory.htm)
-   [http://www.tweakheadz.com/compressors.htm](http://www.tweakheadz.com/compressors.htm)
-   [http://www.rogernichols.com/DAEQ.html](http://www.rogernichols.com/DAEQ.html)

[Reuben
Martin](?title=User:ReubenMartin&action=edit&redlink=1 "User:ReubenMartin (page does not exist)")
added a comment about "touch":

It's just a different way of setting up automation. It's sort of like
the "touch" command from the CLI. It inserts a control point at the
current location without actually changing it's current value.

Retrieved from
"[http://alsa.opensrc.org/Ardour](http://alsa.opensrc.org/Ardour)"

[Category](/Special:Categories "Special:Categories"):
[Software](/Category:Software "Category:Software")

