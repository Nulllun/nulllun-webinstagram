<?php

$source_file = $_COOKIE['img_name'];
$target_file = pathinfo($source_file);
$target_file = $target_file['dirname'] .'/tar'. $target_file['basename'];unlink($target_file);
unlink($target_file);
unlink($source_file);
header('Location: index.php');
exit();