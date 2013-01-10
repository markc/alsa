Snd-seq-oss
===========

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

This is the [OssEmulation](/OssEmulation "OssEmulation") module that
emulates the OSS sequencer interface for MIDI stuff. It supports both
playback to your soundcard's MIDI synth device (if it has one, otherwise
use [Timidity](/Timidity "Timidity")) and playback to external MIDI
keyboards. Recording from MIDI keyboards doesn't work yet. This is a
known bug (*see Alsa-devel 2002/8/26 and 2003/12/7*).

This module provides the two MIDI [OSS
Devices](?title=OSS_Device&action=edit&redlink=1 "OSS Device (page does not exist)"):

` `

      /dev/sequencer (recording doesn't work yet)
      /dev/sequencer2

Please also see the [OSS Sequencer
Emulation](/OSS_Sequencer_Emulation "OSS Sequencer Emulation") page.

The other [OSS devices](/OSS_device "OSS device") are emulated by the
modules *[snd-mixer-oss](/Snd-mixer-oss "Snd-mixer-oss")* and
*[snd-pcm-oss](/Snd-pcm-oss "Snd-pcm-oss")*.

Retrieved from
"[http://alsa.opensrc.org/Snd-seq-oss](http://alsa.opensrc.org/Snd-seq-oss)"

[Category](/Special:Categories "Special:Categories"): [ALSA
modules](/Category:ALSA_modules "Category:ALSA modules")

