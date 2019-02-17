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
$db_server = 'localhost';
$db_name = 'webinstagram';
$db_username = 'michael';
$db_password = '123456';
$db_con = mysqli_connect($db_server,$db_username,$db_password,$db_name);

if($db_con){
    $drop_table_sql = 'DROP TABLE image';
    if(!$db_con->query($drop_table_sql)){
        echo 'Table "image" cannot be dropped<br>';
    }
}else{
    echo 'The initialization fails';
}

//Create database tables
$create_table_sql = 'CREATE TABLE image (iid INT NOT NULL AUTO_INCREMENT, iname CHAR(255) NOT NULL, iclass INT NOT NULL, create_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (iid))';
if(!$db_con->query($create_table_sql)){
    echo 'Table "image" cannot be created<br>';
}

echo 'Initialization process is finished<br><br>';
echo '<a href="index.php">Back to index</a>';