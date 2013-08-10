Mplayer (Howto)
===============

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

This article describes how to get the [mplayer](/Mplayer "Mplayer")
media player program to work with the `dmix` plugin.

Is there a way to get mplayer working with ALSA `plug:dmix`?
------------------------------------------------------------

Yes, you need to use
[SDL](?title=SDL&action=edit&redlink=1 "SDL (page does not exist)") to
get sound output when using `mplayer` and `plug:dmix` (see the page
[dmix](/Dmix "Dmix") for info on [software
mixing](/Hardware_mixing,_software_mixing "Hardware mixing, software mixing")
of multiple PCM [streams](/Stream "Stream")). The reason is that the
current `mplayer` 1.0pre3 alsa9 doesn't handle ALSA devices properly by
design according to a message on the mailinglist.

To use SDL, set up the SDL audio handlers like this if you use the
`bash` shell:

` `

    export SDL_AUDIODRIVER=alsa
    export AUDIODEV=plug:dmix

Now use the `mplayer` SDL audio output:

` `

    mplayer -ao sdl

**Isn't there an alsa1x driver already? Does it handle the ALSA devices
better?**

I tried mplayer cvs at Thu Mar 25 00:18:21 CET 2004 mplayer now has the
[alsa1x](?title=Alsa1x&action=edit&redlink=1 "Alsa1x (page does not exist)")
ao, works beautifully with dmix indeed!

**I have a new mplayer, and it still doesn't work?**

1.  Try recompiling mplayer with ALSA support. If you have ALSA somewhat
    working, it should detect it automatically. Don't forget to install
    ALSA library files.
2.  Setup the ALSA config, and try running `mplayer` with it
    exclusively.
3.  If it runes, but you can't make it work with other software, try
    rebooting you system. The dmix plugin seems to have some problems
    with reinitialising sound on the fly, seems it needs to be the first
    device activated on a card.

  ---------------------------------------------------------------------------------------------------------------------------------------
  **Note:**You can also use `mplayer` without `plug:dmix` but then you would not be able to do software mixing of multiple PCM streams.
  ---------------------------------------------------------------------------------------------------------------------------------------

Retrieved from
"[http://alsa.opensrc.org/Mplayer\_(Howto)](http://alsa.opensrc.org/Mplayer_(Howto))"

[Category](/Special:Categories "Special:Categories"):
[Howto](/Category:Howto "Category:Howto")

