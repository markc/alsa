CS4236B Mixer
=============

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

The ALSA drivers use many more of the features of the CS4236B than did
the drivers of days gone by. This gives you more flexibility in what you
can do with the chip. But with the added flexibility comes added
complexity, and sometimes a bit of confusion. This document will attempt
to reduce that confusion.

Note the 'B' in CS4236B. This is not the same animal as the earlier
CS4236. Although they use the same driver, the CS4236B is more than a
minor revision of the CS4236, which had no capture mixer or wavetable
input. If you have the earlier chip, much of this document won't apply
to you.

Be forewarned that research for this document began as simple trail &
error experimentation. However, I don't have the necessary hardware to
try out the Synth, Wavetable, DSP, and Mono inputs. So I can't be sure
if I have those documented correctly. I turned to the CS4236B
specification to fill in the holes in my experiments.

Contents
--------

-   [1 The Basics](#The_Basics)
    -   [1.1 Listening](#Listening)
    -   [1.2 Recording Without
        Monitoring](#Recording_Without_Monitoring)
    -   [1.3 Recording While Monitoring](#Recording_While_Monitoring)
    -   [1.4 Things Not To Do](#Things_Not_To_Do)

-   [2 Details](#Details)
    -   [2.1 Block Diagram](#Block_Diagram)
    -   [2.2 Control Description](#Control_Description)
    -   [2.3 Mixer Application Quirks](#Mixer_Application_Quirks)
        -   [2.3.1 amixer](#amixer)
        -   [2.3.2 alsamixer](#alsamixer)
        -   [2.3.3 gnome-volume-control](#gnome-volume-control)
        -   [2.3.4 kmix](#kmix)

    -   [2.4 Mixing Mixers](#Mixing_Mixers)

The Basics
----------

First, let's get some elementary stuff out of the way. If you are
familiar with mixers in general and came here looking for specifics,
feel free to skip ahead. But if you came here because you simply want to
know how to set your controls to hear or record what you want, I'll try
to provide a quick overview.

The following procedures assume starting with all switches turned off.

### Listening

1.  Unmute the analog input that you want to listen to and adjust its
    fader (volume control). Analog inputs include Mic, Line, CD, Synth,
    Mono, and Master Digital. Huh? Master Digital is an analog input?
    Yes. Master digital is the mixed audio from the digital sources
    which has been converted to analog and fed to one of the inputs of
    the analog output mixer. If you want to listen to any digital
    source, choose Master Digital for this step and, if you hear no
    sound yet, leave the fader up at about 90%.
    The analog mute switches and faders often appear on the mixer
    application's "Playback" or "In" view. (The faders may be duplicated
    on a "Capture" view, but you are better off using the "Playback"
    view because the duplicate faders don't actually work in some mixer
    apps.)
2.  If your desired input in step one was anything other than "Master
    Digital", you have probably stopped reading by now, and are
    hopefully listening to glorious stereo sound. If, on the other hand,
    you want to hear a digital source, now is the time to unmute it and
    adjust its fader. Digital sources include PCM, FM, Wavetable, and
    DSP.
    The digital mute switches and faders often appear on the mixer
    application's "Playback" or "Out" view.
3.  It doesn't hurt to leave unmuted any or all of the sources that you
    normally listen to, and their faders adjusted appropriately. This
    saves you the trouble of going back to the mixer app every time you
    change sources. Leaving unused inputs unmuted could increase the
    background hiss slightly, but you may not even notice it during
    casual listening. However, it is best to mute unused inputs when
    making a recording -- no sense in saving that hiss for posterity.

If you are still not hearing anything, you may have chosen the wrong
input. For instance, CD is the proper source to select if your player
application uses the analog output from your CD drive. But some
applications read the music digitally from the drive and send it to the
PCM input of the mixer. Also, Synth may seem like the obvious choice for
listening to MIDI files, but your soundcard may not have anything
actually hooked up to the Synth input. The same goes for the Wavetable
input. The only synthesizer inside the CS4236B is the FM synthesizer --
and even that will be silent until you load it with a utility such as
sbiload.

### Recording Without Monitoring

This method of recording doesn't let you hear the actual digital audio
that is being sent to your recording application, so you won't hear any
distortion that is occurring if you are overdriving the input mixer or
the ADC (analog to digital converter). Therefore you should pay careful
attention to the level meters in your recording application when using
this method. Why use this method? It allows you to record from digital
sources without introducing a feedback loop.

1.  For simple recording, make sure that Digital Loopback is muted. This
    will prevent a feedback loop. See Recording While Monitoring to see
    how to use this control to monitor the audio being recorded.
2.  Initially set Capture to 0% and Capture Boost to 100%. If you will
    be recording more than one input, you may need to drop Capture
    Boost.
3.  Unmute and turn on the capture switch for any analog inputs that you
    want to record and adjust their faders. Analog inputs that may be
    captured include Mic, Line, CD, Synth, and Master Digital. If you
    want to record one or more digital sources, choose Master Digital
    and, if you hear no sound from the digital sources yet, adjust its
    fader to about 90%.
4.  Unmute any digital sources that you want to record, and adjust their
    faders.
5.  The mix of inputs that you hear should be the same as what will be
    recorded (unless you have turned on one or more Capture Bypass
    switches or Mic Boost). But since you cannot hear the actual audio
    that will be recorded, it is important to pay close attention to the
    level meters on your recording application. Adjust the levels with
    Capture and/or Capture Boost.

### Recording While Monitoring

This method of recording lets you hear the actual digital audio that is
being sent to your recording application, allowing you to hear if any
distortion is occurring. This works best when recording only analog
sources.

1.  Ensure that the capture switch is off for Master Digital to prevent
    a feedback loop. This will prevent you from recording digital
    sources. (If you really, really want to use this method for
    recording with digital sources, feel free to experiment, but be
    aware that the feedback loop may add subtle (or not so subtle!)
    distortion to your recording. Listen for a tinniness effect being
    added to the sound.)
2.  Initially set Capture to 0% and Capture Boost to 100%. If you will
    be recording more than one input, you may need to drop Capture
    Boost.
3.  Unmute Digital Loopback and Master Digital, and initially set their
    faders fairly high.
4.  Ensure that all other inputs are muted, then turn on the capture
    switch for any analog inputs (except for Master Digital) that you
    want to record and adjust their faders.
5.  Adjust the levels with Capture and/or Capture Boost while watching
    the level meters on your recording application. If any distortion is
    occurring in the conversion from analog to digital, you should be
    able to hear it, and adjust Capture and/or Capture Boost to correct
    it. When using this method, the Digital Loopback and Master Digital
    faders will affect the level that you hear, but not the recording
    level.

### Things Not To Do

Because the ALSA driver gives you so much control of the CS4236B's
mixer, it allows great flexibility in what you can do. It also allows
you to do some things that maybe you ought not to. This section
discusses a few of the things you should probably avoid.

-   Don't unmute Digital Loopback when the capture switch for Master
    Digital is on.

-   Don't unmute Digital Loopback when the capture switch for Analog
    Loopback is on and Master Digital is unmuted.

Either of the above two items will create a feedback loop. If you are
lucky, the levels will be high enough to blast you with feedback's
familiar squeal, and you will immediately correct your mistake. If you
aren't so lucky, the levels won't be high enough to make the distortion
obvious, and only later when you are listening closely to your recording
will you notice that things sound a bit tinny.

-   Don't turn on Line Capture and Line Capture Bypass at the same time.

-   Don't turn on Synth Capture and Synth Capture Bypass at the same
    time.

The capture bypass switches bypass the gain control for these analog
inputs and send the audio signal straight to the capture mixer. If you
also have the capture switch on, the signal takes two paths to the
mixer, and strange things will result. You may notice a dead spot when
adjusting the fader, where the sound gets softer and then louder again.
It is likely that the signal is being distorted too.

The capture bypass switches are meant to be used in place of the capture
switches to allow you to use the input faders to adjust the output
volume only, without affecting the recording volume. (An audio purist
might also point out that this also eliminates the possibility of any
distortion being added to the recording by the gain control.) Obviously,
if you use a capture bypass switch when recording multiple inputs, you
must now depend on the other input faders to adjust your mix.

Details
-------

In this section we get into the nuts and bolts of the CS4236B mixer. If
you want to do something unconventional, the author hopes that this
information will help you figure out how to do it.

### Block Diagram

Here is a simplified block diagram showing the way the various mixer
controls inside the CS4236B relate to each other: ` `

                                           ..........
             +--- playback bypass--------->.        .
             |                             .        .>---------------------- mono
             |                +- mute ---->.        .                        out
             |                |            ..........
             |                |
             |                +------------MONO OUTPUT ---+
             |                                            |
             |                             ..........     |
     MONO ---+- vol ------------ mute ---->.        .     |
                                           .        .     |
                                           .        .     |
      MIC ----- vol -+--- mute --- boost ->.        .     |
                     |                     .        .     |
                     |                     .        .     |
       CD ----- vol ---+---------mute ---->.        .     |
                     | |                   .        .     |
                     | |                   .        .     |
     LINE -+--- vol -----+-------mute ---->.        .>----+-+--------------- line
           |         | | |                 .        .       |                out
           |         | | |                 .        .       |
    SYNTH ---+- vol -------+---- mute ---->.        .       |
           | |       | | | |               .        .       |
           | |       | | | |               .        .       |
           | |       | | | |  +- mute ---->.        .       |
           | |       | | | |  |            ..........       |
           | |       | | | |  |                             |
           | |       | | | |  +------------------------------------------+
           | |       | | | |                                |            |
           | |       | | | |  +---------- ANALOG LOOPBACK --+            |
           | |       | | | |  |                                          |
           | |       | | | |  |            ...........                   |
           | |       | | | |  +- capture ->.         .                   |
           | |       | | | |               .         .                   |
           | |       | | | +---- capture ->.         .                   |
           | |       | | |                 .         .                   |
           | |       | | +------ capture ->.         .                   |
           | |       | |                   .         .                   |
           | |       | +-------- capture ->.         .                   |
           | |       |                     . CAPTURE .>- boost - vol -+----- pcm
           | |       +---------- capture ->.         .                |  |   out
           | |                             .         .                |  |
           | +-----------capture bypass -->.         .                |  |
           |                               .         .                |  |
           +-------------capture bypass -->.         .                |  |
                                           .         .                |  |
                              +- capture ->.         .                |  |
                              |            ...........                |  |
                              |                                       |  |
                              +--------------------------------+      |  |
                                                               |      |  |
                      +------------------ DIGITAL LOOPBACK -----------+  |
                      |                                        |         |
                      |                    ...........         |         |
                      +- vol --- mute ---->.         .         |         |
                                           .         .         |         |
                 DSP --- vol --- mute ---->.         .         |         |
                                           . MASTER  .         |         |
                 PCM --- vol --- mute ---->.         .>-- vol -+---------+
                                           . DIGITAL .
                  FM --- vol --- mute ---->.         .
                                           .         .
           WAVETABLE --- vol --- mute ---->.         .
                                           ...........

### Control Description

Here is information on some of the controls, including the range for
each fader, a description of the control's use, and additional notes.
` `

    CONTROL: Master Digital
        MIN: -94.5 db
        MAX:  12.0 db
       STEP:   1.5 db
        USE: This controls the master level for all digital inputs (PCM,
             FM, Wavetable, DSP, and Digital Loopback).  Unmuting Master
             Digital sends the audio to the analog output mixer.  Turning
             capture on sends the audio to the capture mixer.
      NOTES: This works on both sides of the DAC, with a range of -60 db
             to 0 db on the digital side, and a range of -34.5 to 12.0 db
             on the analog side.  Both sides combine to give an overall
             range of -94.5 to 12.0 db.

    CONTROL: PCM
        MIN: -94.5 db
        MAX    0.0 db
       STEP:   1.5 db
        USE: Controls the input level for the digital data coming in via
             the ISA bus, usually from a an application that plays audio
             (such as aplay).

    CONTROL: Synth
        MIN: -34.5 db
        MAX:   0.0 db
       STEP:   1.5 db
        USE: Controls the input level for the analog input sometimes
             connected to an external synthesizer.
      NOTES: This is an analog input for an external source (such as a
             Crystal Semiconductor CS9233 or a Yamaha OPL3LS), not an
             internal synthesizer.  The CS4236B's internal FM synthesizer
             uses the FM control.  If your soundcard has nothing connected
             to this input, it does nothing.

    CONTROL: Synth Capture Bypass
        USE: This is an alternative to the Synth capture switch.  It
             bypasses the Synth input level control and so gives no
             attenuation or gain.
      NOTES: You should not use Synth capture and Synth Capture Bypass
             simultaneously.

    CONTROL: FM
        MIN: -94.5 db
        MAX:   0.0 db
       STEP:   1.5 db
        USE: Controls the input level for the digital data coming in from
             the internal FM synthesizer.
      NOTES: Before the FM synthesizer will favor you with music, it needs
             to be loaded with instruments.  The sbiload utility (in the
             alsa-tools package) acts as a roadie for the FM synthesizer.
             Try
                 sbiload --help
             or
                 less /usr/share/doc/alsa-tools-*/sbiload/README

             for details.  (If the folks who assembled your eight-CD
             distro didn't bother to find space for this important
             utility, you can get it by downloading the alsa-tools package
             from http://www.alsa-project.org.)

    CONTROL: Wavetable
        MIN: -82.5 db
        MAX:  12.0 db
       STEP:   1.5 db
        USE: Controls the input level for the digital data coming in from
             the wavetable serial port.
      NOTES: This is a digital input for an external wavetable
             synthesizer.  The CS4236B has no internal wavetable
             synthesizer.  This control is only useful if your soundcard
             has a wavetable synthesizer connected to the CS4236B (such as
             a CS9236). And even then it won't be useful until the day
             when (if?) ALSA supports such a wavetable.

    CONTROL: DSP
        MIN: -94.5 db
        MAX:   0.0 db
       STEP:   1.5 db
        USE: Controls the input level for the digital data coming in from
             the DSP serial port.
      NOTES: This is a digital serial input for an external device.  If
             your soundcard has nothing connected to this input, it does
             nothing.

    CONTROL: Line
        MIN: -34.5 db
        MAX:  12.0 db
       STEP:   1.5
        USE: Controls the input level for the analog input typically
             connected to a "Line In" jack.

    CONTROL: Line Capture Bypass
        USE: This is an alternative to the Line capture switch.  It
             bypasses the Line input level control and so gives no
             attenuation or gain.
      NOTES: You should not use Line capture and Line Capture Bypass
             simultaneously.

    CONTROL: CD
        MIN: -34.5 db
        MAX:  12.0 db
       STEP:   1.5
        USE: Controls the input level for the analog input typically
             connected to a CD drive.

    CONTROL: Mic
        MIN: -24.0 db
        MAX:  22.5 db
       STEP:   1.5 db
        USE: Controls the input level for the analog input typically
             connected to a "Mic" jack.

    CONTROL: Mic Playback Boost
        MAX: 20 db
        USE: Gives you microphone a 20 db kick on the way to the analog
             output mixer.  Does nothing for what goes through the Mic
             capture switch.
      NOTES: If your microphone is so tired that it needs a kick to be
             heard in the capture mixer, you might try Analog Loopback
             capture instead of Mic capture. (Remember to unmute the Mic,
             and read the note for the Analog Loopback control to avoid a
             feedback loop.)

    CONTROL: Mono
        MIN: -45.0 db
        MAX:   0.0 db
       STEP:   3.0 db
        USE: Controls the input level for the monaural analog input, which
             might or might not be connected to your PC's speaker output.

    CONTROL: Mono Output
        USE: Combines the analog output's stereo channels into a monaural
             channel and routes it to the mono output, which might or
             might not be connected to your PC's speaker.

    CONTROL: Mono Playback Bypass
        MAX: -9 db

    CONTROL: Capture
        MIN:   0.0 db
        MAX:  22.5 db
       STEP:   1.5 db
        USE: This controls the master level for all inputs that have their
             Capture switch set (Master Digital, Synth, Line, CD, Mic, and
             Analog Loopback).

    CONTROL: Capture Boost
        MIN: -18.0 db
        MAX:   0.0 db
       STEP:   6.0 db
        USE: This extends the range of the Capture control in 6 db steps.
      NOTES: When mixing multiple analog inputs, it may be necessary to
             reduce this control to prevent overloading.

    CONTROL: Analog Loopback
        USE: Turning capture on will route the analog output to the
             Capture mixer.  This is the only way to capture the Mono
             input, and an alternative way to capture the other analog
             inputs.  But I suspect this exists mostly for compatibility
             with software that was designed to interface with earlier
             soundcards which had no capture mixer.  On those soundcards
             this was the only way to record multiple analog sources.
      NOTES: If you have capture on for Analog Loopback, and unmute both
             Digital Loopback and Master Digital, you will create a
             feedback loop.  Unless you want your dog to start barking,
             this is probably not something you should do.

    CONTROL: Digital Loopback
        MIN: -94.5 db
        MAX:   0.0 db
       STEP:   1.5 db
        USE: Unmuting Digital Loopback will route the captured digital
             output to the digital mixer.  If you are capturing analog
             inputs and wish to monitor the digital audio being recorded,
             you would mute the analog inputs and unmute Digital Loopback.
      NOTES: Be sure that you have capture off for Master Digital when you
             unmute Digital Loopback, or you will create a feedback loop.
             (Hush now, Spot!)

### Mixer Application Quirks

When used with the CS4236B, some mixer applications exhibit a few
quirks. You should be aware of them so that they don't sneak up and bite
you. The author is familiar with only these four mixer applications:

-   amixer (version 1.0.10)
-   alsamixer (version 1.0.10)
-   gnome-volume-control (version 2.10.2)
-   kmix (version 2.4)

All switches, except for two, on the CS4236B mixer are stereo pairs,
allowing separate control of the left and right channel. (The two
exceptions are Digital Loopback mute and Mono Playback Bypass.) Some
mixer applications don't allow individual control of each channel
switch, providing a single button for switching both channels. If you
never have the need to switch the channels individually, this won't be a
problem for you.

#### amixer

(No known quirks)

#### alsamixer

-   Six of the faders that appear in the "Capture" view are duplicates
    of faders in the "Playback" view. These duplicate faders don't work;
    use the faders in the "Playback" view. Only the Capture fader works
    in the "Capture" view.

-   Individual control of the stereo channels with the capture switches
    is supported, just not documented. Use the ; and ' keys for left and
    right, respectively.

#### gnome-volume-control

-   All five faders that appear in the "Capture" view are duplicates of
    faders in the "Playback" view. These duplicate faders don't work;
    use the faders in the "Playback" view.

-   There may be two Capture Boost controls on the playback panel. One
    works; the other is dead.

-   The gnome-volume-control has fake mute buttons for Capture and
    Capture Bypass. They merely set the levels temporarily to zero
    (without moving the indicators) and restore them to the indicated
    level when unmuted. Some may find these to be a convenience. Others
    will find them confusing, since they don't actually mute anything,
    if both are not "muted" sound can still be heard, and the levels can
    be raised externally while the indication is that it is "muted".

-   The gnome-volume-control mutes some controls when the levels are
    reduced to zero (Master Digital, Synth, Line, CD, Mic). It does not
    unmute them when the levels are raised again. Clicking the mute
    button when these controls are at zero will go through a three-phase
    cycle: unmute, unmute, mute.

-   There is no Analog Loopback control.

-   No individual switching of stereo channels (see above).

#### kmix

-   No individual switching of stereo channels (see above).

### Mixing Mixers

To avoid confusion, it is probably best not to have more than one mixer
application running at any time. Normally there is no need, but if you
need a control that your favorite mixer app doesn't support fully, go
ahead and start another one. Also, some non-mixer applications (like
music players) have faders that control the mixer. In theory they should
all get along with each other, responding to your commands, and
displaying the current state of the CS4236B's mixer.

However, some applications play well with others, and some don't. Here
are some of the squabbles that you may have to mediate when running more
than one mixer application.

-   As mentioned above, gnome-volume-control automatically mutes some
    controls when its fader is reduced to zero, forcing you to manually
    unmute them later. This is true not only when you use that app to
    zero the fader, but any app.

-   Whenever a left channel mute or capture switch changes,
    gnome-volume-control forces the right channel switch to match it. So
    even if you use a mixer app that can mute and capture individual
    channels, doing so can be confusing as long as gnome-volume-control
    is running. The work around is to set the left channel first, then
    fix the right channel if it changes.

-   If a control is muted, gnome-volume-control no longer updates its
    display of the current level of the fader. If, while the control is
    muted, another app sets its fader to zero, then later unmutes it and
    raises the fader above zero, gnome-volume-control will force the
    fader to jump to the position it was at when first muted.

-   The current state of the following five switches is displayed
    correctly when gnome-volume-control is launched, but they are never
    updated to reflect external changes: Synth Capture Bypass, Line
    Capture Bypass, Mic Playback Boost, Mono Output, Mono Playback
    Bypass.

As stated above, these conflicts only appear when running more than one
application that controls the mixer. They are relatively minor quirks,
but you should be aware of them so as not to start doubting your sanity
when a control suddenly starts behaving differently than it usually
does. When something odd happens, just ask yourself, "am I running
another mixer app?"

---

This is a Wiki page, so feel free to update it if you have additional
information to share, or see errors that need correcting. If you think
that something might be an error, but you are not sure, you may want to
add a comment to the [CS4236B Mixer
Comments](?title=CS4236B_Mixer_Comments&action=edit&redlink=1 "CS4236B Mixer Comments (page does not exist)")
page.

Retrieved from
"[http://alsa.opensrc.org/CS4236B\_Mixer](http://alsa.opensrc.org/CS4236B_Mixer)"

[Category](/Special:Categories "Special:Categories"): [Sound
cards](/Category:Sound_cards "Category:Sound cards")

