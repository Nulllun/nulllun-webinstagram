<?php
$source_file = $_COOKIE['img_name'];
$tmp_fileInfo = pathinfo($source_file);
$edit_file = $tmp_fileInfo['dirname'] .'/tar'. $tmp_fileInfo['basename'];
$tmp_filename = $tmp_fileInfo['basename'];
$target_file = 'photo_album/' . $tmp_filename;

rename($edit_file,$target_file);

unlink($source_file);

$iclass = $_COOKIE['class'];

$db_server = 'localhost';
$db_name = 'webinstagram';
$db_username = 'michael';
$db_password = '123456';
$db_con = mysqli_connect($db_server,$db_username,$db_password,$db_name);
//public = 0//private = 1

if($db_con){
    $sql = $db_con->prepare('INSERT INTO image(iname, iclass) VALUE (?,?)');
    $sql->bind_param('si',$tmp_filename,$iclass);
    if($sql->execute()){
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