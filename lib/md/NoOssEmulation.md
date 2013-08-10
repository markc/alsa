NoOssEmulation
==============

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

You may decide not to install the
[OssEmulation](/OssEmulation "OssEmulation") feature since ALSA is the
Way of the Future. If so you must also make sure that you install
versions of other libraries that are linked with ALSA, not with OSS.
You'll know an app is trying to use OSS if it reports it can't open
`/dev/dsp` (an [OSS device](/OSS_device "OSS device")). For example, on
Debian the following packages should used:

-   **GNOME:**
    install `libesd-alsa0` and remove `libesd0`

-   **alsaplayer:**
    install `alsaplayer-alsa` and remove `alsaplayer-oss`

Retrieved from
"[http://alsa.opensrc.org/NoOssEmulation](http://alsa.opensrc.org/NoOssEmulation)"

[Category](/Special:Categories "Special:Categories"):
[OSS](/Category:OSS "Category:OSS")

