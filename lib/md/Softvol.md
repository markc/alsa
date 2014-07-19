# Softvol

This is the page about the **softvol plugin**, an [ALSA
plugin](/ALSA_plugins "ALSA plugins") that allows the user to add a new
volume control and control the sound volume or parts of it by software.
This is often necessary if the sound card can't control the volume by
hardware. Another usefull thing you can do is control the volume of
every application seperatly, even if the application can't do it on its
own.

## Basic usage

A basic configuration in the `~/.asoundrc` file looks like this:

    pcm.newdevice {
        type            softvol
        slave.pcm       "default"
        control.name    "Softmaster"
        control.card    0
    }

This creates a new [PCM device](/PCM_device "PCM device") called
`newdevice` whose volume is controlled by a new volume control called
`Softmaster`. The audio stream with changed volume will be passed to the
`default` device. As the plugin doesn't change anything but the volume,
*[sample
format](?title=Sample_format&action=edit&redlink=1 "Sample format (page does not exist)")*,
*[sample
rate](?title=Sample_rate&action=edit&redlink=1 "Sample rate (page does not exist)")*
and *number of channels* of the new device are equivalent to the values
of the slave.

It is not possible to redefine a non user defined control! If the name
of the new volume control already exists, the new device just copies the
stream to its slave without changing anything. Use
`amixer controls | grep Softmaster` to find out whether the control
already exists. However, it is possible to create a control named
"Master" to get a proper master volume control **if** the soundcard does
not have one itself. See [How to use softvol to control the master
volume](/How_to_use_softvol_to_control_the_master_volume "How to use softvol to control the master volume").

  ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
  **Note:**The new volume control won't appear imidiately! Only **after the first usage** of the newly defined device (e.g. with [speaker-test](/Speaker-test "Speaker-test")), should `amixer sget Softmaster` display the new control. [Mixers](/Mixer "Mixer") that were already started before the first usage (like KMix) have to be restarted to adopt the changes. If the new control is still not there, try restarting ALSA or your PC.
  ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

## Removing a volume control

This task is not as easy at it seems, if you don't know the trick. If
the correspondant part of the configuration file is just deleted and
`alsactl store` has been executed after the usage of the device in
question, the volume control won't disappear. `alsactl store` stores the
value of all controls (among them the softvol device) in
`/etc/asound.state` and is most likely executed on every shutdown of
your computer.

To make the volume control disappear finally, you have to delete its
values in `/etc/asound.state` or just the whole file (it will be
recreated with default values on next reboot). After that, your computer
has to be restarted once without the execution of `alsactl store` on
shutdown. On Debian, this can be achieved by temporarily renaming
`/etc/rc6.d/K50alsa-utils` (or similar). Pressing the reset button also
works, but should be avoided.

## See also

-   [The .asoundrc file](/The_.asoundrc_file "The .asoundrc file"),
    [.asoundrc](/.asoundrc ".asoundrc") and [Plugin
    Documentation](/Plugin_Documentation "Plugin Documentation") -
    General information about setting up PCM devices
-   [How to use softvol to control the master
    volume](/How_to_use_softvol_to_control_the_master_volume "How to use softvol to control the master volume")
-   [Official
    documentation](http://www.alsa-project.org/alsa-doc/alsa-lib/pcm_plugins.html#pcm_plugins_softvol)
    on the ALSA projects page.
-   The [route
    plugin](?title=Route_(plugin)&action=edit&redlink=1 "Route (plugin) (page does not exist)")
    - Another [ALSA plugin](/ALSA_plugins "ALSA plugins") changing the
    volume (among other things), but statically
