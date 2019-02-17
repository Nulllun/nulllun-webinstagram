<?php
if(!isset($_COOKIE['user'])||$_COOKIE['user']!='admin'){
    header('Location: index.php');
    exit();
}

echo '<h1>System Initialization</h1>';
echo 'Important: all data will be deleted<br><br>';

echo '<button style="display: inline-block;background-color: red"><a href="initialization.php">Please Go Ahead</a></button>';
echo ' ';
echo '<button style="display: inline-block;background-color: lawngreen"><a href="index.php">Go Back</a></button>';

