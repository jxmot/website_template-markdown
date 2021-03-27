<?php
/*
    Page Identifier:

    Identifies the page to metrics, which will create logging files for each 
    page that uses them.
*/
define('PAGE_ID', 'index');
// configure
require_once './php/siteoptions.php';
// time w/ timezone correction
require_once './php/timezone.php';
require_once './php/rightnow.php';
// for creating and writing to files
require_once './php/writefile.php';
// helpers
require_once './php/iphelpers.php';
// used by forms
session_start();
// form validation & send functions
require_once './php/form.php';
require_once './php/logjson.php';

// Did we arrive here as the result of the POST?
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(saveFormData() === true) {
        saveVisitorData();
        if(idiotCheck() === false) {
            sendMail();
        } else {
            require_once './php/idiotid.php';
        }

        $_SESSION['form_ok'] = false;

        header('Location: '.FORM_APPL);
    } else {
        header('Location: https://www.google.com/');
    }
}
?>
<!DOCTYPE html>
<html lang="<?php echo SITE_LANG;?>">
<head>
    <meta charset="<?php echo SITE_CHARSET;?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <meta name="description" content="<?php echo SITE_DESC; ?>"/>
    <meta name="author" content="<?php echo SITE_AUTH; ?>"/>
    <title><?php echo PAGE_TITLE; ?></title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <link rel="stylesheet" href="./assets/css/site.css"/>
    <link rel="stylesheet" href="./assets/css/splash.css"/>
    <link rel="stylesheet" href="./assets/css/navmenu.css"/>
    <link rel="stylesheet" href="./assets/css/blink.css"/>
    <link rel="stylesheet" href="./assets/css/form.css"/>

    <link rel="stylesheet" href="./assets/css/mdout.css"/>

    <link rel="stylesheet" href="./assets/css/totop.css"/>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

    <!-- markdown -> html -->
    <script src="./assets/js/showdown-1.9.1/dist/showdown.js"></script>

    <!-- html -> pdf -->
    <script src="./assets/js/html2pdf.js-0.9.2/dist/html2pdf.bundle.js"></script>
</head>
<body id="pagebody" class="nocopy">
    <div id="maincontent">
        <div class="container" id="nav-container">
            <nav class="navbar navbar-expand-md fixed-top navbar-light navbar-bglight">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sitenavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="sitenavbar">
<?php
// Configure the Nav Menu
$_SESSION['navmenutxt'] = './php/navmenu2.txt'; 
require_once './php/navmenu.php'; 
?>
                </div>
<?php
if(defined('_GITHUBCORNER') && _GITHUBCORNER === true) {
    $_SESSION['ghccfg'] = './php/githubcorner.txt'; 
    require_once './php/githubcorner.php'; 
}
?>
           </nav>
        </div>
        <section id="landing" class="content-selector splash-container">
            <div class="splash">
                <h1>Lorem Ipsum</h1>
                <h2>dolor sit amet</h2>
                <p>Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            </div>
        </section>
    </div>
    <div class="page-content">
        <section id="content_1" class="content-selector" style="display:none;">
            <div id="content_1-toc" class="mdselector">
            </div>
            <div id="content_1-out" class="mdselector sect-content">
            </div>
        </section>

        <section id="content_2" class="content-selector" style="display:none;">
            <div id="content_2-toc" class="mdselector">
            </div>
            <div id="content_2-out" class="mdselector sect-content">
            </div>
        </section>

        <section id="content_3" class="content-selector" style="display:none;">
            <div id="content_3-toc" class="mdselector">
            </div>
            <div id="content_3-out" class="mdselector sect-content">
            </div>
        </section>

        <section id="contact" class="content-selector" style="display:none;">
            <div class=" sect-content">
                <div class="row">
                    <form id="contactform-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <div class="form-row">
                            <div class="col">
                                <p> 
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, 
                                    sed do eiusmod tempor incididunt ut labore et dolore magna 
                                    aliqua. Ut enim ad minim veniam, quis nostrud exercitation.
                                </p>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group" id="name-group">
                                    <input title="Your Name" placeholder="Your Name" class="form-control" type="text" id="form_name" name="form_name" required maxlength="48" size="16">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group" id="email-group">
                                    <input title="Your email" placeholder="Your email" class="form-control" type="email" id="form_email" name="form_email" required maxlength="48" size="24">
                                </div>
                            </div>
                        </div>
                        <div class="form-row form-content-center">
                            <div class="col">
                                <div class="form-group" id="msg-group">
                                    <textarea title="Your Message" placeholder="Your Message" class="form-control" rows="3" id="form_msg" name="form_msg" maxlength="160" required></textarea>
                                    <div class="row">
                                        <div class="col-3 offset-9">
                                            <span id="textcount" class="textcount"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--
                            bot catcher
                        -->
                        <div hidden class="form-row">
                            <div class="col">
                                <div class="form-group" id="website-group">
                                    <input placeholder="Your Website" class="form-control" type="text" id="form_website" name="form_website" maxlength="128" size="24">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div id="submit-group" class="form-group text-center">
                                    <button id="contactus" type="submit" class="form-button">Send Message</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <section id="thankyou" class="content-selector in-center text-center" style="display:none;">
            <div class="row">
                <div class="col">
                    <h1 class="text-upcase">Thank You!</h1>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h3>
                        We will be in touch!
                    </h3>
                </div>
           </div>
        </section>
    </div>

    <button id="gototop" class="gototop" onclick="jumpToTop()" title="Go to top of page">&#9650;</button>

    <link rel="stylesheet" href="./assets/css/footer.css"/>
    <footer class="navbar fixed-bottom footer-bglight">
        <div class="footer-width footer-body footer-font">
<?php
$footmsg = '';
if(defined('FOOTER_MSG')) {
    $footmsg = FOOTER_MSG;
} else {
    $footmsg = '&copy;&nbsp;'.date('Y').'&nbsp;Example Site';
}
?>
            <h6 class="text-center"><?php echo $footmsg; ?></h6>
        </div>
    </footer>

    <script src="./assets/js/menu.js"></script>

    <script src="./assets/js/httpget.js"></script>

    <script src="./assets/js/mdhtml.js"></script>
    <script src="./assets/js/mdpdf.js"></script>

    <script src="./assets/js/totop.js"></script>

    <script src="./assets/js/index.js"></script>
    <script src="./assets/js/form.js"></script>
</body>
</html>
<?php
require_once './php/sitemetrics.php';
?>

