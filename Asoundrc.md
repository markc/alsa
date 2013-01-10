.asoundrc
=========

### From the ALSA wiki

(Redirected from [Asoundrc](?title=Asoundrc&redirect=no "Asoundrc"))

Jump to: [navigation](#mw-head), [search](#p-search)

Contents
--------

-   [1 Warning](#Warning)
-   [2 What is a .asoundrc file? Why might I want
    one?](#What_is_a_.asoundrc_file.3F_Why_might_I_want_one.3F)
-   [3 A brief example.](#A_brief_example.)
-   [4 Where does .asoundrc live?](#Where_does_.asoundrc_live.3F)
-   [5 Changing things](#Changing_things)
-   [6 Default PCM device](#Default_PCM_device)
-   [7 The naming of PCM devices](#The_naming_of_PCM_devices)
-   [8 Plugins](#Plugins)
-   [9 Splitting front and rear
    outputs](#Splitting_front_and_rear_outputs)
-   [10 Joining devices to make
    multichannel](#Joining_devices_to_make_multichannel)
-   [11 Converting Sample Rates On
    Input](#Converting_Sample_Rates_On_Input)
-   [12 Dupe output to multiple cards](#Dupe_output_to_multiple_cards)
-   [13 Downmix stereo to mono](#Downmix_stereo_to_mono)
-   [14 Simple script to create an .asoundrc
    file](#Simple_script_to_create_an_.asoundrc_file)
-   [15 Other documentation of the .asoundrc
    file](#Other_documentation_of_the_.asoundrc_file)

Warning
-------

**Neither .asoundrc or /etc/asound.conf is normally required**. You
should be able to play and record sound without either (assuming your
mic and speakers are hooked up properly). If your system won't work
without one, and you are running the most current version of ALSA, you
probably should file a bug report.

What is a .asoundrc file? Why might I want one?
-----------------------------------------------

The .asoundrc file (in your home directory) and /etc/asound.conf (for
system-wide settings) are the configuration files for ALSA drivers.
Neither file is required for ALSA to work properly. Most applications
will work without them. The main use of these two configuration files is
to add functionality such as routing and sample-rate conversion. It
allows you to create "virtual devices" that pre or post-process audio
streams. Any properly written ALSA program can use these virtual devices
as though they were normal devices.

Before ALSA 1.0.9 you often needed one to make things work at all, and
before ALSA 1.0.11 you generally needed one if you wanted to have more
than one ALSA application output sound at the same time via the
DmixPlugin, but current ALSA versions shouldn't need one.

There are several uses for a .asoundrc. One is to create a personalized
configuration for a soundcard. This is useful if you have a 32-channel
soundcard and want to reserve 5 channels permanently for recording the
drums. For example, you could create a new PCM called "drumrec" that is
always mapped to the same five inputs. The .asoundrc file is quite
complicated. You may find it simpler to use the dmix plugin. Also see
the page [Dmix](/Dmix "Dmix") Plugin.

Lastly similar .asoundrc files are used internally by ALSA to "map"
standard things, for example, to connect "default" to "plughw:0" (this
too could be overridden). The configuration is in the file
/usr/share/alsa/alsa.conf

If you're happy with how your card is working, there's no need to use an
.asoundrc. There is also not much use in taking an .asoundrc for a
10-channel soundcard and hoping to get more out of a 2-channel (stereo)
soundcard. But if you want or have to customize the behaviour of a
soundcard to be different from the standard setting, an .asoundrc is
essential.

In the discussion that follows, remember that anything mentioned for the
.asoundrc file applies equally to /etc/asound.conf except in the latter
case the virtual devices you define can be used by all users on a
system.

A brief example.
----------------

Put the following in a file in your home directory in a file named
.asoundrc:

` `

    pcm.card0 {
        type hw
        card 0
    }
    ctl.card0 {
        type hw
        card 0
    }

You should replace the name of the card (card0) with something useful,
e.g. the one you are using in your /etc/modules.conf file (e.g. cmipci).

This example creates a virtual device named card0 (or whatever you
replaced that with) that just connects directly to your hardware's PCM
output channels. It also creates a control device with the same name.
Neither of these virtual devices actually does anything interesting --
they just act as aliases for the hardware devices.

Where does .asoundrc live?
--------------------------

The .asoundrc file is typically installed in a user's home directory
(\$HOME/.asoundrc) and is called from /usr/share/alsa/alsa.conf. It is
also possible to install a system-wide configuration file as
/etc/asound.conf. When an ALSA application starts both configuration
files are read but the settings in the .asoundrc file override the
settings in the /etc/asound.conf settings.

Changing things
---------------

Most programs require a restart to reread .asoundrc or asound.conf! This
includes desktop environment audio daemons, such as
[PulseAudio](http://www.pulseaudio.org/). For most changes to .asoundrc
you will need to restart the sound server (ie. sudo
/etc/init.d/alsa-utils restart) for the changes to take effect.

\

Default PCM device
------------------

Using ` aplay -L ` you can get a List of existing PCM output devices. If
you want the default to be, for example, a USB Device instead of the
onboard sound, you can place a pcm.!default line in the .asoundrc. Say
aplay -L lists something like ` `

     front:CARD=External,DEV=0
       SB Live! 24-bit External, USB Audio
       Front speakers

you can put the following line in your .asoundrc

` `

    pcm.!default front:External

As a result, most if not all applications will now use this device for
output unless specified otherwise. The same applies for self-defined
devices, as shown below.

The naming of PCM devices
-------------------------

A typical asoundrc starts with a "PCM hw type". This gives an ALSA
application the ability to start using a special soundcard (plugin or
slave) by a given name.

Without this, the soundcard(s) must be accessed with names like "hw:0,0"
or "default". For example:

` `

    ecasound -i test.wav -o alsa,hw:0,0

or with aplay

` `

    aplay -D hw:0,0 test.wav

The numbers after hw: stand for the sound card number and the device
number. A third number can be added (hw:0,0,0) for the sub-device
number, but it defaults to the next sub-device avaliable. The numbers
start from zero, so, for example, to access the first device on the
second sound card, you would use hw:1,0.

The keyword "default" will access the default subdevice on the default
soundcard, which will probably be hw:0,0 for a typical single Sound
Blaster sound card. Now with the "PCM hw type" you are able to define
aliases for your devices. The syntax for this definition is:

` `

    pcm.NAME {
        type hw # Kernel PCM
        card INT/STR # Card name or number
        [device] INT # Device number (default 0)
        [subdevice] INT # Subdevice number, -1 first available (default -1)
        mmap_emulation BOOL # enable mmap emulation for ro/wo devices
    }

Here is another example which gives the first soundcard an alias:

` `

    pcm.ens1371 {
        type hw
        card 0
        device 0
    }

Now you can access this card by the alias "ens1371".

` `

    aplay -D ens1371 test.wav

This definition is helpful if you want to apply any further plugins or
slaves in .asoundrc.

Plugins
-------

What are plugins? A plugin (or plug-in) is a computer program that can,
or must, interact with another program to provide a certain, usually
very specific, function. Typical examples are plugins to display
specific graphic formats (e.g., SVG if the browser doesn't support this
format natively), to play multimedia files, to encrypt/decrypt email
(e.g., PGP), or to filter images in graphic programs. The main program
(a web browser or an email client, for example) provides a way for
plugins to register themselves with the program, and a protocol by which
data is exchanged with plugins. See
[http://www.alsa-project.org/alsa-doc/alsa-lib/pcm\_plugins.html](http://www.alsa-project.org/alsa-doc/alsa-lib/pcm_plugins.html)
for the list of all plugins.

Now define a slave for this plugin. A very simple slave could be defined
as follows:

*What is a `slave` in the first place? What does it do, what does it
mean, what for do I need it? Can **please'*****add some more light on
this?** The slave is the device that is controlled by the plugin, and
recieves the plugin audio output in the case of playback, or provides
input for recording.

` `

    pcm_slave.sltest {
        pcm ens1371
    }

This defines a slave without any parameters. It's nothing more than
another alias for your sound device. The slightly more complicated thing
to understand is that parameters for 'pcm types' must be defined in the
slave-definition-block. Let's setup a rate-converter which shows this
behaviour.

` `

    pcm_slave.sl2 {
        pcm ens1371
        rate 44100
    }

    pcm.rate_convert {
        type rate
        slave sl2
    }

Now you can use this newly created (virtual) device by:

` `

    aplay -D rate_convert test.wav

This automatically converts your samples to a 44.1kHz sample rate while
playing. It's not very useful because most players, and ALSA, convert
samples to the correct sample-rate that is supported by your sound card
but you can use it for a conversion to a lower static sample-rate, for
example. A more complex tool for sample conversions is the PCM type
"plug". The syntax is:

` `

    type plug # Format adjusted PCM
    slave STR # Slave name (see pcm_slave)
    # or
    slave { # Slave definition
        pcm STR # Slave PCM name
    # or
        pcm { } # Slave PCM definition
        [format STR] # Slave format (default nearest) or "unchanged"
        [channels INT] # Slave channels (default nearest) or "unchanged"
        [rate INT] # Slave rate (default nearest) or "unchanged"
    }
    route_policy STR # route policy for automatic ttable generation
    # STR can be 'default', 'average', 'copy', 'duplicate'
    # average: result is average of input channels
    # copy: only first channels are copied to destination
    # duplicate: duplicate first set of channels
    # default: copy policy, except for mono capture - sum
    ttable {
        # Transfer table (bidimensional compound of
        # cchannels * schannels numbers)
        CCHANNEL {
            SCHANNEL REAL # route value (0, 1)
        }
    }

We can use it as follows:

` `

    pcm_slave.sl3 {
        pcm ens1371
        format S16_LE
        channels 1
        rate 16000
    }
    pcm.complex_convert {
        type plug
        slave sl3
    }

By calling it with:

` `

    aplay -vD complex_convert test.wav

you can convert the samples during playing to the sample format:
S16\_LE, one channel and a sample-rate of 16 kHz. If you use aplay with
the verbose option -v you will see the settings from the original file.
For example,

` `

    aplay -v test.wav

will show the original settings of the sound file test.wav. If you add
the definition "route\_policy average" to the plug definition, you will
make your output channel be the (arithmetic) average of your input
channels.

Splitting front and rear outputs
--------------------------------

I had a lot of trouble first figuring out how I could split front and
rear channels into two devices that could be used independently. The
following .asoundrc file is what I came up with. It can be used with
'mplayer', for example, as follows:

` `

    mplayer -ao alsa1x:frontx file1.avi
    mplayer -ao alsa1x:rearx file2.mp3

Enjoy...

` `

    pcm.dshare {
        type dmix
        ipc_key 2048
        slave {
            pcm "hw:0"
            rate 44100
            period_time 0
            period_size 1024
            buffer_size 8192
            channels 4
        }
        bindings {
            0 0
            1 1
            2 2
            3 3
        }
    }
    pcm.frontx {
        type plug
        slave {
            pcm "dshare"
            channels 4
        }
        ttable.0.0 1
        ttable.1.1 1
    }
    pcm.rearx {
        type plug
        slave {
            pcm "dshare"
            channels 4
        }
        ttable.0.2 1
        ttable.1.3 1
    }

Note, for ttable you might use fractions but then you cannot use
LC\_NUMERIC locales that use characters other than '.' as decimal
separator. Actually this is a bug and has already been fixed in versions
higher than 1.0.8.

Joining devices to make multichannel
------------------------------------

If your card has a number of stereo sub-devices that operate
synchronously, you can join them into one virtual multichannel device.

See the documentation for the multi plugin at
[http://www.alsa-project.org/alsa-doc/alsa-lib/pcm\_plugins.html](http://www.alsa-project.org/alsa-doc/alsa-lib/pcm_plugins.html)

The following joins two adjacent sub-devices into a 4 channel device.
There are 3 optional parameters [card,device, first\_subdevice]. It is
basically a nested set of plugins: {route {multi {hw0 hw1}}

\
 Eg. ttable4:1,0,2 will join sub-devices 2 and 3 of device 0 of card 1.
You can use this device with JACK.

` `

    pcm.ttable4 {
        @args [ CARD DEV SUBDEV ]
        @args.CARD {
            type string
            default {
                @func getenv
                vars [
                    ALSA_PCM_CARD
                    ALSA_CARD
                ]
                default {
                    @func refer
                    name defaults.pcm.card
                }
            }
        }
        @args.DEV {
            type integer
            default {
                @func igetenv
                vars [
                    ALSA_PCM_DEVICE
                ]
                default {
                    @func refer
                    name defaults.pcm.device
                }
            }
        }
        @args.SUBDEV {
            type integer
            default 0
        }
        type route;
        hint {
            show {
                @func refer
                name defaults.namehint.basic
            }
            description "4 channel multi route"
        }
        slave.pcm {
            type multi;
            slaves.a.pcm {
                type hw
                card $CARD
                device $DEV
                subdevice $SUBDEV
            }
            slaves.a.channels 2;
            slaves.b.pcm {
                type hw
                card $CARD
                device $DEV
                subdevice { @func iadd integers [ $SUBDEV 1 ] }
            }
            slaves.b.channels 2;
            bindings.0.slave a;
            bindings.0.channel 0;
            bindings.1.slave a;
            bindings.1.channel 1;
            bindings.2.slave b;
            bindings.2.channel 0;
            bindings.3.slave b;
            bindings.3.channel 1;
        }
        ttable.0.0 1;
        ttable.1.1 1;
        ttable.2.2 1;
        ttable.3.3 1;
    }
    # sometimes apps need matching ctl device
    ctl.ttable4 {
        @args [ CARD DEV SUBDEV ]
        @args.CARD {
            type string
            default {
                @func getenv
                vars [
                    ALSA_PCM_CARD
                    ALSA_CARD
                ]
                default {
                    @func refer
                    name defaults.pcm.card
                }
            }
        }
        @args.DEV {
            type integer
            default {
                @func igetenv
                vars [
                    ALSA_PCM_DEVICE
                ]
                default {
                    @func refer
                    name defaults.pcm.device
                }
            }
        }
        @args.SUBDEV {
            type integer
            default 0
        }
        type hw;
        card $CARD;
    }

Converting Sample Rates On Input
--------------------------------

` `

    pcm.rate_convert {
        type plug
        slave {
            pcm "hw:0,0"
            rate 48000
        }
    }

This will take an input of any rate and convert it to 48000 hz, change
to suit your needs.

Dupe output to multiple cards
-----------------------------

In this example an intel8x0 (ICH6 @ hw:0) and an Aureon 5.1 USB card
(Audio @ hw:1) are used. The default device is a stereo device, the
audio stream is duped to both cards. Front left/right is copied to rear
left/right, respectively, and center and sub-woofer are mixed 50%/50%
from front left/right. Dmix is enabled on both cards.

` `

    pcm.!default plug:both

    ctl.!default {
      type hw
      card ICH6
    }

    pcm.both {
      type route;
      slave.pcm {
          type multi;
          slaves.a.pcm "intel8x0";
          slaves.b.pcm "aureon";
          slaves.a.channels 2;
          slaves.b.channels 6;
          bindings.0.slave a;
          bindings.0.channel 0;
          bindings.1.slave a;
          bindings.1.channel 1;

          bindings.2.slave b;
          bindings.2.channel 0;
          bindings.3.slave b;
          bindings.3.channel 1;
          bindings.4.slave b;
          bindings.4.channel 2;
          bindings.5.slave b;
          bindings.5.channel 3;
          bindings.6.slave b;
          bindings.6.channel 4;
          bindings.7.slave b;
          bindings.7.channel 5;
      }

      ttable.0.0 1;
      ttable.1.1 1;

      ttable.0.2 1; # front left
      ttable.1.3 1; # front right
      ttable.0.4 1; # copy front left to rear left
      ttable.1.5 1; # copy front left to rear left
      # mix front left/right to subwoofer and center
      ttable.0.6 0.5;
      ttable.1.6 0.5;
      ttable.0.7 0.5;
      ttable.1.7 0.5;
    }

    ctl.both {
      type hw;
      card ICH6;
    }

    pcm.aureon {
       type dmix
       ipc_key 1024
       slave {
           pcm "hw:1"
           period_time 0
           period_size 2048
    #        buffer_size 8192
           buffer_size 65536
           buffer_time 0
           periods 128
           rate 48000
           channels 6
        }
    # the channels of this card are mixed-up
        bindings {
           0 0
           1 1
           2 4
           3 5
           4 2
           5 3
        }
    }

    pcm.intel8x0 {
       type dmix
       ipc_key 2048
       slave {
           pcm "hw:0"
           period_time 0
           period_size 2048
    #        buffer_size 8192
           buffer_size 65536
           buffer_time 0
           periods 128
           rate 48000
           channels 2
        }
        bindings {
           0 0
           1 1
        }
    }

    ctl.aureon {
       type hw
       card "Audio"
    }

    ctl.intel8x0 {
       type hw
       card "ICH6"
    }

Downmix stereo to mono
----------------------

From
[http://superuser.com/questions/155522/force-downmix-to-mono-on-linux/155601](http://superuser.com/questions/155522/force-downmix-to-mono-on-linux/155601)

` `

    pcm.!default makemono

    pcm.makemono {
        type route
        slave.pcm "hw:0"
        ttable {
            0.0 1    # in-channel 0, out-channel 0, 100% volume
            1.0 1    # in-channel 1, out-channel 0, 100% volume
        }
    }

Simple script to create an .asoundrc file
-----------------------------------------

` `

    % cat /usr/bin/asoundrc
    #!/bin/bash
    # asoundrc v0.1.0 20090101 markc@renta.net GPLv3
    # asoundrc v0.2.0 20090320 quatro_por_quatro@yahoo.es GPLv3
    #
    # A simple script to create a particular default audio device regardless
    # of what cards are loaded or in what order. It could be used anytime or
    # placed in a ~/.bashrc script for a persistent setup every login.
    #
    # Usage: asoundrc [DEFAULT_CARD] > ~/.asoundrc

    # use the first parameter as the card name, or else
    # look for the sound card, discarding those that are only microphones
    # when there are multiple cards, use the first one
    if default_card="${1:-$(cat "$(for f in $(ls -1 /proc/asound/card[0-9]*/{midi,codec}* 2>/dev/null); do echo "${f%/*}"; done \
    | sed -e '\|^[\[:blank:]\]$|d' -e 'q')/id" 2>/dev/null)}"; then
       echo "Using sound card: ${default_card}" >&2 
       cat /proc/asound/card[0-9]*/id | \
       gawk --assign default_card="${default_card}" \
    '{print "pcm."$1" { type hw; card "$1"; }\nctl."$1" { type hw; card "$1"; }" }
    END {print "pcm.!default pcm."default_card"\nctl.!default ctl."default_card}'
    else
       echo "Warning: No sound cards found." >&2
    fi

Other documentation of the .asoundrc file
-----------------------------------------

For a detailed description of the syntax of the `.asoundrc` file, see
below and also check out the `asoundrc.txt` file in the [alsa-lib
package](/Alsa-lib "Alsa-lib"). [Joern
Nettingsmeier](/User:JoernNettingsmeier "User:JoernNettingsmeier")
posted an `.asoundrc` to the linux-audio-users mailing list to use [two
cards as one](/TwoCardsAsOne "TwoCardsAsOne"). If you are interested in
a more advanced `.asoundrc` example have a look at the [RME Hammerfall
.asoundrc](/RME_Hammerfall_.asoundrc "RME Hammerfall .asoundrc") file
created by [Jeremy
Hall](?title=User:JeremyHall&action=edit&redlink=1 "User:JeremyHall (page does not exist)"),
or [squisher's asoundrc](/SquisherAsoundRc "SquisherAsoundRc") (with one
card as two, skype upmixing, ekiga hacks and wine testing).

-   [http://www.alsa-project.org/alsa-doc/alsa-lib/conf.html](http://www.alsa-project.org/alsa-doc/alsa-lib/conf.html)
-   [http://www.alsa-project.org/alsa-doc/alsa-lib/confarg.html](http://www.alsa-project.org/alsa-doc/alsa-lib/confarg.html)
-   [http://www.alsa-project.org/alsa-doc/alsa-lib/pcm\_plugins.html](http://www.alsa-project.org/alsa-doc/alsa-lib/pcm_plugins.html)
-   [Asoundrc.txt](/Asoundrc.txt "Asoundrc.txt")
-   [The .asoundrc file](/The_.asoundrc_file "The .asoundrc file")
-   [Plugin Documentation](/Plugin_Documentation "Plugin Documentation")
-   [Official asoundrc
    documentation](http://www.alsa-project.org/alsa-doc/doc-php/asoundrc.php?company=Generic&card=Generic&chip=Generic&module=Generic)

Retrieved from
"[http://alsa.opensrc.org/.asoundrc](http://alsa.opensrc.org/.asoundrc)"

[Categories](/Special:Categories "Special:Categories"):
[Documentation](/Category:Documentation "Category:Documentation") |
[Configuration](/Category:Configuration "Category:Configuration")

