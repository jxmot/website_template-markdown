<div id="mddocpdf" style="display:none;"></div>

## Name of Site

Lorem ipsum dolor sit amet, usu semper labores vulputate cu. At per sensibus maiestatis, an nonumy dolorum minimum has. Impetus virtute accusamus no mea. Graecis atomorum temporibus an usu, ubique persius eum et. Hinc deseruisse mea eu, alia soluta adversarium vix an. Ut ius utroque probatus recusabo, munere ignota lobortis ei his, mazim vidisse ius ei.

### By Design...

Nec partiendo intellegam no. Mei ne agam corpora aliquando. No duo sale interesset, labitur adipiscing nam an, in latine tamquam suscipiantur vim. Id qui alii quaerendum accommodare. Omnesque contentiones nam ei, vel cu ferri putent corpora. Commodo graecis aliquando eos ad, te congue perpetua liberavisse sit, dicam tation facilisi ei eos.

##### Architecture

```
                      +--------------+
          +-----------+ Site Options +----------+
          |           +------+-------+          |
          |                  |                  V
          V                  |          +--------------+
  +---------------+          |          | Site Metrics |
  | Form Handling |          |          |  (optional)  |
  +-------+-------+          V          +-------+------+
          |           +--------------+          |
          |           |<meta> content|          |
          |           +------+-------+          |
          |                  |                  |
          |                  V                  |
          |           +--------------+          |
          +---------->|  index.php   |<---------+
                      +------+-------+
                             |
                             |            +------------+
                             V            | JavaScript |
                      +--------------+    +------+-----+
  +---------------+   |              |           |
  | Bootstrap 4.6 +-->|  HTML / CSS  |<----------+
  +---------------+   |              |           |
                      +------+-------+    +------+-----+
                             |            |   jQuery   |
                             V            +------------+
                    +------------------+
                    |                  |
                    |                  |
                    |  Rendered Page   |
                    |                  |
                    |                  |
                    +------------------+
```
<br>
<br>
<br>

###### &nbsp;&nbsp;&nbsp;&nbsp;**Invisible to the Naked Eye**

That would be the PHP portion of the site. The only part of it that's in the public repository for this site is the *table of contents* generator.

The remaining PHP is experimental and contains some "secret sauce" LOL

###### &nbsp;&nbsp;&nbsp;&nbsp;**Site content**

The content in some portions of this site are  written in **Markdown** (*like what you're reading right now*) and rendered *on demand* to HTML. I've worked this into other sites where the customer wanted to independently create content but not have to learn HTML to do it.

The Markdown to HTML renderer I'm using is a *slightly* modified version of [Showdown](<https://github.com/showdownjs/showdown>). And it works very well.

But the *table of contents* and the *font selector* are created with a text file and some PHP to render the HMTL that's displayed on the page.

###### &nbsp;&nbsp;&nbsp;&nbsp;**Saving a link(or not)...**

You can't save a link to any of the content. But the link you can save will always be to the root of the site. This is a feature that I use on *some* sites with dynamic content. And where if you saved a link to a specific thing it's likely to have changed between visits.

But in some circumstances it became necessary to obscure *anchor* links. They can be present in the Markdown and used for local links to headings. Unfortunately the `#anchor` would appear in the browsers' address bar, but if saved by the user it would never link back to that part of the site. 

###### &nbsp;&nbsp;&nbsp;&nbsp;**Extra Stuff**

* Font Selection... Let's be honest, although the CRT font looks cool. It's a pain in the ass to be reading it for too long. So where there's content there is also a font selector.
* No Printing.... yeah, just some CSS takes care of that ;)
* No Copy/Paste... same here, just a little CSS and it's not allowed.
* Small footprint... Very light, fast, and doesn't depend on any huge libraries. 


