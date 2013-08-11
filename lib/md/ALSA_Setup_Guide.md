ALSA Setup Guide
================

[ToDo]: include base information common for all the distros ( we can use
the simulation package installation; i.e. instead of use!

    apt-get install alsa-utils

we can use

    binary-package install alsa-utils

This convention advoid specific distro complications. You can go to your
distro documentation (or we can include here links ) about how to
install a package. This doesn't, of course, address things like init
scripts which are managed in widely different ways on different distros.

Gentoo's ALSA documentation
---------------------------

[http://www.gentoo.org/doc/en/alsa-guide.xml](http://www.gentoo.org/doc/en/alsa-guide.xml)
Page is pretty specific to Gentoo. References the Gentoo specific
commands to install Gentoo specific scripts which do Gentoo specific
things (like the gentoo init-scripts, which are distribution specific),
none of which have links to any explanations.

Has some general description of using with the now dying DEVFS (kernel
2.6.x suggests not using DEVFS anymore). udev / 2.6 kernel systems (now
the default) will generally just work first time, as the insersion of
the sound modules creates hotplug events which cause udev to create the
device nodes.

