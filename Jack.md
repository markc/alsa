JACK
====

### From the ALSA wiki

(Redirected from [Jack](?title=Jack&redirect=no "Jack"))

Jump to: [navigation](#mw-head), [search](#p-search)

Contents
--------

-   [1 What is JACK?](#What_is_JACK.3F)
-   [2 Jack and audio mixing](#Jack_and_audio_mixing)
-   [3 How to use oss2jack and Skype](#How_to_use_oss2jack_and_Skype)
-   [4 More JACK-specific documentation in this
    Wiki](#More_JACK-specific_documentation_in_this_Wiki)

### What is JACK?

Jack is a low-latency audio server that can connect the input and
outputs of a number of audio applications. It is different from other
audio server efforts in that it has been designed from the ground up to
be suitable for low-latency professional audio work.

[http://jackaudio.org/faq](http://jackaudio.org/faq)

An example of use, first start jack then start
[alsaplayer](/Alsaplayer "Alsaplayer") to play the stream (SomaFM radio,
in this case) and thirdly, start [ecasound](/Ecasound "Ecasound") to
record directly in [ogg](/Ogg "Ogg") format.

` `

    jackd -d alsa
    alsaplayer -i text -o jack -s somafm http://somafm.com/groovesalad.pls
    ecasound -i:jack_auto,somafm -o:somafm.ogg

### Jack and audio mixing

Since jack was designed for professionals and low latency, by default it
opens the first hardware device it find, usually "hw:0.0". Unlike most
applictions, it does not automatically route thru dmix. This means that
if you want to mix several audio streams in software for output, the
streams must talk to jackd. To force jackd to use dmix instead, allowing
other apps to function as normal (but adding latency to jack) it was
suggested the following command be used:

` `

    jackd -d alsa -P default :0

(This does not work on all systems)

### How to use oss2jack and Skype

Salvatore Di Pietro \<salvuz\_78 at virgilio dot it\> explains: Well
,it's not that complicated... I went to

[http://www.circlemud.org/%7Ejelson/software/fusd/](http://www.circlemud.org/%7Ejelson/software/fusd/)
[http://fort.xdas.com/\~kor/oss2jack/](http://fort.xdas.com/~kor/oss2jack/)

downloaded and installed fusk-kor and oss2jack. I am on Slackware 10.1,
which uses udev, so there were no problems with fusd. Now there's this
little wrapper called skype\_dsp\_hijacker

[http://195.38.3.142:6502/skype/](http://195.38.3.142:6502/skype/)

that enables you to choose the /dev/dspXX to use for in put and
/dev/dspYY to use for output (and /dev/mixerXX to be controlled by
skype)Once installed, start jack, then

` `

    oss2jack -n 100

then

` `

    MICDEV=/dev/dsp100 \
    SPEAKERDEV=/dev/dsp100 \
    LD_PRELOAD=/usr/lib/libskype_dsp_hijacker.so:/usr/lib/libdl.so skype

and the trick is done!

### More JACK-specific documentation in this Wiki

-   [SurroundSound](/SurroundSound "SurroundSound")
-   [jack (plugin)](/Jack_(plugin) "Jack (plugin)")

Retrieved from
"[http://alsa.opensrc.org/JACK](http://alsa.opensrc.org/JACK)"

[Category](/Special:Categories "Special:Categories"):
[Software](/Category:Software "Category:Software")

