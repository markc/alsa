Low-pass filter for subwoofer channel (HOWTO)
=============================================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

I have searched a long time for a solution to filter a single channel of
a 5.1 output stream with ALSA. I wanted the channel to which the
subwoofer is connected to be filtered by a low-pass filter. Without such
a filter the sound from my subwoofer sounds a bit sludgy.

  ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
  **Important:**The solution I am going to present below will only work with an ALSA library with a version higher or equal to 1.0.14rc2 (released 2007-01-16), because there was a [bug with the 'policy none' behaviour](http://www.mail-archive.com/alsa-user@lists.sourceforge.net/msg18416.html) in previous versions.
  ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

There is a patch against the [Ubuntu feisty
package](http://packages.ubuntu.com/feisty/libs/libasound2) (see
[changelog](http://changelogs.ubuntu.com/changelogs/pool/main/a/alsa-lib/alsa-lib_1.0.13-1ubuntu5/changelog)
for version 1.0.13-1ubuntu2) so you can use that package and do not have
to upgrade to a 1.0.14 version if you are using Ubuntu feisty.

  ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
  **Important:**There is a problem which makes the solution presented here unusable with alsa-lib version 1.0.14rc4 up to 1.0.14a. Here is a [description of the problem](http://www.mail-archive.com/alsa-user%40lists.sourceforge.net/msg19863.html) and [ALSA bug report number 0003106](https://bugtrack.alsa-project.org/alsa-bug/view.php?id=3106). You can use alsa-lib version 1.0.15rc1, that contains a fix for this bug, or newer or you can use the older alsa-lib version 1.0.14rc3 or below.
  ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

I created a configuration that takes a stereo (two channel) stream and
mixes it up to a 5.1 (six channel) stream, where the channel for the
subwoofer is low-pass filtered by a [ladspa
plugin](/Ladspa_(plugin) "Ladspa (plugin)").

Contents
--------

-   [1 ALSA configuration](#ALSA_configuration)
-   [2 Explanation](#Explanation)
-   [3 Required LADSPA packages](#Required_LADSPA_packages)
-   [4 Using dmix](#Using_dmix)
-   [5 Troubleshooting](#Troubleshooting)
-   [6 Questions?](#Questions.3F)

ALSA configuration
------------------

Here is the content of my file `/etc/asound.conf` (you can use
`~/.asoundrc` instead):

` `

    pcm.upmix_20to51 {
        type plug
        slave.pcm lowpass_21to21
        slave.channels 3
        ttable {
            0.0     1       # left channel
            1.1     1       # right channel
            0.2     0.5     # mix left and right ...
            1.2     0.5     # ... channel for subwoofer
        }
    }

    pcm.lowpass_21to21 {
        type ladspa
        slave.pcm upmix_21to51
        path "/usr/lib/ladspa"
        channels 3
        plugins {
            0 {
                id 1098 # Identity (Audio) (1098/identity_audio)
                policy duplicate
                input.bindings.0 "Input";
                output.bindings.0 "Output";
            }
            1 {
                id 1672 # 4 Pole Low-Pass Filter with Resonance (FCRCIA) (1672/lp4pole_fcrcia_oa)
                policy none
                input.bindings.2 "Input";
                output.bindings.2 "Output";
                input {
                    controls [ 300 2 ]
                }
            }
        }
    }

    pcm.upmix_21to51 {
        type plug
        slave.pcm surround51
        slave.channels 6
        ttable {
            0.0     1       # front left
            1.1     1       # front right
            0.2     1       # rear left
            1.3     1       # rear right
            0.4     0.5     # center
            1.4     0.5     # center
            2.5     1       # subwoofer
        }
    }

On some systems (e. g. [openSUSE
x86\_64](https://bugzilla.novell.com/show_bug.cgi?id=473741)) you have
to change the path for the LADSPA plugins (e. g. to
"/usr/lib64/ladspa").

Explanation
-----------

The PCM `upmix_20to51` takes the input stream and mixes the two stereo
channels together to a new third channel. The new channel is mixed by
taking 0.5 of the left and 0.5 of the right channel. This third channel
is the data for the subwoofer channel. These three channels are given to
the next PCM.

The PCM `lowpass_21to21` does the real filtering with the help of two
[LADSPA plugins](/Ladspa_(plugin) "Ladspa (plugin)"). The identity
plugin (id 1098) just copies all channels from the input to the output
without changes. The second plugin, the low-pass plugin (id 1672) takes
only the third channel, the subwoofer channel, and applies the low-pass
filter to it. The first control value is the cutoff frequency in Hz and
the second is the resonance (0.0 to 4.0). I have tried different values
but these sound best with my subwoofer. The unchanged channels 0 and 1
together with the filtered channel 2 are given to the next PCM.

The PCM `upmix_21to51` takes the three input channels and distributes
them to channels of the slave PCM `surround51`. Maybe the channels of
the slave PCM are connected to different speakers on other systems. I
found these numbers by trial and error.

If you now start `alsaplayer -d upmix_20to51 [mysong]` or specify
`upmix_20to51` as default ALSA plugin for stereo output in your
favourite audio player you should hear the upmixed, filtered sound from
your speakers.

Required LADSPA packages
------------------------

Yesterday I have got a mail from an ALSA user who had a problem getting
this setup to work. His problem was that the LADSPA plugins were not
found. Of course you have to install the LADSPA packages which contain
these plugins. For the low-pass filter you have to install the [BLOP
plugin set](http://blop.sourceforge.net/index.html) (Debian package:
[blop](http://packages.debian.org/cgi-bin/search_packages.pl?keywords=blop&searchon=names&subword=1&version=all&release=all);
Gentoo package: [blop](http://packages.gentoo.org/search/?sstring=blop);
Ubuntu:
[blop](http://packages.ubuntu.com/cgi-bin/search_packages.pl?keywords=blop&searchon=names&subword=1&version=all&release=all))
and for the identity plugin you need the [Computer Music Toolkit
(CMT)](http://www.ladspa.org/cmt/) (Debian:
[cmt](http://packages.debian.org/cgi-bin/search_packages.pl?keywords=cmt&searchon=names&version=all&release=all);
Gentoo: [ladspa-cmt](http://packages.gentoo.org/search/?sstring=cmt);
Ubuntu:
[cmt](http://packages.ubuntu.com/cgi-bin/search_packages.pl?keywords=cmt&searchon=names&version=all&release=all);
Slackware 10.1:
[cmt](http://www.linuxpackages.net/pkg_details.php?id=8931)).

Using dmix
----------

To get [dmix](/Dmix "Dmix") working with this configuration I added the
following to my configuration file:

` `

    pcm.dmixer {
        type dmix
        ipc_key 1024
        slave {
            pcm "hw:0,0"
            period_time 0
            period_size 1024
            buffer_size 4096
            rate 44100
            channels 6
        }
        bindings {
            0 0
            1 1
            2 2
            3 3
            4 4
            5 5
        }
    }

Then I changed the `slave.pcm` in `upmix_21to51` to `dmixer`.

Troubleshooting
---------------

With certain ALSA versions, (especially, at as it seems, at least
1.0.17a and 1.0.18rc3) the **plug** plugin does not seem to perform
automatic format and channel conversion. (You will get an error like
"pcm\_params.c:170: snd1\_pcm\_hw\_param\_get\_min: Assertion
\`!snd\_interval\_empty(i)' failed") Thus, you will have to define more
interfaces to do so manually, for example: ` `

    pcm.upmix_20to51 {
        type route # as automatic routing does not work, use type route
        slave.pcm lowpass_21to21_plug # 'route' outputs integer data, but float data is needed for ladspa.
                                      # the additional plug will output float data
        slave.channels 3
        ttable {
            0.0     1       # left channel
            1.1     1       # right channel
            0.2     0.5     # mix left and right ...
            1.2     0.5     # ... channel for subwoofer
        }
    }

    pcm.lowpass_21to21_plug {
        type plug
        slave.pcm "lowpass_21to21" # now, relay further to ladspa
    }


    pcm.lowpass_21to21 {
        type ladspa
        slave.pcm lowpass_float # ladspa will also output float data, but hw or route devices will need integer data
        path "/usr/lib/ladspa"
        channels 3
        plugins {
                # [...] nothing important here
        }
    }

    pcm.lowpass_float {
        type lfloat # converts from float to integer data
        slave {
            pcm "upmix_21to51" # your slave device here
            format "S16_LE"    # the format ladspa uses
        }
    }

Questions?
----------

If you have something to annotate, have improvements or it does not work
for you, write on the discussion page or contact me.

--[BlazE](/User:BlazE "User:BlazE") 05:15, 3 February 2007 (EST)

Retrieved from
"[http://alsa.opensrc.org/Low-pass\_filter\_for\_subwoofer\_channel\_(HOWTO)](http://alsa.opensrc.org/Low-pass_filter_for_subwoofer_channel_(HOWTO))"

[Category](/Special:Categories "Special:Categories"):
[Howto](/Category:Howto "Category:Howto")

