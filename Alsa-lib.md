Alsa-lib
========

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

`alsa-lib` (occasionally a.k.a. libasound) is a userspace library that
provides a level of abstraction over the `/dev` interfaces provided by
the kernel modules. For a more detailed overview of ALSA and how
`alsa-lib` fits into the picture, see [AlsaTips](/AlsaTips "AlsaTips").

Homegrown Wiki documentation
----------------------------

[HowTo Asynchronous
Playback](/HowTo_Asynchronous_Playback "HowTo Asynchronous Playback") -
A detailed guide on how to setup and play back audio asynchronously

[HowTo access a mixer
control](/HowTo_access_a_mixer_control "HowTo access a mixer control") -
A guide to using the controls and hcontrols apis

External documentation
----------------------

-   [http://www.alsa-project.org/alsa-doc/alsa-lib/](http://www.alsa-project.org/alsa-doc/alsa-lib/)
    - API reference
-   [http://www.suse.de/\~mana/alsa090\_howto.html](http://www.suse.de/~mana/alsa090_howto.html)
    - An HowTo/Tutorial on alsa-lib for ALSA 0.9 written by Dr Matthias
    Nagorni
-   [http://equalarea.com/paul/alsa-audio.html](http://equalarea.com/paul/alsa-audio.html)
    - Another HowTo on using the API by Paul Davis

alsa-lib PCM plugins
--------------------

[http://www.alsa-project.org/alsa-doc/alsa-lib/pcm\_plugins.html](http://www.alsa-project.org/alsa-doc/alsa-lib/pcm_plugins.html)
- Reference

Wiki pages for certain plugins:

-   [dmix](/Dmix "Dmix") - realtime mixing of output audio streams
-   [dsnoop](/Dsnoop "Dsnoop") - sharing a capture device among several
    apps
-   [asym](/Asym "Asym") - combine halfduplex devices into a full duplex
    one
-   [ladspa](/Ladspa "Ladspa") - use LADSPA (FX) plugins for your alsa
    setup
-   [dshare](/Dshare "Dshare") - subdivide a multichannel device into
    independent mono or stereo devices
-   [.asoundrc](/.asoundrc ".asoundrc") is the place to configure all
    this.

Retrieved from
"[http://alsa.opensrc.org/Alsa-lib](http://alsa.opensrc.org/Alsa-lib)"

[Category](/Special:Categories "Special:Categories"): [ALSA
packages](/Category:ALSA_packages "Category:ALSA packages")

