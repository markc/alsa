Pcm-config-test
===============

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

A little program to browse the parameter space of an alsa pcm device.
Grab it here:

[http://www.affenbande.org/\~tapas/wiki/index.php?pcm-config-test](http://www.affenbande.org/~tapas/wiki/index.php?pcm-config-test)

It is useful to find out which samplerates, transport methods, etc., are
supported by a device.

` `

    pcm-config-test --help

gives this little verbose help:

` `

    tapas@mango:~/tmp/pcm_config_test$ ./pcm_config_test --help

    -- alsa-lib pcm device config tester v0.0.1 --
    usage: pcm_config_test <pcm-device-name> [options] 

    options are:
    --playback
    --capture
    --standard-samplerates
    --samplerate-range x y
    --standard-periodsizes
    --periodsizes-range x y
    --standard-periodcounts
    --periodcounts-range x y
    --formats
    --accessmethods

    at least one of --capture and --playback is needed.
    pcm device name must be the first argument!

Retrieved from
"[http://alsa.opensrc.org/Pcm-config-test](http://alsa.opensrc.org/Pcm-config-test)"

[Category](/Special:Categories "Special:Categories"):
[Software](/Category:Software "Category:Software")

