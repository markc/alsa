Sf2cfg
======

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

The utility program sf2cfg is in the src/ directory.

Using patch files requires setting up .cfg files:

-   A. See the other docs for GUS .pat files -- there are example .cfg
    files.
-   B. The utility program sf2cfg will generate .cfg files for AWE
    soundfonts. Usually no hand-editing will be necessary.

The banks/drumsets and names of patches must be given, since those that
are not declared will not be loaded from files (GUS patch files or sound
fonts) even though the patches are available. This way it's easy to
exclude certain patches from a sound font so as to load better ones from
a subseqently loaded font. Just don't declare them before you've asked
to load the font. It is, thus, unnecessary to use the "font" and "order"
statements implemented by Takashi Iwai. (It is also not possible, since
I've removed support for "font" and "order".)

When the same patch of the same bank or drumset is declared more than
once, only the first declaration counts. So put your best fonts first.

There is a utility sf2cfg to construct a cfg file for a sbk/sf2 sound
font, which spits out all the patches that are present in the font.
Also, I've included sample cfg files in the examples/ directory.

If you have several patch sets and you've set up timidity.cfg
appropriately, you can select among them with the command line switch
"-\#\<n\>". If a "source" statement in a cfg file is preceded, e.g., by
a line "if 2", then the "source" statement will be skipped over unless
"-\#2" was given on the command line. A line "else" will cause the next
"source" statement to be skipped if any non-zero n was requested by
"-\#\<n\>". If you've made use of this feature, "timidity -h" will list
the configurations you've set up.

Instead of using the command line "-p" to raise or lower the number of
simultaneously playing notes, you can do in a cfg file, e.g., put:
"voices 48" in timidity.cfg.

Here are all the command line parameters which can be set instead in the
config file:

` `

    -p  n        voices
    -A  n     amplification
    -C  n     control ratio
    -s  f     rate
    -k  n     interpolation
    -r  n     patch memory
    -X  n     expression curve
    -V  n     volume curve
    -O  letter    play mode

XG conventions have a few "sfx" instrument banks that don't fit in to
the normal midi bank set. In place of "bank" or "drumset", to make one
of these special banks, you can put:

` `

    sfx  for the melodic XG sfx bank,
    drumsfx1 for the first XG sfx drum set, and
    drumsfx2 for the second XG sfx drum set.

*Greg Lee, greg@ling.lll.hawaii.edu, February, 2000 -- July, 2004*

Retrieved from
"[http://alsa.opensrc.org/Sf2cfg](http://alsa.opensrc.org/Sf2cfg)"

[Category](/Special:Categories "Special:Categories"):
[Software](/Category:Software "Category:Software")

