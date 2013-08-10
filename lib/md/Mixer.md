Mixer
=====

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

An ALSA **mixer** is a device that controls the sound inputs and sound
outputs on a [soundcard](/Soundcard "Soundcard"). A mixer requires both
hardware and software components. The ***hardware mixer*** is part of
the electronics inside a soundcard. A ***software mixer*** is some
software which provides a user interface for controlling the hardware
mixer. Examples of software mixers include: `alsamixer`, `aumix`,
`gamix`, `xmix`, ...

A software mixer does not control the hardware mixer directly; the ALSA
sound driver is always an interface between the software mixer and the
hardware mixer. This is because different soundcards have different
interfaces to their hardware mixers. The purpose of the ALSA sound
driver is to provide a standard interface for controlling the different
hardware-mixer interfaces. This means one software mixer can work with
many different soundcards. Typical examples of mixer controls are:

` `

    Master Volume (L,R)
    Bass Tone (L,R)
    Treble Tone (L,R)
    Line Input (L,R)
    PCM Volume (L,R)
    FM Synth Volume (L,R)
    CD/DVD Volume (L,R)
    Microphone Input Gain (L,R)

A software mixer usually has two separate controls for independently
controlling the volumes of the left and right (L,R) channels of each
stereo sound source. There may also be controls for mono sound sources,
e.g. mono microphones. A mixer is implemented inside ALSA using a
[ctl-device](/Ctl-device "Ctl-device").

Retrieved from
"[http://alsa.opensrc.org/Mixer](http://alsa.opensrc.org/Mixer)"

[Category](/Special:Categories "Special:Categories"):
[Glossary](/Category:Glossary "Category:Glossary")

