AlsaMixers
==========

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Contents
--------

-   [1 ALSA Mixers](#ALSA_Mixers)
-   [2 Alsamixer](#Alsamixer)
-   [3 Gamix](#Gamix)
-   [4 Gnome-alsamixer](#Gnome-alsamixer)
-   [5 kalsamix](#kalsamix)
-   [6 KMix](#KMix)
-   [7 Gnome volume Control](#Gnome_volume_Control)

ALSA Mixers
-----------

The basic concept of a mixer is explained in the glossary entry
[Mixer](/Mixer "Mixer").

I created this page, because I heard that some mixer apps for ALSA
(especially graphical ones like *alsamixergui*) don't treat the mixer
devices right. *alsamixergui* for example doesn't allow setting the
capture flag on the "Capture" slider. This basically makes recording on
*cs46xx*-based soundcards impossible, since it is necessary to select
Line-in, ADC and Capture for capturing from line-in.

Alsamixer
---------

So my first tip when it comes to mixers and ALSA is: Use
*[alsamixer](/Alsamixer "Alsamixer")*. It treats the [ctl](/Ctl "Ctl")
interface right.

If you know of any other mixer apps with problems like that, please
report them here.

Actually I also think that every AlsaDrivers page should have a section
on mixer usage, because this varies wildly from one driver to the next.
It took me 2 days to find out that I had to enable capture on more than
one slider with my soundcard.

Gamix
-----

*gamix* is very nice - some controls of my SB Live! soundcard aren't
displayed or are displayed badly in *alsamixer*, such as the whole *EMU
10K1 PCM section*. *gamix* displays the controls in a more logical and
human-readable form and makes it much easier to change levels.

Where can you get gamix? **From:**
[http://www1.tcnet.ne.jp/fmurata/linux/down/](http://www1.tcnet.ne.jp/fmurata/linux/down/)

Features:

-   Handling of multiple sound cards: displays each card in a separate
    horizontal subwindow, vertical subwindow, or separate tabs (menu
    selectable)
-   Handling of emulated OSS driver: ignores (I.E. does not show up as a
    separate mixer panel).
-   Handling of OSS driver: ALSA only?
-   stereo input and output: dual sliders. Use confusingly labeled sync
    button to select whether they are ganged or not. When not ganged,
    there is some confusing interaction between them (possibly the
    result of being implemented in hardware as gain/balance rather than
    independent controls.
-   Mute button visability: very poor: light grey vs dark gray on a
    small button plus there is a confusing little dot that appears in
    the last selected one as if it was a radio button (which appears to
    serve no purpose) that further hides the mute status.

Gnome-alsamixer
---------------

And there's another very good mixer application for *X* and *GNOME* -
the *gnome-alsamixer*. I like it much more than other mixers just
because its logical separation of different kinds of controls - there
are sliders for volume levels and checkboxes for switchable elements are
on different panel.

*gnome-alsamixer* is available at
[http://www.paw.za.org/projects/gnome-alsamixer/](http://www.paw.za.org/projects/gnome-alsamixer/)

Features:

-   Handling of multiple sound cards: separate tabs
-   Handling of emulated OSS driver: ignores (I.E. does not show up as a
    separate mixer panel).
-   Handling of OSS driver: ALSA only?
-   Separate sliders for mic input gain and monitor on USB headset: no
-   stereo input and output: gain and balance sliders
-   organization of large numbers of sliders: horizontal scroll
-   Mute button visability: good (check marks)
-   Capture source selection: Pulldown menu under capture slider, can be
    separately selected for right and left channels, if desired
-   Dock into panel: no

kalsamix
--------

Good mixer for KDE is *kalsamix*. It is only for ALSA and alsa support
is good, it supports events. *kalsamix* is available at
[http://kalsamix.sourceforge.net](http://kalsamix.sourceforge.net)

Don't miss out on kalsamix even if you use Gnome. For me kalsamix
features of being able freely group & choose which sliders should show
as well as allowing renaming of the channels to whatever I want is
invaluable. It's helps me keep sane with 2 soundcards with multiple
in&outputs on each, connected to different external hardware. Amazing
how there seems to be no native Gnomemixer capable of this.

KMix
----

Features:

-   Handling of multiple sound cards: Yes, pulldown menu selection
-   Emulated OSS driver handling: ignore
-   stereo inputs and outputs: no separate control, there is one balance
    slider for the master volume only.
-   Oranization of large numbers of sliders: tabs
-   Handling of ALSA: yes
-   Capture source selection: radio buttons under appropriate monitor
    volume sliders
-   Dock into panel: yes

Gnome volume Control
--------------------

Features:

-   OSS Support: not directly, but through esd
-   ALSA support: not directly, but through esd
-   ESD support only (won't start if esd is suspended)
-   handling of emulated OSS device: shows up alongside ALSA devices in
    File-\>Change device
-   handling of multiple sound cards: yes: menu selection
-   Only has a small subset of the actual controls by default, you have
    to edit preferences to add missing controls.
-   stereo inputs and outputs: no separate control, until you add all
    controls in preferences and it still isn't clear how this happened
    as there were no obvious balance controls added.
-   separate control of record and monitor volume on USB headset: yes
-   Capture source selection: in separate switches tab.
-   Dock into panel: no

Note that I had severe problems with insufficient mic gain, even with
the 20db boost selected, on a Gigabyte GA-K8N Pro SLI motherboard, with
both KMix, gnome volume control, and even alsa-mixer until I tried
gamix/GNOME Alsa mixer. Then all of a sudden it started working even
though it doesn't appear to have been due to additional controls.
Apparently before I was only getting between channel crosstalk.

Retrieved from
"[http://alsa.opensrc.org/AlsaMixers](http://alsa.opensrc.org/AlsaMixers)"

[Category](/Special:Categories "Special:Categories"):
[Software](/Category:Software "Category:Software")

