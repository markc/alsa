Converting Sample Rates on Input .asoundrc
==========================================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Converting Sample Rates On Input
--------------------------------

` `

    pcm.rate_convert {
        type plug
        slave {
            pcm "hw:0,0"
            rate 48000
        }
    }

This will take an input of any rate and convert it to 48000 hz, change
to suit your needs.

Retrieved from
"[http://alsa.opensrc.org/Converting\_Sample\_Rates\_on\_Input\_.asoundrc](http://alsa.opensrc.org/Converting_Sample_Rates_on_Input_.asoundrc)"

[Category](/Special:Categories "Special:Categories"):
[Howto](/Category:Howto "Category:Howto")

