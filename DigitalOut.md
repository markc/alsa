DigitalOut
==========

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

These instructions apply to digital connections using either electrical
coax or optical connections.

Contents
--------

-   [1 Special terms](#Special_terms)
-   [2 Overview](#Overview)
    -   [2.1 Sound Data Encoding](#Sound_Data_Encoding)
    -   [2.2 Digital Sound Media](#Digital_Sound_Media)
    -   [2.3 Side notes](#Side_notes)

-   [3 Check your mixer](#Check_your_mixer)
-   [4 Find your device](#Find_your_device)
    -   [4.1 Separate playback device](#Separate_playback_device)
    -   [4.2 Device aliases](#Device_aliases)
    -   [4.3 Alternate method](#Alternate_method)

-   [5 Use your device](#Use_your_device)
    -   [5.1 PCM output](#PCM_output)
    -   [5.2 Digital surround
        passthrough](#Digital_surround_passthrough)
        -   [5.2.1 Test your setup](#Test_your_setup)
        -   [5.2.2 Solve problems](#Solve_problems)

    -   [5.3 Configure your media player](#Configure_your_media_player)
        -   [5.3.1 mplayer](#mplayer)
        -   [5.3.2 MythTV](#MythTV)
        -   [5.3.3 xine](#xine)

-   [6 Set digital out as default](#Set_digital_out_as_default)

Special terms
-------------

Terms used when dealing with digital outputs are:

-   **IEC958** - The name of the IEC standards document and often seen
    in the alsamixer controls
-   **S/PDIF or SPDIF** - Stands for ***Sony/Philips Digital Interface
    Format***, a specification for digital audio communication
-   **TOSLINK** - Optical connectors/cables used for digital audio
    signal transmission
-   **HDMI** - Connectors/cables used for digital audio and video signal
    transmission

Overview
--------

When dealing with audio signal transmission, several standards exist for
the media AND the encoding. Here is a quick overview of what exists.
More information can be found on [this very good
article](http://www.highdefdigest.com/news/show/Joshua_Zyber/High-Def_FAQ:_Blu-ray_and_HD_DVD_Audio_Explained/1064|)

### Sound Data Encoding

-   **PCM signal** - values of a channel at each time step. Usually,
    values are coded on 16, 24 or 32 bits and classical frequencies are
    44.1 (mainly CD) or 48 (mainly DVD and BD) kHz. One PCM signal is
    required for each channel (ie 6 channels for 5.1 sound). The PCM
    signal can have two forms:
    -   analog form: the PCM signal is transmitted by the sound card via
        [analog output](/SurroundSound "SurroundSound") (generally
        through jack plugs). In this case, the receiver has only to
        amplify the signal.
    -   digital form: the PCM signal is transmitted by sending the
        series of numerical values. In this case, the receiver must
        convert it (with a DAC: Digital-to-Analog Converter) to analog
        before amplification.

-   **Encoded BitStream** - numerical data that encode one or more audio
    channels. In this case, the receiver must be able to decode the
    data, then to convert each channels (with DAC) to analog, and
    eventually to amplify them. Some well known encoded bitstream
    formats are Dolby Digital (sometimes known as AC-3), DTS, etc. The
    compression used for an **Encoded BitStream** can be:
    -   "lossy" compression: as with MP3 (but with better results), some
        parts of the original audio data are lost in order to archive a
        better compression of the data. Examples: Dolby Digital, DTS,
        etc.
    -   "lossless" compression: when decoded, the values of PCM channels
        are identical to the original at the expense of a lower
        compression. All "lossless" compressions have the same quality:
        they decode to the same (original) PCM values. Examples: Dolby
        TrueHD, DTS-HD Master Audio.

### Digital Sound Media

Digital signals (PCM or BitStream) can be sent across different media.
We can distinguish:

-   **Coaxial S/PDIF** - a coaxial wire is used to send data in S/PDIF
    format. This connection has a throughput that allows at most two raw
    PCM channels or some "lossy" compression codecs. No "lossless"
    compression codec can be used on this media. This means that in
    order to have 5.1 sound with a coaxial S/PDIF connection, the sound
    must be transmitted in a (supported) encoded bit stream and decoded
    by the receiver.
-   **TOSLINK S/PDIF** - same as coaxial S/PDIF but the information is
    transmitted through an optical link. The throughput is the same as
    for coaxial S/PDIF, hence the same limitations apply.
-   **HDMI** - audio information can be transmitted together with video
    through an HDMI connection. The throughput of an HDMI connection is
    sufficient to allow 8 raw PCM channels or a "lossless" compression
    codec bit stream [perhaps HDMI before version 1.3 allows a little
    bit less]. That means that, with a HDMI connection, decoding of 5.1
    or 7.1 sources can be done either before sending the data (i.e. on
    the computer and sending data as raw PCM channels) or after sending
    the data (i.e. by the receiver).

### Side notes

On some systems with e.g. an HDA Intel sound card, HDMI sound
transmission only works if the video is also transmitted (xrandr can be
used to enable the video output).

Check your mixer
----------------

Mixer settings will affect your testing later on, so check them now. Run
[alsamixer](/Alsamixer "Alsamixer"). Check that Playback or All is
selected for View (top of screen). Look for the following channels and
take action as noted.

-   **IEC958 Output:** Press M to unmute.
    [File:Alsamixer
    pcmout.png](/File:Alsamixer_pcmout.png "File:Alsamixer pcmout.png")
    alsamixer with IEC958 channels set to PCM out.
-   **IEC958**, **IEC958 1** or similarly named channels: Set to "PCM
    Out". ***\<-- HOW do you do this??*** *Added sample image, but
    thumbnail creation doesn't work... For now:
    [[1]](http://alsa.opensrc.org/images/7/70/Alsamixer_pcmout.png)*
    This doesn't apply to all hardware.

When referring to a digital output, setting it to "PCM Out" instructs
the card to pass through the audio bytestream exactly as it is received
from an application without applying any mixer settings. This is
important, since a main point of having a digital audio output is to
extract raw data from the PC to a device that may be more capable. Many
people, apparently including hardware designers, my regard digital
outputs purely as a noise-free version of analog outputs. However, the
interface is really a separate (if unidirectional) interface. This is
important to keep in mind when passing AC3 surround data streams through
the card to an external decoder. In that case, modifications of the
stream would make it completely invalid.

**TODO: Tell people how to set "PCM out" mode. Add more common mixer
settings, try to keep it simple and as general as possible.**

\

Find your device
----------------

There are different ways by which the digital output may be exposed to
the system by ALSA: as an independent device of a soundcard, or as an
alias. The ways to find either one are described below.

### Separate playback device

On most cards the digital out is a specific audio playback device. To
see which ALSA playback devices you have, you can use this command:

` `

    aplay -l

Sample output:

` `

    [jranders@chickadee ~]$ aplay -l
    **** List of PLAYBACK Hardware Devices ****
    card 0: T71Space [Terratec Aureon 7.1-Space], device 0: ICE1724 [ICE1724]
      Subdevices: 1/1
      Subdevice #0: subdevice #0
    card 0: T71Space [Terratec Aureon 7.1-Space], device 1: IEC1724 IEC958 [IEC1724 IEC958]
      Subdevices: 0/1
      Subdevice #0: subdevice #0
    card 0: T71Space [Terratec Aureon 7.1-Space], device 2: ICE1724 Surrounds [ICE1724 Surround PCM]
      Subdevices: 3/3
      Subdevice #0: subdevice #0
      Subdevice #1: subdevice #1
      Subdevice #2: subdevice #2

The device is specified as `hw:(card),(device)`. The sample above shows
device 1 is labeled "IEC1724 IEC958". That is the digital output device
on this card, so it would be called `hw:0,1`. If your card does not show
an IEC958 device, look for S/PDIF or digital.

### Device aliases

On some cards digital out is already -- or even exclusively -- defined
as an alias. See aplay -L for available playback devices. On a system
with nForce 4 chipset onboard audio and an M-Audio Delta Audiophile
2496, this results in:

    $ aplay -L
    default:CARD=CK804
        NVidia CK804, NVidia CK804
        Default Audio Device
    front:CARD=CK804,DEV=0
        NVidia CK804, NVidia CK804
        Front speakers
    surround40:CARD=CK804,DEV=0
        NVidia CK804, NVidia CK804
        4.0 Surround output to Front and Rear speakers
    surround41:CARD=CK804,DEV=0
        NVidia CK804, NVidia CK804
        4.1 Surround output to Front, Rear and Subwoofer speakers
    surround50:CARD=CK804,DEV=0
        NVidia CK804, NVidia CK804
        5.0 Surround output to Front, Center and Rear speakers
    surround51:CARD=CK804,DEV=0
        NVidia CK804, NVidia CK804
        5.1 Surround output to Front, Center, Rear and Subwoofer speakers
    null
        Discard all samples (playback) or generate zero samples (capture)
    default:CARD=M2496
        M Audio Audiophile 24/96, ICE1712 multi
        Default Audio Device
    front:CARD=M2496,DEV=0
        M Audio Audiophile 24/96, ICE1712 multi
        Front speakers
    surround40:CARD=M2496,DEV=0
        M Audio Audiophile 24/96, ICE1712 multi
        4.0 Surround output to Front and Rear speakers
    surround41:CARD=M2496,DEV=0
        M Audio Audiophile 24/96, ICE1712 multi
        4.1 Surround output to Front, Rear and Subwoofer speakers
    surround50:CARD=M2496,DEV=0
        M Audio Audiophile 24/96, ICE1712 multi
        5.0 Surround output to Front, Center and Rear speakers
    surround51:CARD=M2496,DEV=0
        M Audio Audiophile 24/96, ICE1712 multi
        5.1 Surround output to Front, Center, Rear and Subwoofer speakers
    iec958:CARD=M2496,DEV=0
        M Audio Audiophile 24/96, ICE1712 multi
        IEC958 (S/PDIF) Digital Audio Output

If you see IEC958 or S/PDIF in that list you can use the complete
identification including the CARD and DEV parameters as a playback
device instead of ```` ```hw:x,y``` ````.

Important Note: The [OSSEmulation](/OSSEmulation "OSSEmulation") uses
devices ```` ```hw:0,0``` ```` and ```` ```hw:0,1``` ```` for `/dev/dsp`
and `/dev/adsp`. See the page
[OSSEmulation](/OSSEmulation "OSSEmulation").

### Alternate method

If you did not find your digital device with the above commands, keep
reading. Otherwise, skip to the Use Your Device section.

This is another command to show ALSA devices on your sound card:

` `

    cat /proc/asound/devices

Here is an example:

` `

    tapas@mango:~$ cat /proc/asound/devices 
      1:       : sequencer
      0: [0- 0]: ctl
      8: [0- 0]: raw midi
     18: [0- 2]: digital audio playback
     17: [0- 1]: digital audio playback
     16: [0- 0]: digital audio playback
     24: [0- 0]: digital audio capture
     33:       : timer

There are three audio playback devices:

` `

     18: [0- 2]: digital audio playback
     17: [0- 1]: digital audio playback
     16: [0- 0]: digital audio playback

One of these is the digital out. We can test all outputs using the
[aplay](/Aplay "Aplay") command, or alternatively
[alsaplayer](/Alsaplayer "Alsaplayer") or mplayer. If you want to use
`aplay` for this test, you need to have a `.wav` file. The numbers
inside the square brackets ("`[x- y]`") are indexes for the soundcard
(`x`) and the device (`y`) on that soundcard. So to play using the first
playback device on the first card ("[0- 0]") you could use

` `

    aplay -D hw:0,0 file.wav

For the second and third you could use

` `

    aplay -D hw:0,1 file.wav
    aplay -D hw:0,2 file.wav

If you receive a cryptic error message about "Channels count non
available" then the wav file uses a sample rate different to the
hardware. You can add a resampling layer with the 'plug' plugin, e.g.

` `

    aplay -D plughw:0,0 file.wav

Or with mplayer on [0- 0]:

` `

    mplayer file.wav -ao alsa:device=hw=0.0

If you hear sound when running one of these commands, you have found
your digital device. If not, check your connection, receiver volume, and
mixer settings described in the section above.

On some hardware sound does not seem to come out reliably unless you
specify a subdevice explicitly, e.g. "hw:0,1,1".

\

Use your device
---------------

To utilize the digital output, connect your sound card to something with
a digital input (possibly a stereo or surround receiver). Tell your
program to send sound to 'hw:x,y', where x is the card number and y is
the device number shown by 'aplay -l'. For my card, this is hw:0,1.

### PCM output

If you want to use your digital output for sounds and music you simply
tell the application of your choice to use the IEC958 device.

-   MPlayer lets you use the device via '-ao alsa:device=hw=0.1' (beware
    it's a dot, not a comma)
-   XMMS can be set in Preferences-\>Audio I/O Plugins-\>Output Plugin
    by choosing ALSA, then Configure and setting Audio device to
    'hw:0,1'
-   MythTV can be configured in Utilities/Setup-\>Setup-\>General, on
    the third page, by typing 'ALSA:hw:0,1' into Audio output device
-   xine can be set on the audio tab in setup by setting any output you
    like to 'pcm.hw:0,1' and the audio driver to alsa
-   Phonon can be configured in the KDE system settings, after checking
    the advanced devices box. If you use a custom .asoundrc file you
    need to add a "hint" block on the pcm to list.

If you want to test separate PCM channels over an HDMI connection then
speaker-test is your friend. Keep in mind that multichannel PCM only
works with an HDMI connection or with [analog
output](/SurroundSound "SurroundSound").

### Digital surround passthrough

While the setup thus far allows you to use the digital connection, it
doesn't enable Dolby Digital or dts passthrough, where the complete
signal is sent to your receiver for decoding. Without that, you don't
get surround. Please note, not all sources have digital surround in
them. DVDs and digital TV signals commonly do.

Also note that when you start watching a DVD movie you might not get
surround sound until you play the actual movie (i.e. previews or the
menu often have no digital surround).

\

#### Test your setup

A good test for "bit-perfect" digital passthrough (or S/PDIF
passthrough) is to play these [example wav
files](http://www.sr.se/multikanal/english/e_index.stm) to your receiver
decoder through a single TOSLINK or analog digital connection. First you
should turn down the volume on your amplifier all the way to prevent
damage to your speakers in case of failure. Then you can use aplay for
playback, since that is rather easy to use if you just want to dump data
into the card. The DD or DTS light should come on and you should hear
surround sound when raising the volume. The command to play one of the
files may look like this:

    aplay -D iec958:CARD=M2496,DEV=0 Norrlanda.wav

or

    aplay -D hw:0,1 Norrlanda.wav

The parameters:

-   *-D iec958:CARD=M2496,DEV=0*: Set the output device. You can use the
    device names from `aplay -L`.
-   The files provided at the site have proper headers that set up the
    data stream. If you get garbled results with other files you try to
    play, you may need to use *-f dat* to force 48kHz sample rate, 16
    bit little endian sample format, which is often used on DVDs.

\

#### Solve problems

If you hear screeching, modem-like sounds or noise with digital
pass-through then that means your digital output isn't set up correctly
and the AC3/dts decoder can't make sense of the data it receives. If
this happens there are some things you can try:

-   IEC958 knows two modes: audio (PCM) and non-audio. AC3 and dts
    require non-audio to be selected. ALSA should do this automatically
    but you can force non-audio mode with `iecset audio 0` and audio
    mode with `iecset audio 1`.
-   Try using 'plughw' instead of 'hw'. (Shouldn't work but for some
    people it apparently does)

If neither of these work for you, it may be due to the driver and card's
support of sample rates and formats. This might be the case if you see
errors about `"invalid arguments"`. This is one reason to use the dmix
mixer plugin. Look for user notes on your card at
[http://alsa-project.org/alsa-doc/](http://alsa-project.org/alsa-doc/),
[ALSA modules](/ALSA_modules "ALSA modules") and [Sound
cards](/Sound_cards "Sound cards"). Read about [dmix](/Dmix "Dmix") and
[.asoundrc](/.asoundrc ".asoundrc") (asound.conf).

\

### Configure your media player

#### mplayer

In MPlayer, use `-ac hwac3` or `-ac hwdts` as the audio codec. Do not
specify channels, because history dictates channels be set to 2, the
default. Make sure channels is not in your mplayer config files. MPlayer
uses the first audio track it finds so if you want to use another, run
it with -v and look for 'aid' (English Dolby Digital 5.1 is sometimes
128). Then run mplayer with '-aid 128'. If the audio track is dts, use
hwdts. As for the device, use `-ao` and keep in mind that the comma is
replaced by a dot:

     mplayer -ac hwac3 -ao alsa:device=hw=0.1 dvd://

#### MythTV

MythTV can pass through digital surround from digital TV. Go to
Utilities/Setup-\>Setup-\>General, on the third page, and select "Enable
AC3 to S/PDIF passthrough".

#### xine

In xine, go to the audio tab in setup and set speaker arrangement to
`Pass Through` and `5.1 output (alsa passthrough)` to your digital
output, like 'pcm.hw:0,1'. If that doesn't work, try 'plug:iec958'
instead.

The settings below work for me with an M-Audio Delta Audiophile (ICE1712
chip) to get passthrough to work in xine. Note the syntax for card
specification, which is taken straight from `aplay -L`. The card only
offers the IEC958 link as an alias, while only exposing a single device
to the system. Those lines are supposed to go in the `~/.xine/config`
file:

    audio.device.alsa_passthrough_device:iec958:CARD=M2496,DEV=0
    audio.device.alsa_surround40_device:surround40:CARD=M2496,DEV=0
    audio.device.alsa_surround51_device:surround51:CARD=M2496,DEV=0
    audio.output.speaker_arrangement:Pass Through

\

Set digital out as default
--------------------------

On most soundcards the digital output emits the same sound signal as the
analog output. If this is not the case for you then you can set the
default playback device by using [.asoundrc](/.asoundrc ".asoundrc") or
/etc/asound.conf. If you want your digital output to be the default you
might need to add this:

` `

    pcm.!default {
            type hw
            card <the card number you worked out above>
            device <the device number you worked out above>
    }

Retrieved from
"[http://alsa.opensrc.org/DigitalOut](http://alsa.opensrc.org/DigitalOut)"

[Categories](/Special:Categories "Special:Categories"):
[Howto](/Category:Howto "Category:Howto") |
[Configuration](/Category:Configuration "Category:Configuration")

