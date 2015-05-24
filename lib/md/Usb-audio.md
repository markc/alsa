Usb-audio
=========

Contents
--------

-   [1 The module options for
    usb-audio](#The_module_options_for_usb-audio)
-   [2 Setting up modprobe and kmod
    support](#Setting_up_modprobe_and_kmod_support)
-   [3 Notes](#Notes)
-   [4 Some jackd hints](#Some_jackd_hints)
-   [5 Tuning USB devices for minimal
    latencies](#Tuning_USB_devices_for_minimal_latencies)
-   [6 Devices using snd-usb-audio
    driver](#Devices_using_snd-usb-audio_driver)
    -   [6.1 Roland/Edirol EXR-3s with Linux
        2.6](#Roland.2FEdirol_EXR-3s_with_Linux_2.6)
    -   [6.2 Roland Juno-G synthesizer USB MIDI
        patch](#Roland_Juno-G_synthesizer_USB_MIDI_patch)
    -   [6.3 DSP-400 under Linux 2.6](#DSP-400_under_Linux_2.6)
    -   [6.4 SB Audigy2 NX USB](#SB_Audigy2_NX_USB)
    -   [6.5 M-audio Audiophile USB](#M-audio_Audiophile_USB)
    -   [6.6 Turtle Beach Audio Advantage
        Roadie](#Turtle_Beach_Audio_Advantage_Roadie)
    -   [6.7 Creative USB X-Fi Surround
        5.1](#Creative_USB_X-Fi_Surround_5.1)
    -   [6.8 Creative USB X-Fi HD](#Creative_USB_X-Fi_HD)

-   [7 2002-06-03 - The original release notes
    usb-audio](#2002-06-03_-_The_original_release_notes_usb-audio)
-   [8 See also](#See_also)

The module options for usb-audio
--------------------------------

please add to this section.

Setting up modprobe and kmod support
------------------------------------

NB. Before you send a mail complaining that "I don't have
/etc/modules.conf, where do I find it ....." ,The /etc/conf.modules has
been deprecated with a few distro's so in your case, it may still be
/etc/conf.modules. Basically they are both same, but recent version of
modutils uses /etc/modules.conf instead. Nothing to worry about as such,
optionally please update to latest version of modutils. This should
solve your problem.

Here's the example for this module. Copy and paste this to the bottom of
your /etc/modules.conf file.

    # ALSA portion
    alias char-major-116 snd
    alias snd-card-0 snd-usb-audio

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

Here's a modules.conf file for the Emagic emi2|6.

    alias usb-controller usb-uhci
    # --- ALSA configuration
    alias char-major-116 snd
    alias char-major-14 soundcore
    alias snd-card-0 snd-usb-audio
    alias sound-slot-0 snd-card-0
    # --- OSS compatibility
    #alias sound-slot-0 audio
    alias sound-service-0-0 snd-mixer-oss
    alias sound-service-0-1 snd-seq-oss
    alias sound-service-0-3 snd-pcm-oss
    alias sound-service-0-8 snd-seq-oss
    alias sound-service-0-12 snd-pcm-oss
    # --- Options
    options snd major=116 cards_limit=3
    # --- ALSA configuration END
    post-install sound-slot-0 /bin/aumix-minimal -f /etc/.aumixrc -L >/dev/null 2>&1 || :
    pre-remove sound-slot-0 /bin/aumix-minimal -f /etc/.aumixrc -S >/dev/null 2>&1
    || :

Notes
-----

Takashi Iwai is the maintainer of the code for this card.

First of all you need to have usb working correctly. There is much
useful info available at
[http://www.linux-usb.org](http://www.linux-usb.org).

Optimally setting irq resources for usb is essential for good
performance. If possible set pci/usb irq, from best to worst:

    9,10,11,12,13,14,15,3,4,5,6,7

**Request:** could somebody please provide info on what needs to be done
to set IRQ's properly?

Some jackd hints
----------------

Jack has changed so that -p must always be a power of two. This is
because certain programs can have much more efficient algorithms if they
can depend on that sort of buffer size. Someone will have to find a
different period size that works well.

Using Linux Kernel 2.6.8.1 with Ingo Molnar's 2.6.8.1-VP patches, jackd
0.99.14 and alsa-lib 1.0.7, I'm able to get low latency audio with the
emi 2|6::

    echo 0 > /proc/irq/11/ehci_hcd/threaded
    echo 0 > /proc/irq/11/uhci_hcd/threaded

    jackd -R -d alsa -d hw:1 -p 64 -n 4 -P

USB-MIDI driver for Linux:
[http://member.nifty.ne.jp/Breeze/softwares/unix/usbmidi-e.html](http://member.nifty.ne.jp/Breeze/softwares/unix/usbmidi-e.html)

[USB MIDI sequencer
support](/USB_MIDI_sequencer_support "USB MIDI sequencer support") --
Clemens Ladisch

*You should upgrade to kernel 2.4.19 or greater to get the correct
infomation from lsusb -- Patrick Shirkey*

Fernando's 2.4.19 low latency rpm is a useful resource.
[http://ccrma-www.stanford.edu/planetccrma/software/installkernelandsound.html](http://ccrma-www.stanford.edu/planetccrma/software/installkernelandsound.html)

[Midiman Quattro
.asoundrc](/Midiman_Quattro_.asoundrc "Midiman Quattro .asoundrc")

One more note on configuring your kernel: there is an option for USB
audio support in the USB section of the kernel config. You should
\_NOT\_ enable it. It is intended for use with USB speakers. If you do
enable it, your alsa usb audio module will load properly, but it will
seriously confuse devfs if you have it. Device special files for your
USB audio unit will not be made properly.

It seems that the newer USB Midi module is also unnecessary, even if
your device has midi.

With the USB Audio Quattro, this results in very strange behaviour: apps
that use the OSS compatibility layer can play sound on your device, but
it becomes completely distorted once the loudness goed up. Apps that use
ALSA directly will complain about device drivers not being found and
such. You have been warned!

-- Denis de Leeuw Duarte

Tip: You can also add "usbmidi" and "usbaudio" to the file
"/etc/hotplug/blacklist" to prevent hotplug from loading these OSS
modules.

Tuning USB devices for minimal latencies
----------------------------------------

On linux-audio-user Christoph Eckert brought up the question about how
to get better latencies out of USB audio devices, and USB guru Clemens
Ladisch had a very good tip: The snd-usb-audio module accepts a module
option called "nrpacks", which according to modinfo, sets the: Max.
number of packets per URB. (int). Setting this to "nrpacks=1" should
allow latencies in the area of 4-6 msecs.

Unfortunatly on some systems/kernels nrpacks=1 conflicts with a feature
called "USB bandwidth allocation" in the kernel. Here's the way out:

-   In the kernel config ensure that both options (taken from a 2.6.10)
    are disabled::

    :[   ] Enforce USB bandwidth allocation (EXPERIMENTAL)
    :[   ] Dynamic USB minor allocation (EXPERIMENTAL)

-   Ensure to load the snd-usb-audio module with the parameter
    "nrpacks=1", maybe including it into one of the boot scripts::

    modprobe snd-usb-audio nrpacks=1

-   Or use the module configuration line (e.g. in /etc/modprobe.conf):

    options snd-usb-audio nrpacks=1

-   Now invoke JACK with the following command (or entering the
    corresponding values into Qjackctl):

    jackd -R -P89 -dalsa -dhw:2 -r48000 -p256 -n3 -S

You can omit the "-S" if your card supports 24bit or 32bit access as
well and you want to use that.

***Request:*** could somebody please provide info on what needs to be
done to set IRQs properly?

Devices using snd-usb-audio driver
----------------------------------

-   [Edirol UA-5](/Edirol_UA-5 "Edirol UA-5")
-   [Edirol UM-550 and
    UM-880](/Edirol_UM-550_and_UM-880 "Edirol UM-550 and UM-880")
-   [ESI RoMI/O2](/ESI_RoMI/O2 "ESI RoMI/O2")
-   [Griffin iMic](/Griffin_iMic "Griffin iMic")
-   [Hercules DJ Console](/Hercules_DJ_Console "Hercules DJ Console")
-   [Turtle Beach/Voyetra Audio Advantage Micro
    5.1](?title=Turtle_Beach/Voyetra_Audio_Advantage_Micro_5.1&action=edit&redlink=1 "Turtle Beach/Voyetra Audio Advantage Micro 5.1 (page does not exist)")
-   [M-Audio FastTrack
    Pro](/M-Audio_FastTrack_Pro "M-Audio FastTrack Pro")
-   [Creative USB X-Fi Surround
    5.1](?title=Creative_USB_X-Fi_Surround_5.1&action=edit&redlink=1 "Creative USB X-Fi Surround 5.1 (page does not exist)")
-   [Creative USB X-Fi
    HD](?title=Creative_USB_X-Fi_HD&action=edit&redlink=1 "Creative USB X-Fi HD (page does not exist)")

### Roland/Edirol EXR-3s with Linux 2.6

I've put some instructions for getting EXR-3s working with
snd-usb-audio:
[[1]](http://www.kotiposti.net/epulkkin/EXR3s/index.html). It requires a
minor kernel patch.

### Roland Juno-G synthesizer USB MIDI patch

I made a patch for the USB MIDI function of the Roland Juno-G
synthesizer to work. Basically it is a missing entry in
alsa-driver-1.0.14rc2.orig/sound/usb/usbquirks.h. The patch is
[here](http://gtmp.org/publications/juno-g-usb-midi-alsa-patch).

### DSP-400 under Linux 2.6

If you are trying to get USB headphones working under the 2.6 kernel
(such as the Plantronics DSP series), there is some information to be
found at
[http://www.xantius.com/articles/dsp-400.php](http://www.xantius.com/articles/dsp-400.php),
however it's not being updated...

### SB Audigy2 NX USB

I was fooling around with this for a while and finally came to a
solution thanks to banshee in \#creative and some tinkering. Some might
notice that the NX is detected but the sound is garbled, simply lower
from 44khz to 22khz in xmms, it might not be a complete fix, but it
makes it possable to listen to more than sytem sounds. AIM - Ryox82 for
questions

With ALSA 1.0.2c from the 2.6.9 kernel, the following (found elsewhere
here) did the trick (and is mandatory for getting the EMI 6|2
recording!):

    modprobe snd-usb-audio nrpacks=1

Then I ran Jack with 48kHz, 16 or 24 bit samples, 512 or 1024 sample
blocks and 2 buffers.

With this configuration, my Audigy 2 NX works perfectly on my USB 2.0
bus on my HP/Compaq NX 7010 notebook.

ALSA 1.0.9 did not allow me to un-mute the card at all. Sample rates
other than 48kHz fail miserably.

### M-audio Audiophile USB

This is a strange one at the moment - since it isn't completely
compliant with the USB audio spec and nobody in the dev team has one of
these devices, support is limited. (I do have one and am happy to aid
the developers in improving support for the device by the way)

Anyway, issues I've fond to date: (ALSA 0.9.7 with Linux 2.4.22,
premptable kernel, low latency)

Playback only possible at 48khz 2-channel 16-bit (S16\_LE) (see below)
Record: as playback, but I haven't managed to get any audio from the
device (it returns all zeros - not even any codec noise)

Although I'm telling the device the data is little endian, the data
should be sent as \*Big endian\*!

-- David Hughes

### Turtle Beach Audio Advantage Roadie

I have one of these and am interested in getting surround sound working
on it. If anyone knowledgeable would like to help, it would be
appreciated.

### Creative USB X-Fi Surround 5.1

The card works fine with the snd-usb-audio module. I've only tested the
stereo output though. The X-Fi USB doesn't have a hardware mixer. So you
have to use the softvol plugin along with dmix. Here is a simple
\~/.asoundrc file that will give you a 'Master' Volume control.

    pcm.!default {
        type            plug
        slave.pcm       "softvol"   #make use of softvol
    }

    pcm.softvol {
        type            softvol
        slave {
            pcm        "dmix"      #redirect the output to dmix (instead of "hw:0,0")
        }
        control {
            name        "Master"       #override the PCM slider to set the softvol volume level globally
            card        0
        }
    }

One important thing to note about softvol is that the Master control
won't appear until the device is used for playback.

The device has a volume knob, the behavior of which is identical to that
of IR remotes bundled with some Creative USB Audio devices. It also has
a LED which can be set to On or can be set to Blink continuously. There
doesn't seem to be a way to switch it off.

The latest stable kernel release (2.6.37) has support for this.
alsa-driver-1.0.24 too has these changes but I haven't tested it yet.

~~Support for this is now in the
[git](http://git.kernel.org/?p=linux/kernel/git/tiwai/sound-2.6.git;a=summary)
repo. Ref:
[1](http://mailman.alsa-project.org/pipermail/alsa-devel/2010-October/033100.html)
[2](http://mailman.alsa-project.org/pipermail/alsa-devel/2010-November/033300.html)
Here is the
[patch](http://mndar.phpnet.us/usbxfi/files/usbxfi_volume_knob_led_alsa_driver_1.0.23.patch)
for alsa-driver-1.0.23~~

Once the snd-usb-audio module is loaded, you'll see the 'Power LED'
control in alsamixer. Muting it will set the LED to Blink and unmuting
it will set it to On. For the volume knob, you need to use the alsa\_usb
driver with lirc. Lirc will receive events whenever the volume knob is
turned or pressed.

There is a remote bundled with this device sometimes. Its possible the
remote will work with the same patch but unfortunately I don't have one
with me.

The default alsa\_usb config can be used as the codes are 0x0d for Mute,
0x0f for Vol- and 0x10 for Vol+. These are identical to the remote
identified by name RM-1500 (Not Creative\_RM-1500) ` `

    cp /usr/share/lirc/remotes/creative/lircd.conf.alsa_usb /etc/lircd.conf

Lirc needs to be started with these options. You can set your distro's
config file accordingly ` `

    lircd --driver=alsa_usb --device=hw:S51

Run irw and you'll be able to see the received code when you turn or
press the volume knob. If you need to execute commands for Vol-,Vol+ and
Mute, setup \~/.lircrc . You need to have "irexec -d" running in the
background for these commands to be executed. Everytime you change
\~/.lircrc you need to restart irexec

    # $HOME/.lircrc
    #S51 Volume Knob
    begin
     prog = irexec
     remote = RM-1500
     button = vol-
     repeat = 1
     config = amixer sset Master 1- 
    end

    begin
     prog = irexec
     remote = RM-1500
     button = mute
     repeat = 1
     config = if [ `amixer sget Master|grep "Front Left:"|awk '{print $3}'` -gt 0 ]; then alsactl store -f ~/.asound.state; amixer sset Master 0; amixer sset 'Power LED' off; else alsactl restore -f ~/.asound.state; amixer sset 'Power LED' on;  fi 
    end

    begin
     prog = irexeca
     remote = RM-1500
     button = vol+
     repeat = 1
     config = amixer sset Master 1+ 
    end

The Mute part is messy because softvol plugin doesn't have the Mute
feature. This lircrc allows you to mimic the behaviour under Windows
i.e. LED blinking on Mute.

Anyway, you should change the commands based on your configuration. Eg.
If you are using Pulseaudio you probably don't even need to use dmix &
softvol. You could just use dbus-send or qdbus to change volume in
Pulseaudio or use Pulseaudio's Lirc config in which case you don't need
irexec running at all . I don't use Pulseaudio. Someone who is using it
can probably explain it.

### Creative USB X-Fi HD

This card works fine with snd-usb-audio.

The analog and the SPDIF parts are separated, they show up as different
devices - just like under MS Windows. The analog part offers 48 kHz and
96 kHz as output frequency, while the SPDIF output is capable of 44.1
kHz and 48 kHz. Both outputs can handle 24 bit mode (though on SPDIF the
X-Fi will emit only 16 bits). They are independent of each other, you
can e.g. play a sound in 44.1 kHz/16 bit mode on the SPDIF output while
playing a different, 48 kHz/24 bit sound on the analog output.

The analog recording capability seems to be fixed at 48 kHz / 16 bit
while the SPDIF can handle 44.1 kHz or 48 kHz, depending on the input.

For instructions on setting up SPDIF see the page on
[DigitalOut](http://alsa.opensrc.org/DigitalOut).

The X-Fi HD's volume knob is just a knob that does not do anything
directly with the volume - by default it does not do anything in Linux.
It shows up as a USB HID device and you need LIRC to use it.

After installing LIRC you have to set up three files:

-   /etc/lirc/hardware.conf - the details about the physical device
-   /etc/lirc/lircd.conf - how to translate various codes into
    meaningful symbols
-   /etc/lirc/lircrc - what to do when specific symbols are received

/etc/lirc/hardware.conf should contain the following lines:

    DRIVER="devinput"
    DEVICE="/dev/input/by-id/usb-Creative_Technology_USB_Sound_Blaster_HD_000004Jt-event-if05"

**Note1**: Check the device file name in /dev/input/by-id/ as it
contains the X-Fi's serial number so it's slightly different for
everyone.

**Note2**: Some distributions (like Ubuntu) use REMOTE\_DRIVER and
REMOTE\_DEVICE instead of DRIVER and DEVICE - check your default
hardware.conf.

/etc/lirc/lirdc.conf can be replaced with
[lircd.conf.devinput](http://lirc.sourceforge.net/remotes/devinput/lircd.conf.devinput).

The actual code to change the volume is in /etc/lirc/lircrc, insert the
following:

    # X-Fi HD Volume Knob
    begin
        prog = irexec
        remote = devinput
        button = KEY_VOLUMEDOWN
        repeat = 1
        config = amixer -c HD sset 'PCM' 2- 
    end

    begin
        prog = irexec
        remote = devinput
        button = KEY_MUTE
        repeat = 1
        config = if [ -n "$(amixer -c HD cget name='PCM Playback Switch' |grep 'values=on')" ] ; then amixer -c HD cset name='PCM Playback Switch' off ; else amixer -c HD cset name='PCM Playback Switch' on ; fi
    end

    begin
        prog = irexec
        remote = devinput
        button = KEY_VOLUMEUP
        repeat = 1
        config = amixer -c HD sset 'PCM' 2+
    end

Restart LIRC (make sure that irexec is also (re)started) and you should
have a working volume knob.

2002-06-03 - The original release notes usb-audio
-------------------------------------------------

[Takashi Iwai](/TakashiIwai "TakashiIwai") wrote: right now you can find
a driver for USB audio on cvs. It's in alsa-driver not in alsa-kernel.
The driver will be built automatically when CONFIG\_USB is specified in
kernel config. Please note that this driver is EXPERIMENTAL and
TENTATIVE. My first plan was to implement a USB library layer on
alsa-lib, but it was found out that implementation of isochronous
transfer via `usbdevfs` will bring some difficulty. So I started coding
of a normal kernel driver at first. If any feasible solution to port
such a stuff into user space, we should do that. But anyway, it's good
to have a working code. We can move it to other place later.

The current code is partly based on OSS/USB audio.c code, but apart from
the parsing routine of audio-streaming, the resultant codes became
fairly different from the oss code. Almost all mixer controls are
supported except for graphic equalizer. The mapping of topology might
not be perfect, since alsa has a plain control structure.

So far, I've tested only audio playback on my speaker, which is adaptive
out without pitch/freq setting. `xmms` is working. The driver accepts
the period size up to 1ms. A courageous user can try such a heavy
condition. (me? did not yet :) 24bit/96kHz should work, too, but I have
no such a hardware. Besides, capture is not tested at all.

If you have a usb audio device, please test once. (oh, I forgot to
mention the driver name - it's "snd-usb-audio" quite easy, isn't it?) If
you find somewhat strange behavior (especially in mixer controls),
please send me the output of lsusb. BTW, when you use snd-usb-audio
module, please make sure that you don't load OSS audio.o together.
Hotplug likely loads both modules at the same time.

See also
--------

-   [Quick Install](/Quick_Install "Quick Install")
-   The [.asoundrc](/.asoundrc ".asoundrc") file
-   [USBMidiDevices](/USBMidiDevices "USBMidiDevices")
-   [MultipleUSBAudioDevices](/MultipleUSBAudioDevices "MultipleUSBAudioDevices")
-   [http://www.alsa-project.org/alsa-doc/doc-php/template.php?module=usb-audio](http://www.alsa-project.org/alsa-doc/doc-php/template.php?module=usb-audio)
