SBliveCapture
=============

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

20020711
--------

How to capture the SBlives internally generated wavetable synth sounds
to a wav, then an ogg, file while playing and listening to a MIDI file
using hardware loaded soundfonts. Many thanks to Dr. Matthias Nagorni
for the essential clues.

The first obvious step is to have ALSA correctly installed so you can
fire up [alsamixer](/Alsamixer "Alsamixer") to make sure these
particular controls are set to;

` `

      1 Master    90|90 unmute (m key)
      9 PCM       90|90
     19 Music     90|90 captur (space bar)
     20 Music Cap 90|90
        Capture    0|0 
    (add more if found to be required)

A note about Capture: this is really IGain, and will seriously distort
recording (MIDI at least).

Then simply use pmidi in one shell and arecord in another. Here is a
small shell script I used to make this process easier. It takes a single
argument of the MIDI file without the .mid extention and simplifies
converting a MIDI file to an ogg for net transfer.

` `

    #!/bin/sh
    set -e
    #set -x
    [ -z $1 ] && echo "Usage: record midifile (without .mid extention)" && exit 1
    TEMP=/var/tmp
    arecord -f cd $TEMP/$1.wav &
    pmidi -p 65:0 $1.mid
    killall arecord
    oggenc -q 5 $TEMP/$1.wav -o $TEMP/$1.ogg
    #rm $TEMP/$1.wav
    ls -l $TEMP

I use the above as /usr/local/bin/record (remember to chmod +x) and be
warned that TEMP can get quite large so make sure wherever you point it
to has lots of room. While it may seem crude to just kill the arecord
process it is remarkably accurate, a test run using 4 different
soundfonts on the same MIDI file produced exactly the same sized 20 Mb
wave files.

Retrieved from
"[http://alsa.opensrc.org/SBliveCapture](http://alsa.opensrc.org/SBliveCapture)"

[Category](/Special:Categories "Special:Categories"): [Sound
cards](/Category:Sound_cards "Category:Sound cards")

