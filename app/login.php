<?php
$db_server = 'localhost';
$db_name = 'webinstagram';
$db_username = 'michael';
$db_password = '123456';
$db_con = mysqli_connect($db_server,$db_username,$db_password,$db_name);

if($db_con){
    if(empty($_POST['username'])||(empty($_POST['password']))){
        echo 'Username or password is empty. This page will return to index page in 3 seconds';
        header('Refresh: 3; URL = index.php');
        exit();
    }else{
        $sql = mysqli_prepare($db_con,'SELECT user.passwd FROM user WHERE user.username = ?');
        $sql->bind_param('s',$username);
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
        $sql->execute();
        $sql->bind_result($result);
        $sql->fetch();
        if($result){
            if($result == $password){
                //The user login successfully
                //Set cookies
                setcookie('user',$username,time()+3600);
                $sql->close();
                $db_con->close();
                header('Location: index.php');
                exit();
            }else{
                //Wrong password
                echo 'Wrong password! This page will return to index page in 3 seconds.';
                $sql->close();
                $db_con->close();
                header('Refresh: 3; URL = index.php');
                exit();
            }
        }else{
            //Username not exist
            echo 'Username not exist! This page will return to index page in 3 seconds.';
            $sql->close();
            $db_con->close();
            header('Refresh: 3; URL = index.php');
            exit();
        }
    }

}else {
    echo 'Fail to connect database. This page will return to index page in 3 seconds.';
    header('Refresh: 3; URL = index.php');
    exit();
}