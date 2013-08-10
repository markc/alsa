Introduction
============

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

There are two ways of getting Linux drivers to work, you can either
compile them into the kernel or build them separately as modules. Read
the Kernel-HOWTO for details of how to compile a kernel.

You must turn on the sound support soundcore module
---------------------------------------------------

This is in the kernel. Look in the sound drivers submenu and it should
be the first option ("Sound card support", CONFIG\_SOUND). Most people
enable the module setting. That way you can load and unload the module
manually if you have multiple soundcards or if you intend to debug or
use cutting edge software which may cause your drivers to halt
sometimes. Of course it also means you have more control of your system.
Most modern distributions come with soundcore compiled as a module. You
can check this in numerous ways. The easiest way is to type.

` `

    modprobe soundcore
    lsmod | grep soundcore

If this command returns that you have this module, then you don't need
to recompile your kernel. Some Motherboards don't do a very good job of
assigning irq resources. You may want to do `cat /proc/interrupts` to
see what irq numbers are assigned to what devices. Often, irq 9 provides
the best performance for usb needs. As an example:

` `

              CPU0
     0:     387086          XT-PIC  timer
     1:       5528          XT-PIC  keyboard
     2:          0          XT-PIC  cascade
     8:     570892          XT-PIC  rtc
     9:     352520          XT-PIC  usb-uhci, eth0
    12:     130823          XT-PIC  PS/2 Mouse
    14:       9218          XT-PIC  ide0
    15:         26          XT-PIC  ide1

Retrieved from
"[http://alsa.opensrc.org/Introduction](http://alsa.opensrc.org/Introduction)"

[Category](/Special:Categories "Special:Categories"):
[Howto](/Category:Howto "Category:Howto")

