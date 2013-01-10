AlsaModules
===========

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

20020715
--------

This small script provides some ALSA module related information. If the
ALSA module are not loaded then it provides a list of available drivers
and also gives an idea of what multimedia devices you have on board. If
ALSA modules are loaded then it gives the version and date and a list of
loaded cards. - [Mark
Constable](/User:MarkConstable "User:MarkConstable") 20020715

` `

    #!/bin/sh
    #
    # AlsaModules v0.0.1 15-Jul-2002 alsa@opensrc.org
    #
    # Copyright: Public Domain
    # License: GNU GPL http://www.gnu.org/licenses/gpl.html
    # 
    # Please send any modifications or suggestions to the above email address.
    #set -e
    #set -x

    if [ -f /proc/asound/version ]; then
        cat /proc/asound/version
        echo
        cat /proc/asound/cards
        echo
    else
        CNT=0
        VER=`uname -r`
        SND=`find /lib/modules/$VER/kernel/sound -type f -name "snd-*" | \
            sed s/\.o$// | sed 's/^\/.*\///' | sort`

        for i in $SND; do
            CNT=$((CNT+1))
            [ $CNT -eq 1 ] && A=$i ; [ $CNT -eq 2 ] && B=$i
            [ $CNT -eq 3 ] && C=$i ; [ $CNT -eq 4 ] && D=$i
            [ $CNT -eq 4 ] && printf "%-18s %-18s %-18s %-18s\n" \
                $A $B $C $D && CNT=0
        done
        echo
        cat /proc/pci | grep "Multimedia audio controller"
        echo
    fi

Retrieved from
"[http://alsa.opensrc.org/AlsaModules](http://alsa.opensrc.org/AlsaModules)"

[Category](/Special:Categories "Special:Categories"): [ALSA
modules](/Category:ALSA_modules "Category:ALSA modules")

