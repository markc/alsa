Serial
======

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Contents
--------

-   [1 Module options](#Module_options)
    -   [1.1 Key options](#Key_options)
        -   [1.1.1 adaptor](#adaptor)
        -   [1.1.2 port](#port)
        -   [1.1.3 irq](#irq)
        -   [1.1.4 speed](#speed)
        -   [1.1.5 base](#base)
        -   [1.1.6 outs](#outs)
        -   [1.1.7 ins](#ins)

    -   [1.2 Additional parameters](#Additional_parameters)

-   [2 Usage examples](#Usage_examples)
    -   [2.1 Simple serial converter](#Simple_serial_converter)
    -   [2.2 Roland SoundCanvas with 4 MIDI
        ports](#Roland_SoundCanvas_with_4_MIDI_ports)
    -   [2.3 MS-124T](#MS-124T)
        -   [2.3.1 With A-B switch in A
            position](#With_A-B_switch_in_A_position)
        -   [2.3.2 S/A mode](#S.2FA_mode)
        -   [2.3.3 M/B mode](#M.2FB_mode)

Module options
--------------

The snd-serial-u16550 driver contains some auto-detection code. If this
does not work, these options may be required. This information is
focused on the options that make the Winman 1x1 ISA interface work. The
Winman 2x2 seems the be that same card with two UARTs instead of one.

### Key options

The key options for snd-serial-u16550 are:

#### adaptor

This option is covered in the **serial** page. **adaptor** sets the MIDI
interface type. There are five options:

` `

    0 - Roland Soundcanvas or Alesis QS-series support (default)
    1 - Midiator MS-124T support (1)
    2 - Midiator MS-124W S/A mode (2)
    3 - MS-124W M/B mode support (3)
    4 - Generic device with multiple input support (4)

The number of MIDI inputs for the Generic option is set by the parameter
**ins**, or defaults to 1.

For the Midiator MS-124W, you must set the physical M-S and A-B switches
on the Midiator to match the driver mode you select.

In Roland Soundcanvas mode, multiple ALSA raw MIDI substreams are
supported (midiCnD0-midiCnD15). Whenever you write to a different
substream, the driversends the nonstandard MIDI command sequence F5 NN,
where NN is the substream number plus 1. Roland modules use this command
to switch between different "parts", so this feature lets you treat each
part as a distinct raw MIDI substream. The driver provides no way to
send F5 00 (no selection) or to not send the F5 NN command sequence at
all; perhaps it ought to.

#### port

Specifies the hardware I/O base memory address of the UART chip. On some
cards this is set by hardware. On the Winman 1x1 this is set by jumper.
On the Winman 2x2 the first MIDI port has the specified base address and
the second port has an address 0x008 higher; thus if the base address is
0x200 the second UART base address is 0x208.

#### irq

Specifies the hardware IRQ of the UART chip. On the Winman cards this is
set by jumper. **snd-serial-u16550** may be able to operate on a polling
basis if an interrupt is not available.

#### speed

Specifies the speed in baud of the MIDI interface. The correct rate for
MIDI is 31250 baud; generic PC serial ports, however, cannot produce
this speed due to the clock rate of their UARTs. 38400 baud is the
fallback rate, producible by standard PC serial ports and expected by
devices with a PC serial port interface.

#### base

Specifies the base speed of the UART. This is the crystal clock divided
by 16. On the Winman cards, the crystal clock is 6MHz; on other cards
the crystal clock value should be printed on the crystal, typically the
only component in a metal canister. The appropriate value for the Winman
cards is thus 375000 = 6000000 / 16. The driver will use the appropriate
divisor given the **base** and possibly **speed** parameters.

#### outs

Specifies the number of MIDI outputs supported by the interface.
Defaults to 1.

#### ins

Specifies the number of MIDI inputs supported by the interface. Also
defaults to 1.

### Additional parameters

There are a few additional parameters listed in the output of
/sbin/modinfo snd-serial-u16550. I do not know what they do. On the
Winman 1x1 interface the magic line for me is:

` `

    /sbin/modprobe snd-serial-u16550 adaptor=4 port=0x300 irq=5 speed=31250 base=375000

All these parameters seem to be necessary; on the Winman the module
loaded happily without the **base** parameter but produced meaningless
MIDI data.

Usage examples
--------------

### Simple serial converter

Usage example for simple serial converter:

` `

    /sbin/setserial /dev/ttyS0 uart none
    /sbin/modprobe snd-serial-u16550 port=0x3f8 irq=4 \
        speed=115200

Note: I found that setserial would not accept none as a parameter.
Instead I had to set the port to an unused address. Use:

` `

    cat /proc/ioports

to find out which address are in use... then choose another. The best
ones to use are other serial address like 0x2f8.

In other cases it can be completely fine to give the uart none argument
to setserial.

### Roland SoundCanvas with 4 MIDI ports

Usage example for Roland SoundCanvas with 4 MIDI ports:

` `

       /sbin/setserial /dev/ttyS0 uart none
       /sbin/modprobe snd-serial-u16550 port=0x3f8 irq=4 outs=4

The same goes for an Alesis QSR, only you should leave out the outs=4
parameter, because the QSR only has 1 in and 1 out port.

### MS-124T

In MS-124T mode, one raw MIDI substream is supported (midiCnD0); the
outs module parameter is automatically set to 1. The driver sends the
same data to all four MIDI Out connectors. Set the A-B switch and the
speed module parameter to match (A=19200, B=9600).

#### With A-B switch in A position

Usage example for MS-124T, with A-B switch in A position:

` `

    /sbin/setserial /dev/ttyS0 uart none
    /sbin/modprobe snd-serial-u16550 port=0x3f8 irq=4 \
        adaptor=1 speed=19200

In MS-124W S/A mode, one raw MIDI substream is supported (midiCnD0); the
outs module parameter is automatically set to 1. The driver sends the
same data to all four MIDI Out connectors at full MIDI speed.

#### S/A mode

Usage example for S/A mode:

` `

    /sbin/setserial /dev/ttyS0 uart none
    /sbin/modprobe snd-serial-u16550 port=0x3f8 irq=4 \
        adaptor=2

In MS-124W M/B mode, the driver supports 16 ALSA raw MIDI substreams;
the outs module parameter is automatically set to 16. The substream
number gives a bitmask of which MIDI Out connectors the data should be
sent to, with midiCnD1 sending to Out 1, midiCnD2 to Out 2, midiCnD4 to
Out 3, and midiCnD8 to Out 4. Thus midiCnD15 sends the data to all 4
ports. As a special case, midiCnD0 also sends to all ports, since it is
not useful to send the data to no ports. M/B mode has extra overhead to
select the MIDI Out for each byte, so the aggregate data rate across all
four MIDI Outs is at most one byte every 520 us, as compared with the
full MIDI data rate of one byte every 320 us per port.

#### M/B mode

Usage example for M/B mode:

` `

        /sbin/setserial /dev/ttyS0 uart none
        /sbin/modprobe snd-serial-u16550 port=0x3f8 irq=4 \
            adaptor=3

The MS-124W hardware's M/A mode is currently not supported. This mode
allows the MIDI Outs to act independently at double the aggregate
throughput of M/B, but does not allow sending the same byte
simultaneously to multiple MIDI Outs. The M/A protocol requires the
driver to twiddle the modem control lines under timing constraints, so
it would be a bit more complicated to implement than the other modes.

Midiator models other than MS-124W and MS-124T are currently not
supported. Note that the suffix letter is significant; the MS-124 and
MS-124B are not compatible, nor are the other known models MS-101,
MS-101B, MS-103, and MS-114. I do have documentation
(tim.mann@compaq.com) that partially covers these models, but no units
to experiment with. The MS-124W support is tested with a real unit. The
MS-124T support is untested, but should work.

Retrieved from
"[http://alsa.opensrc.org/Serial](http://alsa.opensrc.org/Serial)"

[Category](/Special:Categories "Special:Categories"): [ALSA
modules](/Category:ALSA_modules "Category:ALSA modules")

