Es18xx
======

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

-   ESS1869 - Compaq Deskpro P500-550
-   ESS1869 - Compaq Armada 7400
-   ESS1869 - Fujitsu Siemens Computers Scenic Mobile 800
-   ES1869 - Fujitsu Siemens Computers Scenic Mobile 320
-   ESS1869 - Compaq Armada 3500
-   ESS1888 - HP Omnibook 800 (detected by OSS 'sb' driver as ESS1887)
-   ES1869 - Compaq Deskpro EN
-   ES1869 - Compaq Armada 1700

* * * * *

According to the datasheet of the es1869 the first DMA channel needs to
be 1, and the second either 0, 1 or 3. On my Armada 3500 however, it's
possible to use different settings. The OSS sb driver can manage this,
so can the windows-drivers, but not our beloved ALSA driver... So check
your BIOS. irq 9 apparently works for some people, but I only managed to
get sound with irq 5.

*kasper at 303.nu 20020701*

* * * * *

Yes I had sound, but then I rebooted (after a long while, I like
sleeping mode on my laptop) and I didn't have ALSA sound anymore. Really
strange. The sb module is still fine, but snd-es18xx either gives me
garbled sound, or no sound at all with very fast going playtime in
mp3blaster.

So I guess there's a strange problem with the driver. But how to find a
solution for this? Maybe I should compare the sb and the snd-es18xx code
and see what is the essential difference.

*kasper at 303.nu 20020701*

* * * * *

I started reading the source code and adding/editing a bit.

It seems that playback using the playback1\_\* functions doesn't work.
And they are called most of the time. The playback2\_\* functions work
fine, but they are only called about once out of 10 times. And also, for
full duplex one needs playback1\_\* to play stuff. (Not I was able to
record anything by the way.)

Also, I think playback1 uses what is called the SECOND audio thingy in
the ES1869 datasheet.

*kasper at 303.nu 20020815*

* * * * *

For the HP Omnibook 800, using ALSA 0.9.0rc6 (other versions unknown),
the following 'modprobe' should get you sound:

` `

    modprobe snd-es18xx port=0x220 mpu_port=0x330 irq=5 dma1=1 dma2=5 isapnp=0

The Omnibook's chip does not respond to PnP scans, and the driver will
fail to find the chip -- and therefore fail to load -- unless you
explicitly disable the PnP scan with 'isapnp=0'

*ewhac at best.com 20021219*

* * * * *

Finally I managed to get clear sound on sony vaio pcg-505fx, by changing
default settings in bios to irq 11, dma1 1, dma2 0. My options to
modprobe:

` `

    modprobe snd-es18xx port=0x220 mpu_port=0x330 irq=11 dma1=1 dma2=0 isapnp=0 

*mikey 20070506*

* * * * *

The tip above also works for a Compaq Deskpro EN SFF P600, with some
modification. As always, check the BIOS for the exact options, but mine
were:

` `

    modprobe snd-es18xx port=0x220 mpu_port=0x330 irq=5 dma1=1 dma2=0 isapnp=0

*nick at inocuo.org 20030708*

* * * * *

I fighted long time with my armada with alsa drivers. Armada 1700 has
volume button in side of laptop. Sound is working fine with alsa drivers
if the alsa is invoked directly on software (xmms in example) But if i
tried to play sound in console (ie. mpg123) The sound just stuttered in
place. Pressing volume button made the sound play again but as soon as i
stopped pressing the buttons, sound left at the place again. Tried all
the possible address combinations but only solution was to go Back to
OSS drivers.

` `

    ::/etc/modprobe.d/soundcard.conf::

    alias snd-card-0 snd-es18xx
    alias sound-slot-0 snd-es18xx
    options snd-es18xx port=0x230 mpu_port=0x330 dma1=0 dma2=1 irq=5 isapnp=0

This was my soundcard config on debian. I have changed the addresses on
bios too since it did give just static noise with default settings.
These settings will work with alsa drivers but with some problems as
mentioned before.

` `

    ::::SB DRIVERS::::
    ::/etc/modprobe.d/soundcard.conf::

    alias snd-card-0 sb
    alias sound-slot-0 sb
    options sound dmabuf=1
    alias midi opl3
    options opl3 io=0x388
    options sb io=0x220 irq=5 dma=0 dma16=1 mpu_io=0x330

This is the soundcard config on debian when using OSS drivers. I know
this is alsa wiki but since i didnt find info almost anywhere it seems
an good idea to place this here too. SB oss drivers seems to be working
on Armada1700 for now.

*palsteri 20080416*

* * * * *

AUTO-MODPROBE IN KERNEL 2.6.x

On distributions such as Fedore Core 2 (and higher) with ALSA you may
want the ES18xx device to be detected and the proper module loaded on
boot-up. The following lines in /etc/modprobe.conf takes care of it:

` `

    # ALSA portion
    alias char-major-116 snd
    alias snd-card-0 snd-es18xx
    options snd-es18xx enable=1 isapnp=0 port=0x220 mpu_port=0x388 fm_port=0x330 irq=5 dma1=1 dma2=0

    # OSS/Free portion
    alias char-major-14 soundcore
    alias sound-slot-0 snd-card-0

    # card #1
    alias sound-service-0-0 snd-mixer-oss
    alias sound-service-0-1 snd-seq-oss
    alias sound-service-0-3 snd-pcm-oss
    alias sound-service-0-8 snd-seq-oss
    alias sound-service-0-12 snd-pcm-oss

* * * * *

**BOOT PARAMETER**

A bit problematic to get the to work when compiling all of ALSA into the
kernel, found that the boot parameter:

` `

    snd-es18xx=1,0,ES1869,0,0x220,0x388,0x330,5,1,0

(and similar) does the trick.

Retrieved from
"[http://alsa.opensrc.org/Es18xx](http://alsa.opensrc.org/Es18xx)"

[Category](/Special:Categories "Special:Categories"): [ALSA
modules](/Category:ALSA_modules "Category:ALSA modules")

