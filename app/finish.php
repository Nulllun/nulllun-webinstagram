<?php
$source_file = $_COOKIE['img_name'];
$tmp_fileInfo = pathinfo($source_file);
$edit_file = $tmp_fileInfo['dirname'] .'/tar'. $tmp_fileInfo['basename'];
$tmp_filename = $tmp_fileInfo['basename'];
$target_file = 'photo_album/' . $tmp_filename;

rename($edit_file,$target_file);

unlink($source_file);

$iclass = $_COOKIE['class'];

$pdo = pg_connect(getenv("DATABASE_URL"));

//public = 0//private = 1

if($pdo){
    //pg_prepare($dbconn, "my_query", 'SELECT * FROM shops WHERE name = $1');
    $sql = pg_prepare($pdo,'insert_img','INSERT INTO image(iname, iclass) VALUE (?,?)');
    $sql = pg_execute($pdo,'insert_img', array($tmp_filename,$iclass));
    //$sql->bind_param('si',$tmp_filename,$iclass);
    if($sql){
        //echo 'Record has been added to database.<br>';
    }else{
        echo 'Fail to add record to database.<br>';
    }
    $sql->close();
    $db_con->close();
}else{
    echo 'Fail to connect database.<br>';
    echo 'Fail to add record to database.<br>';
}

$permalink = 'http://'.$_SERVER[HTTP_HOST].'/WebInstagram/'.$target_file;
echo 'The permalink: '.$permalink.'<br>';
echo "<img src='".$target_file."'/><br>";
echo '<a href="index.php">Back to index page</a>';