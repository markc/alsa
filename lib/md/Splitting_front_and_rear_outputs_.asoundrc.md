Splitting front and rear outputs .asoundrc
==========================================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Splitting front and rear outputs
--------------------------------

I had a lot of trouble first figuring out how I could split front and
rear channels into two devices that could be used independently. The
following [.asoundrc](/.asoundrc ".asoundrc") file is what I came up
with. It can be used with mplayer for example as follows:

` `

    mplayer -ao alsa1x:frontx file1.avi
    mplayer -ao alsa1x:rearx file2.mp3

Enjoy...

` `

    pcm.dshare {
        type dmix
        ipc_key 2048
        slave {
            pcm "hw:0"
            rate 44100
            period_time 0
            period_size 1024
            buffer_size 8192
            channels 4
        }
        bindings {
            0 0
            1 1
            2 2
            3 3
        }
    }
    pcm.frontx {
        type plug
        slave {
            pcm "dshare"
            channels 4
        }
        ttable.0.0 1
        ttable.1.1 1
    }
    pcm.rearx {
        type plug
        slave {
            pcm "dshare"
            channels 4
        }
        ttable.0.2 1
        ttable.1.3 1
    }

Note, for ttable you might use fractions but then you cannot use
LC\_NUMERIC locales that use characters other than '.' as decimal
separator. Actually this is a bug and has already been fixed in versions
higher than 1.0.8.

With this setup, playing a mono file only produces sound in the left
channel, is there any way to make mono files automatically go to both
speakers? //Mikachu

To automatically upmix mono to stereo, you need to add another layer:

    pcm.rearx {
       type plug
       slave {
           pcm {
               type plug
               slave {
                   pcm "dshare"
                   channels 4
               }
               ttable.0.2 1
               ttable.1.3 1
           }
           channels 4
       }
       route_policy default #This upmixes mono to stereo
    }

//Jmkinny

Retrieved from
"[http://alsa.opensrc.org/Splitting\_front\_and\_rear\_outputs\_.asoundrc](http://alsa.opensrc.org/Splitting_front_and_rear_outputs_.asoundrc)"

[Category](/Special:Categories "Special:Categories"):
[Howto](/Category:Howto "Category:Howto")

