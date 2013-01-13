PCM
===

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

**PCM** is an abbreviation for "Pulse Code Modulation". PCM is how
digital audio is typically represented in a computer.

The audio signal is represented by samples of its instantaneous
amplitude taken at regular intervals (the sample period which is the
inverse of the sampling frequency). The representation of each sample
can take several forms. On CDs, a 16-bit integer is used. Plain old
telephony uses 8 bits with a non-linear coding (either A-law or u-law).
Studio equipment often used 24 or more bits. Floating point
representation is also possible. Alsa can use the following formats: S8
U8 S16\_LE S16\_BE U16\_LE U16\_BE S24\_LE S24\_BE U24\_LE U24\_BE
S32\_LE S32\_BE U32\_LE U32\_BE FLOAT\_LE FLOAT\_BE FLOAT64\_LE
FLOAT64\_BE IEC958\_SUBFRAME\_LE IEC958\_SUBFRAME\_BE MU\_LAW A\_LAW
IMA\_ADPCM MPEG GSM SPECIAL S24\_3LE S24\_3BE U24\_3LE U24\_3BE S20\_3LE
S20\_3BE U20\_3LE U20\_3BE S18\_3LE S18\_3BE U18\_3LE

Other representations than PCM are possible. For example it is not
necessary to have a one-to-one correspondance between the samples of the
audio signal and the numbers in the data stream. (Example: mp3)

Retrieved from
"[http://alsa.opensrc.org/PCM](http://alsa.opensrc.org/PCM)"

[Category](/Special:Categories "Special:Categories"):
[Glossary](/Category:Glossary "Category:Glossary")

