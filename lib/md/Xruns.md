Xruns
=====

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

An "xrun" can be either a [buffer
underrun](?title=Buffer_underrun&action=edit&redlink=1 "Buffer underrun (page does not exist)")
or a [buffer
overrun](?title=Buffer_overrun&action=edit&redlink=1 "Buffer overrun (page does not exist)").
In both cases an audio app was either not fast enough to deliver data to
the ALSA audio buffer or not fast enough to process data from the ALSA
audio buffer. Usually xruns are audible as crackles or pops.

Various kernel patches and strategies are available to minimise xruns
under [Jack](/Jack "Jack"), eg. kernel pre-emption and the Realtime
Linux Security Module. At the time of writing (July 2004) these
strategies are in a bit of a state of flux - see
[http://jackit.sourceforge.net/docs/faq.php\#a5](http://jackit.sourceforge.net/docs/faq.php#a5)
for the latest.

Recent versions of Alsa provide a means of logging and debugging xruns
through the [proc tree](/Proc_tree "Proc tree").

Retrieved from
"[http://alsa.opensrc.org/Xruns](http://alsa.opensrc.org/Xruns)"

[Category](/Special:Categories "Special:Categories"):
[Glossary](/Category:Glossary "Category:Glossary")

