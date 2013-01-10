Hdsp
====

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Contents
--------

-   [1 RME Hammerfall DSP](#RME_Hammerfall_DSP)
-   [2 modules.conf](#modules.conf)
-   [3 Extra notes](#Extra_notes)
-   [4 See also](#See_also)

RME Hammerfall DSP
------------------

[PaulDavis](/User:PaulDavis "User:PaulDavis") is the maintainer of the
code for this card.

`modules.conf`
--------------

PaulDavis has supplied his audio section from his `modules.conf` file.

*This is the audio-related section. The only option you need worry about
is the `snd-enable` option to \</code\>snd-hammerfall-mem.o\</code\>,
and even that is optional because by default the module will just
allocate memory for every Hammerfall or Hammerfall DSP device that it
finds.*

` `

    # Audio

    # soundcore is the multiplexer for any and all sound drivers
    # and ALSA hangs from major device 116

    alias char-major-14 soundcore
    alias char-major-116 snd

    # soundcore/OSS service number notes:
    # 0: /dev/mixer
    # 1: /dev/sequencer
    # 2: /dev/midi
    # 3: /dev/dsp
    # 4: /dev/audio
    # 5: /dev/dspW
    # 6: sndstat
    # 8: /dev/music
    # 9: /dev/synth
    # 10: /dev/dmfm
    # 12: /dev/adsp

    # Four soundcards. 
    # OSS-style opens look for sound-slot-N
    # ALSA-style opens look for snd-card-N

    alias sound-slot-0 snd-card-0
    alias sound-slot-1 snd-card-1
    alias sound-slot-2 snd-card-2
    alias sound-slot-3 snd-card-3

    alias snd-card-0 snd-wavefront
    alias snd-card-1 snd-trident
    alias snd-card-2 snd-rme9652
    alias snd-card-3 snd-hdsp

    # First soundcard is a Turtle Beach Tropez+, which has a CS4232 (with
    # an ad1848 CODEC), the usual OPL3, and an ICS2115 wavetable
    # synthesizer with its own MIDI interface.  

    # Here, we leave the CS4232 
    #MIDI interface undefined, since it uses a
    # physical interface that is only accessible from within the case of
    # the machine and I'm not interested in using it. To use it, set:
    #
    #   snd_cs4232_mpu_port
    #   snd_cs4232_mpu_irq

    options snd-wavefront snd_id="Tropez+"
    options snd-wavefront-synth \
        reset_time=100 \
        debug_default=0xffff \
        wf_raw=1

    alias sound-service-0-0 snd-mixer-oss
    alias sound-service-0-3 snd-pcm-oss
    alias sound-service-0-12 snd-pcm-oss

    # Second soundcard is HoonTech SoundWave 4D-NX, based on
    # the Trident 4D-NX chip. 

    options snd-trident snd_id="4D"

    alias sound-service-1-0  snd-mixer-oss
    alias sound-service-1-3  snd-pcm-oss
    alias sound-service-1-12 snd-pcm-oss

    # Both the RME9652 and Hammerfall DSP drivers use
    # the snd-hammerfall_mem module.

    options snd-hammerfall_mem snd_enable=1,1

    # Third card is an RME Digi9652 (Hammerfall)
    # It offers nothing but pure digital PCM 

    options snd-rme9652 snd_id="9652"

    # Fourth card is an RME Hammerfall DSP card
    # It offers variety of things

    options snd-hdsp snd_id="hdsp"

Trevor added: *I gave up on ALSA for my Libretto 70, went back to OSS.
Using the Gentoo distribution of ALSA. The midi\_port definition is
where it hangs A true bug, but the kernel OSS module opl3sa2 works fine.
-- trevor @ dontspam me @ trevormarshall dotty com*

Extra notes
-----------

1.  The initial [HDSP release
    notes](/HDSP_release_notes "HDSP release notes").
2.  JeremyHall provided this info for a working [RME Hammerfall
    .asoundrc](/RME_Hammerfall_.asoundrc "RME Hammerfall .asoundrc")
    file which may be useful for the HDSP.

See also
--------

-   [cmipci](/Cmipci "Cmipci")

Retrieved from
"[http://alsa.opensrc.org/Hdsp](http://alsa.opensrc.org/Hdsp)"

[Category](/Special:Categories "Special:Categories"): [ALSA
modules](/Category:ALSA_modules "Category:ALSA modules")

