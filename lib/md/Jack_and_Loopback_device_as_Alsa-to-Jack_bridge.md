Jack and Loopback device as Alsa-to-Jack bridge
===============================================

##### By Thorgal - May 3rd 2010

Contents
--------

-   [1 Introduction](#introduction)

-   [2 The ALSA Loopback 'Sound card'](#The_ALSA_Loopback_.27Sound_card.27)

    -   [2.1 Compiling snd-aloop if needed](#Compiling_snd-aloop_if_needed)
    -   [2.2 Understanding the ALSA Loopback sound card structure](#Understanding_the_ALSA_Loopback_sound_card_structure)

-   [3 Building an asoundrc file](#Building_an_asoundrc_file)

    -   [3.1 asoundrc definition](#asoundrc_definition)
    -   [3.2 testing our new default ALSA device](#testing_our_new_default_alsa_device)

-   [4 The Jack Bridge](#the_jack_bridge)

    -   [4.1 Creating permanent Jack clients using alsa_in and alsa_out](#Creating_permanent_Jack_clients_using_alsa_in_and_alsa_out)
    -   [4.2 Create scripts to automate bridge initialization via QjackCtl](#Create_scripts_to_automate_bridge_initialization_via_QjackCtl)

-   [5 Alternative Setup: hardware and software based solution](#Alternative_Setup:_hardware_and_software_based_solution)

    -   [5.1 Adding extra h/w inputs in asoundrc](#Adding_extra_h.2Fw_inputs_in_asoundrc)
    -   [5.2 Testing the new ALSA capture](#Testing_the_new_ALSA_capture)

-   [6 Measuring the latency introduced by the Loopback device](#Measuring_the_latency_introduced_by_the_Loopback_device)

    -   [6.1 Playback only](#Playback_only)
    -   [6.2 Capture and Playback](#Capture_and_Playback)
    -   [6.3 Final word](#final_word)

<h2 id="introduction">Introduction</h2>

Some people may use PCs where the [Jack Audio Connection
Kit](http://jackaudio.org) is running all the time. As [one of these
users myself](/User:Thorgal "User:Thorgal"), my DAW PC uses a very light
WM (fluxbox) without any of the audio layers provided by the more
feature rich WMs (like KDE or Gnome). I have jack started at login and
hopefully, it never goes down until the next PC shutdown. Since I do not
want any other audio layer such as Pulseaudio, etc, in between Jack and
ALSA in my case (but it could well be FFADO for firewire devices), this
has the slight disadvantage of making non jackified applications
unusable.

So how can one provide a permanent bridge between non jackified
applications and Jack\? Well, there are different ways. One can be
purely hardware: enable another soundcard (e.g the onboard sound chip)
and physically link it to your DAW sound-card if you are like me with a
dedicated audio h/w for DAW operations. Let this extra soundcard be the
default (ALSA index 0) so that apps like flashplayer, skype, etc, use it
by default. However, this may limit the number of h/w IOs of your DAW
soundcard for your pro work. I do not like this physical link because my
RME Multiface II has only 8 analog mono INs, while the onboard sound
chip (Intel HDA) has no digital output that I can link to the Multiface
digital input. I would be forced to patch two INs of the Multiface to
the stereo output of the onboard chip. It is too expensive to consider
in terms of physical IOs.

The alternative is a software solution or a mix h/w - s/w (as used in my
final setup). So, I was looking for a solution in the form of permanent
Jack clients, playback and capture ideally, or at least playback since I
can use the capture device of a second soundcard like the onboard chip
or anything else (I will clarify this further down but it is not
necessarily an average setup). In terms of software solutions, the ALSA
jack PCM plugin is in my opinion not ideal because the Jack client will
disappear as soon as the application stops outputting audio.
Furthermore, this PCM plugin has not been updated (except lately by
Torben Hohn but the patch is not widespread) and I found the plugin
quite buggy / unstable in many situations.

It is not until recently, as I was fiddling with the ALSA Loopback
device, that I saw a way to achieve what I needed.

The ALSA Loopback 'Sound card'
------------------------------

The ALSA Loopback sound card is a virtual soundcard that is created once
the ALSA kernel module `snd-aloop` is loaded. This virtual soundcard
device, as its name indicates, sends back the output signal of
applications using it back to itself, so one has a chance to e.g. record
this signal from the same device. Simply imagine that you have a
physical link between one OUT and one IN of the same device.

By default, the Loopback sound card consists of 2 devices, each composed
of 8 subdevices. Once the kernel module `snd-aloop` is loaded, you can
verify that the sound card has been created:

    ~$ aplay -l

    **** List of PLAYBACK Hardware Devices ****

    card 0: DSP [Hammerfall DSP], device 0: RME Hammerfall DSP + Multiface [RME Hammerfall DSP + Multiface]
     Subdevices: 0/1
     Subdevice #0: subdevice #0
    card 1: Loopback [Loopback], device 0: Loopback PCM [Loopback PCM]
     Subdevices: 7/8
     Subdevice #0: subdevice #0
     Subdevice #1: subdevice #1
     Subdevice #2: subdevice #2
     Subdevice #3: subdevice #3
     Subdevice #4: subdevice #4
     Subdevice #5: subdevice #5
     Subdevice #6: subdevice #6
     Subdevice #7: subdevice #7
    card 1: Loopback [Loopback], device 1: Loopback PCM [Loopback PCM]
     Subdevices: 8/8
     Subdevice #0: subdevice #0
     Subdevice #1: subdevice #1
     Subdevice #2: subdevice #2
     Subdevice #3: subdevice #3
     Subdevice #4: subdevice #4
     Subdevice #5: subdevice #5
     Subdevice #6: subdevice #6
     Subdevice #7: subdevice #7

Note that you can control the number of subdevices with the module
option `pcm_substreams` (8 by default). You can always set it to 2 only
if you wish at loading time. As an example, here is my ALSA module
config file (`/etc/modprobe.d/sound.conf` on my debian-based DAW)

    alias snd-card-0 snd-aloop
    alias snd-card-1 snd-hdsp
    alias snd-card-2 snd-hda-intel

    options snd-aloop index=0 pcm_substreams=2
    options snd-hdsp index=1
    options snd-hda-intel index=2

As you can see, I do fix indexes even though ALSA and Jack can work with
names only. It is motivated by the special position that is index 0, the
ALSA default device that flashplayer will try to use.

### Compiling `snd-aloop` if needed

Update: it may not be needed any longer as of kernel 2.6.38 ...

It may well be that the ALSA Loopback kernel module was not included in
your distribution's kernel package (it is the case in e.g. debian, as
far as I know). This is no bother as we can easily compile it. Note that
there is no way around since the loopback ALSA module is not part of the
kernel baseline in general. So unless your kernel packager had done the
following work, you will have to do it yourself ...

*Warning: I tried alsa-driver 1.0.21 against 2.6.33.5-rt22 and while it
compiled fine, it would not load at all, even when forced. So don't
waste your time with this version combo.*

Make sure you really don't have it installed. Better check that not :)

    sudo modinfo snd-aloop

If modinfo reports nada, time to check that you have installed the
kernel headers corresponding to your presently running kernel. I'll
leave this to you as this is very distro dependent. In debian based
distros, the package is called something like `linux-headers-xxx` and
must match the installed kernel (package `linux-image-xxx`).

Time to make a backup of the installed kernel modules. Example;

    cd
    mkdir backup  
    cd backup
    cp -a /lib/modules/`uname -r`/kernel/sound  .

Prerequisite: you of course need a compiler and other tools. In debian
based distros, you can check that you have a package called
`build-essential` installed:

    dpkg -l build-essential

If not, just get it:

    sudo apt-get install build-essential

Now grab the alsa-driver source code (same version as your installed
ALSA, in my case 1.0.23 which I will use in my description) from the
[The ALSA website](http://www.alsa-project.org), uncompress, untar it
and cd to the alsa-driver top dir. Here is a command summary ...

    cd
    mkdir source
    cd source
    wget ftp://ftp.alsa-project.org/pub/driver/alsa-driver-1.0.23.tar.bz2
    tar jxvf alsa-driver-1.0.23.tar.bz2
    cd alsa-driver-1.0.23

Now you have to configure the source package for compilation. To help
you, look at what ALSA modules are currently loaded:

    cat /proc/asound/modules

And check what card they correspond to by typing

    ./configure --help

You will see a big list of possible cards. Pick the ones you are
interested in. As an example, this is how I configured the alsa-driver
source on my DAW system:

    ./configure --with-cards=hdsp,loopback,hrtimer --with-oss=yes --with-sequencer=yes

and on my laptop:

    ./configure --with-cards=intel8x0,loopback,hrtimer --with-oss=yes --with-sequencer=yes

So, feel free to configure it the way you want it. Once you have
configured the ALSA driver source, you just go through the usual
sequence:

    make
    sudo make install

It will normally install all the compiled modules into the correct
location of your kernel installation. Now check that the kernel knows
about the loopback module:

    ~$ sudo modinfo snd-aloop
    filename:       /lib/modules/2.6.32/kernel/sound/drivers/snd-aloop.ko
    license:        GPL
    description:    A loopback soundcard
    author:         Jaroslav Kysela <perex@perex.cz>
    srcversion:     B85A5847D027749DCF96195
    depends:        snd-pcm,snd
    vermagic:       2.6.32 SMP preempt mod_unload modversions CORE2
    parm:           index:Index value for loopback soundcard. (array of int)
    parm:           id:ID string for loopback soundcard. (array of charp)
    parm:           enable:Enable this loopback soundcard. (array of bool)
    parm:           pcm_substreams:PCM substreams # (1-8) for loopback driver. (array of int)

Allrighty, time to load it. But before that, shut down all audio apps
(including firefox). Once done, do this:

    sudo alsa force-unload  
    sudo modprobe snd-whatever-module-you-need 
    sudo modprobe snd-aloop 

Now, see if it works:

    ~$ lsmod | grep aloop
    snd_aloop               4732  0
    snd_pcm                57065  6 snd_aloop,snd_hdsp
    snd                    40404  18 snd_aloop,snd_hdsp,snd_pcm,snd_hwdep,snd_rawmidi,snd_seq,snd_timer,snd_seq_device

If all was cool and dandy, just add `snd-aloop` in `/etc/modules`. (If
you wish, you can give the loopback soundcard another name than
"Loopback" in a modprobe option but I kept the default throughout the
entire HOWTO and there is no need to change it.)

In case anything went wrong and you wish to go back to your previous
ALSA installation, no problem:

    sudo rm /lib/modules/`uname -r`/kernel/sound
    sudo cp -a ~/backup/sound /lib/modules/`uname -r`/kernel/
    sudo alsa force-reload

### Understanding the ALSA Loopback sound card structure

Well, this is not too difficult to grasp. This virtual sound card
consists of 2 devices:

-   `hw:Loopback,0`
-   `hw:Loopback,1`

If an application outputs its audio to one of the subdevices e.g. say
`hw:Loopback,0,0` the audio will be available as input in the
corresponding subdevice `hw:Loopback,1,0` because the whole point for
this card is to send the signal back to itself.

So the generic principle is that an output signal to subdevice
`hw:Loopback,i,n` becomes an input signal from `hw:Loopback,j,n` with

    i = [0..1]
    j = ~i (meaning if i = 0, j = 1 and vice-versa)
    n = [0.. (s-1)] with s = number of subdevices (controlled by module option pcm_substreams)

Building an `asoundrc` file
---------------------------

The goal is to create a default ALSA plug device out of the Loopback
card. For a complete software solution, we need one PCM playback, so
ALSA apps can send audio to it, one PCM capture, so ALSA apps can get
audio from it, and combine these 2 PCMs into a nice full duplex "plug"
device.

Note that the underlying goal is this: I want the audio of my jack
system capture ports (from my RME card) to be available at the ALSA
capture device and vice-versa: hear from my jack system playback ports
what ALSA apps are playing back to the ALSA playback device. Tricky...

### asoundrc definition

The asoundrc below should work in most situations.

    # playback PCM device: using loopback subdevice 0,0
    pcm.amix {
      type dmix
      ipc_key 219345
      slave.pcm "hw:Loopback,0,0"
    }

    # capture PCM device: using loopback subdevice 0,1
    pcm.asnoop {
      type dsnoop
      ipc_key 219346
      slave.pcm "hw:Loopback,0,1"
    }

    # duplex device combining our PCM devices defined above
    pcm.aduplex {
      type asym
      playback.pcm "amix"
      capture.pcm "asnoop"
    }

    # ------------------------------------------------------
    # for jack alsa_in and alsa_out: looped-back signal at other ends
    pcm.ploop {
      type plug
      slave.pcm "hw:Loopback,1,1"
    }

    pcm.cloop {
      type dsnoop
      ipc_key 219348
      slave.pcm "hw:Loopback,1,0"
    }

    # ------------------------------------------------------
    # default device

    pcm.!default {
      type plug
      slave.pcm "aduplex"
    }

In summary:

     * ALSA playback = subdevice 0,0
     * ALSA capture  = subdevice 0,1 
     * Jack readable client (cloop) = subdevice 1,0
     * Jack writable client (ploop) = subdevice 1,1

This asoundrc is very generic and one can of course tailor it in terms
of sample rate, audio format, buffer size, etc. One can find the
relevant parameters in the [ALSA-lib
documentation](http://www.alsa-project.org/alsa-doc/alsa-lib/pcm_plugins.html).

Some html5 browsers (i.e. [Firefox 30](https://bugzilla.mozilla.org/show_bug.cgi?id=812900#c14); Chrome 38) will fail to open the pcm.!default device for audio playback. This can be fixed by using pcm.card0 instead:

    # default device
    pcm.card0 {
      type plug
      slave.pcm "aduplex"
    }

Here is an example applicable to my DAW. I left some notes so you
understand the extra stuff I also removed unnecessary dsnoop's and
dmix's because when you analyse things a bit more, you realize that some
of the ALSA PCMs will only be used by one single client (alsa_in/out)
so there is no need to use dmix / dsnoop. Dmix only makes sense for the
ALSA playback PCM because you can have more than one client outputting
to ALSA at the same time. Anyway, note the hardware parameters I have
added so that it matches my RME Multiface II requirements. For the dmix
buffering parameters, read on below.

    # hardware 0,0 : used for ALSA playback
    pcm.loophw00 {
      type hw
      card Loopback
      device 0
      subdevice 0
      format S32_LE
      rate 96000
    }

    # playback PCM device: using loopback subdevice 0,0
    # Don't use a buffer size that is too small. Some apps 
    # won't like it and it will sound crappy 

    pcm.amix {
      type dmix
      ipc_key 219345
      slave {
        pcm loophw00
        period_size 4096
        periods 2
      }
    }

    # software volume
    pcm.asoftvol {
      type softvol
      slave.pcm "amix"

      control { name PCM }

      min_dB -51.0
      max_dB   0.0
    }

    # for jack alsa_in: looped-back signal at other ends
    pcm.cloop {
      type hw
      card Loopback
      device 1
      subdevice 0
      format S32_LE
      rate 96000
    }

    # hardware 0,1 : used for ALSA capture
    pcm.loophw01 {
      type hw
      card Loopback
      device 0
      subdevice 1
      format S32_LE
      rate 96000
    }

    # for jack alsa_out: looped-back signal at other end
    pcm.ploop {
      type hw
      card Loopback
      device 1
      subdevice 1
      format S32_LE
      rate 96000
    }

    # duplex device combining our PCM devices defined above
    pcm.aduplex {
      type asym
      playback.pcm "asoftvol"
      capture.pcm "loophw01"
    }

    # default device
    pcm.!default {
      type plug
      slave.pcm aduplex

      hint {
           show on
           description "Duplex Loopback"
      }
    }

### Testing our new default ALSA device

Save this asoundrc config into `$HOME/.asoundrc` but make sure before
that you are not overwriting an existing asoundrc file (back up whatever
you have if it already exists).

OK, now we can test it from the command line. If jack is running on your
other hardware (RME card in my case), you of course will not hear
anything since we have not bridged yet our default ALSA device to the
jack graph.

    mplayer -ao alsa some_audio_file

You can use another app (`aplay` for example). The idea is that an ALSA
app using the default device we have just created will not spit error
messages and will play along nicely. Try for example `lmms` using the
ALSA default :)

The Jack Bridge
---------------

OK, this is where it will get a little bit confusing because of the
loopback nature of the virtual device ;)

### Creating permanent Jack clients using *alsa_in* and *alsa_out*

Since we used subdevice 0,0 for playback and subdevice 0,1 for capture,
remember that signals from these subdevices will be available by
loopback to the corresponding subdevices, respectively 1,0 and 1,1 in
this case. So the trick for jack is to use alsa_in and alsa_out on the
latter subdevices :) Brilliant ins't it ? :D

Let's do it from the terminal

    # capture client
    alsa_in -j cloop -dcloop
    # playback client
    alsa_out -j ploop -dploop 

I hope you start to see the underlying idea. Once these clients show up
in the graph, when an ALSA app plays back to subdevice 0,0 (default ALSA
device defined in our asounrdc), the signal will be available in
subdevice 1,0, which `alsa_in` listens to. The "cloop" client we created
can now be connected to the jack system output ports and o miracle, you
will hear your ALSA app :)

In order to avoid the warning messages from alsa_in/out, you can add
the relevant parameters, e.g. (my case):

     alsa_in -j cloop -dcloop -n 2 -p 256 -r 96000

On the other hand, if you connect a jack system input port to the
"ploop" client created by alsa_out, the signal is sent to loopback
subdevice 1,1 which will be looped back to subdevice 0,1. This subdevice
is nothing but our ALSA capture device, defined in asoundrc :). So now
you can record say your bass or guitar or voice (from your jack
hardware) to an ALSA app that does not support jack. I tried skype, and
it works just fine. You can also try the command line app called
ecasound, which does support jack but also ALSA. It is a VERY convenient
tool to have around (see further down).

The beauty of it is two-fold:

-   permanence of the "cloop" and "ploop" clients (if you shut down your
    ALSA app, cloop and ploop will remain, always listening
-   if jack crashes, it will bring down cloop and ploop but will not
    disrupt the ALSA apps since they only talk to the loopback soundcard
    which is *completely independent of the jack environment* :D

### Create scripts to automate bridge initialization via QjackCtl

The creation of the "p/cloop" clients can be automated, together with
their connection to jack system ports. Here is my script:

    #!/bin/sh
    # script loop2jack, located in /usr/local/bin
     
    # loop client creation
    /usr/bin/alsa_out -j ploop -dploop -q 1 2>&1 1> /dev/null &
    /usr/bin/alsa_in -j  cloop -dcloop -q 1 2>&1 1> /dev/null &

    # give it some time before connecting to system ports
    sleep 1

    # cloop ports -> jack output ports 
    jack_connect cloop:capture_1 system:playback_1
    jack_connect cloop:capture_2 system:playback_2


    # system microphone (RME analog input 3) to "ploop" ports  
    jack_connect system:capture_3 ploop:playback_1
    jack_connect system:capture_3 ploop:playback_2
     
    # done
    exit 0

*Note that I used `-q 1` as an option to alsa_in/out. This has to do
with the resampling quality. At 2.3ms latency, 96kHz s.r. on a 2 x 2.4
GHz dual core CPU system and using Jack2, I get a low CPU usage (1-2%)
and the quality is reasonable. If you push it to 2, 3 or 4, the CPU will
increase quite a lot at small buffering / latency*

In qjackctl (which I use, YMMV), go to Options -\> Execute *after*
server startup and add

    /usr/local/bin/loop2jack

OK, now that you have added all this, save the qjackctl config, quit and
restart it. Start jack, you should see the ploop and cloop clients in
the graph with the connections between the ports we chose in the
loop2jack script.

Test it: open say lmms, load a demo project, play it :)

And voila! try skype, which you can record in ardour if you want (don't
forget to connect your jack system mic directly to the ardour track
which you had connected to the "cloop" client or you will miss recording
what you are saying to the other person ;)

So this was a pure software solution and this has the benefit that all
your jack input ports are available to the ploop jack client so that
ALSA apps can record the audio coming from these jack ports via the
looped-back device. Of course, the loop stuff has latency (the default
dmix and dsnoop buffering is quite big), but who cares ? ... Well
actually, I did care a little so I revisited some things and estimated
the latency added by the Loopback device. I also tweaked a hybrid
solution where the ALSA capture PCM is using a real hardware (onboard
chip or extra soundcard). Just read below.

Alternative Setup: hardware and software based solution
-------------------------------------------------------

As mentioned in my introduction, I happen to have an onboard chip (Intel
HDA) but also a USB webcam with a built-in mic. It would be a shame not
to use their recording capability in some way, especially since I tend
to use skype from my DAW PC quite often.

### Adding extra h/w inputs in asoundrc

So instead of using the Loopback device for the ALSA capture (all the
stuff related to "ploop" in the previous asoundrc), I simply declared
the extra h/w in the asoundrc. So I removed all the ploop stuff
including the now useless Loopback subdevices used for ALSA capture and
alsa_out, and added hw PCM devices on the Intel device and USB webcam.

    # ------------------------------------------------------
    # hardware 0,0 : used for ALSA playback
    pcm.loophw00 {
      type hw
      card Loopback
      device 0
      subdevice 0
      format S32_LE
      rate 96000
    }

    # ------------------------------------------------------
    # playback PCM device: using loopback subdevice 0,0
    pcm.amix {
      type dmix
      ipc_key 219347
      slave {
        pcm loophw00
        period_size 4096
        periods 2
      }
    }

    # ------------------------------------------------------
    # software volume
    pcm.asoftvol {
      type softvol
      slave.pcm "amix"

      control { name PCM }

      min_dB -51.0
      max_dB   0.0
    }

    # ------------------------------------------------------
    # for jack alsa_in: looped-back signal at other ends
    pcm.cloop {
      type hw
      card Loopback
      device 1
      subdevice 0
      format S32_LE
      rate 96000
    }

    # ------------------------------------------------------
    # hardware Intel: used for ALSA capture
    pcm.intel {
      type hw
      card Intel
    }

    pcm.isnoop {
      type dsnoop
      ipc_key 219346
      slave.pcm "intel"
    }

    # ------------------------------------------------------
    # hardware USB cam: used for ALSA capture
    pcm.usb {
      type hw
      card U0x46d0x81b # name obtained from inspecting file '/proc/asound/cards'
    }

    # ------------------------------------------------------
    # duplex device combining our PCM devices defined above
    pcm.aduplex {
      type asym
      playback.pcm "asoftvol"
      capture.pcm "usb"
    }

    # ------------------------------------------------------
    # default device

    defaults.pcm.rate_converter "samplerate_best"

    pcm.!default {
      type plug
      slave.pcm aduplex

      hint {
           show on
           description "ALSA Default"
      }
    }

### Testing the new ALSA capture

This one was easy to test. I made sure that my asoundrc default card
used the "usb" pcm capture (see above). I then fired up skype, set it to
use the "Default" device for everything. I fired QasMixer (a nice QT4
based mixer if you don't know it) and controlled the capture level of
the USB webcam from there (I do not let skype control my levels). Then I
tried the skype test call and made sure it recorded my voice. The webcam
is by the way a Logitech Webcam C310 which I am satisfied with. Works
out of the box in linux due to its class compliance with USB vid.

Note that the same thing can be done with the Intel HDA capture ("intel"
pcm capture defined in the previous asoundrc) provided that you plug a
mic to its input jack of course :)

Measuring the latency introduced by the Loopback device
-------------------------------------------------------

For measuring the latency, I had to be able to provide both Jack and
ALSA with a common audio source.

### Playback only

First, I fired up jackd and alsa_in on "cloop" (just as before). Then,
I used ecasound as the middle-man for allowing the measuring of the
eventual delay in ardour (which I am comfortable with, you can of course
use another jack enabled recording software if you want).

Here is the ecasound command line, very simple:

     ecasound -i jack -o alsa

Then in qjackctl, I connected a sound source like my microphone
available at `system:capture_3` to `ecasound:playback_1/2`.

In ardour, I created two tracks: one mono track accepting audio from the
same system capture port, and a stereo track connected to the "cloop"
client. Indeed, since ecasound outputs to the default ALSA device, the
cloop client should have the audio by loopback. I then recorded
something in ardour so both tracks contained data coming from the same
audio source. I compared the resulting waveform and observed a delay of
120 ms when the dmix parameters are set to default.

Another way is to use the click sound ardour provides, instead of a
microphone as mentioned above. Just connect the ardour click output
ports to ecasound's input ports, and connect the click ports to one of
the ardour tracks, the other one should still receive the cloop client
data. If you fiddle with the dmix parameters in the .asoundrc, you will
obtain various delays. It is therefore up to you to decide how the
period_size and buffer_size params must be set.

A 120 ms delay is not bad at all considering the huge buffering dmix
configures by default. But remember that dmix really sucks at small
buffering so you have to choose a reasonably large one. I ended up using
the following:

    # ------------------------------------------------------
    # playback PCM device: using loopback subdevice 0,0
    pcm.amix {
      type dmix
      ipc_key 219347
      slave {
        pcm "loophw00"
        period_size 4096
        periods 2
      }
    }

This setting gives me a final Loopback latency of \~ 35ms, while dmix
does a good job without choking.

### Capture and Playback

If you are using the complete software solution (ALSA playback and
capture via cloop and ploop), then you can still use ecasound as an
intermediate tool. Just fire it up in this way:

    ecasound -i alsa -o alsa

In qjackctl, connect the ardour click ports to the "ploop" ports. This
will allow ecasound to record the ardour click via the looped-back ploop
audio. Then ecasound will output it to the default ALSA pcm playback
which alsa_in collects via the cloop client.

In ardour, just like the setup above, have two tracks, one receiving
the internal ardour click directly, the other connected to the cloop
ports. Arm the tracks for recording, enable the click, activate the
transport. You will see audio data in both tracks, one is delayed of
course (the one connected to cloop). With my tuned asoundrc, I get an
overall Loopback latency well below 100ms (approximately 75ms). It is
not bad at all for the whole purpose of the Loopback bridge.

If low latency is a concern, don't use ALSA only apps, use jackified
apps :D

### Final word

I hope all this was clear enough. The idea behind this was to use a h/w
capture device instead of the Loopback device. This reduces the role of
the Loopback device to ALSA playback only, and removes the need of
alsa_out, sparing some CPU and jack process cycles. At the moment, I am
using my USB webcam for capture because I only need ALSA capture for
skype. The Intel HDA is available as well but I don't really need it. It
is connected to my patch panel though, so I can always use it if the
need comes (unlikely).

### Troubleshooting

If you have pulseaudio on you machine, better kill it, overwise it doesn't work.

