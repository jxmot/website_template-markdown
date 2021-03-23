/*
    mdpdf.js - Functions to render and save a PDF 
    file.

    The following was used when creating this code:

        https://pspdfkit.com/blog/2019/html-to-pdf-in-javascript/
        https://github.com/eKoopmans/html2pdf.js
*/
/*
    mdToPDF() - Render a markdown file to PDF and 
    save it.

    Pass in the path+filename of the markdown file 
    and an optional HTML element. If no element is
    passed in the full HTML will be rendered before
    converting it to HTML.
*/
function mdToPDF(pathfile, elem = null) {

    var file = pathfile.split('/').pop().split('.')[0];

    // https://github.com/eKoopmans/html2pdf.js#options
    var opt = {
        margin:         .5,
        filename:       file+'.pdf',
        image:          { type: 'jpeg', quality: 0.98 },
        html2canvas:    { scale: 2 },
        // NOTE: v1.4.1 of jsPDF is used, so "putOnlyUsedFonts" and 
        // maybe other options do not exist.
        jsPDF:          { unit: 'in', format: 'letter', orientation: 'portrait', compress: true, putOnlyUsedFonts: true },
    
        // must disable links, otherwise the PDF will link back 
        // to the server that created the PDF.
        enableLinks:    false,

        // works best
        pagebreak: { avoid: 'img',  mode: 'avoid-all' }
    };

    if(elem === null) {
        // links of all types appear to be broken, especially 
        // anchor links. The odd thing is that other <a> links 
        // work when this code is ran in FireFox, but NOT in 
        // Chrome.
        // opt.enableLinks = true;
        getMDHTML(pathfile, function(mdhtml) {
            html2pdf()
                .set(opt)
                .from(mdhtml)
                .save();
        });
    } else {
        // Choose the element and save the PDF for our user.
        const element = document.getElementById(elem[0].id);
        html2pdf()
            .set(opt)
            .from(element)
            .save();
    }
};
