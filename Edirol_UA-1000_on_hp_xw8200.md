Edirol UA-1000 on hp xw8200
===========================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

I am new to Linux and ALSA. Hope that you can help. Thank you in
advance.

*[markc](/User:Markc "User:Markc") 22:24, 12 January 2007 (EST) Not sure
if I can help much but I feel that if you try a later version
[(K)ubuntu](http://distrowatch.com/table.php?distribution=kubuntu) or
[Knoppix](http://distrowatch.com/table.php?distribution=knoppix) liveCD
you might find that your USB device works better. You are running a
2.6.9 kernel and ALSA v1.0.6 which is close to a year old (ALSA is Aug
2004). I notice the changelog for ALSA 1.0.7 mentions "- add UA-1000
sample rate detection" so the latest ALSA v1.0.13 may have even more
fixes. If a recent liveCD proves you can play mp3s and simply record
from a mic then I would suggest having a look at the 32bit version of
[http://64studio.com](http://64studio.com). Good luck!*

[Johnlee](/User:Johnlee "User:Johnlee") 11:56, 25 January 2007 (EST)
With Fedora Core 5, UA-1000 behaves much better. However, I have now
decided to use RME Hammerfall DSP Multiface II and HDSP-PCI combination.
There seems to be a little better support in the web.

Before I boot up the computer, UA-1000 is powered on and its usb cable
is connected. The 'sample rate' dial is set to 'USER SET'. This way, the
USB is in a state that works under Windows XP.

1.  more /etc/redhat-release
    Red Hat Enterprise Linux ES release 4 (Nahant Update 4)
2.  uname -a
    Linux me.hp.com 2.6.9-34.ELsmp \#1 SMP Fri Feb 24 16:54:53 EST 2006
    i686 i686 i386 GNU/Linux

-   **Issue 1**

No sound heard on the speaker connected to the line out 1 of UA-1000.

     aplay -D hw:1 StPiano.WAV
     Playing WAVE 'StPiano.WAV' : Signed 24 bit Little Endian in 3bytes, Rate 48000 Hz, Stereo
     aplay: set_params:854: Sample format non available

-   **Issue 2**

I record using arecord from the "input 1" microphone. Then, try to
playback using UA-1000. I hear no sound from the speaker connected to
the line output 1 of UA-1000.

    arecord -c2 -Dplughw:1 -r 48000 -fS24_3LE -d120 ~/uafile.WAV

    aplay -Dplughw:1 /root/uafile.WAV -v
     Playing WAVE '/root/uafile.WAV' : Signed 24 bit Little Endian in 3bytes, Rate 48000 Hz, Stereo
     Plug PCM: Route conversion PCM (sformat=S24_LE)
     Transformation table:
     0 <- 0
     1 <- 1
     2 <- none
     3 <- none
     4 <- none
     5 <- none
     6 <- none
     7 <- none
     8 <- none
     9 <- none
     Its setup is:
     stream       : PLAYBACK
     access       : RW_INTERLEAVED
     format       : S24_3LE
     subformat    : STD
     channels     : 2
     rate         : 48000
     exact rate   : 48000 (48000/1)
     msbits       : 24
     buffer_size  : 1638
     period_size  : 410
     period_time  : 8541
     tick_time    : 1000
     tstamp_mode  : NONE
     period_step  : 1
     sleep_min    : 0
     avail_min    : 410
     xfer_align   : 410
     start_threshold  : 1230
     stop_threshold   : 1638
     silence_threshold: 0
     silence_size : 0
     boundary     : 1717567488
     Slave: Hardware PCM card 1 'UA-1000' device 0 subdevice 0

     Its setup is:
     stream       : PLAYBACK
     access       : MMAP_INTERLEAVED
     format       : S24_LE
     subformat    : STD
     channels     : 10
     rate         : 48000
     exact rate   : 48000 (48000/1)
     msbits       : 32
     buffer_size  : 1638
     period_size  : 410
     period_time  : 8541
     tick_time    : 1000
     tstamp_mode  : NONE
     period_step  : 1
     sleep_min    : 0
     avail_min    : 410
     xfer_align   : 410
     start_threshold  : 1230
     stop_threshold   : 1638
     silence_threshold: 0
     silence_size : 0
     boundary     : 1717567488

     aplay -c2 -Dplughw:1 -r 48000 -fS24_3LE  ~/uafile.WAV
     Playing WAVE '/root/uafile.WAV' : Signed 24 bit Little Endian in 3bytes, Rate 48000 Hz, Stereo

-   **Issue 3**

When I unplug the UA-1000's usb cable, my keyboard does not work

-   **My system configuration according to aadebug is:**

<!-- -->

     ALSA Audio Debug v0.1.0 - Wed Jan 10 11:15:23 PST 2007
     http://alsa.opensrc.org/index.php?page=aadebug
     http://www.gnu.org/licenses/gpl.txt
     Kernel ----------------------------------------------------
     Linux haloaudio2.hpl.hp.com 2.6.9-34.ELsmp #1 SMP Fri Feb 24 16:54:53 EST 2006 i686 i686 i386 GNU/Linux

     Loaded Modules --------------------------------------------
     snd_usb_audio          61729  2
     snd_usb_lib            15681  1 snd_usb_audio
     snd_intel8x0           34921  3
     snd_ac97_codec         65169  1 snd_intel8x0
     snd_pcm_oss            52345  0
     snd_mixer_oss          21825  3 snd_pcm_oss
     snd_pcm                91973  3 snd_usb_audio,snd_intel8x0,snd_pcm_oss
     snd_timer              27973  1 snd_pcm
     snd_page_alloc         13641  2 snd_intel8x0,snd_pcm
     snd_mpu401_uart        11329  1 snd_intel8x0
     snd_rawmidi            27749  2 snd_usb_lib,snd_mpu401_uart
     snd_seq_device         11849  1 snd_rawmidi
     snd                    56997  16  snd_usb_audio,snd_intel8x0,snd_ac97_codec,snd_pcm_oss,snd_mixer_oss,snd_pcm,snd_timer,snd_mpu401_uart,snd_rawmidi,snd_seq_device

     Modprobe Conf ---------------------------------------------
     alias snd-card-0 snd-intel8x0
     options snd-card-0 index=0
     install snd-intel8x0 /sbin/modprobe --ignore-install snd-intel8x0 && /usr/sbin/alsactl restore >/dev/null 2>&1 || :
     remove snd-intel8x0 { /usr/sbin/alsactl store >/dev/null 2>&1 || : ; }; /sbin/modprobe -r --ignore-remove snd-intel8x0

     Proc Asound -----------------------------------------------
     Advanced Linux Sound Architecture Driver Version 1.0.6 (Sun Aug 15 07:17:53 2004 UTC).
     Compiled on Feb 24 2006 for kernel 2.6.9-34.ELsmp (SMP).
     0 [ICH5           ]: ICH - Intel ICH5
                         Intel ICH5 at 0xf2600400, irq 201
     1 [UA1000         ]: USB-Audio - UA-1000
                         Roland UA-1000 at usb-0000:00:1d.7-8, high speed
      0: [0- 0]: ctl
     20: [0- 4]: digital audio playback
     27: [0- 3]: digital audio capture
     26: [0- 2]: digital audio capture
     25: [0- 1]: digital audio capture
     16: [0- 0]: digital audio playback
     24: [0- 0]: digital audio capture
     33:       : timer
     32: [1- 0]: ctl
     40: [1- 0]: raw midi
     48: [1- 0]: digital audio playback
     56: [1- 0]: digital audio capture
     cat: /proc/asound/hwdep: No such file or directory
     00-00: Intel ICH : Intel ICH5 : playback 1 : capture 1
     00-01: Intel ICH - MIC ADC : Intel ICH5 - MIC ADC : capture 1
     00-02: Intel ICH - MIC2 ADC : Intel ICH5 - MIC2 ADC : capture 1
     00-03: Intel ICH - ADC2 : Intel ICH5 - ADC2 : capture 1
     00-04: Intel ICH - IEC958 : Intel ICH5 - IEC958 : playback 1
     01-00: USB Audio : USB Audio : playback 1 : capture 1
     cat: /proc/asound/seq/clients: No such file or directory

     Dev Snd ---------------------------------------------------
     controlC0  midi1     pcmC0D0c  pcmC0D1c  pcmC0D3c  pcmC1D0c  timer
     controlC1  midiC1D0  pcmC0D0p  pcmC0D2c  pcmC0D4p  pcmC1D0p
     
     CPU -------------------------------------------------------
     model name      : Intel(R) Xeon(TM) CPU 3.80GHz
     cpu MHz         : 3802.518
     model name      : Intel(R) Xeon(TM) CPU 3.80GHz
     cpu MHz         : 3802.518

     RAM -------------------------------------------------------
     MemTotal:      2074956 kB
     SwapTotal:     2031608 kB

     Hardware --------------------------------------------------
     00:00.0 Host bridge: Intel Corporation E7525 Memory Controller Hub (rev 0c)
     00:1f.5 Multimedia audio controller: Intel Corporation 82801EB/ER (ICH5/ICH5R) AC'97 Audio Controller (rev 02)

Retrieved from
"[http://alsa.opensrc.org/Edirol\_UA-1000\_on\_hp\_xw8200](http://alsa.opensrc.org/Edirol_UA-1000_on_hp_xw8200)"

[Category](/Special:Categories "Special:Categories"): [Sound
cards](/Category:Sound_cards "Category:Sound cards")

