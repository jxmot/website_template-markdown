<?php
/* ********************************************************
    Optional silent hit counter and a visitor log of date/
    time and ip address.

    NOTE: requires "./php/writefile.php"
*/
if(defined('_USE_COUNTERID') && _USE_COUNTERID === true) {
    require_once './php/callerid.php';
    require_once './php/count.php';
}
?>