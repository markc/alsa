Using alsactl to preserve volume state
======================================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Kernel 2.2 and 2.4
------------------

If you include the following lines in your /etc/modules.conf file (or
equivalent /etc/modutils/\<driver-name\> for Debian users) your volume
settings will be saved when the module unloads and restored when the
module loads. No more channels muted by default!

It requires the alsactl program, from alsa-utils, and the below text
assumes this program is installed in /usr/sbin. Don't forget to replace
snd-driver-name with the name of your sound driver.

` `

       # load/unload the volume settings on startup/shutdown
       post-install snd-driver-name /usr/sbin/alsactl restore
       pre-remove snd-driver-name /usr/sbin/alsactl store

This is simply using the modules.conf commands *post-install* and
*pre-remove* to run *alsactl* and load/save the configuration from the
default file. If you want to use a different file from the default, use
the -f option to *alsactl* (type *alsactl -h* for help). If you don't
have the *pre-remove* line, it will always load whatever settings are in
the configuration file (default */etc/asound.state*) when the module
loads. This is handy if you often fiddle with the volume and other
controls but wish to always have a certain setup when you reboot or load
alsa.

Kernel 2.6
----------

The 2.6 Linux kernel uses the module-init-package which is configured in
*/etc/modprobe.conf* instead of */etc/modules.conf*. In addition, the
module-init-package does not understand the post-install and pre-remove
commands. Use the following lines in /etc/modprobe.conf (again, this
assumes *alsactl* is installed in */usr/bin*; change *snd-driver-name*
to the name of your sound driver):

` `

       # load/unload the volume settings on startup/shutdown
       install snd-driver-name /sbin/modprobe \
        --ignore-install snd-driver-name;/usr/sbin/alsactl restore
       remove snd-driver-name /usr/sbin/alsactl \
        store;/sbin/modprobe --ignore-remove -r snd-driver-name

If you want to use a different file from the default, see above (2.4
kernel section).

A hint for Mandrake 9.1
-----------------------

This stumps most people in Mandrake 9.1 - the sound is muted by default
(!). In KDE, go through the K-\>Multimedia-\>Sound menu and select KMix.
Configure the slider settings and then save the settings (File-\>Save
Current Volumes as Default) and then exit by using the dialog close
widget in the top right corner of the dialog, not File-\>Quit. You
should then see a speaker icon in the system tray with a cross on it.
Right-click the icon and select 'Mute' to toggle the cross off. You
should then have sound. If you select File-\>Quit, KMix will close
completely with no icon in the system tray, and you will not see that
the sound has been muted - a real gotcha. Selecting File-\>Quit seems to
dump your mixer settings. By closing with the close widget the speaker
icon and mixer settings re-appear when you next boot.

Retrieved from
"[http://alsa.opensrc.org/Using\_alsactl\_to\_preserve\_volume\_state](http://alsa.opensrc.org/Using_alsactl_to_preserve_volume_state)"

[Category](/Special:Categories "Special:Categories"):
[Howto](/Category:Howto "Category:Howto")

