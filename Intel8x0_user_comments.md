Intel8x0 user comments
======================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

This file contains all the user comments about the
[intel8x0](/Intel8x0 "Intel8x0") chipset, which were made in the past.

* * * * *

6-24-2004 Anyone have any luck getting multi-channel output from
NForce2? Alsa works great to get output on the standard headphone/front
output, but I can't get any sound on the other outputs. /proc shows me
that it's setup 2 pcm outputs (0,0 and 0,2) but the second does not
produce sound on any channel... Running Kernel 2.6.6, Alsa 1.04rc2

* * * * *

Can't run TeamSpeak and Quake3 at the same time!! Is There something I
miss??? I allready ready Teamspeak who-to and linux-gamers who-to but I
dosen't work PLEASE HELP! Debian sid NForce 2 MCP

Thanks \*\*

* * * * *

Is there any easy-to-understand, well written documentation available? I
need a numbered, step-by-step, list of instructions to follow so I can
figure out how to turn on the sound on my linux red hat 9.0 optiplex
gx270 system.

* * * * *

12-23-2003

Hi,

I am using a Soltek SL-B7A-F board with a NForce2 chipset. Sound plays
just fine with ALSA 1.0.0 RC2, but I need to passthrough sound coming
from a DVB-card. Therefore I would plug the line-out cable of the DVB
card into a line-in on the back panel - but the mainboard manual says
these are front, back and LFE channels. Two more ports are on the front
panel, labelled mic-in and something like input/output. Unfortunately I
can't plug the DVB audio source into one of these ports, the cable ist
just about 20 cm long ;/

Can I switch one of the ports on the back panel so it acts like a
line-in? I don't want the cable go to the front, and since any soundcard
always had an input on the back, I think this should be possible...

* * * * *

12-17-2003

Hi people, and thanks to all people thats will lose time to help me.
i've a P4C800 Deluxe with (i suppose) a I8x0 audio card integrated.
(lspci)-\> 00:1f.5 Multimedia audio controller: Intel Corp.: Unknown
device 24d5 (rev 02) I've read some thread about my audio card and
follow some "FAQ" that can help me (as they said) but my card doesnt
work. I've try with OSS ad ALSA driver, down here i will past dmesg
messages: (alsa)-\> Advanced Linux Sound Architecture Driver Version
0.9.7 (Thu Sep 25 19:16:36 2003 UTC). request\_module: failed
/sbin/modprobe -- snd-card-0. error = -16 PCI: Setting latency timer of
device 0000:00:1f.5 to 64 AC'97 0:0 analog subsections not ready
intel8x0: clocking to 48000 ALSA device list:

     #0: Intel ICH5 at 0xfebff800, irq 17

\<-(alsa)

(oss)-\> i810\_audio: Primary codec has ID 0 i810\_audio: Audio
Controller supports 6 channels. i810\_audio: Defaulting to base 2
channel mode. i810\_audio: Resetting connection 0 i810\_audio:
Connection 0 with codec id 0 ac97\_codec: AC97 Audio codec, id: ADS117
(Unknown) i810\_audio: AC'97 codec 0 supports AMAP, total channels = 6
i810\_audio: setting clocking to 48669 \<-(oss)

I'm apologize for my english, and i thanks all people that will help me.
Some one can help me?

-- valk \<valk@mojodo.it\>

* * * * *

Has anyone gotten 6 channel support to work with the nForce2 on the
A7n8X Deluxe? --- Will this driver support the Asus P4P800 board with
the intel ICH5 chipset? Someone lower down says it needs the CVS version
for another P4P board, is that still true?

-\> I have a Asus P4C800 board and it works. I have Debian testing
installed. But I have problems with playing Audio-CDs with Kscd. The
sound is ok, but the System freezes from time to time a few seconds.
UPDATE: My problem is not related to the intel8x0-driver, it seems to be
a general problem with the cdrom drive.

* * * * *

Hello, someone, apparently, maliciously deleted this wiki-page, so I
went through the history, and ressurrected it.

\
 ---

Teamspeak + nforce2 builtin audio, how to use virtual sound channels ?

ie i need a device (/dev/dsp)? for quake3 and i need a device
(/dev/dsp1)? for teamspeak and so on ..

how to achieve this with alsa drivers ? tks

-   -   update on the above\*\*

