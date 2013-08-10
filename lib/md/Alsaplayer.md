Alsaplayer
==========

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

A seed page until someone adds some real info.

Usage
-----

` `

       % alsaplayer --help
       
       Usage: alsaplayer [options] [filename <filename> ...]
       
       Available options:
       
         -c,--config file        use given config file for this session
         -h,--help               print this help message
         -i,--interface iface    use specific interface [default=gtk]. choices:
                                 [ text | gtk ]
         -I,--script file        script to pass to interface plugin
         -n,--session n          use this session id [default=0]
         -l,--startvolume vol    start with this volume [default=1.0]
         -p,--path path          set the path alsaplayer looks for add-ons
         -q,--quiet              quiet operation. less output
         -s,--session-name name  name this session "name"
         -v,--version            print version of this program
         --verbose               be verbose about the output
         --nosave                do not save playlist content at exit
       
       Player control (use -n to select a session other than the default):
       
         -e,--enqueue file(s)  queue files in running alsaplayer
         -E,--replace file(s)  clears and queues files in running alsaplayer
         --status              get some information about session
         --volume vol          set software volume [0.0-1.0]
         --start               start playing
         --stop                stop playing
         --pause               pause/unpause playing
         --prev                jump to previous track
         --next                jump to next track
         --seek second         jump to specified second in current track
         --relative second     jump second seconds from current position
         --speed speed         floating point speed parameter
           1.0 = normal speed, -1.0 normal speed backwards
         --jump track          jump to specified playlist track
         --clear               clear whole playlist
         --quit                quit session
       
       Sound driver options:
       
         -d,--device string    select specific device in output plugin
           for the ALSA plugin: [default="default"]
           for the JACK plugin: [default="alsa_pcm:playback_1,alsa_pcm:playback_2"]
         -f,--fragsize n       fragment size in bytes [default=4096]
         -F,--frequency n      output frequency in Hz [default=44100]
         -g,--fragcount n      fragment count [default=8]
         -r,--realtime         enable realtime scheduling (with proper rights)
         -o,--output output    use specific output driver [default=alsa]. choices:
                               [ alsa | null ]
       
       Experimental options:
       
         -S,--loopsong         loop file
         -P,--looplist         loop playlist
         -x,--crossfade        crossfade playlist entries

See also
--------

-   [http://www.alsaplayer.org/](http://www.alsaplayer.org/) - Official
    home page

Retrieved from
"[http://alsa.opensrc.org/Alsaplayer](http://alsa.opensrc.org/Alsaplayer)"

[Category](/Special:Categories "Special:Categories"):
[Software](/Category:Software "Category:Software")

