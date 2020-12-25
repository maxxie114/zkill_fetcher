# tables killmail, attacker, victim, items, zkb

CREATE TABLE killmail (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    killID INTEGER,
    killmail_id INTEGER,
    killmail_time VARCHAR(20),
    solar_system_id INTEGER
);


CREATE TABLE attacker (
    killmail_id INTEGER,
    alliance_id INTEGER,
    character_id INTEGER,
    corporation_id INTEGER,
    damage_done INTEGER,
    final_blow INTEGER,
    security_status FLOAT,
    ship_type_id INTEGER,
    weapon_type_id INTEGER
);


CREATE TABLE victim (
    killmail_id INTEGER,
    alliance_id INTEGER,
    character_id INTEGER,
    corporation_id INTEGER,
    damage_taken INTEGER,
    ship_type_id INTEGER,
    x_coord FLOAT,
    y_coord FLOAT,
    z_coord FLOAT
);

CREATE TABLE zkb (
    killmail_id INTEGER,
    locationID INTEGER,
    hash VARCHAR(255),
    fittedValue FLOAT,
    totalValue FLOAT,
    points INTEGER,
    npc INTEGER,
    solo INTEGER,
    awox INTEGER,
    href VARCHAR(255)
);

CREATE TABLE labels ( 
    killmail_id INTEGER,
    label VARCHAR(10)
);
