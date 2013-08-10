Module device mapping options
=============================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Systems can have two PCM and/or MIDI devices. Usually, the first PCM
device (`hw:0,0` in ALSA) is mapped to `/dev/dsp0` and the secondary
device (`hw:0,1`) to `/dev/adsp0` (if available). For MIDI, `/dev/midi0`
and `/dev/amidi0` for the first and second devices, respectively.

You can change this device mapping via the module options for
[snd-pcm-oss](/Snd-pcm-oss "Snd-pcm-oss") and
[snd-rawmidi](?title=Snd-rawmidi&action=edit&redlink=1 "Snd-rawmidi (page does not exist)")

The following options are available for snd-pcm-oss:

-   `dsp_map` -- the PCM device number assigned to `/dev/dspX` (default
    = 0)
-   `adsp_map` -- PCM device number assigned to `/dev/adspX` (default =
    1)

For example, to map the third PCM device (`hw:0,2`) to `/dev/adsp0`, do
like this:

` `

    options snd-pcm-oss adsp_map=2

*(need more here; where does the above line get put? somewhere in
`/etc/modutils.d`?)*

The options take arrays. For configuring the second card, specify two
entries separated by comma. For example, to map the third PCM device on
the second card to `/dev/adsp1`, define like below:

` `

    options snd-pcm-oss adsp_map=0,2

To change the mapping of MIDI devices, the following options are
available for snd-rawmidi:

-   `midi_map` -- MIDI device number assigned to `/dev/midi0X` (default
    = 0)
-   `amidi_map` -- MIDI device number assigned to `/dev/amidi0X`
    (default = 1)

For example, to assign the third MIDI device on the first card to
`/dev/midi00`, define as follows:

` `

    options snd-rawmidi midi_map=2

Retrieved from
"[http://alsa.opensrc.org/Module\_device\_mapping\_options](http://alsa.opensrc.org/Module_device_mapping_options)"

[Category](/Special:Categories "Special:Categories"):
[Howto](/Category:Howto "Category:Howto")

