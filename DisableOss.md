DisableOss
==========

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Make sure you disable [Oss](/Oss "Oss") in your Kernel configuration. If
you don't, your system may try to use these drivers rather than the ALSA
ones. If you see a message about...

` `

    Sound card not detected

and you are sure you have the correct ALSA driver, this is the reason.
You have to go to `/etc/modules.conf` to disable (comment with a \#) the
lines that correspond to the plain [Oss](/Oss "Oss") sound driver kernel
modules. Check to see if you still have them by doing an...

` `

    /sbin/lsmod

If you do, remove them with...

` `

    /sbin/rmmod module_name

If you don't unload them the alsa driver will not be able to start,
because the [Oss](/Oss "Oss") driver will be using the hardware
resources associated with your SoundCard.

Note: Some kernels may be compiled with the OSS emulation modules
compiled directly into the kernel. In this case you will need to
recompile the kernel and change them so they are compiled as modules
rather than in the kernel itself. More information about Kernel
compiling can be found at
[http://www.tldp.org/HOWTO/Kernel-HOWTO/](http://www.tldp.org/HOWTO/Kernel-HOWTO/)
and
[http://www.digitalhermit.com/linux/Kernel-Build-HOWTO.html](http://www.digitalhermit.com/linux/Kernel-Build-HOWTO.html)

See also
--------

-   [Oss](/Oss "Oss")
-   [OssEmulation](/OssEmulation "OssEmulation")
-   [ToDo](/ToDo "ToDo") (GUI disability of Sound drivers - Oss/Alsa)

Retrieved from
"[http://alsa.opensrc.org/DisableOss](http://alsa.opensrc.org/DisableOss)"

[Category](/Special:Categories "Special:Categories"):
[OSS](/Category:OSS "Category:OSS")

