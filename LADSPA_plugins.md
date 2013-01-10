Ladspa (plugin)
===============

### From the ALSA wiki

(Redirected from [LADSPA
plugins](?title=LADSPA_plugins&redirect=no "LADSPA plugins"))

Jump to: [navigation](#mw-head), [search](#p-search)

See [http://www.ladspa.org/](http://www.ladspa.org/) for an overview of
LADSPA. Using LADSPA plugins for standard alsa apps has many uses. My
motive to get this working is so i can use a compressor when playing
movies with mplayer.

There is a "ladspa" plugin available for alsa's pcm plugin layer. See
[.asoundrc](/.asoundrc ".asoundrc") for and overview on how to edit this
configuration file..

See
[http://www.alsa-project.org/alsa-doc/alsa-lib/pcm\_plugins.html](http://www.alsa-project.org/alsa-doc/alsa-lib/pcm_plugins.html)
for an overview of all pcm plugins available. The info we are interested
in is on the bottom of that page..

Here's an entry from the asoundrc.txt included in the alsa-lib source
package (It searches the "/usr/lib/ladspa" directory for a .so file that
has the plugin "delay\_5s" stored in it. The controls section sets the
delay time and the dry/wet level i think):

` `

    pcm.ladspa {
        type ladspa
        slave.pcm "plughw:0,0";
        path "/usr/lib/ladspa";
        plugins [{
            label delay_5s
            input {
                controls [ 0.8 0.3 ]
            }
        }]
    }

Using `aplay -Dplug:ladspa some_sound_file.wav` will play this file with
the requested delay. To save the "plug:" prefix we can just define
another pcm device called "pladspa":

` `

    pcm.pladspa {
        type plug
        slave.pcm "ladspa";
    }

We can use this pcm device by using
`aplay -Dpladspa some_sound_file.wav`

The usage of the plug plugin is important because LADSPA plugins only
can han handle FLOAT data. Most sound data is usually saved as some sort
of Integer data..

Ok, back to my objective. Getting compressed sound out of mplayer. I can
use the above pcm device for playback with mplayer:

` `

    mplayer -ao alsa:device=pladspa some_movie.avi

All alsa apps that can be configured to use a specific pcm device should
be compatible (i have to use "-abs 1" to make mplayer work with any
pcm-device. Depending on your hw this might be necessary, too). So
installing a compressor should just include finding the right label
string for the above pcm.ladspa definition and setting the parameters
appropriately..

Ok, i found the "Dyson Compressor" and here is my corresponding
.asoundrc entry:

` `

    pcm.ladspa {
        type ladspa
        slave.pcm "plughw:0,0";
        path "/usr/lib/ladspa";
        plugins [{
            label dysonCompress
            input {
                #peak limit, release time, fast ratio, ratio
                controls [1.0 0.1 0.1 0.9]
            }
        }]
    }

If somebody might have a hint on how to set the parameters to
effectively compress typical movie audio streams, so they loose some of
their dynamic range (nice for watching movies late at night, so they
don't wake up the neighbours at loud spots), please add them here :)

- kokoko3k

You could add a limiter after the compressor and tweak some parameters.
The one i'll use is fastLookaheadLimiter (from swh-plugins). My
.asoundrc follows:

LadComp: in -\> compressor -\> limiter -\> out

` `

    pcm.ladcomp {
        type plug
        slave.pcm "ladcomp_compressor";
    }

    pcm.ladcomp_compressor {
        type ladspa
        slave.pcm "ladcomp_limiter";
        path "/usr/lib/ladspa";
        plugins [{
            label dysonCompress
            input {
                #peak limit, release time, fast ratio, ratio
                controls [0 1 0.5 0.99]
            }
        }]
    }

    pcm.ladcomp_limiter {
        type ladspa
        slave.pcm "plughw:0,0";
        path "/usr/lib/ladspa";
        plugins [{
            label fastLookaheadLimiter
            input {
                #InputGain(Db) -20 -> +20 ; Limit (db) -20 -> 0 ; Release time (s) 0.01 -> 2
                controls [ 20 0 0.8  ]
            }
        }]
    }

As you see, the sound is first "smoothed" by dysonCompress slowly
(release time=1) then it is passed to fastLookaheadLimiter which pumps
it with 20db and limits it to 0 db. If you feel that this filter is too
strong, you may want to lower the input gain replacing

` `

    controls [ 20 0 0.8  ]

with

` `

    controls [ 10 0 0.8  ]

And so on, then play with mplayer:

` `

    mplayer MyNotSoLoudMovie.avi -ao alsa:device=ladcomp

- tapas

You can find out which plugins you have on your system by installing the
ladspa-sdk (at least that is the name of the Debian package).

-   listplugins -- prints out a list of all plugins found in
    LADSPA\_PATH.
-   analyseplugin -- gives you details about a plugins i.e. what
    controls exist
-   applyplugin -- applies a plugin to a wav file to hear how the plugin
    sounds

- jzedlitz

I figured out that many of the swh-plugins (like buttworth-bandpass
filters) are only working with recent versions of alsa-lib. With 1.0.3b
I got segfaults. After a change to 1.0.5 they are working fine!

- julian

Since Alsa 1.0.11rc2 multichannel Ladspa plugins can now be used

- rob

When using ladspa plugins in .asoundrc as above, aplay says:

` `

    aplay: set_params:860 Broken configuration for this PCM: no configurations available

What is wrong?

- michael

A configuration for listening to highly dynamic (classical) music
-----------------------------------------------------------------

I happily found this wiki page while searching for a way to listen to a
certain [CD by Leonard
Bernstein](http://www.bookzilla.de/shop/action/productDetails/1259142/leonard_bernstein_israel_philharmonic_orchestra_israel_philharmonic_orchestra_chichester_psalms_symphonien_nr_1_und_2_klassik_cd.html?aUrl=90006951)
with a **huge** dynamic range to be compressed. Normally, I like to
leave the audio material untouched, but in this situation I wanted to
listen to it while working without disturbing my office neighbours.
Based on the documentation above, I figured out how to do it and I'd
like to share my results with you.

To play around with different ladspa compressor plugins and different
parameter settings, I set up a
[Jack](http://en.wikipedia.org/wiki/JACK_Audio_Connection_Kit) chain
with Amarok as the source. Of course, I had to select the Jack sink in
the Phonon settings to do so. The output of Amarok is fed into
[Jack-Rack](http://jack-rack.sourceforge.net/) and its ouput is fed into
the system's sound card. I got the best results with the
[se4\_1883](http://plugin.org.uk/ladspa-swh/docs/ladspa-swh.html#tth_sEc2.93)
compressor plugin with the following parameter values. BTW: The
different ladspa collections available on a Debian system are listed
[here](http://packages.debian.org/de/lenny/ladspa-plugin).

Here is my [.asoundrc](/.asoundrc ".asoundrc"):

` `

    pcm.ladcomp {
        type plug
        slave.pcm ladspa;
        hint {
            show on
            description "with compressor"
        }
    }
     
    pcm.ladspa {
        type ladspa
           slave.pcm "plughw:0,0";
           path "/usr/lib/ladspa";
           plugins [{
               label se4
               input {
                   #         RMS/peak   attac time (ms)   release time (ms)   threshold (dB)   ratio   knee radius   attenuation 
                   controls  [0.7       30                550                 -25              6.5     6             0]
            }
        }]
    }

To make the virtual sound sink be usable with Phonon (the sound system
of KDE 4.x, for example used by Amarok [you have to
add](http://phonon.kde.org/cms/1032) this "hint" block with a
description to your PCM entry. You can then select the virtual sound
sink you just configured in Amarok / Phonon by its description.

Please be aware that it now makes a difference whether you change the
volume in your player (e.g. Amarok) or you change the master volume. The
higher the volume in your player, the stronger the compression—and vice
versa. [Micu](/User:Micu "User:Micu") 05:20, 26 March 2010 (EST)

See also
--------

-   [Low-pass filter for subwoofer channel
    (HOWTO)](/Low-pass_filter_for_subwoofer_channel_(HOWTO) "Low-pass filter for subwoofer channel (HOWTO)")

Retrieved from
"[http://alsa.opensrc.org/Ladspa\_(plugin)](http://alsa.opensrc.org/Ladspa_(plugin))"

[Category](/Special:Categories "Special:Categories"): [ALSA
plugins](/Category:ALSA_plugins "Category:ALSA plugins")

