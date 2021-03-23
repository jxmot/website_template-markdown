<?php
/*
    form.php - A collection of functions for cleaning and 
    validating the fields in a form. It also checks to see 
    if the visitor is a known spammer and ignores the form
    submission if true. 

    Sending the form data in an email is also done here. And 
    there is an option (_DEBUG_FORM) file is created instead 
    of sending an email.

    There are other conditions that can prevent an email from 
    being sent. 
*/
function isValidDomain($email) {
    list($user, $domain) = explode('@', $email);
    if(checkdnsrr($domain, 'MX')) {
        return true;
    }
    return false;
}

function saveFormData() {
    $botcheck = cleanInput($_POST['form_website']);

    // simple bot check, if this field is not empty 
    // then something found it in the DOM and filled
    // it in. Not perfect, but should help somewhat.
    if(strlen($botcheck) > 0) {
        $_SESSION['botcheck'] = '';
        $_SESSION['form_ok'] = false;
        return false;
    }

    $_SESSION['site_id']     = SITE_ID;
    $_SESSION['form_ok']     = true;

    $_SESSION['form_name']   = cleanInput($_POST['form_name']);
    // http://myphpform.com/validating-url-email.php
    $emailin                 = cleanInput($_POST['form_email']);
    // https://www.guru99.com/php-regular-expressions.html
    // alternative ? - "[/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/]"
    if(!preg_match('/([\w\-]+\@[\w\-]+\.[\w\-]+)/', $emailin)) {
        $_SESSION['form_email'] = 'E-mail address not valid : ' . $emailin;
        $_SESSION['form_ok'] = false;
    } else {
        if(isValidDomain($emailin) !== true) {
            $_SESSION['form_email'] = $emailin . " - Email Domain is NO GOOD\n";
            $_SESSION['form_ok'] = false;
        } else {
            $_SESSION['form_email'] = $emailin;
        }
    }

    $_SESSION['form_msg'] = cleanInput($_POST['form_msg']);

    return $_SESSION['form_ok'];
}

/*
    There is an individual who spams contact forms and implies
    that there is an urgent need for you renew your domain with
    them.

    It is a SCAM. And even if a V2 reCAPTCHA is used they seem 
    to pick the matching tiles and get through.

    After some time collecting form submissions from them and 
    analyzing the field contents I determined that the following 
    tests will detect their 'signature'.
*/
function idiotCheck() {
    if((strpos($_SESSION['form_msg'], '8593423') === false) &&
       (strpos($_SESSION['form_msg'], '84593234') === false) &&
       (strpos(strtolower($_SESSION['form_name']), 'miller') === false) &&
       (strpos($_SESSION['form_email'], 'domainregistrationcorp') === false)) {
        return false;
    } else {
        // let them think everything is ok
        $_SESSION['form_ok'] = true;
        // checked if reporting is enabled
        $_SESSION['idiot_found'] = true;
        return true;
    }
}

function cleanInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function saveVisitorData() {
    $_SESSION['visitDate']     = zonetime('Y/m/d - H:i:s', time());
    $_SESSION['visitFrom']     = $_SERVER['REMOTE_ADDR'];
    $_SESSION['httpUserAgent'] = $_SERVER['HTTP_USER_AGENT'];
}

function sendMail() {
    if(($_SERVER['SERVER_NAME'] != 'localhost') && 
       // change this IP to match the PC your local-hosting on
       ($_SERVER['SERVER_NAME'] != '192.168.0.7') && 
       ($_SERVER['SERVER_NAME'] != '127.0.0.1') && 
       // change this as needed to match the host software you're using
       ($_SERVER['SERVER_NAME'] != 'xampp') &&
       // found in public_html/php/siteoptions.php
       (defined('_DEBUG_FORM') && _DEBUG_FORM != true) || (!defined('_DEBUG_FORM'))) {

        $subject = FORM_SUBJECT;
        $mailto  = FORM_MAILTO;
        $message = createMsg();
        $header  = createHeader();

        mail($mailto, $subject, $message, $header);
    } else {
        if(_DEBUG_FORM === true) {
            // write to a file instead...
            $path = (defined('TEMP_FOLDER') ? TEMP_FOLDER : '');
            $file = $path.zonetime('Ymd-His-', time()).'contactreq.html';
            writefile($file, createMsg()."\n");
        }
    }
}

function createHeader($sentby = null) {
    // Always set content-type when sending HTML email
    $header  = "MIME-Version: 1.0\r\n";
    $header .= "Content-type:text/html;charset=UTF-8\r\n";
    if($sentby === null) $sentby  = FORM_SENTBY;
    $header .= "From: <{$sentby}>\r\n";
    
    return $header;
}

function createMsg() {
        $sentby = FORM_SENTBY;
        return "
<html>
    <head>
    </head>
    <body>
        <h2>Request from {$_SESSION['site_id']}</h2>
        <p>
            <h3>Form Fields:</h3>
            <ul>
                <li>Name: {$_SESSION['form_name']}</li>
                <li>Email: {$_SESSION['form_email']}</li>
                <li>Message: [{$_SESSION['form_msg']}]</li>
            </ul>
        </p>
        <br>
        <p>
            <h3>Extra Info:</h3>
            <ul>
                <li>Sent Via: {$sentby}</li>
                <li>Date of visit: {$_SESSION['visitDate']}</li>
                <li>Visitor IP: {$_SESSION['visitFrom']}</li>
                <li>Visitor User-Agent: {$_SESSION['httpUserAgent']}</li>
            </ul>
        </p>
    </body>
</html>
";
}
?>