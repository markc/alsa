Copy (plugin)
=============

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

This is the page about the **copy plugin**, an [ALSA
plugin](/ALSA_plugins "ALSA plugins") that copies samples from master
copy PCM to given slave PCM.

Basic usage
-----------

A basic configuration in the `~/.asoundrc` file looks like this:

` `

      pcm.name {
           type copy               # Copy PCM
           slave STR               # Slave name
      }

See also
--------

-   [The .asoundrc file](/The_.asoundrc_file "The .asoundrc file"),
    [.asoundrc](/.asoundrc ".asoundrc") and [Plugin
    Documentation](/Plugin_Documentation "Plugin Documentation") -
    General information about setting up PCM devices
-   [Official
    documentation](http://www.alsa-project.org/alsa-doc/alsa-lib/pcm_plugins.html#pcm_plugins_softvol)
    on the ALSA projects page.

Retrieved from
"[http://alsa.opensrc.org/Copy\_(plugin)](http://alsa.opensrc.org/Copy_(plugin))"

[Category](/Special:Categories "Special:Categories"): [ALSA
plugins](/Category:ALSA_plugins "Category:ALSA plugins")

