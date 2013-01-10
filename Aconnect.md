Aconnect
========

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

aconnect - ALSA sequencer connection manager, Copyright (C) 1999-2000
Takashi Iwai

Usage
-----

` `

       Usage:
        * Connection/disconnection betwen two ports
          aconnect [-options] sender receiver
            sender, receiver = client:port pair
            -d,--disconnect     disconnect
            -e,--exclusive      exclusive connection
            -r,--real #         convert real-time-stamp on queue
            -t,--tick #         convert tick-time-stamp on queue
        * List connected ports (no subscription action)
          aconnect -i|-o [-options]
            -i,--input          list input (readable) ports
            -o,--output         list output (writable) ports
            -l,--list           list current connections of each port
        * Remove all exported connections
            -x, --removeall

Use '*aconnect -lio* to see all i/o ports and connections.

Example (SBlive soundcard)
--------------------------

Here is an example of a SBlive soundcard, the DMIDI distributed daemon,
[LinuxSampler](/LinuxSampler "LinuxSampler") and two copies of
[TiMidity](/TiMidity "TiMidity") running with different configurations
plus [MusE](/MusE "MusE") listening to the timer and a MIDI keyboard and
outputting to all 3 [SoftSynths](/SoftSynths "SoftSynths") as well as
the keyboard. The external keyboard on the SBlives MIDI input (in this
case, on the front panel of a [LiveDrive](/LiveDrive "LiveDrive")) was
set up with **aconnect 64:0 129:0** to be able to play a
[GigaSampler](/GigaSampler "GigaSampler") piano sound font via
LinuxSampler. The MusE settings were setup from within the MusE program
itself.

` `

       # aconnect -lio
       client 0: 'System' [type=kernel]
           0 'Timer           '
           1 'Announce        '
               Connecting To: 131:0
       client 64: 'Rawmidi 0 - EMU10K1 MPU-401 (UART)' [type=kernel]
           0 'EMU10K1 MPU-401 (UART)'
               Connecting To: 129:0, 131:0
               Connected From: 131:0
       client 65: 'Emu10k1 WaveTable' [type=kernel]
           0 'Emu10k1 Port 0  '
           1 'Emu10k1 Port 1  '
           2 'Emu10k1 Port 2  '
           3 'Emu10k1 Port 3  '
       client 128: 'DMIDI' [type=user]
           0 'DMIDI - Receive: [ff:ff:ff:ff]'
           1 'DMIDI - Transmit [ff:ff:ff:ff]'
       client 129: 'LinuxSampler' [type=user]
           0 'LinuxSampler    '
               Connected From: 64:0, 131:0
       client 130: 'Client-130' [type=user]
           0 'TiMidity port 0 '
               Connected From: 131:0
           1 'TiMidity port 1 '
               Connected From: 131:0
       client 131: 'MusE Sequencer' [type=user]
           0 'MusE Port 0     '
               Connecting To: 130:0, 130:1, 64:0, 129:0
               Connected From: 0:1, 64:0

A simplistic guideline for the client numbers used above is...

-   0..63: for internal use (0 = system, 63 = OSS sequencer emulation)
-   64..127: device drivers (up to 8 for each card)
-   128..?: user applications

(thanks to Clemens Ladisch on the alsa-users mailing-list)

Retrieved from
"[http://alsa.opensrc.org/Aconnect](http://alsa.opensrc.org/Aconnect)"

[Category](/Special:Categories "Special:Categories"):
[Alsa-utils](/Category:Alsa-utils "Category:Alsa-utils")

