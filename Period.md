Period
======

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

The interval between interrupts from the hardware. This defines the
input latency, since the CPU will not have any idea that there is data
waiting until the audio interface interrupts it.

The audio interface has a "pointer" that marks the current position for
read/write in its h/w buffer. The pointer circles around the buffer as
long as the interface is running.

Typically, there are an integral number of periods per traversal of the
h/w buffer, but not always. There is at least one card
([ymfpci](/Ymfpci "Ymfpci")) that generates interrupts at a fixed rate
indepedent of the buffer size (which can be changed), resulting in some
"odd" effects compared to more traditional designs.

Note: h/w generally defines the interrupt in frames, though not always.

Alsa's period size setting will affect how much work the CPU does. if
you set the period size low, there will be more interrupts and the work
that is done every interrupt will be done more often. So, if you don't
care about low latency, set the period size large as possible and you'll
have more CPU cycles for other things. The defaults that ALSA provides
are in the middle of the range, typically.

(from an old AlsaDevel
thread[[1]](http://www.geocrawler.com/mail/thread.php3?subject==%5BAlsa-devel%5D+What+is+a+period%3F&list==12349),
quoting [Paul Davis](/User:PaulDavis "User:PaulDavis"))

Retrieved from
"[http://alsa.opensrc.org/Period](http://alsa.opensrc.org/Period)"

[Category](/Special:Categories "Special:Categories"):
[Glossary](/Category:Glossary "Category:Glossary")

