Sound Cards: Introduction
=========================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

In the early days of personal computers the only sounds that the
computers could produce were created by a small permanent-magnet
loudspeaker connected to a simple tone generator. This facility was very
limited, and afforded the programmer little more than the ability to
produce a few 'beeps'.

To address the growing demand for more capable sound hardware, several
manufacturers began to produce plug-in cards ('daughter boards') which
contained more complex sound devices. The famous 'sound blaster' is one
example. These plug-in cards were of course generally called 'sound
cards' and, being 'daughter boards' they plugged into the computer's
'mother board'. Sound cards generally have no transducer (loudspeaker,
microphone) capable of converting between electrical energy and sound
energy. They rely on external devices, often connected through external
amplifiers, to do that.

More recently, microelectronics has enabled greater integration, and it
is now common to find fairly complex sound devices on the motherboard
itself. Although these electronic devices are quite often not separate
cards, they are still referred to as 'sound cards'.

In ALSA a soundcard can have several capabilities:

-   It can be used as a pcm-playback/capture device (see
    [pcm-device](/Pcm-device "Pcm-device"))
-   It might have [midi](/Midi "Midi") hardware
-   And it might have a [ctl-device](/Ctl-device "Ctl-device") (a
    mixer).

Different soundcards will have different hardware features. A basic
soundcard might have the I/O ports shown in the figure. More
sophisticated cards will support more channels, S/PDIF I/O, MIDI ports,
or more analog speaker outputs for surround sound or woofers.

[File:Soundcard.png](/File:Soundcard.png "File:Soundcard.png")

In the figure:

-   Line In - analog input from external device
-   Mic In - low-level, mono microphone input
-   PCM playback - digital stream from software
-   Synthesizer - stream generated from wavetable
-   PCM Capture - digital stream output to software
-   Line Out - analog output to external device
-   Speaker - amplified analog output to external speakers

\
 The 'Sound Card' unit usually consists of three sets of components:

-   Connectors - Connect the card to loudspeakers, microphones and other
    devices. In the USA these connectors are usually called 'jacks'.
-   Audio circuits - amplify and mix the audio signals, and convert
    audio signals between analogue and digital representations.
-   Interface - connects the 'Sound Card' to one of the main computer
    buses.

The interface between the sound devices and the processor is usually
through the computer's PCI (or PCIe) bus. The hardware which implements
the interface is usually contained within the 'Southbridge', part of the
'chipset' produced by a manufacturer for motherboard designers. The name
given to the 'Sound Card' is derived from any of the following:

-   The model of the Southbridge chip's Audio Control subcircuit
-   A PCI adapter chip that gets from the PCI bus to the audio circuits
-   The model of the actual CODEC that converts from Digital to Analog
    and back
-   The model of the daughter card that contains the PCI adapter and the
    CODEC.

The program **[alsamixer](/Alsamixer "Alsamixer")** reports the names of
both the 'sound card' and the 'audio chip'. As a result with a
motherboard based on a NVidia chipset the output may be:

    Card: NVidia CK804
    Chip: Realtek ALC850 Rev 0

On another motherboard using a Via chipset, one might find:

    Card: Via Via8235
    Chip: Realtek ALC850 Rev 0

The audio CODEC chip, a Realtek ACL850, being the same in both cases.
The low level command

    cat /proc/asound/cards

provides the card name and chip number but leaves out the vendor name
'Realtek'. Unfortunately most high level programs only provide the card
name.

Contents
--------

