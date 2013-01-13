Hda
===

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Just type this two commands and it will play every sound you want:

` `

    modprobe snd_hda_intel

Other required module like snd-hda-codec will automatically be
installed.

For a permanent setup, you should run `alsaconf`

Note that :

-   Dolby digital may not work on some chips (like ALC883). This problem
    has been fixed and will be available with ALSA \> 1.0.14rc3
-   hda-intel driver duplicate stereo analog output on all other
    channels and on spdif output. You will be able to diable this
    feature with the mixer with Alsa \> 1.0.14rc3

If only certain aspects of your hardware work, e.g. the headphones but
not line out, then you can try passing one of the following model
arguments:

**Asus** ` `

    modprobe snd_hda_intel model=asus

\
 other possible models you can try are:

-   **3stack** *(3-jack in back and a headphone out)*
-   **3stack-digout** *(3-jack in back, a HP out and a SPDIF out)*
-   **5stack** *(5-jack in back, 2-jack in front)*
-   **5stack-digout** *(5-jack in back, 2-jack in front, a SPDIF out)*
-   **6stack** *(6-jack in back, 2-jack in front)*
-   **6stack-digout** *(6-jack with a SPDIF out)*
-   **w810** *(3-jack)*
-   **z71v** *(3-jack [HP shared SPDIF])*
-   **asus** *(3-jack)*
-   **uniwill** *(3-jack)*
-   **F1734** *(2-jack)*
-   **ref** *(Depends on the model used)*
-   **acer** *(Acer laptops)*
-   **acer-aspire** *(Acer Aspire laptops)*

Troubleshooting:

-   To get help be sure to include the content of the `codec#*` file
    (e.g. `/proc/asound/card1/codec#0`)
-   Sometime this chip has some weird problems on the **ASUS P5N-E SLI**
    mainboard (Realtek ALC883 6-channel CODEC), it seems that there's
    some IRQ conflict between the ohci\_controller and the audio
    controller (in the manual tells that they shares the same IRQ), the
    sound results choppy and distorted far away to been listenable.
    Still searching for a solution.
-   If in doubt, check the source code for alsa. There's a number of
    model codes not listed here which can be found under the
    sound/pci/hda/ folder; for example, patch\_realtek.c contains the
    model codes for the ALC883.

Retrieved from
"[http://alsa.opensrc.org/Hda](http://alsa.opensrc.org/Hda)"

[Category](/Special:Categories "Special:Categories"): [ALSA
modules](/Category:ALSA_modules "Category:ALSA modules")

