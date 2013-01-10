Gt
==

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

` `

    NAME
    ====
         gt - version of TiMidity MIDI to WAVE converter and player


    SYNOPSIS
    ========
         gt [-options] [directoryname | filenames ...] [-options]


    DESCRIPTION
    ===========
         Gt is a MIDI to WAVE converter using  Gravis  Ultrasound-compatible
         patch files, extended GUS patch files, or AWE-compatible SoundFonts
         to generate digital audio data from General MIDI files.

         The data can be stored in a file for processing,  or played in real
         time  through  an  audio device.   Gt will generate 6 and 4 channel
         sound output on systems with capable Alsa drivers  and  soundcards.
         Currently, there is only a single output driver, for Alsa.

         It's  not  necessary to give any filenames on the command line;  if
         there are midi files in the current directory,  gt will  find  them
         and  play  them.    You can also give a single directory name,  and
         gt will look in that directory for midi  files.    (This  automatic
         construction of play lists will not work for compressed files.)

         The  default display interface uses the ncurses library to show the
         notes being played and give other information.  The alternatives to
         this interface are described below under the  -i option  (they  are
         -int for ncurses in non-tracing mode,  and -id or -idt for the dumb
         interface).  As songs are playing, a moderate amount of control can
         be  exerted  with  keys  and the mouse (if the mouse works for your
         display window).  Key q or end or F10 exits.  Key V or up-arrow and
         v or down-arrow adjust the volume.   The space bar  pauses  playing
         or  resumes playing when paused.   Key n or page-down or F9 goes to
         the next midi song.   Key p or page-up goes to  the  previous  midi
         song.    Key r or home restarts the current midi song at the begin-
         ning.  Key f or right-arrow skips forward in the current song.  Key
         b or left-arrow skips backward in the current song.   Shifted  kays
         left-arrow  and  right-arrow  adjust the voices ceiling.   Kays F2,
         F3, and F4 change the interpolation algorithm.   Kays F5,  F6,  F7,
         and F8 change the patch set.   Key F11 toggles between wet and  dry
         mode.


         Here is what is shown on the ncurses display:

         line 1
              Program title.

         line 2
              Current  patchset,   interpolation  method,  loading mode.   A
              different patchset can be chosen with function keys F5-F8,  as
              indicated on the bottom line of  the  display.    A  different
              interpolation method can be chosen with function keys F2-F4 --
              also as indicated on the bottom line of the display.   Loading
              mode is either fast or full.   With fast  loading,   only  the
              first  velocity layer is loaded from extended GUS patches (for
              ordinary GUS patches, loading mode makes no difference).   You
              can toggle the loading mode with the shifted F key.

         line 3
              Program status messages and karaoke lyrics or other midi  text
              messages.    Fatal error messages are red if your display does
              color, otherwise they are shown in bold.   (And all the colors
              mentioned below come out in bold face on a non-color display.)
              Loading progress for patch files required for the next song is
              shown in cyan.  If there is a limit on the amount of memory to
              use for patches (see the -r option), the loading line displays
              the  proportion  of  available  memory  that  has  been  used.
              (Patches  used  for previous songs are purged from memory when
              necessary.) Lyrics and other midi text messages are in yellow.

         line 4
              Midi file being played or about to be played.   Just after the
              file name,  [GM],  [GS],  or [XG] may be shown,  which is  the
              synthesizer  type,   if  that  was specified in the midi file.
              After that, as screen space permits, a title,  copyright,  and
              author may be shown.

         line 5
              Elapsed time for the current song and the total time  it  will
                                       -3-
              take  to  play  it.    You can fast forward or rewind with the
              right or left arrow keys.  Key signature, time signature,  and
              tempo are shown in the middle of the line.   At the  right  is
              the master volume,  which will be adjusted by some midi songs,
              or you can adjust it yourself with the up and down arrow keys.
              You can use the clipping rate as a guide to how far  you  want
              to turn up the volume.



         line 7
              The  Ch means  midi  channel  number and is a label for the 16
              numbers below it,  referring to the 16 midi channels.   To the
              right is a predominantly blue voices bar indicating  how  many
              simultaneous  notes  are  being  played,   i.e.,   the current
              polyphony.  The very left part of the voices bar is shown with
              yellow + marks and indicates how full the Alsa  output  buffer
              is.  (If the buffer gets too low,  that means gt can't produce
              output fast enough,  and you may anticipate dropouts.)   Some-
              times  the bar will have a green middle part -- this shows the
              number of notes that were actually in the  music.    The  blue
              part  indicates notes added for various effects (reverb,  cho-
              rus, stereo, or tutti).

              A < mark on the voices bar shows where the voices ceiling  has
              been set.  The ceiling is the target maximum polyphony,  i.e.,
              number  of  simultaneously  sounding  notes,  that gt tries to
              remain below.   The number can be adjusted up or down with the
              shifted right and left arrow keys.    Higher  polyphony  gives
              better  sound  quality  but means more work for the cpu.   The
              default ceiling is 128,  and the default absolute  maximum  is
              256.

              To  the  right  of  the  voices bar are labels for the columns
              below.   The labels are Bnk for midi bank number ('0'  is  not
              shown;  percussion banks are shown below in yellow,  XG varia-
              tion  bank  numbers in cyan,  and the XG sfx bank in magenta),
              Prg for midi program number,  Vol for  the  midi  volume  con-
              troller,   Exp for  the  expression  controller,   Pan for the
              left-right panning controller,  S for the sustain pedal  (also
              shows portamento, sostenuto,  legato,  and soft pedal),  B for
              pitch bend (also shows modulation wheel with *).  R for rever-
              beration, C for chorus depth, c for celeste effect,  and X for
              miscellaneous, mostly unimplemented controllers.

              Though  they  are  displayed,   the legato and soft pedal con-
              trollers are not yet implemented.   You  can  click  with  the
              mouse on the R, C, or c labels to toggle reverberation, chorus
              effect, or celeste effect on or off.   (For XG songs,  celeste
              effect  is  actually variation effect,  and in the c column is
              shown with a V.)


         lines 9-24
              These 16 lines show events on  the  16  basic  midi  channels.
              Gt can  play  on  up to 64 channels,  for midi files that have
              port commands to play on several synthesizers,  but  there  is
              only room to show the first 16 in full on the display.   Notes
              from  higher  channels  do show up,  though,  and are shown in
              cyan.  After the number of the midi channel is the name of the
              patch chosen with the midi program command.   The  name  given
              here  is  the  name  for  the patch given in the configuration
              file, for non-percussion channels.   For a percussion channel,
              it's the drumset name.  If there is no name,  that means there
              was no program command given,  and  the  default  Grand  Piano
              program is being used, or the default drumset 0, for a percus-
              sion channel.  Or, for a drumset,  the absence of any name may
              be because no name for the drumset was given in the configura-
              tion file.

              In the middle area of the midi channel display the  notes  are
              shown.    Lower notes are to the left and higher to the right.
              There isn't room to show very high or very low notes, so these
              are clipped.   A digit from 1-9 indicates the  note  velocity.
              At the onset of the note, if it's playing a stereo patch, it's
              shown  in  magenta,  otherwise it's shown in red for a melodic
              note and yellow for a percussion note.   The decay and release
              phases of a note are shown in green,  and the sustain phase in
              blue.

              After that is the midi bank number in use on the channel, from
              000 to 127,  which for percussion channels is shown in yellow.
              The 000 for melodic bank 0 is left implicit.   Numbers in cyan
              are for XG variation banks.   The XG  sfx  bank  is  shown  as
              magenta  sfx  (if  your  configuration  does not supply an sfx
              bank, but you do have a bank 120, bank 120 is used for the sfx
              bank).   After this come the midi program number  and  current
              values for some midi controllers.

         bottom line
              Shown  here  are  labels for the function keys.   The Help and
              Mixer keys bring up subwindows.  In the Mixer window,  you can
              adjust speaker balance by mouse-clicking to the left or  right
              of  the  speaker letters.   Small letter l and r stand for the
              left and right rear speakers.

         lines 26 on
              If there is room in the display window, below the midi channel
              display,  the current play list of midi files is shown.    You
              can select a new song to play by clicking in the list.




    OPTIONS
    =======
         The  following  command line options are accepted by version 0.1 of
         gt:

         -h   Help.   This shows a one-page summary  of  the  options  being
              described here.  The path name of the current default configu-
              ration file is also shown,  and,  if you have set up alternate
              patch sets with if statements in your configuration file,  the
              names  of  these alternate patch sets are also shown (they can
              be chosen with the command line option -#\fInumber).

         -v   Copyright statement from Tuukko Toivonen.

         -o filename
              Place output on filename.    Assumes  output  mode  ``w  was
              selected  with  the  -Ow  option.   The special filename ``-
              causes output to be placed on stdout.

         -O mode
              Selects the output mode  from  the  compiled-in  alternatives.
              mode  must begin with one of the supported output mode identi-
              fiers. Run gt with the -h option to see a list.  The following
              identifier should be available in all versions:

         -Ow  Generate RIFF WAVE format output.   If output is directed to a
              non-seekable file,  or if gt is interrupted before closing the
              file,  the file header will contain 0xFFFFFFFF in the RIFF and
              data block length fields. The popular sound conversion utility
              sox is able to read such malformed files,   so  you  can  pipe
                                       -6-
              data  directly  to sox for on-the-fly conversion to other for-
              mats.


         Format options
              Option characters may be  added  immediately  after  the  mode
              identifier to change the output format.  The following options
              are recognized:



         8    8-bit sample width

         1    16-bit sample width

         l    Linear encoding

         U    uLaw (8-bit) encoding

         M    Monophonic

         S    Stereo

         q    Quadraphonic

         s    Signed output

         u    Unsigned output

         x    Byte-swapped output

         Note that some options have no effect on some modes.   For example,
         you  cannot  generate a byte-swapped RIFF WAVE file,  or force uLaw
         output on a Linux PCM device.


         -s frequency
              Sets the resampling frequency.   Not  all  sound  devices  are
              capable  of all frequencies -- an approximate frequency may be
              selected, depending on the implementation.

         -a   Turns on antialiasing.   Samples are  run  through  a  lowpass
              filter  before  playing,   which reduces aliasing noise at low
              resampling frequencies.   (With the sampling rate set  to  the
                                       -7-
              standard 44,100 samples per second,  there's no point to using
              this.)

         -k number
              Select  interpolation algorithm for resampling:   0 for linear
              interpolation,  1 for cspline interpolation,  2  for  LaGrange
              interpolation.

         -r number
              Set maximum of ram in megabytes to use up keeping patches from
              previously played midi files.   This should presumably be less
              than your total ram plus disk cache size.   The default is  60
              megabytes.  It probably doesn't matter unless you're using big
              sf2 soundfont patchsets.

         -F   Toggles fast loading mode.  With fast loading,  only the first
              velocity  layer is loaded in extended GUS patches.   It's lots
              faster -- quality suffers.

         -f   Toggles fast envelopes.   Some MIDI files  sound  better  when
              notes decay slower -- it gives the impression of reverb, which
              gt doesn't currently fully support.

         -d   Sets  "dry"  mode.   After notes are released,  their decay is
              governed by the patch data rather than  the  volume  envelope.
              This  is  economical  of polyphony,  but for some instruments,
              typically vibraphone,  ocarina,  and mandolin,  notes  may  be
              terminated  too suddenly.   Non-dry,  or "wet" mode is the de-
              fault.


         -S separation
              Tunes surround sound  separation.    Lower  values  give  more
              separation.    For 5.1 surround,  the default is 64.   For 4.0
              surround, the default is 95.

         -p voices
              Sets polyphony (maximum  number  of  simultaneous  voices)  to
              voices.

         -A amplification
              Multiplies the master volume by amplification%.

         -X curve
              With  the  value 0, the midi expression controller affects the
              volume linearly.  With 1 (the default) or 2, it affects volume
              exponentially.   Values 3, 4, or 5 use tables specific to  GM,
              GS, and XG.

         -V curve
              With  the  value  0,  the  midi  volume controller affects the
              volume linearly.  With 1 (the default) or 2, it affects volume
              exponentially.   Values 3, 4, or 5 use tables specific to  GM,
              GS, and XG.

         -C ratio
              Sets  the  ratio  of  sampling and control frequencies.   This
              determines how  often  envelopes  are  recalculated  --  small
              ratios yield better quality but use more CPU time.

         -# number
              Selects  patchset  when the configuration file has been set up
              appropriately.   See the FILES section below under if and else
              for how to do this.

         -L directory
              Adds directory to the library path.  Patch, configuration, and
              MIDI files are searched along this path.    Directories  added
              last will be searched first.   Note that the current directory
              is always searched first before the library path.

         -c file
              Reads an extra configuration file.

         -I number
              Uses the program number as the default instrument. Any Program
              Change events in MIDI files will override this option.

         -P file
              Uses  the patch file for every program except drums.   Program
              Change events will be ignored.  This is useful for testing new
              patches.

         -D channel
              Marks channel as a drum channel.    If  channel  is  negative,
              channel  -channel  is  marked as an instrumental channel.   If
              channel is 0, all channels are marked as instrumental.    (Sy-
                                       -9-
              sex  dumps  in  GS or XG midi files may mark channels as drums
              and will override this flag.)


         -Q channel
              Causes channel to be quiet.   If channel is negative,  channel
              -channel is turned back on.  If channel is 0, all channels are
              turned on.

         -U   Instructs gt to unload all  instruments  from  memory  between
              MIDI files.   This can reduce memory requirements when playing
              many files in succession.

         -i interface
              Selects  the user interface from the compiled-in alternatives.
              interface must begin  with  one  of  the  supported  interface
              identifiers.    Run gt with the -h option to see a list.   The
              following identifiers may be available:

         -id  The dumb interface -- plays files in sequence, prints messages
              according to verbosity level. The trace mode shows the current
              and total playing time.

         -in  The ncurses full-screen interface with interactive controls.

         Interface options
              Option characters may be added immediately after the interface
              identifier.  The following options are recognized:

         v    Increases verbosity.  This option is cumulative.

         q    Decreases verbosity.  This option is cumulative.

         t    Toggles trace mode.  Trace mode is the default for the ncurses
              interface,  so t turns it off.   Trace mode is not very useful
              for  the  dumb  interface.   The ncurses display in trace mode
              displays events in midi time.  That is, midi events, like note
              onsets, are displayed approximately at the time you hear them,
              though gt is working a second or so ahead in the song,  calcu-
              lating data to send to the output driver.   So midi time is  a
              little  behind  real time.   However,  the status of midi con-
              trollers is shown in real  time,   so  in  the  display,   the
              controllers  will  change  slightly  before you can hear their
              effects.

         -B fragments
              For the Linux sound driver,   selects  the  number  of  buffer
              fragments.    Increasing  the  number  of fragments may reduce
              choppiness when many processes are running.   Specify a  frag-
              ments  of  0 to use the maximum number of fragments available.
              The maximum number available is the default, and it's probably
              not useful to change that.


    FILES
    =====
         gt looks for the configuration file timidity.cfg at startup, before
         processing any options.   If it can't be accessed,  and the library
         path is changed with a -L option on the  command  line,   then  the
         default  file will be sought again along the new library path after
         processing all options,   unless  another  configuration  file  was
         specified with the -c option.

         Configuration  files define the mapping of MIDI programs to instru-
         ment files.   Multiple files may be specified,  and  statements  in
         later  ones  will override earlier ones.   The following statements
         can be used in a configuration file:

         -p voices
              Sets polyphony (maximum  number  of  simultaneous  voices)  to
              voices.

         -A amplification
              Multiplies the master volume by amplification%.

         -X curve
              With  the  value 0, the midi expression controller affects the
              volume linearly.  With 1 (the default) or 2, it affects volume
              exponentially.

         -V curve
              With the value 0,  the  midi  volume  controller  affects  the
              volume linearly.  With 1 (the default) or 2, it affects volume
              exponentially.

         -C ratio
              Sets  the  ratio  of  sampling and control frequencies.   This
                                       -11-
              determines how  often  envelopes  are  recalculated  --  small
              ratios yield better quality but use more CPU time.


         -s frequency
              Sets  the  resampling  frequency.    Not all sound devices are
              capable of all frequencies -- an approximate frequency may  be
              selected, depending on the implementation.

         -k number
              Select  interpolation algorithm for resampling:   0 for linear
              interpolation,  1 for cspline interpolation,  2  for  LaGrange
              interpolation,   3  for  cspline  interpolation  with low-pass
              filtering.

         -r number
              Set maximum of ram in megabytes to use up keeping patches from
              previously played midi files.   This should presumably be less
              than  your total ram plus disk cache size.   The default is 60
              megabytes.  It probably doesn't matter unless you're using big
              sf2 soundfont patchsets.

         -O mode
              Same as corresponding commandline option.

         dir directory
              Adds directory to the search path in the same manner as the -L
              command line option.

         source file
              Reads  another  configuration file,  then continues processing
              the current one.

         sf2 file [option]
              Reads the parameters and waveforms in an AWE-compatible Sound-
              Font  file.    Both  ".sbk" and ".sf2" SoundFonts can be used.
              Preceding patch mappings must list all patches that are to  be
              loaded from the file,  and the preceding bank/drumset keywords
              must  be  followed by sf2 or sbk (which are equivalent).   The
              options allowed are:

         banknumber
              The bank number given in the first preceding  "bank"/"drumset"
              statement  is to be used in place of the bank banknumber given
              in the SoundFont itself.


         bank number [option] [[#N ]name]
              Selects the tone bank to modify.   Patch mappings that  follow
              will  affect this tone bank.   The options allowed are sf2 and
              sbk,  which were described above.   The optional name  is  for
              the  sake  of the display interface,  so the bank can be shown
              with a meaningful name instead of just a  number.    The  name
              assigned  can  be  preceded  by  "#N ", for compatibility with
              Timidity++,  which otherwise complains about  the  extra  name
              argument.

         drumset number [option] [[#N ]name]
              Selects  the  drum set to modify.   Patch mappings that follow
              will affect this drum set.   The options allowed are  sf2  and
              sbk,   which were described above.   As for the bank statement
              described above, the name is for display.

         sfx  Selects the XG non-rhythm SFX bank to modify.   Patch mappings
              that follow will affect this tone bank.

         drumsfx1

         drumsfx2
              Select the XG rhythm SFX banks to modify.  Patch mappings that
              follow will affect these tone banks.

         number file [options]
              Specifies that the the MIDI program number in the current tone
              bank  or drum set should be played using the patch file.   op-
              tions may be any of the following:

         amp=amplification
              Amplifies the instrument's volume  by  amplification  percent.
              If no value is specified, one will be automatically determined
              whenever the instrument is loaded.

         note=note
              Specifies  a  fixed  MIDI note to use when playing the instru-
              ment.  If note is 0, the instrument will be played at whatever
              note the Note On event triggering  it  has.    For  percussion
              instruments,   if  no  value is specified in the configuration
              file, the default in the patch file will be used.


         tuning=cents
              Changes the pitch of the instrument.   cents is a signed quan-
              tity in units of 1/100th of a semitone,  so,   e.g.,   specify
              "+1200" to go up an octave.   The number must begin with a "+"
              or a "-".


         pan=panning
              Sets  the instrument's default panning.   panning may be left,
              right, center,  or an integer between -100 and 100,  designat-
              ing full left and full right respectively.   If  no  value  is
              specified,  the default in the patch file will be used.   Note
              that panning controls in MIDI files will override this value.


         keep={loop|env}
              Strangely  shaped  envelopes  are  removed  automatically from
              melodic instruments in GUS patches.    keep  can  be  used  to
              prevent stripping envelope or loop data.  (Stripping envelopes
              was  originally  the default for gt,  but in this version it's
              not.   So these options are no longer useful -- they are  kept
              for compatibility.  G.L.)


         strip={loop|env|tail}
              Force removal of loop or envelope information from all patches
              in the instrument, or strip the tail,  i.e. all data after the
              loop.   Some third-party instruments have  garbage  after  the
              loop, as evidenced by a clicking noise whenever the instrument
              is  played,   so  adding  the  strip=tail option will markedly
              improve sound quality.


         NOTE:   Whenever any filename ends in one of the  compiled-in  com-
         pression identifiers, such as .gz,  or .sht,  gt will pipe the file
         through  the  appropriate decompressor.   MIDI files often compress
         very well, so the ability to handle compressed files can be useful.

         The special filename ``- can be  used  on  the  command  line  to
         indicate that a MIDI file should be read from stdin.

    COPYRIGHT
    =========
         Copyright (C) 1995 Tuukka Toivonen.
         See AUTHORS below for additional copyrights.

         gt/TiMidity is free software; you can redistribute it and/or modify
         it  under  the terms of the GNU General Public License as published
         by the Free Software Foundation;  either version 2 of the  License,
         or (at your option) any later version.

         TiMidity  is  distributed  in the hope that it will be useful,  but
         WITHOUT ANY WARRANTY;  without even the implied  warranty  of  MER-
         CHANTABILITY  or  FITNESS  FOR  A  PARTICULAR  PURPOSE. See the GNU
         General Public License for more details.

    AVAILABILITY
    ============
         The latest release of the original  version  is  available  on  the
         TiMidity  Home Page,  URL http://www.clinet.fi/~toivonen/timidity/.
         (But the original version is no longer being maintained -- see  URL
         http://http://www.cgs.fi/~tt/discontinued.html.)      The   present
         modified  version  is at
         ftp://ling.lll.hawaii.edu/pub/greg/gt-0.3.tar.gz.


    BUGS
    ====
         8-bit and low-rate output sounds worse than it should.

         Eats more CPU time than a small CPU-time-eating animal.

    AUTHORS
    =======
         Tuukka Toivonen <toivonen@clinet.fi>
         Surround  sound,   reading extended GUS patches implemented by Greg
         Lee.
         HP-UX audio code, X-Motif interface,  icons and antialiasing filter
         by Vincent Pagel <pagel@loria.fr>
         Tcl/Tk  interface  and  AWE  SoundFont  support  by  Takashi   Iwai
         <iwai@dragon.mm.t.u-tokyo.ac.jp>
         Windows 95/NT audio code by Davide Moretti <dmoretti@iper.net>
         DEC audio code by Chi Ming HUNG <cmhung@insti.physics.sunysb.edu>
         S-Lang    user    interface    by   Riccardo   Facchetti   <riccar-
         do@cdc8g5.cdc.polimi.it>
         IW patchset support, karaoke,  AWE/XG enhancements,  much reworking
         of     the     code     by     Greg      Lee      <lee@hawaii.edu>,
         <greg@ling.lll.hawaii.edu>
         KDE  user  interface  "KMidi"  Copyright  (C)  1997  Bernd Johannes
         Wuebben <wuebben@math.cornell.edu>
         Effects filter by Nicolas Witczak <witczak@geocities.fr>,  see  URL
         http://www.geocities.com/SiliconValley/Lab/6307/).
         Portamento,   mod  wheel,   and  other enhancements from TiMidity++
         Copyright  (C)  1999  Masanao  Izumo  <mo@goice.co.jp>.    See  URL
         http://www.goice.co.jp/member/mo/hack-progs/timidity.html.
         alsa driver Copyright (C) 1999 Masanao Izumo <mo@goice.co.jp>
         bsd20   driver   Written  by  Yamate  Keiichiro  <keiich-y@is.aist-
         nara.ac.jp>
         esd driver by Avatar <avatar@deva.net>
         hpux_d driver Copyright 1997 Lawrence T. Hoff
         nas driver Copyright (C) 1999 Michael Haardt <michael@moria.de>
         XAW Interface from Tomokazu Harada <harada@prince.pe.u-tokyo.ac.jp>
         and Yoshishige Arai <ryo2@on.rim.or.jp>
         GTK+ interface by Glenn Trigg 29 Oct 1998
         The  autoconf  script  is  (C)Copyright  1998  by  Hiroshi Takekawa
         <t80679@hongo.ecc.u-tokyo.ac.jp>,  modified for automake  by  Isaku
         Yamahata  <yamahata@kusm.kyoto-u.ac.jp>,   modified for automake by
         Masanao Izumo <mo@goice.co.jp> (1998.11).
         The m4 autoconf definitions:   Configure paths for  ESD  by  Manish
         Singh  98-9-30,   stolen back from Frank Belew,  stolen from Manish
         Singh, Shamelessly stolen from Owen Taylor.
         Configure Paths for Alsa by Christopher  Lansdown  (lansdoct@cs.al-
         fred.edu),   29/10/1998,   modified for TiMidity++ by Isaku Yamaha-
         ta(yamahata@kusm.kyoto-u.ac.jp), 16/12/1998.

Retrieved from
"[http://alsa.opensrc.org/Gt](http://alsa.opensrc.org/Gt)"

[Category](/Special:Categories "Special:Categories"):
[Software](/Category:Software "Category:Software")

