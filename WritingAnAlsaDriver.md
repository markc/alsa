WritingAnAlsaDriver
===================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

There is a shameful lack of information on the Alsa website about how to
write a driver for Alsa. This is becoming a frequently-asked question on
the alsa-dev mailing list.

The best advice seems to be:

1.  Read the book "Linux Device Drivers" (It is available online at
    [http://www.xml.com/ldd/chapter/book/](http://www.xml.com/ldd/chapter/book/)
    )
2.  Look at the half-finished documentation for the woefully out-of-date
    0.4 kernel API linked from
    [http://alsa-project.org/documentation.php3](http://alsa-project.org/documentation.php3)
3.  Or look at another oudated Alsa 0.5 Developer document at
    [http://www.math.TU-Berlin.DE/\~sbartels/alsa/index.html](http://www.math.TU-Berlin.DE/~sbartels/alsa/index.html)
    (Isn't this the same document as \#2?)
4.  Find a driver for a card that is similar to the one you're writing
    for. Read the source code for it. Best to take a widely-used driver
    as your template, since the more esoteric drivers may be broken
    without anyone noticing for some time.
5.  Install a journaling filesystem before you begin development! You'll
    be crashing and fsck'ing your machine many times.

Update: Takashi has helped fill this gaping void:
[http://www.alsa-project.org/\~iwai/writing-an-alsa-driver/index.html](http://www.alsa-project.org/~iwai/writing-an-alsa-driver/index.html)

* * * * *

Alfons Adriaensen asked on the alsa-user mailing-list about the API
change for v1.0: Is there any document that describes this new API and
the rationale for it ?

Takashi responded: ... the doxygen output, i.e. online manual on web, is
already based on the new API. Basically, the difference is found only in
some snd\_pcm\_hw\_params\_xxx and snd\_pcm\_sw\_params\_xxx functions,
such as snd\_pcm\_hw\_params\_get\_access(). These functions returned
non-integer value as the value itself, e.g.

` `

    int snd_pcm_hw_params_get_access(const snd_pcm_hw_params_t *params);

with the new API, they return always the error code and store the value
in the given pointer uniformly, e.g.

` `

    int snd_pcm_hw_params_get_access(const snd_pcm_hw_params_t *params, snd_pcm_access_t *access);

so that you can check the error condition safely. btw, you can still use
the old codes by defining

`  `

    #define ALSA_PCM_OLD_HW_PARAMS_API
    #define ALSA_PCM_OLD_SW_PARAMS_API

before inclusion of asound/asoundlib.h. Takashi 20031123

Retrieved from
"[http://alsa.opensrc.org/WritingAnAlsaDriver](http://alsa.opensrc.org/WritingAnAlsaDriver)"

[Category](/Special:Categories "Special:Categories"):
[Howto](/Category:Howto "Category:Howto")

