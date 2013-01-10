TeamSpeak
=========

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

TeamSpeak 2 series are OSS-only and are currently not possible to be
used simlutaneously with many games (e.g. Quake3) on sound cards without
hardware mixing (is this true? Do soundcards with hardware mixing work
with those games? Yes. You might need an additional tweak though. You
need to disable the capture pcm stream for the OSS game you use. See the
[OssEmulation](/OssEmulation "OssEmulation") page for more docs on this.
The reason for this is: Only one app can have the capture stream open.
Either teamspeak or a game (even on soundcards that do hw mixing for
\_playback\_). A command like this [for enemy territory] should work:

` `

    echo et.x86 0 0 disable > /proc/asound/card0/pcm0c/oss

should do the trick. The above command assumes that card0 is the desired
sundcard)

Yes I am aware of this method and I have tried it (among many many other
tips and tricks) but it doesn't work for my chipset - AC97, see below)

TeamSpeak 3 series is under heavy development and \*maybe\* it will have
native ALSA support. Not that it will solve the problem of software
mixing...

Note: This will at least solve the software mixing problem partly.
Because a properly written alsa app should have no problem with using a
[dmix](/Dmix "Dmix")/[dsnoop](/Dsnoop "Dsnoop")/[asym](/Asym "Asym")
device.. But the problem still is that many games/apps still have OSS
support only.. Many times in a way not tweakable with
[aoss](/Aoss "Aoss")..

(So what would be the solution to this problem then? Is there any? This
means ALSA doesn't fully support OSS through its OSS emulation code,
right? Quote from the ALSA home page: "5. Support for the older OSS API,
providing binary compatibility for most OSS programs." Does the ALSA
project have plans here? Is there hope for times when I will be able to
play Quake3 while chatting on TeamSpeak and listening to smooth jazz
with xmms using the same card?)

Right now the answer to this is: Get a soundcard that does hw mixing
[cheap sblive, cs46xx based cards, etc..] or a soundcard with more than
one device, at least one combined p/c plus one playback only device
[sb128 pci, most es1370/es1371 based cards]

Unfortunately this is a no-go for us, laptop users (Realtec AC97 chipset
here: 0 [I82801DBICH4 ]: ICH - Intel 82801DB-ICH4)... if not buying an
external soundcard - PCMCIA or USB. PCMCIA is far too expensive and USB
is uncomfortable to carry and looks odd ;) - and I am not sure about the
ALSA support there) so we are really eagerly waiting for a solution to
this problem.

` `

    0-0/0: Realtek ALC202 rev 0

    Capabilities     : -headphone out-
    DAC resolution   : 20-bit
    ADC resolution   : 18-bit
    3D enhancement   : Realtek 3D Stereo Enhancement

I believe this is a very common chipset family in the laptops today...

\

-   The /proc file above does not exist on my system... however
    [Aoss](/Aoss "Aoss") worked for me (teamspeak 2.0.32)

` `

    aoss teamspeak

See also
--------

-   [http://www.teamspeak.org/](http://www.teamspeak.org/) - Official
    team speak web site

Retrieved from
"[http://alsa.opensrc.org/TeamSpeak](http://alsa.opensrc.org/TeamSpeak)"

[Category](/Special:Categories "Special:Categories"):
[Software](/Category:Software "Category:Software")

