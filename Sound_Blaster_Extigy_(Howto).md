Sound Blaster Extigy (Howto)
============================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

This article describes how to get the Sound Blaster Extigy/Audigy
working with ALSA.

How do I use LIRC's alsa\_usb plugin for my SB Extigy/Audigy remote control?
----------------------------------------------------------------------------

Support for the remote controls of SB Extigy/Audigy is added in version
1.0.9 of the alsa-drivers, the alsa\_usb module is in lirc version
0.7.2. LIRC's alsa\_usb module relies on the alsa device names.
`/proc/asound/cards` lists the number and name of each recognized
soundcard:

` `

       0 [Extigy       ]: USB-Audio - Sound Blaster Extigy
                          Creative Technology Ltd. Sound Blaster Extigy at usb-0000:00:1d.1-2, full speed
       1 [I82801DBICH4 ]: ICH4 - Intel 82801DB-ICH4
                          Intel 82801DB-ICH4 with AD1981B at 0x24000800, irq 11
       2 [Modem        ]: ICH-MODEM - Intel 82801DB-ICH4 Modem
                          Intel 82801DB-ICH4 Modem at 0x1400, irq 11

You can either pass the number or name of the sound card prefixed with
`hw:` to lircd. In this case lircd -d `hw:0` or lircd -d `hw:Extigy`. I
recommend using the name, since it is independent of the order in which
the devices are discovered and lircd will exit, if the Extigy is not
connected.

\

How do I get AC3 surround sound with my Sound Blaster Extigy?
-------------------------------------------------------------

In order to play a DVD with surround sound using your Extigy, you need
to access the third device on the card. So if you usually access your
Extigy as `hw:1` then the third device on the card is `hw:1,2`, or if
you want to use names `hw:Extigy,2`. This device accepts an SPDIF
formatted AC3 stream which your video player passes to the card. Both
xine and mplayer can do this.

Xine: You need to set the passthrough device
(device.alsa\_passthrough\_device) to this device (`hw:Extigy,2`) and
set the speaker arrangement (output.speaker\_arrangement) to "Pass
Through". N.B. in kaffeine device.alsa\_passthrough\_device and
device.alsa\_surround51\_device share the same description "device used
for 5.1-channel output" so make sure you get the right one.

MPlayer: The flag "-ac hwac3" instructs mplayer to send the encoded
stream directly to your soundcard. Ensure that mplayer uses the third
device either through a configuration file or at the command line (e.g.
playing a
`dvd: "mplayer dvd://1 -ac hwac3 -ao alsa:device=hw=Extigy.2"`)

Now, whenever you play a video with an AC3 audio track (such as a dvd),
the Digital LED will light up and you get surround sound.

Finally you need to adjust the output of the Extigy to your surround
sound setup. In alsamixer you can do this by adjusting the "channel
routing mode" control to the appropriate setting for your surround
configuration. The exaudio driver for OSS mentioned this by the
following:

The extigy has seven speaker modes when decoding AC3 audio:

    mode  Rs Ls LFE C  R  L
      1   0  0   0  0  1  1
      2   0  0   0  0  1  1
      3   0  0   1  0  1  1
      4   1  1   0  0  1  1
      5   1  1   1  0  1  1
      6   1  1   0  1  1  1
      7   1  1   1  1  1  1
    Channel names: 
     Rs = Right surround, Ls = Left surround,  
     LFE = Low frequency enhancement, C = Center front, 
     R = Right front, L = Left front 

\
 In alsamixer, 1 corresponds to 00 and 7 to 100 with the rest spaced
evenly in between. For a configuration of 2 front and 2 rear speakers,
use mode 4. However, a further peculiarity is that the names of the
channels as reported by amixer are incorrect, at least in one case.
Amixer reports the following:

    Simple mixer control 'Master',0
    Capabilities: pvolume pswitch pswitch-joined
    Playback channels: Front Left - Front Right - Rear Left - Rear Right - Front Center - Woofer
    Limits: Playback 0 - 200
    Mono:
    Front Left: Playback 180 [90%] [on]
    Front Right: Playback 180 [90%] [on]
    Rear Left: Playback 0 [0%] [on]
    Rear Right: Playback 0 [0%] [on]
    Front Center: Playback 200 [100%] [on]
    Woofer: Playback 200 [100%] [on]

However, the reported channels do not match the ones that they control
(this has been reported as a bug). The mapping is like this:

    control:     speaker:
    front left   front left
    front right  front right
    rear left    front center
    rear right   woofer
    front center rear left
    woofer       rear right

In alsamixer you control front and rear with the first two stereo mixers
which then gives you front left + right on the first mixer and center
and woofer on the second stereo mixer. The other two mono mixers
intended for center and woofer give you rear left and rear right.

Additionally there is another mono mixer in alsamixer called Master 1.
This mixer controls all channels. Unfortunately it does not increase or
decrease them relative to each other but sets them to one fixed value.

Retrieved from
"[http://alsa.opensrc.org/Sound\_Blaster\_Extigy\_(Howto)](http://alsa.opensrc.org/Sound_Blaster_Extigy_(Howto))"

[Category](/Special:Categories "Special:Categories"):
[Howto](/Category:Howto "Category:Howto")

