Edirol UA-5
===========

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

The alsaconf utility adds this to the `/etc/modules.conf` section as
second audio device:

` `

    alias snd-card-1 snd-usb-audio
    alias sound-slot-1 snd-card-1
    alias sound-service-1-0 snd-mixer-oss
    alias sound-service-1-1 snd-seq-oss
    alias sound-service-1-3 snd-pcm-oss
    alias sound-service-1-8 snd-seq-oss
    alias sound-service-1-12 snd-pcm-oss

`cat /proc/asound/cards` should show the UA-5 if all modules loaded fine
after stop/starting alsa:

` `

    /etc/init.d/alsa stop
    /etc/init.d/alsa start

` `

    aplay -D plughw:1,0 foo.wav

` `

    aplay -l
    <card 0 stuff removed here>
       List of PLAYBACK Hardware Devices ****
    card 1: UA5 [UA-5], device 0: USB Audio [USB Audio]
      Subdevices: 0/1
      Subdevice #0: subdevice #0

`alsamixer -c 1` to use mixer settings on card 1 will return:

` `

    no mixer elems found

since these are the hardware knobs on the ua-5 device, nothing will show
up in mixer programs but the name "mixer10".

One could put an [.asoundrc](/.asoundrc ".asoundrc") in here/his home
directory:

` `

    pcm.ua5 {
        type hw
        card 1
        device 0
    }

    ctl.ua5 {
        type hw
        card 1
    }

    pcm.!default {
        type plug
        slave {
            pcm ua5
        }
    }

* * * * *

So `aplay foo.wav` will play just fine (the !default alsa device is now
'linked' to the `plughw:1,0` device, the ua-5.

The knob setting 44.1/48/96 KHz speed only gets activated after
rebooting the device. (Windows(TM) inside %-)).

XMMS with the xmms-alsa output pluging seems to work.

Please contribute quirks, tips here.

-   What recording tools to use?
-   Does sound skip playing while doing updatedb on the machine (mine
    does).

See also
--------

-   vendor link:
    [http://www.edirol.com/products/info/ua5.html](http://www.edirol.com/products/info/ua5.html)
-   Inside the UA-5 photo's:
    [http://he.fi/photo/ua5-dissection/](http://he.fi/photo/ua5-dissection/)
-   Alternative non-alsa driver:
    [http://www.michaelminn.com/index.html?linux/mmusbaudio/README.html](http://www.michaelminn.com/index.html?linux/mmusbaudio/README.html)

Retrieved from
"[http://alsa.opensrc.org/Edirol\_UA-5](http://alsa.opensrc.org/Edirol_UA-5)"

[Category](/Special:Categories "Special:Categories"): [Sound
cards](/Category:Sound_cards "Category:Sound cards")

