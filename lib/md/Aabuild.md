Aabuild
=======

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

This is a bash shell script to build and install the latest ALSA from
the Mercury (HG) repositories. The old aabuild script is left below to
provide some possible clues when dealing with a kernel and jack.

` `

    #!/bin/bash
    # aabuild v0.1.0 20070926 markc@renta.net GPL
    # http://alsa.opensrc.org/aabuild

    SRCDIR=$(pwd)

    function fetch_all
    {
      rsync -avz --delete --exclude=.hg* rsync://alsa.alsa-project.org/hg alsa
    }

    function build_all
    {
      for i in driver lib plugins utils tools firmware oss; do
        cd $SRCDIR/alsa/alsa-$i && ./hgcompile
      done
    }

    function install_all
    {
      for i in driver lib plugins utils tools firmware oss; do
        cd $SRCDIR/alsa/alsa-$i && make install
      done
      # cd $SRCDIR/alsa/alsa-python && ./setup.py
    }

    #fetch_all
    #build_all
    #install_all

old aabuild
-----------

A Bash shell script to build the latest 2.6 kernel along with ALSA and
Jack from CVS. To use; copy everything including the "\#!/bin/sh" line
down to "\# The End" as PLAIN TEXT, perhaps by dragging your mouse,
paste into a local editor and save to a file called aabuild in
*/usr/src* (suggestions only).

` `

    chmod +x aabuild ; aabuild

*Feedback and edits are most welcome.*

**2005-05-01** Started working on this script again. I can't fully test
this because I have a 64bit system so the realtime-patch does not work
for me. If anyone tries this out please update it for others to use.
Uncomment the process options at the bottom of the script to activate
the various stages.

