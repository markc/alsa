Via
===

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Note: Via does not produce sound cards - but their motherboard chip sets
do provide an interface for audio chips mounted on the motherboard. See
[Sound Cards:
Introduction](/Sound_Cards:_Introduction "Sound Cards: Introduction")
for details.

Via Sound Card Interface
------------------------

If your VIA sound card does not work, type at the terminal window:

` `

    lspci -nv | grep -1 0401

Then find your card below, and set the correct module DXS setting.

` `

    1 )Class 0401: 1106:3059 (rev 50)
       Subsystem: 15bd:1001
       Default module option for dxs_support works fine.
       If sound is not working, distorted, or not loud enough
       Set all 4 VIA DXS mixers to 100%.
       master mixer to 74%, pcm also to 74%

If your sound is distorted, mute the IEC958 channel.

Retrieved from
"[http://alsa.opensrc.org/Via](http://alsa.opensrc.org/Via)"

[Category](/Special:Categories "Special:Categories"): [Sound
cards](/Category:Sound_cards "Category:Sound cards")

