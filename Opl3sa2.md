Opl3sa2
=======

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Output of /sbin/modinfo snd-opl3sa2:

` `

    description: "Yamaha OPL3SA2+"
    author: "Jaroslav Kysela "
    license: "GPL"
    parm: index int array (min = 1, max = 8), description "Index value for OPL3-SA soundcard."
    parm: id string array (min = 1, max = 8), description "ID string for OPL3-SA soundcard."
    parm: enable int array (min = 1, max = 8), description "Enable OPL3-SA soundcard."
    parm: isapnp int array (min = 1, max = 8), description "ISA PnP detection for specified soundcard."
    parm: port long array (min = 1, max = 8), description "Port # for OPL3-SA driver."
    parm: sb_port long array (min = 1, max = 8), description "SB port # for OPL3-SA driver."
    parm: wss_port long array (min = 1, max = 8), description "WSS port # for OPL3-SA driver."
    parm: fm_port long array (min = 1, max = 8), description "FM port # for OPL3-SA driver."
    parm: midi_port long array (min = 1, max = 8), description "MIDI port # for OPL3-SA driver."
    parm: irq int array (min = 1, max = 8), description "IRQ # for OPL3-SA driver."
    parm: dma1 int array (min = 1, max = 8), description "DMA1 # for OPL3-SA driver."
    parm: dma2 int array (min = 1, max = 8), description "DMA2 # for OPL3-SA driver."
    parm: opl3sa3_ymode int array (min = 1, max = 8), description "Speaker size selection for 3D Enhancement mode: Desktop/Large Notebook/Small Notebook/HiFi."

Note: The "snd\_" prefix has been removed from the module options to fit
with the kernel standard.

* * * * *

An example of the module options, as used on my Tecra 8000:

` `

    alias snd-card-0 snd-opl3sa2
    options snd-opl3sa2 snd_dma1=1 \
          dma2=0 \
          fm_port=0x388 \
          irq=5 \
          isapnp=0 \
          midi_port=0x330 \
          port=0x538 \
          sb_port=0x220 \
          wss_port=0x530

Note: the slashes indicate a continuation of the previous line and are
not part of the module options

I'm using ALSA-drivers 0.93c (93c-r1.ebuild on Gentoo Linux)

* * * * *

On a Dell XPS H300 (YMF sound chip on the Mboard):

` `

    alias snd-card-0 snd-opl3sa2
    options snd-opl3sa2 port=0x100 \
    sb_port=0x240 wss_port=0xe80 midi_port=0x300 fm_port=0x388 \
    irq=5 dma1=3 dma2=1

...seems to work (plays music). Make sure you don't set option isapnp to
1.

I'm using ALSA-drivers 0.98 on a Debian Satellite 4010CDT the above
options for the Tecra but ensure you add the following one.

` `

    isapnp=0

it doesn't seem to work otherwise!  :)

**Note:** This driver does NOT work with the Yamaha OPL3-SA / YMF701
chip. For that chip, you need to use the [cs4231](/Cs4231 "Cs4231")
module.

Retrieved from
"[http://alsa.opensrc.org/Opl3sa2](http://alsa.opensrc.org/Opl3sa2)"

[Category](/Special:Categories "Special:Categories"): [ALSA
modules](/Category:ALSA_modules "Category:ALSA modules")

