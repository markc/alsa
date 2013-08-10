The .asoundrc file
==================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Note: [.asoundrc](/.asoundrc ".asoundrc") says that this file is not
necessary. Can someone who knows more merge the two pages or update this
page?

This file allows you to have more advanced control over your card. Some
very useful applications will not work without it. At this point is is
still a bit of a black art getting the details correct. Make a file
called [.asoundrc](/.asoundrc ".asoundrc") in your home directory

` `

    vi ~/.asoundrc

copy and paste the following into the file then save it.

` `

    pcm.cmipci {
        type hw
        card 0
    }

    ctl.cmipci {
        type hw
        card 0
    }

For a full explanation of the .asoundrc file please read this
[[1]](http://www.alsa-project.org/alsa-doc/alsa-lib/pcm_plugins.html#pcm_plugins)
page or the example in the alsa-driver package.

See also
--------

-   [Asoundrc.txt](/Asoundrc.txt "Asoundrc.txt")
-   [.asoundrc](/.asoundrc ".asoundrc")
-   [Plugin\_Documentation](/Plugin_Documentation "Plugin Documentation")

Retrieved from
"[http://alsa.opensrc.org/The\_.asoundrc\_file](http://alsa.opensrc.org/The_.asoundrc_file)"

[Category](/Special:Categories "Special:Categories"):
[Documentation](/Category:Documentation "Category:Documentation")

