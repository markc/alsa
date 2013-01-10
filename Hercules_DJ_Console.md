Hercules DJ Console
===================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

The Hercules DJ Console is an external 5.1 channel usb-soundcard with a
midi-interface and some midi-controllers. As of today ALSA doesn't
support this product very well.

Contents
--------

-   [1 MIDI support](#MIDI_support)
-   [2 External links:](#External_links:)
-   [3 Misc Info](#Misc_Info)
-   [4 Alsa 1.0.9](#Alsa_1.0.9)

MIDI support
------------

MIDI support did work in 1.0.9, but not in latest CVS any longer. Fails
with the error message: ` `

    ALSA /home/nano/devel/alsa/alsa-driver/usb/usbmidi.c:1600: invalid quirk type 2
    snd-usb-audio: probe of 1-1:1.3 failed with error -5

External links:
---------------

-   [http://www.openjay.org/modules.php?name=News&file=article&sid=24](http://www.openjay.org/modules.php?name=News&file=article&sid=24)
-   [http://europe.hercules.com/showpage.php?p=100](http://europe.hercules.com/showpage.php?p=100)

-   Asahi Kasei, AKM AK4529VQ. A high performance multi-channel audio
    codec.
    [http://www.akm.com/datasheets/ek4529.pdf](http://www.akm.com/datasheets/ek4529.pdf)
-   Texas Instruments, TUSB3200AC. A USB Streaming Controller.
    [http://focus.ti.com/docs/prod/folders/print/tusb3200.html](http://focus.ti.com/docs/prod/folders/print/tusb3200.html)
-   Cirrus Logic, CS8427. A stereo digital audio transceiver.
    [http://www.cirrus.com/en/products/pro/detail/P51.html](http://www.cirrus.com/en/products/pro/detail/P51.html)

Misc Info
---------

Misc info (alsa 1.0.10rc1): ` `

    $> alsamixer -c1
    alsamixer: function snd_mixer_load failed: Invalid argument

    $> amixer -c1
    amixer: Mixer hw:1 load error: Invalid argument

    $> amixer -c1 controls
    numid=1,iface=MIXER,name="PCM Playback Switch"
    numid=2,iface=MIXER,name="PCM Playback Volume"
    numid=3,iface=MIXER,name="Delay Control"

    $> amixer -c1 contents
    numid=1,iface=MIXER,name="PCM Playback Switch"
      ; type=BOOLEAN,access=rw---,values=6
      : values=on,on,on,on,on,on
    numid=2,iface=MIXER,name="PCM Playback Volume"
      ; type=INTEGER,access=rw---,values=6,min=0,max=181,step=0
      : values=181,181,181,181,181,181
    numid=3,iface=MIXER,name="Delay Control"
      ; type=INTEGER,access=rw---,values=1,min=0,max=1,step=0
    amixer: Control hw:1 element read error: Invalid argument

    $> amixer -c1 cget numid=1
    numid=1,iface=MIXER,name="PCM Playback Switch"
      ; type=BOOLEAN,access=rw---,values=6
      : values=on,on,on,on,on,on

    $> amixer -c1 cget numid=2
    numid=2,iface=MIXER,name="PCM Playback Volume"
      ; type=INTEGER,access=rw---,values=6,min=0,max=181,step=0
      : values=181,181,181,181,181,181

    $> amixer -c1 cget numid=3
    numid=3,iface=MIXER,name="Delay Control"
      ; type=INTEGER,access=rw---,values=1,min=0,max=1,step=0
    amixer: Control hw:1 element read error: Invalid argument


    $> amidi -l
    Device    Name
    hw:0,0,0  Hercules DJ Console MIDI 1
    hw:0,0,1  Hercules DJ Console MIDI 2



    $> lsusb -v
    Bus 001 Device 002: ID 06f8:d002 Guillemot Corp. 
    Device Descriptor:
     bLength                18
     bDescriptorType         1
     bcdUSB               1.10
     bDeviceClass            0 (Defined at Interface level)
     bDeviceSubClass         0 
     bDeviceProtocol         0 
     bMaxPacketSize0         8
     idVendor           0x06f8 Guillemot Corp.
     idProduct          0xd002 
     bcdDevice            1.00
     iManufacturer           1 
     iProduct                2 
     iSerial                 0 
     bNumConfigurations      1
     Configuration Descriptor:
       bLength                 9
       bDescriptorType         2
       wTotalLength          316
       bNumInterfaces          4
       bConfigurationValue     1
       iConfiguration          0 
       bmAttributes         0x80
       MaxPower              300mA
       Interface Descriptor:
         bLength                 9
         bDescriptorType         4
         bInterfaceNumber        0
         bAlternateSetting       0
         bNumEndpoints           0
         bInterfaceClass         1 Audio
         bInterfaceSubClass      1 Control Device
         bInterfaceProtocol      0 
         iInterface              0 
         AudioControl Interface Descriptor:
           bLength                10
           bDescriptorType        36
           bDescriptorSubtype      1 (HEADER)
           bcdADC               1.00
           wTotalLength           88
           bInCollection           2
           baInterfaceNr( 0)       1
           baInterfaceNr( 1)       2
         AudioControl Interface Descriptor:
           bLength                12
           bDescriptorType        36
           bDescriptorSubtype      2 (INPUT_TERMINAL)
           bTerminalID             5
           wTerminalType      0x0101 USB Streaming
           bAssocTerminal          0
           bNrChannels             6
           wChannelConfig     0x003f
             Left Front (L)
             Right Front (R)
             Center Front (C)
             Low Freqency Enhancement (LFE)
             Left Surround (LS)
             Right Surround (RS)
           iChannelNames           0 
           iTerminal               0 
         AudioControl Interface Descriptor:
           bLength                14
           bDescriptorType        36
           bDescriptorSubtype      6 (FEATURE_UNIT)
           bUnitID                 6
           bSourceID               5
           bControlSize            1
           bmaControls( 0)      0x00
           bmaControls( 1)      0x03
             Mute
             Volume
           bmaControls( 2)      0x03
             Mute
             Volume
           bmaControls( 3)      0x03
             Mute
             Volume
           bmaControls( 4)      0x03
             Mute
             Volume
           bmaControls( 5)      0x03
             Mute
             Volume
           bmaControls( 6)      0x03
             Mute
             Volume
           iFeature                0 
         AudioControl Interface Descriptor:
           bLength                 9
           bDescriptorType        36
           bDescriptorSubtype      3 (OUTPUT_TERMINAL)
           bTerminalID             7
           wTerminalType      0x0301 Speaker
           bAssocTerminal          0
           bSourceID               6
           iTerminal               0 
         AudioControl Interface Descriptor:
           bLength                12
           bDescriptorType        36
           bDescriptorSubtype      2 (INPUT_TERMINAL)
           bTerminalID             1
           wTerminalType      0x0603 Line Connector
           bAssocTerminal          0
           bNrChannels             2
           wChannelConfig     0x0003
             Left Front (L)
             Right Front (R)
           iChannelNames           0 
           iTerminal               0 
         AudioControl Interface Descriptor:
           bLength                10
           bDescriptorType        36
           bDescriptorSubtype      6 (FEATURE_UNIT)
           bUnitID                 2
           bSourceID               1
           bControlSize            1
           bmaControls( 0)      0x80
             Delay
           bmaControls( 1)      0x00
           bmaControls( 2)      0x00
           iFeature                0 
         AudioControl Interface Descriptor:
           bLength                12
           bDescriptorType        36
           bDescriptorSubtype      4 (MIXER_UNIT)
           bUnitID                 3
           bNrInPins               1
           baSourceID( 0)          2
           bNrChannels             2
           wChannelConfig     0x0003
             Left Front (L)
             Right Front (R)
           iChannelNames           0 
           bmControls         0x00
           iMixer                  0 
         AudioControl Interface Descriptor:
           bLength                 9
           bDescriptorType        36
           bDescriptorSubtype      3 (OUTPUT_TERMINAL)
           bTerminalID             4
           wTerminalType      0x0101 USB Streaming
           bAssocTerminal          0
           bSourceID               3
           iTerminal               0 
       Interface Descriptor:
         bLength                 9
         bDescriptorType         4
         bInterfaceNumber        1
         bAlternateSetting       0
         bNumEndpoints           0
         bInterfaceClass         1 Audio
         bInterfaceSubClass      2 Streaming
         bInterfaceProtocol      0 
         iInterface              0 
       Interface Descriptor:
         bLength                 9
         bDescriptorType         4
         bInterfaceNumber        1
         bAlternateSetting       1
         bNumEndpoints           1
         bInterfaceClass         1 Audio
         bInterfaceSubClass      2 Streaming
         bInterfaceProtocol      0 
         iInterface              0 
         AudioStreaming Interface Descriptor:
           bLength                 7
           bDescriptorType        36
           bDescriptorSubtype      1 (AS_GENERAL)
           bTerminalLink           5
           bDelay                  1 frames
           wFormatTag              1 PCM
         AudioStreaming Interface Descriptor:
           bLength                11
           bDescriptorType        36
           bDescriptorSubtype      2 (FORMAT_TYPE)
           bFormatType             1 (FORMAT_TYPE_I)
           bNrChannels             6
           bSubframeSize           2
           bBitResolution         16
           bSamFreqType            1 Discrete
           tSamFreq[ 0]        48000
         Endpoint Descriptor:
           bLength                 9
           bDescriptorType         5
           bEndpointAddress     0x01  EP 1 OUT
           bmAttributes            9
             Transfer Type            Isochronous
             Synch Type               Adaptive
             Usage Type               Data
           wMaxPacketSize     0x0240  1x 576 bytes
           bInterval               1
           bRefresh                0
           bSynchAddress           0
           AudioControl Endpoint Descriptor:
             bLength                 7
             bDescriptorType        37
             bDescriptorSubtype      1 (EP_GENERAL)
             bmAttributes         0x01
               Sampling Frequency
             bLockDelayUnits         0 Undefined
             wLockDelay              0 Undefined
       Interface Descriptor:
         bLength                 9
         bDescriptorType         4
         bInterfaceNumber        2
         bAlternateSetting       0
         bNumEndpoints           0
         bInterfaceClass         1 Audio
         bInterfaceSubClass      2 Streaming
         bInterfaceProtocol      0 
         iInterface              0 
       Interface Descriptor:
         bLength                 9
         bDescriptorType         4
         bInterfaceNumber        2
         bAlternateSetting       1
         bNumEndpoints           1
         bInterfaceClass         1 Audio
         bInterfaceSubClass      2 Streaming
         bInterfaceProtocol      0 
         iInterface              0 
         AudioStreaming Interface Descriptor:
           bLength                 7
           bDescriptorType        36
           bDescriptorSubtype      1 (AS_GENERAL)
           bTerminalLink           4
           bDelay                  1 frames
           wFormatTag              1 PCM
         AudioStreaming Interface Descriptor:
           bLength                11
           bDescriptorType        36
           bDescriptorSubtype      2 (FORMAT_TYPE)
           bFormatType             1 (FORMAT_TYPE_I)
           bNrChannels             2
           bSubframeSize           2
           bBitResolution         16
           bSamFreqType            1 Discrete
           tSamFreq[ 0]        48000
         Endpoint Descriptor:
           bLength                 9
           bDescriptorType         5
           bEndpointAddress     0x81  EP 1 IN
           bmAttributes           13
             Transfer Type            Isochronous
             Synch Type               Synchronous
             Usage Type               Data
           wMaxPacketSize     0x00c0  1x 192 bytes
           bInterval               1
           bRefresh                0
           bSynchAddress           0
           AudioControl Endpoint Descriptor:
             bLength                 7
             bDescriptorType        37
             bDescriptorSubtype      1 (EP_GENERAL)
             bmAttributes         0x01
               Sampling Frequency
             bLockDelayUnits         0 Undefined
             wLockDelay              0 Undefined
       Interface Descriptor:
         bLength                 9
         bDescriptorType         4
         bInterfaceNumber        3
         bAlternateSetting       0
         bNumEndpoints           2
         bInterfaceClass         1 Audio
         bInterfaceSubClass      3 MIDI Streaming
         bInterfaceProtocol      0 
         iInterface              0 
         MIDIStreaming Interface Descriptor:
           bLength                 7
           bDescriptorType        36
           bDescriptorSubtype      1 (HEADER)
           bcdADC               1.00
           wTotalLength           97
         MIDIStreaming Interface Descriptor:
           bLength                 6
           bDescriptorType        36
           bDescriptorSubtype      2 (MIDI_IN_JACK)
           bJackType               2 External
           bJackID                 2
           iJack                   0 
         MIDIStreaming Interface Descriptor:
           bLength                 6
           bDescriptorType        36
           bDescriptorSubtype      2 (MIDI_IN_JACK)
           bJackType               1 Embedded
           bJackID                 1
           iJack                   0 
         MIDIStreaming Interface Descriptor:
           bLength                 9
           bDescriptorType        36
           bDescriptorSubtype      3 (MIDI_OUT_JACK)
           bJackType               1 Embedded
           bJackID                 0
           bNrInputPins            1
           baSourceID( 0)          2
           BaSourcePin( 0)         1
           iJack                   0 
         MIDIStreaming Interface Descriptor:
           bLength                 9
           bDescriptorType        36
           bDescriptorSubtype      3 (MIDI_OUT_JACK)
           bJackType               2 External
           bJackID                 8
           bNrInputPins            1
           baSourceID( 0)          1
           BaSourcePin( 0)         1
           iJack                   0 
         MIDIStreaming Interface Descriptor:
           bLength                 6
           bDescriptorType        36
           bDescriptorSubtype      2 (MIDI_IN_JACK)
           bJackType               2 External
           bJackID                 6
           iJack                   0 
         MIDIStreaming Interface Descriptor:
           bLength                 6
           bDescriptorType        36
           bDescriptorSubtype      2 (MIDI_IN_JACK)
           bJackType               1 Embedded
           bJackID                 1
           iJack                   0 
         MIDIStreaming Interface Descriptor:
           bLength                 9
           bDescriptorType        36
           bDescriptorSubtype      3 (MIDI_OUT_JACK)
           bJackType               1 Embedded
           bJackID                 1
           bNrInputPins            1
           baSourceID( 0)          6
           BaSourcePin( 0)         1
           iJack                   0 
         MIDIStreaming Interface Descriptor:
           bLength                 9
           bDescriptorType        36
           bDescriptorSubtype      3 (MIDI_OUT_JACK)
           bJackType               2 External
           bJackID                 8
           bNrInputPins            1
           baSourceID( 0)          1
           BaSourcePin( 0)         1
           iJack                   0 
         Endpoint Descriptor:
           bLength                 9
           bDescriptorType         5
           bEndpointAddress     0x82  EP 2 IN
           bmAttributes            2
             Transfer Type            Bulk
             Synch Type               None
             Usage Type               Data
           wMaxPacketSize     0x0004  1x 4 bytes
           bInterval               0
           bRefresh                0
           bSynchAddress           0
           MIDIStreaming Endpoint Descriptor:
             bLength                 6
             bDescriptorType        37
             bDescriptorSubtype      1 (GENERAL)
             bNumEmbMIDIJack         2
             baAssocJackID( 0)       0
             baAssocJackID( 1)       1
         Endpoint Descriptor:
           bLength                 9
           bDescriptorType         5
           bEndpointAddress     0x02  EP 2 OUT
           bmAttributes            2
             Transfer Type            Bulk
             Synch Type               None
             Usage Type               Data
           wMaxPacketSize     0x0004  1x 4 bytes
           bInterval               0
           bRefresh                0
           bSynchAddress           0
           MIDIStreaming Endpoint Descriptor:
             bLength                 6
             bDescriptorType        37
             bDescriptorSubtype      1 (GENERAL)
             bNumEmbMIDIJack         2
             baAssocJackID( 0)       0
             baAssocJackID( 1)       1

    $/proc/asound> cat *
    0 [Console        ]: USB-Audio - Hercules DJ Console
                        Hercules Hercules DJ Console at usb-0000:00:1d.0-1, full speed
    1 [I82801CAICH3   ]: ICH - Intel 82801CA-ICH3
                        Intel 82801CA-ICH3 with CS4205 at 0xd800, irq 5
    2 [Modem          ]: ICH-MODEM - Intel 82801CA-ICH3 Modem
                        Intel 82801CA-ICH3 Modem at 0xd400, irq 5
    16: [0- 0]: digital audio playback
    24: [0- 0]: digital audio capture
     0: [0- 0]: ctl
     8: [0- 0]: raw midi
    33:       : timer
    57: [1- 1]: digital audio capture
    48: [1- 0]: digital audio playback
    56: [1- 0]: digital audio capture
    32: [1- 0]: ctl
    80: [2- 0]: digital audio playback
    88: [2- 0]: digital audio capture
    64: [2- 0]: ctl
    0 snd_usb_audio
    1 snd_intel8x0
    2 snd_intel8x0m
    00-00: USB Audio : USB Audio : playback 1 : capture 1
    01-00: Intel ICH : Intel 82801CA-ICH3 : playback 1 : capture 1
    01-01: Intel ICH - MIC ADC : Intel 82801CA-ICH3 - MIC ADC : capture 1
    02-00: Intel ICH - Modem : Intel 82801CA-ICH3 Modem - Modem : playback 1 : capture 1
    G0: system timer : 1000.000us (10000000 ticks)
    P0-0-0: PCM playback 0-0-0 : SLAVE
    P0-0-1: PCM capture 0-0-1 : SLAVE
    P1-0-0: PCM playback 1-0-0 : SLAVE
    P1-0-1: PCM capture 1-0-1 : SLAVE
    P1-1-1: PCM capture 1-1-1 : SLAVE
    P2-0-0: PCM playback 2-0-0 : SLAVE
    P2-0-1: PCM capture 2-0-1 : SLAVE
    Advanced Linux Sound Architecture Driver Version 1.0.9rc2  (Thu Mar 24 10:33:39 2005 UTC).

    $/proc/asound/card0> cat *
    Console
    Hercules DJ Console

    Output 0
     Tx bytes     : 0
    Output 1
     Tx bytes     : 0
    Input 0
     Rx bytes     : 0
    Input 1
     Rx bytes     : 0
    VOLUME "" 0
    BASS "" 0
    TREBLE "" 0
    SYNTH "" 0
    PCM "PCM" 0
    SPEAKER "" 0
    LINE "" 0
    MIC "" 0
    CD "" 0
    IMIX "" 0
    ALTPCM "" 0
    RECLEV "" 0
    IGAIN "" 0
    OGAIN "" 0
    LINE1 "" 0
    LINE2 "" 0
    LINE3 "" 0
    DIGITAL1 "" 0
    DIGITAL2 "" 0
    DIGITAL3 "" 0
    PHONEIN "" 0
    PHONEOUT "" 0
    VIDEO "" 0
    RADIO "" 0
    MONITOR "" 0
    Hercules Hercules DJ Console at usb-0000:00:1d.0-1, full speed : USB Audio

    Playback:
     Status: Stop
     Interface 1
       Altset 1
       Format: S16_LE
       Channels: 6
       Endpoint: 1 OUT (ADAPTIVE)
       Rates: 48000

    Capture:
     Status: Stop
     Interface 2
       Altset 1
       Format: S16_LE
       Channels: 2
       Endpoint: 1 IN (SYNC)
       Rates: 48000
    001/002
    06f8:d002

    $/proc/asound/seq> cat *
     Client info
       cur  clients : 3
       peak clients : 3
       max  clients : 192

     Client   0 : "System" [Kernel]
       Port   0 : "Timer" (Rwe-)
       Port   1 : "Announce" (R-e-)
         Connecting To: 63:0
     Client  62 : "Midi Through" [Kernel]
       Port   0 : "Midi Through Port-0" (RWe-)
     Client  63 : "OSS sequencer" [Kernel]
       Port   0 : "Receiver" (-we-)
         Connected From: 0:1
     snd-seq-oss,loaded,0
     snd-seq-midi,loaded,0
     OSS sequencer emulation version 0.1.8
     ALSA client number 63
     ALSA receiver port 0

     Number of applications: 0

     Number of synth devices: 0

     Number of MIDI devices: 1

     midi 0: [Midi Through Port-0] ALSA port 62:0
       capability read/write / opened none

Alsa 1.0.9
----------

With alsa 1.0.9 midi works, I can read the controls on the device and
connecting a synth to the midiport on the usb card works well, able to
read the midi signals from the synth: ` `

    Client info
      cur  clients : 3
      peak clients : 3
      max  clients : 192

    Client   0 : "System" [Kernel]
      Port   0 : "Timer" (Rwe-)
      Port   1 : "Announce" (R-e-)
        Connecting To: 63:0
    Client  63 : "OSS sequencer" [Kernel]
      Port   0 : "Receiver" (-we-)
        Connected From: 0:1
    Client  64 : "Hercules DJ Console" [Kernel]
      Port   0 : "Hercules DJ Console MIDI 1" (RWeX)
      Port   1 : "Hercules DJ Console MIDI 2" (RWeX)
    snd-seq-midi,loaded,1
    snd-seq-oss,loaded,0
    OSS sequencer emulation version 0.1.8
    ALSA client number 63
    ALSA receiver port 0

    Number of applications: 0

Retrieved from
"[http://alsa.opensrc.org/Hercules\_DJ\_Console](http://alsa.opensrc.org/Hercules_DJ_Console)"

[Category](/Special:Categories "Special:Categories"): [Sound
cards](/Category:Sound_cards "Category:Sound cards")

