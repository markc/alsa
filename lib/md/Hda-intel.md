Hda-intel
=========

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

I have a Medion MD 96367 With an audio card Intel HDA I'm on kubuntu
Linux userbuntu 2.6.22-14-generic \#1 SMP Tue Feb 12 07:42:25 UTC 2008
i686 GNU/Linux

\
 userg@userbuntu:\~\$ lspci | grep Audio 00:1b.0 Audio device: Intel
Corporation 82801H (ICH8 Family) HD Audio Controller (rev 03)

* * * * *

userg@userbuntu:\~\$ cat /proc/asound/card0/codec\#\* | grep Codec
Codec: Realtek ALC883 Codec: Realtek ID 268

I do everything on the
how-to :[[[1]](http://www.alsa-project.org/main/index.php/Matrix:Module-hda-intel)]
with alsa-driver-1.0.16rc2

\
 Thanks, Bruno

###### ========================

Bruno, upgrade to version 1.0.18.... I had the same problem with
openSuSE on a new MSI K9N2 with a Phenon 9600 with the ALC883...
installing the latest and greatest will solve your problem. This is how
I did it:

Remove your distro's alsa (if they do not have the latest and greatest
already.... openSUSE 11.0 only has 1.0.16 \*blech\* unless you go
factory.. then they have.... 1.0.17 \*whoop\* (1.0.17 didn't work
either. openSUSE tweaking the alsa source a little too much perhaps?!?).
At least at the time of this writing. In any case, if your distro has
the 1.0.18, try that FIRST! Next, if you are completely clueless on what
gcc is... stop.... skip this post, and either read up on compiling
software with gcc OR wait for your distro to catch up to the latest alsa
release \*cough SuSE\*cough\* ;).

If they don't and it's still broken... everyone knows removing alsa via
package managers will practically nuke your system good... Simply do
this as either root (no no) or sudo or 'su -' in a console:

In openSUSE 10.x+ c(k)onsole:

`# su -`

`# cp /etc/udev/rules.d/40-alsa.rules /opt/40-alsa.rules`

or wherever your udev is (if your distro supports it...it makes it alot
easier later.... you won't need to run the yast(2) to setup the
soundcard =)).

If you have the "find" package installed do:

` # locate alsa.pc `

(this is a text file that will give you the configure options your
distro used to install alsa on your system. In openSUSE 11.0 it shows:

`# locate alsa.pc`

`/usr/lib/pkgconfig/alsa.pc`

`# pico /usr/lib/pkgconfig/alsa.pc` \#\#or vi or kedit...whatever...

\

      prefix=/usr
      exec_prefix=/usr 
      libdir=/usr/lib
      includedir=/usr/include

\
 blah blah blah

Those 4 lines are what you need. (HINT: just add a `--` before each and
they are the ./configure options IE:

` ./configure --prefix=/usr --exec-prefix=/usr --libdir=/usr/lib --includedir=/usr/include `

and there you have it. Oh and the - in exec-prefix isn't a typo, it's
NOT exec\_prefix...well might not be.... have to try it ;).)

Okay Store that info somewhere safe for the time being. Next in the
console do:

` # rpm -qa | grep alsa | xargs rpm --erase --nodeps`

This will delete the base alsa packages.... without nuking your entire
system.

when that has finished do:

` # rpm -qa | grep alsa-lib | xargs rpm --erase --nodeps`

This removes the alsa-lib package... then:

` # rpm -qa | grep libasound | xargs rpm --erase --nodeps `

This removes a random gstreamer (I believe?) related file that kept me
from compiling the new alsa... once gone... alsa compiled flawlessly.

Okay, I will assume (making an arse of u n me, but..) that you have
downloaded the alsa packages direct from the alsa's main wiki page, Make
sure you have read the FAQ and the README's AND the tutorials on how to
install from source, You have, RIGHT???!?.... if not DO IT NOW.

Once that is done... YOU WILL NOT HAVE ANY AUDIO VIA ALSA AND MOST OF
YOUR audio players will choke a horrible death if you try to run them.
Don't.

Now then: READ THE INSTALL FROM SOURCE TUTORIALS AGAIN NOW..I will not
cover downloading and uncompressing as it is all spelt out in the
tutorials.....Learn them.... follow them.... if you d/l the source from
the website and did NOT use Mercurial (if you dunno what it is... you
DIDN'T. Skip all instructions related to HG or Mercurial.) Go directly
to the part which instructs you to ./configure.....wait a sec....
./configure?!? Mentioned that earlier.... and yes, now would be the time
to use it. So in the terminal/console window type/cut/copy and paste it:

` ./configure --prefix=/usr --exec-prefix=/usr --libdir=/usr/lib --includedir=/usr/include `

(You CAN do './configure --help' first if you wanna see all the whistles
n bells n stuff, you can do with it, but if you have like 500 gigs of
free space, it's better not to play around unless you KNOW what you're
doing. I mean it, really, KNOW and have read the FAQ \*hint\*).

After it has done configuring the source for your system it will tell
you if there were any errors or missing dependencies, If you do have
errors.... READ THE FAQ ;) .... and now it is time to run make:

` # make `

(which is generally the same as typing 'make all'...least in almost
every source I have bothered to mess with). If after running make, you
see in the final 4-5 lines of text the word "error", it fubared....
Google or read the FAQ or trouble shooting section to figure out what
went wrong. The god Google will have your answer 99.98% of the
time....(if you hate Google, use Y! \*ich\* or Jeeves...don't care ;).)
Just copy and paste the line with the 'error' in it into Google...
chances are that one of the millions of Linux users has the same or
similar problem and you can find an answer for it there.

If you see nothing but a couple of "Leaving directories" lines, then it
went okay and it is time to run:

` # make install `

F.Y.I. - Some folks will tell you it isn't good form and/or lazy to
compile anything in root mode as it could be a potential security risk,
not to mention you can root crash and burn Linux sooo easily... (Root is
god in your OS,) which may be true, but I don't think the good folks in
the alsa team will ship a root kit to you in the source....but either
way, I was already in root (cause I am lazy...) if you did sudo's above
use 'sudo make install' instead. And yer a good admin...proud of you.

Do the previous steps for all the ALSA source packages (using the same
./configure line in all source packages ....wait, nothing but Makefile
and README in one of them?!? Read the README. Or just type 'make' and
'make install' skipping the ./configure step =). Oh and pyalsa!?! wth?!?
use:

` # python setup.py install `

Now copy the udev rule from the beginning back:

`# su -`

`# cp /opt/40-alsa.rules /etc/udev/rules.d/40-alsa.rules`

You are now done..... reboot.... run the alsaconf and alsactl commands
in su- or sudo'd as per the TUTORIALS and README's and if you READ THE
TUTORIALS and I didn't totally confuse you, you should now have a
working alsa audio again on your ALC883. \*PHEW!\* Enjoy.

Retrieved from
"[http://alsa.opensrc.org/Hda-intel](http://alsa.opensrc.org/Hda-intel)"

