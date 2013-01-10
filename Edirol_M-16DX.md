Edirol M-16DX
=============

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

[[1]](http://www.roland.com/products/en/M-16DX/images/top_L.jpg)

This is my intent to get together all the information that I have seen
about this card. I hope this to be usefull and a begin point for other
people. Please, don't hesitage to edit this document. My english is
terrible and I would be glad to be somebody working on it.

* * * * *

This information has been obtained from alsa mail lists. I'm not the
author of this information.

* * * * *

This card is a good piece of hardware with a lot of possibilities, but
still no well supported for final user (I hope this to be solved soon).
The main features are:

-   16-channel full digital mixer with 24-bit/96kHz internal processing
-   Clear sound with ultra-low background noise
-   Easy-to-use operation with friendly analog mixer controls
-   3-band sweepable EQ controls (Q & Freq.) with graphic LCD for
    precise tone shaping
-   Innovative 2-piece mixer+module design
-   "Room Acoustic Auto Control" for automatic room compensation
-   Pro-quality digital effects built in, including COSM® insert
    effects, reverb effects, and finalize effects
-   16 scene memory locations for instant recall
-   18-in/2-out USB 2.0 (Hi-Speed USB) audio interface for computer
    multi-track recording
-   DAW Control Surface; knobs work remotely in SONAR, Logic, etc.
-   Flexible analog and digital I/O, including four high-quality mic
    preamps
-   AC adaptor and connection cable (2m/6ft) included

Alsa doesn't support in this time (2009/02) this device. It is possible
to make it work, but there is a big problem as we will see soon.

Adding Alsa support
-------------------

This device is not compatible with usb-audio but it is possible to tell
to the driver just to use it.

Just add the following entry somewhere in sound/usb/usbquirks.h and to
recompile the driver:

` `

    {
       /* Edirol M-16DX */
       USB_DEVICE(0x0582, 0x00c4),
       .driver_info = (unsigned long) & (const struct snd_usb_audio_quirk) {
           .ifnum = QUIRK_ANY_INTERFACE,
           .type = QUIRK_COMPOSITE,
           .data = (const struct snd_usb_audio_quirk[]) {
               {
                   .ifnum = 0,
                   .type = QUIRK_AUDIO_STANDARD_INTERFACE
               },
               {
                   .ifnum = 1,
                   .type = QUIRK_AUDIO_STANDARD_INTERFACE
               },
               {
                    .ifnum = 2,
                    .type = QUIRK_MIDI_FIXED_ENDPOINT,
                    .data = & (const struct snd_usb_midi_endpoint_info) {
                        .out_cables = 0x0001,
                        .in_cables  = 0x0001
                   }
               },
               {
                   .ifnum = -1
               }
           }
       }
    },

I have proved it and it works, alsa detect de device and loads usb-audio
and all the audio inputs and outputs and the midi interfaces are
available. When I plug it I get ` `

    kernel: usb 1-7: new high speed USB device using ehci_hcd and address 4
    kernel: usb 1-7: configuration #1 chosen from 1 choice
    kernel: usb 1-7: New USB device found, idVendor=0582, idProduct=00c4
    kernel: usb 1-7: New USB device strings: Mfr=1, Product=2, SerialNumber=0
    kernel: usb 1-7: Product: M-16DX
    kernel: usb 1-7: Manufacturer: EDIROL
    kernel: usbcore: registered new interface driver snd-usb-audio
    pulseaudio[4115]: alsa-util.c: Device front:1 doesn't support sample format s16le, changed to s32le.
    pulseaudio[4115]: alsa-util.c: Cannot find fallback mixer control "PCM".
    portatil pulseaudio[4115]: alsa-util.c: Device hw:1 doesn't support 2 channels, changed to 18.
    pulseaudio[4115]: alsa-util.c: Device hw:1 doesn't support sample format s16le, changed to s32le.
    pulseaudio[4115]: alsa-util.c: Cannot find fallback mixer control "Mic".

so, you can figure out that pulseaudio is seeing the device and
detecting the sample size, frecuency and ins and outs. If I look in the
cards information ` `

     cat /proc/asound/cards

it respond ` `

    0 [Intel          ]: HDA-Intel - HDA Intel
                         HDA Intel at 0xb0000000 irq 22
    1 [M16DX          ]: USB-Audio - M-16DX
                         EDIROL M-16DX at usb-0000:00:1d.7-7, high speed

and when I look at the card information ` `

     cat /proc/asound/card1/stream0 

get ` `

     EDIROL M-16DX at usb-0000:00:1d.7-7, high speed : USB Audio

    Playback:
     Status: Stop
     Interface 0
       Altset 1
       Format: 0xa
       Channels: 2
       Endpoint: 2 OUT (ASYNC)
       Rates: 44100

    Capture:
     Status: Stop
     Interface 1
       Altset 1
       Format: 0xa
       Channels: 18
       Endpoint: 1 IN (ASYNC)
       Rates: 44100

Just the configuration that I use in the M-16DX. And if I change the
configuration in the M-16DX, it changes accordingly by unplugging and
pluggin again.

But there is a problem with audio in a periodic way. A distortion that
sounds like a bad audio sync come in and it's affected with the
samplerate.

\

How I'm solving it
------------------

This is a stupid workaround, but I'm now working with it. I own a Edirol
M-16DX and a UA-4FX and use it with the M-16DX as in's and the UA-4FX as
out's. In this moment this works for me because the latency is very low.

I know that I seen sometime a modprobe option (I think) that solved the
problem of distortion, but I'm not available to find it again. Sorry.

I hope this helps.

Retrieved from
"[http://alsa.opensrc.org/Edirol\_M-16DX](http://alsa.opensrc.org/Edirol_M-16DX)"

