C-Media CMI8738
===============

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

The CMI8738 is one of the C-Media cards supported by the
[cmipci](/Cmipci "Cmipci") ALSA module.

Contents
--------

-   [1 Initial Setup](#Initial_Setup)
-   [2 Controls](#Controls)
-   [3 Troubleshooting Hints](#Troubleshooting_Hints)
    -   [3.1 No Sound from Analog
        Speakers](#No_Sound_from_Analog_Speakers)

-   [4 See Also](#See_Also)

Initial Setup
-------------

Before plugging speakers into the card, check the Master volume control
is at a reasonable level, but *not* at maximum (you might damage your
speakers, or worse, your ears).

Also check the following controls are unmuted (and set to reasonable
levels):

-   PCM
-   Synth
-   CD

Controls
--------

The following is a partial list (it ignores Capture controls):

-   Master
-   3D Control - Switch
-   PCM
-   Synth
-   Line
-   Line-In Mode
    -   Rear Output
    -   Line-In

-   CD
-   Mic
-   Mic Boost
-   Phone
-   IEC958 5V
-   IEC958 Copyright
-   IEC958 In Monitor
-   IEC958 In Phase Inverse
-   IEC958 In Select
-   IEC958 In Valid
-   IEC958 Loop
-   IEC958 Mix Analog
-   IEC958 Output
    -   on - for digital output
    -   off - for analog output

-   PC Speaker
-   Aux
-   Exchange DAC
    -   on
    -   off

-   Four Channel Mode

The Master control on this card is purely a volume control (it has no
'mute' switch).

Troubleshooting Hints
---------------------

### No Sound from Analog Speakers

If you hear no sound when using this card with analog
speakers/earphones, try switching off the following:

-   IEC958 Output
-   Exchange DAC

These can be switched off using [alsamixer](/Alsamixer "Alsamixer"),
[amixer](/Amixer "Amixer") or [other available
mixers](/ALSAMixers "ALSAMixers"). (Tested using Debian 4.0r6, alsamixer
v1.0.13 and headphones connected to the SPK jack socket.)

See Also
--------

-   The [cmipci](/Cmipci "Cmipci") ALSA module page contains a lot of
    useful information on this card (and other C-Media cards).

Retrieved from
"[http://alsa.opensrc.org/C-Media\_CMI8738](http://alsa.opensrc.org/C-Media_CMI8738)"

[Category](/Special:Categories "Special:Categories"): [Sound
cards](/Category:Sound_cards "Category:Sound cards")

