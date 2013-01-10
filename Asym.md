Asym
====

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

What is *asym*?
---------------

*asym* is an ALSA PCM plugin that combines ***half-duplex*** PCM plugins
like *[dsnoop](/Dsnoop "Dsnoop")* and *[dmix](/Dmix "Dmix")* into one
***full-duplex*** device. There is a config example somewhere in the
mailing list (*please could somebody find it and post it lower down on
this page*). From ALSA version 1.0.1 and onwards, *asym* is included
with ALSA. So if you need *asym*, you'll need to upgrade to at least
this version of ALSA.

See the [alsa-lib](/Alsa-lib "Alsa-lib") and
[.asoundrc](/.asoundrc ".asoundrc") pages for details on PCM plugins.
Also see the page on DmixPlugin for info on how to use the
[OssEmulation](/OssEmulation "OssEmulation") with PCM plugins.

\
 Here's Takashi's email announcing it:

` At Tue, 6 Jan 2004 22:38:28 +0100, Florian Schmidt wrote: >  > On Tue, 6 Jan 2004 11:05:52 -0600 (CST) > David Lloyd <dmlloyd@tds.net> wrote: >  > > This patch works great - I'm now able to use TeamSpeak (which opens  > > capture and playback through oss) at the same time as xmms. > >  >  > Cool.. this sounds good. Great news! Thanks, Takashi.. Is there a chance > of this getting into cvs? Is this actually a replacement for the > pcm.dspX definition? or is it still possible to define it the old way?  as written in my previous mail, it was a quick hack.  and there is a better approach.  the attached patch will add a new plugin, asym, which defines different slave pcms for playback and capture streams. for example,   `

       pcm.duplex {
           type asym
           playback.pcm "dmix"
           capture.pcm "dsnoop"
       }

\
 then you can use the pcm "duplex" for dmix/dsnoop combination.\
 \
 ` `

       % aplay -D duplex foo.wav
       % arecord -D duplex bar.wav

\
 (in reality, you likely need plug layer in addition to support other\

    sample rates, though.)

\
 also, by defining\
 \
 ` `

       pcm.dsp0 "duplex"

\
 you can use it via aoss, too.\
 \
 \
 i'm not sure whether the name "asym" is the best choice.\
 if you have better idea, please let me know before committing to cvs.\
 \
 \
 Takashi

\
 an excerpt from another email:

` > This would solve also the annoying problem of pcm that are valid only  > for one direction and should not be used (or browsed) for the other.  it's also possible by defining only playback or capture   `

       pcm.playbackonly {
           type asym
           playback.pcm foo
       }

\
 then the rest stream will remain undefined.\
 \
 \
 Takashi

* * * * *

Here's an *.asoundrc* excerpt that utilizes the *plug* plugin for rate
conversion, etc. It defines a PCM device and a corresponding ctl device
called "*pasymed*". The *pcm.dsp0* definition at the end tries to point
the [aoss](/Aoss "Aoss") script to our device.

` `

       #asym fun start here. we define one pcm device called "dmixed"
       pcm.dmixed {
           ipc_key 1025
           type dmix
           slave.pcm "hw:0,0"
       }
       
       #one called "dsnooped" for capturing 
       pcm.dsnooped {
           ipc_key 1027
           type dsnoop
           slave.pcm "hw:0,0"
       }
       
       #and this is the real magic
       pcm.asymed {
           type asym
           playback.pcm "dmixed"
           capture.pcm "dsnooped"
       }
       
       #a quick plug plugin for above device to do the converting magic
       pcm.pasymed {
           type plug
           slave.pcm "asymed"
       }
       
       #a ctl device to keep xmms happy
       ctl.pasymed {
           type hw
           card 0
       }
       
       #for aoss:
       pcm.dsp0 {
           type plug
           slave.pcm "asymed"
       }
       
       ctl.mixer0 {
           type hw
           card 0
       }

* * * * *

*asym* can also be used to make [JACK](/JACK "JACK") work with
multi-channel devices with different numbers of inputs and outputs. See
also the SurroundSound page.

* * * * *

Why isn't this asym made a default behavior for ALSA? I mean, wouldn't
it be a very trivial expectation from a sound driver layer to let the
user play back and record multiple times simultaneously, without having
to master the knowledge to tweak the sound layer thru plugins...?

Could somebody please show us a working .asoundrc that would enable
unlimited number of simultaneous playback and recording sessions?

Say, I would like to play Quake3, run TeamSpeak, and listen to music
with xmms at the same time. Also, maybe run a live dj program that would
record from the mike and broadcast it to an icecast server. So
basically, 2 playback and two capture streams, simultaneously. What is
the general step-by-step setup guide to use this asym? Thanks.

Since Teamspeak is not compatible with aoss it cannot be made to work
asym. For the difference between aoss and kernel level oss emu, check
[OSSEmulation](/OSSEmulation "OSSEmulation").. [the ossemulation page
seems to indicate there is a fix for this in cvs]

* * * * *

By what i understood, asym could be the answer to intel8x0 users that
need to use skype, xmms, artsd and quake at the same time. Now the
question is: how to tune up the .asoundrc in order to achieve this?

Thanks in advance

* * * * *

This was not that far away..! First, for my card (emu10k1) I found that
a card named rear is pre configured (debian sid) to play to rear (Wave
Suround) speaker. A little hack around the .asoundrc file gave me this:
` `

       # the asym plugin didn't want my rear pcm device so I gave it this..
       pcm.prear {
           type plug
           slave.pcm "rear"
       }
       
       pcm.dsnoop {
           ipc_key 1027
           ipc_key_add_uid true
           type dsnoop
           slave.pcm "hw:0,0"
       }
       
       pcm.skype {
           type asym
           playback.pcm "prear"
           capture.pcm "dsnoop"
       }
       
       pcm.dsp1 {
           type plug
           slave.pcm "skype"
       }
       
       # Here comes the sad part: the volume for that card is STILL the main volume..
       # Instead it should be Master -> Wave Surround
       ctl.mixer1 {
           type hw
           card 0
       }

Now you need to mute the Wave Surround for main card, and activate the
microphone capture.

Then I was able to plug my headphones to the second output of the 5.1
card, and use it as a different card! alsa softs can use the skype
device, and OSS softs can be run under aoss ( aoss software ) and use
/dev/dsp1 ;) Now comes the tricky thing: I was not able to modify the
controls so that the Main Volume for the skype card give me the Wave
Surround Volume which is the second output volume..

But now I can have my best tunes under xmms with alsa or OSS on the
first output and have only the voice in my headphones while skype'in or
other under alsa/OSS ;)

Retrieved from
"[http://alsa.opensrc.org/Asym](http://alsa.opensrc.org/Asym)"

[Category](/Special:Categories "Special:Categories"): [ALSA
plugins](/Category:ALSA_plugins "Category:ALSA plugins")

