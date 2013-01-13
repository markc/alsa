Setting up modprobe and kmod support
====================================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

The ALSA kernel modules must be loaded every time you boot or reboot
[Linux](/Linux "Linux"). These modules can be loaded automatically by
the `modprobe` command which is part of the `modutils` utilities. The
`modprobe` command uses a configuration file which tells it which kernel
modules to load and how to load them. This document explains how to set
up the `modprobe` configuration file.

The name of the `modprobe` configuration file has unfortunately been
changed several times. For the most recent Linux kernels, Linux 2.6.x,
the file is called `modprobe.conf`. For old Linux kernels such as Linux
2.4.x, the file was called `modules.conf` or even `conf.modules`. You
need to work out what is the name of the file in your particular Linux
distribution. There is also unfortunately no standard location for the
file; the location varies between different Linux distributions. The
file is usually in the directory `/etc`, but if you are using Debian
Linux, the file is either in the directory `/lib/modules` or
`/etc/modutils`. You need to work out where the file is in your
particular Linux distribution.

Assuming you know the name and the location of the `modprobe`
configuration file, it is easy to add support for ALSA kernel modules.
You just need to edit the file and add a few extra lines to it.

Here are two examples of the ALSA-related part of a `modprobe`
configuration file. Add the following lines by copying and pasting them
at the bottom of your configuration file but do not erase the existing
contents of the file. The lines that begin with the "\#" character are
optional comments only. Note to Debian users only: Afterwards you need
to run `update-modules`.

Example 1: A modprobe configuration for a Yamaha OPL3SA2 soundcard
------------------------------------------------------------------

` `

    # ALSA portion
    alias char-major-116 snd
    alias snd-card-0 snd-opl3sa2
    # module options can go here

    # OSS/Free portion
    alias char-major-14 soundcore
    alias sound-slot-0 snd-card-0

    # card #1
    alias sound-service-0-0 snd-mixer-oss
    alias sound-service-0-1 snd-seq-oss
    alias sound-service-0-3 snd-pcm-oss
    alias sound-service-0-8 snd-seq-oss
    alias sound-service-0-12 snd-pcm-oss

Example 2: A modprobe configuration for a Creative Audigy 2 ZS soundcard
------------------------------------------------------------------------

` `

    # ALSA portion
    alias char-major-116 snd
    alias snd-card-0 snd-emu10k1

    # module options can go here

    # OSS/Free portion
    alias char-major-14 soundcore
    alias sound-slot-0 snd-card-0

    # card #1
    alias sound-service-0-0 snd-mixer-oss
    alias sound-service-0-1 snd-seq-oss
    alias sound-service-0-3 snd-pcm-oss
    alias sound-service-0-8 snd-seq-oss
    alias sound-service-0-12 snd-pcm-oss

Retrieved from
"[http://alsa.opensrc.org/Setting\_up\_modprobe\_and\_kmod\_support](http://alsa.opensrc.org/Setting_up_modprobe_and_kmod_support)"

[Category](/Special:Categories "Special:Categories"):
[Howto](/Category:Howto "Category:Howto")

