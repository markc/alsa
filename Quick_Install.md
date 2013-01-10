Quick Install
=============

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Contents
--------

-   [1 Installing ALSA from source](#Installing_ALSA_from_source)
    -   [1.1 1. Requirements](#1._Requirements)
    -   [1.2 2. Getting the sources](#2._Getting_the_sources)
    -   [1.3 3. Compiling and installing](#3._Compiling_and_installing)
    -   [1.4 4. Loading the ALSA modules](#4._Loading_the_ALSA_modules)
    -   [1.5 5. Getting started](#5._Getting_started)
    -   [1.6 Troubleshooting](#Troubleshooting)

Installing ALSA from source
---------------------------

This document describes installing ALSA from source code. For installing
ALSA from binary distro packages see [ALSA Setup
Guide](/ALSA_Setup_Guide "ALSA Setup Guide"). You don't have to do this
though, there are binary packages available. If you are using Red Hat,
see [http://freshrpms.net/docs/alsa/](http://freshrpms.net/docs/alsa/)
for RPM packages. There are debian packages available, too. You can also
choose to install the drivers from source (to make sure they fit your
kernel) and install the libs, utilities etc. as binary packes.
[Debian](http://www.debian.org) users choosing to do this should run ` `

       apt-get install libasound2 alsa-utils alsa-oss

**Kernel 2.6.XXX users:**

If you have a kernel from the 2.6.xxx series, ALSA is already included,
so it's not necessary to do all these steps. If you have a 2.6-kernel
and want to install a newer version of ALSA than the one included, check
out [AlsaBuild2.6](/AlsaBuild2.6 "AlsaBuild2.6").

-   Always check out the latest INSTALL file!

### 1. Requirements

Make sure you have a kernel source tree that you've already compiled
from. This should be in /usr/src/linux but the alsa configure scripts
will look elsewhere with the "--with-kernel=[dir]" option when running
'configure'. The kernel must have sound support turned ON in your kernel
settings (soundcore module). Any other kernel options regarding sound
can be switched OFF. Of course, you need a sound card that is supported
by ALSA. Check out the ALSA sound card matrix.

### 2. Getting the sources

You can download the sources from the front page of the ALSA home page:
[http://www.alsa-project.org](http://www.alsa-project.org). I recommend
you get the drivers, the libraries, the utils and the OSS compat modules
to start with. Next, put them into some directory, e.g. /usr/src/alsa:
` `

       mkdir /usr/src/alsa
       cp downloaddir/alsa* /usr/src/alsa

To unpack the files: ` `

       tar jxvf alsa-driver-xxx.tar.bz2

The same applies to the other packages you downloaded.

**CVS:** You can also get the newest sources from CVS. See AlsaCVS

### 3. Compiling and installing

Note: To avoid problems, stick to the order the modules are installed
here, i.e. first the drivers, then the libs, then the rest.

**To compile & install the drivers:**

` `

       cd alsa-driver-xxx
       ./configure --with-sequencer=yes && make
       make install
       ./snddevices

The `configure` command can take some options, like
`--with-sequencer=yes`. To get a complete list of all options: ` `

       ./configure --help

Some of the most important options: ` `

       --with-kernel=dir          give the directory with kernel
                                  sources default: /usr/src/linux
       --with-isapnp=yes,no,auto  driver will (not) be compiled with
                                  ISA PnP support
       --with-sequencer=yes,no    driver will (not) be compiled with sequencer support
       --with-oss=no,yes          driver will (not) be compiled with OSS/Free emulation
       --with-cards=<list>        compile driver for cards in <list>;
                                  cards may be separated with commas;
                                  'all' compiles all drivers;
                                  Possible cards are:
                                  dummy, virmidi, serial-u16550, mtpav,
                                  als100, azt2320, cmi8330, [...]]

If you don't have ISA, you can safely add `--with-isapnp=no`. If you
only have one card (e.g. SB Live) and aren't planning to add any others,
you can add `--with-cards=emu10k1` or whatever the module for your card
is called. The `./snddevices` command creates the audio devices in
/dev/snd. `make install` and `./snddevices` must be done as root, the
rest can be done as any user.

**ALSA libraries**

This is straightforward: ` `

       cd alsa-lib-xxx
       ./configure && make
       make install

**ALSA Utils**

These include the alsamixer program and other very useful helpers.
**Note:** The alsamixer requires a dev packages for ncurses, for
debian/sid this is 'libncurses5-dev'. ` `

       cd alsa-utils-xxx
       ./configure && make
       make install

**ALSA OSS compat modules**

` `

       cd alsa-oss-xxx
       ./configure && make
       make install

-   NB: Compiling could take a while!

### 4. Loading the ALSA modules

Now insert the modules into the kernel space. ` `

       modprobe snd-ens1371
       modprobe snd-pcm-oss
       modprobe snd-mixer-oss
       modprobe snd-seq-oss

If you get an "init\_module: No such device" error when you run this
modprobe command, make sure that you uninstall all the sound related
modules first. Use `lsmod` to check the installed modules and `rmmod` to
uninstall. Then modprobe the new modules. See Troubleshooting for other
solutions. To make module loading permanent, you have to add these lines
to /etc/modules.conf (for Debian users, this means you have to create a
file with these lines in /etc/modutils and the do update-modules).
**Kernel 2.6 users** note: module settings now go into
/etc/modprobe.conf (Debian users: just copy the module-info file from
/etc/modutils/ to /etc/modprobe.d/ and run update-modules).

**Note**: These next lines are valid for a machine with one SB Live!.
For your settings, see the ALSA sound card matrix details for your
soundcard!

` `

       # alsa/soundblaster live module settings
       # (from the alsa soundcard matrix)
       
       # ALSA portion
       alias char-major-116 snd
       alias snd-card-0 snd-emu10k1
       
       # module options should go here
       
       # OSS/Free portion
       alias char-major-14 soundcore
       alias sound-slot-0 snd-card-0
       
       # card #1
       alias sound-service-0-0 snd-mixer-oss
       alias sound-service-0-1 snd-seq-oss
       alias sound-service-0-3 snd-pcm-oss
       alias sound-service-0-8 snd-seq-oss
       alias sound-service-0-12 snd-pcm-oss

**Loading soundcard settings on startup:**

The 'make install' options of the ALSA drivers creates a file
/etc/init.d/alsasound (if not, this file is also in
alsa-driver-xxx/utils and should be copied to /etc/init.d, then chmod
755) which takes care of saving and loading the mixer settings etc. on
bootup and shutdown, but you have to create links manually to let this
actually happen, otherwise your mixer settings will always be resetted
when you shut down: ` `

       % ln -s /etc/init.d/alsasound /etc/rcS.d/S59alsasound
       % ln -s /etc/init.d/alsasound /etc/rc1.d/K15alsasound
       % ln -s /etc/init.d/alsasound /etc/rc6.d/K15alsasound

### 5. Getting started

If everything worked out correctly, you can now use your sound card! So,
first of all, adjust your soundcards volume levels. All mixer channels
are muted by default. You must use a native mixer program to unmute
appropriate channels, e.g. [alsamixer](/Alsamixer "Alsamixer") from the
alsa-utils package ` `

       alsamixer

**Note**: Some soundcards don't utilise the
[alsamixer](/Alsamixer "Alsamixer") program so you will need to learn
how to use the [amixer](/Amixer "Amixer") program. Unmute the 'Master'
and 'PCM' levels and pull them up, also look for a "Headphone" slider,
and if it exists pull that up as well - if everything worked out, you
should be able to playback music now. If not, check out the
'Troubleshooting' section.

### Troubleshooting

If modprobe snd-sb16 says that you don't have the Sound Blaster card,
first try to install isapnp packages (they are named isapnptools and
libisapnp-dev, on debain) then you nead to add the line "options
snd-sb16 isapnp=0" to your /etc/modules.conf file if you have kernel2.4
(or to /etc/modutils/alsa file on debian and run update-modules)

If anything doesn't work, the first thing to do is to check the
[FAQ](/FAQ "FAQ") and make sure you've got the latest version of ALSA.
Some special problems are listed here: If playback still doesn't work
after installation and programs give errors like 'Can't open default
sound device!' (In this case, the message was given by mpg123), try
this: ` `

       chmod 666 /dev/snd/*

and, if you have the OSS modules installed: ` `

       chmod 666 /dev/mixer* /dev/midi* /dev/dsp* /dev/sequencer*

**Note**: This has to be done as root.

Retrieved from
"[http://alsa.opensrc.org/Quick\_Install](http://alsa.opensrc.org/Quick_Install)"

[Category](/Special:Categories "Special:Categories"):
[Installation](/Category:Installation "Category:Installation")

