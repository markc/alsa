Cakewalk UA-1G
==============

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

ATTENTION: This page is still under construction. This part will be
removed I finished all the tests described on this page. Main problem is
I don't get dmix / softvol to work.

Product page with
[pictures](http://www.roland.com/products/en/UA-1G/index.html)

*This is a card from probably March 2009. The format of this page is
based on the UA-4FX page, because that page is laid out so well.*

The Roland Cakewalk UA-1G is a good quality audio device, with the
following features:

-   Variety of Input & Output options
-   Mic/Guitar Preamp
-   Zero-Latency, Direct Monitoring
-   USB Bus-Powered
-   Full-duplex audio capture and playback at 48kHz and 24-bit samples
-   Half-duplex audio capture and playback at 96kHz and 24-bit samples
    (switching between capture or playback requires changing of setting
    at the back of the device)
-   Very small device to take on the road

I hope that this little howto can guide you and save you some time. The
logic of the Roland Cakewalk UA-1G is that it is operated by hands,
directly on the device. There are some hardware limitations, but it is
frankly a very nice tool.

* * * * *

The Roland Cakewalk UA-1G is not yet supported by Alsa. With the [patch
below](/Cakewalk_UA-1G#Getting_Advanced_mode_to_work "Cakewalk UA-1G")
the device is recognised by the `snd_usb_audio` module. You can play and
record at 44.1kHz and 16-bit samples if you have set the Advanced Driver
switch to **off**. Full support for 24-bit playback and recording at
rates up to 96 kHz has been successfully tested.

* * * * *

*Unfortunately*, Alsa has little control over this device.

In fact, it is not a problem of operating systems (Linux / FreeBSD /
Window\$), but rather a hardware issue. For example, Input level, Phone
volume, mixing, even sample rate are controlled at the hardware level.
There is no software control. Not even with the original Mac/Window\$
drivers. Some users may like this old-fashion way of managing a sound
card. Others may dislike it. Analyse your needs before purchasing this
sound device.

The Roland Cakewalk UA-1G is designed to be a simple mixing board. That
is why the input and output levels are controlled by knobs and not
software.

**Fortunately**, Alsa offers a variety of features and
[plugins](/ALSA_plugins "ALSA plugins"), *which emulate at software
level the missing features*. This is the advantage of Alsa over other
sound systems.

Contents
--------

-   [1 Understanding the Roland Cakewalk UA-1G
    logic](#Understanding_the_Roland_Cakewalk_UA-1G_logic)
    -   [1.1 Advanced Driver toggle
        switch](#Advanced_Driver_toggle_switch)
    -   [1.2 Sample rates switch](#Sample_rates_switch)
    -   [1.3 Cold/Hot reboot](#Cold.2FHot_reboot)
    -   [1.4 Lost?](#Lost.3F)

-   [2 Basic Alsa configuration](#Basic_Alsa_configuration)
    -   [2.1 Assigning audio system
        rights](#Assigning_audio_system_rights)
    -   [2.2 Naming the Roland Cakewalk UA-1G
        device](#Naming_the_Roland_Cakewalk_UA-1G_device)
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

-   [4 Device information](#Device_information)
    -   [4.1
        cat/proc/bus/usb/devices](#cat.2Fproc.2Fbus.2Fusb.2Fdevices)
    -   [4.2 cat /proc/asound/devices](#cat_.2Fproc.2Fasound.2Fdevices)
    -   [4.3 cat /proc/asound/cards](#cat_.2Fproc.2Fasound.2Fcards)
    -   [4.4 aplay -l](#aplay_-l)
    -   [4.5 Getting Advanced mode to
        work](#Getting_Advanced_mode_to_work)
    -   [4.6 Getting Advanced mode to work (alternative
        way)](#Getting_Advanced_mode_to_work_.28alternative_way.29)

-   [5 ToDo](#ToDo)
-   [6 See also](#See_also)

Understanding the Roland Cakewalk UA-1G logic
---------------------------------------------

At first, you should have a look at the back pane. Or look at the photo
of the device. Try to locate three important buttons:

### Advanced Driver toggle switch

On the left side of the UA-1G, there is an on/off switch called
"Advanced Driver", which controls the USB mode of the device. You have
to remove your sound card prior changing this switch.

-   In advanced mode (Advanced Driver switch ON), the UA-1G can record
    or play sound in native 24 bits, in either 32.000 Hz, 44.100 Hz,
    48.000 Hz or 96.000 Hz sample rates. You can choose sample rates
    using a switch next to the Advanced Driver switch. At 96 Khz, the
    device is either capture or playback only.
-   In normal mode (Advanced Driver switch OFF), the UA-1G is fully USB
    sound compliant. It records at the rate of either 32.000 Hz, 44.100
    Hz, 48.000 Hz in 16 bits, and is full-duplex.

### Sample rates switch

On the left side of the UA-1G, there are two switch buttons called
"SAMPLE RATE". The switches have four values: 32 kHz, 44.1 kHz, 48 kHz,
96 kHz and one switch called "96 kHz MODE" for RECORD or PLAY at 96 kHz:

-   With Advanced mode OFF, the device will always record/play natively
    at the rate of the set "SAMPLE RATE" using 16 bits.

-   With Advanced mode ON, the device will be able to record using 24
    bits. Choose the sample rate using the "SAMPLE RATE" switches:
    -   32 kHz: play and record at the same time,
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
-   Restart alsa system. This basically requires do a "sudo service alsa
    restart". You have to make sure that no program accesses the alsa
    devices (like the desktop, jackd, pulse, web browser, midi etc.).
    Reboot might be easier in most cases. In case of problems do a "sudo
    service alsa" with "stop" parameter first and check if the alsa
    modules were really unloaded before doing a "start" again.

### Lost?

To understand advance mode, sample rates and REC/PLAY, it is recommended
to use `aplay` and `arecord` in verbose (option `-v`) mode. This is what
we will do during the howto. This will clearly show you how the audio
devices plays and records sound.

Basic Alsa configuration
------------------------

alsaconf is not required to use the Roland Cakewalk UA-1G. UDev is able
to recognise the audio device. Just plug and play.

### Assigning audio system rights

GNU/Linux is a secure system. To play sound, you need audio system
rights. To query your systems rights:

`  `

    $groups
    my_username adm disk dialout fax cdrom floppy tape dip video plugdev powerdev scanner

In this example, I don't have enough rights to play/record sound. To
assign rights either use your distributions configuration tools (like
drakconf, yast). Find your own user account and add the group "audio" to
it. Alternatively you can do it manually like this:

`  `

    sudo adduser my_username audio

Will add the user *my\_username* (replace with your username) to the
audio group. You should be able to play music.

### Naming the Roland Cakewalk UA-1G device

If the UA-1G is the only device of your computer, you can address the
device using the `plughw:0,0`, but it is not very convenient. We
recommend using the alphanumeric name of the device. To query the name
of your device, type:

` `

    $cat /proc/asound/cards
     0 [UA1G           ]: USB-Audio - Cakewalk UA-1G
                          Roland Cakewalk UA-1G at usb-0000:00:1d.1-1, full speed

Here, you should use `plughw:UA1G` rather than `plughw:0,0`

### Testing sound output

Test the card output. This command plays a woman voice on 2 channels
("Front Right", "Front Left"): ` `

    speaker-test -c2 -D plughw:UA1G -twav

This program needs to be installed separately on some distributions.

### Playing sound

You can play any sound and it will be played with the sample rate set
via the SAMPLE RATE switches.

To play a sound: ` `

    aplay -D plughw:UA1G foo.wav

For a better understanding, it is recommended to play in verbose mode:
` `

    aplay -v -D plughw:UA1G foo.wav

Several lines of text will explain what Alsa is doing:

` `

    Playing WAVE 'foo.wav' : Signed 24 bit Little Endian, Rate 48000 Hz, Stereo
    Plug PCM: Linear conversion PCM (S24_3LE)
    Its setup is:
      stream       : PLAYBACK
      access       : RW_INTERLEAVED
      format       : S24_LE
      subformat    : STD
      channels     : 2
      rate         : 48000
      exact rate   : 48000 (48000/1)
      msbits       : 32
      buffer_size  : 24000
      period_size  : 6000
      period_time  : 125000
      tstamp_mode  : NONE
      period_step  : 1
      avail_min    : 6000
      period_event : 0
      start_threshold  : 24000
      stop_threshold   : 24000
      silence_threshold: 0
      silence_size : 0
      boundary     : 1572864000
    Slave: Hardware PCM card 1 'Cakewalk UA-1G' device 0 subdevice 0
    Its setup is:
      stream       : PLAYBACK
      access       : MMAP_INTERLEAVED
      format       : S24_3LE
      subformat    : STD
      channels     : 2
      rate         : 48000
      exact rate   : 48000 (48000/1)
      msbits       : 24
      buffer_size  : 24000
      period_size  : 6000
      period_time  : 125000
      tstamp_mode  : NONE
      period_step  : 1
      avail_min    : 6000
      period_event : 0
      start_threshold  : 24000
      stop_threshold   : 24000
      silence_threshold: 0
      silence_size : 0
      boundary     : 1572864000

The sound file has a 48.000 Hz sample rate and 24 bits of resolution.

When playing two sounds at the same time, an error message is displayed:
` `

    aplay: main:546: audio open error: Device or resource busy

You can play sounds at higher sample rates and 24-bit precision using
[Advanced
mode](/Cakewalk_UA-1G#Getting_Advanced_mode_to_work "Cakewalk UA-1G").

### Recording sound

With the UA-1G device set to Advanced OFF, you can use the `arecord`
utility from the Alsa package to record any sound from the microphone:

`  `

    $arecord -f cd -t wav -D plughw:UA1G foobar.wav

For a better understanding, try the same command in verbose mode: ` `

    arecord -v -f cd -t wav -D plughw:UA1G foo.wav

The resulting message: ` `

    Recording WAVE 'foo.wav' : Signed 16 bit Little Endian, Rate 44100 Hz, Stereo
    Plug PCM: Rate conversion PCM (48000, sformat=S24_3LE)
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
      period_size  : 5512
      period_time  : 125000
      tstamp_mode  : NONE
      period_step  : 1
      avail_min    : 5512
      period_event : 0
      start_threshold  : 1
      stop_threshold   : 22050
      silence_threshold: 0
      silence_size : 0
      boundary     : 1445068800
    Slave: Hardware PCM card 1 'Cakewalk UA-1G' device 0 subdevice 0
    Its setup is:
      stream       : CAPTURE
      access       : MMAP_INTERLEAVED
      format       : S24_3LE
      subformat    : STD
      channels     : 2
      rate         : 48000
      exact rate   : 48000 (48000/1)
      msbits       : 24
      buffer_size  : 24001
      period_size  : 6000
      period_time  : 125000
      tstamp_mode  : NONE
      period_step  : 1
      avail_min    : 6000
      period_event : 0
      start_threshold  : 1
      stop_threshold   : 24001
      silence_threshold: 0
      silence_size : 0
      boundary     : 1572929536

The Roland Cakewalk UA-1G is able to record in 24 bits, at the sample
rate of 96 Khz.

With [Advanced mode
enabled](/Cakewalk_UA-1G#Getting_Advanced_mode_to_work "Cakewalk UA-1G"),
playing a recorded sound at 96 Khz with the "96 kHz MODE" switch set to
PLAY should work:

` `

    aplay -v -D plughw:UA1G foobar.wav

At 96.000 Hz, the audio device can play OR record, but not both.

If aplay complains of "No such file or directory," it might be because
the "96 kHz MODE" switch is set to RECORD. Try changing it to PLAY. You
might then need to [cold or hot
reboot](/Cakewalk_UA-1G#Cold.2FHot_reboot "Cakewalk UA-1G").

Now you should be able to play the sound: ` `

    aplay -v -D plughw:UA1G foobar.wav

Changing the switch (and enabling [Advanced
mode](/Cakewalk_UA-1G#Getting_Advanced_mode_to_work "Cakewalk UA-1G"))
is all that is needed to see something like this: ` `

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
    Slave: Hardware PCM card 0 'UA-1G' device 0 subdevice 0
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

Also remember some programs don't offer plughw or might give you an
error message concerning the "sample format". Be sure to exactly
configure in this case the record parameter as put out above, especially
setting the format to S24\_3LE (signed 24 bit little endian), 2 channels
and the configured sample rate will be required for recording.

Advanced Alsa configuration
---------------------------

The recommended settings in this HOWTO are now:

-   Advance mode : ON

This will record/play sound in 24 bits, at the frequency set via SAMPLE
RATE switches.

### Full-duplex mode

The Roland Cakewalk UA-1G is a full-duplex device up to 48.000 Hz. With
[Advanced mode
enabled](/Cakewalk_UA-1G#Getting_Advanced_mode_to_work "Cakewalk UA-1G"),
you can also set the UA-1G to 96 kHz PLAY or 96 kHz RECORD. The
[Edirol\_UA-25](/Edirol_UA-25 "Edirol UA-25") page suggests using the
asym plugin to get full-duplex 96 kHz operation, but the hardware does
not support it. Someone, please verify that the UA-25 asym setup is
reasonable and update this section.

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

The below example does not work for me (in my system I have two
soundcards, so I changed card to "1". Alsamixer always gave me the error
"no mixer elems found" no matter what I tried. Also pcm "pasymed" is not
defined anywhere in this example (dmix/plugin:dmixer does not work for
me either). It seems the author of UA-4FX has not tested this or left
out important parts of it. If you have a working example with internal
and external soundcard please drop me a note.

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
explained in the [dsnoop](/Dsnoop "Dsnoop") howto. The better solution
is to use the Mic/Guitar input for a mono dynamic or Mic Plug-In Powered
input for a monaural or the R/L input for a stereo microphone (stereo
might require input level adjustments outside the UA-1G!).

` `

    pcm.record_left {
       type        dsnoop
       ipc_key 234884
       slave {
           pcm     "plughw:UA1G"
           channels 2
       }
       bindings.0  0
    }
    pcm.record_right {
       type        dsnoop
       ipc_key 2241234
       slave {
           pcm     "plughw:UA1G"
           channels 2
       }    
       bindings.0  1
    } 

### Digital signals

The same rules apply here. Alsa has very little control over the UA-1G
hardware. Digital Record must be enabled on the back with the switch
"REC SOURCE" set to DIGITAL. Note: Not tested by me

#### Digital In

To record from digital source, you must select DIGITAL from the **REC
SOURCE** switch on the back side of the UA-1G (near the SAMPLE RATE
switches). You can then record using any Alsa tool, on the pasymed or
SoftMaster PCMs. Note: Not tested by me

#### Digital Out

With the Roland Cakewalk UA-1G in Advanced mode off, you can play 16
bits, SAMPLE RATE (switches) digital output.

Let us try Alsa utility [speaker-test](/Speaker-test "Speaker-test"):
`  `

    speaker-test -c 2 -D softvol0 -twav

Connect an optical cable:

-   from Roland Cakewalk UA-1G digital out
-   to a Terratec USB Aureon MK-2 digital in.

In the mixer of the Terratec Aureon, select `Input 2` and check
`IEC958 In`.

Record the digital stream using the following command: `  `

    arecord -v -f S16_LE -c 2 -D plughw:1,0 foobar.wav

Note: Not tested by me

### Low latency (to be written)

Investigating. To be written.

Device information
------------------

The following section may help Alsa hackers:

### cat/proc/bus/usb/devices

Please note that I removed all other USB devices from the below device
output. ` `

    $cat /proc/bus/usb/devices

    T:  Bus=03 Lev=01 Prnt=01 Port=00 Cnt=01 Dev#=  2 Spd=12  MxCh= 0
    D:  Ver= 1.10 Cls=ff(vend.) Sub=00 Prot=ff MxPS= 8 #Cfgs=  1
    P:  Vendor=0582 ProdID=00e9 Rev= 1.00
    S:  Manufacturer=Roland
    S:  Product=UA-1G
    C:* #Ifs= 1 Cfg#= 1 Atr=80 MxPwr=200mA
    I:* If#= 0 Alt= 0 #EPs= 0 Cls=ff(vend.) Sub=02 Prot=01 Driver=(none)
    I:  If#= 0 Alt= 1 #EPs= 1 Cls=ff(vend.) Sub=02 Prot=01 Driver=(none)
    E:  Ad=82(I) Atr=05(Isoc) MxPS= 608 Ivl=1ms

### cat /proc/asound/devices

Please note that I removed all other audio devices from this output.
`  `

    $cat /proc/asound/devices
     0: [ 0]   : control
     1:        : timer
    16: [ 0- 0]: digital audio playback
    24: [ 0- 0]: digital audio capture

### cat /proc/asound/cards

Please note that I removed all other audio devices from this output. ` `

    $cat /proc/asound/cards
    0 [UA1G           ]: USB-Audio - Cakewalk UA-1G
                         Roland Cakewalk UA-1G at usb-0000:00:1d.1-1, full speed

### aplay -l

` `

    $aplay -l
    **** List of PLAYBACK Hardware Devices ****
    card 0: UA1G [Cakewalk UA-1G], device 0: USB Audio [USB Audio]
      Subdevices: 1/1
      Subdevice #0: subdevice #0

` `

    $aplay -L
    front:CARD=UA1G,DEV=0
        UA-1G, USB Audio
        Front speakers
    surround40:CARD=UA1G,DEV=0
        UA-1G, USB Audio
        4.0 Surround output to Front and Rear speakers
    surround41:CARD=UA1G,DEV=0
        UA-1G, USB Audio
        4.1 Surround output to Front, Rear and Subwoofer speakers
    surround50:CARD=UA1G,DEV=0
        UA-1G, USB Audio
        5.0 Surround output to Front, Center and Rear speakers
    surround51:CARD=UA1G,DEV=0
        UA-1G, USB Audio
        5.1 Surround output to Front, Center, Rear and Subwoofer speakers
    surround71:CARD=UA1G,DEV=0
        UA-1G, USB Audio
        7.1 Surround output to Front, Center, Side, Rear and Woofer speakers
    iec958:CARD=UA1G,DEV=0
        UA-1G, USB Audio
        IEC958 (S/PDIF) Digital Audio Output

### Getting Advanced mode to work

Dch24: I worked through these steps to get almost 100% support for
Advanced mode. All that is missing is software-selectable **Input
Monitor** when the switch is set to AUTO. (When it is set to ON, inputs
are always sent to outputs.)

First, I checked /proc/bus/usb/devices. (Only relevant device(s)) ` `

    $cat /proc/bus/usb/devices
    T:  Bus=03 Lev=01 Prnt=01 Port=00 Cnt=01 Dev#=  2 Spd=12  MxCh= 0
    D:  Ver= 1.10 Cls=ff(vend.) Sub=00 Prot=ff MxPS= 8 #Cfgs=  1
    P:  Vendor=0582 ProdID=00e9 Rev= 1.00
    S:  Manufacturer=Roland
    S:  Product=UA-1G
    C:* #Ifs= 1 Cfg#= 1 Atr=80 MxPwr=200mA
    I:* If#= 0 Alt= 0 #EPs= 0 Cls=ff(vend.) Sub=02 Prot=01 Driver=(none)
    I:  If#= 0 Alt= 1 #EPs= 1 Cls=ff(vend.) Sub=02 Prot=01 Driver=(none)
    E:  Ad=82(I) Atr=05(Isoc) MxPS= 608 Ivl=1ms

Next I checked the [UA-25 Device
Information](/Edirol_UA-25#Device_information "Edirol UA-25") section
and my usb listing seems close enough.

**You don't need to patch your driver or kernel if you have at least
alsa-driver-1.0.22.1 installed (version check: /proc/asound/version).**

Looking at /usr/src/linux-2.6.27.19/sound/usb/usbaudio.c and usbquirks.h
I made the following patch, tested on linux-2.6.27.19 (distribution
kernel), based on the newer alsa-driver-1.0.19: ` `

    Add Alsa support for Roland Cakewalk UA-1G in Advanced mode
    (for sample rates of 48 kHz and 96 kHz)
    usbquirks.h
    ===================================================================
    diff -uNr alsa-kernel/usb/usbquirks.h sound/usb/usbquirks.h
    --- alsa-kernel/usb/usbquirks.h~        2009-01-19 12:08:58.000000000 +0100
    +++ alsa-kernel/usb/usbquirks.h 2009-03-29 14:30:39.000000000 +0200
    @@ -1528,6 +1528,37 @@
                    }
            }
     },
    +{
    +       /* Only needed in "Advanced Driver" mode 
    +        * For the standard mode, Cakewalk UA-1G has ID 0582:00ea, which
    +        * offers only 16-bit PCM at set SAMPLE RATE (switches).
    +        * No mixers available with this quirk in Advanced Driver mode!
    +        */
    +       USB_DEVICE(0x0582, 0x00e9),
    +       .driver_info = (unsigned long) & (const struct snd_usb_audio_quirk) {
    +               .vendor_name = "Roland",
    +               .product_name = "Cakewalk UA-1G",
    +               .ifnum = QUIRK_ANY_INTERFACE,
    +               .type = QUIRK_COMPOSITE,
    +               .data = (const struct snd_usb_audio_quirk[]) {
    +                       {
    +                               .ifnum = 0,
    +                               .type = QUIRK_AUDIO_EDIROL_UAXX
    +                       },
    +                       {
    +                               .ifnum = 1,
    +                               .type = QUIRK_AUDIO_EDIROL_UAXX
    +                       },
    +                       {
    +                               .ifnum = -1,
    +                               .type = QUIRK_AUDIO_EDIROL_UAXX
    +                       },
    +                       {
    +                               .ifnum = -1
    +                       }
    +               }
    +       }
    +},

     /* Guillemot devices */
     {

When I plug in the card, I get the following in the kernel log:
` kernel: usb 3-1: USB disconnect, address 4 kernel: usb 3-1: new full speed USB device using uhci_hcd and address 5 kernel: usb 3-1: configuration #1 chosen from 1 choice kernel: usb 3-1: New USB device found, idVendor=0582, idProduct=00e9 kernel: usb 3-1: New USB device strings: Mfr=1, Product=2, SerialNumber=0 kernel: usb 3-1: Product: UA-1G kernel: usb 3-1: Manufacturer: Roland`

The snd\_usb\_audio driver correctly detects the playback and capture
sample rate: ` `

    $cat /proc/asound/cards
     0 [UA1G           ]: USB-Audio - Cakewalk UA-1G
                          Roland Cakewalk UA-1G at usb-0000:00:0b.0-6, full speed
    $cat /proc/asound/card0/stream0 # correctly detects 32000, 44100, 48000 based on position of SAMPLE RATE switches
    Roland Cakewalk UA-1G at usb-0000:00:0b.0-6, full speed : USB Audio

    Playback:
      Status: Stop
      Interface 0
        Altset 1
        Format: 0x20
        Channels: 2
        Endpoint: 1 OUT (ADAPTIVE)
        Rates: 48000 - 48000 (continuous)

    Capture:
      Status: Stop
      Interface 1
        Altset 1
        Format: 0x20
        Channels: 2
        Endpoint: 2 IN (ASYNC)
        Rates: 48000 - 48000 (continuous)

    $cat /proc/asound/card0/pcm0p/sub0/hw_params # playing a 44.1 kHz .wav, card at 44.1 kHz
    access: MMAP_INTERLEAVED
    format: S24_3LE
    subformat: STD
    channels: 2
    rate: 44100 (44100/1)
    period_size: 6000
    buffer_size: 240001
    $cat /proc/asound/card0/pcm0p/sub0/hw_params # playing a 44.1 kHz .wav, card at 48 kHz
    access: MMAP_INTERLEAVED
    format: S24_3LE
    subformat: STD
    channels: 2
    rate: 48000 (48000/1)
    period_size: 6000
    buffer_size: 240001
    $cat /proc/asound/card0/pcm0c/sub0/hw_params # recording a .wav, card at 96 kHz RECORD
    access: MMAP_INTERLEAVED
    format: S24_3LE
    subformat: STD
    channels: 2
    rate: 96000 (96000/1)
    period_size: 6000
    buffer_size: 240001
    $cat /proc/asound/card0/pcm0p/sub0/hw_params # playing a 44.1 kHz .wav, card at 96 kHz PLAY
    access: MMAP_INTERLEAVED
    format: S24_3LE
    subformat: STD
    channels: 2
    rate: 96000 (96000/1)
    period_size: 6000
    buffer_size: 240001

Switching to 48 kHz playback/recording, /proc/bus/usb/devices has 1 more
endpoint: ` `

    C:* #Ifs= 2 Cfg#= 1 Atr=80 MxPwr=200mA
    I:* If#= 0 Alt= 0 #EPs= 0 Cls=ff(vend.) Sub=02 Prot=02 Driver=snd-usb-audio
    I:  If#= 0 Alt= 1 #EPs= 1 Cls=ff(vend.) Sub=02 Prot=02 Driver=snd-usb-audio
    E:  Ad=01(O) Atr=09(Isoc) MxPS= 320 Ivl=1ms
    I:* If#= 1 Alt= 0 #EPs= 0 Cls=ff(vend.) Sub=02 Prot=01 Driver=snd-usb-audio
    I:  If#= 1 Alt= 1 #EPs= 1 Cls=ff(vend.) Sub=02 Prot=01 Driver=snd-usb-audio
    E:  Ad=82(I) Atr=05(Isoc) MxPS= 320 Ivl=1ms

Obviously, at 96 kHz the interfaces list is quite different. But
everything is detected fine, just like the UA-25.

\

### Getting Advanced mode to work (alternative way)

As I don't understand how to patch a kernel because I am more musician
than a Unix programmer, I found another way to get the advanced mode to
work. You can use the alternative driver from Michael Minn MMUSBAUDIO
([http://michaelminn.com/linux/mmusbaudio/](http://michaelminn.com/linux/mmusbaudio/))
which is dedicated to Roland and Edirol products. As I believed that the
Cakewalk UA-1G was very close to the Edirol UA-1EX for the hardware, I
guessed that modifying the source code a little bit could do the trick.
It worked. So you have to modify the source to add support for the
UA-1G. Nothing impossible, don't worry.

UPDATE : The driver from Michael Minn has been updated and integrated
the following fix. You shouldn't have to modify anything now. Just
compile the driver with "make" and install it with "make install".

\
 Prerequisites : You have to know the manufacturer ID and device ID of
your sound card. It can be a little different from mine. Mine is like
that : ` `

    Manufacturer : 0x0582    DeviceID : 0x00EA (for basic mode)
    Manufacturer : 0x0582    DeviceID : 0x00E9 (for advanced driver mode)

You can find those values by doing unplugging the soundcard, plugging it
again in basic mode and type the following in the console : ` `

    $cat /proc/bus/usb/devices

Then you can find those values for the device whose manufacturer is
Roland. Note the manufacturer id and device id. - Do the same thing but
in advanced driver mode.

Once you have the manufacturer and device ID, you can continue :

​1) Download and extract the driver to a directory.

​2) Modify the following files :

\
 mmusbaudio.c :

\
 Near line 2035 :

` `

    else if ((device->descriptor.idVendor == 0x582) && (interface == 1) &&
     (device->descriptor.idProduct == 0xEA))
     driver_data = mmusbaudio_assign_audio_device(device, "UA-1G (Basic Mode)");

    else if ((device->descriptor.idVendor == 0x582) && (interface == 1) &&
     (device->descriptor.idProduct == 0xE9))
     driver_data = mmusbaudio_assign_audio_device(device, "UA-1G (Advanced Mode)");

\
 Near line 2120 :

` `

    static struct usb_device_id mmusbaudio_ids [] =
    {
     { USB_DEVICE_VER(0x0582, 0x0000, 0x0, 0xffff) }, /* UA-100 */
     { USB_DEVICE_VER(0x0582, 0x0003, 0x0, 0xffff) }, /* SC-8850 */
     { USB_DEVICE_VER(0x0582, 0x0009, 0x0, 0xffff) }, /* UM-1 */
     { USB_DEVICE_VER(0x0582, 0x0010, 0x0, 0xffff) }, /* UA-5 (Advanced Mode) */
     { USB_DEVICE_VER(0x0582, 0x0011, 0x0, 0xffff) }, /* UA-5 (Basic Mode) */
     { USB_DEVICE_VER(0x0582, 0x0096, 0x0, 0xffff) }, /* UA-1EX */
     { USB_DEVICE_VER(0x0582, 0x00EA, 0x0, 0xffff) }, /* UA-1G basic */
     { USB_DEVICE_VER(0x0582, 0x00E9, 0x0, 0xffff) }, /* UA-1G advanced */
     { USB_DEVICE_VER(0x1210, 0x0011, 0x0, 0xffff) }, /* DigiTech GSP 1101 */
     { } /* Terminating entry */
    };

\
 mmusbaudio.mod.c (you maybe need to be root to modify that one) : After
those lines :

` `

    MODULE_ALIAS("usb:v0582p0000d*dc*dsc*dp*ic*isc*ip*");
    MODULE_ALIAS("usb:v0582p0003d*dc*dsc*dp*ic*isc*ip*");
    MODULE_ALIAS("usb:v0582p0009d*dc*dsc*dp*ic*isc*ip*");
    MODULE_ALIAS("usb:v0582p0010d*dc*dsc*dp*ic*isc*ip*");
    MODULE_ALIAS("usb:v0582p0011d*dc*dsc*dp*ic*isc*ip*");
    MODULE_ALIAS("usb:v0582p0096d*dc*dsc*dp*ic*isc*ip*");
    MODULE_ALIAS("usb:v1210p0011d*dc*dsc*dp*ic*isc*ip*");

Add the following two lines :

` `

    MODULE_ALIAS("usb:v0582p00EAd*dc*dsc*dp*ic*isc*ip*"); /*UA-1G (basic mode)*/
    MODULE_ALIAS("usb:v0582p00E9d*dc*dsc*dp*ic*isc*ip*"); /*UA-1G (advanced driver mode)*/

​3) Compile and install :

` `

    cd /home/gabriel/mmusbaudio/ (that's where I extracted the driver, will be different for you of course)
    make
    make install
    make load

​4) Under Debian 5.01 I had to modify the following file to load the
driver at each startup : /etc/modprobe.d/sound (can be /etc/modules.conf
or /etc/modprobe.conf on other distributions, please replace with
appropriate file...)

` `

    gedit /etc/modprobe.d/sound

I commented everything and added two lines. Example : I had a HDA chip
on my laptop. I commented it. You can comment everything and add the two
last lines.

` `

    #alias snd-card-0 snd-hda-intel
    #options snd-hda-intel index=0
    alias sound-slot-0 mmusbaudio
    alias sound-service-0-0 off

​5) Restart your computer (really, don't try to cheat)

​6) Now choose OSS as your audio interface. It should work in advanced
mode !

ToDo
----

-   Latency tests with jack
-   Test SN/R from live signal or recorded wav files with [sonic
    visualizer](http://www.sonicvisualiser.org/)
-   (Let) Implement software mixer (if softvol problems cannot be
    resolved)

See also
--------

-   vendor link:
    [http://www.roland.com/products/en/UA-1G/index.html](http://www.roland.com/products/en/UA-1G/index.html)

Retrieved from
"[http://alsa.opensrc.org/Cakewalk\_UA-1G](http://alsa.opensrc.org/Cakewalk_UA-1G)"

[Category](/Special:Categories "Special:Categories"): [Sound
cards](/Category:Sound_cards "Category:Sound cards")

