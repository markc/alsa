Amidi
=====

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

**amidi** is part of the [alsa-utils](/Alsa-utils "Alsa-utils") package.

Usage
-----

` `

       Usage: amidi options
       
       -h, --help             this help
       -V, --version          print current version
       -l, --list-devices     list all hardware ports
       -L, --list-rawmidis    list all RawMIDI definitions
       -p, --port=name        select port by name
       -s, --send=file        send the contents of a (.syx) file
       -r, --receive=file     write received data into a file
       -S, --send-hex="..."   send hexadecimal bytes
       -d, --dump             print received data as hexadecimal bytes
       -t, --timeout=seconds  exits when no data has been received
                              for the specified duration
       -a, --active-sensing   don't ignore active sensing bytes

For further usage details, see...

` `

       man amidi

Examples
--------

Before using amidi, it is important to disconnect all ALSA MIDI
connections of the port to be used. Then ask amidi for all available
ports:

` `

       amidi -l
       
       hw:2,0,0  MidiSport 8x8 MIDI 1
       hw:2,0,1  MidiSport 8x8 MIDI 2
       hw:2,0,2  MidiSport 8x8 MIDI 3
       hw:2,0,3  MidiSport 8x8 MIDI 4
       hw:2,0,4  MidiSport 8x8 MIDI 5
       hw:2,0,5  MidiSport 8x8 MIDI 6
       hw:2,0,6  MidiSport 8x8 MIDI 7
       hw:2,0,7  MidiSport 8x8 MIDI 8
       hw:2,0,8  MidiSport 8x8 Control^

\
 Ensure you have disconnected the ports you like to use using aconnect
or a graphical replacement like the ones found on
[AlsaMidiPatchbays](/AlsaMidiPatchbays "AlsaMidiPatchbays").

\
 You can send a sysex file to the port hw:2,0,3 of the example above by
executing the following command:

\
 ` `

       amidi -p hw:2,0,3 -s BankA-Singles.syx

You can send a manually entered sysex command by typing them as
hexadecimal code:

\
 ` `

       amidi -p hw:2,0,3 -S "F0 00 20 33 00 00 01 07 0F F0"

\
 You can record incoming sysex data to the file Sysexdump.syx using the
following command:

` `

       amidi -p hw:2,0,3 -r Sysexdump.syx

Start the dump using the controls of your device. Press Ctrl - C as soon
as the dump is completed.

\
 You can also ask most devices to send the desired content using a sysex
request command. To do so, open two shell windows. In the first one,
tell amidi to record the incoming sysex data as shown in the example
above:

\
 ` `

       amidi -p hw:2,0,3 -r Sysexdump.syx

In the second one, tell amidi to send the desired sysex request. You can
do so by sending the request manually...

\
 ` `

       amidi -p hw:2,0,3 -S "F0 00 20 33 00 00 0F 01 10 F7"

or via sending a matching sysex file containing the matching command:

` `

       amidi -p hw:2,0,3 -s RequestSingleBank.syx

\
 After the transmission is completed, precc Ctrl - C in the first shell
window.

\

Info from mailing lists
-----------------------

A snippet from the LAU mailing-list:

