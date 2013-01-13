Alsactl
=======

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

see the [Using alsactl to preserve volume
state](/Using_alsactl_to_preserve_volume_state "Using alsactl to preserve volume state")
page for a discussion on the usage of alsactl..

Usage
-----

` `

       Usage: alsactl <options> command
       
       Available options:
         -h,--help       this help
         -f,--file #     configuration file (default /etc/asound.state)
         -F,--force      try to restore the matching controls as much as possible
         -d,--debug      debug mode
         -v,--version    print version of this program
       
       Available commands:
         store <card #>  save current driver setup for one or each soundcards
                         to configuration file
         restore<card #> load current driver setup for one or each soundcards
                         from configuration file
         power [card #] [state]
                         get/set power state for one or each soundcards

Hint
----

Here is a hint for RedHat users from William M. Quarles on th LAU
mailing list...

I'm using RedHat, but this might work for you, too. Find out which
runlevel your computer uses when normally running (usually 3 for text
login or 5 for graphical login if you haven't messed with anything).

` `

       grep initdefault /etc/inittab

Then cd to /etc/rc.d/rcX.d (where X is your runlevel number). The
directory should be filled with symlinks to scripts that are located in
/etc/rc.d/init.d/. The ones that start with K do not get loaded (they
are the "kill" scripts that run on system shutdown), the ones that start
with S (they run on system startup) do get loaded. The numbers indicate
what order they get loaded in. So you need to make a link for ALSA.

` `

       ln -s ../init.d/alsasound SYYalsasound

where YY is 87 on my system (it might be different for Mandrake, I
haven't read the script). The alsasound script actually can tell SysV
when it should be loaded. To be sure that you picked the right number,
run **ntsysv**. alsasound should be part of the list now. Uncheck it,
then save the configuration. Open ntsysv again, recheck it, save the
configuration, and the load number will be automatically set to the
correct value.

Hint 2
------

On a Debian system you would do something similar with... ` `

       update-rc.d alsasound defaults #

where "\#" is a number described in the previous description.

I think on debian the default runlevel is 2.

Retrieved from
"[http://alsa.opensrc.org/Alsactl](http://alsa.opensrc.org/Alsactl)"

[Category](/Special:Categories "Special:Categories"):
[Alsa-utils](/Category:Alsa-utils "Category:Alsa-utils")

