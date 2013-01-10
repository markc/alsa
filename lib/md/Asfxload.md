Asfxload
========

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

`asfxload` loads a [soundfont](/Soundfont "Soundfont") onto ALSA's Emux
wavetable. The old version `sfxload` works only with ALSA's OSS
emulation. See the
[SoundfontHandling](/SoundfontHandling "SoundfontHandling") page for
details of how to use soundfonts.

[http://www.alsa-project.org/\~iwai/awedrv.html\#Utils](http://www.alsa-project.org/~iwai/awedrv.html#Utils)

` `

    asfxload -- load SoundFont on ALSA Emux WaveTable
       ver.0.5.0  copyright (c) 1996-2003 by Takashi Iwai
    usage:  asfxload [-options] [soundfont[.sf2|.sbk|.bnk]]

     options:
     -D, --hwdep=name        specify the hwdep name
     -i, --clear[=bool]       clear all samples
     -x, --remove[=bool]      remove additional samples
     -N, --increment[=bool]   incremental loading
     -b, --bank=number        append font to the specified bank
     -l, --lock[=bool]        lock the loading fonts
     -C, --compat[=bool]      use v0.4.2 compatible sounds
     -A, --sense=digit        (compat) set attenuation sensitivity (default=10)
     -a, --atten=digit        (compat) set default attenuattion (default=31)
     -d, --decay=scale        (compat) set decay time scale (default=50)
     -M, --memory[=bool]      display available memory on DRAM
     -B, --addblank[=bool]    add 12 words blank loop on each sample
     -c, --chorus=percent     set chorus effect (0-100)
     -r, --reverb=percent     set reverb effect (0-100)
     -V, --volume=percent     set total volume (0-100) (default=70)
     -L, --extract=preset/bank/note
                              do partial loading
     -P, --path=dir           set SoundFont file search path

If you get the error "No Emux synth hwdep device is found" it is
supposed to mean that your driver version is too old. I got this with
kernel 2.6.2 and I am now upgrading to kernel 2.6.4, hoping that they
upgraded the ALSA driver. I got the same error with 2.6.5-mm5 and ALSA
built-in. I recompiled the kernel to include ALSA as modules and then I
just had to modprobe emu10k1-synth to make everything work. *-- tachyon*

2005-03-07
----------

I'm using a 2.6.x kernel and the following line in
`/etc/modprobe.d/local` loads the 8mbgmsfx.sf2
[SoundFont](/SoundFont "SoundFont") automatically when the module is
loaded:

` `

    install snd-emu10k1-synth /sbin/modprobe \
    --ignore-install snd_emu10k1_synth;/usr/bin/asfxload 8mbgmsfx

Of cource you can load it manually instead:

` `

    /usr/bin/asfxload 8mbgmsfx

In Debian (Sarge), asfxload searches for sound fonts in:

-   /usr/share/sounds/sf2
-   /usr/share/sfbank
-   /usr/local/lib/sfbank

-- *MikaelMagnusson*

Retrieved from
"[http://alsa.opensrc.org/Asfxload](http://alsa.opensrc.org/Asfxload)"

[Category](/Special:Categories "Special:Categories"):
[Software](/Category:Software "Category:Software")

