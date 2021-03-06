<?php
// connect to database
$host = "localhost";
$db_name = "killmail";
$username = "fetcher";
$password = "Password!_35";
$charset = "utf8";

try {
    $db = new PDO( "mysql:host=$host;dbname=$db_name;charset=$charset", "$username", "$password");
    echo "Mysql Database Connection Established\n";
    error_log("Mysql Database Connection Established\n",3,"server.log");
} catch(Exception $e) {
    error_log("An Error Occurred:" . $e->getMessage() . "\n", 3, "server.log");
}


/**
 * Insert data into killmail table
 */
function insert_killmail($data, $database) {
    $cmd = "INSERT INTO  killmail (killID, killmail_id, killmail_time, solar_system_id) " . 
           "VALUES (?,?,?,?)";
    $stmt = $database->prepare($cmd);
    $stmt->bindParam(1, $data[0], PDO::PARAM_INT);
    $stmt->bindParam(2, $data[1], PDO::PARAM_INT);
    $stmt->bindParam(3, $data[2], PDO::PARAM_STR);
    $stmt->bindParam(4, $data[3], PDO::PARAM_INT);
    $stmt->execute();
}

/**
 * Insert data into attacker table
 */
function insert_attacker($data,$database) {
    $cmd = "INSERT INTO  attacker (killmail_id,alliance_id,character_id,corporation_id,damage_done," .
           "final_blow,security_status,ship_type_id,weapon_type_id) " . 
           "VALUES (?,?,?,?,?,?,?,?,?)";
    $stm = $database->prepare($cmd);
    $stm->bindValue(1, $data[0], PDO::PARAM_INT);
    $stm->bindParam(2, $data[1], PDO::PARAM_INT);
    $stm->bindParam(3, $data[2], PDO::PARAM_INT);
    $stm->bindParam(4, $data[3], PDO::PARAM_INT);
    $stm->bindParam(5, $data[4], PDO::PARAM_INT);
    $stm->bindParam(6, $data[5], PDO::PARAM_INT);
    $stm->bindParam(7, $data[6], PDO::PARAM_STR);
    $stm->bindParam(8, $data[7], PDO::PARAM_INT);
    $stm->bindParam(9, $data[8], PDO::PARAM_INT);
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
    $stm->bindParam(1, $data[0], PDO::PARAM_INT);
    $stm->bindParam(2, $data[1], PDO::PARAM_INT);
    $stm->bindParam(3, $data[2], PDO::PARAM_INT);
    $stm->bindParam(4, $data[3], PDO::PARAM_INT);
    $stm->bindParam(5, $data[4], PDO::PARAM_INT);
    $stm->bindParam(6, $data[5], PDO::PARAM_INT);
    $stm->bindParam(7, $data[6], PDO::PARAM_STR);
    $stm->bindParam(8, $data[7], PDO::PARAM_STR);
    $stm->bindParam(9, $data[8], PDO::PARAM_STR);
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
    $stm->bindParam(1, $data[0], PDO::PARAM_INT);
    $stm->bindParam(2, $data[1], PDO::PARAM_INT);
    $stm->bindParam(3, $data[2], PDO::PARAM_STR);
    $stm->bindParam(4, $data[3], PDO::PARAM_STR);
    $stm->bindParam(5, $data[4], PDO::PARAM_STR);
    $stm->bindParam(6, $data[5], PDO::PARAM_INT);
    $stm->bindParam(7, $data[6], PDO::PARAM_INT);
    $stm->bindParam(8, $data[7], PDO::PARAM_INT);
    $stm->bindParam(9, $data[8], PDO::PARAM_INT);
    $stm->bindParam(10, $data[9], PDO::PARAM_STR);
    $stm->execute();
}

/**
 * Insert data into labels table
 */
function insert_labels($data, $database) {
    $cmd = "INSERT INTO labels (killmail_id, label) VALUES (?,?)";
    $stm = $database->prepare($cmd);
    $stm->bindParam(1, $data[0], PDO::PARAM_INT);
    $stm->bindParam(2, $data[1], PDO::PARAM_STR);
    $stm->execute();
}

/**
 * Convert iso-8601 time format to sqlite readable time format
 * 
 * @return The converted time format
 */
function convert_time($time): string {
    $old_time = strtotime($time);
    $new_time = date('Y-m-d H:i:s', $old_time);
    error_log("[DEBUG] $new_time\n",3,"server.log");
    echo "[DEBUG] $new_time\n";
    return $new_time;
}

// Infinite loop to Fetch data from redisQ
while(true) {
    $url = 'https://redisq.zkillboard.com/listen.php?queueID=maxxie114&ttw=1';
    $response = file_get_contents($url);
    $json = json_decode($response, true);
    // First check if killmail is null
    if ($json['package'] === null) {
        continue;
    }
    $killmail_id = $json["package"]["killmail"]["killmail_id"];

    $old_km_time = $json["package"]["killmail"]["killmail_time"];
    $new_km_time = convert_time($old_km_time);
    $km_data = array($json["package"]["killID"],
                    $json["package"]["killmail"]["killmail_id"],
                    $new_km_time,
                    $json["package"]["killmail"]["solar_system_id"]);
    insert_killmail($km_data, $db);

    foreach($json["package"]["killmail"]["attackers"] as $i) {
        $alliance_id = (isset($i["alliance_id"])) ? $i["alliance_id"] : null;
        $character_id = (isset($i["character_id"])) ? $i["character_id"] : null;
        $corporation_id = (isset($i["corporation_id"])) ? $i["corporation_id"] : null;
        $ship_type_id = (isset($i["ship_type_id"])) ? $i["ship_type_id"] : null;
        $weapon_type_id = (isset($i["ship_type_id"])) ? $i["ship_type_id"] : null;
        $attacker_data = array($killmail_id,
                            $alliance_id,
                            $character_id,
                            $character_id,
                            $i["damage_done"],
                            $i["final_blow"],
                            $i["security_status"],
                            $ship_type_id,
                            $weapon_type_id);
        insert_attacker($attacker_data, $db);
    }

    $alliance_id = (isset($json["package"]["killmail"]["victim"]["alliance_id"])) ? 
        $json["package"]["killmail"]["victim"]["alliance_id"] : null;
    $character_id = (isset($json["package"]["killmail"]["victim"]["character_id"])) ? 
        $json["package"]["killmail"]["victim"]["character_id"] : null;
    $corporation_id = (isset($json["package"]["killmail"]["victim"]["corporation_id"])) ? 
        $json["package"]["killmail"]["victim"]["corporation_id"] : null;
    $damage_taken = (isset($json["package"]["killmail"]["victim"]["damage_taken"])) ? 
        $json["package"]["killmail"]["victim"]["damage_taken"] : null;
    $ship_type_id = (isset($json["package"]["killmail"]["victim"]["ship_type_id"])) ? 
        $json["package"]["killmail"]["victim"]["ship_type_id"] : null;
    $victim_data = array($killmail_id,
                        $alliance_id,
                        $character_id,
                        $corporation_id,
                        $damage_taken,
                        $ship_type_id,
                        $json["package"]["killmail"]["victim"]["position"]["x"],
                        $json["package"]["killmail"]["victim"]["position"]["y"],
                        $json["package"]["killmail"]["victim"]["position"]["z"]);
    insert_victim($victim_data, $db);

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

    foreach($json["package"]["zkb"]["labels"] as $i) {
        $labels_data = array($killmail_id, $i);
        insert_labels($labels_data, $db);
    }
    sleep(1);
}