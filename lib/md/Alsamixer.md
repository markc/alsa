Alsamixer
=========

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Note: As of ALSA 1.0.6 there is a "view" option in alsamixer. There are
three different views: Playback (default), Capture and All. Press F4 to
switch to Capture mode. Press F3 to switch to Playback mode. Press
\<Enter\> to switch to All mode. Be aware that All mode may not show all
of the capture devices for your card, but Capture mode should.

New attempt, using the output from man alsamixer in mandrake 9.2

Contents
--------

-   [1 Alsa Mixer v1.00 (ncurses)](#Alsa_Mixer_v1.00_.28ncurses.29)
    -   [1.1 NAME](#NAME)
    -   [1.2 SYNOPSIS](#SYNOPSIS)
    -   [1.3 DESCRIPTION](#DESCRIPTION)
    -   [1.4 Options](#Options)
    -   [1.5 KEYBOARD COMMANDS](#KEYBOARD_COMMANDS)
        -   [1.5.1 General Controls](#General_Controls)

    -   [1.6 BUGS](#BUGS)
    -   [1.7 AUTHOR](#AUTHOR)

Alsa Mixer v1.00 (ncurses)
==========================

NAME
----

soundcard mixer settings for ALSA soundcard driver, with ncurses
interface

SYNOPSIS
--------

Usage: alsamixer [-h] [-c \<card: 0...7 or id\>] [-D \<mixer device\>]
[-g] [-s]

DESCRIPTION
-----------

alsamixer is an ncurses (textmode) based mixer program for use with the
ALSA soundcard drivers. It supports multiple soundcards with multiple
devices.

Options
-------

-h, -help

Help: show available flags.

-c \<card number or idenfication\>

Select the soundcard to use, if you have more than one. Cards

are numbered from 0 (the default).

-D \<device identification\>

Select the mixer device to control.

-g \<toggle color settings\>

Toggle the using of colors.

-s \<minimize mixer window\>

Minimize the mixer window.

KEYBOARD COMMANDS
-----------------

alsamixer recognizes the following keyboard commands.

### General Controls

The Left and right arrow keys are used to select the channel (or

device, depending on your preferred terminology). You can also use 'n'

("next") and 'p' ("previous").

The Up and Down Arrows control the volume for the currently selected

device. You can also use '+' or '-' for the same purpose. Both the left
and

right signals are affected. For independent left and right control, see

below.

The 'B' or '=' key adjusts the balance of volumes on left and right
chan-

nels.

'M' toggles muting for the current channel (both left and right). You
can

mute left and right independently by using ',' (or '\<') and '.' (or
'\>')

respectively.

SPACE toggles recording: the current channel will be added or removed

from the sources used for recording. This only works for valid input

channels, of course. You can toggle left and right independently by

using Insert (or ';') and Delete (or ') respectively.

'L' re-draws the screen.

Quick Volume Changes

Page Up increases volume by 5.

Page Down decreases volume by 5.

End sets volume to 0.

You can also control left & right levels for the current channel inde-

pendently, as follows:

[Q | W | E ] -- turn UP [ left | both | right ]

[Z | X | C ] -- turn DOWN [ left | both | right ]

If the currently selected mixer channel is not a stereo channel, then

all UP keys will work like 'W', and all DOWN keys will work like 'X'.

Exiting

Quit the program with ALT-Q, or by hitting ESC. Please note that you

might need to hit ESC twice on some terminals since it's regarded as a

prefix key.

BUGS
----

Some terminal emulators (e.g. nxterm) may not work quite right with

ncurses, but that's their own damn fault. Plain old xterm seems to be

fine.

AUTHOR
------

alsamixer has been written by Tim Janik \<timj at gtk.org\> and been

improved by Jaroslav Kysela \<perex at suse.cz\>.

This manual page was provided by Paul Winkler \<zarmzarm@erols.com\>.

(Edited by Simon Oosthoek)

Common errors

alsamixer -c 3

alsamixer: function snd\_ctl\_open failed for hw:3: No such device

-\> no card 3 found

alsamixer -c 1

No mixer elems found

-\> card 1 has no mixer interface, as typical on external ( usb )
devices like Edirol UA-5

previous contents below

Note : Man page from
[http://www.delafond.org/traducmanfr/man/man1/alsamixer.1.html](http://www.delafond.org/traducmanfr/man/man1/alsamixer.1.html)

NAME

alsamixer - ncurses interface to manage mixer settings of soundcards
controlled by ALSA

SYSNOPSIS

alsamixer [ options ]

DESCRIPTION

alsamixer is an ncurses interface to manage mixer settings of soundcards
controlled by ALSA. It supports several cards and several interfaces
(per card?).

ORDER

(redundant section?)

alsamixer [ options ]

Options

- H, - help

Help: show the possible options.

- C \< number of the card \>

Select the card to manage, if you have of them more one. The cards are
numbered from 0 (card 0 is used by default).

- m \< number of the interface \>

Select the interface of the card to manage, if your card has more than
one. The interfaces are numbered from 0 (interface 0 is used by
default). Don't confuse channels of the card with interfaces of a card.
Channels are sometimes named like "interface". The majority of the cards
have only one interface. More advanced cards can have have several
interfaces. This option corresponds to the option - D for amixer ,
arecord , and aplay .

- E

Start in "exact mode". That modifies the representation(?) of the sound
levels, but does not affect the setting of the sound levels. By default
the sound levels are shown in percentages (0-100). It is easy to read,
but does not show you how the card stores sound levels. In exact mode,
you see the sound levels in the same way that the card stores them. In
this mode, a level is given as a number between 0 and "(a power of 2) -
1", (for example 0-7, or 0-63). You can also toggle to exact mode by
using the keys when alsamixer wasn't started in exact mode (which
key??).

KEYBOARD COMMANDS

alsamixer takes the following commands from the keyboard to control the
soundcard settings.

System checks

The LEFT ARROW keys and Right-hand side are used to select the channels.
You can also use N ("next") and P ("previous").

I got to here fixing some "language problems". This manual could do with
a total rewrite by a native english speaker (which I'm not) who is also
well versed in the details of ALSA internal operation. -- Simon Oosthoek

The keys High and Low control volumes for the channels selected. You can
also use about . The signals left and right-hand side are modified at
the same time. To control independently the signals left and right-hand
side, to see low.

M activates met out of silencing device (or not) the selected channel
(for the left signals and right-hand side). You can independently put
out of silencing device the left or right channel by using the keys
respectively , and . .

SPACE (des)active the recording: the selected channel is added (or not)
in the list of the channels to record. That functions only for the
channels being able to be recorded of course.

R toggles between the sight reading or recording.

L refreshes the screen.

The mode of sight of the noise level changes. See the description of the
option - E higher.

Fast modification of the noise levels.

PageUp? (High of page) increases the noise level by 10.

PageDown? (Low of page) lowers the noise level by 10.

Home (Beginning) puts the noise level at least.

End (Fine) puts the noise level at 0.

You can control the noise levels independently right-hand side and left
like this:

[ Q | W | E ] -- Increases [ left|both|right-hand side ]

[ Z | X | C ] -- Decreases [ left|both|right-hand side ]

If the selected channel is a mono channel, then all the keys to increase
the noise level have the same effect as W , and that to lower the same
effect as X .

To leave the program

To stop the program by ALT Q , or ESC .

Retrieved from
"[http://alsa.opensrc.org/Alsamixer](http://alsa.opensrc.org/Alsamixer)"

[Category](/Special:Categories "Special:Categories"):
[Alsa-utils](/Category:Alsa-utils "Category:Alsa-utils")