` `

    #!/bin/sh
    #
    # aabuild v2.6.12-rc2 2005-04-12 markc@renta.net
    #
    # A bash shell script to build a 2.6 linux kernel with the latest ALSA
    # drivers, library and tools from the official ALSA CVS repository. It
    # depends on lynx, wget, lilo/grub, cvs, patch, make and of course gcc.
    #
    # Copyright : Mark Constable <markc@renta.net>
    # License   : http://www.gnu.org/licenses/gpl.html
    # Homepage  : http://alsa.opensrc.org/index.php?page=aabuild

    #set -e # uncomment to exit script on any errors
    #set -x # uncomment to show a trace of execution

    SRCDIR=/usr/src
    CVSDIR=/usr/src/cvs

    # Please select your local mirror from http://www.kernel.org/mirrors/

    KVERSION=2.6.12-rc2

    KERNEL=http://www.kernel.org/pub/linux/kernel/v2.6/linux-2.6.11.tar.bz2
    RC_PATCH=http://www.kernel.org/pub/linux/kernel/v2.6/testing/patch-2.6.12-rc2.bz2
    RT_PATCH=http://people.redhat.com/mingo/realtime-preempt/realtime-preempt-2.6.12-rc2-RT-V0.7.45-01
    SQUASHFS=http://optusnet.dl.sourceforge.net/sourceforge/squashfs/squashfs2.1-r2.tar.gz

    [ -d $SRCDIR/alsa ] || mkdir -p $SRCDIR/alsa
    [ -d $SRCDIR/jack ] || mkdir -p $SRCDIR/jack

    [ -d $CVSDIR/alsa ] || mkdir -p $CVSDIR/alsa
    [ -d $CVSDIR/jack ] || mkdir -p $CVSDIR/jack

    # ---- setup ------------------------------------------------------------

    setup_kernel()
    {
        cd $SRCDIR
        if [ ! -f $(basename $KERNEL) ]; then
            wget $KERNEL
        fi
        [ -f linux/.config ] && cp linux/.config aabuild-config
        rm -f linux
        rm -rf $(basename $KERNEL|sed 's/.tar.bz2//')
        tar xjf $(basename $KERNEL)
        ln -s $(basename $KERNEL|sed 's/.tar.bz2//') linux
        [ -f aabuild-config ] && cp aabuild-config linux/.config
    }

    setup_rcpatch()
    {
        cd $SRCDIR
        if [ "x$RC_PATCH" != "x" ]; then
            if [ ! -f $(basename $RC_PATCH) ]; then
                wget $RC_PATCH
            fi
            cd linux
            cat ../$(basename $RC_PATCH) | bunzip2 | patch -p1
        fi
    }

    setup_rtpatch()
    {
        cd $SRCDIR
        if [ "x$RT_PATCH" != "x" ]; then
            if [ ! -f $(basename $RT_PATCH) ]; then
                wget $RT_PATCH
            fi
            cd linux
            cat ../$(basename $RT_PATCH) | patch -p1
        fi
    }

    setup_alsa()
    {
        cd $CVSDIR/alsa
        if [ ! -d ./CVS ]; then
            echo "Just hit the enter key at the login prompt"
            cvs -d ':pserver:anonymous@cvs.alsa-project.org:/cvsroot/alsa' login
            cvs -z3 -d ':pserver:anonymous@cvs.alsa-project.org:/cvsroot/alsa' co -P .
        else
            [ "x$(find -type d -name CVS -cmin -720)" = "x" ] && cvs up -P -d
        fi
        cd $SRCDIR
        rm -rf alsa/*
        cp -a $CVSDIR/alsa/* alsa
    }

    setup_jack()
    {
        cd $CVSDIR/jack
        if [ ! -d ./CVS ]; then
            echo "Just hit the enter key at the login prompt"
            cvs -d ':pserver:anonymous@cvs.alsa-project.org:/cvsroot/jackit' login
            cvs -z3 -d ':pserver:anonymous@cvs.alsa-project.org:/cvsroot/jackit' co -P .
        else
            [ "x$(find -type d -name CVS -cmin -720)" = "x" ] && cvs up -P -d
        fi
        cd $SRCDIR
        rm -rf jack/*
        cp -a $CVSDIR/jack/* jack
    }

    setup_squashfs()
    {
        cd $SRCDIR
        if [ "x$SQUASHFS" != "x" ]; then
            if [ ! -f $(basename $SQUASHFS) ]; then
                wget $SQUASHFS
            fi
            tar xzf $(basename $SQUASHFS)
            cd linux
            cat ../$(basename $SQUASHFS|sed 's/.tar.gz//')/linux-2.6.9/squashfs2.1-patch | patch -p1
        fi
    }

    # ---- build ------------------------------------------------------------

    build_kernel()
    {
        cd $SRCDIR/linux
        if [ -f .config ]; then
            make oldconfig
        else
            make xconfig # or menuconfig
        fi
        make
    }

    build_alsa()
    {
        cd $SRCDIR/alsa
        make
        for i in alsa-tools alsa-plugins alsa-oss alsa-firmware; do
            cd $SRCDIR/alsa/$i
            ./cvscompile
        done
    }

    build_jack()
    {
        cd $SRCDIR/jack/jack
        ./autogen.sh
        ./configure
        make
    }

    build_squashfs()
    {
        cd $SRCDIR/$(basename $SQUASHFS|sed 's/.tar.gz//')/squashfs-tools
        make
    }

    # ---- install ----------------------------------------------------------

    install_kernel()
    {
        cd $SRCDIR/linux
        make install modules_install
        mkinitrd /boot/initrd-$KVERSION $KVERSION # if using modules to boot
    }

    install_alsa()
    {
    #    cd $SRCDIR/alsa
    }

    install_jack()
    {
        cd $SRCDIR/jack/jack
        make install
    }

    install_squashfs()
    {
        cd $SRCDIR/$(basename $SQUASHFS)/squashfs-tools
        make install
    }

    make_tarball()
    {
        cd $SRCDIR
        [ -f kernel-$KVERSION.tar.bz2 ] && rm kernel-$KVERSION.tar.bz2
        tar cjpf kernel-$KVERSION.tar.bz2 \
         /boot/initrd-$KVERSION /boot/initrd \
         /boot/vmlinuz-$KVERSION /boot/vmlinuz \
         /boot/System.map-$KVERSION /boot/System.map \
         /lib/modules/$KVERSION
    }

    # ---- support ----------------------------------------------------------

    setup_all()
    {
        setup_kernel
        setup_rcpatch
        setup_rtpatch
        setup_alsa
        setup_jack
        setup_squashfs
    }

    build_all()
    {
        build_kernel
        build_alsa
        build_jack
        build_squashfs
    }

    install_all()
    {
        install_kernel
        install_alsa
        install_jack
        install_squashfs
    }

    # ---- process ----------------------------------------------------------

    #setup_all
    #build_all
    #install_all
    #make_tarball

    # The End

Retrieved from
"[http://alsa.opensrc.org/Aabuild](http://alsa.opensrc.org/Aabuild)"

[Category](/Special:Categories "Special:Categories"):
[Installation](/Category:Installation "Category:Installation")

