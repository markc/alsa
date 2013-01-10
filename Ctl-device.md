Ctl-device
==========

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

A ctl device ("control-device") on a [soundcard](/Soundcard "Soundcard")
is used to help the user control several aspects of the soundcard's
behaviour. The main use is to control the [mixer](/Mixer "Mixer"). A ctl
device has several controls which can be controlled using
[alsamixer](/Alsamixer "Alsamixer") or other similar programs.

The ctl device can often also be used to toggle digital inputs/outputs,
etc.

See [proc asound
documentation](/Proc_asound_documentation "Proc asound documentation")
for information about the ctl device(s) on your soundcard(s). Each ctl
device can have several controls like "Master" or "PCM". You need a
mixer program to adjust these controls. They are not available via the
`/proc` interface as far as i know.

Retrieved from
"[http://alsa.opensrc.org/Ctl-device](http://alsa.opensrc.org/Ctl-device)"

[Category](/Special:Categories "Special:Categories"):
[Glossary](/Category:Glossary "Category:Glossary")

