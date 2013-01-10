Record from mic
===============

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

In order to record from a device, the device's "capture" switch must be
set. To do so, run `alsamixer`, select your microphone and press space.
Something like...

` `

       CAPTUR
       L    R

should appear. On some cards there is a separate "Capture" device, which
must be set to capture as well (and be unmuted, and have volume
increased).

There can also be a "Mic Capture" volume that must be set. To avoid the
sound from the microphone going through speakers, you can mute the
microphone by pressing "m" (I am not sure about that.) Also keep your
eyes open for a "Mic Boost" option. This may have only two settings,
"muted" and "unmuted"; in the later case it will amplify the microphone
input by an additional 20dB.

Another option to check is the Mic number. I battled for ages trying to
get my mic working under SuSe 9.1. In the end I discovered I had to
select "Mic 2" using alsamixer - the default was "Mic 1". Alternatively,
run `amixer` to see all controls. An example of a part of the output can
be:

` `

    Simple mixer control 'Mic',0
      Capabilities: pvolume pvolume-joined cvolume \
         pswitch pswitch-joined cswitch cswitch-joined
      Playback channels: Mono
      Capture channels: Mono
      Limits: Playback 0 - 31 Capture 0 - 7
      Mono: Playback 23 [74%] [on] Capture 5 [71%] [off] 

In this case you set Capture on with the command
`amixer sset Mic Capture cap`. (The Capture volume was set with the
command `amixer sset Mic Capture 71%`.) If you don't want the input from
your microphone to go immediately through your speakers, mute the
Playback: `amixer sset Mic Playback mute`. (I'm not very sure about
that, correct me if I am wrong.)

I am also not sure the control you need to change is called 'Mic', in
some cases, this can probably be another control or have another name.

**Important:** Make sure \_both\_ the Mic Capture and the Capture device
are enabled (press space on them) and have a non-zero input volume. In
alsamixer for my sound card, the Capture device (Item) is on the far
right.

On many AC97 based soundcards Capture can have volume of 0 (thes means 0
dB). Max value is +34 dB. Capture control amplify input signal.

Other things to try:

-   try running aumix. On some (AC97-based?) cards, there is an IGain
    slider that you can increased to 100%. If this enables recording, it
    might be that you hadn't enabled told the Capture device to Capture;
    aumix does this whenever the IGain is changed.

-   Comment from reader: *For me, the instructions above did not still
    cut it. I had to turn a control "AC97" to 100% (in addition to Mic
    and Capture to 100%).*

-   If you can hear your mic, but aren't able to record from it, make
    sure the mic isn't muted, is set to capture, and if there is a
    Capture device, set it to capture, unmute it, and turn the volume
    up.

-   Comment from reader: 'In order to have Mic working in Skype
    (1.4.0.118) I did all the above and, in addition to it, I also had
    to go inside Skype application, \<Options\>, \<Sound devices\>,
    \<Sound In\> and set \<Nvidia nForce.(hw:nForce,0)\>.'

-   Comment from reader: *In my case, with the `snd-hda-intel` driver
    there was a mislabeling of capture channels (probably due to
    incorrectly selected model in `snd-hda-intel`). The alsamixer
    capture item labelled "Digital" was controlling the microphone
    recording volume, while "Capture" and "Capture1" didn't change
    anything.*

Retrieved from
"[http://alsa.opensrc.org/Record\_from\_mic](http://alsa.opensrc.org/Record_from_mic)"

[Category](/Special:Categories "Special:Categories"):
[Howto](/Category:Howto "Category:Howto")

