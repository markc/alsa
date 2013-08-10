User talk:Ingomueller.net
=========================

### From the ALSA wiki

Jump to: [navigation](#mw-head), [search](#p-search)

If you want to contact
[me](/User:Ingomueller.net "User:Ingomueller.net"), just edit the
*[Contacting me](#Contacting_me)* section below or click on the "+" on
the top bar. Indent your post with `~~~~:`, which will be replaced by
the date and your username.

Contents
--------

-   [1 Wiki diary](#Wiki_diary)
-   [2 Contacting me](#Contacting_me)
    -   [2.1 2007-02-20 - Categories](#2007-02-20_-_Categories)

-   [3 Z421 09:52, 21 February 2007
    (EST):](#Z421_09:52.2C_21_February_2007_.28EST.29:)
-   [4 Uploads enabled](#Uploads_enabled)
-   [5 Translations of this wiki](#Translations_of_this_wiki)

Wiki diary
----------

I'm keeping a kind of *wiki diary*, where I note the changes I'm doing
on the wiki. If you are interested in them, just have a look at it: [my
diary](/User:Ingomueller.net/Diary "User:Ingomueller.net/Diary").

Contacting me
-------------

[Olinuxx](/User:Olinuxx "User:Olinuxx") 22:05, 27 april 2007 (Paris):
Hi !\
 Thanks for your quick answer !\
 I go to talk with alsa-user :)\
 Bye !\
 Olinuxx

\

[Julian](?title=User:Julian&action=edit&redlink=1 "User:Julian (page does not exist)")
00:33, 11 April 2007 (EST): Hi Ingo, thanks for the nice comment. I
struggled for hours to get things working, mostly because I couldn't
find any documentation. Didn't want anyone else to have the problem.

\

[Frbiscani](?title=User:Frbiscani&action=edit&redlink=1 "User:Frbiscani (page does not exist)"):Hi
Ingo,

thanks for your corrections and thanks for your kind words :) I figured
out it was better to write down what I did to configure the card before
forgetting it...

I plan to add more stuff to the page in the next days, maybe that page
and the usb-usx2y one could be merged since the configuration for the
us-122/224/428 is virtually identical.

Hope you will read this, I'm not a wiki expert at all and I could not
understand the German in your website in order to decipher your e-mail
address :)

Hear you soon!

[Ingomueller.net](/User:Ingomueller.net "User:Ingomueller.net") 03:41,
15 February 2007 (EST): Hey Frbiscani! This way to contact me was
perfect! I just got an email that this page has been modified (which
never happened before). I guess every user gets informed when his talk
page has been changed. I'm checking the [recent
changes](/Special:RecentChanges "Special:RecentChanges") all the time
anyway, so no worries about that :-) BTW, when editing, you can use
`~~~~`, which will be replaced by your username and the date when
submitting the changes.

I agree with your point about [usb-usx2y](/Usb-usx2y "Usb-usx2y") and
[Tascam US-224](/Tascam_US-224 "Tascam US-224") having similar topics,
but somehow, there is a reason for both to be kept. Of course, all
devices using the usb-usx2y module have a lot in common and the
information about that should be on the according page, but there is
also some information that is specific to every device, like the foto
and the features. Maybe the configuration part of Tascam US-224 can be
moved to usb-usx2y, but I don't know anything about that topic, so just
do whatever you think is the best.

[Frbiscani](?title=User:Frbiscani&action=edit&redlink=1 "User:Frbiscani (page does not exist)")
00:04, 22 February 2007 (EST): Hi Ingo, is there a way I can safely try
to attempt to unify the three tascam cards (us-122,224,428) under the
same page without touching existing pages? A temporary page to be
removed later would be perfect...

### 2007-02-20 - Categories

Ingo, with your MediaWiki experience, could you offer an explanation of
how categories could work in the context of this (or any MW) site ? What
practical advantage do categories offer over a "flat" namespace ?

[Ingomueller.net](/User:Ingomueller.net "User:Ingomueller.net") 21:23,
20 February 2007 (EST): Hi! The main advantage of categories is that
they are meant to be used for grouping articles in categories ;-)
Therefore, a lot of special functions are realised with them. For
example, a simple `[[Category:Sound cards]]` on the bottom of a page is
enough to (1) create a link to that page on the index page of the
category to that page, (2) create a link to the index page on the bottom
of the page, (3) remove it from
[Special:Uncategorizedpages](/Special:UncategorizedPages "Special:UncategorizedPages").
Point (1) also means, that the index page is automatically up-to-date.
The downside of these index pages is that they are not as flexible as
regular pages. That's why I created [Sound
cards](/Sound_cards "Sound cards") as second index for the. Obviously,
this means kind of a los of point (2).

To be honest, I don't know whether this is *THE* solution. I don't know
whether it is good to uses namespaces either. I just didn't see them
being used yet and I don't think that they are meant to replace
categories. For example if namespaces would be used, not *all* articles
would appear in
[Special:Allpages](/Special:AllPages "Special:AllPages").

To resume: I agree with the very most comments you made today! The only
thing I have doubts about are the namespaces. If you wouldn't have made
another proposition first, I would have continued to put articles in
categories, then I would have created regular pages as second index and
I would have linked to those from the main page.

[markc](/User:Markc "User:Markc") 02:35, 22 February 2007 (EST): Forget
namespaces, that was my ignorance and not my understanding what they
were really meant for. I barely understand how categories work but
thanks to the above info, and some direct links you posted elsewhere, I
have a better idea how they work now. FWIW the earliest incarnation of
the old site software was simply a list of links of all the drivers
pointing to their own page. The description next to each link was a
brief list of the most common cards that used that driver. This was
before there was any general extra ALSA information (about dnsoop and
utilities etc) so it was fairly simple and easy to get the core info the
site was initially set up for... to provide some guide as to all the
confusion that something called a "emu10k1 driver is for SBlive sound
cards". This was before the driver matrix was set up on the
alsa-project.org site when there was precious little web info about the
various drivers, especially whatever were the latest ones. These days
ALSA comes with the kernel and most distros use udev so the right driver
is mostly auto-detected on bootup. I'm just pointing out what was a
strong motivation for the site when it was first set up. However, I
still think a Drivers: category with a complete list of all current
drivers, is one of the most useful aspects of what this site could
provide. The example of the emu10k1 page would include all info, or
links to other pages, about a lot of Creative cards, then the ca0106
page would have info about other Creative cards, the usb-audio,
emu10k1-fpga and emu10k1x pages would have even more Creative sound
cards. If we try to provide a list of all supported sound cards and then
what driver they use we will end up with a nightmare. If we provide a
list of drivers first then allow for a growing list of sound card
(entries that become pages when big enough) then it will be possible to
write an external PHP app that has a database lookup table for all cards
and drivers that then provides a link to the right entry/page in the
wiki. That would be a neat separate project. Anyway, my point is that
ALSA, therefor we, do have a concise list of drivers that we could use
as an index to all sound card specific info... which is really the most
valuable info the site can offer (I have such and such a card, htf do I
make it work with linux).

Update: Perhaps what I am trying to suggest is that each driver could be
it's own category so that when a new sound card page was set up that it
belonged not only to the sound card category but the right driver
category as well. Then if a user clicks on the sound card category they
see all sound cards, or, if they click on the emu10k1 category they will
see a subset of cards that only belong to that driver. I don't think
MediaWiki allows for hierarchical sub-categories so we can't have
Drivers:emu10k1:some\_card so the next best is just to make all drivers
into categories... assuming my suggestion makes sense.

[Ingomueller.net](/User:Ingomueller.net "User:Ingomueller.net") 03:43,
22 February 2007 (EST):I didn't see your update yet when I posted the
text below. Fortunately, Mediawiki DOES allow subcategories! (See
[Special:Specialpages](/Special:SpecialPages "Special:SpecialPages"),
[Special:Categories](/Special:Categories "Special:Categories"),
[Special:Uncategorizedcategories](/Special:UncategorizedCategories "Special:UncategorizedCategories"),
[Special:Uncategorizedpages](/Special:UncategorizedPages "Special:UncategorizedPages"))
If you add `[[:Category:<categories-name>]]` to the index page of a
categorie, it becomes subcategorie of *\<categories-name\>*. Putting
every sound card into a category named after its module is a good idea.
They should just stay in the sound card category, too, so a user looking
for his sound card would find it on the categories index. As an article
can be in two categories simultaniously, this is absolutely no problem
to realize.

Update: Forgot about the `Driver:` prefix. Such a prefix seperated with
a colon is for namespaces, not for categories. Adding pages to
categories doesn't affect its name. It's only a matter of whether the
pages contains the string `[[Category:<categories-name>]]` or not.

[markc](/User:Markc "User:Markc") 04:16, 22 February 2007 (EST): (I
don't always use an extra indent because the comments start to become
vertically crushed on the RHS, especially on narrower screens.) Ah,
thanks for that clarification. That is also good news about
sub-categories and being able to use multiple categories on each page is
like the use of "tags", so we have the best of both worlds, hierarchical
groupings and tagging. I didn't appreciate that you have already created
both the "Sound cards" and "ALSA modules" categories. I also keep
thinking that "ALSA modules" are "Drivers" but that is my old-world
confusion. We do indeed have a problem if the second most familiar
person with this site, me, is not aware of a lot of the new structure
you have put in place (I did have a months holiday earlier in the new
year though). Perhaps if we start using a parent Testing: category then
we can be free to experiment a bit more, and try out pages that other
people can contribute to and comment on. I don't think it's the end of
the world if we can't prevent them from showing up in searches as I can
try to simply remove them all from the MySQL database in a few months
time (assuming that is feasible.) If you think this is a good idea then
let's start with your double column Main Page idea and start to set up
the main index pages from it.

[Ingomueller.net](/User:Ingomueller.net "User:Ingomueller.net") 04:45,
22 February 2007 (EST):Using the "Testing:" prefix is fine for me. Users
will see it and be able to classify these page as "beta". We also could
create a [[Special:Allpages?namespace=10 | template] box indicating the
testing status of the page (`{{template-name}}` is replaced by the
content of
[Template:Template-name](?title=Template:Template-name&action=edit&redlink=1 "Template:Template-name (page does not exist)")
wherever used). Ok, so if we agree with each other, let's go ahead and
do it! The only thing I have to tell you is that time is a precious
resource for me at the moment because of three big exams ahead. For the
next month, I'll do as much as I can without neglecting these exams, but
that won't be that much...

[markc](/User:Markc "User:Markc") 09:04, 22 February 2007 (EST): I
agree. If you set up the Testing category and move your Proposed2 page
to Testing:Main\_Page then I'll try and find some time to add more
Testing pages. Perhaps we can use something like
Testing:Sound\_cards\_\_emu10k1 to represent that the testing emu10k1
page is meant to end up in the "Sound cards" category. The double
underscore is a bit ugly but the whole Testing category can hopefully be
removed in a few months. Once we get this major layout change swapped in
as the real deal then normal new pages and incremental changes should
suffice. I wish you the best of results for your upcoming exams.

[Ingomueller.net](/User:Ingomueller.net "User:Ingomueller.net") 09:39,
22 February 2007 (EST): Thanks for wishing me good luck! I hope, I don't
need it ;-) Alright, I created a category
[Category:Testing](/Category:Testing "Category:Testing") (BTW: this has
been done just by creating the according page with
[http://alsa.opensrc.org/Category:Testing&action=edit](http://alsa.opensrc.org/Category:Testing&action=edit))
and moved the new main page and the usx... page into it. I just wanted
to mention that moving pages always creates a link from the old to the
new location, which I think is not desirable with such temporar pages we
are dealing with right now. That's why I deleted the link
[Main\_Page:Proposed2](?title=Main_Page:Proposed2&action=edit&redlink=1 "Main Page:Proposed2 (page does not exist)").
I also changed the appearance of my proposal a bit (now on [Testing:Main
Page](/Testing:Main_Page "Testing:Main Page")): the two sections are now
separated like I planned it. I hope you like it :-)

[Ingomueller.net](/User:Ingomueller.net "User:Ingomueller.net") 03:34,
22 February 2007 (EST): I agree with you that information about every
driver is one of the most important aspects this wiki should provide.
The good thing is that it does that for the most common drivers. There
is a category "ALSA modules" with all the pages about modules. Its index
can be accessed at [Category:ALSA
modules](/Category:ALSA_modules "Category:ALSA modules"). I also created
a regular page as second index, which is more flexible: [ALSA
modules](/ALSA_modules "ALSA modules"). The pages in this category
belong to that category because they contain
`[[Category:ALSA modules]]`. There is also another category:
[Category:Sound cards](/Category:Sound_cards "Category:Sound cards").
I've put articles about specific sound cards in there. Again, I created
a regular page as index: [Sound cards](/Sound_cards "Sound cards"). What
needs to be done now is add a `== Devices using this module ==` section
to every module page and a `This device is using the module module.`
comment to the sound card pages.

This, at least, would allow the user to find out (a) which module his
sound card uses IF it's in the list, (b) tweaks about his sound card,
(c) tweaks about his module IF he knows which module it is, (d) tweaks
of other sound cards using the same module as his one which might work
for him too. Much more can't be done with just a wiki. An extension of
that would be very similar to what the official sound card matrix is.
It'd be great if there was such a matrix linking to the pages of this
wiki, but I don't know whether the effort of duplication is worth it...
Maybe it's enough to have an introduction explaining what modules are,
and that there are two places where to find information about them:
official matrix + this site. (This introduction should be linked to from
every module page in the *See also* section).

On my 4-5 fights against soundcards ;-) I didn't have to bother with
modules anyway. My problems were first that I didn't understand what
modules, sound servers, pcms, drivers, virtual devices, plugins etc etc
were. Once I understood most of that, the questions became more like
"how is the syntax of the asoundrc file", "how to I use the softvol
plugin" etc. Maybe I was just lucky that my sound cards were mostly
supported, but I'm sure that there is a big need of explanation of above
mentioned questions! (The
[special](/Special:SpecialPages "Special:SpecialPages") page
[Special:Popularpages](/Special:PopularPages "Special:PopularPages")
convices me that other users think so, too) This wiki is the perfect -
and unfortunately only - place to provide such information. The ALSA
core developpers don't want to bother with "trivial" problems
unexperienced users might have.

What I'm trying to find out is how this wiki should look like. To resume
my point: I think it should provide as much general information as
possible, so every user will be able to understand the structure of the
problem he is dealing with. Once he understands all that, the wiki
should try to help him to solve even specific problems as well as
possible. I'm mentioning the points in this order because improving the
first thing helps more people with less effort.

Last but not least, what I'd suggest what has to be done now: (1) create
a new main page, (2) write introductions into important general topics
(e.g. "how do alsa, arts and the like, modules, kernel, pcm devices fit
into one picture", "asoundrc configuration", "explanation where to find
information about modules and soundcards" etc), (3) improve module and
sound card pages, (4) improve other documents (howtos, module
documentation...). Points 3 and 4 don't striktly need to be done in this
order, but 1 and 2 should come first. All that is a hell of a lot of
work, but once we decide about what should be done, at least there is a
goal to work towards!

[Frbiscani](?title=User:Frbiscani&action=edit&redlink=1 "User:Frbiscani (page does not exist)")
22:09, 22 February 2007 (EST) I agree with most of what you said here.
There are a lot of topics which are covered almost identically over many
pages (for instance the configuration of "modules.conf"). Such common
stuff should go in a separate page and then referred to in the specific
driver pages, to avoid duplication of efforts. I think it is also
important to have a clear welcome page that can swiftly steer users in
the right direction. There are users that will be interested only in get
their on-board audio working, other will be interested in low-latency
and more "pro" features, and so on...

I've discovered the testing page of usx2y, I'll try to unify us-122,
us-224 and us-428 in the next days. As a side note, is it possible to
upload images to the wiki? I need some screenshot of qjackctl in action
to explain how to use us-224's control surface in ardour...

[Ingomueller.net](/User:Ingomueller.net "User:Ingomueller.net") 23:04,
22 February 2007 (EST): I fully agree with what you said and am glad you
are participating :-) Unfortunately, image upload is disabled at the
moment. I don't know whether this is intentional or just the default
setting that hasn't been changed. I think it could be usefull to have
such a feature (if possible). Maybe [Mark](/User:Markc "User:Markc") can
say something about it?

[Z421](/User:Z421 "User:Z421") 09:52, 21 February 2007 (EST):
-------------------------------------------------------------

thanks for putting my entry in [ice1712](/Ice1712 "Ice1712") the the
correct section. i'm not really used to use wiki's. ;)

