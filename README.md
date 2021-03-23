# Website Template with Markdown Rendering and PDF Output

Welcome! I hope you find this template useful. I enjoyed creating it and I use it myself. 

## By Design...

This template was created so that I could fulfill a specific need that I had. I wanted a simple website that was capable of using *Markdown* text files for content. In addition, content changes or updates would **not** require any coding changes. Even if the content file names changed or if the files were relocated.

There are some additional features that I required:

* Be ***functional***. Just add content, make a few minor changes, and you've got a website.
* Configurable:
  * `<meta>` tags
  * Form debugging on/off
  * Miscellaneous text content
* Intended for dynamic content:
  * The browsers' URL bar is managed. Hash tag (`#`) links are not allowed to be seen. 
  * The "table of contents" and the content files are read *on demand* and rendered. 
  * Links back to the site(page) will always be to the landing.
* PDF Export: The ability to export selective content to PDF.
* A minimal and lightweight appearance.
* Small code footprint, < 200k not including third party libraries(~1.7m).

### Appearance & Functionality

For the most part the appearance is plain. With just a little embellishment on the navigation menu. Other than white, the colors are subdued.

The initial page load and the transitions between navigation menu items utilize a brief fade-in instead of a harsh instant-on transition.



## What's Here

```
+---public_html
    |
    +---php
    |
    +---assets
    |   |
    |   +---css
    |   |
    |   +---js
    |       |
    |       +---html2pdf.js-0.9.2
    |       |   |
    |       |   +---dist
    |       |
    |       +---showdown-1.9.1
    |           |
    |           +---dist
    |
    +---mdfiles
        |
        +---content

```

Where:

* `public_html` - This folder represents the document root on the server, it contains`index.php`.
  * `php` - contains all PHP support files used in this project 
  * `assets` - sub-folder names are self explanatory
  * `mdfiles` - PHP files for creating a *table of contents* and an HTML snippet used in PDF creation.
    * `content` - configuration files for rendering TOCs(*table of content*) and text files formatted in Markdown that are used as content.

## What's Required

**Server**: 

## First Deployment

## Updating Content

### Editing the Navigation Menu