1- i read this
[http://www.teamspeak.org/forums/showthread.php?s=3dfa194cd7a0b7ce1ed6a7bb78360996&threadid=1989](http://www.teamspeak.org/forums/showthread.php?s=3dfa194cd7a0b7ce1ed6a7bb78360996&threadid=1989)
and i read this
[http://www.teamspeak.org/forums/showthread.php?s=3dfa194cd7a0b7ce1ed6a7bb78360996&threadid=1989](http://www.teamspeak.org/forums/showthread.php?s=3dfa194cd7a0b7ce1ed6a7bb78360996&threadid=1989)

so the status is, i tryed the aproach given there but that doesnt work,
and after reading the 2nd post im more confused. I did searched google,
and i dont find nothing niet rien nada, just people complaining about
the same problem Quake3 will not open /dev/dsp when TS is running. And
no one seems to know the answer.

\
 2- another strange bit i get its to initialize quake3 with

quake3 +set s\_initsound 0 I can start the game, without no sound
ofcourse, but with TS sound. I can play skirmish mode, or single player,
and listen ppl speaking on TS, but as soon as i get online or switch to
another quake3 mod like reaction quake, urbanterror, OSP etc the game
starts, ie the map loads, i can move the mouse 360Âº i can switch/change
gear, etc, but as soon as i press forward right, or to go left the game
will crash with

Welcome To Urban Terror 2.6 Received signal 8, exiting... Shutdown tty
console

a mem related problem ? probably, but this happens in 2 diferent OSes,
so itnst a ALSA problem afaik

anyhelp would be appreciated. tks

From deelight@logeek.com : I have exactly the same problem and i didn't
manage to solve it yet...

* * * * *

\

* * * * *

Gericom Laptops:

They have the SiS chipset, but the intel8x0-driver bundled with
alsa-0.9rc6 does not work. I can only play sound from CD.

The PCM does not work. The Mixer does work though, muting/unmuting the
master volume produces klicking noises on the speakers.

This problem was solved in the latest alsa build from cvs (and alsa
version later than 0.9rc6, I suppose...)

Thanks to the alsa guys and also to Gericom which provided a commercial
license for OSS commercial drivers to its customers (though it's
commercial, it was great that a company make an effort towards its
customers who want to use Linux !)

* * * * *

Gigabyte 8SIML Motherboard onboard SiS7012 soundcard:

Digital out seems to be locked at 48Khz, great for dvd playback, but
when playing back an mp3 in Xmms at 44.1Khz, the digital out gets
disabled.

The windowz driver manages to switch the digital out to different rates,
so it can't be a hardware issue.

* * * * *

Toshiba S3000-X4

ALSA docs say it is locked at 48000Hz, but it worked fine for me with
XMMS at any rate.

However, it does not work with 0.9rc6. I am seriously considering
downgrading to rc5 or the "stable" branch.

* * * * *

The Nvidia nforce2 motherboards use this chip for their onboard sound.

I've found that xmms plays mp3s too fast though. Is there an option to
force it to do 48000 playback?

UPDATE: The nForce chip doesn't use this chip for it's sound, it uses
the same programming api as the nForce APU is a much better chip than
the intel. Also, I managed to get the nvaudio kernel module from nvidia
to compile and it works a charm.

\

* * * * *

You can manually set the ac97 clock by adding to /etc/modules.conf (or
equivalent):

options snd-intel-8x0 ac97\_clock=41194

However. with an nforce2 board, the playback speed cycles between normal
and too fast every time the sound device is closed then opened again.
This is much better then previous releases (or the OSS driver) which
changed speeds in mid-song, but it's still nagging.

\

* * * * *

Has anyone gotten SPDIF passthrough working with the nForce2 (found on
A7N266-VM mobos) chipset?

I don't think that motherboard got a nForce2 chipset. According to my
manual it's a nForce chip.

* * * * *

Has anyone gotten SPDIF passthrough or capture to work with a Suttle
SSG51G? The 0.95 driver has got IEC958 controls in alsamixer but they
have no effect. Any help much appreciated as this has been driving me
nuts for weeks.

* * * * *

I'm another user and I'm also having this problem with Alsa 0.9.2 driver
on Shuttle XPC SS51G. I can make changes with the IEC958 controls in the
alsamixer (and alsamixergui) that show up on the mixer form but they
have no effect on the sound output from the front SPDIF connection
(SPDIF output works fine with Windows XP--system is dual boot). It
really is frustrating.

UPDATE 2003-07-31: Problem is SOLVED. Thanks to a tip from Ole Andre
Schistad (oschista@chello.no) on the alsa-project.org web site under
documentation for the Intel i820 card options. The solution is to
compile the ALSA drivers, libs and utils with "cvscompile". According to
Ole, "The S/PDIF support in this chipset currently requires a CVS
version of ALSA...the required device under /dev/alsa is not created
with the "release" drivers..." I'm using ALSA version 0.9.6.

* * * * *

2003-08-19 Yes, cvs makes the IEC958 Passthrough work, however on my MSI
Mega 651, it refuses to send Analog to IEC958. I have obviously enabled
this option but it's still empty sound, analog is still being output so
it does in essence fully function but requires 2 connections and
sometimes manually switching your receiver.

22 Feb 2004

I use alsa 1.0.0rc2 and MSI MEGA, and i get pcm output from xmms, esd,
and others to optical SPDIF only after i run this:

1.  iecset audio on

after that i can use pcm and 5.1 output from dvd player to optical
SPDIF!

\

* * * * *

I can't get this to work on ASUS P4P800-VM. alsamixer reports the driver
and the AD1980 codec (SoundMAX) but I have no sound on neither RCA
ports.

* * * * *

2003-08-24

Hi,

I find some solutions to play correctly mp3 at any rate to the spdif
output (intel810 on a Nvidia NForce2: Shuttle SN41G2).

Of course you should use ALSA CVS version and set correctly alsamixer.

All solutions use resampling methods:

1.  solution 1 resampling at mp3 stage

lame rox.mp3 --resample 48000 - | mpg123 -s - | aplay -v -c2 -f S16\_LE
-r 48000 -D spdif

1.  solution 2 resampling at pcm raw stage

mpg123 -s rox.mp3 | sox -t raw -r 44100 -s -w - -t raw -r 48000 -s -w -
resample | aplay -v -c2 -f S16\_LE -r 48000 -D spdif

1.  solution 3 use mplayer

mplayer -srate 48000 -ao alsa9:spdif rox.mp3

The last solution consist in using alsa-xmms plugins and xmms-crossfade
plugins - with xmms select Crossfade as the output plugin - configure It
to use the alsa-xmms as the output plugin (not the builtin oss) - change
the sample rate to 48000 Hz - then configure the alsa-xmms to use the
spdif (select User define: and write spdif in the field)

Hope it will work with you... enjoy ;o), Damscot.

* * * * *

UPDATE 2003-07-31: Problem is NOT solved for me. The solution is to
compile the ALSA drivers, libs and utils with "cvscompile".

=\> not work for me i have shuttle SS51G Can you send your asound.state
and your mplayer param for play DVD please? maybe your /root/.asoundrc
too ? maybe is my fault ?

* * * * *

Audio problem on Dell Dimension 4600

I am working on the audio solution for this PC running RH8.0. So far I
have not got one note out of it.

The Intel site suggests for RH8.0 linux and this motherboard (Intel
D865PESO) to use the driver, ADI Integrated Audio
Driver?[alsa\_driver\_0.9.1adi\_rev5.tar.gz]. This driver installed OK
as per instructions. I have also installed alsa-lib-0.9.1 and
alsa-utils-0.9.1.

The sound modules load with modprobe (I check with lsmod) but do not
work, for example, if I try to play an mp3, I get the message

"couldn't open audio; Please check that 1. you have the correct output
plugin selected 2. no other program is blocking the soundcard 3. your
soundcard is configured correctly OK" (I do not know how to do any of
these 3 checks).

The KDE utility "system settings/soundcard detection" says: Vendor:
unknown vendor Model: generic snd-intel8x0 device Module: snd-intel8x0
"test" produces nothing; an audio cd likewise.

I ensure the mute is turned off by running alsamixer. I also tried:
amixer -c 0 sset Headphone,0 55 unmute and for speaker jacks: amixer set
PCM 100 unmute

Dell has informed me "the 1980 audio solution uses the AC97 2.2
compliant digital bus from the ICH5 and the Analog Devices ADI1980 AC97
CODEC."

However it seems clear the motherboard is the Intel D865PESO model, and
the Intel website shows this model uses the Analog Devices AD1985 codec,
not 1980.

I have also tried using alsa\_driver\_0.9.6.

Any suggestions for further action would be much appreciated.

Greg

* * * * *

19-9-2003

Even easier to 'fix' the output frequency: use esound. Launch with 'esd
-r 48000', and have all programs output to esd. All works fine!

(on an Asus L3000D laptop)

* * * * *

28-10-2003

