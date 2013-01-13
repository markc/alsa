Plugin Documentation
====================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Contents
--------

-   [1 Official Documentation](#Official_Documentation)
-   [2 Plugin Basics](#Plugin_Basics)
-   [3 Signal Path Illustration](#Signal_Path_Illustration)
-   [4 Example .asoundrc
    Configuration](#Example_.asoundrc_Configuration)
-   [5 See also](#See_also)

Official Documentation
----------------------

The official documentation for plugins is here:
[http://www.alsa-project.org/alsa-doc/alsa-lib/pcm\_plugins.html](http://www.alsa-project.org/alsa-doc/alsa-lib/pcm_plugins.html)

You might also find other useful information here, though much of it is
quite technical:
[http://www.alsa-project.org/alsa-doc/alsa-lib/pages.html](http://www.alsa-project.org/alsa-doc/alsa-lib/pages.html)

Plugin Basics
-------------

Plugins are used to create virtual devices that can be used like normal
hardware devices but cause extra processing of the sound stream to take
place. Virtual devices are defined in either the
[.asoundrc](/.asoundrc ".asoundrc") file in your home directory or the
/etc/asound.conf file for machine-wide settings. This is the most basic
skeleton of a virtual device definition you might seen in a .asoundrc
file:

` `

    pcm.SOMENAME {
        type PLUGINTYPE
        slave {
            pcm SLAVENAME
        }
    }

This creates a new virtual device with name SOMENAME of type PLUGINTYPE
that pipes its output to some other virtual or hardware device
SLAVENAME.

SOMENAME can be any simple name. It's the name you'll use to refer to
this device in the future. There are several virtual device names that
are predefined, such as default and dmix.

PLUGINTYPE is one of the names listed in the official documentation
above. Examples are dmix (a plugin type as well as a predefined virtual
device), jack, and linear.

SLAVENAME is the name of another virtual device or a string describing a
hardware device. To specify the first device of the first card use
"hw:0,0" (with the quotes).

Signal Path Illustration
------------------------

Here is an illustration to put the "SLAVE" and the "PLUGIN/VIRTUAL
DEVICE" into context:

` `

    input signal (audio program)-->  SOMENAME (plugin/virtual device)--> SLAVENAME (slave device)

You can see that you can chain plugins this way by having the SLAVE of a
VIRTUAL DEVICE be the input signal to another VIRTUAL DEVICE. This
process continues until finally the SLAVE of the last plugin is a
hardware device and not a virtual device.

Example .asoundrc Configuration
-------------------------------

To create an automatic rate-conversion virtual device (using the "plug"
plugin that is designed for that purpose) that pipes to the default
device we would write

` `

    pcm.myplugdev {
        type plug
        slave { 
            pcm default 
            rate 44100
        }
    }

We can now specify myplugdev to any (properly written) program that asks
for an alsa device and any sound that the program outputs will be
converted to 44100 Hz before being played. For example, we can run
"aplay -D myplugdev foobar.wav".

` `

    aplay--> myplugdev (plugin named "plug" converts rate) --> default --> hw:0,0

There might be problems with some programs though. Some applications
always try to open a control device with the same name as the pcm device
they are given, so you may also need to create a dummy control device
with the same name:

` `

    ctl.myplugdev {
        type hw
        card 0  # This works if you have one sound card
    }

That was pretty simple. Other plugins will have more parameters and
options. For more info on the syntax of the configuration file, see:
[http://www.alsa-project.org/alsa-doc/alsa-lib/conf.html](http://www.alsa-project.org/alsa-doc/alsa-lib/conf.html)

*Feel free to append any additional plugin related tips or
documentation...*

See also
--------

-   [Asoundrc.txt](/Asoundrc.txt "Asoundrc.txt")
-   [The\_.asoundrc\_file](/The_.asoundrc_file "The .asoundrc file")
-   [.asoundrc](/.asoundrc ".asoundrc")

Retrieved from
"[http://alsa.opensrc.org/Plugin\_Documentation](http://alsa.opensrc.org/Plugin_Documentation)"

[Category](/Special:Categories "Special:Categories"):
[Documentation](/Category:Documentation "Category:Documentation")

