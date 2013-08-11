# Edirol UA-25EX

![UA-25EX](http://www.roland.com/products/en/UA-25EX/images/top_L.jpg "Edirol UA-25EX")

**Vendor Link:** [http://www.roland.com/products/en/UA-25EX/](http://www.roland.com/products/en/UA-25EX/)

The Edirol UA-25EX is a good quality audio device, with great features:

- Variety of Input & Output options
- Balanced Input & Output
- Two Professional Grade Mic Preamps
- Built-in Analog Compresser & Limiter
- Zero-Latency, Direct Monitoring
- USB Bus-Powered
- Phantom microphone power (48 volts)
- Full-duplex management
- MIDI I/O

The Edirol UA-25EX is similar in every point to the [Edirol
UA-25](/Edirol_UA-25 "Edirol UA-25") with the addition of an analog
compressor. This device has 2 modes:

- Standards-compliant: the device is recognised by the `snd_usb_audio`
  module and you can play and record at 44.1kHz and 16-bit samples. MIDI is
  not supported in this mode.
- Advanced mode: full support for 24-bit playback, recording at rates up to
  96 kHz, and MIDI.

The computer has little control over various settings like Input level, Output
level, mixing and even sample rate. This is a hardware issue, and will apply
equally to this card on all OS'es. Some users may like this old-fashion way to
manage sound cards, other may dislike it. To mitigate this limitation, Alsa
offers a variety of features and [plugins](/ALSA_plugins "ALSA plugins") which
emulate at software level the missing features. This is the advantage of Alsa
over other sound systems.


## Contents

- [1 Understanding the Edirol UA-25EX logic](#a1.0)
  - [1.1 Advance button](#a1.1)
  - [1.2 Sample rates switch](#a1.2)
  - [1.3 REC/PLAY button](#a1.3)
  - [1.4 Cold/Hot reboot](#a1.4)
  - [1.5 Lost?](#a1.5)
- [2 Basic Alsa configuration](#a2.0)
  - [2.1 Assigning audio system rights](#a2.1)
  - [2.2 Naming the Edirol UA-25EX device](#a2.2)
  - [2.3 Testing sound output](#a2.3)
  - [2.4 Playing sound](#a2.4)
  - [2.5 Recording sound](#a2.5)
- [3 Advanced Alsa configuration](#a3.0)
  - [3.1 Full-duplex mode](#a3.1)
  - [3.2 Custom softvol PCM](#a3.2)
  - [3.3 Recording left and right input channels seperately](#a3.3)
  - [3.4 Digital signals](#a3.4)
    - [3.4.1 Digital In](#a3.4.1)
    - [3.4.2 Digital Out](#a3.4.2)
- [4 MIDI configuration](#a4.0)
  - [4.1 MIDI ports](#a4.1)
  - [4.2 Connecting an external MIDI controller](#a4.2)
  - [4.3 Connecting an external MIDI synthesizer](#a4.3)
- [5 Resulting .asoundrc file](#a5.0)
- [6 Device information](#a6.0)
  - [6.1 cat/proc/bus/usb/devices](#a6.1)
  - [6.2 cat /proc/asound/devices](#a6.2)
  - [6.3 cat /proc/asound/cards](#a6.3)
  - [6.4 aplay -l](#a6.4)
  - [6.4 aplay -L](#a6.5)


## Understanding the Edirol UA-25EX logic <a name="a1.0"></a>

At first, you should have a look at the back pane. Or look at the photo
of the device. Try to locate three important buttons:


### Advance button <a name="a1.1"></a>

On the back pane of the UA-25EX, there is a switch button called
"ADVANCE", which controls the USB mode of the device. The switch has two
values: ON and OFF:

- In **advance mode** (ADVANCE button ON), the UA-25EX can record or play
  sound in native 24 bits, in either 44.100 Hz, 48.000 Hz or 96.000 Hz
  sample rates. You can choose sample rates using a button. At 96 Khz, the
  device is either capture or playback only. MIDI is enabled. Advance mode
  is recognised since Alsa 1.0.7.
- In **normal mode** (ADVANCE button OFF), the UA-25EX is fully USB sound
  compliant. It records at the rate of 44.100 Hz, in 16 bits, and is full-
  duplex. MIDI is disabled.


### Sample rates switch <a name="a1.2"></a>

On the back pane of the UA-25EX, there is a switch button called "SAMPLE
RATE". The switch has three values: 44.1 Khz, 48 Khz and 96 Khz:

- In Advance mode OFF, the device will always record/play natively at the
  rate of 44.1 Khz using 16 bits.
- In Advance mode ON, the device will be able to record using 24 bits.
  Choose the sample rate using the SAMPLE RATE switch:
  - 44.1 Khz: play and record at the same time,
  - 48 Khz: play and record at the same time,
  - 96 Khz: play OR record. Press the REC/PLAY button to choose.


### REC/PLAY button <a name="a1.3"></a>

When in Advance mode ON, at 96 Khz, you can either play OR record. Press
the REC/PLAY button to choose.


### Cold/Hot reboot <a name="a1.4"></a>

Whenever you switch from ADVANCE ON to ADVANCE OFF, or change sample rates,
you will either need to:

- cold reboot: Unplug the USB cord, plug it again. The hotplug mechanism
  will remove all snd modules and will reload them. Be warned: frequent
  plug/unplug may harm the device physical contacts.
- shutdown/reboot your computer: it is the recommended way, as it will not
  harm your device (or the USB cord). Your computer might not turn off the
  USB power unless you shut down completely. A good place to switch the
  Advance button is during the grub menu, if you are using grub, and if that
  fails, shut the computer off completely to switch the Advance button.


### Lost? <a name="a1.5"></a>

To understand advance mode, sample rates and REC/PLAY, it is recommended to
use `aplay` and `arecord` in verbose (option `-v`) mode. This is what we will
do during the howto. This will clearly show you how the audio devices plays
and records sound.


## Basic Alsa configuration <a name="a2.0"></a>

`alsaconf` is not required to use the Edirol UA-25EX. Hotplug is able to
recognise the audio device. Just plug and play.


### Assigning audio system rights <a name="a2.1"></a>

To play sound, you need audio system rights. To query your systems rights:

    $ groups
    my_username adm disk dialout fax cdrom floppy tape dip video plugdev powerdev scanner

In this example, I don't have enough rights to play/record sound. To assign
rights: Become root (system administrator):

    $ su
    Password:

Enter the administrator password and then:

    # adduser my_username audio

Will add the user **my\_username** (replace with your username) to the audio
group. After logging out and back in again, you should be able to play music.


### Naming the Edirol UA-25EX device <a name="a2.2"></a>

If the UA-25EX is the only device of your computer, you can address the device
using the `plughw:0,0`, but it is not very convenient. We recommend using the
alphanumeric name of the device. To query the name of your device, type:

    $ cat /proc/asound/cards
     0 [UA25EX         ]: USB-Audio - EDIROL UA-25EX
                         Roland EDIROL UA-25 at usb-0000:00:0b.0-2, full speed
     1 [Audio          ]: USB-Audio - USB Audio
                         USB Audio at usb-0000:00:0b.1-4.4.3, full speed

Here, you should use `plughw:UA25EX` rather than `plughw:0,0`


### Testing sound output <a name="a2.3"></a>

Test the card output. This command plays a womans voice on 2 channels ("Front
Right", "Front Left"):

    speaker-test -c2 -D plughw:UA25EX -twav


### Playing sound <a name="a2.4"></a>

In the following example, Advance button is set to ON, and sample rate is 48
Khz. Do not forget to cold/hot reboot whenever you change settings. To play a
sound:

    $ aplay -D plughw:UA25EX foo.wav

For a better understanding, it is recommended to play in verbose mode:

    $ aplay -v -D plughw:UA25EX foo.wav

The following message is displayed:

    Playing raw data 'foo.wav' : Unsigned 8 bit, Rate 8000 Hz, Mono

Plug PCM: Rate conversion PCM (48000, sformat=U8) Its setup is:

     stream       : PLAYBACK
     access       : RW_INTERLEAVED
     format       : U8
     subformat    : STD
     channels     : 1
     rate         : 8000
     exact rate   : 8000 (8000/1)
     msbits       : 8
     buffer_size  : 4000
     period_size  : 1000
     period_time  : 125000
     tick_time    : 0
     tstamp_mode  : NONE
     period_step  : 1
     sleep_min    : 0
     avail_min    : 1000
     xfer_align   : 1000
     start_threshold  : 4000
     stop_threshold   : 4000
     silence_threshold: 0
     silence_size : 0
     boundary     : 262144000

Slave: Route conversion PCM (sformat=S24\_3LE)

    Transformation table:
       0 <- 0
       1 <- 0

Its setup is:

     stream       : PLAYBACK
     access       : MMAP_INTERLEAVED
     format       : U8
     subformat    : STD
     channels     : 1
     rate         : 48000
     exact rate   : 48000 (48000/1)
     msbits       : 8
     buffer_size  : 24006
     period_size  : 6000
     period_time  : 125000
     tick_time    : 0
     tstamp_mode  : NONE
     period_step  : 1
     sleep_min    : 0
     avail_min    : 6000
     xfer_align   : 6000
     start_threshold  : 24000
     stop_threshold   : 24006
     silence_threshold: 0
     silence_size : 0
     boundary     : 1573257216

Slave: Hardware PCM card 1 'UA-25EX' device 0 subdevice 0 Its setup is:

     stream       : PLAYBACK
     access       : MMAP_INTERLEAVED
     format       : S24_3LE
     subformat    : STD
     channels     : 2
     rate         : 48000
     exact rate   : 48000 (48000/1)
     msbits       : 24
     buffer_size  : 24006
     period_size  : 6000
     period_time  : 125000
     tick_time    : 0
     tstamp_mode  : NONE
     period_step  : 1
     sleep_min    : 0
     avail_min    : 6000
     xfer_align   : 6000
     start_threshold  : 24000
     stop_threshold   : 24006
     silence_threshold: 0
     silence_size : 0
     boundary     : 1573257216

The sound file is 8.000 Hz sample rate over 8 bits. Alsa converts it to 48.000
Hz over 24 bits... and plays the sound. When playing two sounds at the same
time, an error message is displayed:

    $ aplay: main:550: audio open error: Device or resource busy

Remember, in advance mode, the UA-25EX is only half-duplex.


### Recording sound <a name="a2.4"></a>

In this example, the UA-25EX device is set to Advance ON and 96 Khz recording.
REC button is pressed. You can use arecord utility, which is part of Alsa
package, to record any sound from the microphone:

    $ arecord -r 96000 -f cd -t wav -D plughw:UA25EX foobar.wav

For a better understanding, try the same command in verbose mode:

    $ arecord -v -r 96000 -f cd -t wav -D plughw:UA25EX foobar.wav

The resulting message:

    Recording WAVE 'foobar.wav' : Signed 16 bit Little Endian, Rate 44100 Hz, \
    Stereo Plug PCM: Rate conversion PCM (96000, sformat=S24_3LE)

Its setup is:

    stream            : CAPTURE
    access            : RW_INTERLEAVED
    format            : S16_LE
    subformat         : STD
    channels          : 2
    rate              : 44100
    exact rate        : 44100 (44100/1)
    msbits            : 16
    buffer_size       : 22050
    period_size       : 5512
    period_time       : 125000
    tick_time         : 0
    tstamp_mode       : NONE
    period_step       : 1
    sleep_min         : 0
    avail_min         : 5512
    xfer_align        : 5512
    start_threshold   : 1
    stop_threshold    : 22050
    silence_threshold : 0
    silence_size      : 0
    boundary          : 722534400

    Slave: Hardware PCM card 1 'UA-25EX' device 0 subdevice 0

Its setup is:

    stream            : CAPTURE
    access            : MMAP_INTERLEAVED
    format            : S24_3LE
    subformat         : STD
    channels          : 2
    rate              : 96000
    exact rate        : 96000 (96000/1)
    msbits            : 24
    buffer_size       : 48002
    period_size       : 12000
    period_time       : 125000
    tick_time         : 0
    tstamp_mode       : NONE
    period_step       : 1
    sleep_min         : 0
    avail_min         : 12000
    xfer_align        : 12000
    start_threshold   : 2
    stop_threshold    : 48002
    silence_threshold : 0
    silence_size      : 0
    boundary          : 1572929536

The Edirol UA-25EX is able to record in 24 bits, at the sample rate of 96 Khz.
Now, try to play the recorded sound at 96 Khz:

    $ aplay -v -D plughw:UA25EX foobar.wav
    $ aplay: main:550: audio open error: No such file or directory

At 96.000 Hz, the audio device can play OR record, but not both. Now, switch
the PLAY button. Unplug the USB cord and plug it again. This should initialize
Alsa if you are using Udev and hotplug. Re-try to play the sound:

    $ aplay -v -D plughw:UA25EX foobar.wav

This results in:

    Playing WAVE 'foobar.wav' : Signed 16 bit Little Endian, Rate 44100 Hz, Stereo
    Plug PCM: Rate conversion PCM (96000, sformat=S24\_3LE)

Its setup is:

    stream            : PLAYBACK
    access            : RW_INTERLEAVED
    format            : S16_LE
    subformat         : STD
    channels          : 2
    rate              : 44100
    exact rate        : 44100 (44100/1)
    msbits            : 16
    buffer_size       : 22050
    period_size       : 5512
    period_time       : 125000
    tick_time         : 0
    tstamp_mode       : NONE
    period_step       : 1
    sleep_min         : 0
    avail_min         : 5512
    xfer_align        : 5512
    start_threshold   : 22048
    stop_threshold    : 22050
    silence_threshold : 0
    silence_size      : 0
    boundary          : 722534400

And:

    Slave: Hardware PCM card 1 'UA-25EX' device 0 subdevice 0

Where its setup is:

    stream            : PLAYBACK
    access            : MMAP_INTERLEAVED
    format            : S24_3LE
    subformat         : STD
    channels          : 2
    rate              : 96000
    exact rate        : 96000 (96000/1)
    msbits            : 24
    buffer_size       : 48002
    period_size       : 12000
    period_time       : 125000
    tick_time         : 0
    tstamp_mode       : NONE
    period_step       : 1
    sleep_min         : 0
    avail_min         : 12000
    xfer_align        : 12000
    start_threshold   : 48000
    stop_threshold    : 48002
    silence_threshold : 0
    silence_size      : 0
    boundary          : 1572929536

It works! Remember, at 96.000 Khz, you can either play OR record, but
not both.


## Advanced Alsa configuration <a name="a3.0"></a>

The recommended settings in this HOWTO are now:

- Advance mode : ON
- Sample rate : 44,1 Khz

This will record/play sound in 24 bits, at the frequency of 44.100 Hz.


### Full-duplex mode <a name="a3.1"></a>

As mentioned above, the Edirol UA-25EX supports full-duplex operation, except
at 96 Khz.If you want to play and record in **full-duplex** though *half-
duplex* plugins, check out the [asym](/Asym "Asym") [plugin](/ALSA_plugins
"ALSA plugins"), which is able to combine the [dmix](/Dmix "Dmix") (i.e. play)
and [dsnoop](/Dsnoop "Dsnoop") (i.e. record) plug-ins.


### Custom softvol PCM <a name="a3.2"></a>

Using mixer settings on `card 0` will return:

    $ alsamixer -c 0
    no mixer elems found

Unfortunately these is no software control over the hardware mixers on the
device (like in any USB device), nothing will show up in mixer programs.
Fortunately, Alsa offers the [softvol](/Softvol "Softvol")
[plugin](/ALSA_plugins "ALSA plugins") to create a software volume control. We
will also define this control as the default mixer. Here is my first try:

    pcm.!default {
        type plug
        slave.pcm "softvol"
    }
    pcm.softvol {
        type softvol
        slave {
            pcm "pasymed"
        }
        control {
            name "SoftMaster"
            card 0
        }
    }

Let us have a look at our software mixer:

    $ amixer
    Simple mixer control 'SoftMaster',0
    Capabilities: volume
    Playback channels: Front Left - Front Right
    Capture channels: Front Left - Front Right
    Limits: 0 - 255
    Front Left: 255 [100%]
    Front Right: 255 [100%]


### Recording left and right input channels seperately <a name="a3.3"></a>

When recording from two mono inputs (Input 1/L and Input 2/R), the sound is
mixed into a stereo stream at hardware level. Again, there is no software
control over this audio device. This is a problem when you only record from
one mono microphone. The resulting stereo sound includes a muted channel with
noise. At software level, you may downmix this sound to mono, but this
degrades quality because of the muted channel with noise. A simple solution is
to [record from left and right input channels
seperately](/Dsnoop#Recording_from_left_or_right_channel "Dsnoop"), as
explained in the [dsnoop](/Dsnoop "Dsnoop") howto.

    pcm.record_left {
        type dsnoop
        ipc_key 234884
        slave {
            pcm "plughw:UA25EX"
            channels 2
        }
        bindings.0 0
    }
    pcm.record_right {
        type dsnoop
        ipc_key 2241234
        slave {
            pcm "plughw:UA25EX"
            channels 2
        }
        bindings.0 1
    }


### Digital signals <a name="a3.4"></a>

The same rules apply here. Alsa has very little control over the UA-25EX
hardware. Digital control is done using buttons on the front pane.


#### Digital In <a name="a3.4.1"></a>

To record from digital source, press the "DIGITAL IN" button on the front pane
of the UA-25EX. This is simple as that! You can then record using any Alsa
tool, on the pasymed or SoftMaster PCMs.

#### Digital Out <a name="a3.4.2"></a>

Here, the Edirol UA-25EX is in Advance mode off. It provides 16 bits, 44.100
Hz digital output.

Let us try Alsa utility [speaker-test](/Speaker-test "Speaker-test"):

    $ speaker-test -c 2 -D softvol0 -twav

An optical cable is connected:

- from Edirol UA-25EX Digital out
- to a Terratec USB Aureon MK-2 digital in.

In the mixer of the Terratec Aureon, I select `Input 2` and check `IEC958 In`.
I can record the digital stream using the following command:

    $ arecord -v -f S16_LE -c 2 -D plughw:1,0 foobar.wav

I can record the digital out stream of the Edirol UA-25EX without problem.


## MIDI configuration <a name="a4.0"></a>

For MIDI to work, the device has to be in [advance mode](/Edirol_UA-25EX#a1.1
"Edirol UA-25EX"). If MIDI is working, you should see a "raw midi" device for
the UA-25EX in /proc/asound/devices:

    $ grep midi /proc/asound/devices
      8: [ 0- 0]: raw midi

Also, /proc/asound/card0/midi0 should exist (assuming the UA-25EX is the 0th
audio device):

    $ cat /proc/asound/card0/midi0
    UA-25EX

    Output 0
      Tx bytes     : 0
    Input 0
      Rx bytes     : 0


### MIDI ports <a name="a4.1"></a>

If the UA-25EX is running in advance mode, `aconnect` should show one MIDI
input and one MIDI output port:

    $ aconnect -il                    # list readable MIDI ports
    client 16: 'UA-25EX' [type=kernel]
        0 'UA-25EX MIDI 1    '

    $ aconnect -ol                    # list writable MIDI ports
    client 16: 'UA-25EX' [type=kernel]
        0 'UA-25EX MIDI 1    '

If you prefer a graphical interface, check out `aconnectgui`. The relevant
information can also be found in /proc/asound/seq/clients.


### Connecting an external MIDI controller <a name="a4.2"></a>

To connect an external MIDI controller (e.g. keyboard, faderbox, stompbox,
etc.), just plug its MIDI output into the "MIDI IN" socket on the back of the
UA-25EX, and use `aconnect` to connect it to whatever software synth you want
to interpret the MIDI data. To connect my MIDI foot controller to PureData,
`aconnect` shows me the following (among other things):

    $ aconnect -il
    client 16: 'UA-25EX' [type=kernel]
        0 'UA-25EX MIDI 1    '

    $ aconnect -ol
    client 128: 'Pure Data' [type=user]
        0 'Pure Data Midi-In 1'

To get MIDI data flowing from my foot controller into PureData, the
incantation I need is:

    $ aconnect 16:0 128:0


### Connecting an external MIDI synthesizer <a name="a4.3"></a>

I don't have one, but the process ought to be entirely analogous to that
described in the preceding section. Feel free to contribute your own
experiences.


## Resulting .asoundrc file <a name="a5.0"></a>

For clarity, here is the resulting .asoundrc file:

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
    #This PCM combining the dmix and dsnoop slaves
    pcm.asymed {
         type asym
         playback.pcm "dmix"
         capture.pcm "dsnoop"
    }
    #This PCM should be able to convert recording rates automatically
    pcm.pasymed {
         type plug
         slave.pcm "asymed"
    }
    pcm.record_left {
      type        dsnoop
      ipc_key 234884
      slave {
          pcm     "plughw:UA25EX"
          channels 2
      }
      bindings.0  0
    }
    pcm.record_right {
      type        dsnoop
      ipc_key 2241234
      slave {
          pcm     "plughw:UA25EX"
          channels 2
      }
      bindings.0  1
    }


## Device information <a name="a6.0"></a>

The following section may help Alsa hackers (please ignore the references to
my second soundcard HDA Intel):


### cat/proc/bus/usb/devices <a name="a6.1"></a>

    $ cat/proc/bus/usb/devices
     T:  Bus=02 Lev=01 Prnt=01 Port=01 Cnt=01 Dev#=  5 Spd=12  MxCh= 0
     D:  Ver= 1.10 Cls=ff(vend.) Sub=00 Prot=ff MxPS= 8 #Cfgs=  1
     P:  Vendor=0582 ProdID=00e6 Rev= 1.00
     S:  Manufacturer=Roland
     S:  Product=EDIROL UA-25EX
     C:* #Ifs= 3 Cfg#= 1 Atr=80 MxPwr=480mA
     I:* If#= 0 Alt= 0 #EPs= 0 Cls=ff(vend.) Sub=02 Prot=00 Driver=snd-usb-audio
     I:  If#= 0 Alt= 1 #EPs= 1 Cls=ff(vend.) Sub=02 Prot=00 Driver=snd-usb-audio
     E:  Ad=01(O) Atr=09(Isoc) MxPS= 320 Ivl=1ms
     I:* If#= 1 Alt= 0 #EPs= 0 Cls=ff(vend.) Sub=02 Prot=00 Driver=snd-usb-audio
     I:  If#= 1 Alt= 1 #EPs= 1 Cls=ff(vend.) Sub=02 Prot=00 Driver=snd-usb-audio
     E:  Ad=82(I) Atr=05(Isoc) MxPS= 320 Ivl=1ms
     I:  If#= 2 Alt= 0 #EPs= 2 Cls=ff(vend.) Sub=03 Prot=00 Driver=snd-usb-audio
     E:  Ad=03(O) Atr=02(Bulk) MxPS=  32 Ivl=0ms
     E:  Ad=84(I) Atr=02(Bulk) MxPS=  32 Ivl=0ms
     I:* If#= 2 Alt= 1 #EPs= 2 Cls=ff(vend.) Sub=03 Prot=00 Driver=snd-usb-audio
     E:  Ad=03(O) Atr=02(Bulk) MxPS=  32 Ivl=0ms
     E:  Ad=84(I) Atr=03(Int.) MxPS=  32 Ivl=1ms


### cat /proc/asound/devices <a name="a6.2"></a>

    $ cat /proc/asound/devices
     0: [ 0]   : control
     1:        : sequencer
    16: [ 0- 0]: digital audio playback
    17: [ 0- 1]: digital audio playback
    24: [ 0- 0]: digital audio capture
    32: [ 1]   : control
    33:        : timer
    40: [ 1- 0]: raw midi
    48: [ 1- 0]: digital audio playback
    56: [ 1- 0]: digital audio capture


### cat /proc/asound/cards <a name="a6.3"></a>

    $ cat /proc/asound/cards
    0 [Intel          ]: HDA-Intel - HDA Intel
                         HDA Intel at 0xd8240000 irq 22
    1 [UA25EX         ]: USB-Audio - UA-25EX
                         EDIROL UA-25EX at usb-0000:00:1d.0-2, full speed


### aplay -l <a name="a6.4"></a>

    $ aplay -l

    **** List of PLAYBACK Hardware Devices ****
    card 0: Intel [HDA Intel], device 0: CONEXANT Analog [CONEXANT Analog]
      Subdevices: 1/1
      Subdevice #0: subdevice #0
    card 0: Intel [HDA Intel], device 1: Conexant Digital [Conexant Digital]
      Subdevices: 1/1
      Subdevice #0: subdevice #0
    card 1: UA25EX [UA-25EX], device 0: USB Audio [USB Audio]
      Subdevices: 1/1
      Subdevice #0: subdevice #0


### aplay -L <a name="a6.5"></a>

    $ aplay -L

    default:CARD=Intel
      HDA Intel, CONEXANT Analog
      Default Audio Device
    front:CARD=Intel,DEV=0
      HDA Intel, CONEXANT Analog
      Front speakers
    surround40:CARD=Intel,DEV=0
      HDA Intel, CONEXANT Analog
      4.0 Surround output to Front and Rear speakers
    surround41:CARD=Intel,DEV=0
      HDA Intel, CONEXANT Analog
      4.1 Surround output to Front, Rear and Subwoofer speakers
    surround50:CARD=Intel,DEV=0
      HDA Intel, CONEXANT Analog
      5.0 Surround output to Front, Center and Rear speakers
    surround51:CARD=Intel,DEV=0
      HDA Intel, CONEXANT Analog
      5.1 Surround output to Front, Center, Rear and Subwoofer speakers
    surround71:CARD=Intel,DEV=0
      HDA Intel, CONEXANT Analog
      7.1 Surround output to Front, Center, Side, Rear and Woofer speakers
    null
      Discard all samples (playback) or generate zero samples (capture)
    default:CARD=UA25EX
      UA-25EX, USB Audio
      Default Audio Device
    front:CARD=UA25EX,DEV=0
      UA-25EX, USB Audio
      Front speakers
    surround40:CARD=UA25EX,DEV=0
      UA-25EX, USB Audio
      4.0 Surround output to Front and Rear speakers
    surround41:CARD=UA25EX,DEV=0
      UA-25EX, USB Audio
      4.1 Surround output to Front, Rear and Subwoofer speakers
    surround50:CARD=UA25EX,DEV=0
      UA-25EX, USB Audio
      5.0 Surround output to Front, Center and Rear speakers
    surround51:CARD=UA25EX,DEV=0
      UA-25EX, USB Audio
      5.1 Surround output to Front, Center, Rear and Subwoofer speakers
    surround71:CARD=UA25EX,DEV=0
      UA-25EX, USB Audio
      7.1 Surround output to Front, Center, Side, Rear and Woofer speakers
    iec958:CARD=UA25EX,DEV=0
      UA-25EX, USB Audio
      IEC958 (S/PDIF) Digital Audio Output

