<?php
$pdo = pg_connect(getenv("DATABASE_URL"));
if(!$pdo) {
    die("Error in connection: " . pg_last_error() . '<br>');
}else{
    echo 'Success connect to database<br>';
}

if($pdo){
    if(empty($_POST['username'])||(empty($_POST['password']))){
        echo 'Username or password is empty. This page will return to index page in 3 seconds';
        header('Refresh: 3; URL = index.php');
        exit();
    }else{
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
        $sql = "SELECT wiuser.wipass FROM wiuser WHERE wiuser.winame = ".$username;

        $result = pg_exec($pdo,$sql);

        if($result){
            $flag = 0;
            while($row = pg_fetch_row($result)){
                if($row[2]==$password){
                    $flag = 1;
                }
            }
            if($flag == 1){
                //The user login successfully
                //Set cookies
                setcookie('user',$username,time()+3600);
                pg_close($pdo);
                header('Location: index.php');
                exit();
            }else{
                //Wrong password
                echo 'Wrong password! This page will return to index page in 3 seconds.';
                pg_close($pdo);
                header('Refresh: 3; URL = index.php');
                exit();
            }
        }else{
            //Username not exist
            echo 'Username not exist! This page will return to index page in 3 seconds.';
            pg_close($pdo);
            header('Refresh: 3; URL = index.php');
            exit();
        }
    }

}else {
    echo 'Fail to connect database. This page will return to index page in 3 seconds.';
    header('Refresh: 3; URL = index.php');
    exit();
}