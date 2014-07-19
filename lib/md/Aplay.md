# Aplay

**aplay** is a simple native ALSA wav player.

Contents
--------

-   [1 Usage](#Usage)
-   [2 Questions](#Questions)
    -   [2.1 Device name](#Device_name)
    -   [2.2 What's a PCM output?](#What.27s_a_PCM_output.3F)

## Usage

       Usage: aplay [OPTION]... [FILE]...
       
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

Aplay can be used to test, if your pcm outputs are working. Be sure to
unmute and set volume for master and pcm channels with ((amixer)) first.
It might be a good idea to set a moderate volume level for not damaging
your boxes. Then call

       aplay -Dhw:0,0 /boot/vmlinuz!

If you hear a terrible noise, your hardware works. If you have pcm coded
files such as .wav files at hand you might want to use these instead.

Note that by using the -d switch you choose card number and pcm output
of the card. If you already configured your
[.asoundrc](/.asoundrc ".asoundrc") you may use name aliases defined
there.

## Questions

### Device name

It would be nice to have "device name" explained (i.e. hw:0,0)

*It's ALSA-geek-speak for the initial hardware device that will convert
digitzed sample to a smooth analog voltage or vice-versa. See below.*

`aplay -D` will accept the output of `aplay -L` as device names. So, for example, my output has the lines

    hdmi:CARD=HDMI,DEV=0
        HDA ATI HDMI, HDMI 0
        HDMI Audio Output

The top line of that (`hdmi:CARD=HDMI,DEV=0`) will be directly accepted by `aplay -D` like so:

    aplay -Dhdmi:CARD=HDMI,DEV=0

It would be even nicer if the --help and man output of *aplay* would
define what NAME of "--device=NAME" should be set to. Then people would
not have to search the Internet to find out.

It would be even nicer still if the device name appeared in the output
of *aplay -l*. Surely that's pretty fundamental - when a user lists
available devices give them the names that you expect to see back.
Probably some UI design principle of least surprise applies!

### What's a PCM output?

*PCM stands for Pulse Code Modulation where analog volume is sampled at
so many kilohertz (1000s times per second) and a snapshot of the voltage
at that point becomes a digitzed sample. **PCM output** would refer to
the hardware part of a soundcard that takes a digital waveform (that may
have been a wav or mp3 file on a hard drive) and converts it back into a
smooth analog oscillating voltage that can produce sound from speakers
or headphone, once amplified to a suitable level.*

