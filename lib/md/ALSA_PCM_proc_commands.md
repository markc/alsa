ALSA PCM proc commands
======================

By default, ALSA emulates OSS PCM with the so-called *plugin layer*,
i.e. tries to convert the sample format, rate or channels automatically
when the card doesn't support it natively. This will lead to some
problems for some applications like quake or wine, especially if they
use the card only in the MMAP mode.

In such a case, you can change the behavior of the PCM per application
by writing a command to the relavent /proc file. There is a proc file
for each PCM stream,

    /proc/asound/cardX/pcmY[cp]/oss

-   *X* is the card number (starting from zero; the first card is card
    0, the second card is card 1, etc.)
-   *Y* is the PCM device number (also starting from zero)
-   *p* is for playback and *c* for capture, respectively.

Note that this proc file exists only after snd-pcm-oss module is loaded.

The command sequence has the following syntax:

    app_name fragments fragment_size [options]

-   *app\_name* is the name of application with (higher priority) or
    without path.
-   *fragments* specifies the number of fragments or zero if no specific
    number is given.
-   *fragment\_size* is the size of fragment in bytes or zero if not
    given.
-   *options* is the optional parameters.

The following options are available:

-   disable -- The application tries to open a pcm device for this
    channel but does not want to use it.
-   direct -- Don't use plugins
-   block -- Force block open mode
-   non-block -- Force non-block open mode

The *disable* option is useful when one stream direction (playback or
capture) is not handled correctly by the application although the
hardware itself does support both directions.

The *direct* option is used, as mentioned above, to bypass the automatic
conversion and useful for MMAP-applications. For example, to playback
the first PCM device without plugins for quake, send a command to the
relevant /proc "file" via echo like the following:

    % echo "quake 0 0 direct" > /proc/asound/card0/pcm0p/oss

While quake wants only playback, you may append the second command to
notify the driver that only this direction is about to be allocated:

    % echo "quake 0 0 disable" > /proc/asound/card0/pcm0c/oss

The permissions of /proc files depend on the module options of ((snd)).
As a default it's set as root, so you'll likely need to be superuser for
sending the command above.

The *block* and *non-block* options are used to change the behavior of
opening the device file. As default, ALSA behaves as defined in POSIX,
i.e. blocks the file when it's busy until the device becomes free
(unless O\_NONBLOCK is specified). Some applications assume the
non-block open behavior, which are actually implemented in some real OSS
drivers.

This blocking behavior can be changed globally via nonblock\_open module
option of snd-pcm-oss. For using the non-block mode as default for OSS
devices, define like the following:

    options snd-pcm-oss nonblock_open=1

You can check the currently defined configuration by reading the proc
file. The read image can be sent to the proc file again, hence you can
save the current configuration

    % cat /proc/asound/card0/pcm0p/oss > /somewhere/oss-cfg

and restore it like

    % cat /somewhere/oss-cfg > /proc/asound/card0/pcm0p/oss

Also, for clearing all the current configuration, send erase command as
below:

    % echo "erase" > /proc/asound/card0/pcm0p/oss

