Cmipci
======

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

This article describes **how to use C-Media CMI series PCI cards with
ALSA**

TakashiIwai is the maintainer of the code for this card.

Contents
--------

-   [1 Notes](#Notes)
-   [2 Front/Rear Multi-channel
    Playback](#Front.2FRear_Multi-channel_Playback)
-   [3 4/6 Multi-Channel Playback](#4.2F6_Multi-Channel_Playback)
-   [4 Volume Control](#Volume_Control)
-   [5 Digital I/O](#Digital_I.2FO)
-   [6 The AC3 (RAW DIGITAL) Output](#The_AC3_.28RAW_DIGITAL.29_Output)
-   [7 Analog Mixer Interface](#Analog_Mixer_Interface)
-   [8 MIDI Controller](#MIDI_Controller)
-   [9 FM OPL/3 Synth](#FM_OPL.2F3_Synth)
-   [10 Joystick and Modem](#Joystick_and_Modem)
-   [11 Debugging Information](#Debugging_Information)
-   [12 Quick Install](#Quick_Install)
-   [13 Setting up modprobe and kmod
    support](#Setting_up_modprobe_and_kmod_support)
-   [14 Options for the snd-cmipci
    module](#Options_for_the_snd-cmipci_module)
-   [15 See also](#See_also)

Notes
-----

There has at March 07 been a thread running on the Ubuntu forums for 2 +
years reporting that microphone sound levels are so low with the cmi8738
chip and the cmipci driver as to be unusable. I've just experienced this
with both a motherboard sound chip and a PCI card with a cmi8738 chip.
Is there any chance of this issue ever being resolved? - Chris Dunn

This card performs well as a playback device but has poor recording
ability. The driver supports spdif I/O for cards that have it available.
- [Patrick
Shirkey](?title=User:PatrickShirkey&action=edit&redlink=1 "User:PatrickShirkey (page does not exist)")

Actually I have no problems recording, even at small buffer sizes (spdif
on dio2448, no soft-monitoring). - Tim Orford

I agree with Patrick - The card produces a loud hissing sound when
capturing from Line-In. Haven't tried capturing SPDIF. - Michael Stevens

I got loud hissing when I tried to record from the microphone, but got
good quality sound when I recorded from the line-in and put the
microphone through a preamp. - John Kawakami

Front/Rear Multi-channel Playback
---------------------------------

CM8x38 chip can use ADC as the second DAC so that two different stereo
channels can be used for front/rear playbacks. Since there are two DACs,
both streams are handled independently unlike the 4/6ch multi-channel
playbacks in the section below.

As default, ALSA driver assigns the first PCM device (i.e. `hw:0,0` for
card\#0) for front and 4/6ch playbacks, while the second PCM device
(`hw:0,1`) is assigned to the second DAC for rear playback.

There are slight differences between the two DACs.

-   The first DAC supports U8 and S16LE formats, while the second DAC
    supports only S16LE.
-   The second DAC supports only two channel stereo.

Please note that the CM8x38 DAC doesn't support arbitrary playback rates
but only certain fixed rates: 5512, 8000, 11025, 16000, 22050, 32000,
44100 and 48000Hz.

The rear output can be heard only when "Four Channel Mode" switch is
disabled. Otherwise no signal will be routed to the rear speakers. As
default it's turned on.

**WARNING**

When "Four Channel Mode" switch is off, the output from rear speakers
will be FULL VOLUME regardless of Master and PCM volumes. This might
damage your audio equipment. Please disconnect speakers before your turn
off this switch.

**WARNING**

` `

    [ Well.. I once got the output with correct volume (i.e. same with the
      front one) and was so excited.  It was even with "Four Channel" bit
      on and "double DAC" mode.  Actually I could hear separate 4 channels
      from front and rear speakers!  But.. after reboot, all was gone.
      It's a very pity that I didn't save the register dump at that
      time..  Maybe there is an unknown register to achieve this... ]

If your card has an extra output jack for the rear output, the rear
playback should be routed there as default. If not, there is a control
switch in the driver "Line-In As Rear", which you can change via
alsamixer or somewhat else. When this switch is on, line-in jack is used
as rear output.

There are two more controls regarding to the rear output. The "Exchange
DAC" switch is used to exchange front and rear playback routes, i.e. the
2nd DAC is output from front output.

4/6 Multi-Channel Playback
--------------------------

The recent CM8738 chips support for the 4/6 multi-channel playback
function. This is useful especially for AC3 decoding.

When the multi-channel is supported, the driver name has a suffix "-MC"
such like "CMI8738-MC6". You can check this name from
`/proc/asound/cards`.

When the 4/6-ch output is enabled, the front DAC accepts up to 6 (or 4)
channels. This is different from the dual DACs described in the previous
section. While the dual DAC supports two different rates or formats, the
4/6-ch playback supports only the same condition for all channels.

For using 4/6 channel playback, you need to specify the PCM channels as
you like and set the format S16LE. For example, for playback with 4
channels,

` `

    snd_pcm_hw_params_set_access(pcm, hw, SND_PCM_ACCESS_RW_INTERLEAVED);
    // or mmap if you like
    snd_pcm_hw_params_set_format(pcm, hw, SND_PCM_FORMAT_S16_LE);
    snd_pcm_hw_params_set_channels(pcm, hw, 4);

    and use the interleaved 4 channel data.

There is a control switch, "Line-In As Bass". As you can imagine from
its name, the line-in jack is used for the bass (5th and 6th channels)
output.

Volume Control
--------------

I found one solution to adjust the volume for all channels when using
routing to map stereo to 5.1 as the dmix setup does not work with latest
1.0.11rc3 alsa release. On my CMI8738-MC6 the Master Volume only affects
the front channel. Since the other channels are on "hw:0,1" and I found
no way to adjust the levels on this, one can use "softvol" to do a
virtual volume adjustment.

Drawback: Master Volume still does not affect all channels, but the
custom "SoftMaster" item can be used to set the volume for all channels.

Here is my [.asoundrc](/.asoundrc ".asoundrc"):

` `

    pcm.softvol {
        type softvol
        slave {
            pcm "hw:0,1"
        }
        control {
            name "SoftMaster"
        }
    }

    pcm.dsp0 {
        type plug
        slave.pcm "softvol"
        slave.channels 6
        route_policy duplicate
    }

    pcm.!default {
        type plug
        slave.pcm "softvol"
        slave.channels 6
        route_policy duplicate
    }

Here it is folks! A working CMI8738-mc6 config file that supports 5.1,
upmixing, dmix, and now, softvol. You can control the volume of your
center/lfe channels! This one enables default upmixing of 2.0-\>5.1 as
we all real 5.1 streams to be dmixed at the same time, so you can watch
a DVD in 5.1 (analog) and have other sounds still coming from all
speakers.

` `

    # 6 channel dmix:
    pcm.dmix6 {
        type dmix
        ipc_key 1024
        ipc_key_add_uid false
        ipc_perm 0660
        slave {
            pcm "hw:0,1"
            rate 48000
            channels 6
            period_time 0
            period_size 1024
            buffer_time 0
            buffer_size 5120
        }
    }

    # upmixing: 
    pcm.ch51dup {
        type route
        slave.pcm dmix6
        slave.channels 6
        ttable.0.0 1
        ttable.1.1 1
        ttable.0.2 1
        ttable.1.3 1
        ttable.0.4 0.5
        ttable.1.4 0.5
        ttable.0.5 0.5
        ttable.1.5 0.5
    }

    pcm.duplex {
        type asym
        playback.pcm "ch51dup" # upmix first
        capture.pcm "hw:0"
    }

    # change default device:
    pcm.!default {
        type softvol 
        slave.pcm "duplex"
        control {
            name "Software Master"
            card 0
        }
    }

    # for aoss
    pcm.dsp "duplex"

    pcm.dsp1 "duplex"

Digital I/O
-----------

The CM8x38 provides the excellent SPDIF capability with very cheap price
(yes, that's the reason I bought the card :)

The SPDIF playback and capture are done via the third PCM device
(`hw:0,2`). Usually this is assigned to the PCM device "`spdif`". The
available rates are 44100 and 48000Hz. For playback with `aplay`, you
can do:

` `

    % aplay -Dhw:0,2 foo.wav
       or
    % aplay -Dspdif foo.wav

So far, only S16LE format is supported. Still no 24bit. Sorry, not
enough info for this.

The playback and capture over SPDIF use normal DAC and ADC,
respectively, so you cannot playback both analog and digital streams
simultaneously.

To enable SPDIF output, you need to turn on "IEC958 Output Switch"
control via mixer or `alsactl`. Then you'll see the red light on from
the card so you know that's working obviously :) The SPDIF input is
always enabled, so you can hear SPDIF input data from line-out with
"IEC958 In Monitor" switch at any time (see below).

You can play via SPDIF even with the first device (`hw:0,0`), but SPDIF
is enabled only when the proper format (S16LE), sample rate (441100 or
48000) and channels (2) are used. Otherwise it's turned off. (Also don't
forget to turn on "IEC958 Output Switch", too.)

Additionally there are relevant control switches:

` `

    "IEC958 Mix Analog" - Mix analog PCM playback and FM-OPL/3 streams and
        output through SPDIF.  This switch appears only on old chip
        models (CM8738 033 and 037).
        Note: without this control you can output PCM to SPDIF.
        This is "mixing" of streams, so e.g. it's not for AC3 output
        (see the next section).

    "IEC958 In Select" - Select SPDIF input, the internal CD-in (false)
        and the external input (true).  This switch appears only on
        the chip models 039 or later.

    "IEC958 Loop" - SPDIF input data is loop back into SPDIF
        output (aka bypass)

    "IEC958 Copyright" - Set the copyright bit.

    "IEC958 5V" - Select 0.5V (coax) or 5V (optical) interface.
        On some cards this doesn't work and you need to change the
        configuration with hardware dip-switch.

    "IEC958 In Monitor" - SPDIF input is routed to DAC.

    "IEC958 In Phase Inverse" - Set SPDIF input format as inverse.
        [FIXME: this doesn't work on all chips..]

    "IEC958 In Valid"   - Set input validity flag detection.

Note: When "PCM Playback Switch" is on, you'll hear the digital output
stream through analog line-out.

The AC3 (RAW DIGITAL) Output
----------------------------

The driver supports raw digital (typically AC3) input and output over
SPDIF. This can be toggled via IEC958 playback control, but usually you
need to access it via alsa-lib. See alsa-lib documents for more details.

In the raw digital mode, the "PCM Playback Switch" is automatically
turned off so that non-audio data is heard from the analog line-out.
Similarly the following switches are off: "IEC958 Mix Analog" and
"IEC958 Loop". The switches are resumed after closing the SPDIF PCM
device automatically to the previous state.

Analog Mixer Interface
----------------------

The mixer interface on CM8x38 is similar to SB16. There are Master, PCM,
Synth, CD, Line, Mic and PC Speaker playback volumes. Synth, CD, Line
and Mic have playback and capture switches, too, as well as SB16.

In addition to the standard SB mixer, CM8x38 provides more functions.

-   PCM playback switch
-   PCM capture switch (to capture the data sent to DAC)
-   Mic Boost switch
-   Mic capture volume
-   Aux playback volume/switch and capture switch
-   3D control switch

MIDI Controller
---------------

The MPU401-UART interface is disabled by default. You need to set module
option "`mpu_port`" properly (eg "`0x330`") to enable it.

There is \_no\_ hardware wavetable function on this chip (except for
OPL3 synth below). What's said as MIDI synth on Windows is a software
synthesizer emulation. On Linux, you can use
[softsynths](/Softsynths "Softsynths") such as
[TiMidity](/TiMidity "TiMidity") for playing MIDI music. See the pages
PlayingMidiFiles and [recording MIDI
files](/Recording_MIDI_files "Recording MIDI files") for more details.

FM OPL/3 Synth
--------------

The FM OPL/3 is disabled by default. To enable it, set "`fm_port`"
module option to "`0x388`". You must also load the snd-opl3-synth kernel
module, with

` `

    modprobe snd-opl3-synth

Don't forget to load some instruments, otherwise you won't hear any
sound at all from your OPL/3 synth. Load instruments with

` `

    sbiload -p65:0 --opl3 std.o3 drums.o3

You need to specify the full path to the files `std.o3` and `drums.o3`.
To verify the port of your OPL/3, type `aconnect -o`. Those files are
provided with the kde midi player `kmid`.

A more complete version, which always uses the correct port:

` `

    sbiload -p `pmidi -l |grep OPL3 |awk '{print $1}'` --opl3 -P /path/to/files std.o3 drums.o3

`sbiload` is found in alsa-tools. Debian doesn't have an alsa-tools
package in sarge, but you can get it from the AGNULLA project, from
[http://mirrors.ircam.fr/pub/demudi/pool/local/a/alsa-tools/alsa-tools\_1.0.5-2\_i386.deb](http://mirrors.ircam.fr/pub/demudi/pool/local/a/alsa-tools/alsa-tools_1.0.5-2_i386.deb)

Else, you can get sbiload directly from CVS by typing

` `

    cvs -d ':pserver:anonymous@cvs.alsa-project.org:/cvsroot/alsa' login
    [hit Enter for empty password]
    cvs -z3 -d ':pserver:anonymous@cvs.alsa-project.org:/cvsroot/alsa' co alsa-tools/seq/sbiload

The quality of the OPL cell seems to be very strange at least on
CMI8738. This is verified under DOS also. Perhaps there is some PCI
chipset dependency, or CMI8738 has a hardware bug. Has anyone gotten
good OPL3 sound from a CMI8x38 chip?

On my card (Leadtek Winfast) the OPL sound seems fine, comparable to
that of the old Soundblaster cards.

Joystick and Modem
------------------

The joystick and modem should be available by enabling the control
switch "Joystick" and "Modem" in `/etc/asound.state` respectively. But I
myself have never tested them yet.

I (another I, than the previous one :) have tested it and I had to load
the "`ns558`" module as well in order to get the gameport enabled. Not
sure if the "`gameport`" and "`analog`" modules are required as well,
but they are loaded here as well.

Debugging Information
---------------------

The registers are shown in `/proc/asound/cardX/cmipci`. If you have any
problem (especially unexpected behavior of mixer), please attach the
output of this `/proc` file together with the bug report.

In some hardware configurations, card echoes the beginning of the signal
instead of smooth playing. A workaround for some motherboards (e.g.,
Intel 865PE-based GA-8IPE1000) is to install the card into the last PCI
slot, not in some middle.

Quick Install
-------------

NB. If you are using cvs then you need to type

` `

    make build

instead of

` `

    ./configure  "or"  ./cvscompile

(if you are using rh9 with a "newer" kernel look at this link if you
have problems installing the modules:
[http://www.mail-archive.com/alsa-user@lists.sourceforge.net/msg08312.html](http://www.mail-archive.com/alsa-user@lists.sourceforge.net/msg08312.html)
)

In a shell type these commands:

Make a directory to store the alsa source code in.

` `

    cd /usr/src
    mkdir alsa
    cd alsa
    cp /downloads/alsa-* .

Now unzip and install the alsa-driver package

` `

    bunzip2 alsa-driver-xxx
    tar -xf alsa-driver-xxx
    cd alsa-driver-xxx
    ./configure --with-snd-card=cmipci --with-sequencer=yes;make;make install
    ./snddevices

Now unzip and install the alsa-lib package

` `

    bunzip2 alsa-lib-xxx
    tar -xf alsa-lib-xxx
    cd ..
    cd alsa-lib-xxx
    ./configure;make;make install

Now unzip and install the alsa-utils package

` `

    cd ..
    bunzip2 alsa-utils-xxx
    tar -xf alsa-utils-xxx
    cd alsa-utils-xxx
    ./configure;make;make install

Now insert the modules into the kernel space.

` `

    modprobe snd-cmipci;modprobe snd-pcm-oss;modprobe snd-mixer-oss;modprobe snd-seq-oss

Now adjust your soundcards volume levels. All mixer channels are muted
by default. You must use a native mixer program to unmute appropriate
channels,for example alsamixer from the alsa-utils package

` `

    alsamixer

-   NB. Some soundcards don't utilise the alsamixer program so you will
    need to learn how to use the [amixer](/Amixer "Amixer") program

You can also look at the utils/alsasound file. This script is designed
for the RedHat distribution, but it can be used with other distributions
which use System V style rc init scripts. This will allow you to load
your modules at boot time. Of course if you want to do this you could
just compile them into the kernel instead and save yourself the hassle
of coming to terms with the rc init scripts.

Setting up modprobe and kmod support
------------------------------------

NB. Before you send a mail complaining that "I don't have
/etc/modules.conf, where do I find it ....." ,The /etc/conf.modules has
been deprecated with a few distro's so in your case, it may still be
/etc/conf.modules. Basically they are both same, but recent version of
modutils uses /etc/modules.conf instead. Nothing to worry about as such,
optionally please update to latest version of modutils. This should
solve your problem.

Here's the example for this card. Copy and paste this to the bottom of
your /etc/modules.conf file.

` `

    # ALSA portion
    alias char-major-116 snd
    alias snd-card-0 snd-cmipci
    options snd-cmipci snd_enable_midi=1 

    # OSS/Free portion
    alias char-major-14 soundcore
    alias sound-slot-0 snd-card-0

    # card #1
    alias sound-service-0-0 snd-mixer-oss
    alias sound-service-0-1 snd-seq-oss
    alias sound-service-0-3 snd-pcm-oss
    alias sound-service-0-12 snd-pcm-oss

To copy and paste the above to your /etc/modules.conf file follow these
[instructions](/Instructions "Instructions").

Options for the `snd-cmipci` module
-----------------------------------

The ALSA module `snd-cmipci` is for C-Media CMI8338 and 8738 PCI
soundcards. This module supports autoprobe and multiple chips up to a
maximum of 8. The available options for this module are:

` `

    mpu_port - 0x300,0x310,0x320,0x330,-1=disable (default)
    fm_port - 0x388,-1=disable (default)
    snd_dac_frame_size - max playback frame size in kB 4-128kB
    snd_adc_frame_size - max capture frame size in kB 4-128kB
    snd_enable_midi - 1 = enable, 0 = disable default
    snd_enable_fm - 1 = enable, 0 = disable default

` `

See also
--------

-   [http://www.alsa-project.org/alsa-doc/doc-php/template.php?module=cmipci](http://www.alsa-project.org/alsa-doc/doc-php/template.php?module=cmipci)
-   [A short explanation of what happens in the /etc/modules.conf
    file](/A_short_explanation_of_what_happens_in_the_/etc/modules.conf_file "A short explanation of what happens in the /etc/modules.conf file")
-   [C-Media CMI8738](/C-Media_CMI8738 "C-Media CMI8738") page in the
    [Sound cards](/Sound_cards "Sound cards") category

Retrieved from
"[http://alsa.opensrc.org/Cmipci](http://alsa.opensrc.org/Cmipci)"

[Category](/Special:Categories "Special:Categories"): [ALSA
modules](/Category:ALSA_modules "Category:ALSA modules")

