Edirol UM-550 and UM-880
========================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Contents
--------

-   [1 Edirol UM-550/UM-880 with 2.6
    kernel](#Edirol_UM-550.2FUM-880_with_2.6_kernel)
    -   [1.1 with OSS](#with_OSS)
    -   [1.2 with ALSA:](#with_ALSA:)

-   [2 Which port is which?](#Which_port_is_which.3F)

Edirol UM-550/UM-880 with 2.6 kernel
------------------------------------

To get the Edirol UM-550 or UM-880 working with a 2.6 kernel:

### with OSS

1.  compile your kernel with CONFIG\_USB\_MIDI
2.  switch the UM-550 or UM-880 into "ordinary driver mode", following
    the instructions in the manual.
3.  note that this will not work with Rosegarden and possibly other
    fairly recent applications.

### with ALSA:

1.  compile your kernel without CONFIG\_USB\_MIDI (important)
2.  compile your kernel with CONFIG\_SND\_USB\_AUDIO
3.  switch the UM-550 or UM-880 into "FPT driver mode", following the
    instructions in the manual.
4.  this is the preferred method, as OSS is deprecated.

There is no difference in functionality between the ordinary and FPT
drivers in the hardware, this is only related to proper recognition of
the device by the OS.

In both cases, you will see obvious signs of success in
/var/log/messages or dmesg if you set things up right. Also, for the
ALSA driver, you will see the device with 'amidi -l'. If the drivers are
compiled as modules, you need to take the normal steps for loading them
into your kernel (e.g. modprobe).

Which port is which?
--------------------

Once the device has been detected by the system, you will get 6 ALSA
MIDI ports (for the UM-550, 9 for the UM-880), the last one of which is
the device's control port, used to send control information to the
device (such as patch change messages, for instance ; this control ports
prevents conflicts with other MIDI devices). The other ports correspond
to the MIDI inputs and outpus on the device, but numbered from 0 instead
of 1, meaning that ALSA port number 0 corresponds to physical port
number 1.

To play a MIDI note from the computer to an instrument connected on
OUTPUT 2 on you device, send the note to "UM-xx0 Port 1" and check that
you have patched INPUT 2 to OUTPUT 2 with the MIDI/USB button lit (which
means that the input will come from USB). You can actually send the note
to any port n, provided that you patch INPUT (n+1) to OUTPUT 2 (again,
with the MIDI/USB button lit).

Also note that you cannot patch USB INPUT 2 to OUTPUT 2 as well as MIDI
INPUT 2 to OUTPUT 2 at the same time, but you could patch USB INPUT 3 to
OUTPUT 2 and MIDI INPUT 2 to OUTPUT 2 at the same time. This is
apparently a limitation of the hardware, and not specific to ALSA or
Linux.

Retrieved from
"[http://alsa.opensrc.org/Edirol\_UM-550\_and\_UM-880](http://alsa.opensrc.org/Edirol_UM-550_and_UM-880)"

[Category](/Special:Categories "Special:Categories"): [ALSA
modules](/Category:ALSA_modules "Category:ALSA modules")

