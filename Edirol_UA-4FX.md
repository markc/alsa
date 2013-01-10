Edirol UA-4FX
=============

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

[pictures](http://www.rolandus.com/products/productdetails.aspx?ObjectId=758&ParentId=114)

*The format of this page is shamelessly copied from the [Edirol
UA-25](/Edirol_UA-25 "Edirol UA-25") page, because that page is laid out
so well.*

The Edirol UA-4FX is a good quality audio device, with great features:

-   Variety of Input & Output options
-   Balanced Input & Output
-   Two Professional Grade Mic Preamps
-   Built-in Digital Signal Processor with some FX processing
    capabilities
-   Zero-Latency, Direct Monitoring
-   USB Bus-Powered
-   Phantom microphone power (48 volts)
-   Full-duplex audio capture and playback at 48kHz and 24-bit samples
-   Half-duplex audio capture and playback at 96kHz and 24-bit samples
    (switching between capture or playback requires a hot or cold
    reboot)
-   MIDI I/O (support added in linux-2.6.28) [Here is the original
    development
    work](/Edirol_UA-4FX#Getting_Advanced_mode_to_work "Edirol UA-4FX")

I hope that this little howto can guide you and save you some time. The
logic of the Edirol UA-4FX is that it is operated by hands, directly on
the device. There are some hardware limitations, but it is frankly a
very nice tool.

* * * * *

The Edirol UA-4FX is partially supported by Alsa: the device is
recognised by the `snd_usb_audio` module. You can play and record at
44.1kHz and 16-bit samples if you have set the Advanced Driver switch to
**off**. Full support for 24-bit playback and recording at rates up to
96 kHz has been successfully tested using the [patch
below](/Edirol_UA-4FX#Getting_Advanced_mode_to_work "Edirol UA-4FX").

* * * * *

*Unfortunately*, Alsa has little control over this device.

In fact, it is not a problem of operating systems (Linux / FreeBSD /
Window\$), but rather a hardware issue. For example, Input level, Output
level, mixing, even sample rate are controlled at the hardware level.
There is no software control. Some users may like this old-fashion way
of managing a sound card. Others may dislike it. Analyse your needs
before purchasing this sound device.

The Edirol UA-4FX is designed to be a simple mixing board. That is why
the input and output levels are controlled by knobs and not software.

**Fortunately**, Alsa offers a variety of features and
[plugins](/ALSA_plugins "ALSA plugins"), *which emulate at software
level the missing features*. This is the advantage of Alsa over other
sound systems.

Contents
--------

-   [1 Understanding the Edirol UA-4FX
    logic](#Understanding_the_Edirol_UA-4FX_logic)
    -   [1.1 Advanced Driver toggle
        switch](#Advanced_Driver_toggle_switch)
    -   [1.2 Sample rates switch](#Sample_rates_switch)
    -   [1.3 Cold/Hot reboot](#Cold.2FHot_reboot)
    -   [1.4 Lost?](#Lost.3F)

-   [2 Basic Alsa configuration](#Basic_Alsa_configuration)
    -   [2.1 Assigning audio system
        rights](#Assigning_audio_system_rights)
    -   [2.2 Naming the Edirol UA-4FX
        device](#Naming_the_Edirol_UA-4FX_device)
    -   [2.3 Testing sound output](#Testing_sound_output)
    -   [2.4 Playing sound](#Playing_sound)
    -   [2.5 Recording sound](#Recording_sound)

-   [3 Advanced Alsa configuration](#Advanced_Alsa_configuration)
    -   [3.1 Full-duplex mode](#Full-duplex_mode)
    -   [3.2 Custom softvol PCM](#Custom_softvol_PCM)
    -   [3.3 Recording left and right input channels
        seperately](#Recording_left_and_right_input_channels_seperately)
    -   [3.4 Digital signals](#Digital_signals)
        -   [3.4.1 Digital In](#Digital_In)
        -   [3.4.2 Digital Out](#Digital_Out)

    -   [3.5 Low latency (to be
        written)](#Low_latency_.28to_be_written.29)

-   [4 MIDI configuration](#MIDI_configuration)
    -   [4.1 MIDI ports](#MIDI_ports)

-   [5 Device information](#Device_information)
    -   [5.1
        cat/proc/bus/usb/devices](#cat.2Fproc.2Fbus.2Fusb.2Fdevices)
    -   [5.2 cat /proc/asound/devices](#cat_.2Fproc.2Fasound.2Fdevices)
    -   [5.3 cat /proc/asound/cards](#cat_.2Fproc.2Fasound.2Fcards)
    -   [5.4 aplay -l](#aplay_-l)
    -   [5.5 Getting Advanced mode to
        work](#Getting_Advanced_mode_to_work)
    -   [5.6 Patch for 2.6.24 through
        2.6.27](#Patch_for_2.6.24_through_2.6.27)

-   [6 See also](#See_also)

Understanding the Edirol UA-4FX logic
-------------------------------------

At first, you should have a look at the back pane. Or look at the photo
of the device. Try to locate three important buttons:

### Advanced Driver toggle switch

On the left side of the UA-4FX, there is an on/off switch called
"Advanced Driver", which controls the USB mode of the device.

-   In advanced mode (Advanced Driver switch ON), the UA-4FX can record
    or play sound in native 24 bits, in either 44.100 Hz, 48.000 Hz or
    96.000 Hz sample rates. You can choose sample rates using a switch
    next to the Advanced Driver switch. At 96 Khz, the device is either
    capture or playback only. MIDI is enabled. Advanced mode support was
    added in 2.6.28, [see
    below](/Edirol_UA-4FX#Getting_Advanced_mode_to_work "Edirol UA-4FX").
-   In normal mode (Advanced Driver switch OFF), the UA-4FX is fully USB
    sound compliant. It records at the rate of 44.100 Hz, in 16 bits,
    and is full-duplex. MIDI is disabled.

### Sample rates switch

On the left side of the UA-4FX, there is a switch button called "SAMPLE
RATE". The switch has four values: 44.1 kHz, 48 kHz, 96 kHz RECORD, and
96 kHz PLAY:

-   With Advanced mode OFF, the device will always record/play natively
    at the rate of 44.1 kHz using 16 bits.

-   With Advanced mode ON, the device will be able to record using 24
    bits. Choose the sample rate using the SAMPLE RATE switch:
    -   44.1 kHz: play and record at the same time,
    -   48 kHz: play and record at the same time,
    -   96 kHz: play OR record, but not both.

### Cold/Hot reboot

Whenever you switch from Advanced ON to Advanced OFF, change sample
rates, or change from 96 kHz RECORD to 96 kHz PLAY, you will either need
to:

-   cold reboot: Unplug the USB cord, plug it again. The hotplug
    mechanism will remove all snd modules and will reload them. Be
    warned : frequent plug/unplug may harm the device physical contacts.
-   shutdown/reboot your computer: it is the recommended way, as it will
    not harm your device (or the USB cord). Your computer might not turn
    off the USB power unless you shut down completely. A good place to
    switch the Advance button is during the grub menu, if you are using
    grub, and if that fails, shut the computer off completely to switch
    the Advance button.

### Lost?

To understand advance mode, sample rates and REC/PLAY, it is recommended
to use `aplay` and `arecord` in verbose (option `-v`) mode. This is what
we will do during the howto. This will clearly show you how the audio
devices plays and records sound.

Basic Alsa configuration
------------------------

alsaconf is not required to use the Edirol UA-4FX. Hotplug is able to
recognise the audio device. Just plug and play.

### Assigning audio system rights

GNU/Linux is a secure system. To play sound, you need audio system
rights. To query your systems rights:

`  `

    $groups
    my_username adm disk dialout fax cdrom floppy tape dip video plugdev powerdev scanner

In this example, I don't have enough rights to play/record sound. To
assign rights:

Become root (system administrator): `  `

    $su
    Password:

Enter the administrator password and then:

`  `

    adduser my_username audio

Will add the user *my\_username* (replace with your username) to the
audio group. You should be able to play music.

### Naming the Edirol UA-4FX device

If the UA-4FX is the only device of your computer, you can address the
device using the `plughw:0,0`, but it is not very convenient. We
recommend using the alphanumeric name of the device. To query the name
of your device, type:

` `

    $cat /proc/asound/cards
     0 [UA4FX          ]: USB-Audio - UA-4FX
                          EDIROL UA-4FX at usb-0000:00:0b.0-6, full speed
     1 [Audio          ]: USB-Audio - USB Audio
                         USB Audio at usb-0000:00:0b.1-4.4.3, full speed

Here, you should use `plughw:UA4FX` rather than `plughw:0,0`

### Testing sound output

Test the card output. This command plays a woman voice on 2 channels
("Front Right", "Front Left"): ` `

    speaker-test -c2 -D plughw:UA4FX -twav

### Playing sound

You can play any sound and it will be played with a sample rate of 44.1
Khz.

To play a sound: ` `

    aplay -D plughw:UA4FX foo.wav

For a better understanding, it is recommended to play in verbose mode:
` `

    aplay -v -D plughw:UA4FX foo.wav

Several lines of text will explain what Alsa is doing:

` `

    Playing WAVE 'foo.wav' : Signed 16 bit Little Endian, Rate 44100 Hz, Stereo
    Plug PCM: Hardware PCM card 0 'UA-4FX' device 0 subdevice 0
    Its setup is:
      stream       : PLAYBACK
      access       : RW_INTERLEAVED
      format       : S16_LE
      subformat    : STD
      channels     : 2
      rate         : 44100
      exact rate   : 44100 (44100/1)
      msbits       : 16
      buffer_size  : 22050
      period_size  : 5513
      period_time  : 125011
      tick_time    : 4000
      tstamp_mode  : NONE
      period_step  : 1
      sleep_min    : 0
      avail_min    : 5513
      xfer_align   : 5513
      start_threshold  : 16539
      stop_threshold   : 22050
      silence_threshold: 0
      silence_size : 0
      boundary     : 6206523236469964800

The sound file has a 44.100 Hz sample rate and 16 bits of resolution.

When playing two sounds at the same time, an error message is displayed:
` `

    aplay: main:546: audio open error: Device or resource busy

You can play sounds at higher sample rates and 24-bit precision using
[Advanced
mode](/Edirol_UA-4FX#Getting_Advanced_mode_to_work "Edirol UA-4FX").

### Recording sound

With the UA-4FX device set to Advanced OFF, you can use the `arecord`
utility from the Alsa package to record any sound from the microphone:

`  `

    $arecord -f cd -t wav -D plughw:UA4FX foobar.wav

For a better understanding, try the same command in verbose mode: ` `

    arecord -v -f cd -t wav -D plughw:UA4FX foo.wav

The resulting message: ` `

    Recording WAVE 'foo.wav' : Signed 16 bit Little Endian, Rate 44100 Hz, Stereo
    Plug PCM: Hardware PCM card 1 'UA-4FX' device 0 subdevice 0
    Its setup is:
      stream       : CAPTURE
      access       : RW_INTERLEAVED
      format       : S16_LE
      subformat    : STD
      channels     : 2
      rate         : 44100
      exact rate   : 44100 (44100/1)
      msbits       : 16
      buffer_size  : 22050
      period_size  : 5513
      period_time  : 125011
      tick_time    : 4000
      tstamp_mode  : NONE
      period_step  : 1
      sleep_min    : 0
      avail_min    : 5513
      xfer_align   : 5513
      start_threshold  : 1
      stop_threshold   : 22050
      silence_threshold: 0
      silence_size : 0
      boundary     : 6206523236469964800

The Edirol UA-4FX is able to record in 24 bits, at the sample rate of 96
Khz.

With [Advanced mode
enabled](/Edirol_UA-4FX#Getting_Advanced_mode_to_work "Edirol UA-4FX"),
playing a recorded sound at 96 Khz would not work:

` `

    aplay -v -D plughw:UA4FX foobar.wav
    aplay: main:550: audio open error: No such file or directory

At 96.000 Hz, the audio device can play OR record, but not both.

If aplay complains of "No such file or directory," it might be because
the SAMPLE RATE switch is set to 96 kHz RECORD. Try changing it to 96
kHz PLAY. You will then need to [cold or hot
reboot](/Edirol_UA-4FX#Cold.2FHot_reboot "Edirol UA-4FX").

Now you should be able to play the sound: ` `

    aplay -v -D plughw:UA4FX foobar.wav

Changing the switch (and enabling [Advanced
mode](/Edirol_UA-4FX#Getting_Advanced_mode_to_work "Edirol UA-4FX")) is
all that is needed to see something like this: ` `

    Playing WAVE 'foobar.wav' : Signed 16 bit Little Endian, Rate 96000 Hz, Stereo
    Plug PCM: Linear conversion PCM (S24_3LE)
    Its setup is:
     stream       : PLAYBACK
     access       : RW_INTERLEAVED
     format       : S16_LE
     subformat    : STD
     channels     : 2
     rate         : 96000
     exact rate   : 96000 (96000/1)
     msbits       : 16
     buffer_size  : 48000
     period_size  : 12000
     period_time  : 125000
     tick_time    : 1000
     tstamp_mode  : NONE
     period_step  : 1
     sleep_min    : 0
     avail_min    : 12000
     xfer_align   : 12000
     start_threshold  : 48000
     stop_threshold   : 48000
     silence_threshold: 0
     silence_size : 0
     boundary     : 6755399441055744000
    Slave: Hardware PCM card 0 'UA-4FX' device 0 subdevice 0
    Its setup is:
     stream       : PLAYBACK
     access       : MMAP_INTERLEAVED
     format       : S24_3LE
     subformat    : STD
     channels     : 2
     rate         : 96000
     exact rate   : 96000 (96000/1)
     msbits       : 24
     buffer_size  : 48000
     period_size  : 12000
     period_time  : 125000
     tick_time    : 1000
     tstamp_mode  : NONE
     period_step  : 1
     sleep_min    : 0
     avail_min    : 12000
     xfer_align   : 12000
     start_threshold  : 48000
     stop_threshold   : 48000
     silence_threshold: 0
     silence_size : 0
     boundary     : 6755399441055744000

Remember, at 96.000 Khz, you can either play OR record, but not both.

Advanced Alsa configuration
---------------------------

The recommended settings in this HOWTO are now:

-   Advance mode : OFF

This will record/play sound in 16 bits, at the frequency of 44.100 Hz.

### Full-duplex mode

The Edirol UA-4FX is a full-duplex device up to 48.000 Hz. With
[Advanced mode
enabled](/Edirol_UA-4FX#Getting_Advanced_mode_to_work "Edirol UA-4FX"),
you can also set the UA-4FX to 96 kHz PLAY or 96 kHz RECORD. The
[Edirol\_UA-25](/Edirol_UA-25 "Edirol UA-25") page suggests using the
asym plugin to get full-duplex 96 kHz operation, but the UA-4FX hardware
does not support it.

### Custom softvol PCM

`$alsamixer -c 0` to use mixer settings on card 0 will return:

` `

    no mixer elems found

Unfortunately these is no software control over the hardware mixers on
the device (like in any USB device), nothing will show up in mixer
programs.

Fortunately, Alsa offers the [softvol](/Softvol "Softvol")
[plugin](/ALSA_plugins "ALSA plugins") to create a software volume
control. We will also define this control as the default mixer.

Here is my first try:

` `

    pcm.!default {
       type             plug
       slave.pcm       "softvol"
    }
    pcm.softvol {
       type            softvol
       slave {
           pcm         "pasymed"
       }
       control {
           name        "SoftMaster"
           card        0
       }
    }

Let us have a look at our software mixer:

` `

    $amixer
    Simple mixer control 'SoftMaster',0
     Capabilities: volume
     Playback channels: Front Left - Front Right
     Capture channels: Front Left - Front Right
     Limits: 0 - 255
     Front Left: 255 [100%]
     Front Right: 255 [100%]

### Recording left and right input channels seperately

When recording from two mono inputs (Input 1/L and Input 2/R), the sound
is mixed into a stereo stream at hardware level. Again, there is no
software control over this audio device.

This is a problem when you only record from one mono microphone. The
resulting stereo sound includes a muted channel with noise. At software
level, you may downmix this sound to mono, but this degrades quality
because of the muted channel with noise.

A simple solution is to [record from left and right input channels
seperately](/Dsnoop#Recording_from_left_or_right_channel "Dsnoop"), as
explained in the [dsnoop](/Dsnoop "Dsnoop") howto.

` `

    pcm.record_left {
       type        dsnoop
       ipc_key 234884
       slave {
           pcm     "plughw:UA4FX"
           channels 2
       }
       bindings.0  0
    }
    pcm.record_right {
       type        dsnoop
       ipc_key 2241234
       slave {
           pcm     "plughw:UA4FX"
           channels 2
       }    
       bindings.0  1
    } 

### Digital signals

The same rules apply here. Alsa has very little control over the UA-4FX
hardware. Digital control is done using buttons on the front pane.

#### Digital In

To record from digital source, you must select DIGITAL from the **REC
SOURCE** switch on the side of the UA-4FX (by the SAMPLE RATE switch).
You can then record using any Alsa tool, on the pasymed or SoftMaster
PCMs.

#### Digital Out

With the Edirol UA-4FX in Advanced mode off, you can play 16 bits,
44.100 Hz digital output.

Let us try Alsa utility [speaker-test](/Speaker-test "Speaker-test"):
`  `

    speaker-test -c 2 -D softvol0 -twav

Connect an optical cable:

-   from Edirol UA-4FX Digital out
-   to a Terratec USB Aureon MK-2 digital in.

In the mixer of the Terratec Aureon, select `Input 2` and check
`IEC958 In`.

Record the digital stream using the following command: `  `

    arecord -v -f S16_LE -c 2 -D plughw:1,0 foobar.wav

### Low latency (to be written)

Investigating. To be written.

MIDI configuration
------------------

*I don't use MIDI instruments. This information comes from the [Ubuntu
Forums](http://ubuntuforums.org/showthread.php?t=1043691). You will need
[Advanced mode
support](/Edirol_UA-4FX#Getting_Advanced_mode_to_work "Edirol UA-4FX").*

For MIDI to work, make sure you are in [Advanced
mode](/Edirol_UA-4FX#Advanced_Driver_toggle_switch "Edirol UA-4FX") by
turning the Advanced mode switch ON located on the left side of the
UA-4FX; you will need to unplug and plug in the device for the change to
take effect.

If MIDI is working, you should see a "raw midi" device for the UA-4FX in
/proc/asound/devices: ` `

    $ grep midi /proc/asound/devices
      8: [ 0- 0]: raw midi

Also, /proc/asound/card0/midi0 should exist (assuming the UA-4FX is the
0th audio device): ` `

    $ cat /proc/asound/card0/midi0
    UA-4FX

    Output 0
      Tx bytes     : 0 
    Input 0
      Rx bytes     : 0

### MIDI ports

When the UA-4FX Advanced mode is
[enabled](/Edirol_UA-4FX#Getting_Advanced_mode_to_work "Edirol UA-4FX"),
`aconnect` should show one MIDI input and one MIDI output port: ` `

    $ aconnect -il                    # list readable MIDI ports
    client 16: 'UA-4FX' [type=kernel]
        0 'UA-4FX MIDI 1    '

    $ aconnect -ol                    # list writable MIDI ports
    client 16: 'UA-4FX' [type=kernel]
        0 'UA-4FX MIDI 1    '

If you prefer a graphical interface, check out `aconnectgui`. The
relevant information can also be found in /proc/asound/seq/clients.

Device information
------------------

The following section may help Alsa hackers:

### cat/proc/bus/usb/devices

Please ignore the OHCI Host Controller and USB Optical Mouse listed in
my /proc/bus/usb/devices ` `

    $cat /proc/bus/usb/devices

    T:  Bus=01 Lev=00 Prnt=00 Port=00 Cnt=00 Dev#=  1 Spd=12  MxCh= 8
    B:  Alloc= 11/900 us ( 1%), #Int=  1, #Iso=  0
    D:  Ver= 1.10 Cls=09(hub  ) Sub=00 Prot=00 MxPS=64 #Cfgs=  1
    P:  Vendor=0000 ProdID=0000 Rev= 2.06
    S:  Manufacturer=Linux 2.6.24-rc2-git5 ohci_hcd
    S:  Product=OHCI Host Controller
    S:  SerialNumber=0000:00:0b.0
    C:* #Ifs= 1 Cfg#= 1 Atr=e0 MxPwr=  0mA
    I:* If#= 0 Alt= 0 #EPs= 1 Cls=09(hub  ) Sub=00 Prot=00 Driver=hub
    E:  Ad=81(I) Atr=03(Int.) MxPS=   2 Ivl=255ms

    T:  Bus=01 Lev=01 Prnt=01 Port=03 Cnt=01 Dev#=  2 Spd=1.5 MxCh= 0
    D:  Ver= 2.00 Cls=00(>ifc ) Sub=00 Prot=00 MxPS= 8 #Cfgs=  1
    P:  Vendor=15ca ProdID=00c3 Rev= 5.12
    S:  Product=USB Optical Mouse
    C:* #Ifs= 1 Cfg#= 1 Atr=a0 MxPwr= 98mA
    I:* If#= 0 Alt= 0 #EPs= 1 Cls=03(HID  ) Sub=01 Prot=02 Driver=usbhid
    E:  Ad=81(I) Atr=03(Int.) MxPS=   4 Ivl=10ms

    T:  Bus=01 Lev=01 Prnt=01 Port=05 Cnt=02 Dev#=  4 Spd=12  MxCh= 0
    D:  Ver= 1.10 Cls=00(>ifc ) Sub=00 Prot=00 MxPS= 8 #Cfgs=  1
    P:  Vendor=0582 ProdID=00a4 Rev= 1.00
    S:  Manufacturer=EDIROL
    S:  Product=UA-4FX
    C:* #Ifs= 3 Cfg#= 1 Atr=80 MxPwr=360mA
    I:* If#= 0 Alt= 0 #EPs= 0 Cls=01(audio) Sub=01 Prot=00 Driver=snd-usb-audio
    I:* If#= 1 Alt= 0 #EPs= 0 Cls=01(audio) Sub=02 Prot=00 Driver=snd-usb-audio
    I:  If#= 1 Alt= 1 #EPs= 1 Cls=01(audio) Sub=02 Prot=00 Driver=snd-usb-audio
    E:  Ad=01(O) Atr=09(Isoc) MxPS= 192 Ivl=1ms
    I:* If#= 2 Alt= 0 #EPs= 0 Cls=01(audio) Sub=02 Prot=00 Driver=snd-usb-audio
    I:  If#= 2 Alt= 1 #EPs= 1 Cls=01(audio) Sub=02 Prot=00 Driver=snd-usb-audio
    E:  Ad=82(I) Atr=05(Isoc) MxPS= 192 Ivl=1ms

### cat /proc/asound/devices

`  `

    $cat /proc/asound/devices
     2:        : timer
     7:        : sequencer
     8: [ 0- 0]: digital audio playback
     9: [ 0- 0]: digital audio capture
    10: [ 0]   : control

### cat /proc/asound/cards

` `

    $cat /proc/asound/cards
    0 [UA4FX          ]: USB-Audio - UA-4FX
                         EDIROL UA-4FX at usb-0000:00:0b.0-6, full speed

### aplay -l

` `

    $aplay -l
    **** List of PLAYBACK Hardware Devices ****
    card 1: UA4FX [UA-4FX], device 0: USB Audio [USB Audio]
      Subdevices: 1/1
      Subdevice #0: subdevice #0

` `

    $aplay -L
    default:CARD=UA4FX
        UA-4FX, USB Audio
        Default Audio Device
    front:CARD=UA4FX,DEV=0
        UA-4FX, USB Audio
        Front speakers
    surround40:CARD=UA4FX,DEV=0
        UA-4FX, USB Audio
        4.0 Surround output to Front and Rear speakers
    surround41:CARD=UA4FX,DEV=0
        UA-4FX, USB Audio
        4.1 Surround output to Front, Rear and Subwoofer speakers
    surround50:CARD=UA4FX,DEV=0
        UA-4FX, USB Audio
        5.0 Surround output to Front, Center and Rear speakers
    surround51:CARD=UA4FX,DEV=0
        UA-4FX, USB Audio
        5.1 Surround output to Front, Center, Rear and Subwoofer speakers
    surround71:CARD=UA4FX,DEV=0
        UA-4FX, USB Audio
        7.1 Surround output to Front, Center, Side, Rear and Woofer speakers
    iec958:CARD=UA4FX,DEV=0
        UA-4FX, USB Audio
        IEC958 (S/PDIF) Digital Audio Output
    null
        Discard all samples (playback) or generate zero samples (capture)

### Getting Advanced mode to work

**Great Big Warning**

*Advanced mode offers 24-bit audio at high sample rates (48kHz full
duplex, and 96kHz half duplex). However, there's noise added by the
hardware on purpose. To figure out how to disable this, which I suppose
is for watermarking / DRM purposes, a reverse engineering effort would
be required.*

I worked through these steps to get almost 100% support for Advanced
mode. All that is missing is software-selectable **Input Monitor** when
the switch is set to AUTO. (When it is set to ON, inputs are always sent
to outputs.)

First, I checked /proc/bus/usb/devices. (I'm leaving out the OHCI hub
and USB Optical Mouse) ` `

    $cat /proc/bus/usb/devices
    T:  Bus=01 Lev=01 Prnt=01 Port=05 Cnt=02 Dev#=  5 Spd=12  MxCh= 0
    D:  Ver= 1.10 Cls=ff(vend.) Sub=00 Prot=ff MxPS= 8 #Cfgs=  1
    P:  Vendor=0582 ProdID=00a3 Rev= 1.00
    S:  Manufacturer=EDIROL
    S:  Product=UA-4FX
    C:* #Ifs= 3 Cfg#= 1 Atr=80 MxPwr=360mA
    I:* If#= 0 Alt= 0 #EPs= 0 Cls=ff(vend.) Sub=02 Prot=02 Driver=(none)
    I:  If#= 0 Alt= 1 #EPs= 1 Cls=ff(vend.) Sub=02 Prot=02 Driver=(none)
    E:  Ad=01(O) Atr=09(Isoc) MxPS= 288 Ivl=1ms
    I:* If#= 1 Alt= 0 #EPs= 0 Cls=ff(vend.) Sub=02 Prot=01 Driver=(none)
    I:  If#= 1 Alt= 1 #EPs= 1 Cls=ff(vend.) Sub=02 Prot=01 Driver=(none)
    E:  Ad=82(I) Atr=05(Isoc) MxPS= 288 Ivl=1ms
    I:* If#= 2 Alt= 0 #EPs= 2 Cls=ff(vend.) Sub=03 Prot=00 Driver=(none)
    E:  Ad=03(O) Atr=02(Bulk) MxPS=  32 Ivl=0ms
    E:  Ad=84(I) Atr=02(Bulk) MxPS=  32 Ivl=0ms
    I:  If#= 2 Alt= 1 #EPs= 2 Cls=ff(vend.) Sub=03 Prot=00 Driver=(none)
    E:  Ad=03(O) Atr=02(Bulk) MxPS=  32 Ivl=0ms
    E:  Ad=84(I) Atr=03(Int.) MxPS=  32 Ivl=1ms

Next I checked the [UA-25 Device
Information](/Edirol_UA-25#Device_information "Edirol UA-25") section
and my usb listing seems close enough.

I made a patch, which works on linux-2.6.24 and linux-2.6.25. It looks
like tiwai included it in 2.6.28-rc3. Thanks! So instead of using the
patch on this page, please upgrade your kernel to linux-2.6.28 or later.

When I load snd\_usb\_audio now, I get the following in dmesg: ` `

    $tail /var/log/dmesg
    [ 2459.843069] ALSA sound/usb/usbmidi.c:1406: switching to altsetting 1 with int ep
    [ 2459.844389] ALSA sound/usb/usbmidi.c:1297: created 1 output and 1 input ports
    [ 2459.844751] usbcore: registered new interface driver snd-usb-audio

The snd\_usb\_audio driver correctly detects the playback and capture
sample rate: ` `

    $cat /proc/asound/cards
     0 [UA4FX          ]: USB-Audio - UA-4FX
                          EDIROL UA-4FX at usb-0000:00:0b.0-6, full speed
    $cat /proc/asound/card0/stream0 # correctly detects 44100, 48000 based on position of SAMPLE RATE switch
    EDIROL UA-4FX at usb-0000:00:0b.0-6, full speed : USB Audio

    Playback:
      Status: Stop
      Interface 0
        Altset 1
        Format: 0x20
        Channels: 2
        Endpoint: 1 OUT (ADAPTIVE)
        Rates: 44100 - 44100 (continuous)
        Rates: 48000 - 48000 (continuous)
        Rates: 96000 - 96000 (continuous)

    Capture:
      Status: Stop
      Interface 1
        Altset 1
        Format: 0x20
        Channels: 2
        Endpoint: 2 IN (ASYNC)
        Rates: 44100 - 44100 (continuous)
        Rates: 48000 - 48000 (continuous)
        Rates: 96000 - 96000 (continuous)
    $cat /proc/asound/card0/pcm0p/sub0/hw_params # playing a 44.1 kHz .wav, card at 44.1 kHz
    access: MMAP_INTERLEAVED
    format: S24_3LE
    subformat: STD
    channels: 2
    rate: 44100 (44100/1)
    period_size: 1024
    buffer_size: 16384
    tick_time: 4000
    $cat /proc/asound/card0/pcm0p/sub0/hw_params # playing a 44.1 kHz .wav, card at 48 kHz
    access: MMAP_INTERLEAVED
    format: S24_3LE
    subformat: STD
    channels: 2
    rate: 48000 (48000/1)
    period_size: 1024
    buffer_size: 16384
    tick_time: 4000
    $cat /proc/asound/card0/pcm0c/sub0/hw_params # recording a .wav, card at 96 kHz RECORD
    access: MMAP_INTERLEAVED
    format: S24_3LE
    subformat: STD
    channels: 2
    rate: 96000 (96000/1)
    period_size: 1024
    buffer_size: 16384
    tick_time: 4000
    $cat /proc/asound/card0/pcm0p/sub0/hw_params # playing a 44.1 kHz .wav, card at 96 kHz PLAY
    access: MMAP_INTERLEAVED
    format: S24_3LE
    subformat: STD
    channels: 2
    rate: 96000 (96000/1)
    period_size: 1024
    buffer_size: 16384
    tick_time: 4000

Switching to 48 kHz playback/recording, /proc/bus/usb/devices has a
third alternate (Alt=2) for interface 0, and it has 1 endpoint: ` `

    C:* #Ifs= 3 Cfg#= 1 Atr=80 MxPwr=360mA
    I:* If#= 0 Alt= 0 #EPs= 0 Cls=ff(vend.) Sub=02 Prot=02 Driver=(none)
    I:  If#= 0 Alt= 1 #EPs= 1 Cls=ff(vend.) Sub=02 Prot=02 Driver=(none)
    E:  Ad=01(O) Atr=09(Isoc) MxPS= 320 Ivl=1ms
    I:  If#= 0 Alt= 2 #EPs= 1 Cls=ff(vend.) Sub=02 Prot=02 Driver=(none)
    E:  Ad=01(O) Atr=09(Isoc) MxPS= 312 Ivl=1ms
    I:* If#= 1 Alt= 0 #EPs= 0 Cls=ff(vend.) Sub=02 Prot=01 Driver=(none)
    I:  If#= 1 Alt= 1 #EPs= 1 Cls=ff(vend.) Sub=02 Prot=01 Driver=(none)

So in create\_ua700\_ua25\_quirk() there's a change to the test for
altsettings. (It's in the patch, above.)

Obviously, at 96 kHz the interfaces list is quite different. But
everything is detected fine, just like the UA-25. Tested MIDI detection
at 96 kHz RECORD, PLAY, 48 kHz, and 44.1 kHz, just fine:

` `

    $cat /proc/asound/devices 
      2:        : timer
      3: [ 0- 0]: raw midi
      4: [ 0- 0]: digital audio playback
      5: [ 0- 0]: digital audio capture
      6: [ 0]   : control
      7:        : sequencer
    $cat /proc/asound/card0/midi0 
    UA-4FX

    Output 0
      Tx bytes     : 0
    Input 0
      Rx bytes     : 0

Every once in a while, the UA-4FX initializes in an odd state: ` `

    $cat /proc/bus/usb/devices
    T:  Bus=01 Lev=01 Prnt=01 Port=05 Cnt=02 Dev#= 13 Spd=12  MxCh= 0
    D:  Ver= 1.00 Cls=ff(vend.) Sub=00 Prot=00 MxPS= 8 #Cfgs=  1
    P:  Vendor=0451 ProdID=3200 Rev= 0.00
    S:  Manufacturer=USB Device - By Haim Eliyahu
    C:* #Ifs= 1 Cfg#= 1 Atr=40 MxPwr=100mA
    I:* If#= 0 Alt= 0 #EPs= 0 Cls=ff(vend.) Sub=00 Prot=00 Driver=(none)

### Patch for 2.6.24 through 2.6.27

Here is a patch for /usr/src/linux-2.6.24/sound/usb/usbaudio.c and
usbquirks.h. I have tested it on linux-2.6.24 and linux-2.6.25:

` `

    Add Alsa support for Roland Edirol UA-4FX in Advanced mode
    (for MIDI support and sample rates of 48 kHz and 96 kHz)
    usbaudio.c, usbquirks.h
    Signed-off-by: david.c.hubbard@gmail.com
    ===================================================================
    diff -u sound/usb/usbaudio.c.00 sound/usb/usbaudio.c
    --- sound/usb/usbaudio.c.00 2007-11-28 02:13:10.000000000 -0700
    +++ sound/usb/usbaudio.c    2007-11-28 02:44:47.000000000 -0700
    @@ -2930,7 +2930,7 @@
     }
     
     /*
    - * Create a stream for an Edirol UA-700/UA-25 interface.  The only way
    + * Create a stream for an Edirol UA-700/UA-25/UA-4FX interface.  The only way
      * to detect the sample rate is by looking at wMaxPacketSize.
      */
     static int create_ua700_ua25_quirk(struct snd_usb_audio *chip,
    @@ -2950,8 +2950,11 @@
        struct audioformat *fp;
        int stream, err;
     
    -   /* both PCM and MIDI interfaces have 2 altsettings */
    -   if (iface->num_altsetting != 2)
    +   /* both PCM and MIDI interfaces have 2 altsettings,
    +    * except UA-4FX at 48 kHz, PCM interface has 3 altsettings */
    +   if (iface->num_altsetting != 2 &&
    +       (chip->usb_id != USB_ID(0x0582, 0x00a3) ||
    +           iface->num_altsetting != 3))
            return -ENXIO;
        alts = &iface->altsetting[1];
        altsd = get_iface_desc(alts);
    diff -u sound/usb/usbquirks.h.00 sound/usb/usbquirks.h
    --- sound/usb/usbquirks.h.00    2007-11-28 02:15:11.000000000 -0700
    +++ sound/usb/usbquirks.h   2007-11-28 02:17:51.000000000 -0700
    @@ -1311,6 +1311,37 @@
        }
     },
        /* TODO: add Edirol MD-P1 support */
    +{  /*
    +    * This quirk is for the "Advanced" modes of the Edirol UA-4FX.
    +    * If the switch is not in an advanced setting, the UA-4FX has
    +    * ID 0x0582/0x00a4 and is standard compliant (no quirks), but
    +    * offers only 16-bit PCM at 44.1 kHz and no MIDI.
    +    */
    +   USB_DEVICE_VENDOR_SPEC(0x0582, 0x00a3),
    +   .driver_info = (unsigned long) & (const struct snd_usb_audio_quirk) {
    +       .vendor_name = "EDIROL",
    +       .product_name = "UA-4FX",
    +       .ifnum = QUIRK_ANY_INTERFACE,
    +       .type = QUIRK_COMPOSITE,
    +       .data = (const struct snd_usb_audio_quirk[]) {
    +           {
    +               .ifnum = 0,
    +               .type = QUIRK_AUDIO_EDIROL_UA700_UA25
    +           },
    +           {
    +               .ifnum = 1,
    +               .type = QUIRK_AUDIO_EDIROL_UA700_UA25
    +           },
    +           {
    +               .ifnum = 2,
    +               .type = QUIRK_AUDIO_EDIROL_UA700_UA25
    +           },
    +           {
    +               .ifnum = -1
    +           }
    +       }
    +   }
    +},
     {
        /* Roland SH-201 */
        USB_DEVICE(0x0582, 0x00ad),

\

See also
--------

-   vendor link:
    [http://www.edirol.net/products/en/UA-4FX](http://www.edirol.net/products/en/UA-4FX)

Retrieved from
"[http://alsa.opensrc.org/Edirol\_UA-4FX](http://alsa.opensrc.org/Edirol_UA-4FX)"

[Category](/Special:Categories "Special:Categories"): [Sound
cards](/Category:Sound_cards "Category:Sound cards")

