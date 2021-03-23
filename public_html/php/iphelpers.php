<?php
require_once './php/cidrmatch.php';

/*
    Information that will be needed through out the
    PHP files to follow.
*/
define('SRVNAME',   ((isset($_SERVER['SERVER_NAME']) === true) ? $_SERVER['SERVER_NAME']  : 'none'));
define('REMADDR',   ((isset($_SERVER['REMOTE_ADDR']) === true) ? $_SERVER['REMOTE_ADDR']  : 'none'));
define('QRYSTR' ,  ((isset($_SERVER['QUERY_STRING']) === true) ? $_SERVER['QUERY_STRING'] : 'none'));
define('HTTPREF',  ((isset($_SERVER['HTTP_REFERER']) === true) ? $_SERVER['HTTP_REFERER'] : 'none'));
define('HTTPHOST',    ((isset($_SERVER['HTTP_HOST']) === true) ? $_SERVER['HTTP_HOST']    : 'none'));
define('DOCROOT', ((isset($_SERVER['DOCUMENT_ROOT']) === true) ? $_SERVER['DOCUMENT_ROOT']: 'none'));

// Disable code if this is not running in its original dev/run environment
if(!defined('_NOTDEVENV') || _NOTDEVENV === false) {
/*
    For "require" use a path that is correct based on the
    OS we're running on. However, there are some assumptions:
        * For Linux a standard home folder would be `/home/user-name`
          and that `public_html` is a sub-folder. The `getfqdnip` 
          module resides at `/home/user-name/getfqdnip`.
        * For Windows the path chosen is specific to my dev 
          environment set up. I use XAMPP and its document root
          is `drive:\XAMPP\htdocs`. All the development projects
          are "folder junctions" in the `drive:\XAMPP\htdocs\tests`
          folder. A folder junction is functionally similar
          to a Linux symlink. However, with Windows junctions 
          you are accessing the original file in its actual
          location.

        DANGER:
            * do not delete the folder junction or the files will
              be deleted too 
            * use the `rmdir` command ONLY!

    NOTE: 
*/
if(strpos(strtolower(PHP_OS), 'linux') !== false) {
    require_once '/home/'.get_current_user().'/getfqdnip/_readfqdndata.php';
} else {
    require_once DOCROOT . '/tests/getfqdnip/_readfqdndata.php';
}

} // if(!defined('_NOTDEVENV') || _NOTDEVENV === false)

/*
    Is the visitor from home?

    This function requires the installation of 
    the getfqdnip sub-module.

        github.com/jxmot/getfqdnip

    
*/
function ip_ishome($_ip = null) {
    if(!defined('_NOTDEVENV') || _NOTDEVENV === false) {
        global $fqdndata;
        $ip = ($_ip === null ? REMADDR : $_ip);
        $ret = ($fqdndata->hostip === $ip);
        return $ret;
    } else return false;
}

/*
    For site functions like "caller id" and any 
    other IP tests determine if they should be 
    performed.

    Returns:
        true = continue with IP tests
        false = do nothing

    When this function is called it compares the
    current server name to names that can occur
    when using a PC base http server. It also
    checks to see if the visitor IP falls into 
    a standard local network IP block. 

    But if _DEBUG_IP is true then always proceed.
*/
function ip_proceed() {
    $ret = ((SRVNAME !== 'localhost') && 
            (SRVNAME !== '127.0.0.1') && 
            (SRVNAME !== 'xampp') && 
            (ip_ishome() === false) &&
            (cidrmatch(SRVNAME, '192.168.0.0/24') === false) &&
            (cidrmatch(REMADDR, '192.168.0.0/24') === false) ||
            (defined('_DEBUG_IP') && _DEBUG_IP === true));

    return $ret;
}

/*
    Returns the visitor's IP address OR if _DEBUG_IP is 
    true then return one of several other IPs based on 
    options set in siteoptions.php.
*/
function ip_get() {
$ret = '';
    if(defined('_DEBUG_IP') && _DEBUG_IP === true) {
        if(defined('_DEBUG_IP_REP') && _DEBUG_IP_REP === 'good') {
            if(defined('_DEBUG_IP_WHT') && _DEBUG_IP_WHT === true) {
                $ret = '66.249.79.158'; 
            } else {
                $ret = '73.176.4.88'; 
            }
        } else {
            if(defined('_DEBUG_IP_CC') && _DEBUG_IP_CC === true) {
                $ret = '23.11.160.10';
            } else {
                $ret = '107.6.169.250';
            }
        }
    } else {
        $ret = REMADDR;
    }
    return $ret;
}
?>