Proc asound documentation
=========================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

**`/proc/asound` for fun and profit**

\
 Linux tends to put information about system processes, including some
of the hardware configuration information, in a virtual filesystem
called `/proc`. The items here are not actual files, they are a way of
reading information from and sending information to the operating system
kernel and associated kernel modules.

Reading information can be done by simply looking at the virtual file
using `cat`, `more`, `less`, or some other pager/file viewer program.
Sending commands back is done by using `cat` or `echo` to write data
into the virtual file.

The `/proc/asound` set of files is what ALSA uses for device information
and for some control purposes.

Contents
--------

-   [1 What are the files?](#What_are_the_files.3F)
    -   [1.1 Device files in /dev/snd/ (and
        /proc/asound/dev/)](#Device_files_in_.2Fdev.2Fsnd.2F_.28and_.2Fproc.2Fasound.2Fdev.2F.29)
    -   [1.2 The /proc/asound/oss/
        directory](#The_.2Fproc.2Fasound.2Foss.2F_directory)
    -   [1.3 The /proc/sound/cardX/
        directory](#The_.2Fproc.2Fsound.2FcardX.2F_directory)
    -   [1.4 The /proc/asound/cardX/pcmXX/
        directories](#The_.2Fproc.2Fasound.2FcardX.2FpcmXX.2F_directories)
    -   [1.5 The /proc/asound/seq/
        directory](#The_.2Fproc.2Fasound.2Fseq.2F_directory)

-   [2 So what are the hardware
    devices?](#So_what_are_the_hardware_devices.3F)
-   [3 /proc will change](#.2Fproc_will_change)
-   [4 See Also](#See_Also)

What are the files?
-------------------

The `/proc` info, such as usb descriptor dump, is hardware (driver)
dependent. Contents are up to the driver author, so a complete general
description isn't really possible. That said, ALSA does have certain
standards which most drivers adhere to.

The basic files, provided by ALSA itself:

 `/proc/asound/cardX/` (where *X* is the sound card number, from 0-7) 
:   a `cardX` directory exists for each sound card the system knows
    about.
:   see below for information on the contents of this directory.

 `/proc/asound/cards` (readonly) 
:   the list of registered cards

 `/proc/asound/dev/` 
:   a directory listing the specific device files used by programs for
    sound operations
    if your system uses devfs, this will be present
:   if your system does not use devfs (and as of 2006-06, most do not)
:   this file will either not exist at all, or simply be a symlink to
    `/dev/snd`

 `/proc/asound/devices` (readonly) 
:   the list of registered ALSA devices (major device number = 116)

 `/proc/asound/hwdep` (readonly) 
:   the list of hwdep (hardware dependent) controls
    does not appear on all systems (does this still exist??)

 `/proc/asound/meminfo` (readonly) 
:   memory usage information
    this proc file appears only when you build the alsa drivers
:   with memory debug (or full) option so the file shows the
:   currently allocated memories on kernel space.

 `/proc/asound/modules` (readonly) 
:   the list of registered ALSA soundcard drivers
    this is not all kernel modules loaded for ALSA, this is just the
    list of
:   drivers for hardware. Expect to see one line here for each soundcard
    that is
:   in use.

 `/proc/asound/oss/` 
:   a directory containing info about oss emulation
    see below for information on the contents of this directory.

 `/proc/asound/pcm` (readonly) 
:   the list of allocated pcm streams
    note that this (probably) does not mean the list of active streams,
    it is a list
:   of devices. It's really useful for figuring out the *hw:0,0* style
    device
:   names that commands like *aplay* want.

 `/proc/asound/seq/` 
:   a directory containing info about sequencer
    see below for information on the contents of this directory.

 `/proc/asound/timers` (readonly) 
:   similar to `/proc/asound/pcm`, it's a list of timers ALSA knows
    about, and also
:   (seems to) describe which ones are actually being used for something
    at the
:   moment.

 `/proc/asound/version` (readonly) 
:   the version and date the ALSA subsystem module (or kernel) was built

Note: Devices marked "readonly" above are used only to provide
information from the kernel. All other devices are read-write devices
and can be used to send commands to ALSA.

### Device files in `/dev/snd/` (and `/proc/asound/dev/)`

Device files are what applications connect to in order to perform sound
operations such as recording, playing, altering volume, getting timing
information, and performing MIDI sequencing. They are generally found in
`/dev/snd`, but may also be found in `/proc/asound/dev` on some systems.

Generally the device files are named in the form `     aaaCxDy`

*aaa* is the service name

*x* is the card number (0-7)

*y* the device number (0-?)

` `

    controlC?  control devices (i.e. mixer, etc.)
    hwC?D?     hwdep devices
    midiC?D?   rawmidi devices
    pcmC?D?p   pcm playback devices
    pcmC?D?c   pcm capture devices
    seq        sequencer device
    timer      timer device

### The `/proc/asound/oss/` directory

The contents of the files under this directory are changed dynamically.
When no oss emulation modules
([snd-pcm-oss](/Snd-pcm-oss "Snd-pcm-oss"),
[snd-mixer-oss](/Snd-mixer-oss "Snd-mixer-oss")) are loaded, no pcm nor
mixer devices will be listed.

` `

    /proc/asound/oss/devices (RO)
     the list of devices already registered

    /proc/asound/oss/sndstat (RO)
     /dev/sndstat compatible list

### The `/proc/sound/cardX/` directory

` `

    id (RO)
     the id string of the card

    ac97#? (RO)
     AC97 codec information

    ac97#?regs (RO)
     (printable) register dump

    midi? (RO)
     the current status of input/output on the
     rawmidi device

    pcm?p
     the directory status of the given pcm playback stream
    pcm?c
     the directory status of the given pcm capture stream

### The `/proc/asound/cardX/pcmXX/` directories

The files in these optional directories contain PCM stream information.
Note that with Linux 2.6.17 and newer these files will only be available
if `CONFIG_SND_VERBOSE_PROCFS` ("Verbose procfs contents") is enabled in
the kernel config.

` `

    pcm??/info (RO)
     the pcm stream general info (card, device, name, etc.)

    pcm??/oss (RO)
     oss emulation info (shown only when the pcm is opened
     as an oss device).

    pcm??/sub?
     the substream information directory

    pcm??/sub?/info (RO)
     the pcm substream general info (card, device, name, etc.)

    pcm??/sub?/status (RO)
     the current status of the given pcm substream
     (status, position, delay, tick time, etc.)

    pcm??/sub?/hw_params (RO)
     hw_params set-up on the substream
     (buffer size, format, etc.)

    pcm??/sub?/sw_params (RO)
     sw_params set-up on the substream
     (threshold, etc.)

    pcm??/sub?/prealloc (RW)
     the number of pre-allocated buffer size in kb.
     you can specify the buffer size by writing to this proc file:

     # echo 128 > /proc/asound/card0/pcm0p/sub0/prealloc

     to allocate 128kbyte for playback, substream #0, stream #0
     on the card #0.

To find all the options for the alsa modules on your machine run this
script...

` `

    modinfo $(modprobe -l snd-*) > ~/modinfo

### The `/proc/asound/seq/ directory`

clients 
:   Need info

drivers 
:   Need info

oss 
:   Need info

queues 
:   Need info

timer 
:   Need info

So what are the hardware devices?
---------------------------------

Typical output might look like this:

` `

    prompt# cat /proc/asound/devices  
      0: [ 0]   : control 
      1:        : sequencer 
     16: [ 0- 0]: digital audio playback 
     18: [ 0- 2]: digital audio playback 
     24: [ 0- 0]: digital audio capture 
     25: [ 0- 1]: digital audio capture 
     33:        : timer 

The example above tells you that you have one [control
channel](?title=Control_channel&action=edit&redlink=1 "Control channel (page does not exist)"),
two PCM playback devices (DAC's), two PCM capture devices (ADC's), a
MIDI
[sequencer](?title=Sequencer&action=edit&redlink=1 "Sequencer (page does not exist)"),
and a
[timer](?title=Timer&action=edit&redlink=1 "Timer (page does not exist)").

On the system used for this example, with no remapping of anything to
anything else, these equate to the following:

**Device:**

-   First PCM playback DAC
    -   What it does: Plays sound
    -   The device file looks like:
    -   `crw-rw----  1 root audio 116,  16 Mar  4 21:30 pcmC0D0p`
    -   (the date on yours will probably be different)
    -   What ALSA calls it: the playback half of `hw:0,0`, which is a
        [duplex
        device](?title=Duplex_device&action=edit&redlink=1 "Duplex device (page does not exist)")

-   First PCM recording ADC
    -   What it does: Plays sound
    -   The device file looks like:
    -   `crw-rw----  1 root audio 116,  16 Mar  4 21:30 pcmC0D0c`
    -   What ALSA calls it: the recording half of `hw:0,0`, which is a
        [duplex
        device](?title=Duplex_device&action=edit&redlink=1 "Duplex device (page does not exist)")

-   Control Channel for first soundcard
    -   What it Does: controls volume/recording gain (and other stuff?)
    -   The device file looks like:
    -   `crw-rw---- 1 root audio 116,   0  Mon DD hh:mm /dev/snd/controlC0`
    -   (`Mon DD hh:mm` will be the date and time the device file was
        created on your system)
    -   What ALSA calls it:  ??

`/proc` will change
-------------------

In future `/proc` will be used for process information only, and the
place to look for ALSA info will be `sysfs`.

In the 2.6 kernel source, there's a file called

`  `

    Documentation/filesystems/sysfs.txt 

with some info about this. As of 2006-06 (and kernel 2.6.16), `/sys`
exists, but the `/proc` interface has not changed yet.

See Also
--------

-   [Procfile.txt](/Procfile.txt "Procfile.txt"): Takashi Iwai's
    `Procfile.txt` in the ALSA Documentation.

-   `aadebug`: a script you can use to provide a brief snapshot of your
    system suitable for emailing to someone else for help.

Retrieved from
"[http://alsa.opensrc.org/Proc\_asound\_documentation](http://alsa.opensrc.org/Proc_asound_documentation)"

[Category](/Special:Categories "Special:Categories"):
[Documentation](/Category:Documentation "Category:Documentation")

