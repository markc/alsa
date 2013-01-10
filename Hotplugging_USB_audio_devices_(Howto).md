Hotplugging USB audio devices (Howto)
=====================================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

This article describes how to have ALSA recognize a USB audio device as
the default device when it is plugged in using hotplug.

The procedure outlined here does not replace [the virtual device FAQ
entry](/FAQ#How_can_I_create_a_virtual_device_that_can_switch_between_one_of_several_different_soundcards_during_playback_.28without_interruption.29.3F "FAQ")
(unfortunately the FAQ entry only states "unknown"). The main
shortcoming is that most probably, you will need to restart all sound
applications so that they open the new default device.

Contents
--------

-   [1 Infrastructure for switching
    cards](#Infrastructure_for_switching_cards)
    -   [1.1 An asound.conf file for each
        setup](#An_asound.conf_file_for_each_setup)
    -   [1.2 A script to switch between
        setups](#A_script_to_switch_between_setups)

-   [2 Get Hotplug to switch setups](#Get_Hotplug_to_switch_setups)
    -   [2.1 Create a usermap file](#Create_a_usermap_file)
    -   [2.2 The hotplug script](#The_hotplug_script)

-   [3 See also](#See_also)

Infrastructure for switching cards
----------------------------------

### An asound.conf file for each setup

I have an Intel and a USB Extigy sound card. I created two different
versions of /etc/asound.conf and placed them in /etc/alsa/ as
asound.intel and asound.extigy respectively:

`/etc/alsa/asound.intel`: ` `

       # CARD DEFINITIONS
       pcm.intel       { type hw; card I82801DBICH4 }
       ctl.intel       { type hw; card I82801DBICH4 }
       
       pcm.intelModem  { type hw; card Modem }
       ctl.intelModem  { type hw; card Modem }
       
       pcm.extigy      { type hw; card Extigy; }
       ctl.extigy      { type hw; card Extigy; }
       
       pcm.!default pcm.intel
       ctl.!default ctl.intel

`/etc/alsa/asound.extigy`: ` `

       # CARD DEFINITIONS
       pcm.intel       { type hw; card I82801DBICH4 }
       ctl.intel       { type hw; card I82801DBICH4 }
       
       pcm.intelModem  { type hw; card Modem }
       ctl.intelModem  { type hw; card Modem }
       
       pcm.extigy      { type hw; card Extigy; }
       ctl.extigy      { type hw; card Extigy; }
       
       pcm.!default pcm.extigy
       ctl.!default ctl.extigy

### A script to switch between setups

I wrote a small script that creates a link from /etc/asound.conf to
/etc/alsa/asound.NAME

`/usr/local/sbin/alsaswitch`: ` `

       #!/bin/bash
       
       usage(){
               echo usage: `basename $0` `ls /etc/alsa/ -1 | sed -e 's:/etc/alsa/::g' -e 's/asound.//g'`
       }
       
       if [ -n $1 ] && [ -e /etc/alsa/asound.$1 ];
       then
               ln -sf /etc/alsa/asound.$1 /etc/asound.conf
       else
               usage
       fi

If you don't want things to happen automatically, stop here. Whenever
you have connected your device, just login as root and do alsaswitch
extigy or whatever extension you gave to the file, but a quicker way of
manually switching is to use `asoundconf-gtk` or:

` `

       asoundconf list
       asoundconf set-default-card name_of_card

Get Hotplug to switch setups
----------------------------

Hotplug has a collection of usermap files. These maps identify a
specific device (by vendor id, device id, etc.) and instruct hotplug to
execute a specific script that sets up the device. The usermaps can be
created per device. In this example, I use
/etc/hotplug/usb/extigy.usermap for the usermap and
/etc/hotplug/usb/extigy for the script that it executes.

### Create a usermap file

Figure out the vendor ID and product ID of your soundcard. You can
either use lsusb -v or search for them on the web. For my SB Extigy,
these are 041e and 3000 respectively.

The usermap file contains several fields. The first one is the name of
the script, the second one is a mask that enables the match criteria. We
have the produce and vendor id, so we use those:

`/etc/hotplug/usb/extigy.usermap`: ` `

    # usb module
    # |       match_flags
    # |       |       idVendor
    # |       |       |       idProduct
    # |       |       |       |       bcdDevice_lo
    # |       |       |       |       |       bcdDevice_hi
    # |       |       |       |       |       |       bDeviceClass
    # |       |       |       |       |       |       |     bDeviceSubClass
    # |       |       |       |       |       |       |     |     bDeviceProtocol
    # |       |       |       |       |       |       |     |     |     bInterfaceClass
    # |       |       |       |       |       |       |     |     |     |     bInterfaceSubClass
    # |       |       |       |       |       |       |     |     |     |     |     bInterfaceProtocol
    # |       |       |       |       |       |       |     |     |     |     |     |     driver_info
      extigy  0x0003  0x041e  0x3000  0x0000  0x0000  0x00  0x00  0x00  0x00  0x00  0x00  0x00000000

Now with this file, I got multiple calls of the script, presumably
because the card has several subdevices. I restricted my script to apply
only to the control interface (bInterfaceSubClass 1) so that I get one
call only, YMMV.

`/etc/hotplug/usb/extigy.usermap`: ` `

    # usb module
    # |       match_flags
    # |       |       idVendor
    # |       |       |       idProduct
    # |       |       |       |       bcdDevice_lo
    # |       |       |       |       |       bcdDevice_hi
    # |       |       |       |       |       |       bDeviceClass
    # |       |       |       |       |       |       |     bDeviceSubClass
    # |       |       |       |       |       |       |     |     bDeviceProtocol
    # |       |       |       |       |       |       |     |     |     bInterfaceClass
    # |       |       |       |       |       |       |     |     |     |     bInterfaceSubClass
    # |       |       |       |       |       |       |     |     |     |     |     bInterfaceProtocol
    # |       |       |       |       |       |       |     |     |     |     |     |     driver_info
      extigy  0x0003  0x041e  0x3000  0x0000  0x0000  0x00  0x00  0x00  0x00  0x01  0x00  0x00000000

### The hotplug script

This is a simple shell script. REMOVER is a variable passed to the
script from hotplug which identifies the location of a script that is
executed on removal. Unfortunately, the usb.agent script does not seem
to work correctly. This is a known
[bug](http://sourceforge.net/tracker/index.php?func=detail&aid=1086458&group_id=17679&atid=117679)
and you can find a workaround in the bug report.

`/etc/hotplug/usb/extigy`: ` `

       #!/bin/bash
       #determine which configuration is active, note that removal does not seem to work
       echo -e "/usr/local/sbin/alsaswitch `ls -lFA /etc/asound.conf \
                                            | sed 's:.*/etc/alsa/asound.\([^ ]*\)$:\1:'`" > $REMOVER
       chmod a+x $REMOVER
       /usr/local/sbin/alsaswitch extigy;

Now all you need is to plug in your device. If you have coldplugging
installed, this also works at boot time.

See also
--------

-   [MultipleCards](/MultipleCards "MultipleCards")
-   [MultipleUSBAudioDevices](/MultipleUSBAudioDevices "MultipleUSBAudioDevices")
-   [Udev](/Udev "Udev")

Retrieved from
"[http://alsa.opensrc.org/Hotplugging\_USB\_audio\_devices\_(Howto)](http://alsa.opensrc.org/Hotplugging_USB_audio_devices_(Howto))"

[Category](/Special:Categories "Special:Categories"):
[Howto](/Category:Howto "Category:Howto")

