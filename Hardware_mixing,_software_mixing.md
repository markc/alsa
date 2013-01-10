Hardware mixing, software mixing
================================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Some soundcards and drivers support **hardware mixing** of multiple pcm
streams which allows more than one app to play sound at the same time.
If your soundcard does not support hw mixing (check in the SoundCard
Matrix), [aoss](/Aoss "Aoss") and [DmixPlugin](/DmixPlugin "DmixPlugin")
may help you.

There's also [dsnoop](/Dsnoop "Dsnoop"). And [asym](/Asym "Asym") to
combine the two.

How to setup *dmix/dsnoop/asym* and *aoss*
------------------------------------------

And now follows a little howto on how to setup *dmix/dsnoop/asym* and
*aoss*:

First, we need to setup a virtual alsa pcm device that knows how to
handle sharing playback and capture streams. I assume that your
*\~/.asoundrc* is empty, but if you already have an *.asoundrc*, I would
suggest renaming it to *.asoundrc.bak*. I also assume that your
soundcard is card 0 in your system and that its optimal sampling rate is
48000hz (check this with *cat /proc/asound/cards*)

Ok, now let's look at an example \~/.asoundrc:

` `

    pcm.my_card {
        type hw
        card 0
        # mmap_emulation true
    }

    pcm.dmixed {
        type dmix 
        ipc_key 1024 
        #  ipc_key_add_uid false   # let multiple users share
        #  ipc_perm 0666           # IPC permissions for multi user sharing (octal, default 0600)
        slave {
        pcm "my_card" 
        #   rate 48000
        #   period_size 512
        }
    }

    pcm.dsnooped {
        type dsnoop 
        ipc_key 2048 
        slave {
        pcm "my_card" 
        #   rate 48000
        #   period_size 128
        }
    }

    pcm.asymed {
        type asym 
        playback.pcm "dmixed" 
        capture.pcm "dsnooped"
    }

    pcm.pasymed {
        type plug 
        slave.pcm "asymed"
    }

    pcm.dsp0 {
        type plug
        slave.pcm "asymed"
    }

    pcm.!default {
        type plug
        slave.pcm "asymed"
    }

What we have now is a virtual alsa pcm device called *asymed*. This
device is capable of mixing several playback streams and sharing one
capture stream amongst several applications. To get automatic
sample-rate conversion, etc, we defined the device *pasymed* which uses
alsa's *plug* plugin.

We also defined a device called *!default*. This is equivalent to
*pasymed*. The special name *!default* makes this device the default
device for all well-coded alsa apps (sadly not many are well coded).

And last we defined a device called *dsp0*. This device is used by the
[aoss](/Aoss "Aoss") script from the *alsa-oss* package. We'll say more
about this later.

First, we test this basic setup with the standard alsa
[aplay](/Aplay "Aplay") tool. You will need a *.wav* file for this test.
If you have none, create one from an mp3 with the following command:

` `

    mpg123 file.mp3 -w file.wav

With this *file.wav* we test the *pasymed* device now:

` `

    aplay -D pasymed file.wav

This should playback *file.wav*. It should work even if you run this
command in two different terminals at the same time, because the sound
from each one will be mixed by the *pasymed* device. Because we defined
the default alsa device *!default* to use *asymed*, you should also be
able to run the command without the *-D pasymed* parameter:

` `

    aplay file.wav

Not all apps understand the default device though. *mplayer* for example
is one of them. To test this setup with *mplayer* use:

` `

    mplayer -ao alsa:device=pasymed file.avi

Next you should test whether all of your desired alsa apps work with
this setup. Some will need to be told explicitly to use *pasymed*.
Others will happily use the default. If some alsa apps behave badly with
*pasymed* (e.g. crackles, stutter), check the old
[DmixPlugin](/DmixPlugin "DmixPlugin") page. It has quite a bit of
troubleshooting advice. Tips: look at the sample rates of the slave,
maybe experiment with the *period\_size* parameter, etc.

I assume that your alsa apps work. Btw: you can also run some
soundservers like *artsd* with alsa-support. *artsd* can be configured
to use *pasymed*, too. I don't know about the *esd* soundserver.

You probably also have some OSS apps. The trick to get OSS apps to use
our *pasymed* device is to call them via the *aoss* script from the
*alsa-oss* package. This tweaks the OSS app to use the *dsp0* device
defined above in *.asoundrc*.

Older versions of *aoss* used to have problems with OSS apps that used
*fopen()* and related functions to access the */dev/dsp* device files.
This has been fixed. See the [aoss](/Aoss "Aoss") page for details.

Some apps use *mmap'*ed audio data transfer. If your app complains about
not being able to use *mmap()*, then play around with the
*mmap\_emulation* setting in the *my\_card* definition.

Retrieved from
"[http://alsa.opensrc.org/Hardware\_mixing,\_software\_mixing](http://alsa.opensrc.org/Hardware_mixing,_software_mixing)"

[Category](/Special:Categories "Special:Categories"):
[Howto](/Category:Howto "Category:Howto")

