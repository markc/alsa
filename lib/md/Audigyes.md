Audigyes
========

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Model: SB0162 Sound Blaster Audigy (without 1394 Connectors)

This card has not yet been tested with alsa. We need the output from
lspci -vn to properly identify it.

I have an SB 0160 which is an Audigy ES. Will the lspci from that help?
Just let me know.

* * * * *

I have an Audigy ES (it's an Audigy 1 OEM card with an Audigy chip,
contrary to the Audigy LS). The model numer is SB0160. Here's the
relevant output of lspci -vn:

` `

    0000:00:0f.0 Class 0401: 1102:0004 (rev 03)
            Subsystem: 1102:0052
            Flags: bus master, medium devsel, latency 32, IRQ 7
            I/O ports at c800
            Capabilities: [dc] Power Management version 2

And here's the output of lscpi -v:

` `

    0000:00:0f.0 Multimedia audio controller: Creative Labs SB Audigy (rev 03)
            Subsystem: Creative Labs: Unknown device 0052
            Flags: bus master, medium devsel, latency 32, IRQ 7
            I/O ports at c800
            Capabilities: [dc] Power Management version 2

The card seems to work (detected as a Soundblaster Audigy). I can supply
any additional info if needed.

Retrieved from
"[http://alsa.opensrc.org/Audigyes](http://alsa.opensrc.org/Audigyes)"

[Category](/Special:Categories "Special:Categories"): [Sound
cards](/Category:Sound_cards "Category:Sound cards")