Uploads enabled
---------------

[markc](/User:Markc "User:Markc") 23:37, 22 February 2007 (EST): Over on
the LHS in the toolbox, once logged in, you will see an "Upload Files"
link. Untested as of this note and this system runs in safe-mode so it
may give an error.

[Ingomueller.net](/User:Ingomueller.net "User:Ingomueller.net") 00:46,
23 February 2007 (EST): File upload works great! Thanks a lot! I
uploaded
[Image:Merge-arrows.gif](/File:Merge-arrows.gif "File:Merge-arrows.gif")
to test and also to have a local copy.

Translations of this wiki
-------------------------

[Andron](/User:Andron "User:Andron") 02:22, 24 February 2007 (EST): Hi
there, Ingo! Thank you for such titanic work at this wiki. I'm just want
to ask you, what do you think about translations of this wiki? I'm want
to translate whole wiki to Russian, and include some translated
materials in new book (in russian language) about professional audio
production in Linux environment. Also, I'm want to know about license,
which cover materials of this wiki.

[Ingomueller.net](/User:Ingomueller.net "User:Ingomueller.net") 08:48,
24 February 2007 (EST): Hi! I'm glad you are interested in the wiki! I
justed asked [Mark](/User:Markc "User:Markc") about the licence, because
the according page has not been filled with content yet. Once this is
done, you are free to do whatever you want with the wikis content as
long it is permitted by the licence. I'm not a legal expert, but I think
you can copy and modify it, as long as you don't earn money with it or
so... Translation is one kind of modification, so it should be allowed.

I'm not sure whether you wanted to translate the wiki in order to have a
russion version of it or whether you wanted to take parts of the wiki to
use it as part of a russian book. If you really want to translate the
wiki, I think there is a possibility to make the wiki multilingual, but
I really please you not to do it. The translation would mean so much
work that you would almost certainly have to do alone. If you would put
this effort in improving the english version, I guess this would be help
a lot more people! I don't want to discriminate non-english speaking
persons, but I don't think that we help them with a (most likely)
uncomplete translation of material that is already uncomplete itself and
out-of-date since years... However, as said before, if you do want to
translate the wiki, I'm sure this can be arranged and I will definitely
support you!

[Filiprino](?title=User:Filiprino&action=edit&redlink=1 "User:Filiprino (page does not exist)")
09:37, 1 May 2007 (EST): Ok, I'll subscribe to the list, sorry for
posting on the wiki page ;-)

Retrieved from
"[http://alsa.opensrc.org/User\_talk:Ingomueller.net](http://alsa.opensrc.org/User_talk:Ingomueller.net)"

[Category](/Special:Categories "Special:Categories"): [Sound
cards](/Category:Sound_cards "Category:Sound cards")

