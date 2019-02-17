<?php
echo '<h1>Testing</h1>';
$pdo = pg_connect(getenv("DATABASE_URL"));
if(!$pdo) {
    die("Error in connection: " . pg_last_error() . '<br>');
}else{
    echo 'Success connect to database<br>';
}

try{
    pg_query($pdo,"DROP TABLE wiuser");
    $create_user = pg_query($pdo,"CREATE TABLE wiuser(uid SERIAL PRIMARY KEY, winame CHAR(20) NOT NULL, wipass CHAR(20) NOT NULL);");
    if(!$create_user){
        echo 'Cannot create table<br>';
    }else{
        echo 'Created table<br>';
    }
    $name1 = 'admin';
    $name2 = 'Alice';
    $pw1 = 'minda123';
    $pw2 = 'csci4140';
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

try{
    pg_query($pdo,"DROP TABLE image");
    $create_img = pg_query($pdo,"CREATE TABLE image(iid SERIAL PRIMARY KEY,iname CHAR(255) NOT NULL ,iclass INT NOT NULL ,create_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP);");
}catch (PDOException $e){
    echo $e->getMessage().'<br>';
}