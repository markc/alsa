Emu10k1x
========

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

This is the new Dell model of SB Live! According to the [Creative Open
Source page](http://opensource.creative.com/soundcard.html). The Dell
CT0200 -- The new Live 5.1 card from Dell (CT0200) is not based on the
EMU10K1 chip, so the EMU10K1 driver [available at
SourceForge](http://sourceforge.net/projects/emu10k1) won't work with
it. The snd-((emu10k1)) ALSA module does not work either. Since ALSA
1.0.5, a new driver module snd-emu10k1x is introduced to support this
different model.

Discussion on the ALSA mailing list regarding this new driver
[http://www.mail-archive.com/alsa-devel@lists.sourceforge.net/msg12497.html](http://www.mail-archive.com/alsa-devel@lists.sourceforge.net/msg12497.html)

This is new stuff, so confirmation from Dell SB Live! users required:
[http://www.mail-archive.com/alsa-user@lists.sourceforge.net/msg13912.html](http://www.mail-archive.com/alsa-user@lists.sourceforge.net/msg13912.html)

MIDI support
------------

From the ALSA [1.0.6
changelog](http://www.mail-archive.com/alsa-announce@lists.sourceforge.net/msg00018.html),
MIDI support on the Dell model (EMU10k1X) is now available:

` `

       emu10k1x
        - added capture support
        - added S/PDIF support (untested)
        - fixed interrupt bug when playing multiple channels
        - split channels into separate PCMs
        - documented some of the registers
        - added support for more periods (up to 512 for playback)
        - formatting clean up
        - MIDI support
        - voice clean up
        - delayed interrupt enable/disable
        - playback/capture constraints added
        - fixed max number of periods

You can try [sfxload](/Sfxload "Sfxload") to load soundfont and see if
hardware MIDI works for this card. The [SB Live! MIDI
How-To](http://www.mandrakeusers.org/index.php?showtopic=1189) would
help here. Also, see the MIDI section of
snd-[emu10k1](/Emu10k1 "Emu10k1") driver for more detail.

Retrieved from
"[http://alsa.opensrc.org/Emu10k1x](http://alsa.opensrc.org/Emu10k1x)"

[Category](/Special:Categories "Special:Categories"): [ALSA
modules](/Category:ALSA_modules "Category:ALSA modules")

