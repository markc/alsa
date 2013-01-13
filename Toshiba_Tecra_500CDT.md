Toshiba Tecra 500CDT
====================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

I used the following options which correspond to configured settings in
the Toshiba setup (hold Esc while BIOS initializing then hit F1):

` `

    snd-cs4232 port=0x534 cport=0x120 irq=5 sb_port=0x220 fm_port=0x388 mpu_port=0x330 mpu_irq=9 dma1=1 dma2=0

Too bad this chip isn't PnP on this laptop :( If your ALSA is configured
with PNP, you will also have to add isapnp=0 to the module options.

You probably also want to reserve the following resources in
/etc/pcmcia/config.opts to make sure the card services doesn't try to
allocate a PC card over the top of them:

` `

    # Hard coded CS4232 ports
    exclude port 0x279-0x279
    exclude port 0xa79-0xa79

    # Software configurable CS4232 ports
    exclude port 0x534-0x537 # WSS
    exclude port 0x388-0x38b # adlib
    exclude port 0x220-0x22f # SB
    exclude irq 5

    exclude port 0x200-0x207 # game
    exclude port 0x120-0x127 # control
    exclude port 0x330-0x331 # mpu401
    exclude irq 9 # mpu401

(Yes that first port does conflict with any LPT3 you might have on the
system. No there's nothing you can do about it.)

If card services is loaded after the ALSA driver, you don't have to
bother with this because the driver will reserve the used resources for
you.

If you have spurious problems with the chip configuration like I did,
you could also use it in SB emulation mode which is less desirable but
worked even when the crystal driver wasn't:

` `

    modprobe snd-sb8 port=0x220 irq=5 dma8=1 or alternately modprobe snd-cs4231 io=0x534 irq=5 dma1=1 to use only the WSS component.

Don't try to use both at the same time or alongside the actual CS4232
driver...

Retrieved from
"[http://alsa.opensrc.org/Toshiba\_Tecra\_500CDT](http://alsa.opensrc.org/Toshiba_Tecra_500CDT)"

[Category](/Special:Categories "Special:Categories"): [Sound
cards](/Category:Sound_cards "Category:Sound cards")

