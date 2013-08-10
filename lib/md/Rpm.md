Rpm
===

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

alsa rpms for redhat 9 :
[http://atrpms.physik.fu-berlin.de/dist/rh9/alsa/](http://atrpms.physik.fu-berlin.de/dist/rh9/alsa/)

For some newbies, rpms are the 'only' thing they can do without screwing
up an install. Not quite at that low level (though close) I went ahead
and got the rpm for ALSA rpmfind.net Below is a bit of my dialog with
the command line:

This is all that was required to get Soundblaster live 1024 running on
my redhat8. There are so many variables to detail in any config or
install I can't possibly detail them all so I'll just give the narrative
of trial and error. It only took me 10 concerted minutes to install the
drivers needed and that's including my 'error time'. Two rpms are
required for my rh8 install for soundblaster live:

-   sndconfig\*.rpm
-   ALSA.rpm
-   xmms\*.rpm (for whatever reason rh8 doesn't ship with mp3 driver!)

Install sndconfig first, then ALSA. I reversed that order as you'll see
below

* * * * *

` `

    root: rpm -i alsa.rpm
    /var/tmp/rpm-tmp.37726: line 2: sbin/insserv: No such file or directory
    Updating etc/rc.config...
    ERROR: fillup not found. This should not happen. Please compare
    /etc/rc.config and /var/adm/fillup-templates/rc.config.alsa
    and update manually.

just to be sure it installed: ` `

    root@dhcp-864-64 download]# rpm -qa alsa
    alsa-0.9.0_cvs20010727-0

So, what next I ask? The error message is a little more verbose than I'm
used to ;)

so...I got the sndconfig.rpm which having read
[http://www.linuxquestions.org/questions/history/37365](http://www.linuxquestions.org/questions/history/37365)
is what I need for redhat 8.

I installed that rpm after getting it from
[http://www.redhat.com/swr/i386/sndconfig-0.69-1.i386\_dl.html](http://www.redhat.com/swr/i386/sndconfig-0.69-1.i386_dl.html)

` `

    root: rpm -i sndconfig-0.69-1.i386.rpm

so the next step is...

Well easy enough: I went to the gnome menu\>system settings and clicked
soundcard detection. Viola! easy as 1.2.3 the little sounds played...
mp3s weren't working though with xmms so.... I did a search on xmms and
Eureka! RH8 doesn't ship with an mp3 driver. This site fixed that in a
hurry.
[http://staff.xmms.org/priv/redhat8/](http://staff.xmms.org/priv/redhat8/)
Let the rocking in the linux world begin :)

Retrieved from
"[http://alsa.opensrc.org/Rpm](http://alsa.opensrc.org/Rpm)"

[Category](/Special:Categories "Special:Categories"):
[Howto](/Category:Howto "Category:Howto")

