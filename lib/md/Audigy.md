Audigy
======

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

2005-02-08
----------

KimKlinkhamer wrote in the [LAU](/LAU "LAU") mailing-list: In an effort
to help, here is what I did to get my Audigy 2 value card woking under
Fedora Core 3 in 5.1 speaker mode. You MUST use 1.08 from the alsa site,
it is not supported in anything before that. My kernel is either 2.6.9
or 2.6.10 downloaded as source from **kernel.org**, compiled with oss
not included, and alsa as modules, and either kernel works fine. I
downloaded all the alsa files, and installed them in this order:
**driver, lib, oss, utils**

To install the driver (as root) I did

` `

    ./snddevices
    ./configure \
     --prefix=/usr \
     --with-cards=emu10k1 \
     --with-sequencer=yes \
     --with-oss=yes&&make
    make install

Then in turn in each of the lib, oss etc directories.

` `

    ./configure --prefix=/usr && make && make install

The relevant bits from my modprobe.conf are:

` `

    alias char-major-116 snd
    alias snd-card-0 snd-emu10k1
    alias snd-slot-0 snd-card-0
    alias sound-service-0-0 snd-mixer-oss
    alias sound-service-0-1 snd-seq-oss
    alias sound-service-0-3 snd-pcm-oss
    alias sound-service-0-8 snd-seq-oss
    alias sound-service-0-12 snd-pcm-oss
    install snd-emu10k1 /sbin/modprobe --ignore-install snd-emu10k1 && 
    /usr/sbin/alsactl restore >/dev/null 2>&1 || :
    remove snd-emu10k1 { /usr/sbin/alsactl store >/dev/null 2>&1 || : ; }; 
    /sbin/modprobe -r --ignore-remove snd-emu10k1

Then went into alsamixer and unmuted stuff, and turned off the IEC958
output (spdif). If anybody has any questions, post them here and I'm
happy to get the answers from my PC.

See also
--------

-   [audigyls](/Audigyls "Audigyls")
-   [audigyes](/Audigyes "Audigyes")
-   [audigyls\_capture](/Audigyls_capture "Audigyls capture")
-   [audigyls\_playback](/Audigyls_playback "Audigyls playback")
-   [AudigyMixer](/AudigyMixer "AudigyMixer")
-   [AudigyMixerControls](/AudigyMixerControls "AudigyMixerControls")
-   [emu10k1](/Emu10k1 "Emu10k1")
-   [SBliveMixerControls](/SBliveMixerControls "SBliveMixerControls")
-   [SBliveValue](/SBliveValue "SBliveValue")
-   [usb-audio](/Usb-audio "Usb-audio")

Retrieved from
"[http://alsa.opensrc.org/Audigy](http://alsa.opensrc.org/Audigy)"

[Category](/Special:Categories "Special:Categories"): [Sound
cards](/Category:Sound_cards "Category:Sound cards")

