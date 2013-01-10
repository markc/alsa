Tascam US-224
=============

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

  ------------------------------------------------------------------------- ---------------------------------------------------------------------------------------------------------------------------------------------
  [File:Merge-arrows.gif](/File:Merge-arrows.gif "File:Merge-arrows.gif")   There is another article called [Usb-usx2y](/Usb-usx2y "Usb-usx2y") with a very similar content. **Please be bold an merge the two pages!**
  ------------------------------------------------------------------------- ---------------------------------------------------------------------------------------------------------------------------------------------

  ------------------------------------------------------------------------- ----------------------------------------------------------------------------------------------------------------------------------------------------------
  [File:Merge-arrows.gif](/File:Merge-arrows.gif "File:Merge-arrows.gif")   There is another article called [Tascam\_US-122](/Tascam_US-122 "Tascam US-122") with a very similar content. **Please be bold an merge the two pages!**
  ------------------------------------------------------------------------- ----------------------------------------------------------------------------------------------------------------------------------------------------------

  ------------------------------------------------------------------------- ----------------------------------------------------------------------------------------------------------------------------------------------------------
  [File:Merge-arrows.gif](/File:Merge-arrows.gif "File:Merge-arrows.gif")   There is another article called [Tascam\_US-428](/Tascam_US-428 "Tascam US-428") with a very similar content. **Please be bold an merge the two pages!**
  ------------------------------------------------------------------------- ----------------------------------------------------------------------------------------------------------------------------------------------------------

[http://www.tascam.com/Products/US-224/us224\_frontFP.jpg](http://www.tascam.com/Products/US-224/us224_frontFP.jpg)

\
 The Tascam US-224 is an external USB audio device which sports the
following features:

-   high-quality 24-bit audio with two inputs and two outputs,
-   self-powered USB interface,
-   four faders, transport/locate controls, data wheel and more for
    control of DAW parameters,
-   records at up to 48kHz, 24-bit resolution,
-   16-channel MIDI In/Out interface,
-   small, portable and easy to use.

The Tascam US-224 is well supported under Alsa, but it can be tricky to
get it running at its maximum potential. Hopefully after reading this
document you will be able to:

-   get it to play sounds :),
-   obtain good latencies with [JACK](/JACK "JACK") (under 6ms),
-   control [Ardour](/Ardour "Ardour") using the card's buttons and jog
    wheel.

Contents
--------

