TerratecAureonUSB5.1
====================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

This audio product is now discontinued and can hardly be found in
stores. It was replaced by [Terratec Aureon 5.1 USB
MK.2](/Terratec_Aureon_5.1_USB_MK.2 "Terratec Aureon 5.1 USB MK.2"). You
may find it on eBay.

[http://sounden.terratec.net/modules/My\_eGallery/gallery/produkte/sound-audio/Aureon51USB/Aureon51USB\_Appliance.jpg](http://sounden.terratec.net/modules/My_eGallery/gallery/produkte/sound-audio/Aureon51USB/Aureon51USB_Appliance.jpg)

Terratec offers [passive support for
GNU/Linux](ftp://ftp.terratec.de/Documentation/Linux_and_Mac_OSX_Compatiblity.pdf).
It is a recommended choice for people needing good sound quality,
without investing in a professional sound card.

Like other USB devices, Terratec audio devices do not have hardware
mixers. You need to create a custom [.asoundrc](/.asoundrc ".asoundrc")
file, using the [softvol](/Softvol "Softvol") plugin, to provide
software level mixing.

This card is a two-way audio card with USB-1 support.

To drive this card at low latencies, some things need to be done. Thanks
to the infos of Clemens Ladisch, do the following to get latencies of
about 13msecs (less will be possible but will lead to audible xruns):

-   In the kernel config ensure that both options (taken from a 2.6.10)

` `

    [   ] Enforce USB bandwidth allocation (EXPERIMENTAL)
    [   ] Dynamic USB minor allocation (EXPERIMENTAL)

are disabled.

-   Ensure to load the snd-usb-audio module with the parameter
    "nrpacks=1", maybe including it into one of the boot scripts:

` `

    modprobe snd-usb-audio nrpacks=1

-   Now invoke JACK with the following command:

` `

    jackd -R -P89 -dalsa -dhw:2 -r48000 -p256 -n3 -S

or entering the corresponding values into Qjackctl

\

See also
========

-   Product page:
    [http://supporten.terratec.net/modules.php?op=modload&name=News&file=article&sid=178](http://supporten.terratec.net/modules.php?op=modload&name=News&file=article&sid=178)

Retrieved from
"[http://alsa.opensrc.org/TerratecAureonUSB5.1](http://alsa.opensrc.org/TerratecAureonUSB5.1)"

[Category](/Special:Categories "Special:Categories"): [Sound
cards](/Category:Sound_cards "Category:Sound cards")

