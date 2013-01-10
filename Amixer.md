Amixer
======

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

What is `amixer`?
-----------------

`amixer` is a command-line program for controlling the mixer in the ALSA
soundcard driver. `amixer` supports multiple soundcards. See also the
[ALSAMixers](/ALSAMixers "ALSAMixers") page and the glossary entry
"[mixer](/Mixer "Mixer")" for a list of alternative mixer programs.

Usage
-----

` `

    Usage: amixer <options> command

    Available options:
      -h,--help       this help
      -c,--card N     select the card
      -D,--device N   select the device, default 'default'
      -d,--debug      debug mode
      -v,--version    print version of this program
      -q,--quiet      be quiet
      -i,--inactive   show also inactive controls

    Available commands:
      scontrols       show all mixer simple controls
      scontents       show contents of all mixer simple controls (default command)
      sset sID P      set contents for one mixer simple control
      sget sID        get contents for one mixer simple control
      controls        show all controls for given card
      contents        show contents of all controls for given card
      cset cID P      set control contents for one control
      cget cID        get control contents for one control

Tip
---

Jaroslav Kysela let slip an important point about `amixer` settings
regarding how to enable or disable **capture** (not playback)
settings...

` `

    Use: amixer sset Capture cap
         amixer sset Capture nocap

    mute/unmute keywords are parsed only for playback

Retrieved from
"[http://alsa.opensrc.org/Amixer](http://alsa.opensrc.org/Amixer)"

[Category](/Special:Categories "Special:Categories"):
[Alsa-utils](/Category:Alsa-utils "Category:Alsa-utils")

