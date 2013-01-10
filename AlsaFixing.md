AlsaFixing
==========

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

ALSA is unfortunately both rather complex and underdocumented. Therefore
there are resources like this Wiki to help people.

This section is about the steps needed to make sure your ALSA setup
works. There are other ALSA setup issue fixing pages, as part of the
official ALSA documentation, and this section supplements them.

Contents
--------

-   [1 If you hear no sound](#If_you_hear_no_sound)
    -   [1.1 Check the sound drivers for your card are
        active](#Check_the_sound_drivers_for_your_card_are_active)
    -   [1.2 Unmute the appopriate mixer
        channels](#Unmute_the_appopriate_mixer_channels)
    -   [1.3 Check whether your application uses OSS instead of
        ALSA](#Check_whether_your_application_uses_OSS_instead_of_ALSA)

If you hear no sound
--------------------

### Check the sound drivers for your card are active

First check that the ALSA drivers are installed and have recognized your
card: Make sure that /proc/asound/cards lists your card, as card number
zero. If not, make sure that the appropriate driver module is loaded. To
figure out which modules you need, use the `lspci | egrep audio`
command. This usually will list the name and type of your sound chipset.
The main ALSA website then contains a list of those chipsets and the
required drivers. As a wild guess, for most recent low cost AC97 based
motherboards and laptops, try the `snd-intel8x0` driver.

### Unmute the appopriate mixer channels

If your card's driver is installed and its name appears in
`/proc/asound/cards`, and you still hear no sound, the most likely cause
is that you haven't unmuted the right mixer channels and set their
volume to nonzero. Note that ALSA sort of misnomes the channels of the
mixers of many cards. Use 'alsamixer' to play around with the settings
of the most obvious sounding channels. There are often descriptions of
what the channels are in the AlsaDrivers section about specific sound
cards.

### Check whether your application uses OSS instead of ALSA

If you still hear no sound, your application may be set up to use OSS.
Check with your applications preferences to see if this is the case. The
best fix is to set you application up to use ALSA instead of OSS. If
your application does not support ALSA, there are three possible
solutions:

     * Make it use a sound server that uses ALSA for output.
     * Load the OSS compatibility modules for ALSA.
     * Use the aoss wrapper to run the application.

Details on OSS emulations are provided in the
[OssEmulation](/OssEmulation "OssEmulation") section.

Retrieved from
"[http://alsa.opensrc.org/AlsaFixing](http://alsa.opensrc.org/AlsaFixing)"

[Category](/Special:Categories "Special:Categories"):
[Troubleshooting](/Category:Troubleshooting "Category:Troubleshooting")

