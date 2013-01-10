Rtirq
=====

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

The **rtirq** script is a bash script written by **Rui Nuno Capela**
which works in conjunction with the [realtime
kernel](?title=Realtime_kernel&action=edit&redlink=1 "Realtime kernel (page does not exist)")
patch by **Ingo Molnar**. The script takes advantage of the fact that
realtime kernels use threads for IRQs management, and as such these
threads (like any other thread running on your system) can be given
maximum priority in an effort to minimize the
[latency](/Latency "Latency") of audio peripherals.

The script identifies the audio devices present on the machine and
raises the priority of the threads that handle the IRQs of such devices.
The rtirq script requires that the 'schedutils' package is correctly
installed on the system, and works by simple invocation. For instance:

` `

    $ sh rtirq.sh
    rtirq.sh: start [rtc] irq=8 pid=247 prio=90: OK.
    rtirq.sh: start [snd] irq=5 pid=1045 prio=85: OK.
    rtirq.sh: start [uhci_hcd] irq=10 pid=747 prio=80: OK.
    rtirq.sh: start [ehci_hcd] irq=11 pid=289 prio=80: OK.
    rtirq.sh: start [i8042] irq=1 pid=297 prio=75: OK.
    rtirq.sh: start [i8042] irq=12 pid=296 prio=74: OK.

The script has identified an external USB card and has hence raised the
priority of the threads managing the USB bus (uhci\_hcd and ehci\_hcd).

See also
--------

-   [Rui Nuno Capela's website](http://www.rncbc.org), with interesting
    info and applications for linux audio
-   [rtirq](http://www.rncbc.org/jack/) download page (near bottom)
-   former [schedutils](http://rlove.org/) download page (now included
    in the standard [util-linux
    package](ftp://ftp.kernel.org/pub/linux/utils/util-linux/))

Retrieved from
"[http://alsa.opensrc.org/Rtirq](http://alsa.opensrc.org/Rtirq)"

[Category](/Special:Categories "Special:Categories"):
[Software](/Category:Software "Category:Software")

