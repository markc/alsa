Audigy 2 PCMCIA
===============

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

The Creative Audigy 2 Notebook PCMCIA card support in alsa is currently
being developed. Progress is slow due to a current fault in the Linux
kernel pcmcia code. This fault causes ioport resources to fail to be
assigned to the card, resulting in the driver hanging the PC until the
PCMCIA card is removed.

-   Output works on the card
-   No input/ capture support yet - on developer TODO list (ALSA
    bug\#2058). Requires adding I2C support to the driver.
-   No power management support yet - on developer TODO list (ALSA
    bug\#2135)

Retrieved from
"[http://alsa.opensrc.org/Audigy\_2\_PCMCIA](http://alsa.opensrc.org/Audigy_2_PCMCIA)"

[Category](/Special:Categories "Special:Categories"): [Sound
cards](/Category:Sound_cards "Category:Sound cards")

