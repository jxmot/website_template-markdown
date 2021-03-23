/*
    Form Enhancement(s) - 

    This code relies upon that the form is contained in an element 
    that is normally hidden. And shown when the form is active.

    On document load create custom event triggers for jQuery show, 
    hide, fadeOut, and fadeIn. And get the maximum length of the
    message element.
    
    Also set up a listener for the message element, on key up. During
    that listener's execution get the length of the message element 
    and create a "(x/YYY)" string and display it.

    This form uses a <textarea> as its message element.
*/
$(function() {
    $.each(['show', 'hide', 'fadeOut', 'fadeIn'], function (i, ev) {
        var el = $.fn[ev];
        $.fn[ev] = function () {
            var result = el.apply(this, arguments);
            result.promise().done(function () {
                this.triggerHandler(ev, [result]);
            })
            return result;
        };
    });

    // wait for the element that contains the form to be shown
    $('#contact').on('show', function() {
        // clear the form each time it's shown
        $('form #msg-group #form_msg').val('');
        $('form #email-group #form_email').val('');
        $('form #name-group #form_name').val('');

        // the hidden spam-bot trap
        $('form #website-group #form_website').val('');

        var maxtext = $('form #msg-group #form_msg').attr('maxlength');
        $('#textcount').text('(0 / '+ maxtext+')');

        // update the count when typing occurs
        $('form #msg-group #form_msg').keyup(function() {
            var len = $(this).val().length;
            var lenstr = '('+len+' / '+ maxtext+')';
            $('#textcount').text(lenstr);
        });
    });
    
    // when hidden remove the keyup listener
    $('#contact').on('hide', function() {
        $('form #msg-group #form_msg').keyup();
    });
});


