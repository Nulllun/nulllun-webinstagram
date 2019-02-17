<?php
$pdo = pg_connect(getenv("DATABASE_URL"));

$loop_tmp = 1;
if(isset($_GET['page'])){
    $page_num = $_GET['page'];
    if(isset($_GET['max_row'])){
        $max_page = ceil($_GET['max_row']/8);
        if($page_num < $max_page){
            $page_num = $page_num + 1;
        }
    }else{
        if($page_num > 1){
            $page_num = $page_num - 1;
        }
    }
}else{
    $page_num = 1;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WebInstagram</title>
</head>
<body>
<h1>Welcome to WebInstagram</h1>
<a href="test.php">Test</a><br>
<?php
    if(isset($_COOKIE['user']))echo 'Welcome back! ' .$_COOKIE['user'].'<br>';
    else echo 'Hello Guest!<br>';
?>

<?php if (isset($_COOKIE['user'])): ?>
    <button style="display: inline-block"><a href="logout.php">Logout</a></button>
    <?php echo ' '?>
    <?php if($_COOKIE['user']=='admin'): ?>
        <button style="display: inline-block"><a href="confirm_init.php">System Initialization</a></button>
    <?php endif; ?>
    <br><br>
<?php endif; ?>

<?php if (!isset($_COOKIE['user'])): ?>
    <button><a href="login.html">Click here to login</a></button><br>
<?php endif; ?>

<?php if($pdo): ?>
    <?php
        $sql = 'SELECT iname FROM image WHERE iclass = 0 ORDER BY create_time DESC';
        if(isset($_COOKIE['user'])){
            $sql = 'SELECT iname FROM image ORDER BY create_time DESC';
        }
    ?>
    <?php $result = pg_query($pdo,$sql);?>
    <?php $max_row = pg_num_rows($result); ?>
    <?php if($max_row>0): ?>
        <?php while ($row = pg_fetch_array($result)){?>
            <?php if((8*($page_num-1) < $loop_tmp)&&($loop_tmp <= 8*$page_num)): ?>
                <?php
                    echo 'HI<br>';
                    $display_img = 'photo_album/'.$row['iname'];
                    $ext = pathinfo($display_img);
                    $ext = $ext['extension'];
                    $resized_img = new Imagick();
                    $tmp_img = file_get_contents($display_img);
                    $resized_img->readImageBlob($tmp_img);
                    $resized_img->resizeImage(300,300,1,1,True);
                    $permalink = 'https://'.$_SERVER[HTTP_HOST].'/'.$display_img;
                    echo '<img src="data:image/'.$ext.';base64,'.base64_encode($resized_img->getImageBlob()).'" alt="" />';
                    echo 'The permalink: '.$permalink.'<br>';
                    $resized_img->destroy();
                ?>
            <?php endif; ?>
            <?php $loop_tmp = $loop_tmp+1 ?>
        <?php }?>
    <?php endif; ?>
<?php endif; ?>
<br>

<div style="display: inline-block"><button><a href="index.php?page=<?php echo $page_num ?>">Previous Page</a></button></div>
<div style="display: inline-block"><p>Current Page: <?php echo $page_num; ?></p></div>
<div style="display: inline-block"><button><a href="index.php?page=<?php echo $page_num ?>&max_row=<?php echo $max_row ?>">Next Page</a></button></div>

<form action="upload_photo.php" method="post" enctype="multipart/form-data"><br>
    Upload photo:
    <input type="file" value="Select Image" name="fileToUpload" id="fileToUpload">
    private: <input type="radio" name="imageClass" value="private">
    public: <input type="radio" name="imageClass" value="public">
    <input type="submit" value="Upload Image" name="imageSubmit">
</form>
<?php if(isset($_COOKIE['uploadErr'])): ?>
    <p style="color: red"><?php echo $_COOKIE["uploadErr"]?></p>
    <?php setcookie('uploadErr','',time()-30)?>
<?php endif; ?>
</body>
</html>
