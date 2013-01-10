Mapping oss mixer controls to alsa mixer
========================================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

ALSA's [OSSEmulation](/OSSEmulation "OSSEmulation") layer (module
[snd-mixer-oss](/Snd-mixer-oss "Snd-mixer-oss")) is able to map OSS
mixer controls to the native ALSA mixer. For example, by default, the
OSS mixer's VOLUME control is mapped to the ALSA mixer element called
***Master***, OSS's PCM mixer control is mapped to ALSA's ***PCM*** and
so on. Unfortunately, this static mapping fails for some cards.

Mixer Elements
--------------

Recently(?), there was introduced a feature to modify that mapping
dynamically via the `/proc` interface. (Thanks!) It is described by
Takashi Iwai \<tiwai@suse.de\> in the document
"alsa-kernel/Documentation/OSS-Emulation.txt", section "Mixer Elements",
of the alsa-driver distribution:

` `

    Mixer Elements
    ==============

    Since ALSA has completely different mixer interface, the emulation of
    OSS mixer is relatively complicated.  ALSA builds up a mixer element
    from several different ALSA (mixer) controls based on the name
    string.  For example, the volume element SOUND_MIXER_PCM is composed
    from "PCM Playback Volume" and "PCM Playback Switch" controls for the
    playback direction and from "PCM Capture Volume" and "PCM Capture
    Switch" for the capture directory (if exists).  When the PCM volume of
    OSS is changed, all the volume and switch controls above are adjusted
    automatically.

    As default, ALSA uses the following control for OSS volumes:

        OSS volume      ALSA control        Index
        -----------------------------------------------------
        SOUND_MIXER_VOLUME  Master          0
        SOUND_MIXER_BASS    Tone Control - Bass 0
        SOUND_MIXER_TREBLE  Tone Control - Treble   0
        SOUND_MIXER_SYNTH   Synth           0
        SOUND_MIXER_PCM     PCM         0
        SOUND_MIXER_SPEAKER PC Speaker      0
        SOUND_MIXER_LINE    Line            0
        SOUND_MIXER_MIC     Mic             0
        SOUND_MIXER_CD      CD          0
        SOUND_MIXER_IMIX    Monitor Mix         0
        SOUND_MIXER_ALTPCM  PCM         1
        SOUND_MIXER_RECLEV  (not assigned)
        SOUND_MIXER_IGAIN   Capture         0
        SOUND_MIXER_OGAIN   Playback        0
        SOUND_MIXER_LINE1   Aux         0
        SOUND_MIXER_LINE2   Aux         1
        SOUND_MIXER_LINE3   Aux         2
        SOUND_MIXER_DIGITAL1    Digital         0
        SOUND_MIXER_DIGITAL2    Digital         1
        SOUND_MIXER_DIGITAL3    Digital         2
        SOUND_MIXER_PHONEIN Phone           0
        SOUND_MIXER_PHONEOUT    Phone           1
        SOUND_MIXER_VIDEO   Video           0
        SOUND_MIXER_RADIO   Radio           0
        SOUND_MIXER_MONITOR Monitor         0

    The second column is the base-string of the corresponding ALSA
    control.  In fact, the controls with "XXX [Playback|Capture]
    [Volume|Switch]" will be checked in addition.

    The current assignment of these mixer elements is listed in the proc
    file, /proc/asound/cardX/oss_mixer (Note: prior to ALSA 1.0 this file
    is named /proc/asound/cardX/mixer_oss), which will be like the following

        VOLUME "Master" 0
        BASS "" 0
        TREBLE "" 0
        SYNTH "" 0
        PCM "PCM" 0
        ...

    where the first column is the OSS volume element, the second column
    the base-string of the corresponding ALSA control, and the third the
    control index.  When the string is empty, it means that the
    corresponding OSS control is not available.

    For changing the assignment, you can write the configuration to this
    proc file.  For example, to map "Wave Playback" to the PCM volume,
    send the command like the following:

        % echo 'VOLUME "Wave Playback" 0' > /proc/asound/card0/mixer_oss

    The command is exactly as same as listed in the proc file.  You can
    change one or more elements, one volume per line.  In the last
    example, both "Wave Playback Volume" and "Wave Playback Switch" will
    be affected when PCM volume is changed.

    Like the case of PCM proc file, the permission of proc files depend on
    the module options of snd.  you'll likely need to be superuser for
    sending the command above.

    As well as in the case of PCM proc file, you can save and restore the
    current mixer configuration by reading and writing the whole file
    image.

Does it work for my envy24-based sound card?
--------------------------------------------

Well, it does... kind of. Unfortunately, it is limited to a 1:1 mapping,
i.e. one OSS mixer control can affect only one alsa mixer control. For
envy24 (ice1712), there are two ways of adjusting the playback volume of
pcm sound:

1.  the digital mixer's pcm out level controls (called "Multi" in
    alsamixer)
2.  the DAC level controls

Let's examine way 1). The channels' mixer controls are numbered "Multi
1", "Multi 2" and so on. Each of these controls a stereo channel (left +
right channels). One can easily map it to the OSS mixer:

` `

    echo 'PCM "Multi" 0' > /proc/asound/card0/oss_mixer

... maps OSS PCM control to the digital mixer's \_first\_ (id 0) stereo
channel.

` `

    echo 'VOLUME "Multi" 2' > /proc/asound/card0/oss_mixer

... maps OSS VOLUME control to the digital mixer's \_third\_ (id 2)
stereo channel.

This solution has some drawbacks: You have to use the digital mixer and
thus cannot omit it (via direct routing of pcm out to hw out, see
"patchbar" in envy24control). I prefer \_not\_ using the mixer, because
it seems to affect sound quality. Another problem is that the mixer
control does not work linearly. Typically, only a small range of the
control actually affects the sound level. Thus, the control becomes
imprecise.

The second solution mentioned above: the DAC level control. (Obviously,
this does only work for analog output). The envy24-based card has
completely separate controls for the left and right channels. Thus, a
mapping does only control ***either*** the left channel ***or*** the
right channel:

` `

    echo 'PCM "DAC" 0' > /proc/asound/card0/oss_mixer

... for the left channel

This is fairly useless (unless you use your card as a mono source
\*g\*), since there is no way to lock DAC0 to DAC1 or vice versa. Seems
like there is no solution without changes to ALSA. I did a quick and
dirty one line hack to my local alsa source, which adjusts DAC1 whenever
DAC0 is changed via the oss-mixer. Actually, when OSS PCM volume is
being changed, a second (normally unused) OSS mixer control is triggered
with the same value. This second mixer control is mapped to DAC1 the
same way PCM is. (The source file is `alsa-kernel/core/oss/mixer_oss.c`,
function `snd_mixer_oss_ioctl1()`.)

\
 *Technical details and terms used may not be adequate. Feel free to add
comments and corrections. (tb, 20030319)*

Retrieved from
"[http://alsa.opensrc.org/Mapping\_oss\_mixer\_controls\_to\_alsa\_mixer](http://alsa.opensrc.org/Mapping_oss_mixer_controls_to_alsa_mixer)"

[Categories](/Special:Categories "Special:Categories"):
[Howto](/Category:Howto "Category:Howto") |
[OSS](/Category:OSS "Category:OSS")

