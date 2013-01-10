Udev
====

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

udev is the standard way of managing /dev directories, designed to clear
up some issues with previous /dev implementations, and provide a robust
path forward.

Contents
--------

-   [1 Writing Udev rules for Alsa](#Writing_Udev_rules_for_Alsa)
    -   [1.1 A working example](#A_working_example)
    -   [1.2 Example to map USB Ports to ALSA card numbers and add each
        sound card to a combined, single interface
        device](#Example_to_map_USB_Ports_to_ALSA_card_numbers_and_add_each_sound_card_to_a_combined.2C_single_interface_device)
        -   [1.2.1 Combine all cards into a single virtual
            device](#Combine_all_cards_into_a_single_virtual_device)

    -   [1.3 Query information about your audio
        devices](#Query_information_about_your_audio_devices)
    -   [1.4 Writing udev rules](#Writing_udev_rules)
        -   [1.4.1 Identify two identical audio
            devices](#Identify_two_identical_audio_devices)
        -   [1.4.2 Upload firmware](#Upload_firmware)

-   [2 Simple udev rules](#Simple_udev_rules)
    -   [2.1 See also](#See_also)

Writing Udev rules for Alsa
===========================

udev rules are flexible and very powerful. Writing udev rules should
solve common Alsa problems, reported by several people:

-   Assign several audio devices the same hwplug:x,y numbers, whenever
    you plug-in or plug-out a device.
-   Identify two identical audio devices using the product ID or the USB
    bus ID of the device.
-   Upload firmware to a special device.

\

A working example
-----------------

This script has to be called by udev, and allows for arbitrary naming
(actually, numbering) of multiple (identical or not) usb soundcards.

The number each card will get is hardcoded into the script, and is
selected by the physical usb port, hub, bus to which the soundcard is
connected to.

(Eg. the soundcard that you connect to the third port of the second hub
will always get the same number, also if you plug and unplug it, reboot,
etc. But if you connect it to a different port, or hub, it will get a
different name).

You have to edit the script to suit your hub-usb ports and the
corresponding soundcard numbering. The script is commented (to help you
customize it).

Then you have to edit the right rules file udev is using for ALSA naming
(Ubuntu: /etc/udev/rules.d/20-names.rules CentOS:
/etc/udev/rules.d/50-udev.rules Other Linuxes: ...?) and insert the 4
rules you find at the beginning of the script BEFORE the regular ALSA
rules.

If you have ideas, suggestions, or improvements, please edit this page
or email me.

`/usb/bin/alsa_name.pl` ` `

    #!/usr/bin/perl
    # fixed and persistent naming for multiple (identical or not) usb soundcards, 
    # based on which port-hub-usbbus they connect to
    #
    # gmaruzz (at) celliax.org 
    #
    # This is to be executed by udev with the following rules:
    #KERNEL=="controlC[0-9]*", DRIVERS=="usb", PROGRAM="/usr/bin/alsa_name.pl %k", NAME="snd/%c{1}"
    #KERNEL=="hwC[D0-9]*", DRIVERS=="usb", PROGRAM="/usr/bin/alsa_name.pl %k", NAME="snd/%c{1}"
    #KERNEL=="midiC[D0-9]*", DRIVERS=="usb", PROGRAM="/usr/bin/alsa_name.pl %k", NAME="snd/%c{1}"
    #KERNEL=="pcmC[D0-9cp]*", DRIVERS=="usb", PROGRAM="/usr/bin/alsa_name.pl %k", NAME="snd/%c{1}"
    #
    use strict;
    use warnings;
    #
    my $alsaname = $ARGV[0]; #udev called us with this argument (%k)
    my $physdevpath = $ENV{PHYSDEVPATH}; #udev put this in our environment
    my $alsanum = "cucu";
    #you can find the physdevpath of a device with "udevinfo -a -p $(udevinfo -q path -n /dev/snd/pcmC0D0c)"
    #
    #
    $physdevpath =~ s/.*\/([^\/]*)/$1/; #eliminate until last slash (/)
    $physdevpath =~ s/([^:]*):.*/$1/; #eliminate from colon (:) to end_of_line
    #
    if($physdevpath eq "1-5.2") # you can find this value with "dmesg"
    {
           $alsanum="11"; #start from "10" (easier for debugging), "0" is for motherboard soundcard, max is "31"
    }
    if($physdevpath eq "1-5.3") # you can find this value with "dmesg"
    {
           $alsanum="12"; #start from "10" (easier for debugging), "0" is for motherboard soundcard, max is "31"
    }
    if($physdevpath eq "1-5.4") # you can find this value with "dmesg"
    {
           $alsanum="13"; #start from "10" (easier for debugging), "0" is for motherboard soundcard, max is "31"
    }
    if($physdevpath eq "3-2") # you can find this value with "dmesg"
    {
           $alsanum="14"; #start from "10" (easier for debugging), "0" is for motherboard soundcard, max is "31"
    }
    # other bus positions....
    #
    if($alsanum ne "cucu")
    {
           $alsaname=~ s/(.*)C([0-9]+)(.*)/$1C$alsanum$3/;
    }
    #
    print $alsaname;
    exit 0;

Example to map USB Ports to ALSA card numbers and add each sound card to a combined, single interface device
------------------------------------------------------------------------------------------------------------

What this does is allow you to define a configuration file that maps
sound cards plugged into particular USB ports to a pre-defined alsa card
numbers. It also can use this configuration file to create an
/etc/asound.conf ALSA configuration that effectively combines all the
sound cards from the confiruation into a single, logical, multi-card
interface that can be used by programs such as JACKd. In other words, it
can also assign several sound cards to a single virtual card.

So for my setup I wanted 5 completely identical soundcards to always be
assigned the exact same card number when plugged into certain ports. The
idea is that I have 5 USB ports in the back of my PC, and everytime I
plug any one of my identical soundcards into a particular USB port, I
want it to always be assigned the same ALSA card number. For my system I
am creating a simple MP3 playing sound server that will play songs to
various rooms in my house. I need to be positive which room corresponds
to which sound card, so this is the only solution I could come up with.
That pretty much sums up this WIKI page!

I struggled a bit with the above example because I am not familiar with
PERL and my system (Gentoo, 2.6.28, udevd --version 124) did not contain
a PHYDEVPATH variable when calling "udevinfo -a -p \$(udevinfo -q path
-n /dev/snd/pcmC0D0c)". It turns out my system puts the usb port in the
KERNELS paramter - perhaps a newer version of udev. Also, rather than
pulling it from the environment, I discovered that the udev rule could
use "%b" to pass the USB port to my program. Also, I wanted to be able
to easily modify and determine the current Port to card number pairings
at boot time without having to parse through a series of if/elseif
combinations in a script. I don't know PERL, so I did it in C++.

What I created was a slightly more advanced C++ example (compared to the
above PERL example) that uses a separate configuration file for storing
the combination of USB ports to ALSA card numbers. I am using a separate
config file so that the USB port, cardID mapping can easily be
manipulated and retrieved by another program. Here is what it needs to
look like:

`File: /etc/audiomux_ports`

` `

    "3-2" 4
    "1-1.2" 3

This maps USB port "3-2" to ALSA card number 4, and USB Port "1-1.2"
(actually a hub port) to ALSA card number 3.

To make sure that udev calls our custom program, create a file that
looks like this:

`File: /etc/udev/rules.d/39-usb-alsa.rules` ` `

    KERNEL=="controlC[0-9]*", DRIVERS=="usb", PROGRAM="/usr/bin/alsa_name %k %b", NAME="snd/%c{1}"
    KERNEL=="hwC[D0-9]*", DRIVERS=="usb", PROGRAM="/usr/bin/alsa_name %k %b", NAME="snd/%c{1}"
    KERNEL=="midiC[D0-9]*", DRIVERS=="usb", PROGRAM="/usr/bin/alsa_name %k %b", NAME="snd/%c{1}"
    KERNEL=="pcmC[D0-9cp]*", DRIVERS=="usb", PROGRAM="/usr/bin/alsa_name %k %b", NAME="snd/%c{1}"

A quick description of this based on my few hours of exerience with
UDEV:

**KERNEL** is the device name that the kernel creates for each sound
card interface. This will be in the form "controlC0" or "pcmC0D0p" for
our sound cards

**DRIVERS**=="USB" simply means that we only execute our program and
attempt to create a link to our sound card interface whenever its a USB
device.

**PROGRAM** is the program we execute to determine if we should
establish a link for this interface. See the code below for the program
that does this. In our case, the program loads all USB port/cardID pairs
from, the configuration file at /etc/audiomux\_ports, and then sees if
the current device's USB port matches any in the configuration. If it
finds a match, the program prints the desired name (which includes the
modified ALSA card number) to stdio and returns 0 to indicate the match
was found. We are passing 2 parameters to our program, %k is the device
name (i.e. controlC0) and %b is the USB port name (i.e. "1-1.2").

**NAME** is the file link we will create to the sound card interface if
everything matches and the PROGRAM returns 0. The %c means that it will
use the value that is printed to stdio by PROGRAM.

And now for the source code that does the rest of the work:

`File: my_source_code.cpp ` ` `

    #include <stdio.h>
    #include <stdlib.h>
    #include <string.h>
    #include <ctype.h>
    #include <vector>
    #include <string>

    using namespace std;
     
    //Simple class/structure that will hold the pairs of USB ports and
    //ALSA card numbers.
    class CardPortPair
    {
    public:
        int cardNum;
        string portName;
    };

    //Function declarations
    int GetDValue(const char *k) ;
    bool isnum(char c);
    int GetCardList(vector<CardPortPair> &list);
    int UdevGetCardNumberForPort(char *k, char *n);
    int CreateAlsaMultiCardConfig(void);

    int main(int argc, char **argv)
    {
           if (argc == 1) //no parameters passed
            return CreateAlsaMultiCardConfig();
        if (argc != 3)  //wrong number of parameters
            return -1;
        
        ///////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        // Create a file in /etc/udev/rules.d (this is the folder in Gentoo) that comes before
        // the Alsa configuration in alphabetical order.  For example, in gentoo I made this file:
        //
        // File: /etc/udev/rules.d/39-usb-alsa.rules
        //
        // KERNEL=="controlC[0-9]*", DRIVERS=="usb", PROGRAM="/usr/bin/alsa_name %k %b", NAME="snd/%c{1}"
        // KERNEL=="hwC[D0-9]*", DRIVERS=="usb", PROGRAM="/usr/bin/alsa_name %k %b", NAME="snd/%c{1}"
        // KERNEL=="midiC[D0-9]*", DRIVERS=="usb", PROGRAM="/usr/bin/alsa_name %k %b", NAME="snd/%c{1}"
        // KERNEL=="pcmC[D0-9cp]*", DRIVERS=="usb", PROGRAM="/usr/bin/alsa_name %k %b", NAME="snd/%c{1}"
        //
        // What this means is that when udev detects a new USB device that matches the KERNEL name (i.e.
        // "controlC2" or "pcmC0D1", it will execute this program, which must be saved and executable
        // as/usr/bin/alsa_name.  Udev will pass the KERNEL name as well as the usb port name as the
        // first two parameters to this program
        //
        ///////////////////////////////////////////////////////////////////////////////////////////////////////
        
        ///////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        // This program uses a simple configuration file to load the BUS address/card number pairs
        // so that whenever a USB sound card device gets plugged into a certain USB port, it will
        // always be assigned the same card number.  Do not use a card number <0 or >31
        //
        // File: /etc/audiomux_ports
        //
        // "3-2" 4    #This means that USB port "3-2" will get assigned alsa card number 4
        // "1-1.2" 3  #And USB port "1-1.2" will get assigned alsa card number 3
        //
        ////////////////////////////////////////////////////////////////////////////////////////////////////
        
        

        //Arg1 is the kernel device name (i.e. "controlC0" or "pcmC0D0p")
        //Arg2 is the KERNELS name, for usb this is the port name (i.e. "3-2" or "1-1.2")
        return UdevGetCardNumberForPort(argv[1], argv[2]);  
    }

    //Search for matching USB port/Alsa cardnum pairs and print the appropriate
    //value to stdio so that udev can retrieve the value and set the appropriate
    //entry.
    int UdevGetCardNumberForPort(char *k, char *n)
    {
        vector<CardPortPair> list;
        GetCardList(list);
        string sn = n;

        int size = list.size();
        for (int i = 0; i < size; ++i) {
            if (list[i].portName == sn) {
                if (!strncmp("controlC", k, 8)) {  //control interface
                    printf("controlC%d\n", list[i].cardNum);
                    return 0;
                } else if (!strncmp("pcmC", k, 4)) { //playback or capture interface                
                    if (k[strlen(k) - 1] == 'p') {
                        printf("pcmC%dD%dp\n", list[i].cardNum, GetDValue(k));  //Recreate the name w/ our custom card number
                        return 0;
                    } else if (k[strlen(k) - 1] == 'c') {
                        printf("pcmC%dD%dc\n", list[i].cardNum, GetDValue(k));  //Recreate the name w/ our custom card number
                        return 0;
                    }
                    return -1;
                } else if (!strncmp("hwC", k, 3)) {  //THIS IS UNTESTED SINCE I DON'T HAVE A USB CARD WITH hwC INTERFACE                
                    printf("hwC%dD%d\n", list[i].cardNum, GetDValue(k));                
                } else if (!strncmp("midiC", k, 5)) { //THIS IS UNTESTED SINCE I DON'T HAVE A USB CARD WITH midiC INTERFACE             
                    printf("midiC%dD%d\n", list[i].cardNum, GetDValue(k));
                }
            }
        }

        return -1;
    }

    //Retrieve the subdevice value, whith comes after the capital D
    //in the device name, (i.e. pcmC0D1).
    int GetDValue(const char *k) 
    {
        char *p = strrchr((const char *)k, 'D');
        if (!p) {
            return -1;
        }
        p++;
        int d = strtol(p, NULL, 0);
        if (d < 0 || d > 32)
            return 0;
        
        return d;
    }

    //Retrieve a list of USB port name/Alsa card number pairs
    //from a file located at "/etc/audiomux_ports".
    //If a USB sound card is detected at a certain USB port, it will
    //always be assigned the matching card number
    int GetCardList(vector<CardPortPair> &list)
    {
        char buffer[500];
        FILE *f = fopen("/etc/audiomux_ports", "r");
        if (!f)
            return -1;

        while (!feof(f)) {
            char *p = fgets(buffer, 500, f);
            if (!p)
               continue;

            //Skip to first quote
            while (*p && *p != '\"') {
                p++;    
            }
            if (!*p) {
                printf("Invalid line received (1)\n");
                continue;
            }
            p++;
            
            //Skip to 2nd quote
            char *p2 = p;
            while (*p2 && *p2 != '\"') {
                p2++;
            }
            if (!*p2) {
                printf("Invalid line received (2)\n");
                continue;
            }
            *p2 = 0;

            //Retrieve name
            string name = p;

            //Skip to channel number
            p = p2 + 1;
            while (*p && !isnum(*p)) {
                p++;
            }
            if (!*p) {
                printf("Invalid line received (3)\n");
                continue;
            }
            int num = strtol(p, NULL, 0);
            if (num < 1 || num > 31) {
                printf("Invalid cardNum received\n");
                continue;
            }

            CardPortPair c;
            c.cardNum = num;
            c.portName = name;
            list.push_back(c);
        }

        fclose(f);

    }

    //I couldn't remember the C function to detect numeric chars!!
    bool isnum(char c) {
        if (c < '0' || c > '9') return false;
        return true;
    }

    //This function creates the /etc/asound.conf file that is necessary
    //to combine all USB sound cards defined by the /etc/audiomux_ports
    //file into a single combined "sound-card".  This assumes that the
    //sound cards each only have one stereo playback device each.
    //
    //This is necessary to use all the sound cards in JACK.  In JACK,
    //the alsa sound device to use will be "ttable".
    int CreateAlsaMultiCardConfig()
    {
        FILE *f = fopen("/etc/asound.conf", "w");
        if (!f) {
            printf("Unexpected error! Could not open .asoundrc");
            return -1;
        }

        vector<CardPortPair> list;
        GetCardList(list);

        fprintf(f, "pcm.multi {\n");
        fprintf(f, "\ttype multi;\n");

        int size = list.size();
        for (int i = 0; i < size; ++i) {
            fprintf(f, "\tslaves.%c.pcm \"hw:%d,0\";\n", 'a' + i, list[i].cardNum);
            fprintf(f, "\tslaves.%c.channels 2;\n", 'a' + i);
        }

        for (int i = 0; i < size; ++i) {     
            fprintf(f, "\tbindings.%d.slave %c;\n", i * 2, 'a' + i);
            fprintf(f, "\tbindings.%d.channel 0;\n", i * 2);
            fprintf(f, "\tbindings.%d.slave %c;\n", i * 2 + 1, 'a' + i);
            fprintf(f, "\tbindings.%d.channel 1;\n", i * 2 + 1);        
        }

        fprintf(f, "}\n");
        fprintf(f, "\n");
        fprintf(f, "ctl.multi {\n");
        fprintf(f, "\ttype hw;\n");
        fprintf(f, "\tcard 0;\n");
        fprintf(f, "}\n");
        fprintf(f, "\n");
        fprintf(f, "pcm.ttable {\n");
        fprintf(f, "\ttype route;\n");
        fprintf(f, "\tslave.pcm \"multi\";\n");
        
        for (int i = 0; i < size; ++i) {
            fprintf(f, "\tttable.%d.%d 1;\n", i * 2, i * 2);
            fprintf(f, "\tttable.%d.%d 1;\n", i * 2 + 1, i * 2 + 1);
        }

        fprintf(f, "}\n");
        fprintf(f, "\n");
        fprintf(f, "ctl.ttable {\n");
        fprintf(f, "\ttype hw;\n");
        fprintf(f, "\tcard 0;\n");
        fprintf(f, "}\n");


     
        fclose(f);

        return 0;
    }

To compile this and save it to the proper directory, do the following.
BTW, you must have gcc installed. ` `

1.  g++ my\_source\_code.cpp -o alsa\_name
2.  cp alsa\_name /usr/bin/alsa\_name

To determine the usb port names to use in your configuration file, just
plug in a device and then run "dmesg". You will see messages printed
everywhere that say something like:
` usb 1-1.2: New USB device found, idVendor=08bb, idProduct=2901` and in
this case the USB port name to use is "1-1.2"

Now when you plug in a sound card to a defined USB port, it should be
assigned the respective card number.

### Combine all cards into a single virtual device

The above code/program has a second purpose in life. When called with no
parameters, it will create an /etc/asound.conf file that combines all
the defined sound cards (from /etc/audiomux\_ports) into a single
logical device. This is required to use all the sound cards in programs
such as JACKd that can not function with multiple cards. In JACK, the
device name to use will be "ttable". You will see 2 playback ports (Left
and Right) for each sound card you define (all cards probably need to be
attached too). Also note that this code only works for 2 channels per
sound card, so if you have a 5.1 sound card, it may only load 2 of the
channels... or it may not work at all.

So to create the multi-device configuration file at /etc/asound.conf,
just run the following

` /usr/bin/alsa_name`

This will read your configuration at /etc/audiomux\_ports and create a
new alsa configuration file that looks like this below. Of course, it
will look different depending on how many sound cards you have and the
card numbers used.

` `

    pcm.multi {
        type multi;
        slaves.a.pcm "hw:4,0";
        slaves.a.channels 2;
        slaves.b.pcm "hw:5,0";
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

    ctl.multi {
        type hw;
        card 0;
    }

    pcm.ttable {
        type route;
        slave.pcm "multi";
        ttable.0.0 1;
        ttable.1.1 1;
        ttable.2.2 1;
        ttable.3.3 1;
    } 

    ctl.ttable {
        type hw;
        card 0;
    } 

That's all... Good luck.

Query information about your audio devices
------------------------------------------

You can use udevadm for that. Example:

    # udevadm info -a -p `udevadm info -q path -n /dev/audio`

will starts with the device specified by the devpath and then walks up
the chain of parent devices. It prints for every device found, all
possible attributes in the udev rules key format. A rule to match, can
be composed by the attributes of the device and the attributes from one
single parent device.

Writing udev rules
------------------

### Identify two identical audio devices

Let's assume we have two identical devices. ALSA will give them the same
ID, with \_1, \_2, … suffixes appended:

    # cat /proc/asound/cards
     4 [UA1A           ]: USB-Audio - EDIROL UA-1A
                          Roland EDIROL UA-1A at usb-0000:00:13.2-6.3, full speed
     5 [UA1A_1         ]: USB-Audio - EDIROL UA-1A
                          Roland EDIROL UA-1A at usb-0000:00:13.2-6.2, full speed

Now we want to change their ID, depending on which port the device is
connected.

First, run the udevadm tool, then plug the device in (for PCI cards,
reload the driver), and check what the device path (DEVPATH) is:

    # udevadm monitor --kernel --property --subsystem-match=sound
    ...
    KERNEL[1305470077.926550] add      /devices/pci0000:00/0000:00:13.2/usb2/2-6/2-6.3/2-6.3:1.0/sound/card4 (sound)
    UDEV_LOG=3
    ACTION=add
    DEVPATH=/devices/pci0000:00/0000:00:13.2/usb2/2-6/2-6.3/2-6.3:1.0/sound/card4
    SUBSYSTEM=sound
    SEQNUM=1434

    KERNEL[1305470077.958511] add      /devices/pci0000:00/0000:00:13.2/usb2/2-6/2-6.3/2-6.3:1.0/sound/card4/pcmC4D0p (sound)
    ...
    KERNEL[1305470078.005760] add      /devices/pci0000:00/0000:00:13.2/usb2/2-6/2-6.3/2-6.3:1.0/sound/card4/pcmC4D0c (sound)
    ...
    KERNEL[1305470078.055299] add      /devices/pci0000:00/0000:00:13.2/usb2/2-6/2-6.3/2-6.3:1.0/sound/card4/controlC4 (sound)
    ...
    KERNEL[1305470078.104122] change   /devices/pci0000:00/0000:00:13.2/usb2/2-6/2-6.3/2-6.3:1.0/sound/card4 (sound)
    ...
    ^C

In this case, the device path of this device is the long string ending
with ".../2-6.3:1.0/sound/card4".

In the sysfs directory of this device is a file "id" that can be used to
change the ALSA sound card ID:

    # echo -n UA1A_B > /sys/devices/pci0000:00/0000:00:13.2/usb2/2-6/2-6.3/2-6.3:1.0/sound/card4/id

Do the same for the other device (note the differences in the device
path):

    # echo -n UA1A_A > /sys/devices/pci0000:00/0000:00:13.2/usb2/2-6/2-6.2/2-6.2:1.0/sound/card5/id
    # cat /proc/asound/cards
     4 [UA1A_B         ]: USB-Audio - EDIROL UA-1A
                          Roland EDIROL UA-1A at usb-0000:00:13.2-6.3, full speed
     5 [UA1A_A         ]: USB-Audio - EDIROL UA-1A
                          Roland EDIROL UA-1A at usb-0000:00:13.2-6.2, full speed

Now we do not want to run these echo commands manually, so we have to do
the same in udev rules.

Create a file like "/etc/udev/rules.d/85-my-usb-audio.rules" with the
following contents:

    SUBSYSTEM!="sound", GOTO="my_usb_audio_end"
    ACTION!="add", GOTO="my_usb_audio_end"

    DEVPATH=="/devices/pci0000:00/0000:00:13.2/usb2/2-6/2-6.2/2-6.2:1.0/sound/card?", ATTR{id}="UA1A_A"
    DEVPATH=="/devices/pci0000:00/0000:00:13.2/usb2/2-6/2-6.3/2-6.3:1.0/sound/card?", ATTR{id}="UA1A_B"

    LABEL="my_usb_audio_end"

The DEVPATH is the same as reported by udevadm, but note that "card4"
was replaced with "card?" to match any random card number. Set the value
of ATTR{id} to whatever you want the ID to be (but use only letters,
digits, and underscores).

Re-plug the devices, and udev should have done its thing:

    # cat /proc/asound/cards
     4 [UA1A_B         ]: USB-Audio - EDIROL UA-1A
                          Roland EDIROL UA-1A at usb-0000:00:13.2-6.3, full speed
     5 [UA1A_A         ]: USB-Audio - EDIROL UA-1A
                          Roland EDIROL UA-1A at usb-0000:00:13.2-6.2, full speed

Now you can use the ID in ALSA device names, where you would otherwise
use a card number:

    $ aplay -D default:UA1A_A something.wav
    Playing WAVE 'something.wav' : Signed 16 bit Little Endian, Rate 44100 Hz, Stereo

Use names like "default:UA1A\_A", "plughw:UA1A\_A", or "hw:UA1A\_A".

### Upload firmware

Simple udev rules
=================

This is an example for an onboard Intel HDA and PCI SB Live, to set the
SB Live as the default card. Put this in /etc/udev/rules.d/030\_alsa
(for Debian, path may vary for other distros): ` `

    DRIVERS=="HDA Intel", KERNEL=="dsp*", NAME="dsp1"
    DRIVERS=="HDA Intel", KERNEL=="adsp*", NAME="adsp1"
    DRIVERS=="HDA Intel", KERNEL=="audio*", NAME="audio1"
    DRIVERS=="HDA Intel", KERNEL=="mixer*", NAME="mixer1"
    DRIVERS=="HDA Intel", KERNEL=="pcmC*D0c", NAME="snd/pcmC1D0c"
    DRIVERS=="HDA Intel", KERNEL=="pcmC*D0p", NAME="snd/pcmC1D0p"
    DRIVERS=="HDA Intel", KERNEL=="pcmC*D1c", NAME="snd/pcmC1D1c"
    DRIVERS=="HDA Intel", KERNEL=="pcmC*D1p", NAME="snd/pcmC1D1p"
    DRIVERS=="HDA Intel", KERNEL=="pcmC*D2c", NAME="snd/pcmC1D2c"
    DRIVERS=="HDA Intel", KERNEL=="controlC*", NAME="snd/controlC1"
    DRIVERS=="EMU10K1_Audigy", KERNEL=="dsp*", NAME="dsp"
    DRIVERS=="EMU10K1_Audigy", KERNEL=="adsp*", NAME="adsp"
    DRIVERS=="EMU10K1_Audigy", KERNEL=="audio*", NAME="audio"
    DRIVERS=="EMU10K1_Audigy", KERNEL=="dmmidi*", NAME="dmmidi"
    DRIVERS=="EMU10K1_Audigy", KERNEL=="admmidi*", NAME="admmidi"
    DRIVERS=="EMU10K1_Audigy", KERNEL=="amidi*", NAME="amidi"
    DRIVERS=="EMU10K1_Audigy", KERNEL=="midi*", NAME="midi"
    DRIVERS=="EMU10K1_Audigy", KERNEL=="mixer*", NAME="mixer"
    DRIVERS=="EMU10K1_Audigy", KERNEL=="controlC*", NAME="snd/controlC0"
    DRIVERS=="EMU10K1_Audigy", KERNEL=="hwC*D0", NAME="snd/hwC0D0"
    DRIVERS=="EMU10K1_Audigy", KERNEL=="hwC*D2", NAME="snd/hwC0D2"
    DRIVERS=="EMU10K1_Audigy", KERNEL=="midiC*D0", NAME="snd/midiC0D0"
    DRIVERS=="EMU10K1_Audigy", KERNEL=="midiC*D1", NAME="snd/midiC0D1"
    DRIVERS=="EMU10K1_Audigy", KERNEL=="midiC*D2", NAME="snd/midiC0D2"
    DRIVERS=="EMU10K1_Audigy", KERNEL=="pcmC*D0c", NAME="snd/pcmC0D0c"
    DRIVERS=="EMU10K1_Audigy", KERNEL=="pcmC*D0p", NAME="snd/pcmC0D0p"
    DRIVERS=="EMU10K1_Audigy", KERNEL=="pcmC*D1c", NAME="snd/pcmC0D1c"
    DRIVERS=="EMU10K1_Audigy", KERNEL=="pcmC*D2p", NAME="snd/pcmC0D2p"
    DRIVERS=="EMU10K1_Audigy", KERNEL=="pcmC*D2c", NAME="snd/pcmC0D2c"
    DRIVERS=="EMU10K1_Audigy", KERNEL=="pcmC*D3p", NAME="snd/pcmC0D3p"

See also
--------

-   While this article is being completed you may want to look at the
    [mailing
    list](http://thread.gmane.org/gmane.linux.alsa.devel/44498), where
    the usage of udev with ALSA has been discussed.
-   [Hotplugging USB audio devices
    (Howto)](/Hotplugging_USB_audio_devices_(Howto) "Hotplugging USB audio devices (Howto)")
-   [MultipleCards](/MultipleCards "MultipleCards")
-   [MultipleUSBAudioDevices](/MultipleUSBAudioDevices "MultipleUSBAudioDevices")

Retrieved from
"[http://alsa.opensrc.org/Udev](http://alsa.opensrc.org/Udev)"

[Category](/Special:Categories "Special:Categories"):
[Howto](/Category:Howto "Category:Howto")

