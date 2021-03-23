/*
    menu.js - Handle selections on the navigation menu.

*/
function setMenu(active) {
    // make sure the active nav item is valid
    if(active !== '') {
        // hide the mobile-view menu (if visible)
        $('.navbar-collapse').collapse('hide');
        // find, and change the last active item to inactive
        $('li .nav-choice').each(function(idx) {
//            console.log(idx + ' ' + $(this).text());
            if($(this).hasClass('nav-active')) {
                $(this).removeClass('nav-active');
                $(this).addClass('nav-hover');
            }
        });
        // make the selected item active
        $('#'+active).addClass('nav-active');
        $('#'+active).removeClass('nav-hover');
        runMenu(active);
    }
};

/*
    Run the chosen menu item.

    This is where the logic for the site nav menu
    resides. 
*/
function runMenu(active) {
    // hide content that is not currently hidden
    $('.content-selector').each(function(idx) {
//        console.log(idx + ' ' + $(this)[0].id);
        if($(this)[0].hidden === false) {
            $(this).hide();
        }
    });

    // menu ID    Menu Item                     Section ID
    // --------   ----------------------------  --------------
    // navsel_1 = Home                          landing
    // navsel_2 = navsel_2                      content_1
    // navsel_3 = navsel_3                      content_2
    // navsel_4 = About                         about
    // navsel_5 = Contact                       contact

    switch(active) {
        // Go to the landing section, fade it 
        // in when it's shown. 
        case 'navsel_1':
            // create a smooth transition...
            $('#landing').addClass('fade');
            $('#landing').show();
            setTimeout(function() {
                $('#landing').removeClass('fade');
            }, 500);
            break;

        case 'navsel_2':
            $('#content_1').addClass('fade');
            $('#content_1').show();
            setTimeout(function() {
                $('#content_1').removeClass('fade');
            }, 250);
            break;

        // When chosen, retrieve and display a TOC for the
        // content that is accessible here. 
        case 'navsel_3':
            $('#abouttoc').html('');
            $('#aboutout').html('');
            $('#mdout').html('');
            // get and show the TOC and enable the PDF button
            showTOCFile('#mdtoc','./mdfiles/toc.php?toc=./content/toc.txt', function() {
                $('#topdfbtn').prop('disabled', true);
                $('#topdfbtn').off('click');
                $('#pdfout-ctrls').show();
            });
            // create a smooth transition...
            $('#content_2').addClass('fade');
            $('#content_2').show();
            setTimeout(function() {
                $('#content_2').removeClass('fade');
            }, 250);
            break;

        case 'navsel_4':
            $('#mdtoc').html('');
            $('#mdout').html('');
            $('#aboutout').html('');
            // get and show the TOC and do NOT enable the PDF button
            showTOCFile('#abouttoc','./mdfiles/toc.php?toc=./content/about.txt');
            // create a smooth transition...
            $('#about').addClass('fade');
            $('#about').show();
            setTimeout(function() {
                $('#about').removeClass('fade');
            }, 250);
            break;

        case 'navsel_5':
            // create a smooth transition...
            $('#contact').addClass('fade');
            $('#contact').show();
            setTimeout(function() {
                $('#contact').removeClass('fade');
            }, 250);
            break;

        default:
            break;
    };
};