HP Omnibook 4150
================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

The HP 4150 can be configured using this driver. Please note that there
are two models of HP 4150, this information is only for the NON B
version (the B version uses the ESS Maestro sound chip). The chip itself
is the Neomagic 256AV, but the [nm256](/Nm256 "Nm256") driver does not
work with this laptop. Given below is the lspci output for this laptop,
if your laptop shows similar information then you can go ahead and
configure this driver.

` `

    $ lspci | grep audio
    01:00.1 Multimedia audio controller: Neomagic Corporation NM2200 [MagicMedia 256AV Audio] (rev 20)

After installing the alsa modules, edit your modules.conf and insert the
following option line for your cs4232 driver.

` `

    options snd-cs4232 port=0x534 cport=0x538 mpu_port=-1  fm_port=0x388 irq=5 dma1=1 dma2=0 isapnp=0

Using snd-cs4231
----------------

Beginning with kernel 2.6.29, the snd-cs4232 driver has been merged into
the snd-cs4231 and
[snd-cs4236](http://git.kernel.org/?p=linux/kernel/git/torvalds/linux-2.6.git;a=commit;h=c2b73d1458014a9f461b75bc1756a699a6c0781f)
drivers. The above line reads for cs4231 as follows (you can omit the FM
parameters now):

` `

    options snd-cs4231 port=0x534 irq=5 dma1=1 dma2=0

That's all! Hopefully your sound card will now be recognized.

Retrieved from
"[http://alsa.opensrc.org/HP\_Omnibook\_4150](http://alsa.opensrc.org/HP_Omnibook_4150)"

[Category](/Special:Categories "Special:Categories"): [Sound
cards](/Category:Sound_cards "Category:Sound cards")

