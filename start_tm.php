<?php

$url = "http://localhost/tm";

//ignore_user_abort(true);
set_time_limit(0);
//$data = file_get_contents('start.txt');
//$d = 0;

while (!file_exists('stop.txt')) {
    // Add 1 to $data

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$resp = curl_exec($curl);
curl_close($curl);

//echo ($resp);
file_put_contents('storage/logs/start.log', $resp, FILE_APPEND | LOCK_EX);
//   $d = $d+1;
    // Update file
//   file_put_contents('/home/./storage/logs/start.log', $data);

    // Wait 4 seconds
    sleep(3);
}


