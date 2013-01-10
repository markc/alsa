AlsaRemove
==========

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

` `

    #!/bin/sh
    #
    # AlsaRemove v0.0.2 21-Mar-2002 alsa@opensrc.org
    #
    # Copyright: Public Domain
    # License: GNU GPL http://www.gnu.org/licenses/gpl.html
    # Homepage: http://alsa.opensrc.org/?AlsaRemove
    # Readme: remove all ALSA components from an AlsaBuild install
    set -x

    rm -rf /usr/include/alsa
    rm -rf /lib/modules/`uname -r`/kernel/sound/*
    rm -rf /usr/share/alsa/*

    rm /usr/lib/libasound*
    rm /usr/share/aclocal/alsa.m4

    rm /usr/sbin/alsactl
    rm /usr/share/man/man1/alsactl.1
    rm /usr/bin/alsamixer
    rm /usr/share/man/man1/alsamixer.1
    rm /usr/bin/amixer
    rm /usr/share/man/man1/amixer.1
    rm /usr/bin/aplay
    rm /usr/share/man/man1/aplay.1
    rm /usr/share/man/man1/arecord.1
    rm /usr/bin/aconnect
    rm /usr/share/man/man1/aconnect.1
    rm /usr/bin/aseqnet
    rm /usr/share/man/man1/aseqnet.1

See also
--------

-   [ALSA](/ALSA "ALSA")
-   [AlsaBuild](/AlsaBuild "AlsaBuild")
-   [AlsaBuildConfig](/AlsaBuildConfig "AlsaBuildConfig")
-   [AlsaKernel](/AlsaKernel "AlsaKernel")

Retrieved from
"[http://alsa.opensrc.org/AlsaRemove](http://alsa.opensrc.org/AlsaRemove)"

[Category](/Special:Categories "Special:Categories"):
[Installation](/Category:Installation "Category:Installation")

