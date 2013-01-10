UsbPhone
========

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

This phone does not work with snd-usb-audio but works in FreeBSD with
uaudio driver.

When plugging in my noname usb phone I get the next:

` `

    lsusb -v:

    Bus 002 Device 002: ID 1908:1389  
    Device Descriptor:
      bLength                18
      bDescriptorType         1
      bcdUSB               1.10
      bDeviceClass            0 (Defined at Interface level)
      bDeviceSubClass         0 
      bDeviceProtocol         0 
      bMaxPacketSize0         8
      idVendor           0x1908 
      idProduct          0x1389 
      bcdDevice            1.00
      iManufacturer           1 BUILDWIN
      iProduct                2 SKYPE PHONE
      iSerial                 0 
      bNumConfigurations      1
      Configuration Descriptor:
        bLength                 9
        bDescriptorType         2
        wTotalLength          254
        bNumInterfaces          4
        bConfigurationValue     1
        iConfiguration          0 
        bmAttributes         0xa0
          (Bus Powered)
          Remote Wakeup
        MaxPower              200mA
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
            wTotalLength          100
            bInCollection           2
            baInterfaceNr( 0)       1
            baInterfaceNr( 1)       2
          AudioControl Interface Descriptor:
            bLength                12
            bDescriptorType        36
            bDescriptorSubtype      2 (INPUT_TERMINAL)
            bTerminalID             1
            wTerminalType      0x0101 USB Streaming
            bAssocTerminal          0
            bNrChannels             2
            wChannelConfig     0x0003
              Left Front (L)
              Right Front (R)
            iChannelNames           0 
            iTerminal               0 
          AudioControl Interface Descriptor:
            bLength                12
            bDescriptorType        36
            bDescriptorSubtype      2 (INPUT_TERMINAL)
            bTerminalID             2
            wTerminalType      0x0201 Microphone
            bAssocTerminal          0
            bNrChannels             1
            wChannelConfig     0x0001
              Left Front (L)
            iChannelNames           0 
            iTerminal               0 
          AudioControl Interface Descriptor:
            bLength                 9
            bDescriptorType        36
            bDescriptorSubtype      3 (OUTPUT_TERMINAL)
            bTerminalID             6
            wTerminalType      0x0301 Speaker
            bAssocTerminal          0
            bSourceID               9
            iTerminal               0 
          AudioControl Interface Descriptor:
            bLength                 9
            bDescriptorType        36
            bDescriptorSubtype      3 (OUTPUT_TERMINAL)
            bTerminalID             7
            wTerminalType      0x0101 USB Streaming
            bAssocTerminal          0
            bSourceID               8
            iTerminal               0 
          AudioControl Interface Descriptor:
            bLength                 7
            bDescriptorType        36
            bDescriptorSubtype      5 (SELECTOR_UNIT)
            bUnitID                 8
            bNrInPins               1
            baSource( 0)           10
            iSelector               0 
          AudioControl Interface Descriptor:
            bLength                10
            bDescriptorType        36
            bDescriptorSubtype      6 (FEATURE_UNIT)
            bUnitID                 9
            bSourceID              15
            bControlSize            1
            bmaControls( 0)      0x01
              Mute
            bmaControls( 1)      0x02
              Volume
            bmaControls( 2)      0x02
              Volume
            iFeature                0 
          AudioControl Interface Descriptor:
            bLength                 9
            bDescriptorType        36
            bDescriptorSubtype      6 (FEATURE_UNIT)
            bUnitID                10
            bSourceID               2
            bControlSize            1
            bmaControls( 0)      0x43
              Mute
              Volume
              Automatic Gain
            bmaControls( 1)      0x00
            iFeature                0 
          AudioControl Interface Descriptor:
            bLength                 9
            bDescriptorType        36
            bDescriptorSubtype      6 (FEATURE_UNIT)
            bUnitID                13
            bSourceID               2
            bControlSize            1
            bmaControls( 0)      0x03
              Mute
              Volume
            bmaControls( 1)      0x00
            iFeature                0 
          AudioControl Interface Descriptor:
            bLength                13
            bDescriptorType        36
            bDescriptorSubtype      4 (MIXER_UNIT)
            bUnitID                15
            bNrInPins               2
            baSourceID( 0)          1
            baSourceID( 1)         13
            bNrChannels             2
            wChannelConfig     0x0003
              Left Front (L)
              Right Front (R)
            iChannelNames           0 
            bmControls         0x00
            iMixer                  0 
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
            bTerminalLink           1
            bDelay                  1 frames
            wFormatTag              1 PCM
          AudioStreaming Interface Descriptor:
            bLength                11
            bDescriptorType        36
            bDescriptorSubtype      2 (FORMAT_TYPE)
            bFormatType             1 (FORMAT_TYPE_I)
            bNrChannels             1
            bSubframeSize           2
            bBitResolution         16
            bSamFreqType            1 Discrete
            tSamFreq[ 0]        16000
          Endpoint Descriptor:
            bLength                 9
            bDescriptorType         5
            bEndpointAddress     0x02  EP 2 OUT
            bmAttributes            9
              Transfer Type            Isochronous
              Synch Type               Adaptive
              Usage Type               Data
            wMaxPacketSize     0x0020  1x 32 bytes
            bInterval               1
            bRefresh                0
            bSynchAddress           0
            AudioControl Endpoint Descriptor:
              bLength                 7
              bDescriptorType        37
              bDescriptorSubtype      1 (EP_GENERAL)
              bmAttributes         0x01
                Sampling Frequency
              bLockDelayUnits         1 Milliseconds
              wLockDelay              1 Milliseconds
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
            bTerminalLink           7
            bDelay                  1 frames
            wFormatTag              1 PCM
          AudioStreaming Interface Descriptor:
            bLength                11
            bDescriptorType        36
            bDescriptorSubtype      2 (FORMAT_TYPE)
            bFormatType             1 (FORMAT_TYPE_I)
            bNrChannels             1
            bSubframeSize           2
            bBitResolution         16
            bSamFreqType            1 Discrete
            tSamFreq[ 0]        16000
          Endpoint Descriptor:
            bLength                 9
            bDescriptorType         5
            bEndpointAddress     0x82  EP 2 IN
            bmAttributes            5
              Transfer Type            Isochronous
              Synch Type               Asynchronous
              Usage Type               Data
            wMaxPacketSize     0x0020  1x 32 bytes
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
          bInterfaceClass         3 Human Interface Devices
          bInterfaceSubClass      0 No Subclass
          bInterfaceProtocol      0 None
          iInterface              0 
            HID Device Descriptor:
              bLength                 9
              bDescriptorType        33
              bcdHID               2.01
              bCountryCode            0 Not supported
              bNumDescriptors         1
              bDescriptorType        34 Report
              wDescriptorLength      40
             Report Descriptors: 
               ** UNAVAILABLE **
          Endpoint Descriptor:
            bLength                 7
            bDescriptorType         5
            bEndpointAddress     0x81  EP 1 IN
            bmAttributes            3
              Transfer Type            Interrupt
              Synch Type               None
              Usage Type               Data
            wMaxPacketSize     0x0008  1x 8 bytes
            bInterval               1
          Endpoint Descriptor:
            bLength                 7
            bDescriptorType         5
            bEndpointAddress     0x01  EP 1 OUT
            bmAttributes            3
              Transfer Type            Interrupt
              Synch Type               None
              Usage Type               Data
            wMaxPacketSize     0x0010  1x 16 bytes
            bInterval               1
    Device Status:     0xc238
      (Bus Powered)

Retrieved from
"[http://alsa.opensrc.org/UsbPhone](http://alsa.opensrc.org/UsbPhone)"

[Category](/Special:Categories "Special:Categories"): [Sound
cards](/Category:Sound_cards "Category:Sound cards")

