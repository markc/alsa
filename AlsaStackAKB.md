AlsaStackAKB
============

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

I'm basically sandboxing here, since this isn't linked from anyplace.
It's a work in progress. Move along, move along. Yes, I use the first
person quite a bit, sometimes as "we", in the vague hope that this will
grow up to be a mature wiki document maintained by a bunch of people.

Contents
--------

-   [1 Software World](#Software_World)
    -   [1.1 Sound Card Hardware Drivers](#Sound_Card_Hardware_Drivers)
    -   [1.2 Kernel Sound Systems](#Kernel_Sound_Systems)
        -   [1.2.1 Why not OSS?](#Why_not_OSS.3F)
            -   [1.2.1.1 /dev/dsp](#.2Fdev.2Fdsp)

        -   [1.2.2 Why ALSA?](#Why_ALSA.3F)

    -   [1.3 Kernel APIs](#Kernel_APIs)
        -   [1.3.1 In-Kernel OSS Emulation](#In-Kernel_OSS_Emulation)
        -   [1.3.2 Out of Kernel OSS
            Emulation](#Out_of_Kernel_OSS_Emulation)

    -   [1.4 Sound Servers and API
        Madness](#Sound_Servers_and_API_Madness)
        -   [1.4.1 aRts](#aRts)
        -   [1.4.2 dmix](#dmix)
        -   [1.4.3 esd](#esd)
        -   [1.4.4 jack](#jack)
        -   [1.4.5 NAS](#NAS)
        -   [1.4.6 SDL](#SDL)

-   [2 Security, Devices, and
    Firmware](#Security.2C_Devices.2C_and_Firmware)
    -   [2.1 Sound Cards](#Sound_Cards)

Software World
--------------

To play or record sound on a linux system, commands and audio data go
through a chain of software components. There are also hardware
components, of course, but we'll look at them seperately.

Components include:

1.  the program or application that plays or records the sound (like
    realplayer, xmms, a game, etc.). This app will use one of many API's
    to tell a program library about the sound commands it wants
    performed.
2.  the library that provides the API for the application to use, and
    passes the command data along. Sometimes it passes it on to an
    intermediate set of programs, sometimes it hands it to the operating
    system core (the kernel).
3.  the intermediate systems between the library and the kernel, if any.
    We'll refer to these as "sound servers", because so far there isn't
    a better term.
4.  the kernel API that the libraries used by the apps and sound servers
    talks to. This lives inside the kernel.
5.  the kernel sound system that interprets the commands. This has
    multiple parts, depending on what kind of commands are being
    executed. These parts mostly correspond to the sound card
    sub-devices.
6.  the kernel hardware driver that tells the hardware what to do, and
    listens to input from the hardware to pass back along the chain.

We'll describe things in reverse order.

### Sound Card Hardware Drivers

The driver is the part of the linux operating system that packages up
the information for a piece of hardware (like, say, a sound card) and
shoves it someplace where the hardware will see it and pay attention. It
also does the reverse, listening to data coming in from the hardware,
and letting the rest of the operating system know it's there.

You can think of it like a mail room at a big company; you give the
hardware driver your package for the sound card (for example some sounds
you want played) and it wraps it up and hands it to the postman. When an
answer comes back (containing, for example, a note that your sound has
been played), the hardware driver signs for the package, unpacks it
some, and drops it on your desk.

Different cards have different abilities to do things; some can play
music thru six speakers, others only know about one. Some can handle
12-track recording for a musician, others have a single microphone
input.

Not all drivers are created equal. Some can use all the capabilities of
the cards they support, while others provide only the bare minimum of
functionality.

**Questions:**

-   What HW drivers are there?
-   What HW drivers do I have installed?
-   What HW drivers do I need?
-   What commands do the drivers support?
-   What features do the drivers support?
-   How can I make sure the driver works?

### Kernel Sound Systems

Linux has two sound systems:

-   The old one, now being phased out, is OSS (the Open Sound System)
-   The new one is ALSA (the Advanced Linux Sound Architecture)

**Questions:**

-   What Sound System do I have installed?
-   How can I make sure the kernel sound system works?
-   Which distros have which sound system?

#### Why not OSS?

OSS had the problem that only one application could send sound to it at
a time. For example, if you tried to listen to some MP3's and play a
game at the same time, only one of those two applications would be able
to actually produce sound.

To get around this, a whole bunch of different programs were developed
that could take multiple streams of sound and mix them. When ALSA came
along, many of those applications were modified so that they could use
either ALSA or OSS. These became some of the "sound servers".

OSS is currently listed as "deprecated" in the linux kernel
configurations, and this means that the kernel developers won't give
much support to people using it. Few drivers are being written for new
sound cards.

##### /dev/dsp

The linux device file normally used by OSS applications to send sound to
the sound card for output is `/dev/dsp`.

Only one program can use this device at a time, so if an MP3 player is
playing a song for you and you start up a game, the game will likely
gripe that `/dev/dsp` is already in use, and possibly will crash, or
hang until the MP3 player releases the device.

#### Why ALSA?

ALSA is better than OSS for a bunch of reasons, including that it can
handle multiple sources of sound and that it's what people are now
writing hardware drivers for. Being a second system, its design benefits
from seeing the shortcomings in the first system. As well, the world of
linux sound is now more complex, with fancy new sound cards, programs
for multi-track recording and playback for musicians, and so on. ALSA
was designed with many more of these capabilities in mind.

To ease the transition, ALSA provides various ways to support programs
that want to use OSS. Some work better than others, depending on the
exact situation.

### Kernel APIs

OSS and ALSA use different kernel APIs. This means that a program
written to use only one of these systems can't directly use the other.

ALSA provides two ways to deal with this:

-   In-Kernel OSS Emulation
-   Out of Kernel OSS Emulation

**Questions:** How can I tell what's installed on my system? How do I
test it?

#### In-Kernel OSS Emulation

ALSA has an emulation (imitation) of OSS' kernel API. This can be used
two ways:

-   By compiling it into the kernel
-   By compiling it as a module and inserting it into the kernel

If it is compiled into the kernel, it can't be removed. This can be a
problem for a few reasons. Among them:

-   It can make configuration more difficult to debug.
-   It can't be switched off, which means poorly behaved apps and system
    software which try to use it need may need to be rooted out.

Compiled as a module, it still has some of these problems; applications
trying to use OSS even if you don't want them to will often cause the
kernel to automatically load the OSS Emulation Modules if they are
available.

Why use In-Kernel emulation?

-   It is generally simpler to use, especially at a user level
-   Performance is better; with Out of Kernel Emulation, you might have
    to deal with audio dropouts, stalling, and similar problems

#### Out of Kernel OSS Emulation

### Sound Servers and API Madness

If you've been following along so far, you've seen that ALSA has the
following common ways to get sound in and out:

-   OSS API compiled into the kernel.
-   OSS API built as a module and loaded into the kernel.
-   OSS API provided via a library, that talks to the ALSA parts in the
    kernel.
-   ALSA API provided via a library.

Now it gets even more complicated.

There are six (that I can think of) common "sound server" systems that
can get between any of the above four implementations of two APIs and
the program that wants to make or record sound:

-   aRts, the analog Realtime synthesizer, the sound system of KDE
-   dmix, actually part of ALSA and not a seperate system, it acts as an
    Indirection Layer though, so it gets covered here
-   esd, the Enlightened Sound Daemon, developed for the Enlightenment
    window manager
-   jack
-   NAS, the Network Audio System, developed for X Windows xterminals
-   SDL, the Simple DirectMedia Layer

Many applications have multiple output methods, so that they can talk to
several (or even all!) of these systems.

#### aRts

#### dmix

#### esd

#### jack

#### NAS

NAS was written by the NCD corporation, which used to make X terminals,
a sort of thin client (A machine you plunk on a desk like an appliance
which is simple enough that users can't easily break it. Usually has no
disk drives.) based on the X Windows system.

Latest (as of May 2006) Stable revision: 1.7, released 2004-11-14 Latest
(as of May 2006) Development revision: 1.7b, released 2005-06-04

**How does it output sound:**

it writes to /dev/audio an exclusive /dev entry

**Interfaces:**

-   Library libaudio.so
-   Unix Socket, /tmp/.sockets/audio\# (where \# is which output device)
-   tcp port, port 8000 + \# (where \# is output device, starting from
    0)
    -   can turn off tcp listener entirely
    -   can set tcp listener to ignore network (only let users on the
        machine use it)
    -   (some sort of authentication scheme)

**Sample Applications that usually come with it:**

-   auplay
-   auctl
-   auinfo
-   audemo
-   audial
-   autool
-   auscope
-   aupanel
-   auedit
-   auconvert
-   auphone
-   aurecord
-   auwave

**Audio Formats it can natively deal with:**

-   .aiff, .aif
-   .au
-   .voc
-   .wav

#### SDL

Security, Devices, and Firmware
-------------------------------

### Sound Cards

Sound cards (or built-in sound chips on a PC's motherboard) typically
have firmware that presents the following types of components, known as
sub-devices, for the host computer to use:

-   Control circuitry, which lets the PC control the volume
-   PCM synthesizers, which produce sound. (this is where the signal to
    your speakers is generated)
-   PCM samplers, which turn sound into digital information a computer
    can handle (this is where the mic input becomes digital info)
-   Timers, to make sure sounds happen at exactly the correct time
-   Sequencers
-   MIDI

Not all cards have all devices, many cards have several of each. All the
devices might live in a single chip, but linux doesn't need to know or
care about that.

Retrieved from
"[http://alsa.opensrc.org/AlsaStackAKB](http://alsa.opensrc.org/AlsaStackAKB)"

[Category](/Special:Categories "Special:Categories"):
[Documentation](/Category:Documentation "Category:Documentation")

