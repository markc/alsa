Aoa
===

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Contents
--------

-   [1 Apple Onboard Audio](#Apple_Onboard_Audio)
-   [2 Kernel configuration](#Kernel_configuration)
-   [3 Resources](#Resources)
-   [4 See also](#See_also)

Apple Onboard Audio
-------------------

`snd-aoa` is the ALSA module for certain G4 PowerMacs, G5 PowerMacs and
newer PowerBooks. The main module requires certain helper modules, such
as `snd-aoa-soundbus`, `snd-aoa-i2sbus`, `snd-aoa-fabric-layout` as well
as the module for the actual sound chip.

On 2.6.x kernels do:

    # cat /proc/device-tree/model

If you have a PowerMac or a PowerBook, you should now see a line like
this:

    PowerMac10,1

The `PowerMac10,1` is a Mac Mini (PowerPC G4). You can find a list at
[EveryMac.com](http://www.everymac.com/systems/by_capability/mac-specs-by-machine-model-machine-id.html)
or at [The Apple
Museum](http://www.foljanty.de/theapplemuseum/index.php?id=36).

Then, check if it features the layout-id device tree
entry:^[[1]](http://lists.debian.org/debian-powerpc/2006/05/msg00365.html)^

    # find /proc/device-tree/ -name layout-id | xargs hexdump -e '1/4 "0x%x\n"'

This will give a hexadecimal number if a layout-id is present.

Should your Mac not provide a layout-id, it is possible that it still
works using the device-id. Since a lot of devices feature this property,
it must be filtered to only show the device-id of the sound device. The
following works if it gives one single line as output:

    # find /proc/device-tree/ -name device-id | grep sound | xargs hexdump -e '1/4 "0x%x\n"'

This should give a hexadecimal number of the device-id for the sound
device.

\
 *You can use `snd-aoa` if your layout-id or device-id (in decimal) is
listed in `/usr/src/linux/sound/aoa/fabrics/snd-aoa-fabric-layout.c`.*

In order to get the correct layout-id or device-id for comparison with
the ones in the ALSA source files you need to convert them from
hexadecimal to decimal using a suitable calculator.

Kernel configuration
--------------------

If you use the in-kernel version of ALSA you need to enable the
following additionally to ALSA sound in general:

    CONFIG_SND_POWERMAC=m
    CONFIG_SND_AOA=m
    CONFIG_SND_AOA_FABRIC_LAYOUT=m
    CONFIG_SND_AOA_SOUNDBUS=m
    CONFIG_SND_AOA_SOUNDBUS_I2S=m

In addition, choose the driver for your PowerMac:

    CONFIG_SND_AOA_ONYX=m
    CONFIG_SND_AOA_TAS=m
    CONFIG_SND_AOA_TOONIE=m

Resources
---------

-   [Module-aoa](http://bugtrack.alsa-project.org/main/index.php/Matrix:Module-aoa)
    at alsa-project.org
-   Apple Support: all
    [PowerMacs](http://support.apple.com/specs/#powermac),
    [PowerBooks](http://support.apple.com/specs/#powerbook) and
    [iBooks](http://support.apple.com/specs/#ibook) ever produced by
    Apple; the [original Mac Mini](http://support.apple.com/kb/SP65)
    (including the “Late 2005” silent update) is the only PowerPC-based
    Mac Mini

See also
--------

-   [Powermac](/Powermac "Powermac") – a similar (but older and less
    advanced) ALSA module

Retrieved from
"[http://alsa.opensrc.org/Aoa](http://alsa.opensrc.org/Aoa)"

[Categories](/Special:Categories "Special:Categories"): [ALSA
modules](/Category:ALSA_modules "Category:ALSA modules") | [Sound
cards](/Category:Sound_cards "Category:Sound cards")

