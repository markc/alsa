HowTo Asynchronous Playback
===========================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

  ------------------------------------------------------------------------- -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
  [File:Merge-arrows.gif](/File:Merge-arrows.gif "File:Merge-arrows.gif")   There is another article called [Asynchronous\_Playback\_(Howto)](/Asynchronous_Playback_(Howto) "Asynchronous Playback (Howto)") with a very similar content. **Please be bold an merge the two pages!**
  ------------------------------------------------------------------------- -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

**WARNING:** [Asynchronous Playback is part of a not safe subset of ALSA
for some Linux distributions that use pulse audio like Ubuntu. Please
consider using safer ways on your programs like polling if you are going
to use Pulse
Audio.](?title=Asynchronous_Playback_is_part_of_a_not_safe_subset_of_ALSA_for_some_Linux_distributions_that_use_pulse_audio_like_Ubuntu._Please_consider_using_safer_ways_on_your_programs_like_polling_if_you_are_going_to_use_Pulse_Audio.&action=edit&redlink=1 "Asynchronous Playback is part of a not safe subset of ALSA for some Linux distributions that use pulse audio like Ubuntu. Please consider using safer ways on your programs like polling if you are going to use Pulse Audio. (page does not exist)")

Since none of the existing documentation was thorough enough for me to
understand what was really going on in ALSA at times, I'm going to write
up this partial document on how I got ALSA output to work in my
application, and what I *think* is going on, describing it to my best
abilities. Hopefully, some Developer With A Clue will extend or fix this
document.

Comments by me in this file are *italic*, and probably means something
wasn't and still isn't quite obvious to me. Fore-mentioned developers
are welcome to enlighten me.

