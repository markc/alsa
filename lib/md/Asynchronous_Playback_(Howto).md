Asynchronous Playback (Howto)
=============================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

  ------------------------------------------------------------------------- -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
  [File:Merge-arrows.gif](/File:Merge-arrows.gif "File:Merge-arrows.gif")   There is another article called [HowTo\_Asynchronous\_Playback](/HowTo_Asynchronous_Playback "HowTo Asynchronous Playback") with a very similar content. **Please be bold an merge the two pages!**
  ------------------------------------------------------------------------- -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

**WARNING:** [Asynchronous Playback is part of a not safe subset of ALSA
for some Linux distributions that use pulse audio like Ubuntu. Please
consider using safer ways on your programs like polling if you are going
to use Pulse
Audio.](?title=Asynchronous_Playback_is_part_of_a_not_safe_subset_of_ALSA_for_some_Linux_distributions_that_use_pulse_audio_like_Ubuntu._Please_consider_using_safer_ways_on_your_programs_like_polling_if_you_are_going_to_use_Pulse_Audio.&action=edit&redlink=1 "Asynchronous Playback is part of a not safe subset of ALSA for some Linux distributions that use pulse audio like Ubuntu. Please consider using safer ways on your programs like polling if you are going to use Pulse Audio. (page does not exist)")

This Howto describes setting up ALSA for playback of sound using the
"asynchronous callback" method. With this method data is written to an
ALSA output buffer and ALSA is instructed to send an asynchronous
notification to the application when it is ready for more data.

In addition to the asynchronous notification technique described in this
Howto, an application can use [simple
polling](?title=Simple_polling_playback_(HOWTO)&action=edit&redlink=1 "Simple polling playback (HOWTO) (page does not exist)")
or [memory mapping
(mmap)](?title=Memory_mapped_playback_(HOWTO)&action=edit&redlink=1 "Memory mapped playback (HOWTO) (page does not exist)").

Contents
--------

