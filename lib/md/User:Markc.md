# User:Markc

#### 2013-08-29 - Finally almost back on track

_[Mark Constable]:_ ... after 4 year of total neglect! Still a lot of work to go
through all pages and make sure they render in Markdown correctly and also remove
ancient text and some pages. Something I notice that is still missing are many
dozens of good quality FAQ pages so I will make an effort to resurect the old MySQL
database at some point and see if I pull them out.

Managing this site via Github is definitely "the way to go". The little EDIT link
at the bottom goes straight to the online Github editer page so I don't even have
to use git program to deal with this site. Anyone with a Github account is also
welcome to become a team member so those EDIT links can work for you too.

#### 2009-04-24 - Two alsa wikis?

_[Qubodup]:_ Hi, Is somewhere explained why this and the 'official' wiki co-exist?
Wouldn't it be better (simpler) to have just one? For easier differnetiation
between the two, I recommend you use this [favicon] and [alsalogo] to make the
difference clearer.

_[Mark Constable]:_ Thanks for the logos, great idea and very much appreciated.
Some of the reasons this site remains in existence are, no one from the official
ALSA site has ever contributed anything to this site (before the official one
existed, this one predates the official wiki by quite a few years), no one has
officially or formally suggested a merge, no one else has shown any serious
interest in helping to merge them, and most importantly there are a significant
number of offsite referers and Google hits that come directly to this site
because it's been here for so long. All points could be worked through with a
significant amount of effort from what would have to be a focussed **team effort**,
which I see no sign of happening, and at the end of the day is it all that
bad that this site also exists?

_[Qubodup]:_ Glad you like it! I/googlepages messed up the favicon though.
It became the official googlepages favicon, when it should look like [favicon].
I don't think it's bad - it just might be confusing is all. also might cause
information to exist twice... but yeah, keeping wikis in shape can be a pain
in the butt.

#### 2007-02-23 - Licence

_[Ingomueller.net]:_ Hi Mark! [Andron] asked my on my talk page about the
licence of this wiki. As I wrote in my diary and on the `ALSA`, I don't exactly
know what to do there. The thing is that `Copyright` says the content of the
wiki are licenced under the cs-by licence, but this page is not linked to by
any article! On the other side, there was a link to the cs-by-nc-ca licence
on every page of the old wiki. The way I see it, the link to cs-by-nc-ca is
more important, but I wanted to see your point. Anyhow, we should definitely
fill [ALSA] with content.

#### 2007-02-20 - Categories

Ingo, with your MediaWiki experience, could you offer an explanation of how
categories or namespaces could work in the context of this (or any MW) site?
What practical advantage do they offer over a single "flat" namespace?

_[Ingomueller.net]:_ Hi! The main advantage of categories is that they are
meant to be used for grouping articles in categories ;-) Therefore, a lot of
special functions are realised with them. For example, a simple `Category:Sound cards`
on the bottom of a page is enough to (1) create a link to that page on the
index page of the category to that page, (2) create a link to the index
page on the bottom of the page, (3) remove it from `Special:Uncategorizedpages`.
Point (1) also means, that the index page is automatically up-to-date. The
downside of these index pages is that they are not as flexible as regular
pages. That's why I created `Sound cards` as second index for the. Obviously,
this means kind of a loss of point (2).

To be honest, I don't know whether this is *THE* solution. I don't know
whether it is good to uses namespaces either. I just didn't see them being
used yet and I don't think that they are meant to replace categories. For
example if namespaces would be used, not *all* articles would appear in
`Special:Allpages`.

To resume: I agree with the very most comments you made today! The only thing
I have doubts about are the namespaces. If you wouldn't have made another
proposition first, I would have continued to put articles in categories, then
I would have created regular pages as second index and I would have linked to
those from the main page.

