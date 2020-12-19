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
    $stm->execute();
}

# First make this code able to parse killmail_example.json
$file = file_get_contents("killmail_example.json");
$json = json_decode($file, true);
$killmail_id = $json["package"]["killmail"]["killmail_id"];

// TODO Add a killmail time parser
$km_data = array(1,
                  $json["package"]["killID"],
                  $json["package"]["killmail"]["killmail_id"],
                  $json["package"]["killmail"]["killmail_time"],
                  $json["package"]["killmail"]["solar_system_id"]);
insert_killmail($km_data, $db);

// jq .package.killmail.attackers[0] killmail_example.json
foreach($json["package"]["killmail"]["attackers"] as $i) {
    $attacker_data = array($killmail_id,
                           $i["alliance_id"],
                           $i["character_id"],
                           $i["corporation_id"],
                           $i["damage_done"],
                           $i["final_blow"],
                           $i["security_status"],
                           $i["ship_type_id"],
                           $i["weapon_type_id"]);
    insert_attacker($attacker_data, $db);
}

// jq .package.killmail.victim  killmail_example.json
$victim_data = array($killmail_id,
                     $json["package"]["killmail"]["victim"]["alliance_id"],
                     $json["package"]["killmail"]["victim"]["character_id"],
                     $json["package"]["killmail"]["victim"]["corporation_id"],
                     $json["package"]["killmail"]["victim"]["damage_taken"],
                     $json["package"]["killmail"]["victim"]["ship_type_id"],
                     $json["package"]["killmail"]["victim"]["position"]["x"],
                     $json["package"]["killmail"]["victim"]["position"]["y"],
                     $json["package"]["killmail"]["victim"]["position"]["z"]);
insert_victim($victim_data, $db);

// jq .package.zkb  killmail_example.json
$zkb_data = array($killmail_id,
                  $json["package"]["zkb"]["locationID"],
                  $json["package"]["zkb"]["hash"],
                  $json["package"]["zkb"]["fittedValue"],
                  $json["package"]["zkb"]["totalValue"],
                  $json["package"]["zkb"]["points"],
                  $json["package"]["zkb"]["npc"],
                  $json["package"]["zkb"]["solo"],
                  $json["package"]["zkb"]["awox"],
                  $json["package"]["zkb"]["href"]
);
insert_zkb($zkb_data, $db);

// jq .package.zkb.labels  killmail_example.json
foreach($json["package"]["zkb"]["labels"] as $i) {
    $labels_data = array($killmail_id, $i);
    insert_labels($labels_data, $db);
}



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