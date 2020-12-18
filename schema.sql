# tables killmail, attacker, victim, items, zkb

CREATE TABLE killmail (
    id INTEGER PRIMARY KEY,
    killID INTEGER,
    killmail_id INTEGER,
    killmail_time TEXT,
    solar_system_id INTEGER,
);


CREATE TABLE attacker (
    killmail_id INTEGER,
    alliance_id INTEGER,
    character_id INTEGER,
    corporation_id INTEGER,
    damage_done INTEGER,
    final_blow INTEGER,
    security_status REAL,
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
    x_coord REAL,
    y_coord REAL,
    z_coord REAL
);

CREATE TABLE items (
    killmail_id INTEGER,
    flag INTEGER,
    item_type_id INTEGER,
    quantity_destroyed INTEGER,
    singleton INTEGER
);

CREATE TABLE zkb (
    killmail_id INTEGER,
    locationID INTEGER,
    hash TEXT,
    fittedValue REAL,
    totalValue REAL,
    points INTEGER,
    npc INTEGER,
    solo INTEGER,
    awox INTEGER
    href TEXT
);

CREATE TABLE labels ( 
    killmail_id INTEGER,
    label TEXT
);
