/*
    mdhtml.js - Uses a modified version of showdown.js to render 
    HTML from Markdown text.         
*/

// Parts used when rendering full HTML from markdown
var metaparts = '\n';
var headparts = '\n<link rel="stylesheet" href="./assets/css/site.css"/>\n<link rel="stylesheet" href="./assets/css/mdout.css"/>\n<link rel="stylesheet" href="./assets/css/pdf.css"/>\n';
var scriptparts = '\n';
var bodybegparts = '\n';
var bodyendparts = '\n';

// https://nicedoc.io/showdownjs/showdown#valid-options
opt = {
    ghCompatibleHeaderId: true,
    simpleLineBreaks: true,
    requireSpaceBeforeHeadingText: true,
    openLinksInNewWindow: true,
    // default to "off", set as needed in the 
    // functions below
    completeHTMLDocument: false,
    // custom - 
    // add classes to all header tags, class
    // names must be separated by a space
    //      mdout.css: .mdanchor - keeps anchors away from top of window
    headerClasses: 'mdanchor',
    // aids in rendering the resulting HTML to PDF
    firstHeaderSkip: true,
    // only used if completeHTMLDocument is true
    // 
    bodyClasses: 'mdselector mdfont',
    //
    headInclude: metaparts + headparts + scriptparts,
    // 
    bodyPrepend: undefined,
    // 
    bodyAppend: undefined
};
// set up the converter...
var converter = new showdown.Converter(opt);
converter.setFlavor('github');

/*
    Retrieve, and render a markdown text file to 
    HTML. Then write it into the element that was 
    passed in. Execute a call back when complete.
*/
function showMDFile(elem, loc, cb = null) {
    httpGet(loc, function(resp) {
        var mdhtml = converter.makeHtml(resp);
        $(elem).html(mdhtml);

        /*
            If this is placed at the top of a
            markdown file - 
        
            <div id="mddocpdf" style="display:none;"></div>
        
            then when that file is shown the "Save to PDF"
            button will appear.

            NOTE: A blank line should follow the <div> line
        */
        if($(elem).find('#mddocpdf').length > 0) {
            $('#pdfout-ctrls').show();
        } else {
            $('#pdfout-ctrls').hide();
        }

        /*
            If this is placed at the top of a
            markdown file - 
        
            <div id="mddocfont" style="display:none;"></div>
        
            then when that file is shown the "Choose Font Below"
            buttons will appear.

            NOTE: A blank line should follow the <div> line
        */
        if($(elem).find('#mddocfont').length > 0) {
            $('#mdfont-ctrls').show();
        } else {
            $('#mdfont-ctrls').hide();
        }

        if(cb !== null) cb();
    }, true);
}

/*
    Retrieve, and render a markdown text file to 
    HTML. And return it to the caller via a call 
    back function.

    The full-HTML rendering also pulls in the 
    public_html/mdfiles/pdfheading.php file to 
    create a heading that is added to the PDF 
    file. It contains the website domain, a 
    copyright year, and the original file name.

    See public_html/mdfiles/pdfheading.php for 
    additional details.
*/
function getMDHTML(loc, cb = null) {
    httpGet(loc, function(resp) {
        // tell the PDF converter to render a full 
        // HTML file. 
        converter.setOption('completeHTMLDocument', true);

        if($('#mdfont-ctrls').is(':visible')) {
            if($('#mdfont_b').hasClass('mdfont-active')) {
                converter.setOption('bodyClasses', 'mdselector alt-mdfont');
            } else {
                converter.setOption('bodyClasses', 'mdselector mdfont');
            }
        }

        // retrieve the PDF heading 
        httpGet('./mdfiles/pdfheading.php?doc='+loc, function(phead) {
            // Add this piece to the renderer
            //converter.setOption('bodyPrepend',phead);
            converter.setOption('bodyAppend',phead);
            // convert to HTML
            var mdhtml = converter.makeHtml(resp);
            // done, reset the options we modified
            //converter.setOption('bodyPrepend',undefined);
            converter.setOption('bodyAppend',undefined);
            converter.setOption('completeHTMLDocument', false);
            converter.setOption('bodyClasses', 'mdselector mdfont');
            // provide the rendered HTML to the caller
            if(cb !== null) cb(mdhtml);
        }, false);
    }, true);
}

