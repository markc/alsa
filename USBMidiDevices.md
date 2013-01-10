USBMidiDevices
==============

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Contents
--------

-   [1 What is a USB MIDI Device?](#What_is_a_USB_MIDI_Device.3F)
-   [2 Edirol UM-1X](#Edirol_UM-1X)
-   [3 E-MU Xmidi series](#E-MU_Xmidi_series)
-   [4 MOTU Fastlane](#MOTU_Fastlane)
-   [5 M-Audio (aka Midiman)](#M-Audio_.28aka_Midiman.29)
    -   [5.1 Using hotplug to load the
        firmware](#Using_hotplug_to_load_the_firmware)
    -   [5.2 Using udev to load the
        firmware](#Using_udev_to_load_the_firmware)

-   [6 M-audio Trigger Finger](#M-audio_Trigger_Finger)
-   [7 Midisport 8x8](#Midisport_8x8)
    -   [7.1 Sysex Requests](#Sysex_Requests)
    -   [7.2 Global Data Sysex](#Global_Data_Sysex)
    -   [7.3 Patch data Sysex](#Patch_data_Sysex)
    -   [7.4 Data bytes encoding](#Data_bytes_encoding)

-   [8 Testing Your Device](#Testing_Your_Device)

What is a USB MIDI Device?
--------------------------

A USB MIDI device is an external cable or box with one or more USB ports
that is useful for connecting a PC which lacks a MIDI interface to [MIDI
keyboards](/MIDI_keyboards "MIDI keyboards") or instruments.

See also:

-   [USB MIDI sequencer
    support](/USB_MIDI_sequencer_support "USB MIDI sequencer support")
-   [usb-audio](/Usb-audio "Usb-audio")

Edirol UM-1X
------------

The easiest USB MIDI devices to use with ALSA are *Edirol's "UM"* range
of products because they work immediately without requiring any
"firmware", unlike some other manufacturers' products which do require
firmware. For example, the *Edirol UM-1EX*
[[1]](http://www.edirol.it/europe/details.asp?ct=3&gid=1&gruppo=Audio+%26+MIDI+Interfaces&id=12&la=UK&code=410)
is a very compact USB-MIDI interface cable which works perfectly with
Linux without needing any further setup after loading the
*snd-usb-audio* module in any USB-enabled Linux kernel.

E-MU Xmidi series
-----------------

Like the Edirol UM-1X interface described above, the E-MU Xmidi line of
interfaces don't require firmware and are ready to go as soon as they're
plugged in. If you prefer a pocket-sized interface that doesn't have
permanently-attached cables, as the Edirols do, the 2x2 is a good
choice.

MOTU Fastlane
-------------

The MOTU Fastlane [[2]](http://www.motu.com/products/midi/fastlane_usb)
works without requiring a firmware loader. Make sure your Linux kernel
is older than 2.6.18 or newer than 2.6.27. See
[http://www.gossamer-threads.com/lists/linux/kernel/807593](http://www.gossamer-threads.com/lists/linux/kernel/807593).

M-Audio (aka Midiman)
---------------------

These instructions apply to M-Audio and Midiman USB MIDI devices such
as: *MidiSport 1x1, 2x2, 4x4, 8x8, KeyStation, Oxygen,* or *Uno*. To use
these devices we need a recent version of ALSA with the
*[usb-audio](/Usb-audio "Usb-audio")* module. *usb-audio* supports both
audio and midi. But we also need to load some firmware to get the device
to work. This is described below.

First, we need a recent 2.4 or 2.6 linux kernel with USB hotplug
support. To configure hotplug support, go to the USB section of kernel
configuration and say Y to "USB device filesystem" (or "Preliminary USB
device filesystem" in older kernels). With this kernel installed,
install ALSA as usual... see the rest of this wiki. :) You'll need to
add *usb-audio* to your */etc/modules.conf* or */etc/modutils/alsa* or
however you usually configure modules. Here's the options I use and note
that I already have another soundcard at snd-card-0, so this one is card
1.

` `

    # modules.conf for snd-usb-audio
    # with a midi device
    alias snd-card-1 snd-usb-audio

    # for oss emulation... untested
    alias sound-slot-1 snd-card-1
    alias sound-service-1-1 snd-seq-oss
    alias sound-service-1-8 snd-seq-oss

    options usb-audio enable=1 \
                       index=1 \
                       id="oxygen"

When you've got a suitable kernel and ALSA installed, it's time to
install the necessary user-mode tools: *hotplug*, *fxload*, and the
firmware loader. Use the system packages if available; for example on
gentoo I can just type "emerge hotplug fxload". Otherwise download the
latest *hotplug* and *fxload* from
[Sourceforge](http://sourceforge.net/project/showfiles.php?group_id=17679).
If installing from source code, follow the instructions in the README.
Debian users, note that instead of *chkconfig --add hotplug* you should
use the command *update-rc.d hotplug defaults*. Now install fxload,
following the instructions in README.txt.

Now you need to know whether your system will use hotplug or udev. To
find out, try this command: ` `

    $ mount | grep udev

If you see a line like "udev on /dev type tmpfs", follow the udev
instructions below. If not, follow the hotplug instructions.

### Using hotplug to load the firmware

Start the hotplug service: ` `

    /etc/init.d/hotplug start

or /etc/rc.d/init.d/hotplug start ... depending on your distro.

Now install the midisport\_firmware package from
[Sourceforge](http://usb-midi-fw.sourceforge.net/). For use with
hotplug, you need the old 0.5 version, and you may also need the
firmware from your *Midiman* driver CD. The README that comes with
midisport\_firmware tells you what file name to look for for your
device. For the *Oxygen*, it's on the CD at ` `

    Keystation\Drivers/UKS11LDR.SYS.

Follow the simple installation instructions in the
midisport-firmware/README and you're all set!

Try plugging in your USB device while watching ` `

    tail -f /var/log/messages

You should see something like (for the *Oxygen*): ` `

    Dec  9 15:45:05 kermit kernel: hub.c: USB new device connect on bus1/1, assigned device number 2
    Dec  9 15:45:05 kermit kernel: usb.c: USB device 2 (vend/prod 0x763/0x1014) is not claimed by any active driver.
    Dec  9 15:45:08 kermit /etc/hotplug/usb.agent: Setup midisport_fw for USB product 763/1014/1
    Dec  9 15:45:08 kermit /etc/hotplug/usb.agent: Module setup midisport_fw for USB product 763/1014/1
    Dec  9 15:45:08 kermit /etc/hotplug/usb/midisport_fw: load /usr/share/usb/MidiSportKS.ihx for 763/1014/1 to /proc/bus/usb/001/002
    Dec  9 15:45:13 kermit kernel: usb.c: USB disconnect on device 2
    Dec  9 15:45:14 kermit kernel: hub.c: USB new device connect on bus1/1, assigned device number 3
    Dec  9 15:45:18 kermit /etc/hotplug/usb.agent: Setup snd-usb-audio for USB product 763/1015/121

*PaulWinkler*

### Using udev to load the firmware

Now install the midisport\_firmware package from
[Sourceforge](http://usb-midi-fw.sourceforge.net/). For use with udev,
you should get the newer (1.2 or later) version. It includes firmware so
you should not need anything from the driver CD.

You need to define a udev rule to get the firmware loaded, if you plug
in the device. The first steps are the same as described in the README
that comes with midisport\_firmware. But instead of the midisport\_fw
stuff in the */etc/hotplug/usb* directory, you have to add a line in the
file */etc/udev/rules.d/50-udev.rules*. (The number 50 leading the file
name may vary on some systems)

    NOTE, as of version 1.2 of the firmware loader, you shouldn't have to do this by hand;

the "make install" command will do it for you.

For earlier versions of the loader, assuming your firmware and the
firmware loader is located in the directory */usr/share/usb/midisport/*
you had to add a line like ` `

      SUBSYSTEM=="usb", ACTION=="add", ENV{PRODUCT}=="763/1020/*", RUN+="/sbin/fxload -s /usr/share/usb/midisport/MidiSportLoader.ihx -I /usr/share/usb/midisport/MidiSport4x

4.ihx" if you're using a MidiSport4x4. In case of other devices, change
the product identifier(763/1020/\*) and the firmware name
(MidiSport4x4.ihx).

Once the firmware loader is installed and the udev rule is created, plug
in the device and you should see something like this in
/var/log/messages:

` `

    Oct 21 23:15:27 kermit usb 2-6: new full speed USB device using ohci_hcd and address 14
    Oct 21 23:15:27 kermit usb 2-6: configuration #1 chosen from 1 choice
    Oct 21 23:15:33 kermit usb 2-6: USB disconnect, address 14
    Oct 21 23:15:34 kermit usb 2-6: new full speed USB device using ohci_hcd and address 15
    Oct 21 23:15:34 kermit usb 2-6: configuration #1 chosen from 1 choice

*Hartmut Geissbauer and Paul Winkler*

\

M-audio Trigger Finger
----------------------

True plug and play using the snd\_usb\_audio module.

Only one wee small tear: You can send sysex to the device to restore
previous settings, but there's no way to backup the device on linux
because it doesn't offer the possibility to request its memory content
via sysex nor does it offer the possibility to invoke a dump from its
interface.

Midisport 8x8
-------------

The Midisport 8x8 works very well using ALSA / Kernel 2.6.10.

To get it to work, first follow the instructions above for other M-Audio
devices using udev or hotplug depending on your system. More specific
information for this device follows.

The midisport can be used as a USB-MIDI-device as well as a programmable
stand alone MIDI patch/mergebay with 8 user definable programs.

m-audio offers a control panel for windows and mac to define the
connections of the patchbay.

In ALSA, the midisport offers 8 in and out ports and one control port.
The device can be configured by sending sysex commands to the control
ports. There's a small shell script to configure the device:
[http://sysexxer.sf.net/files/mspconf.sh](http://sysexxer.sf.net/files/mspconf.sh)

### Sysex Requests

Sending requests to the midisport will cause it to send its current
status to the control port:

  Sysex-request                         Datatype
  ------------------------------------- -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
  F0 00 01 05 7F 00 00 04 00 42 F7      Retrieves the global settings like SMPTE frame rates etc. As soon as the settings are changed using the front panel of the midisport, it immediately sends the new settings to the control port
  F0 00 01 05 7F 00 00 04 00 41 00 F7   Retrieves patch 1; this command seems to be intended to get the current edit buffer of the midisport but gets patch 1 instead
  F0 00 01 05 7F 00 00 04 00 41 01 F7   Retrieves patch 1
  F0 00 01 05 7F 00 00 04 00 41 02 F7   Retrieves patch 2
  F0 00 01 05 7F 00 00 04 00 41 03 F7   Retrieves patch 3
  F0 00 01 05 7F 00 00 04 00 41 04 F7   Retrieves patch 4
  F0 00 01 05 7F 00 00 04 00 41 05 F7   Retrieves patch 5
  F0 00 01 05 7F 00 00 04 00 41 06 F7   Retrieves patch 6
  F0 00 01 05 7F 00 00 04 00 41 07 F7   Retrieves patch 7
  F0 00 01 05 7F 00 00 04 00 41 08 F7   Retrieves patch 8

The requests can be sent to the midisport using amidi or
[http://sysexxer.sf.net](http://sysexxer.sf.net).

### Global Data Sysex

The global settings are encoded in 27 bytes of sysex data. Sending it
back to the midisport's control port will cause the midisport to behave
as specified in the sysex data. The sysex data contains no checksum
bytes.

Example:

` `

    F0 00 01 05 7F 00 00 04 00 02 00 00 00 00 03 00 00 00 00 00 00 00 00 00 00 01 F7

### Patch data Sysex

The 28 bytes of patchbay patches of the midisport look like this:

  ------------- ------------------ ---------------------------- ---------------------------- ------------------------------------------------------------------- -------------------
  Start sysex   m-audio-sysex-ID   unknown bytes (device ID?)   patch number (1 through 8)   16 data bytes, only 4 bit used (therefore the max. value is 0x0F)   end of sysex data
  F0            00 01 05           7F 00 00 04 00 01            01                           00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00                     F7
  ------------- ------------------ ---------------------------- ---------------------------- ------------------------------------------------------------------- -------------------

### Data bytes encoding

One single patch defines which connections are made between the eight
inputs and the eight outputs. This is done bitwise, encoded in 16
nibbles.

Example 1: input 1 is connected to the outputs 1 and 3. So, the binary
representation of this setting reads as 0101 which reads as 0x05 in hex.
The first data byte of the 16 bytes block therefore reads as 05. Example
2: input 1 is connected to the outputs 6,7 and 8. So, the binary
representation of this setting reads as 1110 which reads as 0x0D in hex.
The second data byte of the 16 bytes block therefore reads as 0D.

This gets performed for the remaining 7 input ports, so it leads to a
whole of 16 data bytes.

Testing Your Device
-------------------

A quick test for midi input is... ` `

    cat /dev/midi01

or */dev/midi00* if it's your first "soundcard". Hit some keys or turn
knobs on your MIDI controller and you should see some random-looking
characters on screen that coincide with your actions.

Retrieved from
"[http://alsa.opensrc.org/USBMidiDevices](http://alsa.opensrc.org/USBMidiDevices)"

[Categories](/Special:Categories "Special:Categories"):
[Howto](/Category:Howto "Category:Howto") |
[MIDI](/Category:MIDI "Category:MIDI")

