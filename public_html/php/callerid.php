<?php
/*
    callerid.php - Record a visitor's date and time of 
    visit, IP address, and HTTP referer. Write the data 
    to a JSON formatted file.   
*/

class ciddata {
    public $ip = '';
    public $httpref = '';
}

function endCallerIDLog($endfile) {
    writefile($endfile, getJSONTail());
}

// don't create a log if we're testing...
if(ip_proceed() === true) {

    $remoteaddr = ip_get();

    $logtype = LOG_TYPE;

    // caller/visitor id 
    // will record the date/time and ip, also checks the
    // size of the file and if it exceeds a fixed value
    // then it is copied and renamed with the current 
    // date and then the original file is deleted.
    $callerid = PAGE_ID . '_callerid' . '.' . $logtype;
    $idfile   = LOG_FOLDER . $callerid;

    $maxsize = FILE_32K;
    // reduced the roll-over limit for the log file when debugging
    if(defined('_DEBUG_IP_LOG') && _DEBUG_IP_LOG === true) {
        $maxsize = 500;
    }

    if($logtype === 'json') {
        $fstate = managefile($maxsize, $callerid, LOG_FOLDER, 'endCallerIDLog');
    } else {
        $fstate = managefile($maxsize, $callerid, LOG_FOLDER);
    }

    if(($fstate === NO_FILE) || ($fstate === NEW_FILE)) {
        // if we're creating CSV file then the first line 
        // should define the columns
        if($logtype === 'csv') writefile($idfile, "date,time,remoteaddr,referer\r\n");
        else if($logtype === 'json') writefile($idfile, getJSONHead());
    }

    if($logtype === 'csv') $record = rightnow('csv') . ',' . $remoteaddr . ',' . HTTPREF . "\r\n";
    else if($logtype === 'json') {
        $data = new stdClass();
        $data->data = new ciddata();
        $data->data->ip = $remoteaddr;
        $data->data->httpref = HTTPREF;
        $record = getJSONRecord($data);
    }
    else $record = rightnow('log') . ' > ' . $remoteaddr . ' + ' . HTTPREF . "\r\n";
    
    writefile($idfile, $record);
}
?>