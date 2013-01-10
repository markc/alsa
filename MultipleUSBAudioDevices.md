MultipleUSBAudioDevices
=======================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Contents
--------

-   [1 Introduction](#Introduction)
-   [2 snd-usb-audio](#snd-usb-audio)
-   [3 Questions](#Questions)
-   [4 See also](#See_also)

Introduction
------------

To introduce the problem, USB devices are typically hot-pluggable
external devices. Linux (the kernel) assigns a number for each device in
the system at boot time, or later when the device is plugged into the
system. This number (the minor device number) is used internally by
several system (kernel) functions, but the user applications usually
need a pseudo file, a device node, to open and access the device in a
UNIX way. These files, residing usually in the `/dev` directory, contain
the major and minor numbers that identify a device class and instance of
each device. The problem with hot-pluggable devices is that changing the
order used to plug the device, or the slot where it is attached you are
pointing another `/dev` node to that device. And therefore you need to
tell to your application that your music should be delivered to
`/dev/midi02` instead of `/dev/midi01` as it was until yesterday. This
problem is not limited to MIDI/Audio devices, but also to video-cameras,
printers, flash memory disks, etc.

ALSA uses internal identifiers such as **hw:1,0** or **64:1** to
identify devices to the applications, instead of using the device nodes,
but the problem remains: you want to keep a persistent identifier for
each device to configure your applications, but it changes everyday
depending on the plugging order and the socket used for your USB Audio
and MIDI devices.

I think that a general solution for Linux, not only for ALSA, is *udev*
using a 2.6 kernel and hotplug. But I didn't test it by myself yet, and
don't know how well it fits with ALSA. You can find more about *udev*
here:
[http://kernel.org/pub/linux/utils/kernel/hotplug/udev.html](http://kernel.org/pub/linux/utils/kernel/hotplug/udev.html)

snd-usb-audio
-------------

Nevertheless, if you use a 2.4 kernel or can't use `udev` yet, ALSA's
`snd-usb-audio` module has a feature that can solve your problems. As
root, try this command:

` `

    # modinfo snd-usb-audio
    filename:    /lib/modules/2.4.23/kernel/sound/usb/snd-usb-audio.o
    description: "USB Audio"
    author:      "Takashi Iwai <tiwai@suse.de>"
    license:     "GPL"
    parm:        index int array (min = 1, max = 8), description "Index value for the USB audio adapter."
    parm:        id string array (min = 1, max = 8), description "ID string for the USB audio adapter."
    parm:        enable int array (min = 1, max = 8), description "Enable USB audio adapter."
    parm:        vid int array (min = 1, max = 8), description "Vendor ID for the USB audio device."
    parm:        pid int array (min = 1, max = 8), description "Product ID for the USB audio device."
    parm:        nrpacks int, description "Max. number of packets per URB."
    parm:        async_unlink int, description "Use async unlink mode."

This module has several options, listed in lines starting with `parm:`.
Index is a common option for every ALSA module, and it means the "card"
order for your device. This is one of the key features we need. The
other two are the `vid` and `pid`, meaning the Vendor and Product
identifiers that every USB device shows as descriptor attributes. You
can obtain the numbers using the following command:

` `

    # lsusb
    Bus 001 Device 004: ID 0763:1110 Midiman
    Bus 001 Device 003: ID 0582:0005 Roland Corp. Edirol UM-2 MIDI Adapter

The number 0763 is the Vendor ID for Midiman, and 0582 is the Vendor ID
for Roland. The numbers following the colon are the Product Ids for the
Midisport2x2 (1110) and the UM-2 (0005) respectively. Be warned that the
Midisport has a different product id before loading the firmware. We
need the number after the renumeration, when it has the firmware loaded
and running.

The next step is to assign an index number to every device driven by
ALSA, not only the USB ones. This can be done on `/etc/modules.conf`, or
`/etc/modprobe.conf`, depending on your Linux vendor and kernel version.

Suppose that we have two USB devices (Midisport2x2 and UM-2) one PCI
card and we need also the [virmidi](/Virmidi "Virmidi") driver. The
*card* order will be the following:

1.  PCI card
2.  USB Midisport2x2
3.  USB UM-2
4.  Virmidi

The relevant lines in your `/etc/modules.conf` will be the following:

` `

    alias snd-card-0 snd-via82xx
    alias snd-card-1 snd-usb-audio
    alias snd-card-2 snd-usb-audio
    alias snd-card-3 snd-virmidi
    options snd cards_limit=4
    options snd-via82xx index=0
    options snd-usb-audio index=1,2 vid=0x0763,0x0582 pid=0x1110,0x0005
    options snd-virmidi index=3 midi_devs=2

snd-[via82xx](?title=Via82xx&action=edit&redlink=1 "Via82xx (page does not exist)")
is the ALSA module containing the driver for the PCI card. Assign it the
`index=0` and it will be the first ALSA card in the system. That means:
the PCM and raw MIDI devices will be named `hw:0,N`, and the sequencer
client would have the number `64`, but in this case, my PCI card is a
VIA VT8233/A/8235 without MIDI, so the sequencer client number 64 will
be inexistent/unused.

There are two cards using the module
snd-[usb-audio](/Usb-audio "Usb-audio"), and it has the assigned indexes
1 and 2. Notice the `vid` and `pid` parameters with the arguments for
the Midisport2x2 and the UM-2. The three parameters are arrays, having
up to eight comma separated elements. There should be the same number of
elements for all parameters. Being the cards 1 and 2, the Midisport2x2
will be known as `hw:1` for the raw MIDI interface, and the UM-2 as
`hw:2`. The sequencer client numbers will be 72 for the Midisport2x2 and
80 for the UM-2. These numbers will be the same in despite of the plug
order, or the USB socket used. Even if you only plug the UM-2 but not
the Midisport, the sequencer client for it will be 80 and the raw MIDI
interface will be `hw:2`.

NOTE: If you are using gentoo, you will need to run `modules-update`
after modifying the files in `/etc/modules.d`.

Finally, we assign the persistent index 3 to the very useful
[virmidi](/Virmidi "Virmidi") (snd-virmidi) card. Use the following
commands to verify your configuration:

` `

    # amidi -l
    Device    Name
    hw:1,0,0  Midisport 2x2 MIDI 1
    hw:1,0,1  Midisport 2x2 MIDI 2
    hw:2,0,0  UM-2 MIDI 1
    hw:2,0,1  UM-2 MIDI 2
    hw:3,0    Virtual Raw MIDI (16 subdevices)
    hw:3,1    Virtual Raw MIDI (16 subdevices)

    # aconnect -ol
    client 72: 'Midisport 2x2' [type=kernel]
        0 'Midisport 2x2 MIDI 1'
        1 'Midisport 2x2 MIDI 2'
    client 80: 'UM-2' [type=kernel]
        0 'UM-2 MIDI 1     '
        1 'UM-2 MIDI 2     '
    client 88: 'Virtual Raw MIDI 3-0' [type=kernel]
        0 'VirMIDI 3-0     '
    client 89: 'Virtual Raw MIDI 3-1' [type=kernel]
        0 'VirMIDI 3-1     '

Questions
---------

-   How could index order be specified when using two or more exactly
    the same devices (hence, with same pid and vid)?

Answer: with [Udev](/Udev "Udev")

See also
--------

-   [Hotplugging USB audio devices
    (Howto)](/Hotplugging_USB_audio_devices_(Howto) "Hotplugging USB audio devices (Howto)")
-   [MultipleCards](/MultipleCards "MultipleCards")
-   [Udev](/Udev "Udev")

Retrieved from
"[http://alsa.opensrc.org/MultipleUSBAudioDevices](http://alsa.opensrc.org/MultipleUSBAudioDevices)"

[Category](/Special:Categories "Special:Categories"):
[Howto](/Category:Howto "Category:Howto")

