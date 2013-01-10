Sbawe
=====

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Here is an example of a `/etc/modules.conf` which is known to work with
Creative SoundBlaster AWE 64 Gold ISA soundcards:

` `

    alias sound snd-sbawe
    options snd-sbawe snd_isapnp=1 snd_awe_port=0x620
    alias   char-major-116  sound
    alias   /dev/dsp        sound
    alias   /dev/music      sound
    alias   /dev/sound      sound
    alias   /dev/sequencer  sound
    alias   /dev/sndstat    sound
    add above snd-sbawe snd-pcm-oss snd-mixer-oss snd-seq-oss snd-opl3-synth
    alias snd-card-1 off
    alias snd-card-2 off
    alias snd-card-3 off
    alias snd-card-4 off
    alias snd-card-5 off
    alias snd-card-6 off
    alias snd-card-7 off

Retrieved from
"[http://alsa.opensrc.org/Sbawe](http://alsa.opensrc.org/Sbawe)"

[Category](/Special:Categories "Special:Categories"): [ALSA
modules](/Category:ALSA_modules "Category:ALSA modules")

