
maincontent.classList.add('fade');

document.addEventListener("DOMContentLoaded", () => {
    // matches *.php?thank*
    const thanks_rx = /(.+\.php\#thank)\w+/g;
    const dest = './';

    // the form submission will end up here with 
    // "*.php#thank*" in the URL.
    var href = window.location.href;
    if(href.match(thanks_rx)) {
        // hide content that is not currently hidden
        $('.content-selector').each(function(idx) {
            if($(this)[0].hidden === false) {
                $(this).hide();
            }
        });

        // show thanks...
        $('#thankyou').show();
        // wait for a click...  
        $('#thankyou').one('click', function() {
            window.location.href = href.replace(thanks_rx, dest);
        });
        // and here...
        $('#pagebody').one('click', function() {
            window.location.href = href.replace(thanks_rx, dest);
        });
        // just in case wait a bit and then clear it
        setTimeout(function() {
            window.location.href = href.replace(thanks_rx, dest);
        },7700);
    } else {
        setTimeout(function() {
            $('#maincontent').removeClass('fade');
        }, 1000);
    
        // we're on the "home page" so disable the
        // corresponding menu nav select item
        $('#navsel_1').addClass('nav-active');
        $('#navsel_1').removeClass('nav-hover');
    }

    $('li .nav-choice').click(function(navitem) {
        // ignore clicks on the currently active menu item
        if(!$(navitem.target).hasClass('nav-active')) {
//              console.log(navitem.target.id);
            // located in menu.js
            setMenu(navitem.target.id);
        }
    });
});
