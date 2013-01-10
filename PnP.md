PnP
===

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

**Plug and Play**: Hardware or software that, after being installed
("plugged in"), can immediately be used ("played with"), as opposed to
hardware or software which requires configuration. (dictionary.com,
[http://dictionary.reference.com/search?q=plug%20and%20play](http://dictionary.reference.com/search?q=plug%20and%20play))

If you're unlucky, also known as *Plug and Pray*

---

Ok, but maybe there's another perspective, especially if the problem we
are having (the LVCFK) with some Yamaha opl3sa2 cards on Vector Linux
(2.5??) is at least partially due to Plug and Play.

Rather than writing any more here, I'll refer you to
[http://twiki.org/cgi-bin/view/Wikilearn/SndcdYamahaOpl3Sax](http://twiki.org/cgi-bin/view/Wikilearn/SndcdYamahaOpl3Sax),
which isn't necessarily correct. So, how would I rewrite this page if
some of what I suspect is true? Maybe:

Plug and Play is an old (Microsoft/Intel) technology which allows cards
to be configured in software instead of by the use of hardware jumpers.

The software to establish the settings can be:

-   incorporated in an operating system (most versions of Windows?)
-   incorporated in the BIOS of a computer (most "modern" personal
    computers)
-   provided as a standalone utility for situations where neither of the
    above is applicable (dos or Linux on older computers)

Problems can arise.

One type of problem is when the software sets the resources (IRQ, I/O
address, DMA channels, memory "window") to "unusual" settings that don't
match the settings that the "normal" driver (or configuration utility)
for a given card expects. (I think this is what's happening with respect
to the Yamaha opl3sa2 sound card on computers that the LVCFK is
rebuilding.)

In that case, I think there are two possible solutions:

-   Pass the necessary parameters to the Linux driver module to use the
    non-standard settings (one example of that is mentioned on
    [http://twiki.org/cgi-bin/view/Wikilearn/SndcdYamahaOpl3Sax](http://twiki.org/cgi-bin/view/Wikilearn/SndcdYamahaOpl3Sax).

-   (For cards that support a non-volatile configuration (i.e., can
    maintain their configuration settings with the power off), or by
    booting to dos and then warm booting (no power shut off) to Linux):
    Use the standalone configuration utility to change the settings on a
    card to the (or one of the) standard settings.

*Just for the record, I am duplicating a lot of this information on
WikiLearn -- if it gets corrected here, I'll also correct it there.*

Retrieved from
"[http://alsa.opensrc.org/PnP](http://alsa.opensrc.org/PnP)"

[Category](/Special:Categories "Special:Categories"):
[Glossary](/Category:Glossary "Category:Glossary")

