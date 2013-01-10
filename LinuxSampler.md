LinuxSampler
============

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Home page: [http://www.linuxsampler.org/](http://www.linuxsampler.org/)

The goal of LinuxSampler is to produce a free, open source pure software
audio sampler with professional grade features, comparable to both
hardware and commercial Windows/Mac software samplers. The project was
initiated by Benno Senoner. The program relies on the
[libgig](http://stud.fh-heilbronn.de/~cschoene/projects/libgig/) library
by Christian Schoenebeck which can load
[GigaSampler](/GigaSampler "GigaSampler") and DLS 1 & 2 instrument
patches. To get the code try this...

` `

    cvs -z3 \
     -d:pserver:anonymous@cvs.linuxsampler.org:/var/cvs/linuxsampler \
     co linuxsampler

**cd linuxsampler** and type **configure** then **make**. The resulting
program will only load [GigaSampler](/GigaSampler "GigaSampler") files
as of Novemember 2003 so if you don't have any such patch sets lying
around then try downloading this very nice 40Mb GigaSampler format piano
sound font from
[http://www.alchemystudio.it/FreeSamples/FreePiano.zip](http://www.alchemystudio.it/FreeSamples/FreePiano.zip).
Then to make it all work try this...

` `

    unzip FreePiano.zip
    linuxsampler --gig FreePiano.gig
    aconnect -lio (to check on your particular ports)
    aconnect 64:0 128:0 (where 128 is your LinuxSampler)
    or 
    pmidi -p 128:0 somemusic.mid (if no keyboard)

and you may hear about the best piano sound possible under linux to
date. There are still envelope (attach and decay) issues with
LinuxSampler but if you compare the underlying sound quality with any
other typical SoundFont or GUS Patch for
[TiMidity](/TiMidity "TiMidity") you will be impressed.

There is yet hope for professional quality sounds generated on linux :-)

* * * * *

Rui Nuno Capela \<rncbc at rncbc.org\> posted this nice script to deal
with the current (20031221) LinuxSampler code from CVS. He notes that...
*as of yesterday on IRC, Chris agreed to remove the "offending" files
from CVS, so I think the explicit removal below will be soon a non-op.
OTOH it could be moved apropriately into Makefile.cvs.*

Script name suggestion is **linuxsampler\_cvs\_install.sh**

` `

    #!/bin/sh
    cvs -z3 \
     -d:pserver:anonymous@cvs.linuxsampler.org:/var/cvs/linuxsampler \
     co linuxsampler
    cd linuxsampler || exit 1
    find -name "acconfig.h" -exec rm -rvf {} \;
    find -name "aclocal.m4" -exec rm -rvf {} \;
    find -name "config.*"   -exec rm -rvf {} \;
    find -name "*.cache"    -exec rm -rvf {} \;
    make -f Makefile.cvs
    ./configure --prefix=/usr/local --enable-optimize
    make || exit 2
    su -c "make install"

Thanks for the script Rui, worked for me :-)

Retrieved from
"[http://alsa.opensrc.org/LinuxSampler](http://alsa.opensrc.org/LinuxSampler)"

[Category](/Special:Categories "Special:Categories"):
[Software](/Category:Software "Category:Software")

