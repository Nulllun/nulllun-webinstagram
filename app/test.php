<?php
echo '<h1>Testing</h1>';
$test = getenv("DATABASE_URL");
$pdo = pg_connect(getenv("DATABASE_URL"));
echo $test.'<br>';
if(!$pdo) {
    die("Error in connection: " . pg_last_error() . '<br>');
}else{
    echo 'Success connect to database<br>';
}

try{
    $create_user = pg_query($pdo,"CREATE TABLE wiuser(uid SERIAL PRIMARY KEY, winame CHAR(20) NOT NULL, wipass CHAR(20) NOT NULL);");
    if(!$create_user){
        echo 'Cannot create table<br>';
    }else{
        echo 'Created table<br>';
    }
    pg_query($pdo,"INSERT INTO wiuser(winame,wipass) VALUES ('admin','minda123')");

    pg_query($pdo,"INSERT INTO wiuser(winame,wipass) VALUES ('Alice','csci4140')");

    $result = pg_query($pdo,"SELECT * FROM wiuser");
    if($result) {
        while ($row = pg_fetch_row($result)) {
            echo $row[0] . $row[1] . $row[2] . '<br>';
        }
    }else{
        echo 'Cannot get any result<br>';
    }
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
}else{
    echo 'Imagick is loaded<br>';
}