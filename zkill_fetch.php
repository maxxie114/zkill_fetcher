<?php

/**
 * This program will fetch zkill data using redisQ and write it into a txt file
 * 
 */

// Infinite loop to Fetch data from redisQ
while(true) {
    $response = file_get_contents('https://redisq.zkillboard.com/listen.php?queueID=maxxie114&ttw=1');
    $json = json_decode($response, true);
    echo $json['package']['killID']. "\n";
    sleep(1);
}

