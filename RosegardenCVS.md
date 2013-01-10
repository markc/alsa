RosegardenCVS
=============

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

Getting and Compiling from CVS
------------------------------

The most recent version of [Rosegarden](/Rosegarden "Rosegarden") is
only available as source code from the Rosegarden CVS archive. You have
to **download the source code using CVS** and re-compile it yourself.
This is not difficult to do but you must follow the instructions below
carefully. Open a shell to get a command-line prompt, *e.g.* by running
`xterm`, and type:

` `

    cvs -d:pserver:anonymous@cvs.sourceforge.net:/cvsroot/rosegarden login
    cvs -z3 -d:pserver:anonymous@cvs.sourceforge.net:/cvsroot/rosegarden co rosegarden

You may need to keep re-trying these `cvs` commands if the server or the
network is very busy.

` `

    cd rosegarden
    make -f Makefile.cvs

The following command makes Rosegarden ready for compilation in most
cases. However, you may need to use the `configure` command with certain
options (*e.g.* `--without-ladspa --without-jack`) depending on which
other software is already installed on your computer.

` `

    ./configure

Rosegarden should now be configured. Check carefully whether you see any
error messages (ignore warnings). If there are errors, it usually means
you need to try again giving `configure` some options.

` `

    make

[Rosegarden](/Rosegarden "Rosegarden") should now be compiled. If there
are errors, it usually means you need to try the `configure` command
again with added options.

` `

    su -c "make install"

Rosegarden should now be installed and ready-to-run by typing:

` `

    rosegarden

**Important Warning**: make sure you do not have an old version of
Rosegarden on your computer. If you are using a Linux distribution like
SuSE or Mandrake which already contains Rosegarden, you must ***remove
the old version of Rosegarden before you install a new version of
Rosegarden***. The best way to do this is to use your distribution's
package management system (see your provider's documentation).

Retrieved from
"[http://alsa.opensrc.org/RosegardenCVS](http://alsa.opensrc.org/RosegardenCVS)"

[Category](/Special:Categories "Special:Categories"):
[Software](/Category:Software "Category:Software")

