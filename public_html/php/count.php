<?php
// don't create a log if we're testing...
if(ip_proceed() === true) {

    // invisible counter -
    // opens a file to read the current number of hits
    $counter = PAGE_ID . '_count.log';
    $cntfile = LOG_FOLDER . $counter;
    // if the counter file doesn't exist then create 
    // it and set it to 1, write the file and close it
    if(!file_exists($cntfile)) {
        $filecnt = fopen($cntfile,'w');
        fwrite($filecnt, '1');
        fclose($filecnt);
    } else {
        // the file exists, open it, read it, close it,
        // increment the count, open it again, write it, 
        // and finally close it
        $filecnt = fopen($cntfile,'r');
        $count   = fgets($filecnt,64);
        fclose($filecnt);
        $count=$count + 1 ;
        // opens a file to contain the new hit number
        $filecnt = fopen($cntfile,'w');
        fwrite($filecnt, $count);
        fclose($filecnt);
    }
}
?>
