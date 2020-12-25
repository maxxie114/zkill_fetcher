/* Create the database, user and all the tables in one script */

/* Create the database */
CREATE DATABASE killmail;

/* Create the user needed for this program and grant all privileges to killmail */
CREATE USER 'fetcher'@'localhost'
    IDENTIFIED BY 'Password!_35';

GRANT ALL PRIVILEGES 
    ON killmail.* 
    TO 'fetcher'@'localhost';

FLUSH PRIVILEGES;

/* Switch to the appropriate database */
USE killmail;

/* Create table killmail */
CREATE TABLE killmail (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    killID INTEGER,
    killmail_id INTEGER,
    killmail_time VARCHAR(20),
    solar_system_id INTEGER
);

/* Create table attacker */
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

/* Create table victim */
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

/* Create table zkb */
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

/* Create table labels */
CREATE TABLE labels ( 
    killmail_id INTEGER,
    label VARCHAR(10)
);
