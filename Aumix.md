Aumix
=====

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

` `

     NAME
          aumix - adjust audio mixer
     
     SYNOPSIS
          aumix [-<channel option>[[+|-][<amount>]]|<level>|R[ecord]|P[lay]|q[uery]] 
             [-dhILqS] [-f <rc file>][-C <color scheme file>]
     
     DESCRIPTION
          This program adjusts the settings of an audio mixing device.  It can be used 
          from the command line, in scripts, or interactively with the keyboard or mouse.
     
     OPTIONS
        CHANNEL OPTIONS
          -v          main volume
          -b          bass
          -c          CD
          -i          igain
          -l          line
          -m          microphone
          -o          line out
          -p          PC speaker
          -s          synthesizer
          -t          treble
          -w          PCM
          -x          imix
          -1          line 1
          -2          line 2
          -3          line 3
     
          For each channel, q queries, + and - increment and decrement by one, or an amount 
          if one is specified.  If no + or - is given after the channel option, a number 
          sets a specific level (monophonically).
     
        OTHER OPTIONS
          -C color_scheme_file
                      specify the name of a file containing a color scheme.  This implies -I.  
                      This option can be used to force the ncurses interface with a GTK version.
                      No need to specify a filename in that case.
     
          -d device_file
                      specify the name of the mixer device (default is /dev/mixer)
     
          -f rc_file  specify file for saving and loading settings
     
          -h          display information on usage
     
          -I          run aumix interactively, using the full-screen ncurses-based interface.  
                      This is the default if no options are given, but must be specified in order 
                      to have aumix go into interactive mode after doing things non-interactively.
                      To force use of the ncurses interface with the GTK version, specify -C (no 
                      need to give a filename).
     
          -L          load settings from $HOME/.aumixrc, or /etc/aumixrc if the former is inaccessible
     
          -q          query all devices and print their settings
     
          -S          save settings to $HOME/.aumixrc
     
     EXAMPLES
          The command
     
                aumix -q -v75 -m 0 -c R -c+10 -m q
     
          prints all settings, sets volume to 75%, sets microphone to 0, sets CD to record, 
          increases the CD level by ten (both left and right), and prints the new settings for 
          the microphone.
     
          The .aumixrc file containing:
     
                vol:60:60
                wait:5000
                vol:50:50
     
          sets the volume to 60%, waits five seconds, then reduces the volume to 50%.  Note that
          "wait" lines will not be saved by aumix.  They must be added by hand.
     
     INTERACTIVE USE
          If no options are given on the command line, and aumix is compiled with ncurses, it will 
          run interactively.
     
        LAYOUT
          The left bank of controls is used for adjusting levels; the right bank is for adjusting 
          balance.  Mixing channels not supported by your hardware will not be shown.  Mixing 
          channels which are stereo-capable will have balance controls.
     
        KEYS
          The following keys control aumix in interactive mode:
     
          page up, page down, up and down cursor
                      select a new control.
     
          Tab, Enter, <, >, comma and period
                      toggle between level and balance controls
     
          +, -, [, ], left and right cursor and digits
                      adjust the setting of the current device.  The + and right cursor keys 
                      increase the level by 3%; the - and left cursor keys decrease it by the
                      same amount.  The [ key sets it to 0% and ] sets it to 100%.  The digits 
                      1 to 9 set it to 10% through 90%.  The digit 0 sets it to 100% (not 0%).
                      The same keys work analogously on the balance controls.
     
          Space       toggles between record and play for controls which are capable of this.
     
          |           centers the balance of the current device.
     
          K or k      show a description of the functions of keys
     
          L or l      load settings from $HOME/.aumixrc, falling back to /etc/aumixrc
     
          M or m      mute or unmute
     
          O or o      ``only'': mute all channels but the current one
     
          S or s      save settings to the rc file
     
          U or u      undo any muting
     
          Q or q      end the program
     
          ^L          refresh screen
     
          ^Z, ^D and ^C also have their normal function (the screen is refreshed when aumix is 
                      brought to the foreground).
     
        MOUSE
          In interactive mode, aumix can accept input from the mouse if gpm(8) is running and 
          aumix is compiled with gpm(8) support.  If gpm is not running but gpm support is 
          included, the message 'mouse off' will appear at the top of the screen, and only keyboard 
          input will be accepted.  With gpm(8) running, most functions can be performed through 
          the mouse.  The mouse is active whenever one of its buttons is held down.  While active, 
          it works in the following ways:
          o   over a control track, it sets the control to match the position of the mouse cursor.
          o   over a record/play indicator, it toggles the record/play state.
          o   over the 'Quit', 'Load', 'Save', 'Keys', 'Mute', 'Only', or 'Undo' labels at the top 
              of the screen, it causes those actions to take place.
     
     ENVIRONMENT
          The HOME variable is used.  When aumix is compiled with GTK+ support, DISPLAY is checked, 
          and if set is used.  LANG is used when aumix the ncurses screen is displayed.
     
     FILES
          Saved settings for the mixer are kept in the /etc/aumixrc and $HOME/.aumixrc files, 
          but can be kept anywhere if specified explicitly.  Color schemes are normally kept in the 
          directory given by DATADIR at compilation time, but are preferentially loaded from the 
          current directory and can be kept anywhere so long as the path to them is specified.  
          The format of these files is:
     
                item foreground background
     
          where item is one of 'active', 'axis', 'handle', 'hotkey', 'menu', 'play', 'record', or 
          'track' and foreground and background are one of 'black', 'red', 'green', 'yellow', 
          'blue', 'magenta', 'cyan', or 'white'.  The words should be separated by whitespace and 
          can be upper-, lower-, or mixed-case.  Lines not matching all these conditions are ignored.
          Some samples of color schemes are provided, named after the sort of terminal where they
          should be most suitable.
     
          If either foreground or background is given as '-', then the default color for that is 
          used.  If aumix is linked against ncurses, then the terminal's default fore or background 
          will be used; else the default foreground is white and the default background is black.
     
          An xpm icon is provided.
     
     VERSION
          This page corresponds to version 2.7.
     
     BUGS
          Suspending with ^Z may make the terminal difficult to use.
     
          Please send bug reports and other correspondence to the mailing list.  Past messages may 
          be read at
     
          <URL:http://lilax.org/wws/arc/aumix-l>
     
          and you may wish to join the list via
     
          <URL:http://lilax.org/wws/info/aumix-l>
     
          or by sending a message with just 'subscribe' in the subject to <aumix-l-request@lilax.org>. 
          To post without subscribing, omit "-request" from the address.
     
          Information such as the version of aumix, the architecture and operating system, and the
          model of sound hardware is sometimes needed to diagnose problems, so it is best if you
          include such details in any bug reports.
     
     SEE ALSO
          gpm(1), moused(8), sb(4), xaumix(1)
     

Retrieved from
"[http://alsa.opensrc.org/Aumix](http://alsa.opensrc.org/Aumix)"

[Category](/Special:Categories "Special:Categories"):
[Software](/Category:Software "Category:Software")

