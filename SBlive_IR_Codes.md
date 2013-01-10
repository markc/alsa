SBlive IR Codes
===============

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

By Juhana Sadeharju \<kouhia at nic.funet.fi\> in an email to
alsa-devel.

Below are control codes for the SB Live IR remote control. The remote
could be used in music players, in Audacity, in Ardour, and any other
software. We should have a standard format for an info file which tells
the regions in audiofiles. Such info file (if exists) would tell where
to jump when I press "1" or "next" in the remote.

**SB Live remote control codes** as given by **amidi -d -p hw:0,0** ` `

       // Without "speaker" button hold down.
       F0 00 20 21 60 00 01 0A 41 44 51 2E F7  // 1           .. Number group
       F0 00 20 21 60 00 01 0A 41 44 71 0E F7  // 2
       F0 00 20 21 60 00 01 09 41 44 09 76 F7  // 3
       F0 00 20 21 60 00 01 09 41 44 51 2E F7  // 4
       F0 00 20 21 60 00 01 09 41 44 21 5E F7  // 5
       F0 00 20 21 60 00 01 09 41 44 1E 61 F7  // 6
       F0 00 20 21 60 00 01 0A 41 44 11 6E F7  // 7
       F0 00 20 21 60 00 01 0A 41 44 41 3E F7  // 8
       F0 00 20 21 60 00 01 0A 41 44 6E 11 F7  // 9
       F0 00 20 21 60 00 01 09 41 44 01 7E F7  // 0
       F0 00 20 21 60 00 01 0A 41 44 21 5E F7  // stop        .. Transport group
       F0 00 20 21 60 00 01 0A 41 44 1E 61 F7  // play/pause (>/||)
       F0 00 20 21 60 00 01 0A 41 44 3E 41 F7  // (|>) + slow
       F0 00 20 21 60 00 01 0A 41 44 7E 01 F7  // (|<) + previous
       F0 00 20 21 60 00 01 09 41 44 5E 21 F7  // (>|) + next
       F0 00 20 21 60 00 01 09 41 44 7E 01 F7  // (||>) + step
       F0 00 20 21 60 00 01 09 41 44 76 09 F7  // mute        .. Amplifier group
       F0 00 20 21 60 00 01 0A 41 44 46 39 F7  // vol -
       F0 00 20 21 60 00 01 09 41 44 46 39 F7  // vol +
       F0 00 20 21 60 00 01 09 41 44 31 4E F7  // eax         .. Menu group
       F0 00 20 21 60 00 01 09 41 44 41 3E F7  // options
       F0 00 20 21 60 00 01 09 41 44 6E 11 F7  // display
       F0 00 20 21 60 00 01 09 41 44 71 0E F7  // return
       F0 00 20 21 60 00 01 09 41 44 11 6E F7  // start
       F0 00 20 21 60 00 01 09 41 44 3E 41 F7  // close + cancel
       F0 00 20 21 60 00 01 0A 41 44 61 1E F7  // left (<<)   .. Browse group
       F0 00 20 21 60 00 01 0A 41 44 2E 51 F7  // right (>>)
       F0 00 20 21 60 00 01 0A 41 44 5E 21 F7  // up
       F0 00 20 21 60 00 01 0A 41 44 31 4E F7  // down
       F0 00 20 21 60 00 01 0A 41 44 01 7E F7  // select/ok
       
       // With "speaker" button hold down.
       F0 00 20 21 60 00 01 0A 41 44 50 2F F7  // 1           .. Number group
       F0 00 20 21 60 00 01 0A 41 44 70 0F F7  // 2
       F0 00 20 21 60 00 01 09 41 44 08 77 F7  // 3
       F0 00 20 21 60 00 01 09 41 44 50 2F F7  // 4
       F0 00 20 21 60 00 01 09 41 44 20 5F F7  // 5
       F0 00 20 21 60 00 01 09 41 44 1F 60 F7  // 6
       F0 00 20 21 60 00 01 0A 41 44 10 6F F7  // 7
       F0 00 20 21 60 00 01 0A 41 44 40 3F F7  // 8
       F0 00 20 21 60 00 01 0A 41 44 6F 10 F7  // 9
       F0 00 20 21 60 00 01 09 41 44 00 7F F7  // 0
       F0 00 20 21 60 00 01 0A 41 44 20 5F F7  // stop       .. Transport group
       F0 00 20 21 60 00 01 0A 41 44 1F 60 F7  // play/pause (>/||)
       F0 00 20 21 60 00 01 0A 41 44 3F 40 F7  // (|>) + slow
       F0 00 20 21 60 00 01 0A 41 44 7F 00 F7  // (|<) + previous
       F0 00 20 21 60 00 01 09 41 44 5F 20 F7  // (>|) + next
       F0 00 20 21 60 00 01 09 41 44 7F 00 F7  // (||>) + step
       F0 00 20 21 60 00 01 09 41 44 77 08 F7  // mute       .. Amplifier group
       F0 00 20 21 60 00 01 0A 41 44 47 38 F7  // vol -
       F0 00 20 21 60 00 01 09 41 44 47 38 F7  // vol +
       F0 00 20 21 60 00 01 09 41 44 30 4F F7  // eax        .. Menu group
       F0 00 20 21 60 00 01 09 41 44 40 3F F7  // options
       F0 00 20 21 60 00 01 09 41 44 6F 10 F7  // display
       F0 00 20 21 60 00 01 09 41 44 70 0F F7  // return
       F0 00 20 21 60 00 01 09 41 44 10 6F F7  // start
       F0 00 20 21 60 00 01 09 41 44 3F 40 F7  // close + cancel
       F0 00 20 21 60 00 01 0A 41 44 60 1F F7  // left (<<)  .. Browse group
       F0 00 20 21 60 00 01 0A 41 44 2F 50 F7  // right (>>)
       F0 00 20 21 60 00 01 0A 41 44 5F 20 F7  // up
       F0 00 20 21 60 00 01 0A 41 44 30 4F F7  // down
       F0 00 20 21 60 00 01 0A 41 44 00 7F F7  // select/ok

Note: Creative did not give the group names. The buttons (\<\<) and
(\>\>) in the browse group could be used for 4x backward and forward
playing as well.

Note: number 0 is alone on the line and next to the transport group. It
could be used in the transport control.

Note: speaker button makes no code itself but it works like the shift
key. Why the button is not named "shift" because it works as "shift"
button for all groups.

Note: there is no other "shift" button.

Note: "slow", "previous", "next", "step" and "cancel" are printed under
the buttons. So, "||\>" and "step" could have totally different
meanings.

Retrieved from
"[http://alsa.opensrc.org/SBlive\_IR\_Codes](http://alsa.opensrc.org/SBlive_IR_Codes)"

[Category](/Special:Categories "Special:Categories"): [Sound
cards](/Category:Sound_cards "Category:Sound cards")

