Usb-usx2y
=========

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Contents
--------

-   [1 Getting Tascam soundcards to work with
    ALSA](#Getting_Tascam_soundcards_to_work_with_ALSA)
-   [2 MIDI support](#MIDI_support)
-   [3 Audio support](#Audio_support)
-   [4 Bugs](#Bugs)
-   [5 Comments](#Comments)
-   [6 See also](#See_also)

Getting Tascam soundcards to work with ALSA
-------------------------------------------

The new Tascam soundcards now have ALSA drivers, thanks to the work done
by Martin Langer [[1]](http://langerland.de/linux/usx2y/). You will need
a recent kernels (\>= 2.6.5 ?) have the usx2y driver. You will also need
to have the and the
[alsa-firmware](?title=Alsa-firmware&action=edit&redlink=1 "Alsa-firmware (page does not exist)")
package. The most recent version of the driver are available in the
[alsa-driver](?title=Alsa-driver&action=edit&redlink=1 "Alsa-driver (page does not exist)")
package. You will also need the hotplug scripts and the `usx2yloader`
utility, which are found in alsa-firmware. The hotplug scripts execute
the following at "plug" time:

` `

    modprobe snd-usb-usx2y
    /sbin/fxload -s ${prefix}/share/alsa/firmware/usx2yloader/tascam_loader.ihx \
            -I ${prefix}/share/alsa/firmware/usx2yloader/us122fw.ihx \
            -D /proc/bus/usb/001/002

You will still need to manually run :

` `

    usx2yloader

On debian, the cards work with current kernel-image 2.6.10 along with:

-   firmware (`${prefix}/share/alsa/firmware/usx2yloader/`)
-   loader (`${prefix}/bin/usx2yloader`)
-   hotplug (`/etc/hotplug/usb/tascam_{fpga,fw,fw.usermap}`)

MIDI support
------------

Midi support is provided by the `usb-audio` module.

Audio support
-------------

The `usb-usx2y` module is in charge of the audio. Note there is no
software mixer. The following is an example for `.asoundrc` file:

` `

    pcm.us122 {
        type hw;
        card 3;
    }                                                                                                  
    pcm.usx {
        type plug;
        slave.pcm us122;
    }

Bugs
----

Kernel version must be \>=2.6.1 (otherwise audio would not work at all,
and trying to remove the module would freeze the machine).
[MIDI](/MIDI "MIDI") seem to work ok (provided snd-seq is loaded). Right
now, still a few bugs, where the sync is lost:

` `

    ALSA /usr/src/modules/alsa-driver/usb/usx2y/usbusx2yaudio.c:363: play urb->status = -63

The card does not seem to work well when plugged to an ohci usb bus.

Comments
--------

I could not have [jack](/Jack "Jack") working using directly the alsa
drivers. Instead, jack worked in [OSS](/OSS "OSS") mode, playback only
with a 128 long buffer. Trying to have jack in alsa mode give the
following error, and jackd crashes soon after:

` `

    Mar 10 11:53:58 localhost kernel: -28
    Mar 10 11:53:58 localhost kernel: Sequence Error!(ep=10;nuc=1,frame=106)
    Mar 10 11:53:58 localhost kernel: Sequence Error!(ep=8;nuc=0,frame=106)

See also
--------

-   [Tascam US-122](/Tascam_US-122 "Tascam US-122") - here installed on
    Slackware 10.2 with a 2.6.13 kernel
-   [Tascam US-224](/Tascam_US-224 "Tascam US-224")

Retrieved from
"[http://alsa.opensrc.org/Usb-usx2y](http://alsa.opensrc.org/Usb-usx2y)"

[Category](/Special:Categories "Special:Categories"): [ALSA
modules](/Category:ALSA_modules "Category:ALSA modules")

