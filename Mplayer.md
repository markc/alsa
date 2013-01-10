Mplayer
=======

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

What is `mplayer`?
------------------

**mplayer** is a mediaplayer app for Linux/X which can play a wide range
of audio and video file formats. It is available at
[http://www.mplayerhq.hu](http://www.mplayerhq.hu).

2010-02-12 - How to use an alternate ALSA device
------------------------------------------------

So you happen to have a USB audio device or a second sound card and you
want **mplayer** to use that device instead of the typcial internal
onboard audio card. First, you need an idea of the current available
audio devices. There are a number of ways to find this information, this
is just a simple method from a terminal shell...

    % aplay -l
    **** List of PLAYBACK Hardware Devices ****
    card 0: Intel [HDA Intel], device 0: ALC272 Analog [ALC272 Analog]
      Subdevices: 1/1
      Subdevice #0: subdevice #0
    card 1: H2 [H2], device 0: USB Audio [USB Audio]
      Subdevices: 1/1
      Subdevice #0: subdevice #0

In the example above there are 2 audio devices, a typcial Intel onboard
audio device and an external ZOOM H2 USB audio device. In ALSA terms
(note the **card \#:** and **device \#:** numbers) the 2 ALSA devices
would be known as **hw:0.0** and **hw:1.0** (an alternate would be
plughw:0.0 and plughw:1.0 respectively) so to translate this to what
**mplayer** needs we could use this below to use the external USB
device...

    mplayer -ao alsa:device=hw=1.0 groovy.mp3

or **alsa:device=hw=0.0** to use the first device. You could also
hardwire these settings so **mplayer** would always use them without
having to specify it on the command line every time, but, then you would
always have to make sure the USB device is available on reboot. Hints;
the **lsusb** command will show available USB devices and **arecord -l**
will confirm the capture (audio in) device names.

    % cat ~/.mplayer/config
    ao=alsa:device=hw=1.0

\

See also
--------

-   [mplayer (Howto)](/Mplayer_(Howto) "Mplayer (Howto)")

Retrieved from
"[http://alsa.opensrc.org/Mplayer](http://alsa.opensrc.org/Mplayer)"

[Category](/Special:Categories "Special:Categories"):
[Software](/Category:Software "Category:Software")

