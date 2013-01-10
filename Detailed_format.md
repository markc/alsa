Detailed format
===============

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

GUS extended patches
--------------------

### Patch header

` `

    bytes:  info:           starts at offset:

    22      magic                     0
    60      copyright                22
     1      instruments              82
     1      voices                   83
     1      channels                 84
     2      number of waveforms      85
     2      master volume            87
     4      datasize                 89
     7      "SF2EXT\0" magic         93 (new)
    29      unused                  100
     2      instrument number       129
    16      instrument name         131
     4      instrument size         147
     1      number of layers        151
     1      number velocity layers  152 (new)
    36      9 layer records of      153 (new)
              4 bytes each:
            velmin/velmax/left-samples/right-samples
     3      unused                  189
     1      layer duplicate         192
     1      layer number            193
     4      layer size              194
     1      number of samples       198
    40      10 layer records of     199 (new)
              4 bytes each (continues above array):
            velmin/velmax/left-samples/right-samples

    :::239 bytes total

### Sample header

` `

    bytes:  info:           starts at offset:

     7      sample name               0
     1      fractions                 7
     4      length                    8
     4      loop start               12
     4      loop end                 16
     2      sample rate              20
     4      low frequency            22
     4      high frequency           26
     4      base frequency           30
     2      finetune                 34
     1      panning (always 7)       36
     6      envelope rates           37  |
     6      envelope offsets         43  |  18 bytes
     3      tremolo sweep/rate/depth 49  |
     3      vibrato sweep/rate/depth 52  |
     1      sample mode              55
     2      scale frequency          56
     2      scale factor             58
     2      sample volume            60 (new?)
     1      volume envelope delay    62 (new)
     1      exclusive class          63 (new)
     1      vibrato delay            64 (new)
     6      mod envelope rates:      65 (new)
             attack/hold/decay/release/relB/relC
     6      mod envelope levels:     71 (new)
             attack/hold/decay/release/relB/relC
     1      mod envelope delay       77 (new)
     1      chorus effect send       78 (new)
     1      reverb effect send       79 (new)
     2      resonance                80 (new)
     2      cutoff frequency         82 (new)
     1      modEnvToPitch            84 (new)
     1      modEnvToFilterFc         85 (new)
     1      modLfoToFilterFc         86 (new)
     1      keynumToModEnvHold       87 (new)
     1      keynumToModEnvDecay      88 (new)
     1      keynumToVolEnvHold       89 (new)
     1      keynumToVolEnvDecay      90 (new)
     1      true panning (0-255)     91 (new)
     4      unused                   92
      (sample data follows)

    :::96 bytes total

Retrieved from
"[http://alsa.opensrc.org/Detailed\_format](http://alsa.opensrc.org/Detailed_format)"

[Category](/Special:Categories "Special:Categories"):
[MIDI](/Category:MIDI "Category:MIDI")

