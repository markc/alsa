Aoss
====

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

The *aoss* script for OSS emulation
-----------------------------------

One of the aims of ALSA is to provide full OSS compatibility for OSS
applications. ALSA does this by emulating the old OSS sound driver. ALSA
has two alternative methods of emulating the old OSS sound driver:

-   The first (and most reliable) emulation method is to load ALSA's
    kernel [OSSEmulation](/OSSEmulation "OSSEmulation") modules:
    *[snd-pcm-oss](/Snd-pcm-oss "Snd-pcm-oss")*,
    *[snd-mixer-oss](/Snd-mixer-oss "Snd-mixer-oss")*, and
    *[snd-seq-oss](/Snd-seq-oss "Snd-seq-oss")*.
-   The second emulation method is to use the *aoss* script included in
    the *alsa-oss* package.

For example, to use the *xmms* media player program, which in some old
version is only an OSS application, you can start it using *aoss*:

` `

       aoss xmms

together with the OSS output plugin of *xmms*. Usage of *aoss* is
preferred over kernel-level OSS emulation because if you need use the
PCM plugin layer, enabling the use of the
[DmixPlugin](/DmixPlugin "DmixPlugin") or [asym](/Asym "Asym"). If you
don't need software-mixing of streams or any other PCM layer
functionality, then go with the kernel-level emu (modules), since they
are much easier to set up: Just load them.

For details of how to use the kernel modules see the
[OSSEmulation](/OSSEmulation "OSSEmulation") page.

You can define PCM devices in the [.asoundrc](/.asoundrc ".asoundrc")
which will then get used by the *aoss* script (pcm.dsp0). See the man
page of *aoss*. Also I think that you can tell it which mixer to use;
use a *"ctl.mixer0"* entry for that.

Notes
-----

**Important** It seems that *aoss* does not support libc's *fopen()*
function calls. So all OSS apps that use the sound devices by calling
*fopen()* won't work with *aoss*. The *sox* program, for example, won't
work. I don't know of any others though I suspect that there are quite a
few.

*Teamspeak* uses *fopen()* too in the current version. *Teamspeak 3.x*
is supposed to have native ALSA support though. Maybe *aoss* will be
adapted to catch calls to libc's *fopen()* and other related functions.

For alsa-oss-1.0.5 there's a patch available which should fix the fopen
stuff:

[http://www.affenbande.org/\~tapas/alsa-oss-fopen.patch](http://www.affenbande.org/~tapas/alsa-oss-fopen.patch)

this one builds on the above one:

[http://www.affenbande.org/\~tapas/alsa-oss-fopen2.patch](http://www.affenbande.org/~tapas/alsa-oss-fopen2.patch)

and fixes some minor issues..

\
 Please test and let me know [tapas](/User:Tapas "User:Tapas").

**Update**: the fix should be in alsa cvs now.. please grab from there.
dunno when it will come into the next release.. **Update2**: seems as if
the fix is official since release 1.0.6a

Retrieved from
"[http://alsa.opensrc.org/Aoss](http://alsa.opensrc.org/Aoss)"

[Category](/Special:Categories "Special:Categories"):
[OSS](/Category:OSS "Category:OSS")

