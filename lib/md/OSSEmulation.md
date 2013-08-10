OSS emulation
=============

### From the ALSA wiki

(Redirected from
[OSSEmulation](?title=OSSEmulation&redirect=no "OSSEmulation"))

Jump to: [navigation](#mw-head), [search](#p-search)

Contents
--------

-   [1 OSS Emulation in Alsa](#OSS_Emulation_in_Alsa)
-   [2 Issues and Limitations](#Issues_and_Limitations)
-   [3 OSS Emulation Topics](#OSS_Emulation_Topics)
-   [4 More Info](#More_Info)
-   [5 Alternatives](#Alternatives)

OSS Emulation in Alsa
---------------------

One of the aims of ALSA is to provide full OSS compatibility for OSS
applications. ALSA has an **OSS emulation** which supports all of the
[OSS devices](/OSS_device "OSS device") listed below.

There are two different OSS emulation methods in ALSA (and several not
in ALSA itself; see the "Alternatives" section below):

1.  Kernel-level OSS emulation via the `snd-pcm-oss` and `snd-mixer-oss`
    and `snd-seq-oss` modules
2.  The `aoss` script from the `alsa-oss` package.

The latter has the advantage of being able to use any device from ALSA's
[PCM
plugin](?title=PCM_plugin&action=edit&redlink=1 "PCM plugin (page does not exist)")
layer during the emulation. This enables software-based mixing of
streams for OSS apps. See the [DmixPlugin](/DmixPlugin "DmixPlugin")
page for more details of how to do software mixing.

Note that neither method works for all OSS apps.

Issues and Limitations
----------------------

Particular issues include:

-   the OSS sequencer `/dev/sequencer` only half works (playback works
    but recording from [MIDI
    keyboards](/MIDI_keyboards "MIDI keyboards") is broken -- *see
    Alsa-devel
    [2004/02/02](http://bugtrack.alsa-project.org/alsa-bug/bug_view_advanced_page.php?bug_id=28)
    2002/8/26 and 2003/12/7*).
-   apps that use libc's FILE\* functionality (fopen(), etc..). A fix
    for this should now be in alsa cvs (as of what version/date?)
-   things that use OSS via memory mapping (mmap). See [ALSA PCM proc
    commands](/ALSA_PCM_proc_commands "ALSA PCM proc commands") for some
    hints on this.
-   The *ICE1712* chipset supports only an unconventional format,
    interleaved 10-channels 24bit (packed in 32bit). Therefore you
    cannot mmap the buffer in a conventional (mono or 2-channels, 8 or
    16bit) format using OSS emulation.
-   Some USB devices support only 24bit format packed in 3bytes. This
    format is not supported by OSS and no conversion is provided by
    kernel OSS emulation. You can, however, use the user-space OSS
    emulation via libaoss instead.

OSS Emulation Topics
--------------------

-   [List of Supported OSS devices](http://alsa.opensrc.org/OSS+device)
    (such as /dev/dsp)
-   Kernel [module device mapping
    options](/Module_device_mapping_options "Module device mapping options")
    control which ALSA PCM and MIDI devices OSS devices like /dev/dsp
    get mapped to.

-   Some [ALSA PCM proc
    commands](/ALSA_PCM_proc_commands "ALSA PCM proc commands") can be
    used to control behaviors important for OSS emulation. Check these
    out if your problems may be related to:
    -   apps that uses MMAP
    -   sample rate conversion
    -   fragment size
    -   i/o blocking issues
    -   apps that can't handle duplex streams properly

-   Takashi Iwai's documentation on the OSS MIDI emulation may be found
    at
    [OssSequencerEmulation](/OssSequencerEmulation "OssSequencerEmulation").
-   All about [Mapping oss mixer controls to alsa
    mixer](/Mapping_oss_mixer_controls_to_alsa_mixer "Mapping oss mixer controls to alsa mixer")

More Info
---------

Much of this page and it's sub-topic pages is derived from
[http://alsa-project.org/\~iwai/OSS-Emulation.html](http://alsa-project.org/~iwai/OSS-Emulation.html)
from the official ALSA docs. It may be more frequently updated or
contain more extensive information than this wiki.

[DmixPlugin](/DmixPlugin "DmixPlugin") includes some tips on using dmix
with OSS.

[OSS and dmix](/OSS_and_dmix "OSS and dmix") by Richard is an a step by
step guide on how to use xmms while playing Unreal Tournament. It
probably will also help with Enemy Territory, Quake3, and other things
that use OSS, fopen(), and/or mmap.

Alternatives
------------

ALSA is not the first sound system (and probably not the last) to have a
need to capture and convert output from programs written for OSS. If
ALSA's OSS Emulation is not doing it for you, you can look into:

-   the artsdsp wrapper for KDE's arts sound server
-   the esddsp wrapper for esd (Enlighted Sound Daemon) sound server
-   the libjackasyn and bio2jack libraries for use with jackit (Jack
    Audio Connection Kit) (bio2jack requires recompiling)

Retrieved from
"[http://alsa.opensrc.org/OSS\_emulation](http://alsa.opensrc.org/OSS_emulation)"

[Category](/Special:Categories "Special:Categories"):
[OSS](/Category:OSS "Category:OSS")

