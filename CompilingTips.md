CompilingTips
=============

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

For a more complete description, check out [Quick
Install](/Quick_Install "Quick Install")

I use mandrake 9.1

Make sure you have install kernel-source and gcc compiler and other
required library

-   extract alsa-driver somewhere

If you run ./configure it will detect some setting, but when compiling
it will say error about modversions.h, read on:

` `

    cd /usr/src/linux
    make menuconfig #or make config or make xconfig
    Save configuration
    make dep   # this will create modversions.h

Then continue compile your kernel, this is necessary because if you
continue compile alsa there will be unresolved some kernel symbols.

` `

    make bzImage
    make modules
    make modules_install
    make install
    lilo

Reboot Linux, and use new kernel.

Now continue compile alsa:

` `

    service alsa stop # stop alsa with previous version
    cd somewhere
    make clean  # make sure its clean
    ./configure # add your additional option, see ./configure --help
    make
    make install

Ok then, your alsa driver has been installed. Check by typing:

` `

    modprobe snd-yoursoundcardname   # without .o

or

` `

    service alsa start

If you have trouble with unresolved verbose\_printk, try to edit
condefs.h, find VERBOSE\_PRINTK, and comment it out. Then recompile your
alsa driver.

Now continue compile alsa-lib, alsa-utils, alsa-tools, etc.

Retrieved from
"[http://alsa.opensrc.org/CompilingTips](http://alsa.opensrc.org/CompilingTips)"

[Category](/Special:Categories "Special:Categories"):
[Installation](/Category:Installation "Category:Installation")

