RealtimeKernelAndPAM
====================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Contents
--------

-   [1 2006-12-12](#2006-12-12)
-   [2 2005-10-09](#2005-10-09)
-   [3 2005-09-30](#2005-09-30)
-   [4 2005-09-24](#2005-09-24)
-   [5 2005-08-18](#2005-08-18)
-   [6 2005-08-17](#2005-08-17)
-   [7 2005-07-19](#2005-07-19)

2006-12-12
----------

As of October the pam package 0.79-4 is in Debian unstable, which
already includes the rtlimits patch. So the packages at seite9.de should
no longer be used.

With any recent Linux system all you should need to do is adding the
following lines to /etc/security/limits.conf (the location may vary,
depending on your distribution):

` `

    @audio - rtprio 99
    @audio - memlock 250000
    @audio - nice -10

This would give all users in the group audio realtime privileges. You
might want to adjust the different values, particularly memlock.

2005-10-09
----------

I have put up a new version of the patched pam package for Debian
unstable at
[http://seite9.de/\~burkhard/pam\_debian\_rlimits/](http://seite9.de/~burkhard/pam_debian_rlimits/).
It works for me, but use it at your own risk.

2005-09-30
----------

Eric Dantan Rzewnicki [writes on the
linux-audio-user-mailing-list](http://lalists.stanford.edu/lau/2005/09/0718.html):

` `

    There are also pam debs for sarge here:
    http://techweb.rfa.org/debrfa/dists/sarge/main/binary-i386/

2005-09-24
----------

I am using Debian unstable and the files from the link below did not
work for me (the package would not build). Thus I patched the sources
myself and built a custom pam-package. As I spent quite some time on
figuring this out, I provide my package here in the hope that it will
save you some work:

[http://seite9.de/\~burkhard/pam\_debian\_rlimits/](http://seite9.de/~burkhard/pam_debian_rlimits/)

Just get libpam-modules\_0.76-24\_i386.deb and do dpkg -i. In case you
want to build the package yourself, grab the diff-, orig- and dsc-files
and do:

` `

    tar xvzf pam_0.76.orig.tar.gz
    gzip -d pam_0.76-24.diff.gz
    patch -p0 < pam_0.76-24.diff
    mv pam-0.76.orig/ pam-0.76
    cd pam-0.76/
    chmod u+x debian/rules
    sudo apt-get install fakeroot
    sudo apt-get build-dep pam
    dpkg-buildpackage -rfakeroot
    sudo dpkg -i ../libpam-modules_0.76-24_i386.deb

Of course, you use these files at your own risk. They work for me, with
a recent Debian unstable (from yesterday). The current Debian version of
pam is 0.76-23. The configuration file you might want to tweak is
`/etc/security/limits.conf`, but I believe the defaults are sensible.
Eventually you might also be interested in [how I created this
package](http://seite9.de/~burkhard/pam_debian_rlimits/WhatIdid) in
detail.

[Burkhard Ritter](/User:BurkhardRitter "User:BurkhardRitter")

*A huge thank you Burkhard!!*

2005-08-18
----------

Fernando (CCRMA) wrote to LAU with these two patches for Fedora systems
saying: If this is for fedora core then I have a patched pam in Planet
CCRMA... I'm including the patches as attachments (you may want to
change the default settings). Beware that if you change the maximum
rtpriority allowed to less than 100 you need a patch for 2.6.12, if has
a bug in that code section (I don't have a patch, I just use 100 as the
max which was the behavior of the previous lsm kernel module).

Here; [pam\_limits.patch](http://alsa.opensrc.org/pam_limits.patch) and
here;
[pam\_limits.skel.patch](http://alsa.opensrc.org/pam_limits.skel.patch)

There are some notes how to use real-time limits here;

[http://www.steamballoon.com/wiki/Rlimits](http://www.steamballoon.com/wiki/Rlimits)

2005-08-17
----------

I cannot believe how difficult it is to find any decent information
about how to deal with such a basic and essential part of the linux
audio tool chain. Apparently the PAM patches are available from here, at
least for Debian users:

[http://fsb.gotdns.org/\~froh/files/pam-rlimits\_debian/](http://fsb.gotdns.org/~froh/files/pam-rlimits_debian/)

2005-07-19
----------

Seed page, please add information of this vital topic - [Mark
Constable](/User:MarkConstable "User:MarkConstable")

Retrieved from
"[http://alsa.opensrc.org/RealtimeKernelAndPAM](http://alsa.opensrc.org/RealtimeKernelAndPAM)"

[Category](/Special:Categories "Special:Categories"):
[Software](/Category:Software "Category:Software")

