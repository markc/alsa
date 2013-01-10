A short explanation of what happens in the /etc/modules.conf file
=================================================================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Native Devices
--------------

After the main multiplexer is loaded, its code requests top level sound
card module. String snd-card-%i is requested for native devices where %i
is sound card number from zero to seven. String sound-slot-%i is
requested for native devices where %i is slot number for ALSA owner this
means sound card number. The options line allows you to set various
config options before the module is loaded. String snd\_id lets you set
the name of the card which is returned in the /proc/asound/cards file.
Other options may be available which are card specific. The options for
these are found in the INSTALL file or above.

` `

    # ALSA portion
    alias snd-card-0 snd-interwave
    alias snd-card-1 snd-cmipci
    options snd-cmipci id="first" enable_midi="1"

    # OSS/Free portion
    alias sound-slot-0 snd-card-0
    alias sound-slot-1 snd-card-1

NB. For drivers older than 0.9.0rc5 use:

` `

    options snd-cmipci snd_id="first" snd_enable_midi="1"

The "snd\_" prefix has been removed from the "module options" to fit
with the kernel standard.

Autoloading OSS/free emulation
------------------------------

We are finished at this point with the configuration for ALSA native
devices, but you may also need autoloading for ALSA add-on OSS/Free
emulation modules. At this time only one module does not depend on any
others, thus must be loaded separately, snd-pcm1-oss.o. String
`sound-service-%i-%i` is requested for OSS/Free service where first %i
means slot number e.g. card number and second %i means service number.

` `

    # OSS/Free portion - card #1
    alias sound-slot-0 snd-card-0
    alias sound-service-0-0 snd-mixer-oss
    alias sound-service-0-1 snd-seq-oss
    alias sound-service-0-3 snd-pcm-oss
    alias sound-service-0-8 snd-seq-oss
    alias sound-service-0-12 snd-pcm-oss

    # OSS/Free portion - card #2 (cmipci)
    alias sound-slot-1  snd-card-1 
    alias sound-service-1-0 snd-mixer-oss
    alias sound-service-1-3 snd-pcm-oss
    alias sound-service-1-12 snd-pcm-oss

The alias for `snd-seq-oss` is not necessary on the second device,
because there is only one `/dev/sequencer`, regardless how many devices
you have.

Retrieved from
"[http://alsa.opensrc.org/A\_short\_explanation\_of\_what\_happens\_in\_the\_/etc/modules.conf\_file](http://alsa.opensrc.org/A_short_explanation_of_what_happens_in_the_/etc/modules.conf_file)"

[Category](/Special:Categories "Special:Categories"):
[Documentation](/Category:Documentation "Category:Documentation")

