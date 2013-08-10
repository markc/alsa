Envy24control
=============

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Envy24control is a graphical utility for controlling cards based on the
envy24 or [ice1712](/Ice1712 "Ice1712") chipset, e.g., the Midiman Delta
series and the Terratec EWS and EWX series. It is supplied as part of
the [alsa-tools](/Alsa-tools "Alsa-tools") package. The utility allows
control of the digital mixer, channel gains and other hardware settings,
as well as displaying a level meter for each input and output channel.

\

[http://www.alsa-project.org/alsa/ftp/others/envy24control/envy24\_1.jpg](http://www.alsa-project.org/alsa/ftp/others/envy24control/envy24_1.jpg)

\
 The following options are available when invoking `envy24control`:

-   `-c card-number`
    Use the card specified by card-number rather than the first card.
    This is equivalent with `-Dhw:n` option where n is the card number.

-   `-D control-name`
    Use the card specified by control-name rather than the first card,
    normally this will be of the form `hw:n` where n is the sound card
    number (zero-based). This is only needed if you have more than one
    Envy24-based card or if your Envy24 card is not configured as the
    first card in your ALSA driver setup.

-   `-o outputs`
    Limit number of outputs to display. Default is 8.

-   `-i inputs`
    Limit number of inputs to display. Default is 10.

-   `-s outputs`
    Limit number of SPDIF outputs to display. Default is 2.

The controls may be a little daunting at first, not to mention the
potential confusion created with varying number schemes within the same
app (DAC0-7 vs CM1-8, etc). DAC analog vol controls are a direct gain
control of the analog signal at the analog line pre-amp. Take
envy24control in its default state. PCM Out 1/2 are directly routed to
H/W Out 1/2. This means that any PCM data that jack sends to
alsa\_pcm:playback\_1/2 (which is PCM Out 1/2 in envy24control) goes
directly to H/W Out 1/2, which is the analog rca line outs 1 and 2. Any
adjustments you make on the monitor mixer page will have no effect. The
analog adjustments DAC0 and DAC1 are your only control.

If you route H/W Out1/2 to Digital Mix L/R, respectively, now you are
going to hear whatever audio is on the 'Monitor Mixer'. DAC0 and 1 still
need to be up, they are at the analog preamp level so always have to be
up no matter what you assign to your H/W Outs. Now that you are
monitoring the Digital Mix, you need to 'send' audio to the Mix to be
able to hear anything. On the 'Monitor Mixer' tab, what you will hear is
what can be seen in the left-most, large Digital Mixer meter. To 'send'
audio there, simply unmute and raise the levels for whatever channels
you want to monitor.

For example, to duplicate the earlier configuration (PCM1/2 directly
routed to H/W1/2), unmute and raise the level completely for the
\*Left\* side only on PCM Out1. Ditto for PCM Out 2, except just the
\*right\* side. Using a typical stereo wav file being played back should
show you how audio appears on the Digital Mixer as you made the
adjustments. Does it make sense why left on 1 and right on 2? PCM1 is
the left channel of a typical stereo audio signal, PCM2 is the right. If
you were to up both left and right on PCM1, you are sending the left
half of a signal to both sides, creating a mono signal. Do it on both
PCM Out 1 and 2, and you have a mono signal at twice the amplitude. I
used PCM Out 1/2 here as examples, using a typical stereo wav file as an
audio source, but this applies to all the ins/outs, etc.

Now, to monitor some live inputs, head down to any of the HW In
channels, and unmute/up level on an In channel that you have an input on
(mic, guitar, etc). Make sure to up the level at the analog pre-amp as
well, making sure to account for the numbering difference (H/W In 3 is
controlled by ADC2, etc). At this point I sometimes run 2 instances of
envy24control (yup you can do that) so I can watch the level meter while
adjusting the proper ADC. Once that is adjusted, unmute and raise level
on the monitor mixer tab and the audio will be sent to the Digital Mixer
and you should hear it. That's that...

The IPGA0-7 adjustments on the analog page is an additional gain boost
for line inputs. If you turn up an ADC all the way on a given channel,
and the signal is still not hot enough, this amplifies it internally,
thus adding distortion. In my opinion, anytime you use these you are
band-aiding a problem somewhere else.

Retrieved from
"[http://alsa.opensrc.org/Envy24control](http://alsa.opensrc.org/Envy24control)"

[Category](/Special:Categories "Special:Categories"):
[Alsa-tools](/Category:Alsa-tools "Category:Alsa-tools")

