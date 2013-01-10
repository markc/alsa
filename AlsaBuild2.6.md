AlsaBuild2.6
============

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Contents
--------

-   [1 Note (aabuild)](#Note_.28aabuild.29)
-   [2 Offical page](#Offical_page)
-   [3 Compiling new alsa-package](#Compiling_new_alsa-package)
    -   [3.1 Compile the alsa driver seperate from the kernel
        source](#Compile_the_alsa_driver_seperate_from_the_kernel_source)
    -   [3.2 Patch the ALSA-drivers included with the kernel
        source](#Patch_the_ALSA-drivers_included_with_the_kernel_source)
    -   [3.3 Overwrite alsa in the kernel source(updated
        2006-12-26)](#Overwrite_alsa_in_the_kernel_source.28updated_2006-12-26.29)
    -   [3.4 Notes](#Notes)
    -   [3.5 Questions](#Questions)

-   [4 Notes](#Notes_2)
-   [5 Another unofficial method](#Another_unofficial_method)
    -   [5.1 Requirements:](#Requirements:)
    -   [5.2 Install:](#Install:)
    -   [5.3 Usage:](#Usage:)

Note (aabuild)
--------------

*20040307*

There is now a Bash shell script example at
[aabuild](/Aabuild "Aabuild").

Offical page
------------

An official page about building a kernel with ALSA drivers...

[http://www.alsa-project.org/documentation.php3\#kerndriv](http://www.alsa-project.org/documentation.php3#kerndriv)

Compiling new alsa-package
--------------------------

The ALSA drivers are packaged with the 2.6 kernel source, therefore it
should not be necessary to install the alsa drivers package separately.
If you do want to use a newer alsa-package than which is included with
the kernel, you have basically two options:

### Compile the alsa driver seperate from the kernel source

Disable all ALSA options in the kernel config and only enable the
general Sound Support in the kernel config (if you want the old OSS
sound driver, enable that too. But be aware that the old OSS modules and
ALSA cannot coexist in the same kernel, so compile them as modules if
you want to have the option of switching back to OSS. Do not confuse the
old OSS modules with the ALSA OSS emulation).. Build and install this
kernel. Then build the ALSA-drivers from the source package from
[http://alsa-project.org/](http://alsa-project.org/). It might be
necessary to compile the alsa-driver package as root, since it seems to
create the driver modules in the kernel source first. An alternative is
to use the CVS alsa-driver; use the following command to get it:

` `

    cvs -q -f -z3 -d \
        ":pserver:anonymous:@cvs.sourceforge.net:/cvsroot/alsa" \
        co -P alsa-kernel alsa-driver

Can both the OSS amd the Alsa configured as Modules ... coexist?

Versions of alsa-driver \< 1.0.2c do not appear to work well with kernel
2.6.x. Some people have problems, some do not. alsa-driver version
1.0.2c should install correctly on both kernel 2.4.x and 2.6.x. Gentoo
users: Don't try to emerge the alsa-driver package as it will fail. You
will need to compile it manually as root. As of kernel 2.6.3, installing
alsa-driver package might not be needed, as kernel 2.6.3 already
includes alsa-driver 1.0.2.

### Patch the ALSA-drivers included with the kernel source

Please fill in info you have on this subject matter...

### Overwrite alsa in the kernel source(updated 2006-12-26)

Get alsa-kernel from the hg (aka mercurial) repository. CVS repository
stopped working as of alsa release ??. With alsa-driver \>= 1.0.2c,
option 1] is recommended instead. For these steps make sure you have
done "make clean" in the kernel directory, for me that is
`/usr/src/linux`. Create a temp directory of for example,
`/usr/local/alsa`.

` `

    # mkdir /usr/local/alsa
    # cd /usr/local/alsa
    # hg clone http://hg-mirror.alsa-project.org/alsa-kernel alsa-kernel
    # cd alsa-kernel
    # rm -rf oss
    # cp -a kernel/* /usr/src/linux
    # rm -rf kernel/
    # cp -a Documentation/* /usr/src/linux/Documentation
    # rm -rf Documentation
    # cp -a include/* /usr/src/linux/include/sound
    # rm -rf include
    # cp -a * /usr/src/linux/sound

If you need a previous version you should clone to the latest and the go
back with the following command:

` `

    # hg update -C v1.0.13

This example pulls the hg version tagged v1.0.13, which corresponds to
version 1.0.13. This way your integrating the desired version, and not
the latest hg, which could have the potential to be broken.

After this you can configure kernel and choose alsa configuration
options within your usual kernel configuration tool.

### Notes

With alsa-driver \>= 1.0.2c, option 1] is recommended instead. One can
integrate ALSA-driver 1.0.1 into the Linux Kernel 2.6.0 or 2.6.1 source
tree pretty painlessly, here's how you do it: Note, for alsa-driver
1.0.2 this will not work as there is not alsa-kernel directory in it,
instead use option (3), see below...

` `

    # Unpack your kernel source in /usr/src (/usr/src/linux-2.6.1)
    # Unpack alsa-driver-1.0.1 tarball into /usr/src (/usr/src/alsa-driver-1.0.1)
    # cd /usr/src/alsa-driver-1.0.1/alsa-kernel
    # rm -rf oss
    # cp -a * /usr/src/linux-2.6.1/sound
    # cd include
    # cp -a * /usr/src/linux-2.6.1/include/sound
    # cd ../Documentation
    # cp -a * /usr/src/linux-2.6.1/Documentation

The last two are optional. One can then configure your kernel source as
normal and compile, enjoy!

Warren Chartier \<icebalm AT NOSPAM icebalm DOT com\> Updates from James
Courtier-Dutton. (aka. jcdutton)

### Questions

Interesting... I just installed it the normal way. It puts drivers in
/lib/modules/2.6.0/misc. I first disabled the alsa drivers in the
kernel. Yours sounds very useful as I'd like to have it all in the
kernel. My via82xx chipset in Gigabyte 7V-AXP (kt400) works great now.
Before the mic recording wouldn't work. Are you sure you should remove
the "oss" directory? Isn't that for OSS emulation? That's pretty useful
for a lot of applications.

*No, the OSS emulation modules are in '**linux/sound/core/oss'** and
'**linux/sound/core/seq/oss'**. The '**linux/sound/oss'** directory has
the old OSS sound driver. If you need to use the old OSS sound driver
then don't delete this directory. One reason you might want to use the
OSS sound driver is to have the OSS '**/dev/sequencer'** for recording
MIDI because the ALSA OSS emulation is not 100% compatible.*

Notes
-----

The OSS emulation is indeed very useful, but there is a reason (I just
discovered! :) to rm -rf the oss directory from the alsa 1.0.0rc2
directory before copying over the rest of the contents to the
linux-2.6.0/sound directory: the alsa 1.0.0rc2 version of the oss
directory breaks the kernel build, or, at least, it broke mine
(i386/building alsa as modules). There's some incapability between its
Makefile and that of the linux-2.6.0 master Makefile. I didn't save the
error, and I didn't fell like figuring it out, so I can't tell you
exactly what it is (though there's a more or less easy way for you to
find out for yourself). Leaving the original linux-2.6.0/sound/oss
directory in place and only copying over the rest of the alsa 1.0.0rc2
stuff does indeed work fine.

Erik Curiel (erik-alsa.opensrc.org AT NOSPAM gaffle dot com)

* * * * *

The oss directory being removed is not for OSS emulation, it is where
the kernel stores the old obsolete OSS-Lite drivers, why there is a
Makefile for it in the alsa-drivers package I don't know. The OSS
emulation is located in /usr/src/linux/sound/core/oss. Hope this helps!

Warren Chartier \<icebalm AT NOSPAM icebalm DOT com\> Comfirmed by James
Courtier-Dutton. (aka. jcdutton)

* * * * *

I compiled the kernel 2.6.9 with the alsa provided with it. Is it
possible to upgrade to a newer alsa version, or do i have to recompile
using one of those methods ?

*Yes but it is more reliable to (re)build both together. For a recipe to
upgrade to the latest CVS ALSA have a look at
[aabuild](/Aabuild "Aabuild") for technical hints.*

Another unofficial method
-------------------------

### Requirements:

You will need to be running the 2.6.xx version kernel that you are going
to compile alsa for. You will also need to have a \`configured' version
of the matching 2.6.xx source code. The source should be configured to
include \`sound', \`alsa' and any sound features you want included, ie;
sound card drivers, oss emulation, etc. The sound should be configured
as modules. Ideally, you upgraded a working system to 2.6 and want to
get any current fixes/features to solve problems with the existing
2.6.xx sound. That means you already have a working \`kernel
developement' environment (compiler, source files, etc.). If you
installed a distribution with 2.6, you will at least need to have the
source code for the 2.6 kernel and it needs to be configured like your
running kernel.

### Install:

Download and install the alsa source files. For each alsa package (ie;
alsa-drivers, alsa-tools, etc,) running \`./configure' will set up
\`makefiles' apropriate to your running kernel. It will match the
running kernel to the linux kernel source in /usr/src/linux.2.6.xx. When
compiling the alsa-tools use; ./configure --prefix=/usr. This will put
alsa utility programs in /usr/bin. Otherwise they will go into
/usr/local/bin.

For each package, do \`make' and \`make install'. REBOOT THE SYSTEM.
Check if sound modules are installed; from a terminal, run; lsmod. If
not, perform depmod before trying to load the sound modules. On my
system (RedHat 8.0 \`full install' upgraded to 2.6.1), modules do not
automatically load under 2.6 as they should. I added 'modprobe' commands
to /etc/rc.d/rc.local to load up the needed modules.

### Usage:

For volume control you will need to run;
[alsamixer](/Alsamixer "Alsamixer") from a terminal (it's a text based
gui.) For programs that depend on OSS emulation (Gnome, pre-existing
versions of xawtv?,mplayer?,xmms?,) you will also have to use an OSS
volume control (the two volume controls work separately.) OSS requires
BOTH volume controls, example:

` `

       sound-source->alsamixer->oss-emulation->ossmixer->speakers

Retrieved from
"[http://alsa.opensrc.org/AlsaBuild2.6](http://alsa.opensrc.org/AlsaBuild2.6)"

[Category](/Special:Categories "Special:Categories"):
[Installation](/Category:Installation "Category:Installation")

