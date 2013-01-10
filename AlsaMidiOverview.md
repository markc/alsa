AlsaMidiOverview
================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

There's a huge difference between the ALSA MIDI implementation and most
other operating systems. With ALSA it is no problem to interconnect
different applications on the same computer.

Make sure that ALSA found your soundcard

` `

    cat /proc/asound/cards

There is a difference between hardware MIDI ports and software MIDI
ports (virtual ports), but in practice every well-written ALSA app
should work with both.

` `

    amidi -l

gives you a listing of the available hardware MIDI ports on your system.
Here's the output on my machine:

` `

    tapas@mango:~$ amidi -l
    Device    Name
    hw:0,0    CS46XX
    hw:1,0    Virtual Raw MIDI (16 subdevices)
    hw:1,1    Virtual Raw MIDI (16 subdevices)
    hw:1,2    Virtual Raw MIDI (16 subdevices)
    hw:1,3    Virtual Raw MIDI (16 subdevices)

This output shows that I effectively have two soundcards. One of them is
the `virmidi` module that provides 4 "virtual" hardware ports. These can
be used to connect apps that insist on using hardware MIDI ports.

The command `aconnect`, which is also used to connect software MIDI
ports, can give you a listing of all MIDI ports (both software and
hardware MIDI ports):

` `

    tapas@mango:~$ aconnect  -i -o  
    client 0: 'System' [type=kernel]
        0 'Timer           '
        1 'Announce        '
    client 62: 'Midi Through' [type=kernel]
        0 'Midi Through Port-0'
    client 64: 'Rawmidi 0 - CS46XX' [type=kernel]
        0 'CS46XX          '
    client 72: 'Virtual Raw MIDI 1-0' [type=kernel]
        0 'VirMIDI 1-0     '
    client 73: 'Virtual Raw MIDI 1-1' [type=kernel]
        0 'VirMIDI 1-1     '
    client 74: 'Virtual Raw MIDI 1-2' [type=kernel]
        0 'VirMIDI 1-2     '
    client 75: 'Virtual Raw MIDI 1-3' [type=kernel]
        0 'VirMIDI 1-3     '
    client 129: 'FLUID Synth (11157)' [type=user]
        0 'Synth input port (11157)'
    client 130: 'Virtual Keyboard' [type=user]
        0 'Virtual Keyboard'

The `"-i"` and `"-o"` options tell `aconnect` to list both writable and
readable ports (input and output). See the output of the command
`"man aconnect"` to get more info.

As we can see from above listing from `aconnect`, I have two programs
running that provide software MIDI ports. This part of the listing is
shown again below:

​1) fluidsynth:

` `

    client 129: 'FLUID Synth (11157)' [type=user]
        0 'Synth input port (11157)'

​2) vkeybd:

` `

    client 130: 'Virtual Keyboard' [type=user]
        0 'Virtual Keyboard'

[FluidSynth](/FluidSynth "FluidSynth") is a software synthesizer that
can load [soundfonts](/Soundfont "Soundfont"). `vkeybd` is a virtual
keyboard that can generate MIDI events. We will connect the two now.

` `

    tapas@mango:~$ aconnect 130:0 129:0

After this I can just play around with the keys on the `vkeybd` and
`fluidsynth` plays the appropriate notes.

Of course, I can also connect `vkeybd` to a hardware MIDI port:

` `

    tapas@mango:~$ aconnect 130:0 64:0

Now, every key press goes to `fluidsynth` [we haven't disconnected it
yet] AND to the hardware MIDI output port on my soundcard. That's one of
the nice things about ALSA: you can connect a MIDI source to any number
of MIDI destinations. And you can connect any number of MIDI sources to
a MIDI destination. Very nifty.

Using `aconnect` can be tedious. That's why I usually use a graphical
patchbay to connect MIDI stuff. See
[AlsaMidiPatchbays](/AlsaMidiPatchbays "AlsaMidiPatchbays").

Retrieved from
"[http://alsa.opensrc.org/AlsaMidiOverview](http://alsa.opensrc.org/AlsaMidiOverview)"

[Category](/Special:Categories "Special:Categories"):
[MIDI](/Category:MIDI "Category:MIDI")

