Alsa Preferred Soundcards
=========================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

This page is intended to complement the [ALSA Soundcard
Matrix](http://www.alsa-project.org/main/index.php/Matrix:Main), part of
the [ALSA Project Documentation](http://www.alsa-project.org/alsa-doc/),
and promote supporters of Alsa and Free/Open Source Software.

Contents
--------

-   [1 RME](#RME)
    -   [1.1 Products](#Products)
    -   [1.2 Alsa support](#Alsa_support)
    -   [1.3 User comments](#User_comments)

-   [2 Terratec](#Terratec)
    -   [2.1 Products](#Products_2)
    -   [2.2 Alsa support](#Alsa_support_2)
    -   [2.3 User comments](#User_comments_2)

-   [3 3. Midiman/M-Audio](#3._Midiman.2FM-Audio)
    -   [3.1 Products](#Products_3)
    -   [3.2 User comments](#User_comments_3)
    -   [3.3 Alsa support](#Alsa_support_3)
    -   [3.4 User comments](#User_comments_4)

-   [4 4. Creative Labs](#4._Creative_Labs)
    -   [4.1 Products](#Products_4)
    -   [4.2 Alsa support](#Alsa_support_4)
    -   [4.3 User comments](#User_comments_5)

-   [5 5. HeadRoom](#5._HeadRoom)
    -   [5.1 Products](#Products_5)
    -   [5.2 Alsa support](#Alsa_support_5)
    -   [5.3 User comments](#User_comments_6)

-   [6 General comments](#General_comments)

[RME](http://www.rme-audio.com/english/index.htm)
-------------------------------------------------

### Products

-   [DIGI96/8 PAD](http://www.rme-audio.com/english/digi96/digi96pa.htm)
    -   Apparently well supported according to notes on the Alsa
        Soundcard Matrix.
    -   Fairly expensive (\$400US list price)

-   [Hammerfall
    DIGI9636](http://www.rme-audio.com/english/hammer/d9636.htm)
    -   Apparently well supported according to notes on the Alsa
        Soundcard Matrix.
    -   Expensive (\$750US list price)

-   [HDSP-PCI + Hammerfall DSP Multiface
    II](http://www.rme-audio.com/english/hdsp/multifa.htm)
    -   So far so good. Still trying learning to program the device.
    -   About \$900.0 for the combination of HDSP-PCI and Hammerfall DSP
        Multiface II.
    -   [Johnlee](/User:Johnlee "User:Johnlee") 12:04, 25 January 2007
        (EST)

### Alsa support

-   [ALSA Linux Driver for RME Digital Audio
    Cards](http://www.rme-audio.com/english/linux/alsa.htm)
    -   Proactive support for Alsa and Linux

-   [Alsa Soundcard Matrix
    (RME)](http://www.alsa-project.org/alsa-doc/index.php?vendor=vendor-RME#matrix)

### User comments

-   [Johnlee](/User:Johnlee "User:Johnlee") 12:13, 25 January 2007 (EST)
    With the latest update of Fedora Core 5, I am able to use the
    combination of RME Hammerfall DSP Multiface II and HDSP PCI Card. I
    was able to write a simple audio playback routine. Before I move on
    to writing a complex application, I wanted to know if the ALSA
    support for the combination of RME Hammerfall DSP Multiface II and
    HDSP PCI Card is solid. The Web seems to suggest that ALSA is solid
    only for RME 9632 and 9652. Is this true?

[Terratec](http://en.terratec.net/)
-----------------------------------

Terratec offers [passive support for
GNU/Linux](ftp://ftp.terratec.de/Documentation/Linux_and_Mac_OSX_Compatiblity.pdf).
Alsa fully supports this audio device, and several Alsa hackers use it.
It is a recommended choice for people needing good sound quality,
without investing in a professional sound card.

### Products

-   [EWS88
    MT](http://sounden.terratec.net/modules.php?op=modload&name=News&file=article&sid=8)
    -   Apparently well supported according to notes on the Alsa
        Soundcard Matrix.
    -   Fairly expensive (\$350US list price - found for 1/2 that
        online)

-   [Aureon 7.1
    Space](http://sounden.terratec.net/modules.php?op=modload&name=News&file=article&sid=149&menu=215)
    -   Fairly well supported according to notes on the Alsa Soundcard
        Matrix.
    -   Somewhat expensive (\$150US list price)

-   [Terratec Aureon 5.1
    USB](/TerratecAureonUSB5.1 "TerratecAureonUSB5.1") (not MKII!!)
    -   Cheap card but worth the money for hobbyist use
    -   16Bits/48kHz only
    -   2 Ins / 6 Outs + Mic & digital in \* Headphone and digital out
    -   Works well with the snd-usb-audio-module
    -   For low latency see `TerratecAureonUSB5.1`

Was replaced by [Terratec Aureon 5.1 USB
MK.2](/Terratec_Aureon_5.1_USB_MK.2 "Terratec Aureon 5.1 USB MK.2")

-   [Terratec Aureon 5.1 USB
    MK.2](/Terratec_Aureon_5.1_USB_MK.2 "Terratec Aureon 5.1 USB MK.2")
    -   Cheap card but worth the money for hobbyist use
    -   16Bits/24Bits/48kHz
    -   1 In / 3 Outs + Mic & digital in \* Headphone and digital out
    -   Works well with the snd-usb-audio-module

### Alsa support

-   [Compatibility statement
    (PDF)](ftp://ftp.terratec.de/Documentation/Linux_and_Mac_OSX_Compatiblity.pdf)
    -   Passive support for Alsa and Linux

-   [Alsa Soundcard Matrix
    (Terratec)](http://www.alsa-project.org/alsa-doc/index.php?vendor=vendor-Terratec#matrix)

### User comments

-   Hi! Beware of the Terratec 7.1 series. I bought the 7.1 Space and
    the SPDIF wouldn't work. Lately I bought a Terratec 5.1 Aureon Fun,
    which was weirdly labeled a Terratec Aureon PCI. The SPDIF-in works
    (SPDIF-out not tested yet) with alsa 1.0.8, I can't think of a
    cheaper solution (19.95Euro)

3. [Midiman/M-Audio](http://www.midiman.com/index.php)
------------------------------------------------------

### Products

-   [Delta
    44](http://www.midiman.com/index.php?do=products.main&ID=ad13e577f5e5f494c721095cefefd71b)
    -   Fairly well supported according to notes on the Alsa Soundcard
        Matrix.
    -   Pretty reasonable price (\$199US list price - found for \$149US
        online)

-   [Quattro USB audio
    interface](http://www.midiman.com/index.php?do=products.main&ID=81703e2203e2556c9d650c1b3d3a6e79)
    -   Fairly well supported according to notes on the Alsa Soundcard
        Matrix.
    -   Somewhat expensive (\$350US list price)

-   [Uno USB MIDI
    interface](http://www.m-audio.com/index.php?do=products.list&ID=usbmidiinterfaces)
    -   Works perfectly with Alsa and Rosegarden. Needs fxload to load a
        firmware on connect. See this [Sourceforge
        project](http://usb-midi-fw.sourceforge.net/) for help.

### User comments

-   I can just tell everyone: "avoid the m-audio quattro usb!" i never
    got it working with more then one stereo out (debian/ubuntu,
    alsa/jack), furthermore the card is really sensitive to the power
    environment - i strongly encourage people to use a separate power
    circuit when performing on stage. it just crashes, even worse on
    windows. i know three other people with similar problems. this card
    has great sound, but otherwise it's a troublesome interface.

-   Hmm... Can someone please verify that the quattro is really as bad
    as the guy above says it is? I'm questioning his credibility... he
    calls the quattro a card twice. The quattro isn't a card, it is a
    box that connects via usb. Hard to imagine someone who had actually
    used it or even just seen it would make that mistake 2 times. Is
    this person just messing with wiki, or does he work for an m-audio
    competitor or something?

### Alsa support

-   [Driver download
    page](http://www.midiman.com/index.php?do=support.drivers)
    -   Passive support for Alsa and Linux
    -   Download page points to 4Front OSS drivers

-   [Alsa Soundcard Matrix
    (MAudio)](http://www.alsa-project.org/alsa-doc/index.php?vendor=vendor-MAudio#matrix)

### User comments

4. [Creative Labs](http://www.creative.com)
-------------------------------------------

### Products

-   [Soundblaster Audigy 2
    ZS](http://www.creative.com/products/product.asp?category=1&subcategory=204&product=4915)
    -   Fairly well supported according to notes on the Alsa Soundcard
        Matrix.
    -   About moderate in price (\$100US list price, \$70US at Newegg)

-   [USB Soundblaster Audigy 2
    NX](http://www.creative.com/products/product.asp?category=1&subcategory=204&product=9103)
    -   Fairly well supported according to notes on the Alsa Soundcard
        Matrix.
    -   On the cheaper end of USB sound (\$100US list price, \$85US at
        Newegg
        
-   [PCIE SOUND BLASTERX AE-5](https://us.creative.com/p/sound-blaster/sound-blasterx-ae-5)
    -   Currently testing but seems to work now. NOTE: at least on Fedora it is required to have alsa-firmware installed and select the correct profile (5.1 analog out + stereo analog input) with e.g. pavucontrol-qt 

### Alsa support

-   [Creative Opensource Support Site](http://opensource.creative.com)
    -   Once active, now fairly passive support for Alsa and Linux

-   [Alsa Soundcard Matrix (Creative
    Labs)](http://www.alsa-project.org/alsa-doc/index.php?vendor=vendor-Creative_Labs#matrix)

### User comments

-My Audigy 2 ZS works fine when installed via ALSA, but needs
[asfxload](http://www.alsa-project.org/~iwai/awedrv.html#Utils) to load
soundfonts into the hardware wavetable synthesizer to use MIDI in
hardware.

5. [HeadRoom](http://www.headphone.com)
---------------------------------------

### Products

-   [BitHead](http://www.headphone.com/products/headphone-amps/headroom-amps/the-mobile-line/headroom-bithead.php)
-   [Total
    Bithead](http://www.headphone.com/products/headphone-amps/headroom-amps/the-mobile-line/headroom-total-bithead.php)

The Bithead is a two-in-one device, about 3.5in by 2.5in. It can plug
into a portable music player and (using 4 AAA batteries) amplifies the
output signal to the point where it can drive reasonably good
headphones. But it is also a USB audio device which can connect to a USB
port, and put the signal through a good 16-bit digital-to-analog
converter. When connected to the USB port it will either run from the
5-volt USB power supply, or else and in addition use the power from the
batteries (if your headphones need the extra push). It has two headphone
output jacks, a clipping meter to give you guidance about volume levels,
and (best of all from my point of view) a crossfeed processor.

Getting it to work with Linux/Alsa was trivial. The USB audio chip is a
Burr-Brown PCM2902E stereo audio codec supporting sampling rates up to
48kHz and is well-supported by the snd-usb-audio driver. In my own case,
I just rmmod-ed the snd-intel8x0 module for the onboard sound card
(which I have always hated), and when I plugged in the device, the
hotplug and usb subsystems identified it right away and loaded the
snd-usb-audio module.

These are not full-fledged sound-cards. All they (aim to) do is provide
higher quality audio ouput. That, though, they do very well; the
improvement over what I had before is phenomenal. It's not cheap (\$199
direct from the manufacturer) but I am extremely happy with it, and
especially with how well it plays with Alsa.

### Alsa support

### User comments

General comments
----------------

Some direct links to where these cards can be purchased would also be
useful. For instance, most computer shops in Australia only carry one or
two very cheap commodity cards plus most of the Creative SBLive range
and that's it. Where to actually buy ANY other card is a well kept
secret.

Also, comments and opinions about the various cards and their
performance, merits or otherwise would be most appreciated. Any and all
information helps to lower the barrier to a satisfactory audio linux
experience.

A companion page for devices listed by type instead? (USB, FireWire,
PCI, PCMCIA, etc.) I am sure the mailing lists and such get clogged up
with people asking "what is the best sound card for linux?" (Which is
why I haven't bothered, even though I am looking for a good one for a
laptop.) Also a link to a page discussing the latency, cost,
compatibility, etc. tradeoffs of each type. (Maybe this page already
exists?)

*Comment added by Stuart Allie* For people in Australia, you can get the
m-audio audiophile 24/96 for (currently) A\$280 from
[hometheatrepc.com.au](http://www.hometheatrepc.com.au), or for A\$299
from [network-ed.com.au](http://www.network-ed.com.au). A pretty
reasonable range of soundcards can be found at network-ed or at
[musiclab.com.au](http://www.musiclab.com.au). I have heard that it is
possible (and possibly simpler) to buy things like the audiophile 24/96
from overseas for around US\$99 and have it shipped to Oz.

Retrieved from
"[http://alsa.opensrc.org/Alsa\_Preferred\_Soundcards](http://alsa.opensrc.org/Alsa_Preferred_Soundcards)"

[Category](/Special:Categories "Special:Categories"): [Sound
cards](/Category:Sound_cards "Category:Sound cards")

