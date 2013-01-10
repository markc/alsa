Edirol PC-50
============

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

This is a 4 octave (49 velocity sensitive keys) midi controller keyboard
with integrated USB interface and a single MIDI-out port.

I have tested this under Mandriva 2007 (kernel 2.6.17, alsa 1.0.12) and
it works fine, it's completely plug-n-play, no manual configuration
necessary.

Here is the `/proc/asound/cards` and `amidi -l` output (see card 1):

` `

    # more /proc/asound/cards
     0 [M2x2           ]: USB-Audio - Midisport 2x2
                          Midiman Midisport 2x2 at usb-0000:01:0a.0-1, full speed
     1 [PC50           ]: USB-Audio - PC-50
                          EDIROL PC-50 at usb-0000:00:07.2-1, full speed
    # amidi -l
    Dir Device    Name
    IO  hw:0,0,0  Midisport 2x2 MIDI 1
    IO  hw:0,0,1  Midisport 2x2 MIDI 2
    IO  hw:1,0,0  PC-50 MIDI 1

This keyboard has a 'Advanced Driver' switch on the side to
enable/disable FPT (Fast Processing Technology), some Roland/Edirol
feature they claim is used to make effective use of the USB bandwith
according to the amount of MIDI data transmitted.

I have tested it both with FPT on or off and it seems to work fine
either way under Linux.

Retrieved from
"[http://alsa.opensrc.org/Edirol\_PC-50](http://alsa.opensrc.org/Edirol_PC-50)"

[Category](/Special:Categories "Special:Categories"): [Sound
cards](/Category:Sound_cards "Category:Sound cards")

