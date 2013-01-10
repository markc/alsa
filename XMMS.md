XMMS
====

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

**Configuring XMMS with ALSA for digital output (spdif)**

-   from XMMS Options-\>Preferences (Ctrl P), select the tab "Audio I/O
    Plugins"
-   in the box "Output Plugin", select the "ALSA 1.2.8 output plugin
    [libALSA.so]" and press the "Configure" button
-   in "ALSA Driver configuration", click the checkbox "[x] User
    defined:" and enter **spdif** instead of **default**
-   leave the "Mixer card:" set to "0", and "Mixer device:" set to "PCM"

This will select the digital output for the soundcard and now XMMS will
send the output to ALSA's digital output. Only stereo tracks work at the
moment, for some odd reason mono tracks won't play.

You can use XMMS with a plugin to play [MIDI](/MIDI "MIDI") files.

Retrieved from
"[http://alsa.opensrc.org/XMMS](http://alsa.opensrc.org/XMMS)"

[Category](/Special:Categories "Special:Categories"):
[Software](/Category:Software "Category:Software")

