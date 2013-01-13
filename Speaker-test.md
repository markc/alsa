Speaker-test
============

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

The Speaker-test program at alsa-project.org/\~james is deprecicated and
is now included in alsa-utils. To test your [ALSA](/ALSA "ALSA")
setup...

Contents
--------

-   [1 First Step](#First_Step)
-   [2 Just stereo sound from one stereo
    jack](#Just_stereo_sound_from_one_stereo_jack)
-   [3 A 4 speaker setup from two stereo
    jacks](#A_4_speaker_setup_from_two_stereo_jacks)
-   [4 A 5.1 speaker setup from three stereo
    jacks](#A_5.1_speaker_setup_from_three_stereo_jacks)
-   [5 2-speaker test using the spdif (coax or optical)
    output](#2-speaker_test_using_the_spdif_.28coax_or_optical.29_output)

First Step
----------

First you need to get a list of all your sound cards (if you have
multiple ones) and on each card you may have multiple devices ( for
example a set of output for analog and one digital output and one HDMI)

Type  : ( L should be upper case )

` `

    ./aplay -L

you will get the list of the devices and sub devices configured on your
system. You will have lines similar to :

` `

    surround51:CARD=Live,DEV=0
    SBLive! Value [CT4670], ADC Capture/Standard PCM Playback
    5.1 Surround output to Front, Center, Rear and Subwoofer speakers

that is one way of output to that specific card and device.

now in order to test the specific card and device type commands like:
` `

    speaker-test -Dsurround51:Live -c6 -twav

or you can use something like this ` `

    mplayer -ao alsa:device=hw=Live.0  /1.mp3 -af channels=6:2:0:1:0:2

this means: ` `

    mplayer -ao alsa:device=hw="Audio Card"."Audio Device"  "Filename to play" -af channels=6:"Number of routings":"Routing1":"Routing2"...

and Routing1 can be: "Channel 0 of original" to "Channel 1 of output"
and Routing1 can be: "Channel 0 of original" to "Channel 2 of output"
(Same output on both channels ( mono ) ) (and the outputs are on two
different physical plugs on the sound card)

\

-c6 tell speaker test to product 6 channel audio.

I test this output: ` `

       surround71:CARD=HDMI
       HDA ATI HDMI
       7.1 Surround output to Front, Center, Side, Rear and Woofer speaker

with this code:

` `

       speaker-test -surround71:HDMI -c8 -twav

\

\

Just stereo sound from one stereo jack
--------------------------------------

` `

    ./speaker-test -Dplug:front -c2

A 4 speaker setup from two stereo jacks
---------------------------------------

` `

    ./speaker-test -Dplug:surround40 -c4

A 5.1 speaker setup from three stereo jacks
-------------------------------------------

` `

    ./speaker-test -Dplug:surround51 -c6

` `

    ./speaker-test -Dsurround40 -c6 -twav

\

2-speaker test using the spdif (coax or optical) output
-------------------------------------------------------

` `

    ./speaker-test -Dplug:spdif -c2

Retrieved from
"[http://alsa.opensrc.org/Speaker-test](http://alsa.opensrc.org/Speaker-test)"

[Category](/Special:Categories "Special:Categories"):
[Alsa-utils](/Category:Alsa-utils "Category:Alsa-utils")