/*
    Clear/remove the hashtag anchor address from 
    the URL bar of the browser.

    This is done because the rendered HTML content 
    can contain anchor links for navigating the 
    text. They use <a> tags and will leave the 
    hashtag. 

    That's a problem because the address it creates 
    is an impossible link. And if saved will not 
    link back to the selected content.
*/
function clearHash(href) {
    var newhref = href.split('#');
    history.replaceState({}, '', newhref[0]);
}

/*
    Retrieve a specified TOC(table of contents) file
    and render it. Display it in a specifedd element 
    and create listeners for clicks on the TOC elements.
    
    When a TOC element is click the corresponding 
    markdown file will be read, rendered, and displayed.

    When the content is displayed enable a button that
    triggers rendering the HTML to PDF conversion and 
    saves it for the user.

    See public_html/mdfiles/toc.php for details on how
    a TOC is configured.
*/
function showTOCFile(elem, loc, _cb = null) {
    var cb = _cb;

    $(elem).hide();
    $('#mdtoctable .toc-item').off('click');

    // the next sibling element is always the "out"
    // container.
    var mdout = $(elem).next();

    httpGet(loc, function(resp) {
        $(elem).html(resp);

        $('#mdtoctable .toc-item').off('click');

        $('#mdtoctable .toc-item').click(function(tocitem) {
            $('#mdtoctable .toc-item').each(function(idx) {
                if($(this).hasClass('nav-active')) {
                    $(this).removeClass('nav-active');
                    $(this).addClass('nav-hover');
                }
            });
            $('#'+tocitem.target.id).addClass('nav-active');
            $('#'+tocitem.target.id).removeClass('nav-hover');

            showMDFile(mdout,tocitem.target.dataset['mdfile'], function() {
                // only manage the "to PDF" button if it was made
                // to be visible. 
                if($('#pdfout-ctrls').is(':visible')) {
                    $('#topdfbtn').prop('disabled', false);
                    //$('#topdfbtn').click(function() {
                    $('#topdfbtn').one('click', function() {
                        // disable the button, one PDF per viewing
                        $('#topdfbtn').prop('disabled', true);
                        //console.log('to PDF! - '+tocitem.target.dataset['mdfile']);
                        mdToPDF(tocitem.target.dataset['mdfile']);
                    });
                } 

                // only manage the font selection if it was made
                // to be visible. 
                if($('#mdfont-ctrls').is(':visible')) {
                    if($(mdout).hasClass('alt-mdfont')) {
                        $('#mdfont_a').removeClass('mdfont-active');
                        $('#mdfont_a').addClass('mdfont-inactive');
                        $('#mdfont_a').addClass('nav-hover');
            
                        $('#mdfont_b').addClass('mdfont-active');
                        $('#mdfont_b').removeClass('mdfont-inactive');
                        $('#mdfont_b').removeClass('nav-hover');
                    }
            
                    $('#mdfontsel .mdfont_item').click(function(fontitem) {
//                        console.log('change font');
                        $('#mdfontsel .mdfont_item').each(function(idx) {
                            if($(this).hasClass('mdfont-active')) {
                                $(this).removeClass('mdfont-active');
                                $(this).addClass('mdfont-inactive');
                                $(this).addClass('nav-hover');
                            }
                        });
            
                        $('#'+fontitem.target.id).addClass('mdfont-active');
                        $('#'+fontitem.target.id).removeClass('mdfont-inactive');
                        $('#'+fontitem.target.id).removeClass('nav-hover');
            
                        // add or remove the font class(es)
                        if(fontitem.target.id === 'mdfont_a') {
                            $(mdout).addClass('mdfont');
                            $(mdout).removeClass('alt-mdfont');
                        } else {
                            if(fontitem.target.id === 'mdfont_b') {
                                $(mdout).removeClass('mdfont');
                                $(mdout).addClass('alt-mdfont');
                            }
                        }
                    });
                }

                // on this site <a> only exists in the rendered markdown file,
                // jump to the anchor and remove the hastag from the URL bar
                $('a').on('click', function() {
                    var _href = this.href;
                    window.setTimeout(clearHash, 5, _href);
                });
            });
        });

        $(elem).show();

        if(cb !== null) cb();
    });
}


