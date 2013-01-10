Rosegarden
==========

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Contents
--------

-   [1 What is Rosegarden?](#What_is_Rosegarden.3F)
-   [2 What can Rosegarden do?](#What_can_Rosegarden_do.3F)
    -   [2.1 Main features:](#Main_features:)
    -   [2.2 Other features:](#Other_features:)

-   [3 How can I get Rosegarden?](#How_can_I_get_Rosegarden.3F)
-   [4 Questions about Rosegarden:](#Questions_about_Rosegarden:)

What is Rosegarden?
-------------------

**Rosegarden** is a piece of software which helps you write **music
compositions** either in standard Western musical notation or in a
graph-like "matrix" layout of notes -- a piano-roll. Rosegarden has a
**[MIDI](/MIDI "MIDI") sequencer** and several different editors
including a **score editor**. A unique aspect of Rosegarden, in contrast
to most other music composition software, is that it is being created by
an international collaboration of software developers who are
continually publishing new versions of the software every day.
Rosegarden runs on **[Linux](/Linux "Linux")** *(Rosegarden does not run
in Windows)* using the **[ALSA](/ALSA "ALSA")** sound system so you need
to have both **Linux** and **ALSA** installed first.

What can Rosegarden do?
-----------------------

### Main features:

-   **Score Editor**
    -   Creates music scores with one or more staves by editing in
        standard musical notation.
    -   "Drag-and-drop" editing with cut, copy and paste of notes,
        rests, *etc.*
    -   Powerful **heuristic quantisation** for making "tidy" notation
        from imported MIDI files.
    -   **Automatic interpretation** of dynamics and other notation into
        a live MIDI performance of your composition.
    -   **Fine-positioning** and **visibility control** of notation
        objects.
    -   **Part-writing** on single staves.
    -   High-quality printing output.
    -   Color highlighting of notes during selection and playback.

-   **MIDI Sequencer**
    -   Real-time playback of your composition to a
        [soundcard](/Soundcard "Soundcard"),
        [softsynths](/Softsynths "Softsynths"), or external MIDI
        instruments like [MIDI
        keyboards](/MIDI_keyboards "MIDI keyboards").
    -   Real-time and step recording from external MIDI instruments
        (useful for recording improvisations).

-   **Piano-roll - Matrix Editor**
    -   Edits scores using a color-coded graph-like layout of the
        musical notes.
    -   "Drag-and-drop" editing with cut, copy and paste of **MIDI
        events.**
    -   Adjustable speed-up or slow-down of MIDI events in regions of a
        MIDI file.

-   **Track Editor / Overview Editor**
    -   Overview of the MIDI tracks and/or audio tracks (and segments)
        in your composition.
    -   "Drag-and-drop" editing with cut, copy and paste of **segments**
        between different tracks or within the same track.

-   **MIDI Event List Editor**
    -   Creates **control events** like "sustain pedal", "chorus",
        "reverb", ...
    -   Detailed viewing and editing of event properties.

-   **Support for commonly used file formats**
    -   Import and export of standard MIDI files.
    -   Export of MusicXML, Mup, Csound, and Lilypond files.

-   Multi-track editing for audio and MIDI segments.
-   Support for soft synths (DSSI) and audio plugins like LADSPA.
-   Unlimited undo/redo of editing operations.

### Other features:

-   Translations are available for 12 languages including English (UK
    and US), Chinese (Simplified), Dutch, Estonian, French, German,
    Italian, Japanese, Russian, Spanish, Swedish, and Welsh.
-   GPL licence. Rosegarden is libre software. [concept explained in
    this link](http://www.fsf.org/philosophy/free-sw.html).
-   Implemented in C++ using the QT3 toolkit.
-   The new series 4 Rosegarden works with
    [ALSAMIDI](?title=ALSAMIDI&action=edit&redlink=1 "ALSAMIDI (page does not exist)").
    The older but still useable series 2 [Rosegarden
    2.1pl4](http://www.all-day-breakfast.com/rosegarden/2.1/) works with
    ALSA [OSSEmulation](/OSSEmulation "OSSEmulation") MIDI.

How can I get Rosegarden?
-------------------------

Ready-to-run binaries for Linux are available for [Rosegarden version
1.0 dated 14 February 2005](http://rosegardenmusic.com/getting/). Please
note that to get the most recent version you will have to download
Rosegarden's **source code** using CVS and re-compile it yourself. See
the page [RosegardenCVS](/RosegardenCVS "RosegardenCVS") for more
details.

*There is no Windows or Mac version available, and the only way to run
Rosegarden in Windows is by using "VMWare (TM)" or a similar
**[virtualization
environment](http://en.wikipedia.org/w/wiki.phtml?title=Virtualization)**.*

Questions about Rosegarden:
---------------------------

-   **Frequently Asked Questions** are answered in the *[Rosegarden
    FAQ](http://rosegardenmusic.com/resources/faq/)*
-   More detailed information about Rosegarden is available at the
    project website
    [http://rosegardenmusic.com/](http://rosegardenmusic.com/).

-   Read the **Rosegarden Tutorial** on how to use Rosegarden at
    [http://rosegarden.sourceforge.net/tutorial/](http://rosegarden.sourceforge.net/tutorial/)

-   If you have **questions about using Rosegarden**, check the [Users'
    Mailing
    List](http://lists.sourceforge.net/lists/listinfo/rosegarden-user).

-   If you have a **bug report** or want to **help write the software,
    translations or documentation**, check the [Developers' Mailing
    List](http://lists.sourceforge.net/lists/listinfo/rosegarden-devel).

Retrieved from
"[http://alsa.opensrc.org/Rosegarden](http://alsa.opensrc.org/Rosegarden)"

[Category](/Special:Categories "Special:Categories"):
[Software](/Category:Software "Category:Software")

