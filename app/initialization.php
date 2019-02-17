<?php
if(!isset($_COOKIE['user'])||$_COOKIE['user']!='admin'){
    header('Location: index.php');
    exit();
}

//Remove all stored photos
$dir1 = 'photo_album';
$dir2 = 'temp';
$files1 = glob($dir1.'/*');
$files2 = glob($dir2.'/*');

foreach ($files1 as $file1){
    unlink($file1);
}
foreach ($files2 as $file2){
    unlink($file2);
}

//Delete all database records of photo
$pdo = pg_connect(getenv("DATABASE_URL"));

if($pdo){
    $drop_table_sql = 'DROP TABLE image';
    if(!pg_query($pdo,$drop_table_sql)){
        echo 'Table "image" cannot be dropped<br>';
    }
}else{
    echo 'The initialization fails';
}

//Create database tables
$create_table_sql = "CREATE TABLE image(iid SERIAL PRIMARY KEY,iname CHAR(255) NOT NULL ,iclass INT NOT NULL ,create_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP);";
if(!pg_query($pdo,$create_table_sql)){
    echo 'Table "image" cannot be created<br>';
}

echo 'Initialization process is finished<br><br>';
echo '<a href="index.php">Back to index</a>';