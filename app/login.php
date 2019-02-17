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
        $username = $_POST['username'];
        $password = $_POST['password'];
        if($username=='Alice')echo "The user is Alice<br>";
        $sql = "SELECT * FROM wiuser";
        echo $sql.'<br>';
        $result = pg_query($pdo,$sql);
        if($result){
            $flag = 0;
            while($row = pg_fetch_row($result)){
                if(trim($row[1])==$username&&trim($row[2])==$password){
                    $flag = 1;
                }
                //echo $row[1].'|'.$username.'|'.$row[2].'|'.$password.'<br>';
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
                //header('Refresh: 3; URL = index.php');
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