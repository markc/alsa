HowTo access a mixer control
============================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

I couldn't find any documentation anywhere about this. After lots of
trial and error I got just enough from the amixer source code to work
out what I needed. All error handling is omitted for clarity.

So here is the minimum code needed to duplicate the following command
line:

` `

    > amixer -c 1 cset name='Line Playback Volume' 66,77

The control has the following features: ` `

    > amixer -c 1 cget name='Line Playback Volume'
    numid=1,iface=MIXER,name='Line Playback Volume'
     ; type=INTEGER,access=rw---R--,values=2,min=0,max=255,step=0
     : values=200,200
     | dBscale-min=-51.75dB,step=0.25dB,mute=1

The coloured parameters are the same colour in the code.

We will use the high-level control API. First we need to open an hctl
and load its data:

` `

    snd_hctl_t *hctl;
    err = snd_hctl_open(&hctl, "hw:1", 0);
    err = snd_hctl_load(hctl);

Now we need to initialise a `snd_ctl_elem_id_t` structure which alsa can
use to find the control we want.

` `

    snd_ctl_elem_id_t *id;
    snd_ctl_elem_id_alloca(&id);
    snd_ctl_elem_id_set_interface(id, SND_CTL_ELEM_IFACE_MIXER);

We **must** specify the interface and **either** the numeric id ` `

    snd_ctl_elem_id_set_id(id, 1);

**or** the name of the control. ` `

    snd_ctl_elem_id_set_name(id, "Line Playback Volume");

With this initialised we can use it to get a `snd_hctl_elem_t` object
and a `snd_ctl_elem_value_t` object. The elem is retrieved as follows:

` `

    snd_hctl_elem_t *elem = snd_hctl_find_elem(hctl, id);

The elem\_value is initialised with the id of the element and the value
we want to set like this:

` `

    snd_ctl_elem_value_t *control;
    snd_ctl_elem_value_alloca(&control);
    snd_ctl_elem_value_set_id(control, id);    

Finally we are ready to write our values to the mixer control:

` `

    snd_ctl_elem_value_set_integer(control, 0, 66);
    err = snd_hctl_elem_write(elem, control);

    snd_ctl_elem_value_set_integer(control, 1, 77);
    err = snd_hctl_elem_write(elem, control);

And if we don't want to do anything else we can close the high level
control handle:

` `

    snd_hctl_close(hctl);

We don't have to cleanup any memory, cause all elements are allocated on
the stack and freed automatically when our function returns to its
caller.

Retrieved from
"[http://alsa.opensrc.org/HowTo\_access\_a\_mixer\_control](http://alsa.opensrc.org/HowTo_access_a_mixer_control)"

[Category](/Special:Categories "Special:Categories"):
[Howto](/Category:Howto "Category:Howto")