-   [1 The ingredients](#The_ingredients)
-   [2 Maybe it 'Just Works'?](#Maybe_it_.27Just_Works.27.3F)
-   [3 Setting up your US-224
    manually](#Setting_up_your_US-224_manually)
    -   [3.1 Kernel module](#Kernel_module)
    -   [3.2 Setting up firmware and
        FPGA](#Setting_up_firmware_and_FPGA)
    -   [3.3 Starting us428control](#Starting_us428control)
    -   [3.4 Testing the card](#Testing_the_card)

-   [4 Minimizing latency in JACK](#Minimizing_latency_in_JACK)
-   [5 Using the control surface in
    Ardour](#Using_the_control_surface_in_Ardour)
-   [6 Troubleshooting](#Troubleshooting)
-   [7 See also](#See_also)

The ingredients
---------------

In order to make your US-224 work under linux you will need:

-   a fairly recent 2.6 kernel (US-224 support is included from version
    2.6.9),
-   the [alsa-tools](/Alsa-tools "Alsa-tools") and
    [alsa-firmware](?title=Alsa-firmware&action=edit&redlink=1 "Alsa-firmware (page does not exist)")
    packages, which are most likely included as installable packages in
    your distribution of choice (alternatively you can get them from the
    [Alsa website](http://www.alsa-project.org/)),
-   the firmware loader 'fxload', which again is probably already
    included in your distribution (in any case you can download it from
    the [linux hotplug website](http://linux-hotplug.sourceforge.net/)).

You could also use the external alsa drivers instead of those included
with your kernel version, even if with a modern kernel there are no real
reasons to do so.

To make your life easier you should also make sure that the `lsusb`
command, from the ['usbutils'](http://linux-usb.sourceforge.net/)
package, is available on your system. It will allow you to easily
identify the resources used by your card without poking inside `/proc`.

Maybe it 'Just Works'?
----------------------

Chances are that your distribution has already set everything up for
you, and the card is configured automatically when it is plugged in your
PC. If the green led marked as 'USB' lights up a few seconds after the
card is plugged in and turned on, you can safely skip the next section.
Otherwise keep on reading.

Setting up your US-224 manually
-------------------------------

We are now going to explain how to setup your US-224 manually. Please
make sure your card is connected to a USB port and turned on. The green
led named 'Power' should be on.

### Kernel module

The first step is to make sure that the appropriate kernel module (which
is known as the 'driver' in the Windows world) is available and loaded.
The kernel module for the US-224 is called
**snd-[usb-usx2y](/Usb-usx2y "Usb-usx2y")**, and to make sure it is
available on your system you can run the following command as root (from
now on all commands will have to be run as root unless stated
otherwise):

`  `

    $ modprobe snd-usb-usx2y

If the module is available it will be loaded silently, otherwise some
kind of error message will be shown. If the module is not present you
will have to recompile your kernel. You can find a lot of howtos which
thoroughly explain this step (a good one can be found
[here](http://www.faqs.org/docs/Linux-HOWTO/Kernel-HOWTO.html)). Make
sure you select the snd-usb-usx2y module in the Alsa section of your
kernel configuration, under 'USB devices'.

Once you have loaded the kernel module, it should show up when executing
the `lsmod` command, whose output should contain lines similar to these
ones:

` `

    $ lsmod
    Module                  Size  Used by
    [...]
    snd_usb_usx2y          20160  0
    [...]

Please note that hyphens are replaced by underscores in the output of
`lsmod`.

### Setting up firmware and FPGA

The kernel module is not enough to make the card work. The US-224 needs
also a firmware and its FPGA must be programmed before use.

To load the firmware you will need the 'fxload' utility (as described
above) and two firmware binary files. These files are included in the
[alsa-firmware](?title=Alsa-firmware&action=edit&redlink=1 "Alsa-firmware (page does not exist)")
package, and are are named `tascam_loader.ihx` and `us224fw.ihx`. They
can typically be found in such locations as
`/usr/share/alsa/firmware/usx2yloader`,
`/usr/local/share/alsa/firmware/usx2yloader`, etc. Before loading the
firmware you must find out which bus the card is attached to and which
device number it has been assigned. The best way to gather this info is
through the `lsusb` utility, from the 'usbutils' packages. Executing
`lsusb` from the console will output something similar to this:

` `

    Bus 003 Device 008: ID 04b4:6830 Cypress Semiconductor Corp. USB-2.0 IDE Adapter
    Bus 003 Device 001: ID 0000:0000
    Bus 002 Device 007: ID 1604:8004 Tascam US-224 Audio/Midi Controller (without fw)
    Bus 002 Device 006: ID 046d:c03d Logitech, Inc.
    Bus 002 Device 001: ID 0000:0000
    Bus 001 Device 001: ID 0000:0000

In this case the card is attached to Bus 002 and its device number is
007. As you can see `lsusb` recognizes that the card is without
firmware.

Now we can upload the firmware to the card using the following command:

` `

    $ fxload  -s /usr/share/alsa/firmware/usx2yloader/tascam_loader.ihx \
      -I /usr/share/alsa/firmware/usx2yloader/us224fw.ihx -D /proc/bus/usb/002/007

You will have to use the locations of the actual firmware files on your
system, and the bus/device numbers your card is related to. Beware that
they are not static and they will change as you connect/disconnect USB
devices.

You can check that the firmware has actually been loaded into the card
by launching the `lsusb` command again. It should output something like
this:

` `

    Bus 003 Device 008: ID 04b4:6830 Cypress Semiconductor Corp. USB-2.0 IDE Adapter
    Bus 003 Device 001: ID 0000:0000
    Bus 002 Device 008: ID 1604:8005 Tascam US-224 Audio/Midi Controller
    Bus 002 Device 006: ID 046d:c03d Logitech, Inc.
    Bus 002 Device 001: ID 0000:0000
    Bus 001 Device 001: ID 0000:0000

As you can see the card's device number has increased by one and the
`(without fw)` indication has disappeared.

As for the FPGA, it needs to be programmed before using the card. You
can do this by simply launching the `usx2yloader` command, from the
[alsa-tools](/Alsa-tools "Alsa-tools") package:

` `

    $ usx2yloader

At this point after a couple of seconds the card's leds should blink,
and the 'USB' green led should turn on. You may also hear a clicking
sound if your speakers are connected to the card.

### Starting us428control

'[us428control](?title=Us428control&action=edit&redlink=1 "Us428control (page does not exist)")'
is a small program, available in the
[alsa-tools](/Alsa-tools "Alsa-tools") package, that sits in the
background and manages the physical controls on your US-224. If you do
not run it you may not be able to hear anything from the card because it
is muted by default and there are no software mixers on the board. The
only way to raise the volume is through the knobs and faders, and they
are non functional until 'us428control' is running. You should launch
`us428control` by appending `&`, so that it won't block your console
while it is running:

` `

    $ us428control &

This command may output a message similar to

` `

    us428control: cannot open hwdep hw:0

This is perfectly fine if you have another card which is loaded before
the US-224: us428control probes all cards beginning from the first one
until it finds a Tascam card. If you want to get rid of this message you
can explicitly tell us428control to probe just a specific device by
using the `-c` switch.

### Testing the card

To check whether the card is functional or not, run the following
command, making sure that you are using the right value for the `-D`
option (`hw:0` is for the first soundcard, `hw:1` for the second one and
so on):

` `

    $ speaker-test -c2 -D hw:1 -twav

Make also sure that all the volume controls on the soundcard are not
muted :)

Minimizing latency in JACK
--------------------------

In order to squeeze out the best performance in terms of latency with
[JACK](/JACK "JACK") you will have to tweak a bit the configuration of
your US-224. The first step is to load the kernel module with the option
`nrpacks` set to `1`:

` `

    $ modprobe snd-usb-usx2y nrpacks=1

If you don't want to specify this parameter each time you load the
module (and, most importantly, if you want this option to be picked up
by your distribution's scripts automatically) you will have to modify a
file, called `/etc/modules.conf`, by adding the following line
somewhere:

` `

    options snd-usb-usx2y nrpacks=1

  --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
  **Caveat:**some distributions use the file `/etc/conf.modules` in place of `/etc/modules.conf`, and some other distributions (e.g., Gentoo) use the more flexible approach of re-building `/etc/modules.conf` at each system startup from a group of files in the `/etc/modules.d/` directory. Please consult your distribution's documentation for details regarding the management of `/etc/modules.conf`.
  --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

What does the `nrpacks=1` option do? Basically it is a USB setting that
enables lower latency transmission over the bus. This settings is
detected by JACK, which features an experimental **rawusb** driver
capable of exploiting this low latency route over the USB bus. Keep in
mind that this driver is still experimental and may not work for you,
but it is not dangerous to try it.

To enable the rawusb backend in JACK you have to start it specifying the
Alsa sub-device number 2. For instance:

` `

    $ jackd -dalsa -dhw:1,2 <other JACK parameters follow>

This means that we are using jackd with the Alsa backend on the second
card (numbered 1 because the first card is given number 0) and
sub-device number 2. If you did not load snd-usb-usxy with the
`nrpacks=1` option, sub-device number 2 will not be available and JACK
will exit with an error. If you are using
[qjackctl](?title=Qjackctl&action=edit&redlink=1 "Qjackctl (page does not exist)")
to start JACK, you can confirm that the `nrpacks=1` setting has actually
been used when loading the module by checking for the existence of the
'US-X2Y hwdep Audio' device when pressing the '\>' button in the 'Setup'
window of qjackctl:

[File:Qjackctl
rawusb.png](/File:Qjackctl_rawusb.png "File:Qjackctl rawusb.png")

\

That said, you can reach the physical limits of low latency over USB
also by using the standard JACK driver in conjunction with a [realtime
kernel](?title=Realtime_kernel&action=edit&redlink=1 "Realtime kernel (page does not exist)")
and the [rtirq](/Rtirq "Rtirq") script by Rui Nuno Capela. According to
my personal experience, the US-224 works better with low values for the
period length (`-p` parameter in JACK) and higher values for the number
of periods (`-n` parameter in JACK), which somehow contradicts what is
written in JACK's man pages. For instance with `-p128 -n2` the sound
comes out rather choppy, while with `-p64 -n4` the sound has no
distortions whatsoever. `-p64 -n4` corresponds to a latency of 5.8ms,
which, to my knowledge, is close to the best you can theoretically
achieve over USB.

Using the control surface in Ardour
-----------------------------------

To use the control surface of your US-224 in [Ardour](/Ardour "Ardour")
you will need to:

-   establish the proper connections between Ardour and the card using
    [JACK](/JACK "JACK"),
-   enable control surface support in Ardour.

To achieve the first goal we are going to assume that
[qjackctl](?title=Qjackctl&action=edit&redlink=1 "Qjackctl (page does not exist)")
is correctly installed on your system and that you are able to use it to
start JACK.

Once JACK has been started with qjackctl and Ardour is running, click on
the 'Connect' button on the main window of qjackctl, then select the
'MIDI' tab in the window that just popped up. You have to establish the
following connections using drag&drop between the two panes:

[File:Qjackctl tascam control
surface.png](/File:Qjackctl_tascam_control_surface.png "File:Qjackctl tascam control surface.png")

Here we are setting things up so that control events generated on the
card will be reported to Ardour (so that, for instance, when you press
the 'Play' button on the card Ardour will start playing), and conversely
Ardour will report back to the card about control events generated
inside Ardour itself (so that, for instance, if you press the 'Record'
button in Ardour the card's 'Record' led will be powered on too). You
can use qjackctl's patchbay functionality to store and recall JACK's
connections in a file to avoid manually establishing them each time.

The second step is to enable control surface support in Ardour. To
achieve this you have to check the following options under the 'Options'
menu in Ardour's main window:

-   Control Surface -\> Generic MIDI
-   Control Surface -\> Controls -\> Feedback
-   Send MTC
-   Send MMC
-   Use MMC

Additionally, you have to open the 'Options -\> Option Editor' window,
click on the 'MIDI' tab and make sure that all the available options for
the control port are activated:

[File:Ardour control
options.png](/File:Ardour_control_options.png "File:Ardour control options.png")

\
 At this point you should be able to use your US-224 to pilot Ardour.
You can, for instance, play or start recording by pressing the card's
button, as well as use the 'Locate' buttons and the jog wheel to change
position of the cursor in Ardour's tracks. Some buttons, like the 'Null'
and 'Solo' ones, are not yet supported as of March 2007
([us428control](?title=Us428control&action=edit&redlink=1 "Us428control (page does not exist)")
version 0.4.4). Support for these buttons is present in the upcoming
versions (which will be included as usual in the
[alsa-tools](/Alsa-tools "Alsa-tools") package).

Troubleshooting
---------------

**Q: The 'power' and 'USB' leds are turned on, the card is detected by
the Alsa subsystem, volumes are unmuted but I can't hear any sound.**

A: Probably you forgot to run the `us428control` utility, which
activates the card's knobs, faders and switches. Run it in a console as
root (possibly appending the `&` character to avoid killing it when you
close the console):

` `

    $ us428control &

**Q: All volumes are unmuted and us428control is running, but I can't
hear any sound from the mic/guitar I've plugged in the card.**

A: Make sure that you pressed the 'Input monitor' button and that the
corresponding led is on. Input volumes can be adjusted using the first
two faders.

**Q: The card seems to hang at random times, and I get messages like**

` `

    ep=8 stalled with status=-18

**or**

` `

    Sequence Error!(hcd_frame=5170779 ep=8in;wait=5170776,frame=5170777).

**in the kernel logs.**

A: Most likely you are running with some sort of power management
activated. In particular this card seems very sensitive to the changes
of CPU frequency. On my laptop, for instance, every time the CPU scales
frequency the card hangs for a while. My suggestion is to disable CPU
scaling altogether when you are using the card. On a modern linux
distribution you can fix the CPU frequency to the highest value
available with the following command:

` `

    $ echo "performance" > /sys/devices/system/cpu/cpu0/cpufreq/scaling_governor

You may want to experiment a bit and read about CPU frequency scaling. A
good resource can be found
[here](http://www.thinkwiki.org/wiki/How_to_make_use_of_Dynamic_Frequency_Scaling).

**Q: The card is connected, the power led is on and the firmware has
been successfully loaded, but `us428control` / `usx2yloader` fails with
an error message similar to**

` `

    no US-X2Y-compatible cards found

A: Check that `us428control` / `usx2yloader` is not already running.

See also
--------

-   The [usb-usx2y](/Usb-usx2y "Usb-usx2y") module page
-   The [usb-audio](/Usb-audio "Usb-audio") module page has some more
    information about settings for USB devices
-   [Vendor page](http://www.tascam.com/Products/US-224.html)

Retrieved from
"[http://alsa.opensrc.org/Tascam\_US-224](http://alsa.opensrc.org/Tascam_US-224)"

[Category](/Special:Categories "Special:Categories"): [Sound
cards](/Category:Sound_cards "Category:Sound cards")

