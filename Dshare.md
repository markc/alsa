Dshare
======

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

I'm no ALSA expert, but since this page was empty and getting
information on dshare was not easy I decided to be daring and put
something on this page. BTW, most pages about dshare contain
[.asoundrc](/.asoundrc ".asoundrc") snippets in a "this doesn't work"
context, so it might be nice to see what did work (for me).

Two things seem to be very important when using dshare :

-   define your hardware as a pcm\_slave
-   define the number of channels

` `

       pcm_slave.nforce {
           pcm "hw:0"
           channels 6
           rate 44100        # fixed, because all dshare devices must use the same samplerate.
           buffer_size 4096  # make these sizes smaller for lower latency
           period_size 2048
           periods 0
           period_time 0
       }

then use dshare type pcm definitions, bound to the hardware slave :

` `

       pcm.ch12 {
           type dshare
           ipc_key 47110815
           slave nforce
           bindings.0 0
           bindings.1 1
       }
       
       pcm.ch34 {
           type dshare
           ipc_key 47110815
           slave nforce
           bindings.0 2
           bindings.1 3
       }
       
       pcm.ch56 {
           type dshare
           ipc_key 47110815
           slave nforce
           bindings.0 4
           bindings.1 5
       }

On top of each dshare pcm device, you could create a plug device to
allow other samplerates. See the [Plugin
Documentation](/Plugin_Documentation "Plugin Documentation") page.

* * * * *

#### 2005-09-18

With the assistance of the above post I finally figured out how to use
dshare with the ice1712. With this I can play linuxsampler out of
channels 1-4 and fluidsynth out of channels 5-6 simultaneously, with
very low latency, and very low cpu load. -Garett *Thank you Garret* ` `

       pcm_slave.66_slave {
           pcm "hw:1,0"
           channels 8
           rate 44100
           buffer_size 256
           period_size 128
       }
       
       pcm.66ch1234_dshare {
           type dshare
           ipc_key 18273645
           slave 66_slave
           bindings.0 0
           bindings.1 1
           bindings.2 2
           bindings.3 3
       }
       
       pcm.66ch1234 {
           type plug
           slave.pcm "66ch1234_dshare"
       }
       
       pcm.66ch56_dshare {
           type dshare
           ipc_key 18273645
           slave 66_slave
           bindings.0 4
           bindings.1 5
       }
       
       pcm.66ch56
           type plug
           slave.pcm "66ch56_dshare"
       }

Retrieved from
"[http://alsa.opensrc.org/Dshare](http://alsa.opensrc.org/Dshare)"

[Category](/Special:Categories "Special:Categories"): [ALSA
plugins](/Category:ALSA_plugins "Category:ALSA plugins")

