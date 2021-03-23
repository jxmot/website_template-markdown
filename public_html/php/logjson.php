<?php
/*
    Common functions for JSON file logging.

    Using these functios a JSON log file will look 
    like this:

    {"log":[{"createdAt":[1611336842,["20210122","113402"]]},
    {"visited":[1611336842,["20210122","113402"]],"data":{"ipAddress":"66.249.79.158","isPublic":true,"ipVersion":4,"isWhitelisted":true,"abuseConfidenceScore":0,"countryCode":"US","usageType":"Search Engine Spider","isp":"Google LLC","domain":"google.com","hostnames":["crawl-66-249-79-158.googlebot.com"],"totalReports":3,"numDistinctUsers":2,"lastReportedAt":"2021-01-19T05:30:33+00:00"}},
    {"endedAt":[1611336851,["20210122","113411"]]}]}

*/
// returns the head of the file, which contains - 
//      {"log":[{"createdAt":[1611336842,["20210122","113402"]]}
// 
// Which is the date and time when the file was created.
function getJSONHead() {
    $out = '{"log":[{"createdAt":['.time().','.rightnow('json').']}';
    return $out;
}

// returns the tail of the file, which contains - 
//      {"endedAt":[1611336842,["20210122","113402"]]}]}
// 
// Which is the date and time when the file was archived.
function getJSONTail() {
    $out = ",\n".'{"endedAt":['.time().','.rightnow('json').']}]}';
    return $out;
}

// creates a "visit" time stamp, it will look like this - 
//      {"visited":[1611336842,["20210122","113402"]]
//
// The time stamps indicate when the record was created
function getJSONVisit() {
    $out = (object)['visited'=>array(time(), json_decode(rightnow('json')))];
    return $out;
}

// Combines the visit time stamp(getJSONVisit()), and the data that
// was passed in $data - 
//      {"visited":[1611336842,["20210122","113402"]],"data":{...}}
function getJSONRecord($data) {
    // combine an object that contains the current date and time
    // with the data passed to us.
    $rec = (object)array_merge((array)getJSONVisit(),(array)$data);
    // format the record as JSON
    $json = ",\n" . json_encode($rec);
    return $json;
}
?>