<?php
echo '<h1>Testing</h1>';
$test = getenv("DATABASE_URL");
$pdo = pg_connect(getenv("DATABASE_URL"));
echo $test;
if(!$pdo) {
    die("Error in connection: " . pg_last_error() . '<br>');
}else{
    echo 'Success connect to database<br>';
}

try{
    pg_exec($pdo,"CREATE TABLE wi_user(uid INT AUTO_INCREMENT PRIMARY KEY, wi_name CHAR(20) NOT NULL, wi_pass CHAR(20) NOT NULL)");

    pg_exec($pdo,"INSERT INTO wi_user(wi_name,wi_pass) VALUES ('admin','minda123')");

    pg_exec($pdo,"INSERT INTO wi_user(wi_name,wi_pass) VALUES ('Alice','csci4140')");

}catch (PDOException $e){
    echo $e->getMessage().'<br>';
}


//if($create_user) echo 'Success create user table<br>';
//if($insert_admin) echo 'Success insert admin<br>';
//if($insert_alice) echo 'Success insert alice<br>';
if(!extension_loaded('pgsql')){
    echo 'pgsql is not loaded<br>';
}else{
    echo 'pgsql is loaded<br>';
}

if(!extension_loaded('imagick')){
    echo 'Imagick is not loaded<br>';
    echo 'Imagick is loaded<br>';
}