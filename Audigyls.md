Audigyls
========

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

General information
-------------------

The following cards use the ALSA snd-audigyls driver. It uses a P17
Chip: CA0106-DAT. Note: With ALSA 1.0.8, snd-**audigyls** module is
being **replaced by snd-[ca0106](/Ca0106 "Ca0106")**, see below for
further information. It has been tested, and can do Analog output on the
SB Live 24. Currently Mic input and SPDIF in/out do not work on the SB
Live 24. For those interested, it is called the
[ca0106](/Ca0106 "Ca0106") driver because that is the name printed on
the big chip on the cards. The driver for the Audigy LS/live24bit is now
included in alsa-driver 1.0.8.

-   Audigy LS. Model:SB0312. Supported in alsa-driver 1.0.6a and above.
    [http://www.soundblaster.com/products/audigyLS/](http://www.soundblaster.com/products/audigyLS/)

-   Live! 7.1 24bit Model:SB0410, SB0413.
    [http://www.soundblaster.com/products/live24bit/](http://www.soundblaster.com/products/live24bit/)

-   Download it from:
    [http://www.alsa-project.org/](http://www.alsa-project.org/)

To build it, use:

` `

    ./configure --with-cards=ca0106

Development information
-----------------------

WARNING: The Audigy LS is a very basic sound card. It has no hardware
mixer, no DSP, and no interpolators. (Well not totally true, but I have
only just received the Datasheets under NDA, so how was I supposed to
know before! I will be implementing support for some extra features now
that I know about them, when I get a moment. For example: The sound card
does in fact have interpolators.)

-   [audigyls\_capture](/Audigyls_capture "Audigyls capture") -- Audigy
    LS Capture controls
-   [audigyls\_playback](/Audigyls_playback "Audigyls playback") --
    Audigy LS Playback controls

Development of the ca0106 driver is done with a Model:SB0310 and a
Model:SB0410. We understand that an Audigy LS exists with Model:SB0312,
and we would like to know what the differences are. **lspci -vn** will
help us. More information regarding the CA0106 driver that might be
interesting to developers is available from:
[http://www.alsa-project.org/\~james/alsa-driver/](http://www.alsa-project.org/~james/alsa-driver/)

Other information
-----------------

A good creative sound card identification list is here:

-   [http://us.creative.com/support/identifyproduct/](http://us.creative.com/support/identifyproduct/)

snd-audigyls discussion in the ALSA mailing list (probably obsolete now)

-   [http://www.mail-archive.com/alsa-devel@lists.sourceforge.net/msg12892.html](http://www.mail-archive.com/alsa-devel@lists.sourceforge.net/msg12892.html)

Retrieved from
"[http://alsa.opensrc.org/Audigyls](http://alsa.opensrc.org/Audigyls)"

[Category](/Special:Categories "Special:Categories"): [ALSA
modules](/Category:ALSA_modules "Category:ALSA modules")