_[Ingomueller.net]:_ I just googled a bit about discussion on the topic
"namespace vs category". One major point I think we should consider is that
*Go* button as well as the *Search* button only affects the main namespace
(by default) whereas categories have no affect at all on them. So namespaces
are made fore articles, that are not directly related to the topic of the
wiki (such as discussions, help, user pages, tempates etc...).

#### 2007-02-11 - ALSA documentation

_[Ingomueller.net]:_ There is a
[discussion](http://thread.gmane.org/gmane.linux.alsa.devel/44417) going on
on the ALSA developper mailing list about ALSA documentation in general. As
you know, most of the information on the official site is ten years old or
older. They are thinking about installing a wiki, so keeping the information
up-to-date would be easier. Having two wikis with the same topic would be
totally absurd, so merging the two sources wiki and official site will be
discussed, too. I'd like you to join the disussion as administrator of this
wiki. I really hope that this discussion is finally moving things forward.

_[Mark Constable]:_ Feel free to do as you feel best suits the needs of all
involved.

#### 2007-02-12 - Your user page

_[Ingomueller.net]:_ I saw that you copied your old user profile, so I created 
redirects from `User:MarkConstable` and `MarkConstable`, your old user pages.
When I set them up initially, I didn't know that your user name was now `markc`.

_[Mark Constable]:_ Thank you. I'm still getting used to how MediaWiki works
and did not realize, at the time, that my original MW markc account would also
become my main personal page area. I need to sit down and RTFM.

#### 2007-01-11 - External links

_[Ingomueller.net]:_ Hey Mark. I just realized that many external links on
google or in forums have the form
`http://alsa.opensrc.org/index.php?page=<pagename>`. Is there a way to
redirect those links to `http://alsa.opensrc.org/<pagename>`? That'd be
usefull, because one of our initial aims was to keep external links working.

_[Mark Constable]:_ Good catch. I've tried some rewrite rules but I can't
quite get the right combination to work. I've posted a forum message for help.
BTW, I saw the Johnless edits, do you think a PHP forum would be useful...
like say punBB? There used to be an alsa@opensrc.org mailing-list but no
one used it so I dismantled it some time ago (it was just catching spam).

_[Ingomueller.net]:_ YES! I think a forum would be a VERY good idea! I already
thought about it, but didn't want to ask :-) Maybe you've seen my post to the
alsa mailing list complaining about the bad documentation. One of my points
was, that the information is not concetrated in one place. A central forum
where all alsa related problems are discussed would be a huge step in this
direction! I'm only worrying a bit (it's really just a little bit) about how
frequently the forum will be used. There has to be a certain amount of regular
users in order to make a forum work. If there would be a link on the official
alsa page to the new forum, that would be a good start...

_[Mark Constable]:_ I've looked around and I think that using the latest Drupal
v5 might offer a lot of flexibility as it has a builtin forum module along with
a "books" module that could provide an interesting method for creating "formal"
documentation... and a blog module. There is a MediaWiki extension that allows
for login authentication to a Drupal site (v4.7 atm) so MW could kind of become
the primary wiki extension for Drupal. I need to do something with the main
opensrc.org site so installing Drupal there and intergrating MW authentication,
and menu links, to it might be a good solution. Drupal also has better media
upload plugin modules so it would make for a more natural user area for musicians
and any content. However, first I must get this MediaWiki installation upgraded
to the latest dynamic SVN version and I think the best way to do that will be to
setup an alsa3 site and import the current database info into the alsa3 site.

_[Ingomueller.net]:_ An entire CMS is definitely a good idea. As it is a really
big step, we have to think about it very carefully. If we go that big, I think
we should also invite some responsible alsa developpers to our discussion. If
there is such a thing as a "formal" documentation (which would be a very good
thing), it should be written be somebody who really knows what he talks about,
and not a user who was able to get something working by trail and error (like me).
I can't tell, if Drupal is the right choise. I searched their forum for a few
minutes and found only request of MediaWiki integrations, no module or similar.

