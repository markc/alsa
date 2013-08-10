Midiman Quattro .asoundrc
=========================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Put the following into your [.asoundrc](/.asoundrc ".asoundrc") file.
This includes seperate stereo support and four channel support. Remember
that the quattro can only do stereo i/o for 96000hz 24bit, 2i/1o or
1i/2o at 48000hz 24bit, 4i/4o at 48000hz 16bit in windows and mac
environments. YMMV in Linux :)

.asoundrc
=========

     # The Quattro seems to only have two pcms, not 3.
     # quattro1 is pcm0 

           pcm.quattro1 {
                     type hw
                    card 1
            device 0
             }
     
              ctl.quattro1 {
                     type hw
                     card 1
             }
        
     # quattro2 is pcm1 

             pcm.quattro2 {
                     type hw
                    card 1
            device 1
             }
     
              ctl.quattro2 {
                     type hw
                     card 1 
             }
     #----    

     #
     # compose 4 channels from two channel x two devices, hw:1,0 and hw:1,1
     #

     pcm.quattro {
            type multi;

            slaves.a.pcm "hw:1,0";
            slaves.a.channels 2;
            slaves.b.pcm "hw:1,1";
            slaves.b.channels 2;

            bindings.0.slave a;
            bindings.0.channel 0;
            bindings.1.slave a;
            bindings.1.channel 1;
            bindings.2.slave b;
            bindings.2.channel 0;
            bindings.3.slave b;
            bindings.3.channel 1;
     }

     ctl.quattro {
            type hw;
            card 1;
     }


     #
     # remap 4 channels as interleaved using plug.
     # 

     pcm.q4 {
            type plug;
            slave.pcm "quattro";
            ttable.0.0 1;
            ttable.1.1 1;
            ttable.2.2 1;
           ttable.3.3 1;
     }



     ctl.q4 {
            type hw;
            card 1;
     }

     #
     # Use route plugin 
     #



     pcm.q41 {
            type route;
            slave.pcm "quattro";
            ttable.0.0 1;
            ttable.1.1 1;
            ttable.2.2 1;
            ttable.3.3 1;

     }

     ctl.q41 {
            type hw;
            card 1;
     }

     #----

See Also
========

-   [http://wiki.linuxquestions.org/wiki/M-Audio\_Quattro](http://wiki.linuxquestions.org/wiki/M-Audio_Quattro)
-   [http://justinhaynes.com/wiki/index.php?title=Thinkpad\_X61s\_Fedora\_10\_PlanetCCRMA\_M-Audio\_Configuration](http://justinhaynes.com/wiki/index.php?title=Thinkpad_X61s_Fedora_10_PlanetCCRMA_M-Audio_Configuration)

Retrieved from
"[http://alsa.opensrc.org/Midiman\_Quattro\_.asoundrc](http://alsa.opensrc.org/Midiman_Quattro_.asoundrc)"

[Category](/Special:Categories "Special:Categories"): [Sound
cards](/Category:Sound_cards "Category:Sound cards")