-   [1 About Error Handling](#About_Error_Handling)
-   [2 Opening the device](#Opening_the_device)
    -   [2.1 Data Types](#Data_Types)
    -   [2.2 Function Call](#Function_Call)

-   [3 Closing the device](#Closing_the_device)
-   [4 Hardware parameters](#Hardware_parameters)
    -   [4.1 Structures](#Structures)
    -   [4.2 Mandatory Parameters](#Mandatory_Parameters)
        -   [4.2.1 Access Mode](#Access_Mode)

    -   [4.3 Sample Format](#Sample_Format)
    -   [4.4 Sample Rate](#Sample_Rate)
    -   [4.5 Number of Channels](#Number_of_Channels)
    -   [4.6 Setting the Hardware
        Parameters](#Setting_the_Hardware_Parameters)
    -   [4.7 Wrapping Up](#Wrapping_Up)

-   [5 Software Parameters](#Software_Parameters)
    -   [5.1 Structures](#Structures_2)
    -   [5.2 Timing Parameters](#Timing_Parameters)
    -   [5.3 Setting the Software
        Parameters](#Setting_the_Software_Parameters)
    -   [5.4 Wrapping up](#Wrapping_up_2)

-   [6 Writing to the Device](#Writing_to_the_Device)
    -   [6.1 Preparation](#Preparation)
    -   [6.2 Writing the First Chunk](#Writing_the_First_Chunk)

-   [7 The Callback Notification](#The_Callback_Notification)
    -   [7.1 Initializing the Callback](#Initializing_the_Callback)
    -   [7.2 Cancelling the Callback](#Cancelling_the_Callback)
    -   [7.3 Starting (Enabling) the
        Callbacks](#Starting_.28Enabling.29_the_Callbacks)
    -   [7.4 Stopping the Callback](#Stopping_the_Callback)
    -   [7.5 Processing the Callback](#Processing_the_Callback)
        -   [7.5.1 Filling the Buffer](#Filling_the_Buffer)

About Error Handling
--------------------

For the sake of clarity, the error checking code is not shown in this
Howto; it is left to the programmer to decide what action should be
taken if an error is encountered. When necessary, this Howto will
present code that is required to releases resources (devices or memory)
to recover from an error and restore the system to its original state.

Most functions in alsa-lib
[API](?title=API&action=edit&redlink=1 "API (page does not exist)")
return a negative error code if the operation failed, similar to regular
system calls. Also (quite) similar is the
'[snd\_strerror](?title=Snd_strerror&action=edit&redlink=1 "Snd strerror (page does not exist)")'
function, which turns an error code in a human-readable string, like the
strerror function.

The following code presents how the 'snd\_strerror' function could be
used if, for example, an error occurs while opening the ALSA playback
device:

    /* Error check */
    if (err < 0) {
      fprintf (stderr, "cannot open audio device %s (%s)\n", 
        device_name, snd_strerror (err));
      pcm_handle = NULL;
      return;
      }

Opening the device
------------------

Before using an ALSA device, it is necessary to open it first. To do
this, the
'[snd\_pcm\_open](?title=Snd_pcm_open&action=edit&redlink=1 "Snd pcm open (page does not exist)")'
API function is used.

### Data Types

    /* This holds the error code returned */
    int err; 

    /* Our device handle */
    snd_pcm_t *pcm_handle = NULL;

    /* The device name */
    const char *device_name = "default"; 

The 'err' variable will hold the return value of the function.

### Function Call

    /* Open the device */
    err = snd_pcm_open (&pcm_handle, device_name, SND_PCM_STREAM_PLAYBACK, 0);

This should look fairly straight-forward. We need

-   a file handle, a variable holding the return value of our calls
-   a device name to tell ALSA which device to open for us. The device
    name is a standard ALSA device identifier you've probably
    encountered already, such as "hw:0,0" to indicate the first device.
    The value we use here ("default") opens up either the first
    available device or whatever the default is, probably set in the
    system or user's asoundrc file.
-   the direction of the stream. There are only two options for this
    parameter: SND\_PCM\_STREAM\_PLAYBACK for playing of sounds and
    SND\_PCM\_STREAM\_CAPTURE for the capturing of audio.
-   the mode in which to open the device. This can be set to
    SND\_PCM\_NONBLOCK if you'd like to initialize the device in
    non-blocking mode, meaning calls to snd\_pcm\_writei or
    snd\_pcm\_writen will not block until space is available in the
    buffer, but instead immediatly return with error code EAGAIN to
    indicate the write failed, just like any other system call with
    which you might be familiar.

  ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
  **Question for Developers:**Can this be OR'd? And what exactly is the SND\_PCM\_ASYNC flag for? The asynchronous notification worked without this flag, in fact, it broke when I tried to set it.
  ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

Closing the device
------------------

Normally the ALSA device would not be closed until the application has
finished using it but for the sake of clarity of this Howto, it is
presented here.

    snd_pcm_close (pcm_handle);

Hardware parameters
-------------------

### Structures

Before data can be sent to the newly opened device, that data needs to
be initialized. All of the required data is contained in one structure
of the type
'[snd\_pcm\_hw\_params\_t](?title=Snd_pcm_hw_params_t&action=edit&redlink=1 "Snd pcm hw params t (page does not exist)")'.

     snd_pcm_hw_params_t *hw_params;
      

A variable of this type is dynamically allocated using the
'[snd\_pcm\_hw\_params\_malloc](?title=Snd_pcm_hw_params_malloc&action=edit&redlink=1 "Snd pcm hw params malloc (page does not exist)")'
API function.

     snd_pcm_hw_params_malloc (&hw_params);

The hardware parameters structure needs to be initialised with the
device capabilities.

     snd_pcm_hw_params_any(pcm_handle, hwparams);

Hardware parameters are specified, queried, and modified using a set of
API function which follow the naming convention,
"snd\_pcm\_hw\_params\_OPERATION" where "OPERATION" defines that which
is to be performed.

Some of the hardware parameter API functions modify the parameter passed
to it (in which case, the parameter's address is passed). Since
constants can not be used in such situations (even if it the "returned"
value is ignored), it is necessary to define variables for these
parameters.

For example, the API function
'[snd\_pcm\_hw\_params\_set\_rate\_near](?title=Snd_pcm_hw_params_set_rate_near&action=edit&redlink=1 "Snd pcm hw params set rate near (page does not exist)")'
modifies the [frame
rate](?title=Frame_rate&action=edit&redlink=1 "Frame rate (page does not exist)")
variable that was passed; therefore it is necessary to declare such a
variable:

    unsigned int rrate = 44100;

### *Mandatory Parameters*

Not all hardware parameters need to be specified, in many cases the
defaults provided by the ALSA system will serve without modification.
Nonetheless, setting a subset of hardware parameters is almost
mandatory.

#### Access Mode

The
'[snd\_pcm\_hw\_params\_set\_access](?title=Snd_pcm_hw_params_set_access&action=edit&redlink=1 "Snd pcm hw params set access (page does not exist)")'
function is used to set the transfer mode.

    snd_pcm_hw_params_set_access (pcm_handle, hw_params, SND_PCM_ACCESS_RW_INTERLEAVED);

There are two types of transfer modes:

-   Regular - using the snd\_pcm\_write\* functions
-   Mmap'd - writing directly to a memory pointer

Besides this, there are also two ways to represent the data transfered,
interleaved and non-interleaved. If the stream you're playing is mono,
this won't make a difference. In all other cases, interleaved means the
data is transfered in individual frames, where each frame is composed of
a single sample from each channel. Non-interleaved means data is
transfered in periods, where each period is composed of a chunk of
samples from each channel.

 Sound Stream Example 
:   

To visualize the two different data representations, consider a 16-bit
stereo sound stream.

Interleaved would look like
:   

LL RR LL RR LL RR LL RR LL RR LL RR LL RR LL RR LL RR LL RR ...

Non-interleaved *might* look like
:   

LL LL LL LL LL RR RR RR RR RR LL LL LL LL LL RR RR RR RR RR ...

where each character represents a byte in the buffer, and padding should
of course be ignored (it's just for clarity).

* * * * *

    snd_pcm_hw_params_set_format (pcm_handle, hw_params, SND_PCM_FORMAT_S16_LE);
    snd_pcm_hw_params_set_rate_near (pcm_handle, hw_params, &rrate, NULL);
    snd_pcm_hw_params_set_channels (pcm_handle, hw_params, 2);

\

So now that we've got two transfer modes and two ways to organize our
sound stream, we can conclude there's 4 options we can pass to
snd\_pcm\_hw\_params\_set\_access:

-   SND\_PCM\_ACCESS\_MMAP\_INTERLEAVED
-   SND\_PCM\_ACCESS\_MMAP\_NONINTERLEAVED
-   SND\_PCM\_ACCESS\_RW\_INTERLEAVED
-   SND\_PCM\_ACCESS\_RW\_NONINTERLEAVED

  -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
  **Question for Developers:**There's also a SND\_PCM\_ACCESS\_MMAP\_COMPLEX, which is described in the API reference as "mmap access with complex placement". Anyone care to explain how that works?
  -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

### Sample Format

So now that we've set our access mode, we specify the sample format.
There's a whole range of sample formats ALSA supports. You can find a
list on the [ALSA Document Library
website](http://www.alsa-project.org/alsa-doc/alsa-lib/group___p_c_m.html#a70).

The sample format we picked above is Signed 16-bit Little-Endian
samples. A pretty common sample format, and it should be obvious how
these parameters are named.

### Sample Rate

After that, we set the sample rate of our stream, in Hz. Note that the
functions we use is called
[snd\_pcm\_hw\_params\_set\_rate\_*near*](?title=Snd_pcm_hw_params_set_rate_near&action=edit&redlink=1 "Snd pcm hw params set rate near (page does not exist)"),
meaning the actual sample rate set may not match the sample rate we
specify. For this reason the function takes a *pointer* to an unsigned
integer, so it can change the value of our rrate variable to reflect the
actual rate set. There's also a function
[snd\_pcm\_hw\_params\_set\_rate](?title=Snd_pcm_hw_params_set_rate&action=edit&redlink=1 "Snd pcm hw params set rate (page does not exist)"),
which doesn't take a pointer, and will try to set the sample rate to the
exact rate you specify. It's likely that this will fail on different
sound devices though.

  -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
  **Note:**The last parameter to [snd\_pcm\_hw\_params\_set\_rate\_near](?title=Snd_pcm_hw_params_set_rate_near&action=edit&redlink=1 "Snd pcm hw params set rate near (page does not exist)") specifies the "Sub unit direction". It should be set to "-1" to specify that the actual rate should be *less than* the supplied parameter, "1" for an actual rate *greater than* the rate supplied, and "0" for *exactly* the supplied rate.
  -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

### Number of Channels

How we tell our device how many channels our stream contains should be
obvious now from the code above.

Two other hardware parameters which might be helpful to mention are
buffer size and period size:

    /* These values are pretty small, might be useful in
      situations where latency is a dirty word. */
    snd_pcm_uframes_t buffer_size = 1024;
    snd_pcm_uframes_t period_size = 64;

    snd_pcm_hw_params_set_buffer_size_near (pcm_handle, hw_params, &buffer_size);
    snd_pcm_hw_params_set_period_size_near (pcm_handle, hw_params, &period_size, NULL);

Both of these take the size in frames. The period size is what I
described earlier in the section about interleaved and non-interleaved.
Besides specifying the size in frames you can also specify them in
nanoseconds using the hardware parameters buffer\_time and period\_time.

There's a whole lot of other hardware variables you can alter, but
that'd be too much information to cover here. Take a look at the [API
reference](http://www.alsa-project.org/alsa-doc/alsa-lib/group___p_c_m___h_w___params.html)
if you're interested.

### Setting the Hardware Parameters

Now that we're done setting all our hardware parameters, we have to
apply them back to the device. This is easy, really:

    snd_pcm_hw_params (pcm_handle, hw_params);

\

### Wrapping Up

Of course, we also have to clean up the structure behind our back.
Simply free it up like this:

    snd_pcm_hw_params_free (hw_params);

Software Parameters
-------------------

### Structures

Besides hardware parameters, there are also software parameters. There's
alot less of 'em, but in our case, we have to deal with them. Setting
them is almost exactly the same as hardware parameters, except with, you
guessed it, an snd\_pcm\_sw\_params\_t structure instead:

    snd_pcm_sw_params_t *sw_params;

    snd_pcm_sw_params_malloc (&sw_params);
    snd_pcm_sw_params_current (pcm_handle, sw_params);

### Timing Parameters

Software parameters are optional in most cases, but in this case we're
going to use asynchronous notification to let ALSA tell us when we need
to fill the buffer with some new data. And in this case, software
parameters are handy, because they allow us to set a threshold for when
that happens and also when ALSA starts actually playing something:

    snd_pcm_sw_params_set_start_threshold(pcm_handle, sw_params, buffer_size - period_size);
    snd_pcm_sw_params_set_avail_min(pcm_handle, sw_params, period_size);

The function 'set\_start\_threshold' tells ALSA when to start playing.
In this case, we tell it to wait until our buffer is almost full.

The function 'set\_avail\_min' tells ALSA when to notify us. In this
case, we want to be able to write atleast period\_size samples to the
buffer without blocking.

Just like hardware parameters, other available software parameters are
covered in the [API
Reference](http://www.alsa-project.org/alsa-doc/alsa-lib/_2test_2pcm_8c-example.html).

### Setting the Software Parameters

And just like hardware parameters, we have to apply the changes we made
back to the device using this simple piece of code:

    snd_pcm_sw_params(pcm_handle, sw_params)

### Wrapping up

And because we don't want to cause any leaks, atleast not in memory, we
clean up:

    snd_pcm_sw_params_free (sw_params);

Writing to the Device
---------------------

### Preparation

Now we've set up our device, but we still can't write to it. There's one
last step we have to take: prepare the device:

    snd_pcm_prepare (pcm_handle);

### Writing the First Chunk

Now we can write! Before we start playback it's a good idea to write an
initial chunk of sound to the device:

    snd_pcm_writei (pcm_handle, MyBuffer, 2 * period_size);

First of all, we have been using the interleaved format throughout this
example as you've seen above. If you were using the non-interleaved
format, you'd use the
[snd\_pcm\_writen](?title=Snd_pcm_writen&action=edit&redlink=1 "Snd pcm writen (page does not exist)")
function instead. Other than that, it works exactly the same.

"MyBuffer" in the above piece of code is a pointer to wherever the data
is you want to write to the device. and the last parameter is the size
in frames of the data to write.

  ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
  **Note:**Two times the period size seems to be a good initial write size? Going below this results in a buffer underrun (broken pipe error on any subsequent function calls) and going over it seems to trigger "file descriptor in a bad state" errors.
  ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

  -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
  **Note:**The write functions actually return something useful beside error codes as well; i.e., if the write succeeds, the length of the data actually written to the device is returned. You probably want to check that this is the same size as the data you intended to send.
  -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

The Callback Notification
-------------------------

### Initializing the Callback

So now it's time to actually get asynchronous! The way ALSA notifies us,
is through a callback. We tell it which callback simply by calling a
function:

    snd_async_handler_t *pcm_callback;

    snd_async_add_pcm_handler(&pcm_callback, pcm_handle, MyCallback, NULL)

The first parameter to this function is simply a pointer to a handle.
This handle is also a parameter to our callback, as I will show you
later on. The second parameter is our device handle again, the third our
callback function and the fourth is a void pointer to any user data you
may want to pass to the callback. I'll just leave it set to NULL in this
example.

### Cancelling the Callback

You can disable the callback at any time by calling the
snd\_async\_del\_handler function, like this:

    snd_async_del_handler (pcm_callback);

However, it is **not** necessary to clean up the callback. It will be
cleaned up when the device is closed anyways.

### Starting (Enabling) the Callbacks

So when we've been through all this trouble to set up our device, we
want to actually start playing. This is another easy part:

    snd_pcm_start(pcm_handle);

Now you can do pretty much anything else in your application. If there's
not much else to do, there's always the sleep system call.

### Stopping the Callback

At any time, you can stop playback by calling any of these two
functions:

    snd_pcm_drop(pcm_handle);

Which immediatly stops playback, dropping any frames still left in the
buffer, or:

    snd_pcm_drain(pcm_handle);

Which 'drains' the buffer, stopping after all remaining frames in the
buffer have finished playing.

For other operations related to playback or the device structure, again,
see the [API
reference](http://www.alsa-project.org/alsa-doc/alsa-lib/group___p_c_m.html)

### Processing the Callback

#### Filling the Buffer

To prevent buffer underruns, we need to refill the buffer every so
often, adding new stream data to it to keep the sound playing smoothly.
This is where our callback comes in.

The callback has the following signature:

    void MyCallback(snd_async_handler_t *pcm_callback);

What happens in the callback is fairly simple; this is simply and
roughly what it will look like:

    void MyCallback(snd_async_handler_t *pcm_callback) {
                    snd_pcm_t *pcm_handle = snd_async_handler_get_pcm(pcm_callback);
      snd_pcm_sframes_t avail;
      int err;
           
      avail = snd_pcm_avail_update(pcm_handle);
      while (avail >= period_size) {
         snd_pcm_writei(pcm_handle, MyBuffer, period_size);
         avail = snd_pcm_avail_update(handle);
         }
     }

As you can see, the
[snd\_async\_handler\_t](?title=Snd_async_handler_t&action=edit&redlink=1 "Snd async handler t (page does not exist)")
structure is passed to the callback. This is a really handy structure,
because the first thing we do is grab the associated device handle from
it. If you had any user data associated with it, you can get to it like
this:

    void *private_data = snd_async_handler_get_callback_private(pcm_callback);

Where 'void \*' would, of course, be whatever type the original data you
passed to the snd\_async\_add\_pcm\_handler function was. In our case,
however, this would simply return NULL.

Another new function we see here is
[snd\_pcm\_avail\_update](?title=Snd_pcm_avail_update&action=edit&redlink=1 "Snd pcm avail update (page does not exist)").
This function takes a device handle, and returns the amount of available
frames that can be written to the device. As you can see, we use this in
our loop too keep writing chunks to the buffer until it's full.

That is basically all there is to the callback.

  --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
  **Note:**This example does not include error checking, which is a good idea, of course. Occasionally, you may have to restore from a buffer underrun, in case the computer was caught up in some other process and didn't get to calling your callback. Whenever this happens, the first operation you perform on the device, in this case [snd\_pcm\_avail\_update](?title=Snd_pcm_avail_update&action=edit&redlink=1 "Snd pcm avail update (page does not exist)"), will return -EPIPE (a 'Broken Pipe' error). You can restore from this by calling the [snd\_pcm\_prepare](?title=Snd_pcm_prepare&action=edit&redlink=1 "Snd pcm prepare (page does not exist)") function again.
  --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

Retrieved from
"[http://alsa.opensrc.org/Asynchronous\_Playback\_(Howto)](http://alsa.opensrc.org/Asynchronous_Playback_(Howto))"

[Category](/Special:Categories "Special:Categories"):
[Howto](/Category:Howto "Category:Howto")

