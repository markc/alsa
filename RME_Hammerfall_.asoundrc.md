RME Hammerfall .asoundrc
========================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Example RME Hammerfall [.asoundrc](/.asoundrc ".asoundrc"). This is for
two RME Hammerfall cards. They have been split into top row and bottom
row with channels 0-7+16-25 on rme9652\_0 and channels 8-15+26-27 on
rme9652\_1. NB. channels 24-27 are used as two stereo channels while the
others are mono.

.asoundrc
---------

` `

    # eg.             card1                          
    #     | 0  1  2  3  4  5  6  7       |  
    #     | 8  9  10 11 12 13 14 15 24 25|
    #                 card2
    #     | 16 17 18 19 20 21 22 23 24 25|

    pcm_slave.rme9652_s {
        pcm rme9652_0
    }
    pcm.rme9652_1 {
        type hw
        card 1
    }
    ctl.rme9652_1 {
        type hw
        card 1
    }
    pcm.rme9652_0 {
        type hw
        card 0
    }
    ctl.rme9652_0 {
        type hw
        card 0
    }
    ctl.rme9652_48 {
        type hw
        card 0
    }
    pcm.rme9652_48 {
        type multi;
        slaves.a.pcm rme9652_0;
        slaves.a.channels 26;
        slaves.b.pcm rme9652_1;
        slaves.b.channels 26;
        bindings.0.slave a;
        bindings.0.channel 0;
        bindings.1.slave a;
        bindings.1.channel 1;
        bindings.2.slave a;
        bindings.2.channel 2;
        bindings.3.slave a;
        bindings.3.channel 3;
        bindings.4.slave a;
        bindings.4.channel 4;
        bindings.5.slave a;
        bindings.5.channel 5;
        bindings.6.slave a;
        bindings.6.channel 6;
        bindings.7.slave a;
        bindings.7.channel 7;
        bindings.8.slave a;
        bindings.8.channel 16;
        bindings.9.slave a;
        bindings.9.channel 17;
        bindings.10.slave a;
        bindings.10.channel 18;
        bindings.11.slave a;
        bindings.11.channel 19;
        bindings.12.slave a;
        bindings.12.channel 20;
        bindings.13.slave a;
        bindings.13.channel 21;
        bindings.14.slave a;
        bindings.14.channel 22;
        bindings.15.slave a;
        bindings.15.channel 23;

    # Use rme9652_1

        bindings.16.slave b;
        bindings.16.channel 8;
        bindings.17.slave b;
        bindings.17.channel 9;
        bindings.18.slave b;
        bindings.18.channel 10;
        bindings.19.slave b;
        bindings.19.channel 11;
        bindings.20.slave b;
        bindings.20.channel 12;
        bindings.21.slave b;
        bindings.21.channel 13;
        bindings.22.slave b;
        bindings.22.channel 14;
        bindings.23.slave b;
        bindings.23.channel 15;

    # stereo channels

        bindings.24.slave a;
        bindings.24.channel 24;
        bindings.25.slave a;
        bindings.25.channel 25;
        bindings.26.slave b;
        bindings.26.channel 24;
        bindings.27.slave b;
        bindings.27.channel 25;
    }

What is happening?
------------------

There are two sound cards which are linked with a wordclock pipe. That
allows them to keep sample sync with each other which is very important
for multichannel work. If the sample rates are not in sync then your
sounds become out of time with each other.

Each sound card has a number of physical channels 19 + 10. They are
represented in /proc/asound/cardx as pcmXc (capture) and pcmXp
(playback). Where X equals the number of the physical input/output (i/o)
channels starting at 0. If you look at the lines:

` `

        type multi;
        slaves.a.pcm rme9652_0;
        slaves.a.channels 26;

You can see that the card has been nicknamed "a" and given a range of 26
channels. You can assign the card any number of channels you want but
you can only use as many channels as the card has physically available.
The bindings start at the first available pcm device for the card ie.
pcm0c pcm0p - and move upwards sequentially from there.

The first card for this file has 18 physical pcm devices. Nine of them
are capture devices ie. pcm0c pcm1c pcm2c ... pcm8c, each with
corresponding playback channels ie. pcm0p pcm1p pcm2p ... pcm8p. The
second card has 10 physical pcm devices ie. pcm0c pcm1c pcm2c ... pcm9c.
Now if you look at the lines:

` `

        bindings.0.slave a;
        bindings.0.channel 0;
        bindings.1.slave a;
        bindings.1.channel 1;

The first binding points to the first available pcm device on the card
represented as "a". The second binding points to the second available
pcm device on "a" and so on upto the last one available. We then assign
a channel number to the binding so that the channels on the new
"soundcard" we have created are easy for us to access. Another way of
saying it is:

-   address of the first channel on my new soundcard using this real
    soundcard which we call "a";
-   make this address of the first channel on my new soundcard be the
    first pcm device on my new soundcard;

-   address of the second channel on my new soundcard using this real
    soundcard which we call "a";
-   make this address of the second channel on my real soundcard be the
    second pcm device on my new soundcard;

Retrieved from
"[http://alsa.opensrc.org/RME\_Hammerfall\_.asoundrc](http://alsa.opensrc.org/RME_Hammerfall_.asoundrc)"

[Category](/Special:Categories "Special:Categories"): [Sound
cards](/Category:Sound_cards "Category:Sound cards")

