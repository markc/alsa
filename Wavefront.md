Wavefront
=========

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Hi, I was trying to get my Turtle Beach Maui Card running, but was not
succesful. The Maui is a standalone wavetable isa board, that needs to
be initialized with a firmware and then emulates a MPU401 interface. I
got the card running in my windows 98 test and gaming system. Somebody
got any hints?

What I tried until now:

Downloaded firmware:
[ftp://ftp.voyetra.com/pub/tbs/wavefrnt/wfsdk095.zip](ftp://ftp.voyetra.com/pub/tbs/wavefrnt/wfsdk095.zip).
In this file there seems to be the firmware file (dos/OSWF.MOT). I
processed this file with the flex program given in the documentation of
the OSS kernel driver by Paul Barton Davis, as I assumed the processing
needed is the same. You may find this in
Documentation/sound/oss/Wavefront in the kernel sources. Copied here for
you convenience:

` `

    %%
    ^S[28].*\r$ printf ("%c%.*s", yyleng-1,yyleng-1,yytext);
    <<EOF>> { fputc ('\0', stdout); return; }
    \n {} 
    .  {}

To use it, put the above in file (say, ws.l) compile it like this:

` `

    shell> flex -ows.c ws.l
    shell> cc -o ws ws.c

and then use it like this:

` `

    ws < my-copy-of-the-oswf.mot-file > /etc/sound/wavefront.os

* * * * *

Then I tried to load the module with:

` `

    modprobe snd-wavefront ics2115_port=0x330 ics2115_irq=12 ospath=/etc/wavefront.os enable=1 wf_raw=1

I'm pretty sure the port is correct and the irq is set set via the io
ports as far as I know. I've checked that the irq is free. I've got no
/etc/sound, so I changed the path from the instructions above. To be
sure I included the further options to enable the board and force
firmware loading. All other options I left out, since i assumed these to
specific to Tropez cards that have additional wave outputs.

What I got in dmesg output is:

` `

    pnp: the driver 'wavefront' has been registered
    pnp: the driver 'wavefront' has been unregistered
    No WaveFront cards found or devices busy

I think that I'm not far from the solution and therefore added this
instruction. I hope somebody finds the missing part. Then lets add the
output of modinfo:

` `

    /sbin/modinfo snd-wavefront
    author:         Paul Barton-Davis <pbd@op.net>
    description:    Turtle Beach Wavefront
    license:        GPL
    parm:           index:Index value for WaveFront soundcard.
    parm:           id:ID string for WaveFront soundcard.
    parm:           enable:Enable WaveFront soundcard.
    parm:           isapnp:ISA PnP detection for WaveFront soundcards.
    parm:           cs4232_pcm_port:Port # for CS4232 PCM interface.
    parm:           cs4232_pcm_irq:IRQ # for CS4232 PCM interface.
    parm:           dma1:DMA1 # for CS4232 PCM interface.
    parm:           dma2:DMA2 # for CS4232 PCM interface.
    parm:           cs4232_mpu_port:port # for CS4232 MPU-401 interface.
    parm:           cs4232_mpu_irq:IRQ # for CS4232 MPU-401 interface.
    parm:           ics2115_irq:IRQ # for ICS2115.
    parm:           ics2115_port:Port # for ICS2115.
    parm:           fm_port:FM port #.
    parm:           use_cs4232_midi:Use CS4232 MPU-401 interface (inaccessibly located inside your computer)
    parm:           wf_raw:if non-zero, assume that we need to boot the OS
    parm:           fx_raw:if non-zero, assume that the FX process needs help
    parm:           debug_default:debug parameters for card initialization
    parm:           wait_usecs:how long to wait without sleeping, usecs
    parm:           sleep_interval:how long to sleep when waiting for reply
    parm:           sleep_tries:how many times to try sleeping during a wait
    parm:           ospath:full pathname to processed ICS2115 OS firmware
    parm:           reset_time:how long to wait for a reset to take effect
    parm:           ramcheck_time:how many seconds to wait for the RAM test
    parm:           osrun_time:how many seconds to wait for the ICS2115 OS
    vermagic:       2.6.6 preempt 686 gcc-3.3
    depends:        snd-cs4231-lib,snd-opl3-lib,snd-mpu401-uart,snd-rawmidi,snd-hwdep
    alias:          pnp:cCSC7532dCSC0000dCSC0010dPnPb006dCSC0004*
    alias:          pnp:cCSC7632dCSC0000dCSC0010dPnPb006dCSC0004*

Update
------

Changed port address to eliminate chance of port conflict with other,
yet unconfigured sound cards. Now the card is using port 0x260 according
to
[http://www.turtlebeach.com/site/kb\_ftp/5603004.asp](http://www.turtlebeach.com/site/kb_ftp/5603004.asp)
Checked the reinserted card. Still the problem remains.

Thanks, Martin

Retrieved from
"[http://alsa.opensrc.org/Wavefront](http://alsa.opensrc.org/Wavefront)"

[Category](/Special:Categories "Special:Categories"): [ALSA
modules](/Category:ALSA_modules "Category:ALSA modules")

