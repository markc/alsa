AlsaBuild
=========

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Contents
--------

-   [1 20040307](#20040307)
-   [2 20030224](#20030224)
-   [3 20020808](#20020808)
-   [4 Suggestions, improvements,
    comments ?](#Suggestions.2C_improvements.2C_comments_.3F)
-   [5 AlsaBuild](#AlsaBuild)
-   [6 See also](#See_also)

20040307
--------

This script is now superceded by [aabuild](/Aabuild "Aabuild").

20030224
--------

This script is well and truly out of date and only remains here as a
guide. If you try this script out then you will have to look around for
current kernels and patches, and if you have any success then please
consider updating this script and adding your own attribution.

20020808
--------

This script builds a late model preemptable 2.4 kernel with ALSA direct
from it's CVS repository. Here is the AlsaBuildConfig kernel config file
for building the AlsaKernel tarball and here is the associated
AlsaRemove script, also, AlsaModules may be useful. First time users may
want to put comments "\#" and and "exit" early on in the script to see
how it works in your case. - MarkConstable 20020803

Suggestions, improvements, comments ?
-------------------------------------

**2.4.20-pre1-ac1** The preempt patch probably only just applies against
this patched kernel by using fuzzy logic but there are no rejects and I
am running on it right now and my ALSA/SBlive plays oggs. That is the
limit of my testing though. There are a bunch of ugly warnings when
depmod gets called after build the non-ALSA kernel modules and AlsaBuild
will stop at that point so the easiest remedy is to manually cd into the
/usr/src/alsa dir and simply type "make" to finish off the build...
perhaps consider rebooting at this stage (I did so) before continuing
with the ALSA build part.

Previous note...

Some people might need this kludge when doing an ALSA make: when the
stock CVS Makefile invokes configure it then checks for the current
running kernel version and looks up the /lib/modules/\`uname -r\`/build
link which will point to the kernel source of the current running
kernel, not the new one you may have just compiled. It used to work up
till 2.4.19 because the kernel source was always placed in
/usr/src/linux but with 2.4.19 the kernel source unwinds into
/usr/src/linux-2.4.19 so this build link problem just got real. The
solution is to either reboot after building the kernel and before
proceeding to build ALSA or stop the build just before make'ing ALSA and
manually diddle with that build link in /lib/modules/2.4.\*/build and
point it to the /usr/src/linux-2.4.19 source dir. - [Mark
Constable](/User:MarkConstable "User:MarkConstable") 20020805

AlsaBuild
---------

` `

    #!/bin/sh
    #
    # AlsaBuild v0.1.2 8-Aug-2002 alsa@opensrc.org
    #
    # Copyright: Public Domain
    # License: GNU GPL http://www.gnu.org/licenses/gpl.html
    # Homepage: http://alsa.opensrc.org/?AlsaBuild
    # Please send any modifications or suggestions to alsa@opensrc.org
    #
    set -e
    set -x

    MIRROR=www.kernel.org
    SRCDIR=/usr/src
    CVSDIR=/usr/src/cvs
    KERNEL=linux-2.4.19.tar.bz2
    PATCH1=patch-2.4.20-pre1.bz2
    PATCH2=patch-2.4.20-pre1-ac1.bz2
    PATCH3=preempt-kernel-rml-2.4.19-rc5-ac1-1.patch

    [ -d $SCRDIR ] || mkdir -p $SCRDIR
    [ -d $CVSDIR/alsa ] || mkdir -p $CVSDIR/alsa

    cd $SRCDIR

    if [ ! -f $KERNEL ]; then
        wget http://$MIRROR/pub/linux/kernel/v2.4/$KERNEL
    fi

    if [ ! -f ${PATCH1%.bz2} ]; then
        wget http://$MIRROR/pub/linux/kernel/v2.4/testing/$PATCH1
        bunzip2 $PATCH1
    fi

    if [ ! -f ${PATCH2%.bz2} ]; then
        wget http://$MIRROR/pub/linux/kernel/people/alan/linux-2.4/2.4.20/$PATCH2
        bunzip2 $PATCH2
    fi

    if [ ! -f ${PATCH3} ]; then
        wget http://$MIRROR/pub/linux/kernel/people/rml/preempt-kernel/v2.4/$PATCH3
    fi

    if [ -f ${KERNEL%.tar.bz2}/.config ]; then
        cp ${KERNEL%.tar.bz2}/.config config
    fi

    rm -rf ${KERNEL%.tar.bz2}

    tar xjf $KERNEL

    cd $SRCDIR/${KERNEL%.tar.bz2}

    patch -p1 < ../${PATCH1%.bz2}
    patch -p1 < ../${PATCH2%.bz2}
    patch -p1 < ../$PATCH3

    cd $CVSDIR/alsa

    if [ -d ./CVS ]; then
        cvs up -P -d
    else
        echo "Just hit the enter key at the login prompt"
        cvs -d ':pserver:anonymous@cvs.alsa-project.org:/cvsroot/alsa' login
        cvs -z3 -d ':pserver:anonymous@cvs.alsa-project.org:/cvsroot/alsa' co -P .
    fi

    cd $SRCDIR

    rm -rf alsa
    mkdir alsa
    cp -a $CVSDIR/alsa .

    #exit # uncomment this until the above works smoothly

    cd $SRCDIR/${KERNEL%.tar.bz2}

    if [ -f ../config ]; then
        cp ../config .config
        make oldconfig
        # substitute oldconfig for config or menuconfig or xconfig
        # if you need to add more modules for your hardware
    else
        #make config
        #make menuconfig
        make xconfig
    fi

    time make dep clean bzlilo modules modules_install

    cd $SRCDIR/alsa
    time make

    # rm -rf /vmlinuz /System.map /lib/modules/2.4.20-pre1-ac1 # before a 2nd build attempt
    # tar czf alsa-kernel-`date +%Y%m%d`.tgz /vmlinuz /System.map /lib/modules/2.4.20-pre1-ac1

See also
--------

[AlsaBuild2.6](/AlsaBuild2.6 "AlsaBuild2.6")

Retrieved from
"[http://alsa.opensrc.org/AlsaBuild](http://alsa.opensrc.org/AlsaBuild)"

[Category](/Special:Categories "Special:Categories"):
[Installation](/Category:Installation "Category:Installation")

