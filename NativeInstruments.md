NativeInstruments
=================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

This page is under construction and information is being added and
updated.

Native Instruments devices are usable as soundcards under Linux thanks
to the snd\_usb\_caiaq module developed by Daniel Mack (very many thanks
to him for having made this possible in the first place). If you have
one of these devices and you got it setup properly, please correct and
add information, as currently all of this has been tested only on one
system with Rig Kontrol 2.

Contents
--------

-   [1 Kernel Configuration](#Kernel_Configuration)
-   [2 Pulse Audio](#Pulse_Audio)
-   [3 Jack configuration](#Jack_configuration)
-   [4 Buttons, pedals, knobs](#Buttons.2C_pedals.2C_knobs)
    -   [4.1 SuperCollider](#SuperCollider)

Kernel Configuration
--------------------

At least for the Rig Kontrol 2, important bug fixes are in the
2.6.31-rc4 kernel and later (probably even some earlier version should
have them, but I don't know which. Surely 2.6.31-rc4 has them). You can
use git to clone the latest kernel source.

Pulse Audio
-----------

If you're having problems with Pulse Audio, some issues with the
snd\_usb\_caiaq module have only recently been resolved; these changes
will be in 0.9.16. In the meanwhile, you can get the latest git version.

If you're on Ubuntu Jaunty, you can do the following:

add the following line to your /etc/apt/sources.list ` `

    deb http://ppa.launchpad.net/themuso/ppa/ubuntu jaunty main

and then run: ` `

    sudo apt-get update
    sudo apt-get install pulseaudio

\

Jack configuration
------------------

What follows is generic steps for configuring Jack.

1)Add following lines at the end of /etc/security/limits.conf (note:
this only works if your distribution uses PAM, as for example Ubuntu)
` `

    @audio - rtprio 99
    @audio - memlock unlimited
    @audio - nice -19

​2) Create if necessary the audio group and add yourself to it with: ` `

    sudo groupadd -f audio
    sudo gpasswd -a username audio

​3) Log out and log back in

​4) Configure JACK with Qjacktcl like this: check the Realtime box and
set Periods/Buffer to 2, then set Frames/Period to 512. Startup jack and
if it is working okay, return to the settings menu and set Frames/Period
to 256, restart jack and see how it is working. Keep on lowering
Frames/Period till you obtain a decent latency/xruns ratio.

With Rig Kontrol 2, on my system I'm pretty okay with 128 Frames/Period
- that's 5.8 milliseconds latency and xruns only occasionaly when i open
or close audio apps, otherwise it's steady.

Buttons, pedals, knobs
----------------------

Native Instruments devices (those with buttons, pedals, knobs etc.)
produce linux input events. It is therefore possible to detect those and
to make them trigger interesting things, such as midi. This is possible
and quite easy with SuperCollider
[http://www.audiosynth.com/](http://www.audiosynth.com/) . It could even
been done in Gizmod, though the best that has been done was making the
buttons on the RK2 type letters. SuperCollider is much more appropriate
for this purpose, so Gizmod was abbandoned.

### SuperCollider

The GeneralHID class permits to control devices that create input events
on linux and osx. Have a look the supercollider help page for
GeneralHID, it is pretty straightforward.

The following is the SuperCollider patch I use to make the Rig Kontrol 2
control mainly Rakarrack but even Jack-Rack and Freewheling for
instance. It is not perfect: when you press button 1 and 2 the preset in
rakarrack will change first to 20 (or whatevere \~preset is set to) and
then next/previous setup. Also, when you hit other buttons, you might
have to press them once in the first place and then they will start to
trigger on/off... these though are more of an issue with how rakarrack
manages midi and hopefully will be solved.

` `

    // RK2 with rakarrack. Once you run the code, you should connect the alsa midi 
    //out Out:0 of SuperCollider to the alsa midi in of rakarrack 
    (
    ~preset = 20; //default rakarrack preset. This is where the preset changes start from
    //these are the max and min values the pedal assumes. You can test this with
    // a.[\ped].debug_( true )  and then a.[\ped].debug_( false ) to stop.
    ~pedmax = 5000;
    ~pedmin = 0.046;
    ~efx = 116; // the channel on which rakarrack listens for turning on/off effects
    ~chan = 0; // the midi channel on which to send data
    //the following make buttons 1~7 output different velocities on the ~efx channel. 
    ~b1off = 0; 
    ~b1on = 1;
    ~b2off = 2;
    ~b2on = 3;
    ~b3off = 4;
    ~b3on = 5;
    ~b4off = 6;
    ~b4on = 7;
    ~b5off = 8;
    ~b5on = 9;
    ~b6off = 10;
    ~b6on = 11;
    ~b7off = 12;
    ~b7on = 13;
    ~cped = 1; //the midi control to which to assign the pedal 
    // some flags needed for the code
    ~f1 = true;
    ~f2 = true;
    ~f3 = true;
    ~f4 = true;
    ~f5 = true;
    ~f6 = true;
    ~f7 = true; 
    MIDIClient.init;
    m = MIDIOut.new(0,0);
    m.latency_( 0 ); 
    GeneralHID.buildDeviceList;
    d = GeneralHID.deviceList;
    //If you can't open the RK2, try changing the following to b = GeneralHID.findBy( 6092 );
    b = GeneralHID.findBy( 6092, 6505 );
    a = GeneralHID.open( b );
    a.add( \ped, [3,0] );
    a.add( \b1, [1,2] );
    a.add( \b2, [1,3] );
    a.add( \b3, [1,4] );
    a.add( \b4, [1,5] );
    a.add( \b5, [1,6] );
    a.add( \b6, [1,7] );
    a.add( \b7, [1,8] ); 
    m.program(~chan, ~preset);
    //Button 1 and 2 on the RK2 change preset in Rakarrack
    a.[\b1].action_( { |v| if( v.value == 1, {~preset = ~preset - 1; m.program(~chan, ~preset)},{} ) } );
    a.[\b2].action_( { |v| if( v.value == 1, {~preset = ~preset + 1; m.program(~chan, ~preset)},{} ) } ); 
    //Other buttons have each a flag variable: if it set to true, pressing the button
    //will send an "off effect" signal to rakarrack, otherwise viceversa. This is not good
    //because you can't know in the beggining which effects are on and which off, so it might be
    //the first time you push the button it won't do anything; then it should trigger on/off
    //for the effect. This trouble is caused by how midi is managed by rakarrack.
    a.[\b3].action_( { arg v;  
    if(v.value == 1,
    {if( ~f3 == true ,
    {m.control(~chan, ~efx, ~b3off); ~f3 = false}, 
    {m.control(~chan, ~efx, ~b3on); ~f3 = true} 
    )}
    )});
    a.[\b4].action_( { arg v;  
    if(v.value == 1,
    {if( ~f4 == true ,
    {m.control(~chan, ~efx, ~b4off); ~f4 = false}, 
    {m.control(~chan, ~efx, ~b4on); ~f4 = true} 
    )}
    )}); 
    a.[\b5].action_( { arg v;  
    if(v.value == 1,
    {if( ~f5 == true ,
    {m.control(~chan, ~efx, ~b5off); ~f5 = false}, 
    {m.control(~chan, ~efx, ~b5on); ~f5 = true} 
    )}
    )}); 
    a.[\b6].action_( { arg v;  
    if(v.value == 1,
    {if( ~f6 == true ,
    {m.control(~chan, ~efx, ~b6off); ~f6 = false}, 
    {m.control(~chan, ~efx, ~b6on);~f6 = true} 
    )}
    )});
    a.[\b7].action_( { arg v;  
    if(v.value == 1,
    {if( ~f7 == true ,
    {m.control(~chan, ~efx, ~b7off); ~f7 = false}, 
    {m.control(~chan, ~efx, ~b7on);~f7 = true} 
    )}
    )});
    //the values of the pedal are linearly reparametrized into 0~127. It the sends this value on CC ~cped
    a.[\ped].action_({ |v| m.control(~chan, ~cped, 1270000*((v.value - ~pedmin)/(~pedmax - ~pedmin))); });
    )

Retrieved from
"[http://alsa.opensrc.org/NativeInstruments](http://alsa.opensrc.org/NativeInstruments)"