-   [1 Drivers](#Drivers)
-   [2 AC'97](#AC.2797)
-   [3 High Definition Audio](#High_Definition_Audio)
-   [4 External Links](#External_Links)
-   [5 See also](#See_also)

Drivers
-------

The audio cards used in most home computers are based on the Intel
[AC'97](/AC97 "AC97") standard (see below). This defines a set of
standard controls on the audio chip and is sufficient for high level
programs to find out what controls are available on each card and to
then issue the correct commands.

Unfortunately, the PCI interface is not fully specified by AC'97 and so
different ALSA drivers are needed for each type of PCI interface. As a
result, in a running system, the command

    lsmod | grep snd

will show the module `snd_ac97_codec` which handles the AC'97 standard.
It will show that this is calling a second module to handle the PCI
interface. For the Via8235 above this would be the module `snd_via82xx`.
For the Nvidia CK804 it will be `snd_intel8x0`, as Nvidia and Intel use
the same interface standard.

The AC'97 standard has to a great degree been replaced by the Intel
'High Definition Audio' (HDA) standard. This defines both the circuits
and the PCI interface and so needs only a single set of ALSA drivers.

AC'97
-----

The Intel '[Audio CODEC '97](/AC97 "AC97")' standard specifies audio
components to be found in a mainstream PC, a standard way of connecting
the components and a set of registers for controlling the components. It
also defines related features such as voltages and timing
characteristics.

Input can be analogue audio signals from a microphone, telephone, video,
CD and other devices. Some will be mono, some stereo. Input also
includes sound from the computer which is converted from digital to
analogue before further processing. Upon input, each of these signals
passes through an amplifier and a mute switch, both of which can be
controlled by the mixer software on the computer.

Analogue output can be to stereo speakers and additional surroundsound
speakers. Output of sound to the computer is provided by an analogue to
digital converter. Again, all output streams can be amplified or muted,
on command, from the computer. Later versions of the standard allow
input and output using the Sony/Phillips Digital Interface ([S/P
DIF](/SPDIF "SPDIF"),) also frequently called IEC958 because of the
international specification that subsequently standardised this format,
to connect additional audio equipment.

Between input and output the standard defines two main pathways, one
providing analogue output to the main stereo speakers, the other leading
to the computer input. In the first, the different input streams can be
combined and passed through an optional surroundsound filter, before
being sent via a tone filter to the output. Digital input
([PCM](/PCM "PCM") - Pulse Coded Modulation) can be added before or
after the surroundsound step. The telephone signal is added after the
surroundsound step.

For computer output the standard is somewhat different. Output to the
computer is allowed from just one of the analogue inputs or from the
main stereo output after the tone filter, or from a mono version of the
main output. In ALSA the latter are often called the 'MIX' and 'MONO
MIX' channels. Note that the digital input signal can only be captured
using one of the two latter channels.

As well as the above outputs there is also a mono output channel and
surroundsound channels. The mono output can be driven from the
microphone input. Alternatively it can be a mono copy of the main output
channel, tapped before the telephone input is added. This allows mono
output to be used for telephone output without feedback developing.

The surroundsound channels can be driven by the surroundsound filter in
the main pathway. Alternatively they can be driven by their own digital
input stream from the computer. Additional switches are often available,
for example to allow input from more than one microphone or to allow
additional links between the audio channels.

High Definition Audio
---------------------

This is a recent Intel specification for defining and controlling a much
more sophisticated audio system. In this case the audio system is
connected to a PCI or other system bus via a well specified 'HDA
Controller'. This is then connected to one or more audio chips via a
serial bus, the 'High Definition Audio Link'. Each audio chip (or CODEC
to use Intel's terminology) can then contain a number of widgets.
Typical widgets are:

-   A computer audio output converter (DAC) widget
-   A computer audio input converted (ADC) widget
-   A mixer widget (including input and output amplifiers and mutes)
-   A selector (multiplexor widget)
-   A pin widget (detecting input/output devices)
-   A volume widget

On startup, each codec sends the controller information about which
widgets are present and how they are connected. This allows very complex
systems to be developed and controlled.

External Links
--------------

-   AC'97 Specification:
    [http://download.intel.com/support/motherboards/desktop/sb/ac97\_r23.pdf](http://download.intel.com/support/motherboards/desktop/sb/ac97_r23.pdf)
-   High Definition Audio:
    [http://www.intel.com/design/chipsets/hdaudio.htm](http://www.intel.com/design/chipsets/hdaudio.htm)

See also
--------

-   [Sound cards](/Sound_cards "Sound cards")
-   [MIDI](/MIDI "MIDI")

Retrieved from
"[http://alsa.opensrc.org/Sound\_Cards:\_Introduction](http://alsa.opensrc.org/Sound_Cards:_Introduction)"

[Categories](/Special:Categories "Special:Categories"): [Sound
cards](/Category:Sound_cards "Category:Sound cards") |
[Documentation](/Category:Documentation "Category:Documentation") |
[Introduction](?title=Category:Introduction&action=edit&redlink=1 "Category:Introduction (page does not exist)")
| [Glossary](/Category:Glossary "Category:Glossary")

