ThinkPad600
===========

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

**Alsa for the IBM Thinkpad 600 Laptop (possibly also for later
versions)**

The Thinkpad 600 has a CS4237B, which is very compatible with both the
CS4232 and the CS4236 driver. The consensus of many users seems to be to
test the the CS4236 driver first. If you have quality problems (you
shouldn't), try the CS4232 instead. The Linux 2.4 kernel also has a
CS4232 driver which works, though it may not be as good as the Alsa
driver (I tested it, but not extensively).

A key thing to remember is that the Thinkpads are somewhat odd in their
approach to ISAPNP. For instance, at least in Linux 2.4, pnpdump doesn't
work and using the isapnp=1 settings can get you into trouble.

The recommendations I have seen are:

Contents
--------

-   [1 Recommendation 1](#Recommendation_1)
-   [2 Recommendation 2](#Recommendation_2)
-   [3 Recommendation 3](#Recommendation_3)
-   [4 Recommendation 4](#Recommendation_4)
-   [5 Recommendation 5](#Recommendation_5)
-   [6 Recommendation 6](#Recommendation_6)
-   [7 Recommendation 7](#Recommendation_7)
-   [8 Recommendation 8](#Recommendation_8)
-   [9 Recommendation 9](#Recommendation_9)
-   [10 Recommendation 10](#Recommendation_10)
-   [11 More hints](#More_hints)
-   [12 See also](#See_also)

Recommendation 1
----------------

Ensure that "((ThinkPad Simple Boot))", AKA "Quick Boot" is DISABLED. If
you do not do this, the PNP BIOS may not appropriately set the resources
for the CS4232, and you'll always get a Device Busy or not found error
when you modprobe the driver no matter what settings you give.

Recommendation 2
----------------

Use the PS2.EXE utility (sadly, you have to boot into DOS to do this) to
set and verify the resources used by the soundcard (and make sure it's
enabled). That is, check the AUDIO and AUDIOCTRL parameters. The MIDI
parameter (for the mpu) can be disabled. You don't need it unless you're
hooking to external MIDI devices. PS2.EXE is available on the IBM site,
click downloads after going to the IBM support link listed under
ThinkPad.

You may instead be able to use "lspnp -v" and "setpnp" to view and
configure these settings (lspnp and setpnp are distributed in the
PCMCIA-CS package). To use lspnp and setpnp, you might have to have
build the kernel with the PNP-BIOS configuration option enabled. This
option is shown as experimental in the 2.4 kernels, up to 2.4.20 anyway.
Also, look at the tpctl link on the ThinkPad page.

Recommendation 3
----------------

You need to have the source for the kernel to build the alsa drivers (I
think at least alsa 0.9 is recommended for linux 2.4). It's best (maybe
imperative for the TP600) to run ./configure with the --with\_isapnp=0
option. The kernel source code should also have been built with the
configuration setting "ISAPNP BIOS" disabled. If you don't totally
disable ISAPNP support on the TP600, when the driver starts it may try
to use the isapnp functions to determine resources automatically. This
always seems to fail on my TP600 (and others as well, I gather) for the
same reason that pnpdump doesn't do anything. The options I used are ` `

    ./configure --with-isapnp=0 --with-sequencer=yes --with-cards=cs4232,cs4236

Recommendation 4
----------------

Immediately after "make install" for the driver, do a "modprobe cs4236
port=PORT cport=CPORT irq=IRQ dma=DMA dma2=DMA2". You found PORT, IRQ,
DMA, and DMA2 using PS2.EXE (or lspnp -v), right? My machine's
`lspnp -v shows`

` `

    0e CSC0000 Crystal PnP audio system CODEC
      port 0x530-0x537
      port 0x388-0x38b
      port 0x240-0x253
      irq 5
      dma 1
      dma 0

    0f CSC0000 Crystal PnP audio system control registers
       port 0x538-0x53f

so I used

` `

    modprobe snd-cs4236 port=0x530 cport=0x538 irq=5 dma1=1 dma2=0

to test with. Note that I left my Crystal PnP audio system MPU-401
disbled in PS2.EXE (I think you only need the MPU-401 enabled if you are
going to use the external MIDI port). Also note that, to get lspnp to
work, I compiled the (2.4.20-ac2) kernel with

` `

     CONFIG_PNP=y
     # CONFIG_ISAPNP is not set
     CONFIG_PNPBIOS=y

in the `.config` file.

Recommendation 5
----------------

If this doesn't work and you get several messages, one ending with some
phrase like "device not found or busy", the next one saying something
like "hint: this may be caused by incorrect resource settings" the
problem might be the resources (check PS2.EXE and lspnp). Or it might be
that quick boot is enabled. Or maybe the isapnp is enabled, either
because you didn't specify the --with\_isapnp=0 option, or you did, but
the kernel was compiled with its own ISAPNP configuration enabled (in
which case the alsa drivers will use the kernel's internal isapnp, NOT
the settings you specify to modprobe). If you think resource settings
are the problem, recompiling the alsa drivers using --with\_debug=detect
or --with\_debug=full may help. If you really want some debug messages,
edit the sound.h file in the kernal drivers and recompile the kernel
(you may need to manually modprobe soundcore and snd to prior to
attempting the load of cs4236 to see this).

Recommendation 6
----------------

Otherwise, modprobe should have gone through with no errors. If you do
an

` `

    lsmod | grep snd

you should see something like this:

` `

    snd-cs4236              2160   0  (unused)
    snd-cs4236-lib         10160   0  [snd-cs4236]
    snd-opl3-lib            5360   0  [snd-cs4236]
    snd-hwdep               3376   0  [snd-opl3-lib]
    snd-cs4231-lib         13616   0  [snd-cs4236 snd-cs4236-lib]
    snd-pcm                55744   0  [snd-cs4236-lib snd-cs4231-lib]
    snd-timer               9744   0  [snd-opl3-lib snd-cs4231-lib snd-pcm]
    snd-mpu401-uart         2736   0  [snd-cs4236]
    snd-rawmidi            11968   0  [snd-mpu401-uart]
    snd-seq-device          3744   0  [snd-opl3-lib snd-rawmidi]
    snd                    24576   0  [snd-cs4236 snd-cs4236-lib snd-opl3-lib snd-hwdep snd-cs4231-lib snd-pcm snd-timer snd-mpu401-uart snd-rawmidi snd-seq-device]
    soundcore               3632   0  [snd]

Also, after the modprobe works, for the first time you should have a
/proc/asound directory, and cat `/proc/asound/cards` should show
something like this:

` `

    0 [CS4237B        ]: CS4237B - CS4237B
                         CS4237B at 0x530, irq 5, dma 0&1

Recommendation 7
----------------

Now finish building and installing the alsa libraries per the
instrutions (unpack the tarballs, enter the directories, execute

` `

    ./configure && make && make install

Recommendation 8
----------------

At this point, even without fiddling with alsamixer, go to a directory
with a sound file and type

` `

    aplay FILENAME

You should get a message like "Playing WAVE 'horse.wav' : Unsigned 8
bit, Rate 11025 Hz, Mono" if FILENAME (for example) is a wavefile called
horse.wav. If in addition you get "aplay: pcm\_write:999: write error:
Input/output error" then it is likely that your dma's are reversed! In
my case, if I got this with the above modprobe, I would remove the
snd-cs4236 module:

` `

    rmmod -r snd-cs4236

and retry with the dma's switched:

` `

    modprobe snd-cs4236 port=0x530 cport=0x538 irq=5 dma1=0 dma2=1

Recommendation 9
----------------

OK, now we are in the home stretch. Run `alsamixer`. \<Master D\> in the
leftmost column should be red. Hit the "M" key on the keyboard to make
the MM at the top disappear: otherwise the Master Digital will be muted.
Then use the pageup to get the volume up. In my case, I have to get this
up almost to the red zone (around 73)-- maybe you don't need as much
volume. Then, hit the right arrow six times so PCM is red. Again, unmute
it with the "M" key and use pageup to get the volume up (I went to 71).

Now use `aplay FILENAME` to play FILENAME. It should work.

Recommendation 10
-----------------

Finally, you should set yourself in the audio group and set up linux to
run amixer with the right settings on bootup so the volume is ready to
go. You probably want to give the CD player some volume, too.

--[Greg Lindauer](/User:GregLindauer "User:GregLindauer")

More hints
----------

These following steps were needed on a recent installation of Ubuntu
Hardy Heron. First, it really likes to try to load cs4232 module, which
results in a kernel OOPS. You'll need to use the cs4236 module instead.
First, place "blacklist snd\_cs4232" to /etc/modprobe.d/blacklist. Then
put these commands in /etc/rc.local:

    echo 'activate' > /sys/devices/pnp0/00\:0e/resources
    echo 'activate' > /sys/devices/pnp0/00\:0f/resources

    modprobe snd_cs4236 isapnp=0 port=0x530 cport=0x538 irq=5 dma1=1 dma2=0

See also
--------

-   Back to the [cs4232](/Cs4232 "Cs4232")
-   Back to the [cs4236](/Cs4236 "Cs4236")
-   the links at [ThinkPad](/ThinkPad "ThinkPad")

Retrieved from
"[http://alsa.opensrc.org/ThinkPad600](http://alsa.opensrc.org/ThinkPad600)"

[Category](/Special:Categories "Special:Categories"): [Sound
cards](/Category:Sound_cards "Category:Sound cards")

