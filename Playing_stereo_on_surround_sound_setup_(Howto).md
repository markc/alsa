Playing stereo on surround sound setup (Howto)
==============================================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

**Can I play stereo files over all speakers of my 4.0, 5.1 or 7.1
surround-sound setup?**

Yes, you need to edit your `.asoundrc` file for this to work. I quote
Takashi's email from the alsa-user mailing list:

*On 28 Jan 2004 Florian Schmidt wrote: Hi, as far as i understand it,
the copy plugin does nothing but copy its input to its output. I wonder
if it would be easily possible to extend this plugin to copy to multiple
slave PCMs. This way it would be (easily?) possible to "distribute" a
stereo signal to 4 or even 6 channels. The `route` and `plug` plugins
already can do that, for example...*

` `

    pcm.ch40dup {
        type route
        slave.pcm surround40
        slave.channels 4
        ttable.0.0 1
        ttable.1.1 1
        ttable.0.2 1
        ttable.1.3 1
    }

    pcm.ch51dup {
        type route
        slave.pcm surround51
        slave.channels 6
        ttable.0.0 1
        ttable.1.1 1
        ttable.0.2 1
        ttable.1.3 1
        ttable.0.4 0.5
        ttable.1.4 0.5
    }

*and you can play two channel WAV using...*

` `

      aplay -Dch40dup 2ch-stereo.wav
      aplay -Dch51dup 2ch-stereo.wav

*for 4.0 and 5.1 surrounds, respectively. Of course, this is just a copy
of the left/right samples and no Dolby Prologic effect is included ;)*

*On 28 Jan 2004 TakashiIwai wrote more about this issue: Route (and
plug) plugin already can do that. for example, in your question,
multiple slave PCMs are assumed. In such a case, combine the multiple
PCMs via the `multi` plugin at first, then use the `route` plugin over
it.*

See [.asoundrc](/.asoundrc ".asoundrc") and
[alsa-lib](/Alsa-lib "Alsa-lib").

* * * * *

To use the `ch40dup` or `ch51dup` devices with XMMS go to Preferences
(Ctrl+P), choose the ALSA output plugin in the *Output Plugin* box,
choose *Configure* and fill in the device of your choice at *Audio
device* (it won't be in the list).

* * * * *

Hello. I've been having problems with the line-input capture. I'd like
to take this stereo input and send it over my surround setup on my
sounblaster live 5.1. MPlayer and XMMS already play in surround without
a script like the above one, but the line in does not. Do I need to use
a script like the one above in order to sort this out? Cheers

oni@section9.co.uk

* * * * *

Instead of worrying about the ttable thing, you can also just use thise
code in your .asoundrc:

` `

    pcm.duplicate {
        type plug
        slave.pcm "surround51"
        slave.channels 6
        route_policy duplicate
    }

You just have to adjust the channels to the number of channels you have.
Then just choose the duplicate plug in your audio player, and there you
are. You can even set the slave as a dmixer, so you can have software
mixing at the same time as you are 'expanding' a stereo file to all your
speakers, like e.g. this:

` `

    pcm.dmixs51 {
        type dmix
        ipc_key 1024
        slave {
            pcm "hw:0,1"
            rate 48000
            channels 6
            period_time 0
            period_size 1024
            buffer_time 0
            buffer_size 4096
       }
    }
    pcm.duplicate {
        type plug
        slave.pcm "dmixs51"
        slave.channels 6
        route_policy duplicate
    }

Note that in this case, I use the pcm "`hw:0,1`", this may be "`hw:0,0`"
for your soundcard (mine is a CMI8378).

Sebastian Brocks mail@sebastian-brocks.de

* * * * *

If you use duplicate instead of the ttable routing then your center (and
LFE) channel will be a copy of one of the input channels. Using ttable
(as above) you can mix the left and right channels to get a more correct
center.

One can use:

` `

    mplayer -af pan=2:1:0:0:0 file.ogg # left
    mplayer -af pan=2:0:0:0:1 file.ogg # right

to test how the left and right channels are mixed.

* * * * *

You never want to route left or right channels to the LFE output. That
one is used for effects. Modern 5.1 systems either use a low-pass filter
themselves to drive a subwoofer or play bass using the satellites. If
you do route to the LFE, you should get an awful lot of bass and/or
distortion from the high frequency sounds.

The ttable example is corrected, and this is another reason why the
duplicate method should not be used.

--[Linuxfreck](?title=User:Linuxfreck&action=edit&redlink=1 "User:Linuxfreck (page does not exist)")
11:01, 5 February 2008 (EST)

* * * * *

Just to add, if you want the duplication across RL and RR done in amarok
as described above for xmms, go to amarok-\>settings-\>configure
amarok-\>engine. You should have your output plugin set to alsa. In the
section called ALSA Device Configuration, add `plug:ch51dup` to both
Mono and Stereo boxes instead of `default`.

The volume of the speakers can be adjusted with alsamixer (or kmix)
using center (for front speaker) front (for FL and FR) and surround (for
RL and RR).

I admit setting the .asoundrc to duplicate the sound across all 6
channels is a lot more convenient since it does it for any app that uses
alsa and doesn't require application level configuration. Is there any
way to get alsa to use ch51dup for all applications (games, movies)?

--alamuru420123\_AT\_gREMOVETHISmail\_DOT\_com

Retrieved from
"[http://alsa.opensrc.org/Playing\_stereo\_on\_surround\_sound\_setup\_(Howto)](http://alsa.opensrc.org/Playing_stereo_on_surround_sound_setup_(Howto))"

[Category](/Special:Categories "Special:Categories"):
[Howto](/Category:Howto "Category:Howto")