One more thing about the initial topic: Is it possible (and desirable) to
write protect the old wiki and include a note on every page like "The ALSA
wiki has moved to a new software. This version is only kept to preserve old
versions. Please go to `http://alsa.opensrc.org/<pagename>` to see this page
in the new wiki." Someone made changes in the old wiki recently. With the
write protection, we wouldn't have to care about such changes.

_[Ingomueller.net]:_ I just wanted to ask wether you got the rewrite rules to
work? I think you did, because `http://alsa.opensrc.org/index.php?page=<pagename>`
links seem to be redirected now. I had another idea recently: we should analyse
the logs of 404 errors, searches and visits of non-existing pages. That way,
we'd find out other links that aren't working anymore. For example [LADSPA] had
to be redirected to [Ladspa], because mediawiki is case-insensitive unlike the
old wiki. I'm sure there are more of such articles I'm not aware of. The
analysis of the search logs would also allow us to know what people are really
interested in and change the wiki structure accordingly.

#### 2007-01-05 - Mysql errors

_[Ingomueller.net]:_ I keep getting this error when submitting changes from a page:

    Database error
    From the ALSA wiki
    A database query syntax error has occurred. This may indicate a bug\
    in the software. The last attempted database query was:

        (SQL query hidden)

    from within function "SearchMySQL4::update". MySQL returned error\
    "1062: Duplicate entry '2' for key 3 (localhost)".

Do you knwo what it is about? The strange thing is, that the changes are
mostly made, i.e. the changes from the page itself are applied, but for
example the page is not added to the index of a category. **Update:** I just
realized that I can't create new pages or categories either. Two other things
I found out not to work right: The search is not working at all and the
navigation menu is all at the bottom of the page when I edit an article
(Firefox 2.0.0.1). I hope you are the right person to ask and find the time
to look at the problems. That'd be great!

_[Mark Constable]:_ Yes, I noticed the error and have tried to fix it but so far the
problem remains. I will copying the database and use the new copy. Also, this
MediaWiki software is getting a bit old and I am attempting to use the latest
code so I'll try both of these things in the next 24 hours.

**Update:** I copied the database. This edit will test if saving now works.
**Yes**, it did. I'll work on updating the MediaWiki codebase to the latest
version from SVN (in a way that it can be continuously updated, apparently).
Hopefully this will provide a more recent CSS template to fix the menus
dropping to the bottom, and perhaps any other issues. Ingo, a huge thanks for
all your input over the last month. It's really appreciated.

_[ingomueller.net]:_ Thanks a lot Mark! The database problems are now all
solved! A new MediaWiki version would be cool, too. But that's not that
urgent. If I can help with that anyhow, just let me know...

_[ingomueller.net]:_ I just found another tiny bug, which will sure be solved
with the wiki update. The rss feed for the recent changes doesn't work. Both
Firefox and Thunderbird say that this is not a valid rss feed. Nothing to really
worry about, but one more reason to do the update...

_[Mark Constable]:_ I'm using the RSS feed via aKregator for KDE and it works.
I'll check it with FF and TB and see if I can pick up the exact error.

[https://github.com/opensrc/alsa]: https://github.com/opensrc/alsa
[Mark Constable]: http://alsa.opensrc.org/User:Markc
[Ingomueller.net]: http://alsa.opensrc.org/User:Ingomueller.net
[Qubodup]: http://alsa.opensrc.org/User:Qubodup
[alsalogo]: https://sites.google.com/site/qubodup/alsalogo.gif
[alsalogo]: http://qubodup.googlepages.com/favicon.ico
[favicon]: http://qubodup.googlepages.com/faviconWTFGOOGLE.ico
[Edit this page at Github]: https://github.com/opensrc/alsa/edit/master/lib/md/User:Markc.md
[Live Page at alsa.opensrc.org]: http://alsa.opensrc.org/User:Markc

