Sfxload
=======

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Soundfont Loading with sfxload
------------------------------

*sfxload* loads a [soundfont](/Soundfont "Soundfont") onto ALSA's OSS
emulation of the emux wavetable. The new version
*[asfxload](/Asfxload "Asfxload")* works only with ALSA's native emux
wavetable. See the
[SoundfontHandling](/SoundfontHandling "SoundfontHandling") page for
details of how to use soundfonts.

[http://www.alsa-project.org/\~iwai/awedrv.html\#Utils](http://www.alsa-project.org/~iwai/awedrv.html#Utils)

Examine sfxload's success with -v (verbosity).

**sfxload \<sfbank.file\>** used to successfully load a sound bank which
could then be used by an application like *pmidi*. This is the first
option for *sfxload*, and the man page says that: *The first usage is to
read SF2 (or SBK) file and transfer to the awe driver. In this case, the
samples which were loaded on the driver are replaced with the new one.*

*Then it stopped working*. *pmidi* would play the file and the events
could be viewed with *aseqview* but there would be no sound! When
loading the sfbank.file with the above command line, *-v* would show
that the default soundbank was -1. I discovered that *sfxload
\<sfbank.file\>* needed to be told which bank to load.

**sfxload -b\# \<sfbank.file\>** *In the second case,*sfxload*reads the
file and appends it to the pre-loaded samples on the driver with
specified bank number. The old samples remain in the driver. The
additional samples can be cleared with the*-x*option.*

This additional flag may be necessary because the ALSA driver no longer
properly handles the first case. -G. Baum, 2004-01-01

\
 cat /proc/asound/card?/wavetableD? to see if sfxload worked (it should
say something about memory and instruments). If you cat before and after
the call to sfxload, it should be very obvious whether or not the load
actually succeeded. -Hawkeye Parker, 2004-02-19

Retrieved from
"[http://alsa.opensrc.org/Sfxload](http://alsa.opensrc.org/Sfxload)"

[Category](/Special:Categories "Special:Categories"):
[Software](/Category:Software "Category:Software")

