Getting oss emulation to work with 2 Sound cards
================================================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Contents
--------

-   [1 Getting OSS emulation to work with 2 sound
    cards](#Getting_OSS_emulation_to_work_with_2_sound_cards)
-   [2 Bugs and Workarounds](#Bugs_and_Workarounds)
    -   [2.1 Getting OSS emulation to work with 2 Sound
        cards](#Getting_OSS_emulation_to_work_with_2_Sound_cards_2)

-   [3 Probleme und Wege, sie zu umgehen
    (german)](#Probleme_und_Wege.2C_sie_zu_umgehen_.28german.29)
    -   [3.1 OSS Emulation mit zwei Soundkarten
        (german)](#OSS_Emulation_mit_zwei_Soundkarten_.28german.29)

Getting OSS emulation to work with 2 sound cards
------------------------------------------------

I spend some hours on getting
[OSSEmulation](/OSSEmulation "OSSEmulation") working with two cards on
my up-to-date gentoo 1.4rc2 based system with plain vanilla 2.4.20
kernel. The nice people on the Alsa-user mailing list helped me get it
working. Apparently there is a problem with the sound-related `devfs`
code in 2.4.x kernels up to and including 2.4.20.

* * * * *

Georgi Georgiev \<chutz@gg3.net\>:

The `devfs` code of ALSA seems to not work correctly. Even though my
setup is as described below, the device `/dev/sound/dsp1` for example,
is not created (just check the whole mail).

Creating a device manually does the job, but creating a device on every
boot is annoying. ` `

    (...)
    $ cat /proc/asound/oss/devices
       2: [0- 2]: raw midi
       0: [0- 0]: mixer
       3: [0- 3]: digital audio
      12: [0-12]: digital audio
      18: [1- 2]: raw midi
      26: [1-10]: hardware dependent
      16: [1- 0]: mixer
      19: [1- 3]: digital audio
      28: [1-12]: digital audio
    (...)

* * * * *

As he states, the OSS emulation gets loaded correctly for two cards but
the [OSS device](/OSS_device "OSS device") nodes are not created in
`/dev/sound` and also the links are missing in `/dev`.

* * * * *

Jaroslav Kysela `<perex@suse.cz>`:

It's not an ALSA problem, but the `sound_core.c` from the 2.4 kernel is
buggy. Unfortunately, Marcelo hasn't accepted our patch. Here it is:
(...)

* * * * *

The patch doesn't work, as Georgi Georgiev states in another mail:

I just tried the patch and I use a vanilla 2.4.20 kernel. Only the
fourth chunk is not applicable, because it seems sort of applied
already. The function `register_sound_special()` that is in the kernel
looks a lot like the alsa patch wants it to look like. The part that is
not applied is the shortcut with the unknown devices - the kernel source
prefers a long `switch` statement, rather than using a `goto`. (...)

The `/dev/sound` devices are created as expected with this patch. I
could do `"modprobe -r snd-pcm-oss"`, but when I decided to do
`"modprobe -r snd-cmipci"` I got a segfault, and
`"modprobe -r snd-emu10k1"` (right after that) froze the modprobe
process.

* * * * *

I therefore put the following in my `/etc/conf.d/local.start` as a
workaround:

` `

    echo Creating missing Sound devices
    mknod  /dev/sound/dsp1 c 14 19
    mknod  /dev/sound/mixer1 c 14 16
    chown root.audio /dev/sound/dsp1
    chown root.audio /dev/sound/mixer1
    chmod 664 /dev/sound/dsp1 /dev/sound/mixer1
    ln -s /dev/sound/dsp1 /dev/dsp1
    ln -s /dev/sound/mixer1 /dev/mixer1
    echo "Sound should be ok now!"

It's not nice but it works.

Bugs and Workarounds
--------------------

See also: [BugTracking](/BugTracking "BugTracking")

### Getting OSS emulation to work with 2 Sound cards

If you need [OSSEmulation](/OSSEmulation "OSSEmulation") for two or more
cards, you have to work around a problem with recent kernels up to and
including 2.4.20. At the time of this writing 2.4.20 is the most current
kernel version. Hopefully this will be fixed in later kernel versions
but it might still apply to later versions.

The `devfs` code does ***not*** create [OSS
device](/OSS_device "OSS device") nodes in `/dev/sound` and links in
`/dev`. As a workaround those have to be created manually or
automatically at boot time. ` `

    nano -w /etc/conf.d/local.start

    #Set up device nodes for alsa oss emulation for the second sound card
    mknod  /dev/sound/dsp1 c 14 19
    mknod  /dev/sound/mixer1 c 14 16
    chown root.audio /dev/sound/dsp1
    chown root.audio /dev/sound/mixer1
    chmod 664 /dev/sound/dsp1 /dev/sound/mixer1
    ln -s /dev/sound/dsp1 /dev/dsp1
    ln -s /dev/sound/mixer1 /dev/mixer1

This will automatically create the missing device nodes that `devfs`
should but doesn't create automatically at boot time. This workaround is
needed as long as the kernel's `devfs` code does not create them
automatically.

Probleme und Wege, sie zu umgehen (german)
------------------------------------------

### OSS Emulation mit zwei Soundkarten (german)

Wenn man [OSSEmulation](/OSSEmulation "OSSEmulation") für zwei
Soundkarten benötigt, muss man ein Problem im `devfs` Code des 2.4.x
Kernels umgehen. Das Problem tritt bis einschließlich Version 2.4.20
auf. Möglicherweise sind auch noch kommende Versionen betroffen.

Das `devfs` legt nur [OSS devicenodes](/OSS_device "OSS device") für die
erste Soundkarte in `/dev/sound` an. Ausserdem werden keine Links in
`/dev` gesetzt. Diese müssen daher manuell oder automatisch beim
Systemstart generiert werden.

Code listing 5.1 ` `

    nano -w /etc/conf.d/local.start

    #Set up device nodes for alsa oss emulation for the second sound card
    mknod  /dev/sound/dsp1 c 14 19
    mknod  /dev/sound/mixer1 c 14 16
    chown root.audio /dev/sound/dsp1
    chown root.audio /dev/sound/mixer1
    chmod 664 /dev/sound/dsp1 /dev/sound/mixer1
    ln -s /dev/sound/dsp1 /dev/dsp1
    ln -s /dev/sound/mixer1 /dev/mixer1

Dieser Workaround legt das `dsp1` und das `mixer1` device beim
Bootvorgang an. Er ist so lange nötig, bis der Kernel diese über `devfs`
automatisch anlegen kann.

RichardStevens 20030104

Retrieved from
"[http://alsa.opensrc.org/Getting\_oss\_emulation\_to\_work\_with\_2\_Sound\_cards](http://alsa.opensrc.org/Getting_oss_emulation_to_work_with_2_Sound_cards)"

[Categories](/Special:Categories "Special:Categories"):
[Howto](/Category:Howto "Category:Howto") |
[OSS](/Category:OSS "Category:OSS")

