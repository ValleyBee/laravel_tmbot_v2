<?php

public function everyminute() : void
{

    $url = "http://localhost:8000/tm";

//ignore_user_abort(true);
    set_time_limit(0);
//$data = file_get_contents('start.txt');
//$d = 0;

    // Add 1 to $data

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

//$resp = curl_exec($curl);
    curl_close($curl);

//echo ($resp);

//   $d = $d+1;
    // Update file
//   file_put_contents('start.txt', $data);

    // Wait 4 second

}
