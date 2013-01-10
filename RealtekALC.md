RealtekALC
==========

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Realtek produce a series of 2,6 and 8 channel audio chips which support
the Intel Audio Codec 1997 (AC'97) and the more recent Intel High
Definition Audio standard for converting between analogue and digital
audio data streams. The current (July 2007) set of audio chips include:

AC'97

     2-Channel:  ALC101, ALC202, ALC203, ALC250 
     6-Channel:  ALC650, ALC655, ALC658 
     8-Channel:  ALC850 

High Definition Audio

     2-Channel:  ALC260, ALC262, ALC268 
     6-Channel:  ALC662 
     8-Channel:  ALC861, ALC880, ALC882, ALC883, ALC888, ALC885

Higher numbers may indicate better quality or more options.

For use with a computer, the chips need to be connected to one of the
computer buses. This may be done via a dedicated soundcard or, if the
chip is on the motherboard, by direct connection to the motherboard
southbridge. See [Sound Cards:
Introduction](/Sound_Cards:_Introduction "Sound Cards: Introduction")

Thus if the motherboard is based on the Nvidia Nforce4 chipset, an
ALC650 may be connected to the Nvidia CK804 chip. It can then be driven
using the [intel8x0](/Intel8x0 "Intel8x0") Alsa kernel module which
supports the Nvidia interface. If the motherboard is based on a Via
chipset, the ALC650 may be connected to a Via8233 southbridge chip. It
can the be driven using the
[via82xx](?title=Via82xx&action=edit&redlink=1 "Via82xx (page does not exist)")
Alsa kernel module. Note that in such cases the system will appear to
contain a Nvidia or Via soundcard.

\

[Realtek ALC650](/Realtek_ALC650 "Realtek ALC650")

As input this accepts digital [PCM](/PCM "PCM") (pulse coded modulation)
data from the computer and analogue signals from a CD, microphone,
telephone and other audio equipment. PCM data is first converted to an
analogue signal. The different analogue signals can then be amplified
and combined to produce the main stero line-out signal. Output to the
additional four analogue output channels can come either from their own
PCM input channels or from the line-out signal.

In a separate analogue path through the chip, the input analogue signals
(plus the line-out signal) can be combined and amplified to produce a
digital output signal for input to the computer. The chip can also send
and receive data from other audio devices using the Sony/Phillips
Digital Interface Format (S/P DIF).

\

([DavidWebb](?title=User:DavidWebb&action=edit&redlink=1 "User:DavidWebb (page does not exist)"))

External Links
--------------

[http://www.realtek.com.tw/](http://www.realtek.com.tw/) Realtek
Semiconductor Corporation

Retrieved from
"[http://alsa.opensrc.org/RealtekALC](http://alsa.opensrc.org/RealtekALC)"

[Category](/Special:Categories "Special:Categories"): [Sound
cards](/Category:Sound_cards "Category:Sound cards")

