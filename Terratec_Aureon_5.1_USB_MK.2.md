Terratec Aureon 5.1 USB MK.2
============================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

The Terratec Aureon 5.1 USB MK-2 is a very interesting, entry-level
USB-sound compatible sound card.

[http://www.terratec.net/en/products/pictures/img/1923271\_b48c53c7f7.png](http://www.terratec.net/en/products/pictures/img/1923271_b48c53c7f7.png)

Contents
--------

-   [1 Discovering the hardware](#Discovering_the_hardware)
    -   [1.1 Specifications](#Specifications)
    -   [1.2 Terratec passive support for
        GNU/Linux](#Terratec_passive_support_for_GNU.2FLinux)

-   [2 Alsa configuration](#Alsa_configuration)
    -   [2.1 Software mixer](#Software_mixer)
    -   [2.2 Surround 5.1](#Surround_5.1)

-   [3 Device information](#Device_information)
    -   [3.1 cat
        /proc/bus/usb/devices](#cat_.2Fproc.2Fbus.2Fusb.2Fdevices)
    -   [3.2 cat /proc/asound/devices](#cat_.2Fproc.2Fasound.2Fdevices)
    -   [3.3 aplay -l](#aplay_-l)
    -   [3.4 Kernel-Configuration](#Kernel-Configuration)

-   [4 See also](#See_also)

Discovering the hardware
========================

Specifications
--------------

The specifications are:

-   USB 1.1 interface (USB 2.0 compatible)
-   USB audio class specification version 1.0
-   Buspowered via USB
-   Stereo line input (3,5 mm jack plug)
-   3 stereo line outputs (3,5 mm jack plug)
-   Optical S/P-DIF digital input (TOS link)
-   Optical S/P-DIF digital output (TOS link)
-   Microphone input (3,5 mm jack plug)
-   Headphone Output (3,5 mm jack plug)
-   Audio resolution: 16 bit
-   Sample rates
    -   analogue: 32, 44,1 and 48 kHz
    -   digital: 48 kHz

Terratec passive support for GNU/Linux
--------------------------------------

Terratec offers [passive support for
GNU/Linux](ftp://ftp.terratec.de/Documentation/Linux_and_Mac_OSX_Compatiblity.pdf).
Alsa fully supports this audio device, and several Alsa hackers use it.
It is a recommended choice for people needing good sound quality,
without investing in a professional sound card.

Alsa configuration
==================

Software mixer
--------------

Like other USB devices, Terratec audio devices do not have hardware
mixers. You need to create a custom [.asoundrc](/.asoundrc ".asoundrc")
file, using the [softvol](/Softvol "Softvol") plugin, to provide
software level mixing.

` `

    pcm.newdevice {
        slave.pcm       "default"
        control.name    "Softmaster"
    }

Surround 5.1
------------

Proposed `.asoundrc` file for Surround 5.1:

` `

    pcm.dmix51 {
      type dmix
      ipc_key 1024
      ipc_key_add_uid false
      ipc_perm 0666
      slave {
         pcm "hw:0,0"
         channels 6
         period_time 0
         period_size 1024
         buffer_size 8192
         rate 44100
      }
    }

    ctl.dmix51 {
      type hw
      card 0
    }

    pcm.stereo {
      type plug
      slave.pcm "dmix51"
      ttable.0.0 1
      ttable.1.1 1
    }

    pcm.!default {
      type route
      slave.pcm "dmix51"
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

    pcm.duplicate {
      type plug
      slave.pcm "dmix51"
      slave.channels 6
      route_policy duplicate
    }

Device information
==================

The following section may help Alsa hackers:

cat /proc/bus/usb/devices
-------------------------

` `

    $cat /proc/bus/usb/devices
    T:  Bus=01 Lev=03 Prnt=07 Port=02 Cnt=01 Dev#=  8 Spd=12  MxCh= 0
    D:  Ver= 1.10 Cls=00(>ifc ) Sub=00 Prot=00 MxPS=64 #Cfgs=  1
    P:  Vendor=0ccd ProdID=0028 Rev= 1.00
    S:  Product=USB Audio
    C:* #Ifs= 4 Cfg#= 1 Atr=a0 MxPwr=500mA
    I:  If#= 0 Alt= 0 #EPs= 0 Cls=01(audio) Sub=01 Prot=00 Driver=snd-usb-audio
    I:  If#= 1 Alt= 0 #EPs= 0 Cls=01(audio) Sub=02 Prot=00 Driver=snd-usb-audio
    I:  If#= 1 Alt= 1 #EPs= 1 Cls=01(audio) Sub=02 Prot=00 Driver=snd-usb-audio
    E:  Ad=01(O) Atr=09(Isoc) MxPS= 200 Ivl=1ms
    I:  If#= 1 Alt= 2 #EPs= 1 Cls=01(audio) Sub=02 Prot=00 Driver=snd-usb-audio
    E:  Ad=01(O) Atr=09(Isoc) MxPS= 600 Ivl=1ms
    I:  If#= 2 Alt= 0 #EPs= 0 Cls=01(audio) Sub=02 Prot=00 Driver=snd-usb-audio
    I:  If#= 2 Alt= 1 #EPs= 1 Cls=01(audio) Sub=02 Prot=00 Driver=snd-usb-audio
    E:  Ad=82(I) Atr=05(Isoc) MxPS= 200 Ivl=1ms
    I:  If#= 3 Alt= 0 #EPs= 1 Cls=03(HID  ) Sub=00 Prot=00 Driver=usbhid
    E:  Ad=83(I) Atr=03(Int.) MxPS=   3 Ivl=32ms

cat /proc/asound/devices
------------------------

` `

    cat /proc/asound/devices
     32: [ 1]   : control
     33:        : timer
     48: [ 1- 0]: digital audio playback
     56: [ 1- 0]: digital audio capture

aplay -l
--------

` `

    aplay -l
    **** List of PLAYBACK Hardware Devices ****
    card 1: Audio [USB Audio], device 0: USB Audio [USB Audio]
     Subdevices: 1/1
     Subdevice #0: subdevice #0

Kernel-Configuration
--------------------

I have had to **deactivate** the Option: "Enforce USB bandwidth
allocation (EXPERIMENTAL)"

See also
========

-   Product page:
    [http://www.terratec.net/en/products/Aureon\_5.1\_USB\_MK\_II\_2120.html](http://www.terratec.net/en/products/Aureon_5.1_USB_MK_II_2120.html)

Retrieved from
"[http://alsa.opensrc.org/Terratec\_Aureon\_5.1\_USB\_MK.2](http://alsa.opensrc.org/Terratec_Aureon_5.1_USB_MK.2)"

[Category](/Special:Categories "Special:Categories"): [Sound
cards](/Category:Sound_cards "Category:Sound cards")

