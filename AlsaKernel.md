AlsaKernel
==========

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Contents
--------

-   [1 20020808](#20020808)
-   [2 Lilo](#Lilo)
-   [3 prepkernel script](#prepkernel_script)
-   [4 See also](#See_also)

20020808
--------

Well a logicial next step after creating and using the
[AlsaBuild](/AlsaBuild "AlsaBuild") shell script is to provide a less
than 3 Mb tarball for those who do not want to download 30 plus Mb of
kernel source and ALSA CVS. This is not meant to be a binary kernel to
suit everyone but it does have some essential options already selected.
There is no guarantee or warranty so use at your own risk.

This 2.4 stable kernel is built for a PIII CPU and a ne2k-pci ethernet
card driver plus a few common garden variety eth cards as modules,
generic SCSI and just the basic soundcore module with no extra OSS audio
options. It does include a bootable devfs, builtin RTC (real time
clock), netfiltering modules to secure your audio workstation and the
EXT3 journalling file system. Check
[AlsaBuildConfig](/AlsaBuildConfig "AlsaBuildConfig") for the full story
on what is or is not included but this one definately includes the
PREEMPT low latency kernel option. The basic kernel components are...

` `

    linux-2.4.19.tar.bz2
    patch-2.4.20-pre1.bz2
    patch-2.4.20-pre1-ac1.bz2
    preempt-kernel-rml-2.4.19-rc5-ac1-1.patch

[http://alsa.opensrc.org/alsa-kernel-20020808.tgz](http://alsa.opensrc.org/alsa-kernel-20020808.tgz)
(2.8Mb)

Please add any further notes or suggestions here below. I will attempt
to keep this binary tarball uptodate whenever a new point release of the
stable kernel is made. - [Mark
Constable](/User:MarkConstable "User:MarkConstable") 20020714

Lilo
----

Here is an /etc/lilo.conf to suit the above kernel build. It relies on a
the default kernel argument of **make bzlilo** which moves /vmlinuz to
/vmlinuz.old and places the freshly built kernel image to /vmlinuz (not
in /boot/vmlinuz-"version" like various distributions). This config
presumes your boot partition is /dev/hda5 or the first logical (not
primary) partition. Comment out the "append" line as I happen to have
two el-cheapo NE20000 clone eth cards, left as an example, along with
the last 3 commented lines for a mulitboot windoze partition. - [Mark
Constable](/User:MarkConstable "User:MarkConstable") 20020713

` `

    boot=/dev/hda
    root=/dev/hda5
    compact
    install=/boot/boot.b
    map=/boot/map
    vga=normal
    delay=20
    append="ether=0,0,eth0 ether=0,0,eth1 idebus=66"

    image=/vmlinuz
    label = Linux
    read-only

    image=/vmlinuz.old
    label = Linux.old
    read-only

    #other=/dev/hda1
    # label=win98
    # table=/dev/hda

`prepkernel` script
-------------------

This small script creates links from the standard /usr/include area for
the main kernel includes files. Some distributions provide **kernel
headers** in /usr/include/linux but they become out of date with a
freshly downloaded kernel, which could also be patched, so to ensure
other applications and libraries use the current kernel headers we link
the below include directories directly into the kernel source tree. I
call this script /usr/local/sbin/prepkernel on my system and use it
after my libc6 development package is updated. Modified for kernel
version 2.4.19. - [Mark
Constable](/User:MarkConstable "User:MarkConstable") 20020805

` `

    #!/bin/sh

    cd /usr/include

    [ -d linux.old ] && rm -rf linux.old
    [ -d asm.old ] && rm -rf asm.old
    [ -d scsi.old ] && rm -rf scsi.old

    mv linux linux.old
    mv asm asm.old
    mv scsi scsi.old

    cp -R ../../usr/src/linux-2.4.19/include/linux linux
    cp -R ../../usr/src/linux-2.4.19/include/asm-i386 asm
    cp -R ../../usr/src/linux-2.4.19/include/scsi scsi

Don't use Symbolic link of header directory but copy it.

See also
--------

-   [Alsa](/Alsa "Alsa")
-   [AlsaBuild](/AlsaBuild "AlsaBuild")
-   [AlsaBuildConfig](/AlsaBuildConfig "AlsaBuildConfig")
-   [AlsaRemove](/AlsaRemove "AlsaRemove")

Retrieved from
"[http://alsa.opensrc.org/AlsaKernel](http://alsa.opensrc.org/AlsaKernel)"

[Category](/Special:Categories "Special:Categories"):
[Installation](/Category:Installation "Category:Installation")

