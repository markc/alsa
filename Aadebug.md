Aadebug
=======

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

This is a simple shell script to aid ALSA audio debugging. If you are
requesting help on the mailing list or at a friend, it's output may be
very usefull. To use it, copy and paste the code below into an editor
and save it as `aadebug`, then execute `chmod +x aadebug`. Run the
script by typing `./aadebug` in a shell and send the result to the
person who is going to help you.

The script
----------

` `

    #!/bin/bash

    echo "ALSA Audio Debug v0.2.0 - $(date)"
    echo "http://alsa.opensrc.org/aadebug"
    echo "http://www.gnu.org/licenses/agpl-3.0.txt"
    echo
    echo Kernel ----------------------------------------------------
    uname -a
    cat /proc/asound/version
    echo
    echo Loaded Modules --------------------------------------------
    lsmod | grep ^snd
    lsmod | egrep -q '(^usb-midi|^audio)'
    if [ $? -eq 0 ]; then
       echo "Warning: either 'audio' or 'usb-midi' OSS modules are loaded"
       echo "this may interfere with ALSA's snd-usb-audio."
       if [ ! -f /etc/hotplug/blacklist ]; then
           echo "You should create a file '/etc/hotplug/blacklist' with"
       echo "both names on it to avoid hotplug loading them."
       else
       egrep -q '(^usb-midi|^audio)' /etc/hotplug/blacklist
       if [ $? -eq 1 ]; then
           echo "You should add both modules to '/etc/hotplug/blacklist'"
           echo "to avoid hotplug loading them."
       fi
       fi
    fi
    echo
    echo Proc Asound -----------------------------------------------
    if [ ! -d /proc/asound ] ; then
       echo "Warning: /proc/asound does not exist"
       echo "This indicates that ALSA is not installed correctly"
       echo "Check various logs in /var/log for a clue as to why"
    else
       cat /proc/asound/{cards,devices,hwdep,pcm,seq/clients}
    fi
    echo
    echo Dev Snd ---------------------------------------------------
    if [ ! -d /dev/snd ] ; then
       echo "Warning: /dev/snd does not exist"
    else
       /bin/ls -l /dev/snd
    fi
    echo
    echo CPU -------------------------------------------------------
    grep -e "model name" -e "cpu MHz" /proc/cpuinfo
    echo
    echo RAM -------------------------------------------------------
    grep -e MemTotal -e SwapTotal /proc/meminfo
    echo
    echo Hardware --------------------------------------------------
    lspci | egrep -i "(audio|video|multimedia|vga)"
    echo
    echo Interupts -------------------------------------------------
    cat /proc/interrupts
    echo
    if [ "$(echo $(uname -r) | grep 2.6)" -a -f /proc/config.gz ]; then
    echo Proc Config -----------------------------------------------
    zcat /proc/config.gz | egrep "(CONFIG_SOUND|CONFIG_SND)"
    echo
    fi

Changelog
---------

-   **2011-04-16:** Rearranged some items, removed modprobe.conf check,
    long list /dev/snd, add /proc/interrupts, AGPLv3 license change
-   **2007-02-10:**
    [ingomueller.net](/User:Ingomueller.net "User:Ingomueller.net") -
    Changed the link in the script to this page
-   **2005-10-11:** Pedro Lopez - I've included a test in aadebug to
    check if the OSS modules for USB devices are loaded, which is a
    common source of problems. Also included a suggestion pointing the
    user to `/etc/hotplug/blacklist` to solve the issue. Another
    addition is to include the contents of `/proc/asound/seq/clients`,
    which is useful to diagnose problems with ALSA sequencer.
-   **2005-02-27:** Many thanks to P Fudd, Ilja Kogan, vb, Russell
    Harris and Robert Wenner for suggestions to this script
-   **2004-06-02:** Changed test for /etc/modules.conf to
    /etc/modprobe.conf, thanks to Ilja Kogan
-   **2004-02-08:** Added a test to show kernel config parameters for a
    2.6 kernel with /proc/config.gz

Notes
-----

If you are new to linux then these notes on using the command line shell
may help. You may need to change to the root user, if so then type
`su -` and enter your root users password. When finished with executing
the script, type `control-d` to return to your normal user identity. You
can capture the output to a file by typing...

` `

    aadebug > aadebug.txt 2>&1

The `2>&1` will ensure that any error messages are also captured to the
`aadebug.txt` output file. If you want to get really fancy you could do
something like...

` `

    aadebug | mail -s"My aadebug output" to@someone

if you system is set up to allow this.

Retrieved from
"[http://alsa.opensrc.org/Aadebug](http://alsa.opensrc.org/Aadebug)"

[Category](/Special:Categories "Special:Categories"):
[Software](/Category:Software "Category:Software")

