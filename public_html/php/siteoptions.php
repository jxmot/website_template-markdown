<?php
/*
    siteoptions.php
        
        Contains the defines that enable or disable features and code
*/
/* ************************************************************************* */
// debugging options, used by functions in iphelpers.php:
//
// When _DEBUG_IP = true :
//      ip_proceed() - will return always return `true`
//      ip_get() - enables checking other options to 
//                 determine which IP to return
//
define('_DEBUG_IP', false);
// Canned IP reputation, 'good' or 'bad'
define('_DEBUG_IP_REP', 'bad');
// if _DEBUG_IP_REP is 'bad' then a white 
// listed IP that has an unwanted country
// code is returned
define('_DEBUG_IP_CC', true);
// if _DEBUG_IP_REP is 'good' then a white
// listed IP can be returned
define('_DEBUG_IP_WHT', false);
// shorten the maxsize of all IP log files,
// this is independant of _DEBUG_IP
define('_DEBUG_IP_LOG', false);

// enables debugging code during development, its primary 
// use is to make the form generate text output in the 
// /temp folder. When "true" emails will NOT be sent, instead
// a file will be created in /temp
define('_DEBUG_FORM', true);
// create the ./temp folder if _DEBUG_FORM is true and if the
// folder doesn't already exist
if(_DEBUG_FORM === true) {
    if(!file_exists('./temp')) {
        mkdir('./temp', 0777, true);
    }
    define('TEMP_FOLDER', './temp/');
}

// 'log' = text file ('txt' is also OK)
// 'csv' = comma separated values
// 'json' = JSON formatted, content might be different
define('LOG_TYPE', 'json');
// use caller ID and hit counter?
define('_USE_COUNTERID', true);
define('_IP_LOGGING', _USE_COUNTERID);

if(_IP_LOGGING === true) {
    if(!file_exists('./logs')) {
        mkdir('./logs', 0777, true);
    }
    define('LOG_FOLDER', './logs/');
}

/*
    Language setting and charset used by our HTML.
*/
define('SITE_LANG', 'en-US');
define('SITE_CHARSET', 'UTF-8');

/*
    Page Identifier:

    Identifies the page to metrics, which will create logging files for each 
    page that uses them.

    For a "single page" (or "single file") site this can be left here. For 
    sites that consist of muliple pages remove it from here and place it at 
    the top of each page. Change the identifier as needed for the pages.
*/
define('PAGE_TITLE','Site Template with Bootstrap 4.6, Markdown Rendering, and PDF Save.');
define('SITE_DESC','Site Template with Bootstrap 4.6, Markdown Rendering, and PDF Save.');
define('SITE_AUTH','https://github.com/jxmot');

// the target that is loaded upon clicking submit
define('FORM_APPL', '#thankyou');
// put into the form submission, useful if the destination
// receives submissions from more than one site
define('SITE_ID', 'mysite');
// Contact message options
define('FORM_MAILTO', 'someone@somewhere.com');
define('FORM_SUBJECT', "It's for YOU!");
define('FORM_SENTBY', 'no-reply@somewhere.com');

// footer stuff
define('FOOTER_MSG', '&copy;&nbsp;2017-'.date('Y').'&nbsp;My Site');

// enable/disable the octocat in the corner
define('_GITHUBCORNER', true);

// Disables code in places that need to be dev-env compatible. This 
// prevents having to keep two versions of some files.
define('_NOTDEVENV', true);

?>