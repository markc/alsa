M-Audio FastTrack Pro
=====================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

The [M-Audio](http://www.m-audio.com/) [FastTrack
Pro](http://www.m-audio.com/products/en_us/FastTrackPro-main.html) is a
4-in, 4-out external USB1.1 sound-card and uses the alsa
[Usb-audio](/Usb-audio "Usb-audio") module. It can sample and playback
with up to 24bit, 96kHz but, due to the insufficient bandwidth of
USB1.1, will only work with reduced channel count with anything higher
than 16bit, 48 kHz.

There is a [Patch by Pavel
Polischouk](http://thread.gmane.org/gmane.linux.alsa.devel/42396) posted
on gmane.linux.alsa.devel that makes 24bit sound work with this module
by using the snd-usb-audio device\_setup parameter. As this wiki does
not allow uploads of ".patch" files, I put it in a alsa-feature request.
Please try to get the [ASCII
version](https://bugtrack.alsa-project.org/alsa-bug/file_download.php?file_id=2091&type=bug)
of the patch against Kernel 2.6.22.1 from there.

Updated patch to support 2.6.27 Alsa bug ID 0003249. Patch can be
downloaded from ALSA bug track. Updated with patch for 2.6.31. Updated
patch works as described below.

Suggested entry in `/etc/modprobe.d/fast-track-pro`:

` `

    options    snd_usb_audio   vid=0x763 pid=0x2012 device_setup=0x9 index=5 enable=1

This will put the FastTrack Pro at device number 5 with 24bit mode, max.
48kHz sampling mode, 2 inputs and 4 outputs. According to the patch, the
possible values for the device\_setup parameter are the sum of the
following numbers:

-   0x01 : use the device\_setup parameter, always needed
-   0x02 : enable digital output (channels 3,4)
-   0x04 : use 48kHz-96kHz sampling rate, 8-48 kHz if not used
-   0x08 : 24bit sampling rate
-   0x10 : enable digital input (channels 3,4)

Recording can be done e.g. by using [arecord](/Arecord "Arecord"):

` `

    arecord -c2 -t raw -fS24_3BE -d5,0 ...

Retrieved from
"[http://alsa.opensrc.org/M-Audio\_FastTrack\_Pro](http://alsa.opensrc.org/M-Audio_FastTrack_Pro)"

[Category](/Special:Categories "Special:Categories"): [Sound
cards](/Category:Sound_cards "Category:Sound cards")

