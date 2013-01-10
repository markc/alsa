Unresolved Symbols
==================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

To avoid the *unresolved symbols* error, you can try one of the tips
below.

Contents
--------

-   [1 Tip 1](#Tip_1)
-   [2 Tip 2](#Tip_2)
-   [3 Tip 3](#Tip_3)
-   [4 Tip 4](#Tip_4)
-   [5 Tip 5](#Tip_5)
-   [6 Tip 6](#Tip_6)

Tip 1
-----

If you keep getting an *unresolved symbols* error when using ALSA
modules, the solution is very simple: ***Clean the kernel's source
tree.***

Change directory to the kernel source tree. If you want to keep the same
config, I advise :

` `

       cp .config /tmp        # (not inside the current directory, it will get erased)
       make mrproper
       cp /tmp/.config .
       make oldconfig
       make dep
       make bzImage
       make modules
       make modules_install

Copy your new kernel image file *bzImage* to your boot device location
as you'd normally do.

Then, recompile ALSA.

I know that this is not directly ALSA related, but it could take place
in the FAQ, as it definitely prevents ALSA from working.

Tip 2
-----

Try this: In the alsa-driver directory,

` `

       rm config.cache
       ./configure [your options]
       make clean
       make

and then, as root, do:

` `

       make install
       rmmod -a \_        # these make sure no old modules are hanging around in memory
       rmmod -a /

Maybe some partially-compiled files are left over from a previous
attempt. Remove all of the ALSA kernel modules before you do *make
install*. Do a *find /lib/modules/\`uname -r\` -name 'snd\*.o'* to make
sure they're all gone.

Tip 3
-----

On Thu, 8 Mar 2001, Narayana, Venkat A. wrote:

` `

       > Hi,
       > I am learning to write kernel modules, and while experimenting
       > with a simple module, i got
       > " hello.o: unresolved symbol printk_Rsmp_1b7d4074" error
       > while loading this module via insmod hello.o command.
       >
       > I noticed that /proc/ksyms contains printk symbol.
       >
       > What is that i am doing which is not correct?
       > Help me out.

As other people have pointed out this has to do with versioning.

The simple answer to the question is that you need to include
*modversions.h* before the header file for *printk* if you want the
module to load into a kernel with *CONFIG\_MODVERSIONS* turned on.

You could do this in two ways:

-   in each of your c files, at the top (before you *\#include
    linux/kernel.h*), you could have:

` `

       #ifdef CONFIG_MODVERSIONS
       #include <linux/modversions.h>
       #endif

-   or in your makefile, you could have

` `

       ifdef CONFIG_MODVERSIONS
       CPPFLAGS += -include /usr/src/linux/modversions.h
       endif

Tip 4
-----

Now, I'll try and explain how it all works. (Jay, a section on this is
definitely needed in the module programming guide ;). Okay, this can be
a bit difficult to explain, but I'll give it a go. I've probably got
some of it wrong. Someone will correct me. (all this assumes
*CONFIG\_MODVERSIONS* is turned on)

-   the kernel is compiled with *-include /usr/src/linux/modversions.h*.
    What this effectively means is that *modversions.h* is included at
    the top of every c file in the kernel.

-   so what does this do? Well, if you have a look at *modversions.h*,
    it includes loads of *.ver* files. Each of these files have loads of
    lines like (in *ksyms.ver*)

` `

       #define __ver_printk    1b7d4074
       #define printk  _set_ver(printk)

this winds up having a *\#define* along the line of

` `

       #define printk printk_R1b7d4074

-   so what does this do? Well, now everywhere *printk* is mentioned it
    gets

replaced by *printk\_R1b7d4074* by the preprocessor. So when the kernel
is compiled there is no such function as *printk*, there is only one
called *printk\_R1b7d4074*.

-   so if you want to write a module that uses the 'printk'
    function(sorry, I mean the *printk\_R1b7d4074* function) you're
    going to have to include *modversions.h* before *printk* is defined.

Tip 5
-----

Another question you might ask is how the .ver files get generated?

-   well the basic command is along the lines of

` `

       gcc -E -D__GENKSYMS__ <the-c-file> | genksys -k <your-kernel-version> > <your-ver-file>

-   the *gcc* command puts the c file through the preprocessor with
    *\_\_GENKSYMS\_\_* defined
-   the output of this is passed through to *genkyms* which generates
    output like

` `

       #define __ver_printk    1b7d4074
       #define printk  _set_ver(printk)

where the *1b7d4074* depends on the kernel version you supply.

Tip 6
-----

Hi,

I have gone through an alsa compilation which went well, but the loading
of the module came back with the following error :

` `

       /lib/modules/2.2.17/misc/snd.o: unresolved symbol unregister_sound_dsp
       /lib/modules/2.2.17/misc/snd.o: unresolved symbol register_sound_dsp
       /lib/modules/2.2.17/misc/snd.o: unresolved symbol
       unregister_sound_special
       /lib/modules/2.2.17/misc/snd.o: unresolved symbol register_sound_special
       /lib/modules/2.2.17/misc/snd.o: insmod /lib/modules/2.2.17/misc/snd.o
       failed
       /lib/modules/2.2.17/misc/snd.o: insmod snd-cs4236 failed

I then went to the FAQ which said that it was because my kernel was
incorrectly configured and also because I had missed out the soundcore
code *(CONFIG\_SOUND=y)*.

I was surprised because I had just recompiled that kernel, ensuring that
I had added the right options.

Apparently -- I noticed this on some kernel mailing lists -- the usage
of the kernel modversions facility (*CONFIG\_MODVERSIONS*) is not always
correctly taken into account by the fastdep kernel makefiles
reconfiguration system.

The result is weird symbol names for some symbols.

Retrieved from
"[http://alsa.opensrc.org/Unresolved\_Symbols](http://alsa.opensrc.org/Unresolved_Symbols)"

[Category](/Special:Categories "Special:Categories"):
[Troubleshooting](/Category:Troubleshooting "Category:Troubleshooting")

