Dmix Kde - arts, ESD and SDL quick and dirty HOWTO
==================================================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

*The information on this page is out of date but still of some interest
when dealing with the subject matter.*

Contents
--------

-   [1 2004-09-02](#2004-09-02)
    -   [1.1 Other known problems](#Other_known_problems)
    -   [1.2 Additional comment by Alexander E.
        Patrakov](#Additional_comment_by_Alexander_E._Patrakov)
    -   [1.3 Additional comment by Manfred
        Vogelgesang](#Additional_comment_by_Manfred_Vogelgesang)
    -   [1.4 Additional comment by Stefan
        Briesenick](#Additional_comment_by_Stefan_Briesenick)

-   [2 Another example](#Another_example)
-   [3 Yet another example](#Yet_another_example)
-   [4 Another hint](#Another_hint)

2004-09-02
----------

The version of KDE available in Debian "Sid" Unstable includes artsd
1.3.0. It can be used with asound to produce sound even while other
applications are playing, using a configuration like the ones at the
bottom of this page.

-   **before you start** - read the
    [DmixPlugin](/DmixPlugin "DmixPlugin") page and be sure that your
    dmixing works properly. I mean try to play using alsaplayer for
    example, two songs in the same time. I read about `dmix`, and tried
    to apply it to KDE. It succeeded. This hack is quick and dirty, but
    works fine :)

-   **add this to `/etc/asound.conf`**

` `

    pcm.card0 {
        type hw
        card 0
    }
    pcm.!default {
        type plug
        slave.pcm "dmixer"
    }
    pcm.dmixer  {
        type dmix
        ipc_key 1025
        slave {
            pcm "hw:0,0"
            period_time 0
            period_size 4096
            buffer_size 16384 
            periods 128
            rate 44100
        }
        bindings {
            0 0
            1 1
        }
    }

-   **configure esound** - some important apps, such as `mozilla` uses
    `esound`(`esd`) (aoss doesn't work with mozilla). Make sure that
    your `esd` uses alsa, and add **`-d default`** option to
    `/etc/esd.conf` (`/etc/esound/esd.conf` on Debian sid).

` `

    [esd]
    auto_spawn=1
    spawn_options=-terminate -nobeeps -as 2 -d default  # <====
    spawn_wait_ms=100

If you notice that `esd` doesn't want to play through `default` device,
or if you launch `esd -d default`, it segfaults, it means that you have
`esound` \<= 0.2.32, which use obsolete alsa API. If it's true, install
more recent, or compile latest `esound` with
`esound-alsa-pcm-newapi.patch`
[http://cvs.pld-linux.org/SOURCES/esound-alsa-pcm-newapi.patch](http://cvs.pld-linux.org/SOURCES/esound-alsa-pcm-newapi.patch))

-   **configure `artsd`** - in kde control center, to use *Enlightement
    sound daemon*(also known as ESD). Native ALSA method doesn't work
    with `dmix`, at least in KDE 3.1.x and KDE 3.2.0. If you doesn't
    have such option in your control center, you have to recompile it
    with proper `./configure` options. And of course you should have
    `esd` installed in your system (very often package is called
    esound). Now sound in KDE is mixed with sound from alsa driven apps
    without need to use (almost always not working) artsdsp.
-   **SDL** - now time to change behaviour of apps which uses SDL to
    play sound. SDL tries to use ```` ```hw:0``` ````, and without
    intervention, it fails to open audio device. But SDL uses AUDIODEV
    environment variable, so it placed such file to `/etc/profile.d/`,
    example **dmix\_sdl.sh**:

\\

` export AUDIODEV=default`

... and problems disappeared? unfortunately not :[[. Some application
behaves strange when AUDIODEV is set. For example: `mozilla` crashed
when you touch the keyboard, and `scorched3d` runs few times slower.
Strange, but true. So if you notice such problem, you must manually set
AUDIODEV for your applications, instead of globally set it in
`/etc/profile.d/dmix_sdl.sh`

(Note: see comment below by Stefan Briesenick for a better solution to
this problem)

### Other known problems

-   `Arts` with `ESD` output sometimes doesn't want to start in KDE
    startup, and starts with `null` device. Reloading it solves the
    problem, but only once per session. (sometimes it works without
    problems).

-   Sometimes alsa driven apps (for example `aplay`) hangs while playing
    and blocks all sound. Killing such blocking app brings lot of noise
    (all blocked sounds played together)

### Additional comment by Alexander E. Patrakov

The proposed wrapper-based solution of the artsd problem does not work
for me with KDE 3.2.0 and FM801-based soundcard. Artsd plays for several
seconds and then hangs. I managed to solve the problem by just selecting
esd as the output device for artsd.

### Additional comment by Manfred Vogelgesang

Regarding the claim that the periodsize MUST be 4096 (or artsd would
reject it otherwise) I found out that it DOES work for my previous value
of 1024! This periodsize of 1024 in my .asoundrc works when artsd is
launched with "-S 1024", like for instance:

` `

    aoss /opt/kde3/bin/artsd -S 1024 -a toss -r 48000 &

Unfortunately, preloading "aoss" doesn't seem to work with
"artswrapper"; it appears that you must call "artsd" directly. Moreover,
mplayer complains about the period size when it is set at 4096, while it
works with 1024, for instance when calling it like:

` `

    mplayer -srate 48000 -ao alsa9:pcm.dmixer

This command worked for me, I really got mplayer to use alsa and allow
for mixing sounds (based upon the above .asoundrc and the already
mentioned periodsize of 1024 instead of 4096).

After trying this alsa/artsd mixing for some time now, I must conclude:
This "solution" doesn't appear to be stable! More often than not, artsd
shuts itself down after a more or less brief time! Furthermore, when
using this "solution" latency for applications run via artsdsp, e.g.
artsdsp -m quake2, increases to a degree that is no longer acceptable -
in games like quake2 the latency is especially annoying, while in my
experience it is no problem whatsoever, when using artsdsp -m quake2
exclusively, i.e. without mixing artsd with alsa! If someone has ideas
to improve the situation, feel free to comment...

### Additional comment by Stefan Briesenick

SDL works for me like a charm just with the following environment
variable:

` `

    SDL_AUDIODRIVER="alsa"

It seems to me, that SDL uses 'default' then as the AUDIODEV by default
(so you have to setup 'pcm.!default'), at least mixing is done properly
through dmix. Since you don't have to set the AUDIODEV variable, you
don't have the mentioned problems above with Mozilla & friends.

Another example
---------------

This page seems to be the only resource that describes dmix in
combination with arts and esound, so I will tell my experiences here. I
have a NForce2 board using the intel8x0 driver under Linux 2.6.5, KDE
3.2.1 and arts 1.2.2. My `/etc/asound.conf` file is the following:

` `

    pcm.ossmix {
        type dmix
        ipc_key 1027       # must be unique!
        slave {
            pcm "hw:0,0"   # you cannot use a "plug"
                           # device here, darn.
            period_time 0
        period_size 1024
        buffer_size 4096
            #format "S32_LE"
            #periods 128   # dito.
            rate 44100     # with rate 8000 you *will* 
                           # hear, if ossmix is used :)
        }
        bindings {
            0 0            # from 0 => to 0
            1 1            # from 1 => to 1
        }
    }
    pcm.!default {
        type plug
        slave.pcm "ossmix"
    }
    # mixer0 like above
    ctl.mixer0 {
        type hw
        card 0
    }

My `/etc/esd/esd.conf`:

` `

    [esd]
    auto_spawn=1
    spawn_options=-terminate -nobeeps -as 2 -d default
    spawn_wait_ms=100

Arts is configured to use ALSA and full duplex is disabled (with
enabling full duplex it complains that it cannot open the device for
recording). The sampling rate is set to 44100 Hz. I have experimented a
long time with the values of period\_size and buffer\_size. With the
"rate" entry was commented out, artsd output was snatchy at period\_size
4096 while esound ouput was ok, and at period\_size 1024 esound produced
unacceptable results while arts was fine. The rate entry fixed this, and
now I can use native ALSA, ALSA-OSS, Artsd and EsounD at the same time!

Yet another example
-------------------

Well, I've been stumbling around with ALSA, and since this wiki helped
me, I figured I'd take the time to help back. I'm running an ASUS
A7N266-VM motherboard with an nForce chipset -- not even an nForce2. I
just wanted KDE to be noise-enabled while I played games and such. Since
I'm running Debian unstable, at this date I've got artsd 1.3.0. Although
this version of artsd has an ALSA output selection, enabling it didn't
help. I'd still hear the test sound, but other sounds queued up with
"aplay KDE\_Notify.wav &" waited until artsd gave up the device. The
solution was to change the device name in my /etc/asound.conf and set
artsd to use that device in the Control Center. **Using "default" and
"dsp0" as the device name produced choppy or blocking sound!**

**Here's my current asound.conf:**

` `

    pcm.!default
    {
        type plug
        slave.pcm "nmixer"
    }
    pcm.nforce
    {
        type plug
        slave.pcm "nmixer"
    }
    pcm.dsp0
    {
        type plug
        slave.pcm "nmixer"
    }

    # A bit more control over the mixer
    pcm.nmixer
    {
        type dmix
        ipc_key 6789  # Any unique number
        slave {
            pcm "hw:0,0"
            period_time 0
            period_size 1024
            buffer_size 4096
            #periods 128
            #rate 44100
         }
        #bindings {
        #    0 0
        #    1 1
        #}
    }
    ctl.mixer0
    {
        type hw
        card 0
    }

Another hint
------------

Well, I am using KDE 3.5.2, arts 1.5.2. I have a i810 sound card. After
much tinkering I found this worked for me: In KDE Sound Server
Configuration, use ALSA as audio device. Then override device location
to 'plug:dmix'. Also the tip on setting the rate was very useful to get
proper playback. (Check the Use custom sampling rate option and set it
the value to 44100 Hz).

Retrieved from
"[http://alsa.opensrc.org/Dmix\_Kde\_-\_arts,\_ESD\_and\_SDL\_quick\_and\_dirty\_HOWTO](http://alsa.opensrc.org/Dmix_Kde_-_arts,_ESD_and_SDL_quick_and_dirty_HOWTO)"

[Category](/Special:Categories "Special:Categories"):
[Howto](/Category:Howto "Category:Howto")