Alternative fix for the output frequency, using artsd (enabled by
default in KDE): add the option "-r 48000". Unfortunately, in KDE3 you
cannot set this with the graphical control center. Here is a two steps
receipt: 1) start the sound system control center (Settings-\>Control
Center-\>Sound & Multimedia), modify any option and apply it (this will
create your config file) 2) edit the \$HOME/.kde/share/config/kcmartsrc
file and change the line Arguments: Arguments=\\s-F10 -S 4096 -r 48000
-s 60 -m artsmessage -l 3 -f

                            ^^^^^^^^^

(tested on KDE 3.1.4 and ASUS L3000D laptop)

* * * * *

23-9-2003

Hi, I am having massive problems getting my nForce2 APU to work, it's
easy enough to get it to work with arts, but, alsa, no go. If i set arts
to use OSS there is no errors and it works, but the problem is that only
one device can use OSS at once. I have tried to use the alsa driver
snd-intel8x0 but it returns that it cant find the card, I also tried
using the nvaudio driver with which alsa sesms load properly but when i
try to use it i get a "unable to open default device" error, also when I
"cat /proc/asound/cards" it returns "no soundcards". Everything else
works, video, IDE, TV card, just not sound. :(

Please please, I am getting desperate, please contact me at
gnif@spacevs.com if you can help, I am using Debian 3.0r1 Woody with a
2.4.20 kernel (I compiled for the nForce2 chipset).

PS: I am very much a linux noobe.

here is my modules conf: alias char-major-116 snd alias snd-card-0
nvaudio alias char-major-14 soundcore alias sound-slot-0 snd-card-0
alias sound-service-0-0 snd-mixer-oss alias sound-service-0-1
snd-seq-oss alias sound-service-0-3 snd-pcm-oss alias sound-service-0-8
snd-seq-oss alias sound-service-0-12 snd-pcm-oss options snd
snd\_major=116 snd\_cards\_limit=1 snd\_device\_mode=666

alias /dev/mixer snd-mixer-oss alias /dev/dsp snd-pcm-oss alias
/dev/midi snd-seq-oss

\

23-10-2003

Hi, I've got quite similar problems with sound as gnif@spacevs.com; I
have an Epox 8RDA3+ with C-Media sound chip. Sound works when loading
the kernel modules ac97codec and i810\_audio, but only for OSS output.
That's not enough, because if arts is playing sound, xmms can't access
the sound device. If someone has a solution or knows a howto for this,
please tell it on this Wiki site. Thanks.

11-19-2003 (19.11.2003) to gnif@spacevs.com: AFAIK nvaudio is an oss -
module, not an alsa module. You should decide to use either OSS or ALSA,
not both. If you can use arts you shouldn't need any more. Arts does
mixing in software and sends the mixed stream to the driver. (Only the
arts deamon opnes the device, all audio apps should send their data to
arts) Configure XMMS to use an arts output plugin - this should be
enough. ARTS output plugins are at xmms.org

I have an Epox 8RDA3+ as well. I get sound with Alsa 0.9.6 when I use
ALSAs' OSS emulation . Without the OOS emulation, I get: ALSA
snd\_pcm\_hw\_params\_set\_period\_size error: Invalid argument. I
haven't yet figured out what that means. The other issue here for me is
that the AC97 codec (the C-Media CMI9738 chip itsself) does not have a
hardware PCM-out volume control. So I get sound but can't change the
volume.

04-21-2004 (21.04.2004) from: gnif@spacevs.com \>\>Arts does mixing in
software and sends the mixed stream to the driver But I know that the
nforce2 APU can do hardware mixing, hell, even windows can!. Software
mixing is just slow and bulky, and doesn't help as arts can't be used
with the games I run (AA). To overcome this limitation I have installed
a SB Live and disabled the onboard audio, but this is only a temporary
workaround. Since my last post I have tried using gentoo (Great falvor),
it even includes all the nforce support in the kernel by default, I had
sound & video working with no problems, except for only 1 program can
use /dev/dsp at once. Also, it has been a few months since I last
checked the nforce drivers from nvidia, the latest version may have
fixed this problem. PS: I have given up with alsa, it is easer to use
the OSS drivers.

* * * * *

17-10-2003

Did anyone get ac3 passthrough spdif working on a dell inpiron (8200)
laptop ?? I got spdif working only i can't get the ac3 (Dobly digital)
passthrough spdif working...

I used 0.9.7 and the cvs releases , no luck :(

* * * * *

26-10-2003

I have a new motherboard with built-in audio (DFI PS83-BL with C-Media
9739A). Kudzu recognizes it as "Intel Corp.|82801EB AC'97 Audio" and
assigns the snd-intel8x0 driver to handle it. Problem is, I cannot
control the volume on audio generated from the CPU. For example, from
XMMS. In ALSA 0.9.2 and my SoundBlaster card, the PCM control controlled
the volume for XMMS. I installed ALSA 0.9.8 and the PCM for my current
audio chip is a binary control! That's right: I can turn it off and on.
No settings in between. Does anyone know what the story is on this?
Thanks.

\

* * * * *

29-10-2003

I have a SiS 7012 (i8x0 compatible). I know that it is a cheap piece of
chip (some people may say that it is just a piece of s\*\*t :). But i
still dont know if it is easy to use Full duplex, Software or hardware
pcm volume setting, the midi port... say with alsa (nor with oss?).

* * * * *

03-11-2003

I seem to have a similar mainboard (mine is ASRock). Very cheap thing
with many problems afaics. Could you explain, how you got yours working
fine? Any problems? What ACPI-Options did you set? I get a bit of sound
with the oss kernel driver, but very very lacky. I'm currently trying to
set up alsa, but still can't hear anything. One error I get is the
following

aplay /usr/kde/3.2/share/sounds/pop.wav \# wait 10sec here for output to
be displayed Playing WAVE '/usr/kde/3.2/share/sounds/pop.wav' : Signed
16 bit Little Endian, Rate 44100 Hz, Mono

1.  wait another 10sec

ALSA lib pcm\_hw.c:524:(snd\_pcm\_hw\_drain) SNDRV\_PCM\_IOCTL\_DRAIN
failed: Input/output error still no sound, program finished.

    Bus  0, device   2, function  7:
       Multimedia audio controller: Silicon Integrated Systems [SiS] Sound Controller (rev 160).
         IRQ 5.
         Master Capable.  Latency=32.  Min Gnt=52.Max Lat=11.
         I/O at 0xdc00 [0xdcff].
         I/O at 0xd800 [0xd87f].

any ideas? any help?

* * * * *

11-18-2003 The "can't change volume with C-Media 9739A" is a hardwar
issue. The chip itsself does not have a hardware PCM-Out volume control.
The only thing you can cahnge in the relevant register is the mute bit.
Thats's why some mixers represent it as as binary switch, checkbox or
similair. I was wandering if one could use alsa-libs module architecture
to do volume control in software. Haven't figured that out yet.

* * * * *

11-26-2003 Any news on the C-Media 9739 alias 82801EB issue? I also have
the on-off effect... And: only the FRONT-out works. Don't know how to
acitivate REAR and SUB.

* * * * *

12-03-2003 Got the same MB : DFI PS83/BL with i865pe on mandrake 9.2
with alsa the i8x0 driver gives no sound at all... (kernel
2.4.22mdk-smp) the insmod returns error of unresolved symbol and so
on... any idea ?

* * * * *

12-03-2003 I'm having some weird problems with my SiS 7012 card, when I
try and run StepMania (It's a DDR emulation program) I get this error.

ALSA: Advanced Linux Sound Architecture Driver Version 0.9.6. ALSA
Driver: 0: SiS SI7012 [SI7012], device 0: Intel ICH [SiS SI7012], 1/1
subdevices avail Couldn't load driver ALSA9: Driver unusable (not enough
mixing streams) Sound driver: ALSA9-sw

And then the sound plays all warped and messed up. However, in XMMS and
whatnot, while using the ALSA plugin, there aren't any problems and
playback is perfect. When I try and play an .mp3 with mpg123, using the
ALSA driver, the sound is messed up (its a little different than
StepMania, but its static-y all the same) and I have a feeling its a
similar problem. Unfortunately mpg123 doesn't give me any errors about
it. I had a feeling it was because my sound card is a pos, but I don't
know how to go about setting it up. It seems that it knows what card to
use, so I don't understand the problem. And ideas?

* * * * *

Jan 02, 2004

Hullo. I have problems with an old A7N266-C mobo. My sound is all jumpy,
Winamp3 statics all the time (W3 linux build 488). Anyone has a clue on
this?&

* * * * *

Jan 07, 2004

Hi! I have a nForce1 mobo and I'm trying to use alsa (kernel 2.6
built-in) with the intel8x0 driver. I get no error messages and
/proc/asound shows the card (and yes, I have unmuted master, pcm,... in
alsamixer), but I can't play any files (I can play CDs, though). The pcm
slider in KMix keeps dropping to zero... Thanks for any help!

* * * * *

Jan 21, 2004

I have an SIS7012, Debian unstable,Using Alsa driver 1.0.1 compiled
through 2.6.0. Alsa libs 1.01. Application independant problem

    All audio other than CD audio is scratchy with pops. I have tried upgrade, downgrade etc all to no avail.

Aside: xmms crashes on using alsa output so i use esd.

     The sound quality was fine but seemingly without reason has degraded.

Any advice as to how i can solve this prblem is greatley apreciated

Jasper

* * * * *

Jan 21, 2004

I have problems getting the mixxing to work with my cmedia 9739A based
via kt-600 based msi-delta fisr motherboard. It is really annoying, is
there any work in progress or should i look for another soundcard?

Ashtar

* * * * *

Feb 13, 2004

I installed 0.9.4 alas on a Debian box with an Asus P4P800 motherboard.
Followed these instructions, turned up the mixer and get no sound. The
sndcard is identified as "Intel 82801EB AC97". Any output to /dev/dsp
hangs for a long time, and then it starts going. Xmms gives me nice
little bars going up and down. Still no sound. Tried many permutations.
Kernel version is 2.4.20. Would prefer not to upgrade since it's got all
the nVidia extensions installed and working.

1.  cat /dev/sndstat

Sound Driver:3.8.1a-980706 (ALSA v0.9.4 emulation code) Kernel: Linux
Shawn.stone 2.4.21 \#1 Sun Aug 3 20:15:59 PDT 2003 i686 Config options:
0

Installed drivers: Type 10: ALSA emulation

Card config: Intel ICH5 at 0xfebff800, irq 5

Audio devices: 0: Intel ICH5 (DUPLEX)

Synth devices: NOT ENABLED IN CONFIG

Midi devices: NOT ENABLED IN CONFIG

Timers: 7: system timer

Mixers: 0: Analog Devices AD1985

1.  lspci -v

\>\>snip\<\<

00:1f.5 Multimedia audio controller: Intel Corp.: Unknown device 24d5
(rev 02)

           Subsystem: Asustek Computer, Inc.: Unknown device 80f3
           Flags: bus master, medium devsel, latency 0, IRQ 5
           I/O ports at e800 [size=256]
           I/O ports at ee80 [size=64]
           Memory at febff800 (32-bit, non-prefetchable) [size=512]
           Memory at febff400 (32-bit, non-prefetchable) [size=256]
           Capabilities: [50] Power Management version 2

\>\>snip\<\<

Is it time to slap an old sound card in?

* * * * *

Hi, I have a Gigabyte 8Knxp which is nearly similar to the Asus Board,
00:1f.5 Multimedia audio controller: Intel Corp. 82801EB AC'97 Audio
Controller (rev 02)

i got the sound to work after many hours. I tried the dmix howto, i can
now play 2 sounds at once. I installed the latest alsa drivers on
debian/sid. The main problem is that i have no Microphone input, and
canÂ´t use quake3 while xmms is running, it hangs at the sound
initialisation.

cat /proc/asound/pcm 00-00: Intel ICH : Intel ICH5 : playback 1 :
capture 1 00-01: Intel ICH - MIC ADC : Intel ICH5 - MIC ADC : capture 1
00-02: Intel ICH - MIC2 ADC : Intel ICH5 - MIC2 ADC : capture 1 00-03:
Intel ICH - ADC2 : Intel ICH5 - ADC2 : capture 1 00-04: Intel ICH -
IEC958 : Intel ICH5 - IEC958 : playback 1

I think the main problem is, that the Linux driver handle all the
connectors on the back in a other way than windows. But i tried all of
them and none worked for me. Is there a script or tool that installs and
configures a working multisource playback? thx for your site! PS: the
sound goes over into noise after ca. 10 minutes, when i start a new song
its ok for a while. if you have tips. mail me: hayoshock@gmx.de

* * * * *

February the 14th 2004

Hi.

I have problems in geting the SPDIV to work. I have a Asus OEM board
with SiS7012. I installed the alsa-CVS version on my debian system.

I want the chip to use spdif als well as the normal output. I dono what
i did wrong or what i forgot. The M\$-Programloader can manage that so i
hoped i can do it in linux too. Cauz the singal via the optical-out is
much better then the analog.

i also have another problem. the mixer discards my volume-setings after
every reboot and i can't find out why.

i u can halp me plz contact me at chris\_dengler@web.de

thx Chris

* * * * *

William Blew: I have my nforce2 board's S/PDIF optical output working
from both the alsa and oss APIs with the ALSA 1.0.2c drivers.

For comparison, my configuration is an ABIT NF7-S rev 2 mobo. This board
uses the nforce2 SPP chipset with a MCP2-T southbridge.

I am using my motherboard's optical S/PDIF output to connect to my
digital home speaker system from Cambridge SoundWorks (the DTT3500).

I am using a linux kernel 2.6.3 that includes alsa-driver 1.0.2c.

I have installed alsa-lib, alsa-oss, and alsa-tools 1.0.2. The trick to
get the OSS emulation working is that our motherboards' optical S/PDIF
is the pcmC0D2p device. However, ALSA's oss emulation defaults to using
pcmC0D0p. Hence no sound by default. :(

For OSS emulation device mapping:
[http://www.alsa-project.org/\~iwai/OSS-Emulation.html](http://www.alsa-project.org/~iwai/OSS-Emulation.html)

I use Gentoo Linux with devfsd (hence some unusual alias entries in my
modules.conf). Here is my modules.conf file. The options for snd-oss-pcm
is the key piece of magic, as they map the oss devices to the pcmC0D2p
device instead of the default pcmC0D0p device:

options snd cards\_limit=1 alias /dev/snd snd-card-0 alias /dev/sound
snd-card-0 alias /dev/sndstat snd-card-0 alias char-major-116 snd alias
snd-card-0 snd-intel8x0 options snd-intel8x0 mpu\_port=0x330 options
snd-pcm-oss dsp\_map=2 alias char-major-14 soundcore alias sound-slot-0
snd-card-0 alias sound-slot-1 snd-card-0 alias sound-service-0-0
snd-mixer-oss alias sound-service-0-1 snd-seq-oss alias
sound-service-0-3 snd-pcm-oss alias sound-service-0-8 snd-seq-oss alias
sound-service-0-12 snd-pcm-oss

In addition, the following enables a software mixing, rate converting
device for ALSA interfacing applications, the alsa device is "nforce".

It differs from the www wiki sites in that it uses hw:0,2 (not hw:0,1):

pcm.nforce-hw { type hw card 0 } pcm.!default { type plug slave.pcm
"nforce" } pcm.nforce { type dmix ipc\_key 1234 slave { pcm "hw:0,2"
period\_time 0 period\_size 1024 buffer\_size 32768 rate 44100 } }
ctl.nforce-hw { type hw card 0 }

The mplayer (as of version 1.0pre3) can be used with the above
configuration:

        mplayer -ao alsa9:nforce <other_options> <file>

Alternatively, its oss driver can also be used:

        mplayer -ao oss <other_options> <file>

BTW, with my setup, I have the outstanding sound issues: 1) AFAIK,
alsa's mixer doesn't affect the output in any way. 2) xine's alsa
support doesn't seem to work with this config 3) various media players'
(mplayer 1.0pre3 and xine) S/PDIF passthrough (aka hwac3) don't work.

I hope this helps.

* * * * *

I got exactly the same main-problem: the alsamixer doesn't affect the
output in any way (I'd like to regulate the analog output)

my hardware: nforce (ep-8rda3i) my kernel: linux kernel 2.6.3
(alsa-driver 1.0.2c.)

So my main question is, if this is an hardware/alsa problem, or if i
just made some configuration mistakes ?

* * * * *

Have been tearing my hear out trying to get Alsa drivers working on ASUS
P4P800S board. After runninging in circles recompiling etc etc etc like
everybody, found a ref on a forum about multichannel and this chipset.
Had the idea to plug speakers into Mic jack, hey presto it all works. I
am running MDK 10beta2 with kernel 2.6.2 May be someone knows how to you
can fix this err, bug/oversight?

hope this helps peoples stress levels :-)

msymons@westnet.com.au

* * * * *

Here is my sad experience:

NForce2 (WinFast K7NCR18D-Pro) kernel 2.6.3 alsa 1.0.3 all parts (also
tried 1.0.2c which came with kernel + 0.98 userland)

It works but the quality is evasive.

'alsaplayer -o alsa song.mp3' may advance through the song \~10% faster
than it should, or may work in sync - depending on the players which
were run before it! When it plays at normal speed, high pitches appear
err....cracked.

'aplay /mnt/c/WINDOWS/Media/Windows\\ XP\\ Logon\\ Sound.wav' sounds
really distorted though presumably at proper speed (it is 22Khz)

And everything sounds as ugly as if it was resampled several times back
and forth with quality losses.

If I create the file .asoundrc with the contents (as suggested at the
non-wiki card page): pcm.nforce-hw { type hw card 0 }

pcm.!default { type plug slave.pcm "nforce" }

pcm.nforce { type dmix ipc\_key 1234 slave { pcm "hw:0,0" period\_time 0
period\_size 512 buffer\_size 4096 rate 44100 } }

ctl.nforce-hw { type hw card 0 }

Then aplay segfaults. I tried all suggested .asoundrc files from i8x0
page (that redirect default to dmix), and they all segfault. Though, I
can run several parallel 'alsaplayer -o alsa -d plug: dmix song.mp3'
processes.

-(

P.S. Got an SB Live yesterday. All the mentioned problems disappeared
into thin air. ;-)

yar(nospam)@warlock.ru

* * * * *

Regarding: "alsa 1.0.3 all parts (also tried 1.0.2c which came with
kernel + 0.98 userland)"

