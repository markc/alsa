SurroundSound
=============

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

**NOTE:** This article applies to surround sound sent to the analog
outputs. For digital output, see [DigitalOut](/DigitalOut "DigitalOut").

**surround51** and **surround40** are the generic PCM definitions for 6
(aka 5.1) and 4 (aka 4.0) channel analog outputs. When the ALSA driver
supports 5.1 or 4.0 analog output, the corresponding configuration file
for ALSA-lib is transparently provided and includes the definition of
surround51 and/or surround40. The usage is very simple. Just pass
**surround51** or **surround40** as the PCM name...

` `

    aplay -Dsurround51 foo.wav

where foo.wav is a WAV file containing 6 channel stereo samples. Note
that surround51 and surround40 are supposed to be analog, not for the
digital AC3/DTS. They don't decode anything. They just support the
multi-channel PCM.

Contents
--------

-   [1 Additional notes on surround
    PCM](#Additional_notes_on_surround_PCM)
-   [2 Custom Routing of Signals to Surround
    Outputs](#Custom_Routing_of_Signals_to_Surround_Outputs)
-   [3 Using surroundXX PCMs with
    JACK](#Using_surroundXX_PCMs_with_JACK)
-   [4 Using Surround and Mplayer or
    Xine](#Using_Surround_and_Mplayer_or_Xine)
-   [5 Troubleshooting](#Troubleshooting)
-   [6 External links](#External_links)

Additional notes on surround PCM
--------------------------------

from Greg Lee

-   The current version of [aplay](/Aplay "Aplay") will read the number
    of channels from a wave file and seems to give you 6 or 4 channel
    sound automatically without your having to specify the device on the
    command line. However, it sounds much better if you specify a device
    explicitly, as described above. Without "-Dsurround51", perhaps
    [aplay](/Aplay "Aplay") is doing some kind of plugin simulation of
    real 6 channel sound.
-   Six channel wave files, for testing, are hard to find. There are
    several sample six channel wave files, and also some six channel
    oggs in the tar archive at
    [ftp://ling.lll.hawaii.edu/pub/greg/Surround-SDL-testfiles.tgz](ftp://ling.lll.hawaii.edu/pub/greg/Surround-SDL-testfiles.tgz)
    (it's rather bulky). Some 6 channel ogg files derived from midi
    songs with [gt](/Gt "Gt") are in
    [ftp://ling.lll.hawaii.edu/pub/greg/gt-demo.tar.gz](ftp://ling.lll.hawaii.edu/pub/greg/gt-demo.tar.gz).
-   Some of the six channel wave files that you *can* find on the web
    are in "wave extensible" format, which have the interleaved channels
    in an order differing from what Alsa expects (center and lfe come
    before left and right rear). It's a MS thing. You can play those
    with *sfplay*, a simple command line player I adapted from an
    example program in Erik de Castro Lopo's libsndfile distribution.
    *sfplay* recognizes wave extensible files and flips the channel
    order so they can be played using Alsa. Source code for *sfplay* is
    in the archive
    [ftp://ling.lll.hawaii.edu/pub/greg/surround-utils-0.0.1.tar.gz](ftp://ling.lll.hawaii.edu/pub/greg/surround-utils-0.0.1.tar.gz)
    , which also has some other utilities for working with six channel
    wave files. You need libsndfile to compile them:
    [http://www.mega-nerd.com/libsndfile/libsndfile-1.0.9.tar.gz](http://www.mega-nerd.com/libsndfile/libsndfile-1.0.9.tar.gz),
    or whatever version is current.
-   There is a version of timidity for Alsa that uses the surround
    devices. It's described on the page GusSoundfont with source code in
    [ftp://ling.lll.hawaii.edu/pub/greg/gt-0.3.tar.gz](ftp://ling.lll.hawaii.edu/pub/greg/gt-0.3.tar.gz).
-   The current CVS version of [SDL](http://www.libsdl.org/), a popular
    games programming library, has Alsa support for 4 and 6 channel
    sound.

Custom Routing of Signals to Surround Outputs
---------------------------------------------

  ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
  **Note:**There were problems with multichannel [LADSPA plugins](/Ladspa_(plugin) "Ladspa (plugin)") in (some?) versions earlier than ALSA 1.0.14rc2. If you experience any strange behavior, you may need to upgrade to that version or above. For lowpass filtering with LADSPA also see [this howto](/Low-pass_filter_for_subwoofer_channel_(HOWTO) "Low-pass filter for subwoofer channel (HOWTO)").
  ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

With a little [.asoundrc](/.asoundrc ".asoundrc") hackery, you can
easily route signals around any way you like. See [Playing stereo on
surround sound setup
(Howto)](/Playing_stereo_on_surround_sound_setup_(Howto) "Playing stereo on surround sound setup (Howto)")
for an example of how to play a stereo signal over booth front and rear
speakers simultaneously. The example can easily be adapted to suit your
needs. The Howto tells us how to route our "normal" stereo signals to 4
or 5 speakers. It would be nice to process the signal for the subwoofer
with a lowpass filter. Thats's where the [LADSPA
plugins](/LADSPA_plugins "LADSPA plugins") come in handy:

` `

    pcm.lowpass {
         type ladspa
         slave.pcm    ...
         path "/usr/lib/ladspa"
         plugins [ {
              label lpf 
              input {
                   controls [ 50 ]
              }
         } ]
    }

This filter will cut off everything above 50 Hz. Only problem: How do I
send *only one* channel (a mixture of right and left channel) through
this filter? And where do I send the filtered signal? I have tried this
setup:

` `

    # move channel 0 to channel 2
    pcm.move0to2 {
         type route
         slave.pcm 3to6
         slave.channels 3
         ttable.0.2 1
    }
    # 3to6 has 3 input and 6 output channels
    # the stereo signal is on ch. 0 and 1
    # ch.0 is copied to 0 and 2  (front and rear)
    # ch.1 is copied to 1 and 3  (front and rear)
    # ch.0 and ch.1 will is mixed to ch.4 (center)
    # ch.2 is routed to ch.5 (subwoofer)
    pcm.3to6 {
         type route
         slave.pcm "surround51"
         slave.channels 6
         ttable.0.0 1
         ttable.1.1 1
         ttable.0.2 1
         ttable.1.3 1
         ttable.0.4 0.5
         ttable.1.4 0.5
         ttable.2.5 1
    }

This seems to work from the lowpass filter to the output (I have tried
aplay -D \`\`\`plug:lowpass\`\`\` sound.wav). But still the question -
How to I get the data of one channel to the lowpass filter?

Update 18th April 2006 - since alsa 1.0.11rc2 the ladspa plugin can
handle multichannel ladspa plugins. Using a 3 channel ladspa plugin
where 2 channels are passed through and one has a low pass filter
applied the effect desired above can be achieved.

**Question:** Is somebody able to describe how this lowpass filter only
for the LFE channel could be implemented with these multichannel ladspa
plugins?

**Answer:**

1.  After installation of libasound2 version 1.0.11-7\~bpo.1 in Debian
    Sarge.
2.  Sample config - input is 1 mono channel and sub channel
    (0-sub,1-normal mono):

` `

    pcm.ice2_11cutoffsub {
         type ladspa
         slave.pcm       ice_plug
         path    "/usr/lib/ladspa"
         plugins {
              0 {
                   label lp4pole_fcrcia_oa
                   policy none
                   input.bindings.0 "Input";
                   output.bindings.0 "Output";
                   input {
                        controls       [ 300 0 ]
                   }
              }
              1 {
                   label delay_5s
                   input.bindings.0 "Input";
                   output.bindings.0 "Output";
                   input {
                        controls [ 0 0 ]
                   }
              }
         }
    }

Other sample config - input is stereo channel and sub channel
(0,1-stereo,2-sub):

` `

    pcm.ice2_21cutoffsub {
         type ladspa
         slave.pcm       ice_plug
         path    "/usr/lib/ladspa"
         plugins {
              0 {
                   label lp4pole_fcrcia_oa
                   policy none
                   input.bindings.2 "Input";
                   output.bindings.2 "Output";
                   input {
                        controls       [ 300 0 ]
                   }
              }
              1 {
                   label delay_0.01s
                   input.bindings.0 "Input";
                   output.bindings.0 "Output";
                   input {
                        controls [ 0 1 ]
                   }
              }
         }
    }

I do not see the code, but seem that you need to cover all ALSA channels
with at least one plugin - at least in my alsa version. Seem - If you do
not pass other channels thought any alsa plugin you will get silence on
that channel. Check me!

**Question:** I select filter by hearing them all, but who know that is
the best and why?

Using surroundXX PCMs with [JACK](/JACK "JACK")
-----------------------------------------------

On my SBLive, the naked surround40 device cannot be used with
[JACK](/JACK "JACK"). There are two problems:

-   The individual channels are laid out in memory in a non-contiguous
    way, which prevents JACK from using mmap() on them (hope that's
    accurate, please review), and
-   JACK assumes that all output channels correspond to capture channels
    and tries to open four ins as well, while the card only has two.
    Simply using the --inchannels option of jackd does not work.

So we need to create a new virtual device that will be mmap()able and
has 2 ins and 4 outs. TakashiIwai helped out with some magic
incantations to add to your .asoundrc:

` `

    ctl.jack40 {
         type hw
         card 0
    }
    pcm.jack40 {
         # "asym" allows for different
         # handling of in/out devices
         type asym
         playback.pcm {
              # route for mmap workaround
              type route
              slave.pcm surround40
              ttable.0.0 1
              ttable.1.1 1
              ttable.2.2 1
              ttable.3.3 1
         }
         capture.pcm {
              # 2 channels only
              type hw
              card 0
         }
    }

Now you can start jackd with two inputs and four outputs:

` `

    jackd -d alsa --device jack40 --inchannels 2 --outchannels 4

For 5.1 cards, there is probably a similar spell. I only have 2 stereo
outs on my card, so I can't test other setups. If you get 5.1 or other
configurations to work, please add them here. On the older (dual-DAC)
CMedia CMI8738, the above asoundrc setup works with:

` `

    jackd -d alsa --device jack40 --playback --outchannels 4

and the --outchannels switch can be omitted. You can't get capture
inputs at the same time (I'm assuming because the ADC is busy driving
the rear channels) but you do get four-way audio outputs.

For 5.1 sound, this [.asoundrc](/.asoundrc ".asoundrc") works just fine

` `

    ctl.jack51 {
        type hw
        card 0
    }

    pcm.jack51 {
        # "asym" allows for different
        # handling of in/out devices
        type asym
        playback.pcm {
             # route for mmap workaround
             type plug
             slave.pcm "surround51"
             slave.channels 6
             route_policy duplicate
        }
        capture.pcm {
            # 2 channels only
            type hw
            card 0
        }
    }

Just start JACK with

` `

    jackd -d alsa --device jack51 --inchannels 2 --outchannels 6

Using Surround and Mplayer or Xine
----------------------------------

I had a problem where speaker-test worked for my alsa configuration but
Xine didn't. I also never got my 7.1 surround system to work past
4.0...until I used the following for Xine (.xine/config):

` `

    audio.device.alsa_surround40_device:plughw:0,1

and

` `

    audio.device.alsa_surround51_device:plughw:0,1

Mplayer is similar:

` `

    mplayer -channels 6 -ao alsa:mmap:noblock:device=hw=0.1  dvd://4

Now I have Center, LFE, rear, and front. I should have side as well, but
I haven't tested that yet. You can check your
/proc/asound/card0/pcmXp/info files (replace X with the device \#) to
play with the 0,1 (or 0.1) to try it out.

The first number is the card number and the second is the device \# on
the card. Usually the device with multiple devices is your surround, but
I am still confused by this. When using plughw, it is backwards of what
I expected in /proc, but when I set up sections in my .asoundrc, it
seems to follow what is in /proc.

Hope that helps someone! It took me a year and a half and countless
hours to get this to finally work on my 64-Bit Asus A8V Deluxe (via8237
-\> snd-via82xx).

Troubleshooting
---------------

Are you sure your speakers are plugged in properly? Sound cards that are
integrated into the motherboard often have only three jacks: line out,
line in, and microphone. Most of the time, the front speakers miniplug
should go in the line out jack and the rear speakers miniplug should go
in the line in jack. On at least one system with the VT8237 integrated
audio chip, the rear speakers miniplug should go in the microphone jack
for proper surround output.

External links
--------------

-   [http://www.halfgaar.net/surround-sound-in-linux](http://www.halfgaar.net/surround-sound-in-linux)
    - Shows what's needed to get surround sound working properly for
    games and movies. Includes OpenAL configuration.

Retrieved from
"[http://alsa.opensrc.org/SurroundSound](http://alsa.opensrc.org/SurroundSound)"

[Categories](/Special:Categories "Special:Categories"):
[Howto](/Category:Howto "Category:Howto") |
[Configuration](/Category:Configuration "Category:Configuration")

