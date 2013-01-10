Emu10k1
=======

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Please add links to worthy information about the Sound Blaster Live! and
feel free to delete dead links. Other SbLive related pages are
SbLiveCapture, [SBlive IR Codes](/SBlive_IR_Codes "SBlive IR Codes"),
[SbLiveMixer](/SbLiveMixer "SbLiveMixer"),
[SbLiveMixerControls](/SbLiveMixerControls "SbLiveMixerControls"),
[LiveDrive](/LiveDrive "LiveDrive"). Other Audigy related pages are
[AudigyMixer](/AudigyMixer "AudigyMixer"),
[AudigyMixerControls](/AudigyMixerControls "AudigyMixerControls"). Also,
check out the [Creative Open Source
page](http://opensource.creative.com/soundcard.html) for information
regarding other models of Creative soundcard, eg.
[emu10k1x](/Emu10k1x "Emu10k1x") and [audigyls](/Audigyls "Audigyls").

Contents
--------

-   [1 2005-01-01 Latest News](#2005-01-01_Latest_News)
-   [2 Content of this Wiki-page](#Content_of_this_Wiki-page)
-   [3 Options of the kernel module](#Options_of_the_kernel_module)
-   [4 General mixer settings for
    emu10k1](#General_mixer_settings_for_emu10k1)
-   [5 Mixer settings for 'Digital out'
    users](#Mixer_settings_for_.27Digital_out.27_users)
-   [6 Midi](#Midi)
-   [7 Infrared remote control on Audigy 2 ZS pro and Audigy 4
    pro.](#Infrared_remote_control_on_Audigy_2_ZS_pro_and_Audigy_4_pro.)
-   [8 AC3 & DTS passthrough on Audigy and Audigy
    2](#AC3_.26_DTS_passthrough_on_Audigy_and_Audigy_2)
-   [9 How to record on Audigy and Audigy
    2](#How_to_record_on_Audigy_and_Audigy_2)
-   [10 Links](#Links)
-   [11 Misc stuff](#Misc_stuff)
-   [12 Questions](#Questions)

2005-01-01 Latest News
----------------------

Audigy 2 Value edition (SB0400) PCI IDs:1102:0008 -- A patch against the
current alsa CVS, to support this sound card, is now available
[here](http://www.alsa-project.org/~james/alsa-driver/audigy2/audigy2_value-support.diff).
That support was only possible thanks to the kind donation of a Sound
Card by Creative/3D labs.

Content of this Wiki-page
-------------------------

1.  Options of the kernel module
2.  General mixer settings for emu10k1
3.  Mixer settings for 'Digital out' users
4.  Midi
5.  Infrared remote control on Audigy 2 ZS pro and Audigy 4 pro.
6.  AC3 & DTS passthrough on Audigy and Audigy 2
7.  How record on Audigy and Audigy 2
8.  Links
9.  Misc stuff
10. Questions

Options of the kernel module
----------------------------

After installing ALSA (having it generate the `/etc/modules` section for
you) there are still some traps ... errr, steps left ;) To correctly set
up the module refer to
\<alsasources\>/alsa-kernel/Documentation/**ALSA-Configuration.txt**.
Please look up the information in **your** sources (in case something
changed). This was taken from version 1.0.8 of ALSA-Configuration.txt:

` `

    Module snd-emu10k1
    ==================

      Module for EMU10K1/EMU10k2 based PCI soundcards.
        * Sound Blaster Live!
        * Sound Blaster PCI 512
        * Emu APS (partially supported)
        * Sound Blaster Audigy
        * Sound Blaster Audigy 2

      extin   - bitmap of available external inputs for FX8010 (see below, not needed for Audigy, Audigy 2)
      extout  - bitmap of available external outputs for FX8010 (see below, not needed for Audigy, Audigy 2)
      seq_ports - allocated sequencer ports (4 by default)
      max_synth_voices - limit of voices used for wavetable (64 by default)
      max_buffer_size  - specifies the maximum size of wavetable/pcm buffers given in MB unit.  Default value is 128.
      enable_ir - enable IR

      Module supports up to 8 cards and autoprobe.

      Input & Output configurations............................[extin/extout]
        * Creative Card wo/Digital out......................[0x0003/0x1f03]
        * Creative Card w/Digital out.......................[0x0003/0x1f0f]
        * Creative Card w/Digital CD in.....................[0x000f/0x1f0f]
        * Creative Card wo/Digital out + LiveDrive..........[0x3fc3/0x1fc3]
        * Creative Card w/Digital out + LiveDrive...........[0x3fc3/0x1fcf]
        * Creative Card w/Digital CD in + LiveDrive.........[0x3fcf/0x1fcf]
        * Creative Card wo/Digital out + Digital I/O 2......[0x0fc3/0x1f0f]
        * Creative Card w/Digital out + Digital I/O 2.......[0x0fc3/0x1f0f]
        * Creative Card w/Digital CD in + Digital I/O 2.....[0x0fcf/0x1f0f]
        * Creative Card 5.1/w Digital out + LiveDrive.......[0x3fc3/0x1fff]
        * Creative Card 5.1 (c) 2003........................[0x3fc3/0x7cff]
        * Creative Card all ins and outs....................[0x3fff/0x7fff]

Find your card and add the corresponding [Bitmaps](/Bitmaps "Bitmaps")
to the snd-emu10k1 options in your `etc/modules.conf`, like:

` `

    options snd-emu10k1 <some other options> extin="0x3fc3" extout="0x1fc3"

This will enable [spdif](/Spdif "Spdif") in/out on your LiveDrive.

Adding options snd-emu10k1 extin="0x3fc3" extout="0x1fff" to
/etc/modules.conf allows me to select Mix as capture source and I can
use Line, Capture, AC97 and AC97 Capture to modify line in volume
without hearing the squeal. If I set Line volume over 70, the sound
distorts but overall I can adjust volume much better than on W2K. I'm
using PCM output via Hoontech digital out addon card. I've capture set
to both Capture and Mix (hit space in alsamixer -- that isn't documented
on the man page).

` `

    My version of SBLive:
    $ lspci -vs 00:0a.0
    00:0a.0 Multimedia audio controller: Creative Labs SB Live! EMU10k1 (rev 04)

General mixer settings for emu10k1
----------------------------------

I've added a page about the SBliveValue which should be helpful to
people who own such a thing. I suggest that people with other cards
(Audigy in particular?) should create separate pages for those too. The
drivers have a lot in common, but reading instructions for the wrong
card can be very confusing. SbLiveMixer (from the ALSA distribution
docs) and a new SBliveMixerControls page that is just waiting for your
input right now ! Go on, if you know what any of the SBlive mixer
controls do then make a quick note at this link, many people will be
grateful for your input because no one else seems to have much of a
consistant idea what some of these controls actually do. - MarkConstable
20020729

You can also use the graphical tool gnome-alsamixer -zp 20031103 or you
could try "qamix" from:
[http://www.suse.de/\~mana/kalsatools.html](http://www.suse.de/~mana/kalsatools.html)
which has a nice preset for the emu10k1, use "qamix -g emu10k1.xml" if
you run it from the source dir after you have compiled it. (js) After
some experimentation with [alsamixer](/Alsamixer "Alsamixer") I figured
out that I could actually use my rear speakers by using the "Wave
Surround" slider. Great! I also figured out that my boomy bass was
caused by the "Tone" slider being muted. A press on "m" on the keyboard
got rid of the problem -- and enabled the "Bass" and "Treble" sliders.
The only problem was that it sounded more flat now, specially when
"Bass" and "Treble" are at 0%. I then realized that Tone muted == Bass
and Treble to 50%. (Can somebody confirm?) So for now I set Bass = 35%
and Treble = 50%. MUCH better :) Hope this email helped somebody. -
GuillaumePratte 20020623

One extra note on the rear speaker output, besides unmuting the \`Wave
Surround' slider, you will also need to \*\*MUTE\*\* the
\`Analog/Digital Output Jack' (the right-most slider in alsamixer) to
enable rear speaker output. - Sprite 20020827

Recording from line/mic/cd(analog): In
[alsamixer](/Alsamixer "Alsamixer"), set Capture to something reasonable
(I have 53) and \*hit space bar\* to enable Capture. Then set the volume
for the source you want, and hit spacebar for capture on that too. I
have AC97 set to zero and AC97 Capture set to 100, not sure if this does
anything, but mic/line/cd recording now works for me. - Jared 20020910

When using a surround-sound system with the SBLive 5.1, you'll initially
nothing but an annoying hum from the middle speaker when you load the
ALSA drivers. To make the middle speaker work properly, mute the channel
entitled "SB Live Analog/Digital Output Jack". On my system, it is on
the far right of [alsamixer](/Alsamixer "Alsamixer"). This should be
corrected in ALSA version bigger as 1.0.0rc2 - pz 20031210

I had issues with the bass being too low on my SBLive Value with the OSS
emu10k1 drivers. The issue, apparently, is that some SBLive cards have
their analog front signals inverted, which cancels out the bass on some
speaker systems (Cambridge Soundworks four-point systems, for example).
The emu-tools [[1]](http://sourceforge.net/projects/emu10k1) fixed that
by offering an option to invert the rear speaker signals as well. The
emu-tools don't work with ALSA though, so the only way to get acceptable
bass sound is to disable the rear speakers (Wave Surround to 0, as
mentioned above). Just something to keep in mind if you have a similar
setup.

I also had issues with my SB live value on linux, where the bass had
major distortion. If you cranked the bass up any bit over 50 it would
start having distortion. i totally fixed this by going to the wave
slider and turning that down to 50. now i can turn bass all the way up,
and it sounds great, and i have zero distortion.

With my Cambridge 4-point, plus 1 subwoofer, (Sound Blaster Live Player
1024) Wave Surround had to be turned up to enable both the rear speakers
and the subwoofer. Has anyone seen anything Creative has said about this
issue, seeing as nobody seems to know how to use their card?

You can find the specification of the SigmaTel STAC9708/11 chip on the
internet, this is the chip which is used in the mixer part of the sound
card. (There are two versions, the link goes to version 2, the newer one
of the two versions I found.) The chip is named in the alsamixer, too.
See here for the pdf doc:
[http://people.freenet.de/kxdev/docs/codecs/stac9708-ds.pdf](http://people.freenet.de/kxdev/docs/codecs/stac9708-ds.pdf).
On page 23, there is a nice diagram, and you should be able to match a
lot of the items to the names you see in alsamixer. This is valid for my
SB Live! Platinum at least. PJ20050220

Another interesting specification about the FX8010 chip is
[here](http://people.freenet.de/kxdev/docs/original/fx8010-arch.pdf).
Developers: You should also take a look at the [kX
Project](http://kxproject.lugosoft.com/docs.php), they have more
technical documentation. This is an effort to write new drivers for some
SB cards (for Windows, but they have doc.) -- PJ 20050220

\

Mixer settings for 'Digital out' users
--------------------------------------

If you have digital speakers, you will find that line-in and the inputs
on your card (other than SPDIF CD and anything from a LiveDrive? if
you've got one) are silent. The fix for this is ... odd.

` `

    AC97 - set this reasonably high (94)
    Capture - Set this to midrange (53) and capture (press space)

You then have an option of several inputs which can be set to capture.
Note, the volume levels for these inputs ONLY affects you if you've got
analog speakers (on Audigy this in not true and should work with digital
speakers and ALSA 0.9.8 and higher)!

` `

    Line - On the back of the card
    Mic - On the back
    CD - Internal analog header
    Aux - Internal header
    Mix - Probably equivalent of "igain" with OSS driver, DON'T use it!

Set one of these to capture and that's what you'll hear (and presumably
record from) Note that if you select "Mix", you will get a high-pitched
nasty horrible squeal. If you know how to make that go away, please
share [uneducated guess by a mildly educated reader: when capturing the
mixer signal and somehow feeding that back into the output signal you
get a classical feedback]. Otherwise you can only use ONE of these
devices at a time.

ALSA 0.9.8 changed mixer routing on Audigy and Audigy 2 card. You are
able to route analog signals and stereo wave to center and rear speakers
using Surround, Center, LFE, Front controls. PCM Front, PCM Surround,
PCM Center, PCM LFE controls volume for 5.1 playback. PCM controls
volume for stereo wave playback.

On Audigy (Audigy 2) with ALSA 1.0.0pre1 and more you don't need to set
capture source - only capture volume. AC97 was renamed to Analog Mix
which contains mix from LineI, Analog CD, .. There is now independent
Mic, you can listen mic + line in and record only mic. On Audigy all
analog sources are routed through DSP and Analog Mix controls volume of
this analog mix. If you are unable to hear sound from your CD/Line with
ALSA 1.0.0test1 and higher then you must set Analog Mix volume to
reasonable value (100). pzad 20031210.

Some tips for Sound Blaster Live Digital 5.1 and Digital Coaxial
speakers.
[http://j.f.l.free.fr/notes/doku.php?id=wiki:alsa](http://j.f.l.free.fr/notes/doku.php?id=wiki:alsa)

Midi
----

SBliveCapture is a page about using the SBlives native loopback to
capture [PCM](/PCM "PCM") output to a file using an example of recording
MIDI/soundfonts directly to wav then to [ogg](/Ogg "Ogg") -
MarkConstable 20020711

Wavetable MIDI single-item check list: First use
[sfxload](/Sfxload "Sfxload") / [asfxload](/Asfxload "Asfxload") (part
of the
[awesfx](?title=Awesfx&action=edit&redlink=1 "Awesfx (page does not exist)")
package) to fill the wavetable, otherwise you'll get just dead silence.
For some reason, I did not find this trivia fact in any HOWTO. - Jan
20021111, updated on Feb 20050203

If you use one of the newer distro like Mandriva 2005 LE/Debian 3.1
Sarge/Ubuntu Hoary, it is now easier to setup MIDI playback than ever,
just check the following articles for your distro:

-   Easy setup of Midi under Mandrake Linux 10/10.1
    Part I: For SB Live! / Audigy owners
    [http://mandrivausers.org/index.php?showtopic=22604](http://mandrivausers.org/index.php?showtopic=22604)

HOWTO: MIDI in Hoary with SB Live/Audigy hardware synthesizer

(applicable to Debian 3.1 Sarge too)

[http://www.ubuntuforums.org/showthread.php?t=30963](http://www.ubuntuforums.org/showthread.php?t=30963)

-   For Debian Sarge and Ubunutu, bascially you need to add the entry
    **snd-emu10k1-synth** to the file /etc/modules in order to [enable
    the sequencer
    module](http://lists.debian.org/debian-user/2005/01/msg03667.html)
    at boot.

Mandrake Club has another article on setting up awesfx and KMid, you can
check it out here:

-   Configuring and using the MIDI with Mandrake Linux
    [http://mandrakeclub.com/article.php?sid=979](http://mandrakeclub.com/article.php?sid=979)

For older distros or users who prefer not to use
[Kmid](http://developer.kde.org/~larrosa/kmid.html), you can check out
another tutorial here:

-   SB Live!/Audigy Midi mini-how-to (Draft)
    [http://www.mandrivausers.org/index.php?showtopic=1189](http://www.mandrivausers.org/index.php?showtopic=1189)
    This How-To should be adaptable to other Linux distros.

-   You need to load a .sf2 file which is distributed on the web and on
    Creative CD's. Because of a muddy license, these files are NOT
    distributed with Debian.

If you have a dual booting set up, with a Windows partition, you may
find soundfont files at: C:\\Program Files\\sblive\\sfbank, at least
that was the case with my SB Live! Value and Windows 98. If you have the
Liveware 3 CD, you can get the soundfont files at
/mnt/cdrom/AUDIO/COMMON/SFBANK/ or /cdrom/AUDIO/COMMON/SFBANK/.

NOTE: sfxload requires OSS emulation and may therefore not be suitable
for a couple of people. Takashi Iwai has made an update to the awesfx
package (2004/02/24 =\> 0.5.0a) which introduces 'asfxload'. This uses
native alsa functions to load the soundfonts. It can be found on his
page:
[http://www.alsa-project.org/\~iwai/awedrv.html\#Utils](http://www.alsa-project.org/~iwai/awedrv.html#Utils)
Please note that it requires at least alsa-lib 1.0.2 .

The [asfxload](/Asfxload "Asfxload") utility can be tweaked to compile
with an alsa-lib less than 1.0.2: Edit the configure.in file and comment
out the check for ALSA version, I think it's AM\_ALSA\_LIB or somesuch.
Then run autoconf to regenerate the configure script. Then run configure
and make. Some of the other stuff may fail in the compile, but the
asfxload utility comes out compiled, and - voila - you have soundfonts!
Note, I am using kernel 2.6.3 so my drivers are probably not 0.9.8 but
alsa-lib is. YMMV. **Don't forget** to unmute and turn up the "Music"
slider (number 19) of the emu10k1 mixer.

BIG SOUNDFONT: By default, you can not load for more as 128MB soundfont
with those cards. If you want to load more, it is very easy.

-   Add the following option for the emu10k1 module:

` `

    options snd-emu10k1 max_buffer_size=<size_in_MB>

It is best to reboot, because it is some limitations, and amoung them,
the kernel might be not able to allocate the memory if you have already
used for other purposes.

It is a hadrware limitation with max\_buffer\_size of 1GB (maybe 2? I
don't know for sure). It will not harm if you try to allocate more as
what the card can do. You can check at all is working (or not) as
expected with:

` `

    #  cat /proc/asound/card0/wavetableD1

Infrared remote control on Audigy 2 ZS pro and Audigy 4 pro.
------------------------------------------------------------

There is an issue with the Audigy 2 Platinum Ex soundcard and the Audigy
4 pro (and probably some other Audigy 2 cards as well), whereas the IR
sensor, MIDI and the buttons on the LiveDrive do NOT work at all until
the LiveDrive is initialized by sending the sequence of '0xf0, 0x00,
0x20, 0x21, 0x61, 0x0, 0x00, 0x00, 0x7f, 0x0, 0xf7' to the MIDI port.
Before doing this, even the LED on the LiveDrive won't blink, as it
usually does when a button on the remote is pressed. As far as I know,
this behaviour is different than with most LiveDrives manufactured by
Creative. For more information [see this
link](http://www.mail-archive.com/alsa-devel@lists.sourceforge.net/msg09267.html).
The easiest workaround to this is to add the following line to
/etc/modules.conf

` `

    post-install snd-emu10k1 
    echo -e '\360\000\040\041\141\000\000\000\177\000\367' > /dev/snd/midiC0D1

If it doesn't work, try

` `

    echo -en "\xf0\x00\x20\x21\x61\x00\x00\x00\x7f\x00\xf7" > /dev/snd/midiC0D1

It works for me and it should be distribution-independent (with
exception to Debian, where you change /etc/modutils/alsa and run
update-modules afterwards, Debian users will know anyway).

AC3 & DTS passthrough on Audigy and Audigy 2
--------------------------------------------

From ALSA 0.9.7 and higher AC3 (and maybe DTS passthrough) should work.
Linuxlogin.com has more information on AC3 passthrough for
emu10k1/emu10k2 soundcards, which you can find here:

-   [Linux SBLive Support](http://www.linuxlogin.com/linux/emu10k1.php)
-   [Linux SB Audigy2
    Support](http://www.linuxlogin.com/linux/emu10k2.php)

How to record on Audigy and Audigy 2
------------------------------------

**Question:** How can I select capture source on audigy (there isn't
any) ??? **Answer:** You don't need to set capture source, just set
Capture Volume.

For example to record from Aux2 set Aux2 Capture Volume (you can monitor
what you are capturing using Aux2 PlaybackVolume).

**Recording from analog sources:**

-   All analog sources are mixed together and only this mix can by
    recorded.
-   Analog Mix Capture Volume controls capture volume for this mix.
-   You can monitor what you are recodring using Analog Mix Playback
    Volume control.

**Warning:**

-   Line In, CD, Aux affect playback (monitor) and recording volume.

**Why this is so ?**

-   Because Audigy hardware works this way.
-   Windows drivers works in similiar way, you can not choose Line In as
    capture source, only Analog Mix can be chosen.

Links
-----

There are of course other links on this page, but here are some more:

-   [Creative semi-official open source work and
    drivers](http://opensource.creative.com/)
-   [MIDI synth information for SB
    Live!](http://earthops.org/synth-MIDI-sb.html)
-   [Open source OSS driver, utilities and card
    information](http://sourceforge.net/projects/emu10k1)
-   [The ALSA sequencer
    subsystem](http://www.alsa-project.org/~iwai/lk2k/lk2k.html)
-   [Libranet sound card
    help](http://www.libranet.com/supported_soundcards.html)
-   [AC3
    passthrough](http://sourceforge.net/mailarchive/message.php?msg_id=1454341)
-   [Audigy 2 pinouts](http://alsa.alsa-project.org/~james/datasheets/)
-   [An SB Live! for Linux information page by D. St
    Clair](http://www.euronet.nl/~mailme/)
-   [http://www.alsa-project.org/archive/alsa-user/msg04319.html](http://www.alsa-project.org/archive/alsa-user/msg04319.html)

Misc stuff
----------

If you have a little problem with high sound having distortion, just put
the bass lower. I started working at the emu10k1 driver in order to make
the as10k1 work. I am now writing a so-called "loader" called ld10k1,
that should read binary files generated by as10k1 and load them onto the
card, doing the necessary "relocation" to pointers and GPRs. I had to
modify, slightly, the as10k1 program too. Anyone interested should
contact me at "nigu at itadinanta dot it". The ld10k1 project has not
reached alpha stage yet, but I am planning to ask to integrate it into
the alsa-tools project.

The ALSA drivers shipped with kernel 2.6 only have read permissions on
/dev/snd/seq set for the owner(superuser). This prevents regular users
using ALSA directly or via a sound server. To resolve the problem you
need to 'chmod a+rw /dev/snd/seq' as root. You can then restart arts or
play music with xmms etc. **Note:** OSS emulation works without this
step being nessesary. Its sad to see that some people are destroying
others work... (this is obviously subject to argument; restrictive
permissions are good from a security point of view)

Questions
---------

Please add your questions here, so we can further improve this Wiki!

* * * * *

This is a weird problem I've been having since I started using Linux
(Mandrake 9.0, 9.1, 9.2, 10.0). My sound card is a SB Live!, this is the
very first model, with the daughter card. I also have an Inspire 5.1
Digital 5700. This decoder and the SB Live! daughter card are connected
via a Digital Din cable, so the sound is digital. I use the Alsa 1.0.2c
drivers (snd-emu10k1), on an up-to-date Mandrake 10 CE (april 6th,
2004).

When I do a fresh install of any version of Mandrake, the sound works
correctly and is digital. I can configure Kmix so that I get the same
stereo sound from the FL and FR speakers (PCM slider if I remember
correctly) and the RL and RR speakers (wave surround slider)
simultaneously. Everything is fine.

But after a few weeks, I suddenly get no sound from the front speakers,
no matter what I do ! Only the rear speakers work. Well, the only way I
can hear sound coming from the front is through this command :

` `

    aplay -Dplug:iec958 File1.wav.

I get the impression that this happens after playing with the Xine and
MPlayer sound settings, but this really is just a supposition. A
solution is to stop Alsa (/etc/init.d/alsa stop), delete
/etc/asound.state, then restart Alsa (/etc/init.d/alsa start), which
creates a new (good) asound.state from scratch. I still don't know what
caused the problem in the first place.

-   For me it look like something uses spdif device (this unmute "IEC958
    Raw Playback"). I don't know how to find what is it (meybe arts,
    esd, xmms, or other deamon, program). It is simpler manualy in alsa
    mixer togle "IEC958 Raw Playback" to get front speakers as restart
    alsa.
-   Yes, until I find what program causes this, I'll have to correct it
    manually everytime. Thank you for the help !

* * * * *

I had a problem when I tried to install alsa 1.0.0rc2 on my slackware
distribution. I have a wintv board and the bt87x driver was added to
this version of alsa, so it was also added to my system - the problem is
that I lost sound under KDE. What is the best solution to have sound on
my system again with this version of the alsa drivers?

-   Load bt87x as second soundcard, not as first.

* * * * *

How can I make my Audigy work with 2.6 kernel (I know it's a veeeery
generic question :)?

*I'm not sure what your level of ALSA understanding is but it's just a
matter of configuring the audio section of the kernel config for ALSA
and your (probably PCI) sound card driver. How to change the kernel
config and compile a kernel is basically a matter of downloading the
source code from kernel.org, or mirror, **tar xjf linux-\*.tar.bz2** and
then **cd** (change directory) into the linux-\* and type **make
menuconfig clean bzlilo modules\_install** and basically reboot. Don't
forget to run **alsamixer** and unmute the **Master** and **PCM**
channels with a **m** and the up arrow. There are lots of finer points
to get caught out on but this rough guide should help.*

* * * * *

Still distortion: I am using the current alsa drivers (1.0pre2) with an
SBlive value (digital output) and contrary to the oss emu10k1 driver I
am still experiencing distortion/clipping while playing pcm sounds. It
gets better when I disable tone control, but doesn't disappear entirely.
It does not help to lower some or all related mixer controls. Does
anyone have an idea what to do in this case, did you also experience
something like this?

I have also disortion! I am using kernel 2.6 and I had to recompile it
with OSS-support because ALSA really sounds horrible on my system. I
fixed the distortion by lowering the PCM volume to around 74-81 with
alsamixer. SBLive! 5.1 with 2.6.3, emu10k1 support compiled right in.
Make sure to save your settings.  :)

The problem is that mixer for SB Live is broken and for digital speakers
there is no way to control PCM volume and then when tone controls are on
signal is saturated (and disortion is there). I would like to correct SB
Live mixer in alsa, but actualy I don't have SB Live. If someone has
some programing skills and would like test patches, then send mail to me
pzad@pobox.sk.

2004-10-08 - I also have a sb live value (lspci says rev 7) w/
switchable digital/analog output. I'm using a stereo reciever and
speakers, and there is a huge amount of bass distortion. Moving the
reciever to the rear output helps somewhat, but it just mostly lowers
the volume. please help james 'a.t westcoastbmx /d;ot' com

* * * * *

It would be nice if there were some sort of easy to read description of
how the SB-Live works internally. I read the documentation and learn
about all sorts of FX-registers and the like, but I don't really get a
sense of what that actually means in practice.

* * * * *

I have a rather strange (at least to me) mixer problem with my SB Live
Player 5.1 (without live-drive or any other add-on): I can't find any
way to control the overall "Master" volume. I can adjust the volume of
my rear speakers, my front speakers, my center speaker, all seperately.
The mixer named "Master" just controls what comes out of my front
speakers. But what i want is a simple way to adjust the general volume
for wave playback (xmms, mplayer etc.) on all my speakers (like my old
oss emu10k1 drivers offered with the "pcm" mixer), and i really tried
all the different mixer controls alsamixer offered me...

SB Live [alsamixer](/Alsamixer "Alsamixer") need some corrections.

Mixer problem: I have the same problem. I have an SB Audigy Platinum eX.
There is no 'master' slider that will affect the entire audio stream -
like you, I can only adjust speakers individually. ALSA compiled into
2.6 kernel.

For Audigy upgrade at least to alsa 1.0.0 or kerner 2.6.3.

[Ingomueller.net](/User:Ingomueller.net "User:Ingomueller.net") 04:38,
12 January 2007 (EST) Maybe [this
howto](/How_to_use_softvol_to_control_the_master_volume "How to use softvol to control the master volume")
helps.

* * * * *

I have for a time now been pretty disturbed by the fact that I can't get
my Audigy2 Platinum eX drive buttons and remote to work. Is there anyone
out there that have made any progress with this? If so please could you
not drop me a mail and tell me how you've done. Or drop by at my audigy
page
[http://hem.passagen.se/krso4125/sb](http://hem.passagen.se/krso4125/sb).
Many thanks in advance! -- trasher@linux.se

* * * * *

Along with the changes to the Audigy's mixer in 1.0.x, it seems that
it's almost impossible to get a decent recording volume for microphone
in-- even with mic capture at 100% and the boost on, it's nowhere near
what I was able to get with 0.9.x-- I suspect this is because of
whatever the "Capture" volume slider controls isn't being set high
enough now. Anyone have any ideas what to do there? (Tried all the
various different \* capture settings to no effect) --
mightyquinn@letterboxes.org

* * * * *

If you want InfraRed to work on an Audigy 2 ZS Platinum, you have to
init the midi port, see
[http://www.mail-archive.com/alsa-devel@lists.sourceforge.net/msg09268.html](http://www.mail-archive.com/alsa-devel@lists.sourceforge.net/msg09268.html)
. Easiest solution is to

` `

    echo -e `\360\000\040\041\141\000\000\000\177\000\367' > /dev/snd/midiC0D1

I have put this at the end of "/etc/alsa.d/emu10k1" (SuSE 9.0). --
lurch@gmx.li

* * * * *

I have sound working great thanks to alsa and the emu10k1 drivers
compiled into the kernel. Just keep all the mixer settings below 80% (or
out of the red in alsamixer). One problem, though: my rear speaker
channel (controlled by "wave surround") is incredibly too loud. I have
to leave that channel on 2% when the rest of the channels are at normal
(AKA loud) levels so I dont blow my rear speakers. Any ideas? --
Gamerz232(AT)Yahoo.com

* * * * *

Surround Sound in MPlayer using ALSA drivers for emu10k1 (Audigy in my
case): I had spent hours trying to get surroundsound working on my
Audigy using kernel 2.6 with ALSA drivers. I have a second set of analog
speakers hooked up to my rear output. I found that "Wave Surround"
controlled the rear speaker levels, while "Master" and "PCM" controlled
the front speaker (when playing, say, an MP3). However, I was torn to
find that I had trouble playing multi-channel audio (AC3) in video
files, while it was easy with the old emu10k1 OSS drivers.

I finally figured it out a few hours ago. In MPlayer, using the
"-channels 4" command line argument sends the sound driver into
"surround40" mode, which changes how the sound is mixed. You'll want to
use a really good mixer, like gamix. I haven't seen any other mixer
program with gamix's features. In any case, once the card goes into
surround40 mode, the sound is controlled as follows:

-   the front speakers are controlled by the three "EMU10K1 PCM 1" or
    "EMU10K1 PCM 2" sliders (try and see which ones produce the desired
    effect; when playing a multi-channel movie, EMU10K1 PCM 1 controlled
    the front, while when listening to matrix-encoded surroundsound,
    EMU10K1 PCM 2 controlled the rear)
-   the rear speakers are controlled by the "Surround" sliders (\*not\*
    the "Wave Surround" sliders) Note that many 2-channel PCM or MP3
    files actually have matrix encoded surround sound. You can enable
    the playing of this by adding "-af surround" before the "-channels
    4" option on the command line for MPlayer. (However, I have noticed
    this makes the audio skip for me. Try it yourself and let me know!)

A quick question: Has anyone been able to find a way to find a "Master"
slider to control \*all\* the overall audio levels?

For Audigy upgrade at least to alsa 1.0.0 or kernel 2.6.3.

[Ingomueller.net](/User:Ingomueller.net "User:Ingomueller.net") 04:38,
12 January 2007 (EST) Maybe [this
howto](/How_to_use_softvol_to_control_the_master_volume "How to use softvol to control the master volume")
helps.

* * * * *

I use a script:

` `

    case "$1" in
          up)
     amixer -q set 'Master' 10+
     amixer -q set 'Wave Center' 10+
     amixer -q set 'Wave LFE' 10+
     amixer -q set 'Wave Surround' 10+
     ;;

          down)
     amixer -q set 'Master' 10-
     amixer -q set 'Wave Center' 10-
     amixer -q set 'Wave LFE' 10-
     amixer -q set 'Wave Surround' 10-
     ;;

          *)
     amixer -q set 'Master' $1
     amixer -q set 'Wave Center' $1
     amixer -q set 'Wave LFE' $1
     amixer -q set 'Wave Surround' $1
     ;;
    esac

If you have different names for your mixer do a 'amixer scontrols |
less' and choose the appropriate names. -- Tom [diamondT \_at\_ mail.gr]

* * * * *

Surround sound: front speakers not playing (volume control problem?)
I've got an Audigy 2 ZS card and 5.1 speakers (SuSE 9.0 - alsa 1.0.2).
Stereo and 4 channel mode are OK. But when trying to play something in 6
channel mode - surround51 (e.g. 'ac3dec -6 ac3test.ac3', same thing with
mplayer or xine) front speakers are silent. I suspect it has to do
something with volume control. Anyone knows which slider should I
adjust? (I use alsamixer) -- Tom [diamondT \_at\_ mail.gr]

* * * * *

Could anybody with nice mixer settings send me his /etc/asound.state ? I
have a SB Live 5.1 with Cambridge SoundWorks speakers. --
alsa@e-trolley.de

* * * * *

Options of the Kernel module: It should not be to much work to add an
extra option to the kernel module to revert the rear speaker connection
so that the Bass is not canceled out with some of the SBlive cards. It
is available with the EMU-Tools. BTW: the kernel 2.6 emu10k1 works fine
with my card, the 2.4 did not, I had to use the emu-tools to get it
right. Until I can have my basses right, I'm back to the OSS module :(
-- Richard from NZ

* * * * *

No digital output from tvtime/xawtv: I have a SBLive 5.1 connected to an
AV-Receiver via the digital output. Playing music with ` `

    aplay -D plughw:0,3 file.wav

works fine but there is no sound when I run tvtime or xawtv. Using
kernel 2.6.2 with alsa compiled in I think I can't change module
options. Is there any way bringing digital output to tvtime because I
want to get rid of the extra wiring from the speakers-output to the
6CH-input of the receiver? -- thx, wum

*Well, it depends on which tv card you use. The minority of them
supports digital audio capturing; so the sound card has to do that and
you'll have to have an additional cable. But I think you don't want to
connect your tv card to your AV-Receiver. Just connect the audio-out
jack of the tv card to the line-in of your SBLive. -- Matthias*

* * * * *

I have a SB Live! Platinum with the front panel. I've gotten everything
to work well for recording using the ports in the back. I can use jack,
and ardour works great. I can't seem to find any working info on getting
the (Mic2/Line2) port on the front-panel to work, though. I have tried
every combination of mixer settings that I can concieve of. Here is my
options line in modules.conf:

` `

    options snd-emu10k1 index=0 enable_ir=1 extin="0x3fc3" extout="0x1fff"

How do I get this working?

* * * * *

**2004-05-13 surround40 / surround51 playback through spdif**

I can play back a stereo mp3 through the front speakers of my digital
receiver (connected via spdif). So far so good. I looked into [Playing
stereo on surround sound setup
(Howto)](/Playing_stereo_on_surround_sound_setup_(Howto) "Playing stereo on surround sound setup (Howto)")
in order to copy the front channels to the rear channels, however this
does not lead to the desired results. It only uses the analog outputs.
Is there a way I can use the other speakers (5.1 setup with 2x front, 2x
rear, center + sub)? I could not even route the sound to the rear
speakers ... AC3 passthrough via mplayer / xine / oogle works fine.
Could I encode my own ac3 stream on the fly (and send that to the
receiver), or is it too much number chrunching? If so, how? -- thx
JoernDreyer

* * * * *

**2004-05-19 No sound with Soundblaster Live and kernel 2.6.6 / ALSA
1.0.4**

After upgrading from kernel 2.6.3 to 2.6.6, my Soundblaster Live
suddenly didn't work anymore. Luckily, I found a solution after some
googling. The original mail text is available
[here](http://www.mail-archive.com/alsa-user@lists.sourceforge.net/msg13529.html)
(In case the page disappears someday, here's a quote of the mail:

-   What is model number of this card ???
-   Is it SB0220 "SoundBlaster Live! 5.1 Digital" ???
-   Has STAC9758 AC97 on it ???

Could you try this ?? In `alsa-driver/alsa-kernel/pci/ac97/ac97_codec.c`
is the line

` `

    { 0x83847658, 0xffffffff, "STAC9758/59", patch_sigmatel_stac9758,        NULL }, 

change it to

` `

    { 0x83847658, 0xffffffff, "STAC9758/59",        NULL,   NULL }, 

-- Peter Zubaj

(In my kernel tree, the file was
/usr/src/linux/sound/pci/ac97/ac97\_codec.c) After rebuilding and
reinstalling modules (make modules; make modules\_install) sound worked
fine. -- Oliver Gerlich

With this you will have working front and center/lfe. Rear will be
silent. For full support for this SB Live use CVS version of ALSA.
(pzad)

* * * * *

I have upgraded my Mandrake 9.2 to Mandrake 10.0 now my audigy2 zs
doesnt make any sound ! The modules are loaded and the mixer is set well
it was beter before :( Anyone having the same problem ?

*Yes, I had the same problem with SBLive card and kernel vanilla 2.6.5
with Mandrake 10: I've just made the simple modification to the
/usr/src/linux/sound/pci/ac97/ac97\_codec.c shown above and recompile
the kernel. Now it works well! Many thanks to Oliver Gerlich and Peter
Zubaj. -- mesfet*

* * * * *

I have an Audigy2 zs, and I have the 7.1 speaker system. Everything
works like it should, except the "Side speakers". They don't even show
up in the alsamixer. I have Front(l/r), Rear surround, lfe, and center -
but no side?!? -- Bryan Hundven \<bryanhundven AT y@hoo DOT com\> Any
help would be most appriciated!!!

*Look at
[https://bugtrack.alsa-project.org/alsa-bug/bug\_view\_page.php?bug\_id=0000270](https://bugtrack.alsa-project.org/alsa-bug/bug_view_page.php?bug_id=0000270)
login as guest - if you can, then test second patch. -- pzad at
pobox.sk*

**2004-08-27 emu10k1 with kernel 2.6.8-rc2 NOSOUND fixed**

I have a audigy2 zs and had problems to get sound with 2.6.8-rc2 kernel
everything seems ok but NO sound. I found a solution by installing the
2.6.8-rc-love3 sources from www.love-sources.org. I think they have a
newer alsa version build in. so it would be enough to update your alsa
modules perhaps only problem now i have is to get everything working
right with my 5.1 boxes. -- greets Kai LÃ¶hnert (luxuspur \_\_@\_\_
gmail.com)

**2004-08-13) SBLive! speaker echos microphone**

I've just installed an SBLive! and managed to get sound from it but when
I talk to the microhpone (connected directly to the pink socket on the
card) the speakers echo what I say. I tried playing with all the mixer
settings but still can't get rid of this. What can I do? Also - my new
card is listed as "card 1" and no application finds it by default, I
have to tell them all to use "-c 1" or "\`\`\`hw:1,0\`\`\`". Thanks,
--Amos, alsaopensrc -at- amos.mailshell.com

To answer my own question - got good advise from two people on alsa-user
mailing list to set "playback" on my AC97 to "0" and "capture" to "100%"
and that did it. Hope this helps someone one day.

**2004-09-14 Audigy2 low volume**

I have an audigy 2 platinum. I'm not able to reach decent volume levels
(both for the analog speakers and the inputs - line in, mic, digital
etc.). I must keep everything at 100% and yet the volume is very, very
lower if compared with the volume I can obtain with win98 (which is
quite loud and does not present distortions). The problem is the same
for all ALSA versions since the audigy2 was first supported up to
1.0.7rc1.

I'm not saying that the volume is so low I can't hear anything. But, if
I set the mixer and the speakers' volume for linux and I reboot with
windows without changing it I'll probably need a whole set of new
glasses for my house's windows. Anybody with the same problem?

**2004-09-17 Re: Audigy2 low volume**

Hmm i dont have this problem with my "Audigy2 ZS Platinum PRO" I have
the latest development kernel source (with mm patches) 2.6.9-rc1-mm5
with alsa 1.0.6. My Mixer settings:
[http://www.pc-dummy.net/alsa\_wiki/mixer-settings.txt](http://www.pc-dummy.net/alsa_wiki/mixer-settings.txt)

**2004-09-20**

Try to play with line2 and aux controls in alsamixer (these should
control inputs on AudigyDrive)

` `

    Captured FX Outputs   :
      Output 00 [Digital Front Left]
      Output 12 [???]

This is what outputs are captured using emu10k1 device 2 (efx capture)

**2004-09-24 Live! Value - Midi/Gameport**

How do I configure the midi/gameport to work with an external keyboard?
The particular keyboard is an Evolution MK-149 which comes with a
midi-gameport cable (which also provides power).

Answer (2006-10-12): I have the same keyboard and soundcard, and the
same problem. I went out and bought a new (generic) gameport-midi-kable.
Now it just worked! Seems like the included midi cable is not standard.
You will ofcourse need to take power from somewhere else then.

**2005-01-14 Line-In to Surround**

Hi everybody. Does anyone know how to get the Line-In on a soundblaster
live to send its signal through to the surround / wave bit? Mplayer and
the like all work with surround sound 5.1 fine but i need to pass
through the line to whatever channel mplayer uses.

**2005-02-19 True 5.1 surround**

How do I get the driver to truly use 5.1 for all my apps? instead of
just repeating the signal from the front left and right speakers to the
back speakers, I want each speaker to be its own channel.

ANSWER: See
[wiki](http://forums.gentoo.org/viewtopic-p-4173170.html#4173170), for
e.g. [Doom3](http://zerowing.idsoftware.com/) - the routing needs to be
fixed:

` `

    pcm.doom {
        slave.pcm surround51
        slave.channels 6
        type route
        ttable.0.0 1
        ttable.1.1 1
        ttable.2.4 1
        ttable.3.5 1
        ttable.4.2 1
        ttable.5.3 1
    }

OLD answer:

The driver supports 5.1, it is most of the applications that dont.
Personally, i get 5.1 sound on DVDs, Video files with ac3-5.1 audio, and
obviously any other application or game that supports 5.1 sound.

\

* * * * *

I have an Audigy 2 ZS Platinum and I just can not make only one audio
input work -- for example, the Mic 2/Line 2 jack. I only get the damn
Analog Mix input. When I try to record guitar with Rosegarden, for
example, my audio track comes with the metronome MIDI tick. I tried
QAmix, Kmix, Gamix, AlsaMixerGUI, etc., and even setting all the other
inputs to 0 I get this "What U Hear" recording. Updating to ALSA 1.0.9
in my Debian box did not help. Just donÂ´t know what else I could try.

---

Try use alsamixer (console application). It is known to work (not every
mixer app suports alsa correctly - for example some sets both capture
and playback volume at one time making recording hard). In alsamixer you
can use F3, F4, F5 keys to switch between playback, capture and all
control view. Every source which can be captured on Audigy 2 ZS has two
sliders - volume for playback and volume for capture. Analog Mix is mix
from "CD" (cdrom analog), "Line In" (on card back side), "Aux" (internal
aux input - ot used often). If you want record only one source from this
you have to mute others. There is "Analog Mix Capture" for capture
volume.

You can capture PCM output (this can be your problem). "PCM" controls
playback volume, but there is "PCM Capture" slider - in most cases it
should be set to 0.

There is "Music" or "Music Capture" sliders ("Synth" or "Synth
Capture"). If you don't want capture midi synth output set "Music
Capture" 0.

"Mic" and "Mic Capture" is for Mic input on back side of card.

"Aux2", "Aux2 Capture" and "Line2", "Line2 Capture" are for inputs on
AudigyDrive.

\
 **2005-06-27 MIDI on Debian 2.6.11** (Updated on 2005-09-17)

If your system cannot find the sequencer : ` `

    # /usr/src/alsa-driver-1.0.9b/snddevices

If you cannot load your Sound font bank, run : ` `

    # aplaymidi -l

-   Or, you can add the entry **snd-emu10k1-synth** to the file
    /etc/modules in order to enable the sequencer module at boot.

Then try again : ` `

    #  asfxload  /usr/share/sfbank/8MBGMSFX.SF2

You might have to run those lines everytime you boot.

* * * * *

**2005-11-08 No sound out of the Audigy 4**

If you have an "Audigy 4" card and already have alsa configured, but you
get no sound out of it, try the following (only for analog outputs):

` `

    # alsamixer 

-   use the right arrow key to get to the "IEC958 Optical Raw Switch"
    and make sure it is off (if not press m);
-   press the right arrow key a few more times to get to the "Audigy
    Analog/Digital Output Jack" switch and make sure it is on (if not
    press m)

(*any other combination of these two switches won't allow you to get
sound from the analog outputs of the card*)

now, you should get sound out of it

\
 If you want to make these changes persistent, do the following ` `

    # alsactl store <the id of your sound card>

if you have only one sound card the following is sufficient ` `

    # alsactl store 0

BTW: don't worry if your Audigy 4 get's detected as an Audigy 2 Value,
it will work anyway :)

if this helps, I'm using Alsa 1.0.10

* * * * *

**Problem with surround**

\
 Since I upgraded to OpenSuse 10.0, and consecuently alsa 1.0.10, when I
try to use the surround system, I just get the rear speakers sound. I
tried to touch every control in alsamixer or gamix, but nothin works.
Seems like a buggy driver for the surround for my SounBlaster Live!
Player 5.1 [sb0060].

Also, since the upgrade, the excesive number of controls in alsamixer
(all the emu10k1, etc...) have dissapeared. So I can't try to adjust the
emu10k1 1, etc. as somebody told before. And in gamix, these controls
appear greyed, soy that they don't work...

Can't really understand what happens.

If I try speaker-test with surround 40, 41, 50, 51, 71... is al the
same. Just sound on the back speakers.

Hope anyone can help....

Thanks

Nacho

I think, you have old alsa-lib instaled. In alsa 1.0.10 was changed
playback of front channels for 5.1 playback - stereo should be same.

Also there were problem with detection of SB0060 - they were fixed in
alsa 1.0.10rc2. Check /proc/asound/version for your currently running
alsa.

EMU10K1 \* controls were marked as PCM class (not as MIXER class). This
means, they are no longer controlable through mixer app (they never
should be controlable by mixer).

\
 +++++ OH! You're right, /proc/asound/version shows alsa 1.0.9b, even if
it was supposed that alsa 1.0.10 was used... So I just compiled and
installed the new alsa-drivers, and now everything works nicely...
Thanks!!!

* * * * *

I was trying a whole year to make the ir sensor and the midi-in of the
front panel (audigy 2 ZS) work and i finally did it with sending the
sequence to /dev/snd/midiC0D1. But now there is another problem: I have
either midi keyboard or remote. I can't have both of them. When there is
no lircd the midi keyboard plays fine but when lircd -H livedrive\_midi
-d /dev/snd/midiC0D1 is opened then the midi keyboard is dead. If I
close lircd then midi keyboard plays again. Is there a solution for this
problem?

* * * * *

I have an Audigy 2 ZS, with a DVD player connected to the SPDIF In
(copper) connector on the Live Drive.

One annoyance I have with the ALSA drivers (up to and including
1.0.10rc3) is the SPDIF In data stream doesn't seem to sync properly
reliably, resulting in digital static sounds. Unplugging and
reconnecting the cable fixes the problem, but can take several attempts.
I assume that the SPDIF data stream has some kind of synchronisation
built-in (self-clocking data?) to avoid these kind of problems, but it
doesn't seem to work as it should.

Any ideas?

* * * * *

I have got an Audigy 4, which works pretty well in 1.0.10. However,
/dev/dsp input comes from a weird place, i.e. not from the microphone
input. If I use the setting options dsp\_map=1, I get correct mic input
from /dev/dsp, but not correct output.

This makes it just about impossible to use Skype completely.

---

I'm trying to find a way to use the digital output of my Audigy 2 for
analog stereo. Is this possible?

\

* * * * *

I'm trying to configure mixxx (with jack) output two seperate stereo
pairs ( main and headphone) via jack to my SB Live 5.1 in ubuntu breezy
. The jack server will not start with 4 output channels yet it will
happily do 4 speaker stereo . The underlying alsa driver only provides a
single stereo pair . Has anyone got this to work ?

* * * * *

**2006-06-27 Audigy Drive MIDI port won't wake up from cold**

My keyboard, connected to the MIDI port on my front panel, will only get
its signals through to jackd/Qjackctl/Qsynth/whatever after a warm
reboot from Windows, where it works fine. Starting from cold, nothing
gets through.

What Audigy ?

* * * * *

**Problem getting Line-In to 5.1 Surround-Sound**

Hi,

I have a SB Live 5.1 card with Sigmatel STAC9708 Chip for many years
now. In Windows I was able to listen to the music from Line-In in 5.1
surround if I switched the capture source to Line-In. With alsa in Linux
that "trick" doesn't work. But the playback from any stereo wave-file
will work on all 5 speakers, only the Line-In don't.

Does anyone know what I have to adjust to get the LineIn signal on all 5
or 4 speakers? I'm using Advanced Linux Sound Architecture Driver
Version 1.0.10rc3 (Mon Nov 07 13:30:21 2005 UTC).

Thanks for all who can help!

David

AFAIK this is possible only on Audigy (emu10k2) line of card (under
linux). On sb live I think it is possible only with using ld10k1 and
init\_sblive script (I never tried) and it has still limitation.

---

**Audigy4 garbled/grainy sound**

When I upgraded to suse 10.1, I encountered problems with sound. I have
a builtin abit ac'97. I bought an audigy4 later, hoping it would fix the
problems. I'v managed with help to fix most of them. MP3 and WAV files
work with real player and amarok using the helix engine. Kaffenine has
garbled sound or won't play at all. My project, which uses SDL, has
badly garbled/grainy sound. I'v been unable to use it for any gaming for
about 3 weeks now. I'v asked around many different forums and irc's with
no solutions, including sdl. Changing the driver using
"putenv("SDL\_AUDIODRIVER=esd)" within sdl\_snd to alsa, doesn't work
either. I'v turned off the builtin sound in the bios.

* * * * *

**2006-11-15 Is 192kHz supported?**

I just found out that my Audigy 4 (non-pro) sounds clearer when I use
mplayer to upsample my audio data to 96kHz, instead of sending it in
44.1kHz. The card is supposed to be able to do 192kHz stereo, but I
suppose that's not yet implemented in the emu10k1 driver?

* * * * *

**2007-04-29 How can I get IR working?** I have installed Debian 4.0
(Etch), and I have a Sound Blaster Live! 5.1 Platinum (model SB0060)
with the Live! Drive IR and RM-900 remote. I know the LiveDrive is
working because I've been able to record music from my mp3 using the two
RCA connectors. I've modified the file /etc/modutils/alsa-base adding
the option "options snd-emu10k1 enable\_ir=1 extin="0x3fff"
extout="0x7fff"" and also the file /etc/modprobe.d/alsa-base, with the
same option, but I can't get the IR working (or at least the LED
blinking...).
[Filiprino](?title=User:Filiprino&action=edit&redlink=1 "User:Filiprino (page does not exist)")

* * * * *

**2009-11-30 Standby issues?** I'm missing information related to ALSA
and standby mode. I guess there are several issues around this. My
problem is that my E-mu 1820 is "dead" after resume from standby. No
LEDs are lightning and Ubuntu reports that firmware cannot be loaded.
I.e. same issues as here:
[[2]](http://www.mail-archive.com/alsa-user@lists.sourceforge.net/msg25409.html).
Can it be that what is missing is a "wakeup soundcard" command in my
resume script? Does such a wakeup command exists? Any inputs are
appreciated. (btw. ALSA version is 1.0.20).

Retrieved from
"[http://alsa.opensrc.org/Emu10k1](http://alsa.opensrc.org/Emu10k1)"

[Category](/Special:Categories "Special:Categories"): [ALSA
modules](/Category:ALSA_modules "Category:ALSA modules")

