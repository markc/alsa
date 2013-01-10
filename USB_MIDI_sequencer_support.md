USB MIDI sequencer support
==========================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

I've written a daemon which connects the ALSA sequencer with the
usbdevfs device file of a USB MIDI device. You can get it at
[http://www.informatik.uni-halle.de/\~ladischc/usbmidid.html](http://www.informatik.uni-halle.de/~ladischc/usbmidid.html)

It requires a kernel with USB and usbdevfs support (obviously), and with
hotplugging support and hotplugging scripts installed correctly.

It should work with most USB MIDI devices, but currently it has been
tested with Roland SC-8820 only. I don't have the slightest idea whether
the code for parsing the device descriptors of fully compliant devices
woks at all. :-) So, please tell me if it works for you.

--*Clemens*

**Additional notes:**

You need at least kernel 2.4.19 to get the right output from lsusb. To
first get raw MIDI input from a USB MIDI device, read
[USBMidiDevices](/USBMidiDevices "USBMidiDevices") and
[usb-audio](/Usb-audio "Usb-audio").

Retrieved from
"[http://alsa.opensrc.org/USB\_MIDI\_sequencer\_support](http://alsa.opensrc.org/USB_MIDI_sequencer_support)"

[Categories](/Special:Categories "Special:Categories"):
[MIDI](/Category:MIDI "Category:MIDI") |
[Software](/Category:Software "Category:Software")

