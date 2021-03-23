<?php
class idiotdata {
    public $ip = '';
    public $httpref = '';

    public $firstName = '';
    public $lastName = '';
    public $contactPhn = '';
    public $compMainPhn = '';
    public $compEmail = '';
    public $httpUserAgent = '';
}

function endIdiotIDLog($endfile) {
    writefile($endfile, getJSONTail());
}

$remoteaddr = ip_get();

// idiot/visitor id 
// will record the date/time and ip, also checks the
// size of the file and if it exceeds a fixed value
// then it is copied and renamed with the current 
// date and then the original file is deleted.
$idiotid = PAGE_ID . '_idiotid.json';
$idfile  = LOG_FOLDER . $idiotid;

$fstate = managefile(FILE_32K, $idiotid, LOG_FOLDER, 'endIdiotIDLog');
if(($fstate === NO_FILE) || ($fstate === NEW_FILE)) {
    writefile($idfile, getJSONHead());
}

$data = new stdClass();
$data->data = new idiotdata();
$data->data->ip = $remoteaddr;
$data->data->httpref = HTTPREF;

$data->data->firstName = $_SESSION['firstName'];
$data->data->lastName = $_SESSION['lastName'];
$data->data->contactPhn = $_SESSION['contactPhn'];
$data->data->compMainPhn = $_SESSION['compMainPhn'];
$data->data->compEmail = $_SESSION['compEmail'];
$data->data->httpUserAgent = $_SESSION['httpUserAgent'];

$record = getJSONRecord($data);

writefile($idfile, $record);
?>