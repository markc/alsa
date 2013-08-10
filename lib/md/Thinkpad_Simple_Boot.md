Thinkpad Simple Boot
====================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

**YOU MUST DISABLE the SIMPLE BOOT flag FOR Linux!**

On a ThinkPad, enabling Simple Boot does much the same thing as setting
PNP OS = Yes on most desktops. If you enable Simple Boot, you are
telling the BIOS NOT to configure the devices (the CS4237B in this case)
with the resources you set using PS2.EXE (or setpnp). YOU MUST DISABLE
the SIMPLE BOOT flag FOR Linux!

The IBM Bios Update Instructions mention the Simple Boot flag for the
following [ThinkPads](/ThinkPad "ThinkPad"): 600, 600E, 600X, 770, 770E,
and 770ED.

**This is what IBM says about Simple Boot in the BIOS Update
instructions:**

**Simple Boot Flag function**

This function automatically optimizes the behavior and boot performance
of the BIOS and operating system, based on the installed operating
system and previous boot.

If this function is Enabled and once a Plug and Play-capable operating
system, such as Windows 98, is installed, the system BIOS does not
configure such hardware resources as system interrupts, memory ranges,
and I/O port ranges for all the devices in the system.

If you are going to use a non-Plug and Play-capable operating system,
disable this function so that the BIOS will configure hardware
resources.

**NOTE:** If you are using multiple operating systems in addition to
Windows 95/98, you must DISABLE the Simple Boot Flag in Easy-Setup.

To modify the Simple Boot Flag:

1.  Hold down the F1 key on the ThinkPad and power on the system.
2.  Open the Config icon.
3.  Open the Quick Boot icon.
4.  Set Simple Boot Flag to Enable or Disable depending on
    configuration.

--[Greg Lindauer](/User:GregLindauer "User:GregLindauer")

See also
--------

-   [cs4232](/Cs4232 "Cs4232")
-   [cs4236](/Cs4236 "Cs4236")

Retrieved from
"[http://alsa.opensrc.org/Thinkpad\_Simple\_Boot](http://alsa.opensrc.org/Thinkpad_Simple_Boot)"

[Category](/Special:Categories "Special:Categories"): [Sound
cards](/Category:Sound_cards "Category:Sound cards")

