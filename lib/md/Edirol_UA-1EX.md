Edirol UA-1EX
=============

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

[Roland/Edirol
UA-1EX](http://www.rolandus.com/products/productdetails.aspx?ObjectId=743)

This card uses the usb-audio driver and has functioned for some time
with this driver as long as the advanced driver mode switch was off,
limiting the card to 16bit 48kHz. Since Alsa 1.0.15 the advanced driver
mode for this card has been supported however there is no information on
how to use this mode.

Advanced Driver Mode Enabled
----------------------------

When in advanced driver mode the card appears to use a 3 byte sample
format. In order to capture audio data from the card while using the
advanced driver mode the following command is required:
`arecord -r96000 -fS24_3LE -c2 -Dhw:0 ~/recording.wav` (\*)

(\*)where the device (-D:hw0) and filename (\~/recording.wav) may be
different for your system/preferences.

Retrieved from
"[http://alsa.opensrc.org/Edirol\_UA-1EX](http://alsa.opensrc.org/Edirol_UA-1EX)"

[Category](/Special:Categories "Special:Categories"): [Sound
cards](/Category:Sound_cards "Category:Sound cards")