*I'm trying to upgrade the software version of a Tascam DM-24 digital
mixing consol using amidi. The command is: **amidi -p
\`\`\`hw:1,0,1\`\`\` --send=flash.mid***

**Answer**: amidi does not support SMF .mid files. Use
[aplaymidi](?title=Aplaymidi&action=edit&redlink=1 "Aplaymidi (page does not exist)")
instead.

` `

       #! /bin/bash
       #
       # ========================================================
       #
       # This script configures the 8 offline patchbay programs
       # of an m-audio Midisport 8x8. Copyright (c) March 2005 by
       # Christoph Eckert, mchristoph.eckert@t-online.de
       #
       # This script is published in terms and conditions of the
       # Gnu General Public License (aka GPL).
       #
       # The author published it in the hope it is useful for any
       # other, but without any warranty or any responsibility.
       # Use this script at your own risk.
       # ========================================================
       
       clear
       
       # Some variables:
       HEADER="F0 00 01 05 7F 00 00 04 00 01"
       DATA=""
       END="F7"
       
       # Some functions:
       function inputselect
       {
           # Lets the user choose if he wants to define 
           # connections for one of the inputs
           for i in $(echo "1 2 3 4 5 6 7 8"); do
               echo "Configure input $i?"
               echo ""
               read INOUTEDITYESNO
               if [ "$INOUTEDITYESNO" = "y" ]; then
                   echo ""
                   inputsconnect
               else
                   echo "Input $i won't be connected to any output."
                   echo ""
                   DATA="$DATA 00 00"
                   # echo "DATA now reads as:"
                   # echo "$DATA"
                   echo ""
               fi
           done
       }
       
       function inputsconnect
       {
       # Asks for the outputs the user wants to connect to the
       # chosen input, and writes them into the variable NIBBLE
       
           echo "Defining outputs for input $i."
           echo "Enter y to agree, anything else to skip."
           echo ""
           for j in $(echo "1 2 3 4 5 6 7 8") ; do
               echo "In$i to out$j:"
               echo ""
               read INOUTCONNYESNO
               echo ""
               if [ "$INOUTCONNYESNO" = "y" ]; then
                   NIBBLE="$NIBBLE 1"
               else
                   # echo "Input $i won't be connected to output $j."
                   # echo ""
                   NIBBLE="$NIBBLE 0"
               fi
               # echo "NIBBLE now reads as $NIBBLE"
               if [ $j = "4" ]; then
                   convertnibble
               fi
               if [ $j = "8" ]; then
                   convertnibble
               fi
           done
       }
       
       function convertnibble
       {
       # reads the variable NIBBLE, converts it to
       # HEX and appends it to the variable DATA
       # echo "Converting nibble..."
       
           if [ "$NIBBLE" = " 0 0 0 0" ]; then 
               DATA="$DATA 00"
           fi
           if [ "$NIBBLE" = " 1 0 0 0" ]; then
               DATA="$DATA 01"
           fi
           if [ "$NIBBLE" = " 0 1 0 0" ] ;then
               DATA="$DATA 02"
           fi
           if [ "$NIBBLE" = " 1 1 0 0" ]; then
               DATA="$DATA 03"
           fi
           if [ "$NIBBLE" = " 0 0 1 0" ]; then
               DATA="$DATA 04"
           fi
           if [ "$NIBBLE" = " 1 0 1 0" ]; then
               DATA="$DATA 05"
           fi
           if [ "$NIBBLE" = " 0 1 1 0" ]; then
               DATA="$DATA 06"
           fi
           if [ "$NIBBLE" = " 1 1 1 0" ]; then
               DATA="$DATA 07"
           fi
           if [ "$NIBBLE" = " 0 0 0 1" ]; then
               DATA="$DATA 08"
           fi
           if [ "$NIBBLE" = " 1 0 0 1" ]; then
               DATA="$DATA 09"
           fi
           if [ "$NIBBLE" = " 0 1 0 1" ]; then
               DATA="$DATA 0A"
           fi
           if [ "$NIBBLE" = " 1 1 0 1" ]; then
               DATA="$DATA 0B"
           fi
           if [ "$NIBBLE" = " 0 0 1 1" ]; then
               DATA="$DATA 0C"
           fi
           if [ "$NIBBLE" = " 0 1 1 1" ]; then
               DATA="$DATA 0E"
           fi
           if [ "$NIBBLE" = " 1 1 1 1" ]; then
               DATA="$DATA 0F"
           fi
           # echo "DATA now reads as:"
           # echo "$DATA"
           echo ""
           NIBBLE=""
       }
       
       # Script now starts
       
       echo ""
       echo ""
       
       if DEVICE=$(amidi -l | grep -i MidiSport | grep -i 8x8 | grep -i Control | cut -d ' ' -f 1)
       then
           echo "The \"Midisport 8x8\" has been found as ALSA device \"$DEVICE\"."
           echo ""
       else
           echo 'Sorry, but no Midisport 8x8 has been found.'
           echo ""
           echo "Please ensure that"
           echo ""
           echo "* the Midisport 8x8 is connected to the computer via the USB" 
           echo "* port and it is set to USB mode (see its front panel)"
           echo "* the module snd-usb-audio is loaded (type 'lsmod | cut -d \" \" -f 1 | grep -i snd_usb_audio')"
           echo "* the program fxloader is installed (as root, type 'which fxload' to see if it's installed)"
           echo "* you have installed the USB firmwareloader (see http://usb-midi-fw.sf.net for details)"
           exit 1
           echo ""
       fi
       
       echo "The Midisport 8x8 contains 8 user definable patches."
       echo "Please enter 1 through 8 for the patch you want to setup:"
       echo ""
       
       read PATCHTOEDIT
       PATCHTOEDIT=$(echo "0$PATCHTOEDIT")
       echo ""
       echo "Patch $PATCHTOEDIT selected."
       echo ""
       echo "The Midisport 8x8 has eight MIDI inputs."
       echo "You will be asked for the inputs you want to connect."
       echo "Enter y to configure, anything else to skip one input."
       
       inputselect
       
       SEND="$HEADER $PATCHTOEDIT $DATA $END"
       COMMAND="amidi -p $DEVICE  -S \"$SEND\""
       
       echo ""
       echo "The following command can now be sent to the Midisport:"
       echo ""
       echo "$COMMAND"
       echo ""
       echo "Sending it can cause severe damage of hard- and software as well."
       echo "If you know what you do, copy the above line and execute it."
       echo ""
       
       exit

Retrieved from
"[http://alsa.opensrc.org/Amidi](http://alsa.opensrc.org/Amidi)"

[Category](/Special:Categories "Special:Categories"):
[Alsa-utils](/Category:Alsa-utils "Category:Alsa-utils")