I recommend using 2.6.3 with its natively provided 1.0.2c alsa-driver
set and with the 1.0.2 alsa userland packages (alsa-libs and alsa-utils
in particular). I have had some success with those versions. With 1.0.3
userland packages, it crashed with my 1.0.2c drivers and I can't get the
1.0.3 drivers to compile on my Gentoo Linux boxen. :(

* * * * *

Regarding compilation of 1.0.3 drivers at Gentoo:

symlink /usr/src/linux/arch/i386 as /usr/src/linux/arch/x86

and emerge it:

FEATURES="-sandbox" ACCEPT\_KEYWORDS="\~x86" ALSA\_CARDS='intel8x0'
emerge --buildpkg =media-sound/alsa-driver-1.0.3

yar(nospam)@warlock.ru

* * * * *

How can I make my IEC958 work? On a COMPAL CQ-12 laptop:

1.  cat /proc/asound/pcm

00-00: Intel ICH : Intel 82801DB-ICH4 : playback 1 : capture 1 00-01:
Intel ICH - MIC ADC : Intel 82801DB-ICH4 - MIC ADC : capture 1 00-02:
Intel ICH - MIC2 ADC : Intel 82801DB-ICH4 - MIC2 ADC : capture 1 00-03:
Intel ICH - ADC2 : Intel 82801DB-ICH4 - ADC2 : capture 1 00-04: Intel
ICH - IEC958 : Intel 82801DB-ICH4 - IEC958 : playback 1

and

1.  lspci -vv

00:1f.5 Multimedia audio controller: Intel Corp. 82801DB AC'97 Audio
Controller (rev 02) Subsystem: COMPAL Electronics Inc: Unknown device
0017 Control: I/O+ Mem+ BusMaster+ SpecCycle- MemWINV- VGASnoop- ParErr-
Stepping- SERR- FastB2B- Status: Cap+ 66Mhz- UDF- FastB2B+ ParErr-
DEVSEL=medium \>TAbort- \<TAbort- \<MAbort- \>SERR- \<PERR- Latency: 0
Interrupt: pin B routed to IRQ 17 Region 0: I/O ports at 1c00 [size=256]
Region 1: I/O ports at 18c0 [size=64] Region 2: Memory at d0000c00
(32-bit, non-prefetchable) [size=512] Region 3: Memory at d0000800
(32-bit, non-prefetchable) [size=256] Capabilities: [50] Power
Management version 2 Flags: PMEClk- DSI- D1- D2- AuxCurrent=375mA
PME(D0+,D1-,D2-,D3hot+,D3cold+) Status: D0 PME-Enable- DSel=0 DScale=0
PME-

\
 I get an output device in xmms saying:

Intel ICH - IEC958 : Intel 82801DB-ICH4 - IEC958 (hw:0,4)

but the playback does not start if I select it. xmms loads the music r
whatever, and then it stops. The spectrometer doens't show activity.
Also, in alsamixergui I can't switch it on (frozen bar)

What is this IEC958 and what can I use it for/how can I use it at all?

* * * * *

I upgraded fedora core to this kernel because of problems with the vfat
filesystem in 2.4\*\*\* -rwxr-xr-x 1 root root 14591451 Mar 18 19:05
kernel-2.6.3-2.1.253.2.1.i686.rpm -rwxr-xr-x 1 root root 2003596 Mar 18
19:08 kernel-doc-2.6.3-2.1.253.2.1.i386.rpm -rwxr-xr-x 1 root root
44355715 Mar 18 19:12 kernel-source-2.6.3-2.1.253.2.1.i386.rpm I then
used these packages for alsa: -rwxr-xr-x 1 root root 307527 Mar 19 18:47
alsa-lib-1.0.3a-1.i386.rpm -rwxr-xr-x 1 root root 799935 Mar 19 18:47
alsa-lib-devel-1.0.3a-1.i386.rpm -rwxr-xr-x 1 root root 118185 Mar 19
18:47 alsa-utils-1.0.3-1.i386.rpm

I edited /etc/modprobe.conf and inserted:

           # ALSA portion
           alias char-major-116 snd
           alias snd-card-0 snd-intel8x0

\# module options should go here

           # OSS/Free portion
           alias char-major-14 soundcore
           alias sound-slot-0 snd-card-0

\# card \#1 alias sound-service-0-0 snd-mixer-oss alias
sound-service-0-1 snd-seq-oss alias sound-service-0-3 snd-pcm-oss alias
sound-service-0-8 snd-seq-oss alias sound-service-0-12 snd-pcm-oss after
reboot I ran /sbin/modprobe snd-intel8x0 and as expected did not recieve
any output so i guess this was ok. I ran aumix and set my levels but
still didn't get any sound. I think maybe the on-board sound for Intel
850 chipset is not supported? If anyone has a step by step for this
please -\> i621148@removethis.hotmail.com Thanks

* * * * *

* * * * *

I have a Shuttle SN41G2 (nForce)and I recently installed Fedora Core 2
Test 2 (2.6.3 kernel) and 1.0.4rc2 ALSA on it. I can use aplay to play a
.wav but I can't get xine to play any audio at all thru the SPDIF
output. Here's my config. Please help.

ALSA Audio Debug v0.0.7custom - Fri Apr 2 16:10:57 EST 2004
[http://alsa.opensrc.org/?aadebug](http://alsa.opensrc.org/?aadebug)

Kernel ---------------------------------------------------- Linux
localhost 2.6.3-2.1.253.2.1 \#1 Fri Mar 12 14:01:55 EST 2004 i686 athlon
i386 GNU/Linux

Loaded Modules --------------------------------------------
snd\_pcm\_oss 43684 0 snd\_mixer\_oss 14848 2 snd\_pcm\_oss
snd\_intel8x0 31144 2 snd\_ac97\_codec 55172 1 snd\_intel8x0 snd\_pcm
83592 2 snd\_pcm\_oss,snd\_intel8x0 snd\_timer 25604 1 snd\_pcm
snd\_page\_alloc 8708 2 snd\_intel8x0,snd\_pcm snd\_mpu401\_uart 7808 1
snd\_intel8x0 snd\_rawmidi 21920 1 snd\_mpu401\_uart snd\_seq\_device
6920 1 snd\_rawmidi snd 45284 11
snd\_pcm\_oss,snd\_mixer\_oss,snd\_intel8x0,snd\_ac97\_codec,snd\_pcm,snd\_timer,snd\_mpu401\_uart,snd\_rawmidi,snd\_seq\_device

Modules Conf ---------------------------------------------- Warning:
/etc/modules.conf does not exist This means any kernel modules will not
be auto loaded See your linux distro docs on how to create this file

Modprobe Conf ---------------------------------------------- alias
sound-slot-0 snd-intel8x0 install snd-intel8x0 /sbin/modprobe
--ignore-install snd-intel8x0 && /usr/sbin/alsactl restore \>/dev/null
2\>&1 || : remove snd-intel8x0 { /usr/sbin/alsactl store \>/dev/null
2\>&1 || : ; }; /sbin/modprobe -r --ignore-remove snd-intel8x0

Proc Asound ----------------------------------------------- Advanced
Linux Sound Architecture Driver Version 1.0.4rc2. Compiled on Apr 2 2004
for kernel 2.6.3-2.1.253.2.1. 0 [nForce2 ]: NFORCE - NVidia nForce2

                        NVidia nForce2 at 0xea082000, irq 12
     0: [0- 0]: ctl
    18: [0- 2]: digital audio playback
    25: [0- 1]: digital audio capture
    16: [0- 0]: digital audio playback
    24: [0- 0]: digital audio capture
    33:       : timer

cat: /proc/asound/hwdep: No such file or directory 00-00: Intel ICH :
NVidia nForce2 : playback 1 : capture 1 00-01: Intel ICH - MIC ADC :
NVidia nForce2 - MIC ADC : capture 1 00-02: Intel ICH - IEC958 : NVidia
nForce2 - IEC958 : playback 1

Dev Snd --------------------------------------------------- controlC0
hwC2D0 midiC0D4 midiC2D0 midiC3D4 pcmC0D4c pcmC1D2c pcmC2D0c pcmC2D6c
pcmC3D4c controlC1 hwC2D1 midiC0D5 midiC2D1 midiC3D5 pcmC0D4p pcmC1D2p
pcmC2D0p pcmC2D6p pcmC3D4p controlC2 hwC2D2 midiC0D6 midiC2D2 midiC3D6
pcmC0D5c pcmC1D3c pcmC2D1c pcmC2D7c pcmC3D5c controlC3 hwC2D3 midiC0D7
midiC2D3 midiC3D7 pcmC0D5p pcmC1D3p pcmC2D1p pcmC2D7p pcmC3D5p hwC0D0
hwC3D0 midiC1D0 midiC2D4 pcmC0D0c pcmC0D6c pcmC1D4c pcmC2D2c pcmC3D0c
pcmC3D6c hwC0D1 hwC3D1 midiC1D1 midiC2D5 pcmC0D0p pcmC0D6p pcmC1D4p
pcmC2D2p pcmC3D0p pcmC3D6p hwC0D2 hwC3D2 midiC1D2 midiC2D6 pcmC0D1c
pcmC0D7c pcmC1D5c pcmC2D3c pcmC3D1c pcmC3D7c hwC0D3 hwC3D3 midiC1D3
midiC2D7 pcmC0D1p pcmC0D7p pcmC1D5p pcmC2D3p pcmC3D1p pcmC3D7p hwC1D0
midiC0D0 midiC1D4 midiC3D0 pcmC0D2c pcmC1D0c pcmC1D6c pcmC2D4c pcmC3D2c
seq hwC1D1 midiC0D1 midiC1D5 midiC3D1 pcmC0D2p pcmC1D0p pcmC1D6p
pcmC2D4p pcmC3D2p timer hwC1D2 midiC0D2 midiC1D6 midiC3D2 pcmC0D3c
pcmC1D1c pcmC1D7c pcmC2D5c pcmC3D3c hwC1D3 midiC0D3 midiC1D7 midiC3D3
pcmC0D3p pcmC1D1p pcmC1D7p pcmC2D5p pcmC3D3p

CPU ------------------------------------------------------- model name
 : AMD Athlon(tm) XP 2800+ cpu MHz  : 2079.770

RAM ------------------------------------------------------- MemTotal:
386080 kB SwapTotal: 779144 kB

Hardware -------------------------------------------------- 00:00.0 Host
bridge: nVidia Corporation nForce2 AGP (different version?) (rev a2)
00:05.0 Multimedia audio controller: nVidia Corporation nForce
MultiMedia audio [Via VT82C686B] (rev a2) 00:06.0 Multimedia audio
controller: nVidia Corporation nForce2 AC97 Audio Controler (MCP) (rev
a1)

% iecset Mode: consumer Data: audio Rate: 48000 Hz Copyright: protected
Emphasis: none Category: PCM coder Original: original Clock: 1000 ppm

% cat /etc/asound.conf pcm.nforce-hw { type hw card 0 device 2 }

pcm.!default { type plug slave.pcm "nforce" }

1.  0,0 is analog out (i.e. headphone socket on the shuttle), and 0,1 is
2.  spdif out.

pcm.nforce { type dmix ipc\_key 1234 slave { pcm "hw:0,2" period\_time 0
period\_size 1024 buffer\_size 32768 rate 48000 } }

ctl.nforce-hw { type hw card 0 device 2 }

=
=

xine config:

1.  used to inform xine about what the sound card can do
2.  bool, default: 0

audio.a52\_pass\_through:1

1.  used to inform xine about what the sound card can do
2.  bool, default: 0
3.  audio.alsa\_mmap\_enable:0

1.  used to inform xine about what the sound card can do
2.  bool, default: 0
3.  audio.five\_channel:0

1.  used to inform xine about what the sound card can do
2.  bool, default: 0

audio.five\_lfe\_channel:1

1.  used to inform xine about what the sound card can do
2.  bool, default: 0
3.  audio.four\_channel:0

1.  used to inform xine about what the sound card can do
2.  bool, default: 0
3.  audio.four\_lfe\_channel:0

1.  Audio volume
2.  [0..100], default: 50
3.  audio.mixer\_volume:50

1.  restore volume level at startup
2.  bool, default: 0
3.  audio.remember\_volume:0

1.  device used for 5.1-channel output
2.  string, default: iec958:AES0=0x6,AES1=0x82,AES2=0x0,AES3=0x2

audio.alsa\_a52\_device:default

1.  device used for mono output
2.  string, default: default
3.  audio.alsa\_default\_device:default

1.  device used for stereo output
2.  string, default: front

audio.alsa\_front\_device:default

1.  alsa mixer device
2.  string, default: PCM
3.  audio.alsa\_mixer\_name:PCM

1.  device used for 4-channel output
2.  string, default: surround40
3.  audio.alsa\_surround40\_device:surround40

1.  device used for 5.1-channel output
2.  string, default: surround51
3.  audio.alsa\_surround51\_device:surround51

1.  audio driver to use
2.  { auto null alsa oss esd none file }, default: 0

audio.driver:alsa

1.  adjust if audio is offsync
2.  numeric, default: 0
3.  audio.passthrough\_offset:0

1.  if !=0 always resample to given rate
2.  numeric, default: 0

audio.force\_rate:48000

1.  number of audio buffers to allocate (higher values mean smoother
    playback but higher latency)
2.  numeric, default: 230
3.  audio.num\_buffers:230

1.  adjust whether resampling is done or not
2.  { auto off on }, default: 0

audio.resample\_mode:on

\

\

* * * * *

Shuttle SN41G2 guy,

In Xine try setting your audio devices to hw:0,2

All of them, then restart xine, and if you are lucky (like me) it will
work.

Hope this helps a bit.

* * * * *

I'm on Fedora Core 2, with a custom 2.6.6 kernel, and a nforce2 board
trying to use spdif out.

I've got the output for oss and alsa working perfectly with William
Blew's configs above, sound quality is excellent. But i've got the same
issue as a couple of other people in that I can't control the volume....
which is slowly driving me insane, as this is for an HTPC box, and by
amp is one of the ones that is apparently higher quality because it has
no remote control... so i have a stick for changing the volume while
watching TV :/

Darren B.

* * * * *

For people who want to use several OSS compatible applications with ALSA
at the same time, I suggest using the dmix plugin and aoss with the OSS
emulation in ALSA enabled.

For howto use dmix as default:
[http://alsa-project.org/alsa-doc/doc-php/template.php?company=Nvidia&card=nForce&chip=NM2360&module=intel8x0\#aso](http://alsa-project.org/alsa-doc/doc-php/template.php?company=Nvidia&card=nForce&chip=NM2360&module=intel8x0#aso)

Howto use aoss: just execute: "aoss quake3" or replace quake3 with your
program name. Aoss is part of the alsa-libs and can be found here:
[http://www.alsa-project.org/alsa/ftp/oss-lib/](http://www.alsa-project.org/alsa/ftp/oss-lib/)

When everything is configured you can use many applications at the same
time thru aoss and oss emulation.

Hope it helped!

Dennis

* * * * *

For everyone who's missing volume control with his CMedia 9739 onboard
sound chip, here are the facts I found out so far. This chip is used at
least on Epox 8RDA3+ and maybe in every newer nforce2 chipset. (Who
knows where else it is used?) The general problem with the 9739 is that
it doesn't have a volume control in hardware. As the technical reference
(avail. at
[http://www.cmedia.com.tw/e\_t\_twp.htm](http://www.cmedia.com.tw/e_t_twp.htm))
states, there is no PCM volume register on chip, only a PCM muting
register. Strangely, it also states that there is a \_Master\_ volume
register where you should be able to set the volume (not only muting)!
But I had no success using it; changes to that register have no effect.
Maybe this is a hardware bug, or the tech reference is wrong. BTW.
CMedia's OSS driver does volume control in software, so they know about
the problem... So it seems that the best solution is to use some kind of
software volume control.

To get the chip in fact working under Linux, there are several
possibilities:

-   use intel8x0 driver (and an external volume control, maybe at the
    speaker)

<!-- -->

    Pro: mostly works (stable etc.)
    Con: you need an external volume control; and it's not very elegant :)

-   use intel8x0 driver and an extra sound demon (eg. KDE's artsd)

<!-- -->

    Pro: works; and the sound daemon has volume control
    Con: not every app supports those sound daemons (but xmms and mplayer do); you have one program more running in background; the daemons are not always reliable (that's my experience); you need to use a specific program for setting the volume (eg. kmix)

-   use CMedia's OSS driver (avail. at
    [http://www.cmedia.com.tw/download/e\_UDA9738\_linux\_01.htm](http://www.cmedia.com.tw/download/e_UDA9738_linux_01.htm))

<!-- -->

    Pro: built by manufacturer :) ; has built-in volume control
    Con: only usable with old OSS (Open Sound System), AFAIK not usable with ALSA; didn't work reliably for me

-   curse CMedia for building such a crappy chip; curse them again for
    not releasing an ALSA driver; curse NVidia for using such a crappy
    chip (older nforce boards had a better chip onboard..); in the end,
    buy an extra soundcard and be happy :)

<!-- -->

    Pro: it does work really well (if you buy a good card and not an el-cheapo for 9.95 EUR which features as chip a 9739 :)
    Con: additional costs to your PC; takes a PCI slot

BTW. I think I also tried the nforce2 soudn driver; it worked stable,
but had no volume control as well...

Well the (probably) best solution would be to integrate generic software
volume control in ALSA; that means to write an ALSA plugin that does
about the same as CMedia's driver does: rescale every sound sample to
the desired volume. CMedia's driver is under the GPL, so their algorithm
could be used. I've heard that such a plugin is planned, but I don't
know about the current status. Ask at Alsa-devel mailing list
([https://lists.sourceforge.net/lists/listinfo/alsa-devel](https://lists.sourceforge.net/lists/listinfo/alsa-devel))
about it. More about ALSA plugins:
[http://www.alsa-project.org/alsa-doc/alsa-lib/pcm\_plugins.html](http://www.alsa-project.org/alsa-doc/alsa-lib/pcm_plugins.html)

Good luck, Oliver

* * * * *

Hi, I just want to give a short summary about my experiences using this
soundcard on my Dell Inspiron 8600 (BIOS version A08). I am using the
recent kernel 2.6.7 (vanilla) and alsa works perfectly with my
soundcard. Then I tried to enable acpi to get e.g. the status of my
battery. ACPI is working fine as well, but then I got irq conflicts with
my soundcard. Error message seen in dmesg: unable to grab IRQ 7 Intel
ICH: probe of 0000:00:1f.5 failed with error -16

The reason is that after I enabled acpi, acpi is on irq 9 and parport0
(lpt1) is using irq 7, which conflicts with the irq port of my soundcard
(cat /proc/interrupts). Usually pci devices can share irq's. But lpt is
an isa device and so it cannot share it with intel8x0. It's a problem of
the bios which handles the irq interrupts in a bad way.

So for me, I solved the problem by disabling the lpt port in the BIOS
settings.

If anybody has a better solution pls mail to "internet at
weismueller.org"

Good Luck, Jonas

\

* * * * *

07-July-2004

Just wanted to report success with SPDIF and AC3/DTS pass through.

I'm using the on-board sound on my ABIT IC7-MAX3 mobo. It's a RealTek
ALC650, for which I'm using the snd-intel8x0 module.

alsadriver is 1.0.5a, but I suspect that's not terribly important.

I had a lot of trouble at first. In the end, my main problem was finding
how to properly mute the "Analog to IEC958 Output" setting. The
gnome-alsamixer didn't seem to do this, but alsamixer did (use the m key
to mute).

Now if I can just get 1080i working with my HDTV... :)

-- Buck

Update 10-July-2004

It seems I was mistaken. I have yet to figure a reliable way to get
SPDIF to work. I can get it to work by fiddling with the mixers, but I
don't know the exact sequence that does the trick.

-- Buck

14 Dec 2004

No rear channel audio output if 'IEC958 Input Monitor' is on

Unmuting the 'IEC958 Input Monitor' mixer control on Intel ICH5 with the
Realtek ALC650F chip leads to loss of audio output at both the rear
channels; not sure whether this holds true for other chipsets supported
by snd\_intel8x0. Make sure to \_mute\_ this control if you don't need
it.

-- Uday Kumar Reddy

Retrieved from
"[http://alsa.opensrc.org/Intel8x0\_user\_comments](http://alsa.opensrc.org/Intel8x0_user_comments)"

[Category](/Special:Categories "Special:Categories"): [ALSA
modules](/Category:ALSA_modules "Category:ALSA modules")

