Via VT8235
==========

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Contents
--------

-   [1 onboard SYNTAX SV266A](#onboard_SYNTAX_SV266A)
-   [2 RedHat users](#RedHat_users)
-   [3 noises in xmms](#noises_in_xmms)
-   [4 VX8255, Shuttle mobo, Debian woody/2.4.24 kernel, alsa
    1.03](#VX8255.2C_Shuttle_mobo.2C_Debian_woody.2F2.4.24_kernel.2C_alsa_1.03)

onboard SYNTAX SV266A
---------------------

For example, an onboard SYNTAX SV266A motherboard **lspci** gives this:

` `

    00:11.5 Multimedia audio controller:
    VIA Technologies, Inc. AC97 Audio Controller (rev 50)

[http://www.d.kth.se/\~d98-jas/debian/debian-install-alsa.txt](http://www.d.kth.se/~d98-jas/debian/debian-install-alsa.txt)

I think I need ALSA, because I couldn't get mpg321 to play sound. I had
entered manually the following lines into the file /etc/modules and the
driver was recognised.

` `

    # nano /etc/modules
    ac97
    via82cxxx_audio

The mixer (**apt-get install cam**) worked fine, it started and the
faders produced ugly digital noises when moved.. I connected a walkman
headphones to the the microphone input (red) and another set of
headphones to the output (green). I whistled into the *microphone* and
adjusted the microphone volume fadres in cam and overall volume
faders... all worked. But mpg321 responded witha dumb message *libao -
OSS cannot set rate to 44100* and the cam mixer worked, but no mp3
sound.

Debian users! here there is a step-by-step... just cut and paste!
[http://www.d.kth.se/\~d98-jas/debian/debian-install-alsa.txt](http://www.d.kth.se/~d98-jas/debian/debian-install-alsa.txt)

First time, it did not compile .. I looked at the offending modules
(pcm20 radio-card) and took them out .. then it compiled fine, deb'ed,
rebooted.. hunky dory!! THX Jon!!

` `

    # /etc/init.d/alsa restart
    No ALSA driver installed
    No ALSA driver installed
    ALSA driver isn't running.
    No ALSA driver installed

    Starting ALSA sound driver (version none):modprobe: Can't locate module snd
     failed.

and of course *mpg321 blabla.mp3* says: *Can't find a suitable libao
driver. (Is device in use?)*. The quest continues. I have in
**/etc/alsa** two files

` `

    alsa-base.conf 
    alsa-source.conf

and in **/etc/modutils** one file

` `

    alsa-path

which has implanted itself into **/etc/modules.conf** because at some
stage I ran the **update-modules** script I presume. YET the path in
there points to something non-existent.

RedHat users
------------

RedHat users may get joy out of this link:
[http://www.redhat.com/mailing-lists/sound-list/msg04248.html](http://www.redhat.com/mailing-lists/sound-list/msg04248.html)

As far as I can see, the configuration-file where my card is mentioned
is **/etc/alsa/modutils/0.9**. Ok. Now I thought that maybe the card
isn't compiled into the alsa-module-doodaa. I found on
[http://www.sonic.net/\~rknop/linux/debian\_alsa.html](http://www.sonic.net/~rknop/linux/debian_alsa.html)
the variable...

`  `

    export ALSA_CARDS=ens1371

so I set it to via82xx and it failed, but via8233 IT COMPILED aargh,
man, am I dumb! And the

` `

    dpkg -i /usr/src/modules/alsa-modules-2.4.20_0.9.0rc7-2_i386.deb

didn't work. I see. So I looked for the file and found it in another
directory, under a different, but similar name:

` `

    dpkg -i /usr/src/alsa-modules-2.4.20_0.9+0beta12+3+p0+custom1_i386.deb

worked then and now alsa started! BUT still no joy.

` `

    # alsamixer
    alsamixer: function snd_ctl_open failed for default: No such file or directory

aaaaaaarrrrgghhhh (real men stay calm.) googling found others who failed
like me... Thorsten was no real consolation.

[http://www.geocrawler.com/archives/3/12350/2002/11/0/10257285/](http://www.geocrawler.com/archives/3/12350/2002/11/0/10257285/)

but Craig offered running a script that created the devices

[http://www.geocrawler.com/archives/3/12350/2002/4/0/8569022/](http://www.geocrawler.com/archives/3/12350/2002/4/0/8569022/)

so I ran

` `

    /usr/src/modules/alsa-driver/snddevices

lot of links created, but still alsamixer failed to work.

` `

    # lsmod
    snd-via8233             5024   0  (unused)
    snd-pcm                52608   0  [snd-via8233]
    snd-timer              11360   0  [snd-pcm]
    snd-ac97-codec         22976   0  [snd-via8233]
    snd                    27944   0  (autoclean) [snd-via8233 snd-pcm snd-timer snd-ac97-codec]
    soundcore               3972   0  (autoclean) [snd]

returns that the modules are there. I must have restarted

` `

    /etc/init.d/alsa restart

because, believe it or not it works all of a sudden. ((alsamixer)) mixes
and mpg321 plays. In another terminal window I accidentally executed

` `

    /usr/src/linux-2.4.20/debian/rules

which is still running.. boy what a fool I am, because after the next
reboot it will fry everything.  :-)

Like I thought. after a reboot, I am back to

` `

    alsactl store
    /usr/sbin/alsactl-0.9: save_state:963: No soundcards found...

and hey I got it working again. I had to edit the conf file (via the
symbol-link :-)

` `

    nano /etc/modutils/alsa

and enter

` `

    snd-via8233

instead of **snd-via82xx** DUH! alsa restart and it worked, alsamixer
starts. (the console brings a few messages about sharing IRQ10... and it
still works after a reboot, phew, and I thought it was as easy as
entering

` `

    apt-get install alsa

noises in xmms
--------------

I use custom kernel (2.4.23) with ALSA (0.9.8), my distribution is
debian woody (3.0). I experienced strange noises while playing sound
files with xmms (1.2.7). Other sound file players (mpg123) were ok.
Solution seems to be load ALSA drivers with dxs\_support set to 1 or 4
(both worked for me). Commands to do that can be:

` `

    # load module(s)
    modprobe snd-via82xx dxs_support=1
    # if nescessary, unmute PCM and Master
    amixer set PCM unmute "68%"
    amixer set Master unmute "68%"

To automate it in boot process, do:

` `

    # edit the file /etc/modutils/alsa
    # run update-modules command
    file /etc/modutils/alsa
    #(actually link on debian woody) may look like this:

and add these lines

` `

    # ALSA part

    alias char-major-116 snd
    # for ALSA < 0.9.0beta11
    alias snd-card-0 snd-card-via8233
    # for ALSA >= 0.9.0beta11
    alias snd-card-0 snd-via82xx 
    options snd-via82xx dxs_support=1

    # OSS/Free part

    alias char-major-14 soundcore
    alias sound-slot-0 snd-card-0

    # card #1

    alias sound-service-0-0 snd-mixer-oss
    alias sound-service-0-1 snd-seq-oss
    alias sound-service-0-3 snd-pcm-oss
    alias sound-service-0-8 snd-seq-oss
    alias sound-service-0-12 snd-pcm-oss

VX8255, Shuttle mobo, Debian woody/2.4.24 kernel, alsa 1.03
-----------------------------------------------------------

I found the above, as well as the rest of the ALSA documentation,
helpful, but what clinched it was a document from VIA's own linux audio
page,
[http://www.viaarena.com/?PageID=294\#md](http://www.viaarena.com/?PageID=294#md)

The problem I had seemed to be that the via-rhine module would yank
along kernel sound, and I couldn't remove the modules (with
rmmod/modprobe) without removing the via-rhine module, which would have
removed my ethernet support. I had to manually remove the modules, and
then edit my /etc/modules to put the alsa modules for my integrated card
above the load for via-rhine. On reboot, everything worked like a charm.
There were some errors in the logfile, as it still tried to load the
competing modules, but those were a small price to pay for having things
work.

Key points, summarized from Alsa and elsewhere to avoid others having to
search everywhere - Remove your alsa directory from /usr/src/modules,
and download a fresh tar, if you're having problems. Make sure to do a
make mrproper of your kernel source, but save off your .config first,
and copy it back before compiling. If you've appended a version number
to your kernel, make sure to check the makefile generated by Alsa's
configure - mine only got the first append, not the second one. Make
sure that you're compiling while running the kernel that you intend to
use - so, first compile and install the kernel without ALSA, then add
ALSA. Finally, make sure that no other, non-ALSA sound drivers are
currently running or installed.

Retrieved from
"[http://alsa.opensrc.org/Via\_VT8235](http://alsa.opensrc.org/Via_VT8235)"

[Category](/Special:Categories "Special:Categories"): [Sound
cards](/Category:Sound_cards "Category:Sound cards")

