Quake 3 engine games (Howto)
============================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

This article describes how to get ***Quake 3** engine games such
as***Enemy Territory** to work with ALSA.

### When I try to play ***Enemy Territory*** or other games based on the ***Quake 3*** engine, I get an `"/dev/dsp: Input/output error Could not mmap /dev/dsp"` message

Read the [OssEmulation](/OssEmulation "OssEmulation") documentation
about setting the parameters for OSS via the `/proc` interface. For some
people trying to play ET, the following works:

` `

    echo "et.x86 0 0 direct" > /proc/asound/card0/pcm0p/oss

which changes the playback part of OSS (indicated by the `"p"` in
`"pcm0p"`).

You will generally need to add write permissions even for the root user
in order to echo anything to `/proc/asound/card0/pcm0p/oss`. Also
remember your new settings will not be preserved following a reboot.

You may also need to try this:

` `

    echo "et.x86 0 0 disable" > /proc/asound/card0/pcm0c/oss 

which disables capture (meaning microphone input? PCM input?):

This is not enough for some driver modules such as `cs46xx` for which
you need to enable `mmap` explicitly via a module option. See the
relevant [ALSA modules](/ALSA_modules "ALSA modules") pages for more
info on your driver modules.

On the M-Audio Revolution 7.1 with enemy-territory, all the above does
is change the error message to: `Could not set /dev/dsp to stereo=2`.

An easy-fix workaround is using esd 0.2.35 or above as an intermediate,
just type...

` `

    esddsp --mmap mygame

Where mygame is the name of the game, and it will probably run. You
should have
[esd](?title=Esd&action=edit&redlink=1 "Esd (page does not exist)")
(esound) installed (and esd active) of course.

Retrieved from
"[http://alsa.opensrc.org/Quake\_3\_engine\_games\_(Howto)](http://alsa.opensrc.org/Quake_3_engine_games_(Howto))"

[Category](/Special:Categories "Special:Categories"):
[Howto](/Category:Howto "Category:Howto")

