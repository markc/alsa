MPU-401 MIDI setup (Howto)
==========================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

### How to get the MIDI-Port of the VIA8233 working

You'll need the 'snd-[mpu401](/Mpu401 "Mpu401")' driver module. If you
don't have it already, recompile alsa with it. Now edit your
modules.conf file and add these lines (get the irq and io port from your
bios or windows):

` `

    alias snd-card-1 snd-mpu401
    options snd-mpu401 port=0x330 irq=7
    alias sound-slot-1 snd-card-1
    alias sound-service-1-0 snd-mixer-oss
    alias sound-service-1-1 snd-seq-oss
    alias sound-service-1-3 snd-pcm-oss
    alias sound-service-1-12 snd-pcm-oss

Note that you might have to replace `port` and `irq` by `snd_port` and
`snd_irq`, respectively, depending on your kernel version. Type
`modinfo snd-mpu401` to get the list of parameters supported by
`snd-mpu401`. Now do a `modprobe snd-mpu401`. It should load without
errors. Now check the `/proc/asound/oss/sndstat` file and you should see
something like this under Midi-Devices:

` `

    1: MPU-401 (UART)

That's it! Have fun :) (for example, read Takashi's HowTo? about
[TiMidity](/TiMidity "TiMidity") as an ALSA-Sequencer-Client and then
connect a MIDI-Keyboard to your MIDI-Port and you'll be able to play on
it!)

Retrieved from
"[http://alsa.opensrc.org/MPU-401\_MIDI\_setup\_(Howto)](http://alsa.opensrc.org/MPU-401_MIDI_setup_(Howto))"

[Category](/Special:Categories "Special:Categories"):
[Howto](/Category:Howto "Category:Howto")

