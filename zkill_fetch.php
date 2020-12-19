<?php

/**
 * This program will fetch zkill data using redisQ and write it into a txt file
 */

// connect to database
$db = new SQLite3("killmail.db");

// First wipe the databases
// DEBUG
$db->exec("DELETE FROM killmail");
$db->exec("DELETE FROM attacker");
$db->exec("DELETE FROM victim");
$db->exec("DELETE FROM zkb");
$db->exec("DELETE FROM labels");

/**
 * Insert data into killmail table
 */
function insert_killmail($data, $database) {
    $cmd = "INSERT INTO  killmail (id, killID, killmail_id, killmail_time, solar_system_id) " . 
           "VALUES (?,?,?,?,?)";
    $stm = $database->prepare($cmd);
    $stm->bindValue(1, $data[0], SQLITE3_INTEGER);
    $stm->bindParam(2, $data[1], SQLITE3_INTEGER);
    $stm->bindParam(3, $data[2], SQLITE3_INTEGER);
    $stm->bindParam(4, $data[3], SQLITE3_TEXT);
    $stm->bindParam(5, $data[4], SQLITE3_INTEGER);
    $stm->execute();
}

/**
 * Insert data into attacker table
 */
function insert_attacker($data,$database) {
    $cmd = "INSERT INTO  attacker (killmail_id,alliance_id,character_id,corporation_id,damage_done," .
           "final_blow,security_status,ship_type_id,weapon_type_id) " . 
           "VALUES (?,?,?,?,?,?,?,?,?)";
    $stm = $database->prepare($cmd);
    $stm->bindValue(1, $data[0], SQLITE3_INTEGER);
    $stm->bindParam(2, $data[1], SQLITE3_INTEGER);
    $stm->bindParam(3, $data[2], SQLITE3_INTEGER);
    $stm->bindParam(4, $data[3], SQLITE3_INTEGER);
    $stm->bindParam(5, $data[4], SQLITE3_INTEGER);
    $stm->bindParam(6, $data[5], SQLITE3_INTEGER);
    $stm->bindParam(7, $data[6], SQLITE3_FLOAT);
    $stm->bindParam(8, $data[7], SQLITE3_INTEGER);
    $stm->bindParam(9, $data[8], SQLITE3_INTEGER);
    $stm->execute();
}

/**
 * Insert data into victim table
 */
function insert_victim($data,$database) {
    $cmd = "INSERT INTO  victim (killmail_id,alliance_id,character_id,corporation_id,damage_taken," .
           "ship_type_id,x_coord,y_coord,z_coord) " . 
           "VALUES (?,?,?,?,?,?,?,?,?)";
    $stm = $database->prepare($cmd);
    $stm->bindParam(1, $data[0], SQLITE3_INTEGER);
    $stm->bindParam(2, $data[1], SQLITE3_INTEGER);
    $stm->bindParam(3, $data[2], SQLITE3_INTEGER);
    $stm->bindParam(4, $data[3], SQLITE3_INTEGER);
    $stm->bindParam(5, $data[4], SQLITE3_INTEGER);
    $stm->bindParam(6, $data[5], SQLITE3_INTEGER);
    $stm->bindParam(7, $data[6], SQLITE3_FLOAT);
    $stm->bindParam(8, $data[7], SQLITE3_FLOAT);
    $stm->bindParam(9, $data[8], SQLITE3_FLOAT);
    $stm->execute();
}

/**
 * Insert data into zkb table
 */
function insert_zkb($data,$database) {
    $cmd = "INSERT INTO  zkb (killmail_id,locationID,hash,fittedValue,totalValue," .
           "points,npc,solo,awox, href) " . 
           "VALUES (?,?,?,?,?,?,?,?,?,?)";
    $stm = $database->prepare($cmd);
    $stm->bindParam(1, $data[0], SQLITE3_INTEGER);
    $stm->bindParam(2, $data[1], SQLITE3_INTEGER);
    $stm->bindParam(3, $data[2], SQLITE3_TEXT);
    $stm->bindParam(4, $data[3], SQLITE3_FLOAT);
    $stm->bindParam(5, $data[4], SQLITE3_FLOAT);
    $stm->bindParam(6, $data[5], SQLITE3_INTEGER);
    $stm->bindParam(7, $data[6], SQLITE3_INTEGER);
    $stm->bindParam(8, $data[7], SQLITE3_INTEGER);
    $stm->bindParam(9, $data[8], SQLITE3_INTEGER);
    $stm->bindParam(10, $data[9], SQLITE3_TEXT);
    $stm->execute();
}

/**
 * Insert data into labels table
 */
function insert_labels($data, $database) {
    $cmd = "INSERT INTO labels (killmail_id, label) VALUES (?,?)";
    $stm = $database->prepare($cmd);
    $stm->bindParam(1, $data[0], SQLITE3_INTEGER);
    $stm->bindParam(2, $data[1], SQLITE3_TEXT);
}

# First make this code able to parse killmail_example.json
$file = file_get_contents("killmail_example.json");
$json = json_decode($file, true);
// var_dump($json);
$arr_data = array(1,
                  $json["package"]["killID"],
                  $json["package"]["killmail"]["killmail_id"],
                  $json["package"]["killmail"]["killmail_time"],
                  $json["package"]["killmail"]["solar_system_id"]);
// var_dump($arr_data);
insert_killmail($arr_data, $db);



// Infinite loop to Fetch data from redisQ
// while(true) {
//     $response = file_get_contents('https://redisq.zkillboard.com/listen.php?queueID=maxxie114&ttw=1');
//     $json = json_decode($response, true);
//     // First check if killmail is null
//     if ($json['package'] === null) {
//         continue;
//     }
//     sleep(1);
// }