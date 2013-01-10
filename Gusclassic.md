Gusclassic
==========

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

gusclassic
----------

The following IRQs are valid with the gusclassic driver:
2,3,5,7,9,11,12,15. However 2,3,7,15 are normally used in an ISA system,
if you use a ps/2 mouse 12 as well. This leaves you with 5 and 11 as
valid interrupts. I recommend 5 when you have no other ISA card
installed. Be sure to mark this interrupt as used by a native ISA
hardware in your bios setup.

The following DMAs are valid with the gusclassic driver: 0,1,3,5,6,7.
0,1 and 3 are 8bit DMAs, 5-7 are 16bit. I recommend you use DMA 6 and 7
with your GUS. You will have to declare them used by ISA in your bios
setup as well.

These IRQ and DMA restrictions apply to all GF1 based GUS cards, thus
also to GUS Max and GUS Extreme. (but I haven't verified yet)

My module options for my GUS classic look as follows:

` `

    options snd-gusclassic port=0x240 irq=5 dma1=6 dma2=7

Retrieved from
"[http://alsa.opensrc.org/Gusclassic](http://alsa.opensrc.org/Gusclassic)"

[Category](/Special:Categories "Special:Categories"): [ALSA
modules](/Category:ALSA_modules "Category:ALSA modules")

