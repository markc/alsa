Arecord
=======

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

**arecord** is a simple native ALSA command line wav recorder.

Usage
-----

` `

       Usage: arecord [OPTION]... [FILE]...
       
       --help                  help
       --version               print current version
       -l, --list-devices      list all soundcards and digital audio devices
       -L, --list-pcms         list all PCMs defined
       -D, --device=NAME       select PCM by name
       -q, --quiet             quiet mode
       -t, --file-type TYPE    file type (voc, wav, raw or au)
       -c, --channels=#        channels
       -f, --format=FORMAT     sample format (case insensitive)
       -r, --rate=#            sample rate
       -d, --duration=#        interrupt after # seconds
       -s, --sleep-min=#       min ticks to sleep
       -M, --mmap              mmap stream
       -N, --nonblock          nonblocking mode
       -F, --period-time=#     distance between interrupts is # microseconds
       -B, --buffer-time=#     buffer duration is # microseconds
       -A, --avail-min=#       min available space for wakeup is # microseconds
       -R, --start-delay=#     delay for automatic PCM start is # microseconds
                               (relative to buffer size if <= 0)
       -T, --stop-delay=#      delay for automatic PCM stop is # microseconds from xrun
       -v, --verbose           show PCM structure and setup (accumulative)
       -I, --separate-channels one file for each channel
       Recognized sample formats are: S8 U8 S16_LE S16_BE U16_LE U16_BE S24_LE S24_BE U24_LE U24_BE S32_LE S32_BE U32_LE U32_BE FLOAT_LE FLOAT_BE FLOAT64_LE FLOAT64_BE IEC958_SUBFRAME_LE IEC958_SUBFRAME_BE MU_LAW A_LAW IMA_ADPCM MPEG GSM SPECIAL S24_3LE S24_3BE U24_3LE U24_3BE S20_3LE S20_3BE U20_3LE U20_3BE S18_3LE S18_3BE U18_3LE
       Some of these may not be available on selected hardware
       The availabled format shortcuts are:
       -f cd (16 bit little endian, 44100, stereo)
       -f cdr (16 bit big endian, 44100, stereo)
       -f dat (16 bit little endian, 48000, stereo)

[SBliveCapture](/SBliveCapture "SBliveCapture") is an example of using
arecord in a shell script.

Retrieved from
"[http://alsa.opensrc.org/Arecord](http://alsa.opensrc.org/Arecord)"

[Category](/Special:Categories "Special:Categories"):
[Alsa-utils](/Category:Alsa-utils "Category:Alsa-utils")

