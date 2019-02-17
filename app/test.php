<?php
$db = parse_url(getenv("DATABASE_URL"));

$pdo = new PDO("pgsql:" . sprintf(
        "host=%s;port=%s;user=%s;password=%s;dbname=%s",
        $db["host"],
        $db["port"],
        $db["user"],
        $db["pass"],
        ltrim($db["path"], "/")
    ));

$create_user = pg_query($pdo,"CREATE TABLE wi_user(uid INT AUTO_INCREMENT PRIMARY KEY, wi_name CHAR(20) NOT NULL, wi_pass CHAR(20) NOT NULL)");

$insert_admin = pg_query($pdo,"INSERT INTO wi_user(wi_name,wi_pass) VALUES ('admin','minda123')");

$insert_alice = pg_query($pdo,"INSERT INTO wi_user(wi_name,wi_pass) VALUES ('Alice','csci4140')");

if($create_user) echo 'Success create user table<br>';
if($insert_admin) echo 'Success insert admin<br>';
if($insert_alice) echo 'Success insert alice<br>';