Ymfpci
======

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

**XG-MIDI and Yamaha YMF-744/754 Soundcards**

\

Contents
--------

-   [1 2005-10-11](#2005-10-11)
-   [2 2002-06-07](#2002-06-07)
    -   [2.1 Load modules](#Load_modules)
    -   [2.2 Install sbiload](#Install_sbiload)
    -   [2.3 Load patches](#Load_patches)
    -   [2.4 Adjust mixer levels](#Adjust_mixer_levels)

-   [3 Alsamixer Inputs Guide](#Alsamixer_Inputs_Guide)
-   [4 Low latency and ymfpci cards](#Low_latency_and_ymfpci_cards)
-   [5 Quick tip on recording from
    SPDIF](#Quick_tip_on_recording_from_SPDIF)

2005-10-11
----------

The Yamaha DS-XG specs for this card are available from here...

[ftp://ftp.alsa-project.org/pub/manuals/yamaha/pci/754docs.zip](ftp://ftp.alsa-project.org/pub/manuals/yamaha/pci/754docs.zip)

See GuillemotMaxisoundFortissimo for a variation on this card.

2002-06-07
----------

### Load modules

Load the `snd-opl3-synth`, `snd-seq-instr`, `snd-ainstr-fm` and related
modules. For my ad1816a [soundcard](/Soundcard "Soundcard"), I load the
following modules using `modprobe` which fills in the dependencies: ` `

    /sbin/modprobe snd-ad1816a
    /sbin/modprobe snd-opl3-synth

### Install sbiload

Get and install the `sbiload` program from alsa-tools. Some versions of
alsa-tools are missing the instruments. The CVS version of alsa-tools
includes instruments, so your best bet is to get the CVS version of
alsa-tools-x.x.x or else to download the missing instruments (`std.*`
and `drums.*`) from here:

[http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/alsa/alsa-tools/seq/sbiload/](http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/alsa/alsa-tools/seq/sbiload/)

I used the following command to compile and install `sbiload`

` `

    cd alsa-tools-0.9.0rc1/seq/sbiload
    ./configure --prefix=/usr/local --with-kernel=2.5.20
    make
    sudo make install

### Load patches

Load the patches for the card like so:

` `

    sbiload -p65:0 --opl3 std.o3 drums.o3

For Slackware Linux, I have in my `/etc/rc.d/rc.modules` file:

` `

    /usr/local/bin/sbiload -p 65:0 --opl3 \
    /usr/local/share/alsa/banks/opl3/std.o3 \
    /usr/local/share/alsa/banks/opl3/drums.o3

This loads the OPL3 versions of the sound banks. If you want more
soundblaster-like sounds (OPL2), load the files `std.sb` and `drums.sb`.

### Adjust mixer levels

Adjust the mixer levels. On my card, there is a Synth mixer and a FM
mixer. The FM mixer is the one for adjusting the volume of MIDI
playback. On my card, the sound is very quiet until the slider is almost
to the top, so you may need to experiment.

OK, you should be able to generate FM music now. If you have a MIDI
keyboard and a working MPU401, you can connect it to the OPL3 synth to
hear sounds. Here are the outputs from aconnect

` `

    $ aconnect -i
    client 0: 'System' [type=kernel]
        0 'Timer           '
        1 'Announce        '
    client 64: 'External MIDI 0' [type=kernel]
        0 'MIDI 0-0        '

    $ aconnect -o
    client 64: 'External MIDI 0' [type=kernel]
        0 'MIDI 0-0        '
    client 65: 'OPL3 FM synth' [type=kernel]
        0 'OPL3 Port       '

    $ aconnect 64:0 65:0

Viola! Sounds! The newest version of
[Rosegarden](/Rosegarden "Rosegarden") works well for playing music at
least. I recommend getting the `kaconnect` program if you want to work
seriously with ALSA synthesizers:

[http://www.suse.de/\~mana/kalsatools.html](http://www.suse.de/~mana/kalsatools.html)

You'll probably have to play with the makefile to get them to compile.

I would also like to point out that ISA MPU401 interfaces \_really\_
like to have IRQ 9, but it is often taken by the ACPI controller on
modern motherboards (which is unchangeable on my Tyan Tiger 100). In
that case, be sure to set the next best interrupt, IRQ 10, as **ISA** in
the BIOS settings. Setting IRQ 9 will not really prevent the ACPI
controller from using it and causing the MPU401 to not work.

Have fun, and tell your friends. What I would like is to be able to
change the parameters on an OPL3 instrument using MIDI control messages.
An OPL3 is two operators away from a DX-7 for crying out loud ;)

--BrentCook *Thanks Brent*

Alsamixer Inputs Guide
----------------------

'ADC' = Throughput \`line in\` port 'ADC Capture' = Record from \`line
in\` port (Left hand 'Digital' input also has to be unmuted to record)

(FIXME: need more info/clarification)

Low latency and ymfpci cards
----------------------------

The `ymfpci` soundcard has limited features, even in Asio with Windows.
In order to use a `ymfpci` soundcard with [Jack](/Jack "Jack"), and
generally to do anything useful, you need to set the period size. For
example:

` `

    jackd -d alsa -d default -r 44100 -p 512 -n 3

The key setting here is:

` `

    -p 512

This gives you a latency of \~74ms. Using `/dev/rtc` and other kernel
latency settings and patches should help.

Quick tip on recording from SPDIF
---------------------------------

Using the Hoontech Soundtrack Digital XG, you can record easily using
`snd` for example and setting the following
[alsamixer](/Alsamixer "Alsamixer") settings:

*Please don't mess around with this stuff wearing headphones, you can
get some noisy digital loops that could blow your ears.*

-   Master: \~90%
-   PCM: \~90% (these first two shouldn't effect the quality of the
    recording)
-   Wave: 100%
-   [IEC958](?title=IEC958&action=edit&redlink=1 "IEC958 (page does not exist)"):
    capture enabled (spacebar to enable)
-   IEC958 1: 100%
-   Capture: capture enabled (redundancy abounds)
-   Digital: 100%
-   Direct Recording Source: IEC958

All of the above discovered by trial and error (mostly the latter).

Retrieved from
"[http://alsa.opensrc.org/Ymfpci](http://alsa.opensrc.org/Ymfpci)"

[Category](/Special:Categories "Special:Categories"): [ALSA
modules](/Category:ALSA_modules "Category:ALSA modules")

