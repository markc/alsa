Via686a
=======

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

via82xx
-------

This driver supports VIA's 82c686A, 686B and similar chips found in
motherboards from many manufacturers. It's an AC97 chipset.

Mixer controls
--------------

As usual, ALSA provides a host of controls for the mixer on VIA's
chipset. Because this chipset is used by many OEMs you may find some
variation in the applicability of these instructions. If your board
doesn't appear to actually have a phone connector, or multiple
microphone sockets then those controls simply won't work, ALSA will mute
them by default and you can ignore them.

-   Master - This controls the analog output level (for example to your
    headphones). Unmute and set to a comfortable level, try somewhere
    around 70-90%.
-   PCM - Controls the level from the ALSA PCM playback device. ie your
    MP3s, Game sounds etc. Unmute and set to a comfortable level, try
    100% unless this causes distortion.
-   Line - Sound from the Line In connector (if any). Mute to reduce
    noise, unless you want to listen to something from Line In
-   CD - Sound from the CD or DVD drive, if there's one connected. Used
    only when the drive itself is playing audio. Mute when not in use.
-   Mic - Sound from the Mic In line. Once again mute when not in use.
-   Video/ Phone/ PC Speaker/ Aux - More input levels, unlikely to be
    connected. Mute.

This brings us to the capture controls, which affect recording only.
Ordinarily there's no direct connection between what you hear, and what
ALSA is recording (but you can change that as we'll see). You really
need a software meter (VIA's chipset doesn't support a hardware meter)
to know whether your levels are OK while recording, using video
conferencing software etc. If your favourite application doesn't have
such a mater, ask the author to consider adding one.

Like most consumer cards VIA's chipset can record from one source at a
time. The choice of sources is: Line In, CD, Microphone, Video, Phone,
Aux, and Mix. The last choice is special, it records more or less what's
going to the Line Out, the result of the playback mixer controls. It's
not affected by the Master levels control.

In order for anything to be recorded the appropriate recording source
must be chosen and the Capture control turned on. You can also adjust
the input gain for the recorded sound with the capture control. Often a
relatively low level is best.

Module options
--------------

yast2 on SuSE has the following entries:

` `

    # modules.conf

    options snd-via686 snd_ac97_clock=48000 snd_enable=1 snd_index=0
    options snd snd_cards_limit=1 snd_major=116
    # hlTL.zRM_II+f8jA:AC97 Audio Controller
    alias snd-card-0 snd-via686

    # YaST2: sound system dependent part
    #
    alias sound-slot-0 snd-card-0
    alias sound-service-0-0 snd-mixer-oss
    alias sound-service-0-1 snd-seq-oss
    alias sound-service-0-3 snd-pcm-oss
    alias sound-service-0-8 snd-seq-oss
    alias sound-service-0-11 snd-mixer-oss
    alias sound-service-0-12 snd-pcm-oss

Retrieved from
"[http://alsa.opensrc.org/Via686a](http://alsa.opensrc.org/Via686a)"

[Category](/Special:Categories "Special:Categories"): [ALSA
modules](/Category:ALSA_modules "Category:ALSA modules")