This document describes just one of the methods for using ALSA.
Specifically, I'm going to use regular writes here, and use asynchronous
notification to find out when I can write to the ALSA buffer. Besides
asynchronous notification, you can also simply poll like you would with
any other file descriptor. And besides regular writes, you can also mmap
the buffer and write directly to memory. I'm not going to cover these,
though, but you can find an example of it all in the alsa-lib API
reference here:
[http://www.alsa-project.org/alsa-doc/alsa-lib/\_2test\_2pcm\_8c-example.html](http://www.alsa-project.org/alsa-doc/alsa-lib/_2test_2pcm_8c-example.html)

Contents
--------

-   [1 Setting up the device](#Setting_up_the_device)
-   [2 Setting up parameters on the
    device](#Setting_up_parameters_on_the_device)
    -   [2.1 Hardware parameters](#Hardware_parameters)
    -   [2.2 Software parameters](#Software_parameters)

-   [3 Preparing the device](#Preparing_the_device)
-   [4 The callback function](#The_callback_function)

Setting up the device
---------------------

The first step is naturally to open the sound device.

` `

    /* This holds the error code returned */
    int err;

    /* Our device handle */
    snd_pcm_t *pcm_handle = NULL;

    /* The device name */
    const char *device_name = "default";

    /* Open the device */
    err = snd_pcm_open (&pcm_handle, device_name, SND_PCM_STREAM_PLAYBACK, 0);

    /* Error check */
    if (err < 0) {
        fprintf (stderr, "cannot open audio device %s (%s)\n", 
            device_name, snd_strerror (err));
        pcm_handle = NULL;
        return;
    }

This should look fairly straight-forward. We need a handle, a variable
holding the return value of our calls and a device name to tell ALSA
which device to open for us. The device name is a standard ALSA device
identifier you've probably encountered already, such as "hw:0,0" to
indicate the first device. The value "default" we use here opens up
either the first available device or whatever the default is, probably
set in the system or user's asoundrc file.

Most functions in alsa-lib return a negative error code if the operation
failed, like most regular system calls. Also (quite) similar is the
snd\_strerror function, which turns an error code in a human-readable
string, like the strerror function.

The third parameter to snd\_pcm\_open, by the way, indicates the
direction of the stream. The only other option here is
SND\_PCM\_STREAM\_CAPTURE, which obviously captures audio instead of
playing it. The final parameter to snd\_pcm\_open is the mode in which
to open the device. This can be set to SND\_PCM\_NONBLOCK if you'd like
to initialize the device in non-blocking mode, meaning calls to
snd\_pcm\_writei or snd\_pcm\_writen will not block until space is
available in the buffer, but instead immediately return with error code
EAGAIN to indicate the write failed, just like any other system call you
might be familiar with.

*Can this be OR'd? And what exactly is the SND\_PCM\_ASYNC flag for? The
asynchronous notification worked without this flag, in fact, it broke
when I tried to set it.*

* * * * *

In code examples beyond this section, I will leave out error checking
for brevity, and simply tell you how to clean up instead. In the example
above the ALSA code was simply part of another application, which could
still function if ALSA for some reason broke during execution. This is
why I set pcm\_handle to NULL, it is used throughout the application to
indicate if ALSA is initialized. If your application is simple player or
whatever, you'd probably exit at that point.

To kick off the lame excuse I have for my lazyness, after we're finished
with the device, we simply close it:

` `

    snd_pcm_close (pcm_handle);

Setting up parameters on the device
-----------------------------------

### Hardware parameters

Before we can actually feed something to this device handle we just
created, we have to tell it what we're feeding. We do this using
hardware parameters, which are kept in a structure of type
snd\_pcm\_hw\_params\_t. First, we allocate this structure, and then we
fill it with information from our device's current state:

` `

    snd_pcm_hw_params_t *hw_params;

    snd_pcm_hw_params_malloc (&hw_params);
    snd_pcm_hw_params_any (pcm_handle, hw_params);

If this all goes well, we can now set hardware parameters! Setting a
subset of hardware parameters is almost mandatory:

` `

    unsigned int rrate = 44100;

    snd_pcm_hw_params_set_access (pcm_handle, hw_params, SND_PCM_ACCESS_RW_INTERLEAVED);
    snd_pcm_hw_params_set_format (pcm_handle, hw_params, SND_PCM_FORMAT_S16_LE);
    snd_pcm_hw_params_set_rate_near (pcm_handle, hw_params, &rrate, NULL);
    snd_pcm_hw_params_set_channels (pcm_handle, hw_params, 2);

snd\_pcm\_hw\_params\_set\_access is used to set the transfer mode I've
been talking about at the start of this document. There are two types of
transfer modes:

-   Regular - using the snd\_pcm\_write\* functions
-   Mmap'd - writing directly to a memory pointer

Besides this, there are also two ways to represent the data transfered,
interleaved and non-interleaved. If the stream you're playing is mono,
this won't make a difference. In all other cases, interleaved means the
data is transfered in individual frames, where each frame is composed of
a single sample from each channel. Non-interleaved means data is
transfered in periods, where each period is composed of a chunk of
samples from each channel.

* * * * *

To visualize the case above, where we have a 16-bit stereo sound stream:

-   interleaved would look like:
    `LL RR LL RR LL RR LL RR LL RR LL RR LL RR LL RR LL RR LL RR ...`
-   non-interleaved *might* look like:
    `LL LL LL LL LL RR RR RR RR RR LL LL LL LL LL RR RR RR RR RR ...`

where each character represents a byte in the buffer, and padding should
of course be ignored (it's just for clarity).

\
 Note that I emphasized *might* in the non-interleaved case. The size of
the chunks depends on the period size hardware parameter, which you can
adjust using snd\_pcm\_hw\_params\_set\_period\_size. But in most cases,
you want interleaved access.

So now that we've got two transfer modes and two ways to organize our
sound stream, we can conclude there's 4 options we can pass to
snd\_pcm\_hw\_params\_set\_access:

-   SND\_PCM\_ACCESS\_MMAP\_INTERLEAVED
-   SND\_PCM\_ACCESS\_MMAP\_NONINTERLEAVED
-   SND\_PCM\_ACCESS\_RW\_INTERLEAVED
-   SND\_PCM\_ACCESS\_RW\_NONINTERLEAVED

*There's also a SND\_PCM\_ACCESS\_MMAP\_COMPLEX, which is described in
the API reference as "mmap access with complex placement". Anyone care
to explain how that works?*

* * * * *

So now that we've set our access mode, we specify the sample format.
There's a whole range of sample formats ALSA supports. You can find a
list here:
[http://www.alsa-project.org/alsa-doc/alsa-lib/group\_\_\_p\_c\_m.html\#a70](http://www.alsa-project.org/alsa-doc/alsa-lib/group___p_c_m.html#a70)

The sample format we picked above is Signed 16-bit Little-Endian
samples. A pretty common sample format, and it should be obvious how
these parameters are named.

* * * * *

After that, we set the sample rate of our stream, in Hz. Note that the
functions we use is called snd\_pcm\_hw\_params\_set\_rate\_**near**,
meaning the actual sample rate set may not match the sample rate we
specify. For this reason the function takes a *pointer* to an unsigned
integer, so it can change the value of our rrate variable to reflect the
actual rate set. There's also a function
snd\_pcm\_hw\_params\_set\_rate, which doesn't take a pointer, and will
try to set the sample rate to the exact rate you specify. It's likely
that this will fail on different sound devices though.

*The last parameter to snd\_pcm\_hw\_params\_set\_rate\_near, 'dir', is
documented as "Sub unit direction". What does that mean? Leaving it set
to NULL seems to be safe.*

* * * * *

From pcm.c:

Exact value is \<,=,\> the returned one following dir (-1,0,1)

So NULL means, try exact value.

* * * * *

How we tell our device how many channels our stream contains should be
obvious now from the code above.

* * * * *

Two other hardware parameters which might be helpful to mention are
buffer size and period size:

` `

    /* These values are pretty small, might be useful in
       situations where latency is a dirty word. */
    snd_pcm_uframes_t buffer_size = 1024;
    snd_pcm_uframes_t period_size = 64;

    snd_pcm_hw_params_set_buffer_size_near (pcm_handle, hw_params, &buffer_size);
    snd_pcm_hw_params_set_period_size_near (pcm_handle, hw_params, &period_size, NULL);

Both of these take the size in bytes. The period size is what I
described earlier in the section about interleaved and non-interleaved.
Besides specifying the size in bytes you can also specify them in
nanoseconds using the hardware parameters buffer\_time and period\_time.

There's a whole lot of other hardware variables you can alter, but
that'd be too much information to cover here. Take a look at the API
reference if you're interested:
[http://www.alsa-project.org/alsa-doc/alsa-lib/group\_\_\_p\_c\_m\_\_\_h\_w\_\_\_params.html](http://www.alsa-project.org/alsa-doc/alsa-lib/group___p_c_m___h_w___params.html)

* * * * *

Now that we're done setting all our hardware parameters, we have to
apply them back to the device. This is easy, really:

` `

    snd_pcm_hw_params (pcm_handle, hw_params);

* * * * *

Of course, we also have to clean up the structure behind our back.
Simply free it up like this:

` `

    snd_pcm_hw_params_free (hw_params);

### Software parameters

Besides hardware parameters, there are also software parameters. There's
a lot less of 'em, but in our case, we have to deal with them. Setting
them is almost exactly the same as hardware parameters, except with, you
guessed it, an snd\_pcm\_sw\_params\_t structure instead:

` `

    snd_pcm_sw_params_t *sw_params;

    snd_pcm_sw_params_malloc (&sw_params);
    snd_pcm_sw_params_current (pcm_handle, sw_params);

* * * * *

Software parameters are optional in most cases, but in this case we're
going to use asynchronous notification to let ALSA tell us when we need
to fill the buffer with some new data. And in this case, software
parameters are handy, because they allow us to set a threshold for when
that happens and also when ALSA starts actually playing something:

` `

    snd_pcm_sw_params_set_start_threshold(pcm_handle, sw_params, buffer_size - period_size);
    snd_pcm_sw_params_set_avail_min(pcm_handle, sw_params, period_size);

set\_start\_threshold tells ALSA when to start playing. In this case, we
tell it to wait until our buffer is almost full.

set\_avail\_min tells ALSA when to notify us. In this case, we want to
be able to write at least period\_size samples to the buffer without
blocking.

*I'm not quite sure if my explanation of this is right, might need some
reviewing. It's also not a very extensive explanation.*

Just like hardware parameters, other available software parameters are
covered in the API reference:
[http://www.alsa-project.org/alsa-doc/alsa-lib/\_2test\_2pcm\_8c-example.html](http://www.alsa-project.org/alsa-doc/alsa-lib/_2test_2pcm_8c-example.html)

* * * * *

And just like hardware parameters, we have to apply the changes we made
back to the device using this simple piece of code:

` `

    snd_pcm_sw_params(pcm_handle, sw_params)

* * * * *

And because we don't want to cause any leaks, at least not in memory, we
clean up:

` `

    snd_pcm_sw_params_free (sw_params);

Preparing the device
--------------------

Now we've set up our device, but we still can't write to it. There's one
last step we have to take: prepare the device:

` `

    snd_pcm_prepare (pcm_handle);

* * * * *

Now we can write! Before we start playback it's a good idea to write an
initial chunk of sound to the device:

` `

    snd_pcm_writei (pcm_handle, MyBuffer, 2 * period_size);

First of all, we have been using the interleaved format throughout this
example as you've seen above. If you were using the non-interleaved
format, you'd use the snd\_pcm\_writen function instead. Other than
that, it works exactly the same.

[MyBuffer](?title=MyBuffer&action=edit&redlink=1 "MyBuffer (page does not exist)")
in the above piece of code is a pointer to wherever the data is you want
to write to the device. and the last parameter is the size in bytes of
the data to write.

*Two times the period size seems to be a good initial write size? Going
below this results in a buffer under-run (broken pipe error on any
subsequent function calls) and going over it seems to trigger "file
descriptor in a bad state" errors.*

Also note, that the write functions actually return something useful
beside error codes as well: if the write succeeds, the length of the
data actually written to the device is returned. You probably want to
check that this is the same size as the data you intended to send.

* * * * *

So now it's time to actually get asynchronous! The way ALSA notifies us,
is through a callback. We tell it which callback simply by calling a
function:

` `

    snd_async_handler_t *pcm_callback;

    snd_async_add_pcm_handler(&pcm_callback, pcm_handle, MyCallback, NULL)

The first parameter to this function is simply a pointer to a handle.
This handle is also a parameter to our callback, as I will show you
later on. The second parameter is our device handle again, the third our
callback function and the fourth is a void pointer to any user data you
may want to pass to the callback. I'll just leave it set to NULL in this
example.

I'll show how the callback is implemented in the next section.

You can disable the callback at any time by calling the
snd\_async\_del\_handler function, like this:

` `

    snd_async_del_handler (pcm_callback);

However, it is **not** necessary to clean up the callback. It will be
cleaned up when the device is closed anyways.

* * * * *

So when we've been through all this trouble to set up our device, we
want to actually start playing. This is another easy part:

` `

    snd_pcm_start(pcm_handle);

Now you can do pretty much anything else in your application. If there's
not much else to do, there's always the sleep system call.

At any time, you can stop playback by calling any of these two
functions:

` `

    snd_pcm_drop(pcm_handle);

Which immediately stops playback, dropping any frames still left in the
buffer, or:

` `

    snd_pcm_drain(pcm_handle);

Which 'drains' the buffer, stopping after all remaining frames in the
buffer have finished playing.

For other operations related to playback or the device structure, again,
see the API reference:
[http://www.alsa-project.org/alsa-doc/alsa-lib/group\_\_\_p\_c\_m.html](http://www.alsa-project.org/alsa-doc/alsa-lib/group___p_c_m.html)

The callback function
---------------------

To prevent buffer under-runs, we need to refill the buffer every so
often, adding new stream data to it to keep the sound playing smoothly.
This is where our callback comes in.

The callback has the following signature:

` `

    void MyCallback(snd_async_handler_t *pcm_callback);

What happens in the callback is fairly simple; this is simply and
roughly what it will look like:

` `

    void MyCallback(snd_async_handler_t *pcm_callback)
    {
            snd_pcm_t *pcm_handle = snd_async_handler_get_pcm(pcm_callback);
            snd_pcm_sframes_t avail;
            int err;
            
            avail = snd_pcm_avail_update(pcm_handle);
            while (avail >= period_size) {
                    snd_pcm_writei(pcm_handle, MyBuffer, period_size);
                    avail = snd_pcm_avail_update(handle);
            }
    }

*Matt S -
[http://www.alsa-project.org/alsa-doc/alsa-lib/group\_\_\_p\_c\_m.html\#a53](http://www.alsa-project.org/alsa-doc/alsa-lib/group___p_c_m.html#a53)
suggests snd\_pcm\_delay should be used instead of
snd\_pcm\_avail\_update?* *Psy -
[http://www.alsa-project.org/alsa-doc/alsa-lib/group\_\_\_p\_c\_m.html\#g012e8b999070e72ab23514f25e7d6482](http://www.alsa-project.org/alsa-doc/alsa-lib/group___p_c_m.html#g012e8b999070e72ab23514f25e7d6482)
clearly says that snd\_pcm\_avail\_update has to be called before
writing to the device takes place, in order to update the r/w-pointer.*

**Note:** The callback will be called by ALSA inside a signal handler,
so be careful how you access data in other parts of your program and
don't do any malloc/free type stuff.

As you can see, the snd\_async\_handler\_t structure is passed to the
callback. This is a really handy structure, because the first thing we
do is grab the associated device handle from it. If you had any user
data associated with it, you can get to it like this:

` `

    void *private_data = snd_async_handler_get_callback_private(pcm_callback);

Where 'void \*' would of course be whatever type the original data you
passed to the snd\_async\_add\_pcm\_handler function was. In our case,
however, this would simply return NULL.

Another new function we see here is snd\_pcm\_avail\_update. This
function takes a device handle, and returns the amount of available
bytes that can be written to the device. As you can see, we use this in
our loop too keep writing chunks to the buffer until it's full.

That is basically all there is to the callback. Note however, that this
example does not include error checking, which is a good idea of course.
Occasionally, you may have to restore from a buffer under-run, in case
the computer was caught up in some other process and didn't get to
calling your callback. Whenever this happens, the first operation you
perform on the device, in this case snd\_pcm\_avail\_update, will return
-EPIPE (a 'Broken Pipe' error). You can restore from this by calling the
snd\_pcm\_prepare function again.

* * * * *

*[User:Stéphan
K.](?title=User:St%C3%A9phan_K.&action=edit&redlink=1 "User:Stéphan K. (page does not exist)"):
I just now noticed how often I mentioned myself in this document.
Perhaps it would've been better writing this from another perspective...
oh well. :)*

Retrieved from
"[http://alsa.opensrc.org/HowTo\_Asynchronous\_Playback](http://alsa.opensrc.org/HowTo_Asynchronous_Playback)"

[Category](/Special:Categories "Special:Categories"):
[Howto](/Category:Howto "Category:Howto")

