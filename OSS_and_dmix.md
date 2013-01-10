OSS and dmix
============

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Using OSS and Dmix
------------------

Something I (and I imagine others) have wanted to do for a while is
listen to XMMS whilst playing Unreal Tournament. I have now found this
possible using aoss and the [dmix](/Dmix "Dmix") plugin.

My setup is:

` `

    Debian Etch (worked with Sarge too)
    ALSA 1.0.10-1  (worked with previous versions)
    Nforce2 Onboard sound

Firstly, I created the [.asoundrc](/.asoundrc ".asoundrc") file:

` `

    #~/.asoundrc

    #default control device is my card 
    #(as it does anyway, without .asoundrc)
    ctl.!default {
      type hw
      card 0
    }


    pcm.dmixer  {             #this virtual device does the mixing of 
      type dmix               #the various signals
      ipc_key 1024
      slave {
        pcm "hw:0,0"
        period_time 0
        period_size 1024
        buffer_size 4096
        rate 44100
      }
      bindings {
        0 0
        1 1
      }
    }


    pcm.!default {             #this means that applications use the mixer
      type plug                #by default, so you can hear everything
      slave.pcm "dmixer"
    }

then I invoked unreal with

` `

    aoss ut2004

et voila, it worked :)

Retrieved from
"[http://alsa.opensrc.org/OSS\_and\_dmix](http://alsa.opensrc.org/OSS_and_dmix)"

[Category](/Special:Categories "Special:Categories"):
[OSS](/Category:OSS "Category:OSS")

