OSS device
==========

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

One of the aims of ALSA is to provide full compatibility for OSS
applications. ALSA has a powerful
[OSSEmulation](/OSSEmulation "OSSEmulation") which provides the
following **OSS devices**:

**PCM**

-   /dev/dsp*X* (8-bit unsigned)
-   /dev/adsp*X*
-   also probably /dev/dspW (16-bit little-endian) and /dev/audio
    (logarithmic mu-law encoding; 12 or 16-bit samples crunched into
    8-bit representation)

**Mixer**

-   /dev/mixer*X*

**MIDI**

-   /dev/midi0*X*
-   /dev/amidi0*X*

**Sequencer**

-   /dev/sequencer
-   /dev/sequencer2 (aka /dev/music)

**Probably not supported:**

-   /dev/sndstat (human-readable status file, not intended for use by
    programs)
-   /dev/dmfm*X* (raw low-level access to fm synthesizer registers)
-   /dev/dmmidi*X* (raw low-level access to midi bus)

*X* is the card number from 0 to 7.

Unlike actual OSS, ALSA cannot use device files more than the assigned
ones. For example, the first card cannot use /dev/dsp1 or /dev/dsp2, but
only /dev/dsp0 and /dev/adsp0. In an OSS installation, symlinks without
the trailing device numbers are often used to connect to devices; for
example, /dev/dsp might be a symlink pointing to /dev/dsp0.

Some distributions have the device files like */dev/midi0* and
*/dev/midi1*. These are not for OSS. They are for tclmidi, which is a
totally different thing.

Retrieved from
"[http://alsa.opensrc.org/OSS\_device](http://alsa.opensrc.org/OSS_device)"

[Category](/Special:Categories "Special:Categories"):
[OSS](/Category:OSS "Category:OSS")

