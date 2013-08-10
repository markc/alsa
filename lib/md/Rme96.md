Rme96
=====

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Contents
--------

-   [1 RME Digi 96/8 series sound
    cards](#RME_Digi_96.2F8_series_sound_cards)
-   [2 ALSA Section](#ALSA_Section)
    -   [2.1 Devices](#Devices)
    -   [2.2 Buffer Size, Periods &
        Frames](#Buffer_Size.2C_Periods_.26_Frames)
    -   [2.3 modules.conf](#modules.conf)
    -   [2.4 .asoundrc](#.asoundrc)

-   [3 JACK Section](#JACK_Section)
    -   [3.1 Tips](#Tips)
    -   [3.2 JACK Options](#JACK_Options)

-   [4 Misc. Section](#Misc._Section)
    -   [4.1 Digital Pass Through](#Digital_Pass_Through)
    -   [4.2 Sequencer Issues](#Sequencer_Issues)
    -   [4.3 GUI Mixer](#GUI_Mixer)
    -   [4.4 Hardware](#Hardware)
    -   [4.5 ADAT as regular ALSA
        channels](#ADAT_as_regular_ALSA_channels)

RME Digi 96/8 series sound cards
--------------------------------

Last updated: **2005-09-08**

At the last update, the latest verion of [ALSA](/ALSA "ALSA") is 1.0.9
and the latest version of [JACK](/JACK "JACK") is 0.100.0. If things
have changed over time, edit this page and change the date and ALSA/JACK
versions listed. This info is mostly valid for the 2.4 kernel series,
but the 2.6 kernel series has become quite stable and is generally
recommended over the 2.4 series.

ALSA Section
------------

### Devices

Device 0 - (accessed as **hw:x,0**)

SPDIF Coaxial and Optical

AES/EBU

Analog IO

Digital pass through (dolby, ac3, dts)

Device 1 - (accessed as **hw:x,1**)

ADAT

### Buffer Size, Periods & Frames

This card has a fixed buffersize of 64KBytes, and must be divided into
either 8 or 32 periods (a.k.a fragments or buffers). Any app that does
not have the number of periods and frames per period (a.k.a. buffer
size) set correctly will not play back properly. The following table
shows possible combinations. Any other combination will not work! Note:
20 and 24 bit words are padded to make 32 bit words.

Device 0 -

(16 bit wordsize)

--2048 frames and 8 periods

--512 frames and 32 periods

(32 bit wordsize)

--1024 frames and 8 periods

--256 frames and 32 periods

Device 1 -

(16 bit wordsize)

--512 frames and 8 periods

--128 frames and 32 periods

(32 bit wordsize)

--256 frames and 8 periods

--64 frames and 32 periods

**Update:** This is no longer completely true with newer versions of
alsa. In laymans terms, the number of periods created and number of
periods actually used are no longer necessarily tied to each other. This
means you can set the number of periods used to any number below the
number of periods created, resulting in much lower latency. This
functionality can be accessed in versions of Jack \> 0.99.0

### modules.conf

` `

    # ALSA portion
    alias char-major-116 snd
    alias snd-card-0 snd-rme96

    # OSS/Free portion - card #1
    alias char-major-14 soundcore
    alias sound-slot-0 snd-card-0
    alias sound-service-0-0 snd-mixer-oss
    alias sound-service-0-1 snd-seq-oss
    alias sound-service-0-3 snd-pcm-oss
    alias sound-service-0-8 snd-seq-oss
    alias sound-service-0-12 snd-pcm-oss

    alias /dev/mixer snd-mixer-oss
    alias /dev/dsp snd-pcm-oss
    alias /dev/midi snd-seq-oss

    # Set this to the correct number of cards
    options snd cards_limit=1

    # Other available module options
    # index int array (min = 1, max = 8),
    #  description "Index value for RME Digi96 soundcard."
    # id string array (min = 1, max = 8),
    #  description "ID string for RME Digi96 soundcard."
    # enable int array (min = 1, max = 8),
    #  description "Enable RME Digi96 soundcard."

### .asoundrc

` `

    pcm.rme_stereo {
        type hw
        card 0
    }
    ctl.rme_stereo {
        type hw
        card 0
    }
    pcm.rme_adat {
        type hw 
        card 0
        device 1
    }
    ctl.rme_adat {
        type hw
        card 0
    }

To connect an app to **Device 0**, use the **rme\_stereo** interface. To
connect an app to **Device 1**, use the **rme\_adat** interface. This is
a minimal [.asoundrc](/.asoundrc ".asoundrc"), you can always add more
interface definitions, like the DmixPlugin, and the alias names used
here can be changed as well.

JACK Section
------------

### Tips

-   If you are getting a continuous stream of delay warnings after
    starting JACK on Device 0, you may have your input connector set to
    a connection that has nothing plugged into it. For example if your
    input is set to "Coaxial" and no externial hardware plugged into
    your coaxial connection, or there is hardware plugged in that is not
    on or not set to use the coaxial connections then this may be the
    cause of the delays. Either set your input to "Analog" or configure
    the connected hardware properly.

-   If you are connecting JACK to SubDevice 1, the following must be set
    correctly or JACK will fail:
    1.  Input Connector must be set to Optical.
    2.  Your Sample Clock Source should be set to work correctly with
        your connected ADAT hardware. (Internal == Master. Autosync ==
        Slave and matches the format of the Master. Word == Both card
        and ADAT hardware are slave to a word clock generator) Usually
        you will want your hardware slaved to the card.
    3.  The external hardware MUST be in Digital Optical ADAT mode so
        that it can communicate with JACK. If the external hardware can
        only go into that mode when there is an ADAT signal present, run
        `aplay -D rme_plug anyfile.wav` in order to get the ADAT device
        turned on. You can then stop aplay and switch the external
        hardware to Digital Optical ADAT mode. JACK should then startup
        properly. (This had been addressed in the newer versions of
        jack/alsa, but I'm leaving it here in case anybody with and
        older distro runs into this problem)
    4.  Make sure you are not connecting Input to Input and Output to
        Output. :)
    5.  Be careful about 32 bit and 16 bit mode. By default Jack starts
        in 32 bit mode. If the connected interface does not support 32
        bit mode then it will attempt to connect in 24 and 16 bit mode.

-   As of Jack 0.90.0 you can connect directly to PCM hw:x,1 and Jack
    will know to use the Controller hw:x,0. There is only one controller
    for both devices. If you are using an earlier version of Jack it
    will attempt to use Controller hw:x,1 which doesn't exist.

-   Using the a plugin interface is sluggish! Don't connect Jack to a
    plug interface like dmix unless you absolutely have to.

-   If your desktop starts a sound server (Arts or esound for example)
    you may want to turn thses off. They serve no purpose anymore now
    that ALSA has the dmix plugin available. The only reason you would
    need them is if a certain piece of software will only connect to a
    sound server.

### JACK Options

Here's some examples of JACK options that work, with the
[.asoundrc](/.asoundrc ".asoundrc") file listed above.

**Connection to SPDIF device** ` `

    jackd -R -t 2000 -u -d alsa -d rme_stereo -r 44100 -p 256 -n 32 -m -H -M
    jackd -R -t 2000 -u -d alsa -d rme_stereo -r 44100 -p 1024 -n 8 -m -H -M

**Connection to ADAT device** ` `

    jackd -R -t 2000 -u -d alsa -d rme_adat -r 44100 -p 512 -n 8 -H -M
    jackd -R -t 2000 -u -d alsa -d rme_adat -r 44100 -p 128 -n 32 -H -M

There are many other combinations that work. These are just some
examples that show some options available through JACK.

Misc. Section
-------------

### Digital Pass Through

**.xine/config**

` `

    # device used for 5.1-channel output
    audio.alsa_a52_device:rme_stereo:AES0=0x6,AES1=0x82,AES2=0x0,AES3=0x2
    audio.a52_pass_through:1

### Sequencer Issues

If you are useing a 2.4 series kernel, or 2.6 with Alsa loaded as
modules, and plan to use a soft synth such as timidity++ or fluidsynth,
you need to make sure that synth module is loaded at boot time. (Or load
it manually with modprobe) This card does not have a MIDI interface, so
the Alsa sequencer modules needed by the softsynths will not be loaded
by default. Most distros have a means of specifying which modules you
want loaded at boot time by default. Add the alsa sequencer modules to
this list.

If you are using a 2.6 series kernel with Alsa compiled directly into
the kernel, you need not worry about this as long as the kernel was
build with the Alsa sequencer built in.

### GUI Mixer

There is a GUI mixer that comes with ALSA tools for the RME 96/8 card
series, but i think the one found at [this
site](http://www.uni-koblenz.de/~phil/tkdigi/) is nicer. (This is a
personal web site so if the link goes dead, remove this section.) When
using Jack there is a nice interface for starting and stopping Jack
called [qjackctl](http://qjackctl.sf.net). It also can be used for
patching both Jack and the Alsa Sequencer and saving preset for almost
anything.

### Hardware

There is a jumper on the card that can be set so that the card starts up
in ADAT mode. If you will be using ADAT a lot, you may want to set this
jumper. The jumper (JP4) is labeled "Boot ADAT".

### ADAT as regular ALSA channels

There is an article about how to configure
[.asoundrc](/.asoundrc ".asoundrc") to [use the RME ADAT interface as
multiple stereo
channels](/RME_cards:_ADAT_interface_as_multiple_analog_channels_(Howto) "RME cards: ADAT interface as multiple analog channels (Howto)").

Retrieved from
"[http://alsa.opensrc.org/Rme96](http://alsa.opensrc.org/Rme96)"

[Category](/Special:Categories "Special:Categories"): [ALSA
modules](/Category:ALSA_modules "Category:ALSA modules")

