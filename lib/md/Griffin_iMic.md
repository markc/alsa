Griffin iMic
============

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

I found this hardware to work well with alsa under many default
debian-type installations and with many apps. I've found it has nice
clean audio when everything is well-configured.

I've successfully used this hardware with alsa and a default-userland
installation of [jack](/Jack "Jack"). I kept getting lots of xruns when
I connected a client, along with this error

     Subgraph starting at ecasound timed out (subgraph_wait=..., status=0, state=running)

and something about zombifying and then exit? I played with the buffers
to no avail. \_Finally\_ I tried increasing jackd's timeout (with -t
int\_usecs), which defaults to 500usec, to a very large number. It's
worked like butter ever since.

Retrieved from
"[http://alsa.opensrc.org/Griffin\_iMic](http://alsa.opensrc.org/Griffin_iMic)"

[Category](/Special:Categories "Special:Categories"): [Sound
cards](/Category:Sound_cards "Category:Sound cards")

