<?php
//If no upload file
setcookie('img_name','',time()-3600);
setcookie('class','',time()-3600);
setcookie('uploadErr','',time()-30);
if(empty($_FILES['fileToUpload']['name'])){
    //echo 'No selected file. This page will return to index page in 3 seconds';
    setcookie('uploadErr','No selected file',time()+30);
    header('Location: index.php');
    exit();
}

//If not select private/pubilc
if(empty($_POST['imageClass'])){
    //echo 'Please upload the image as PUBLIC or PRIVATE. This page will return to index page in 3 seconds';
    setcookie('uploadErr','Please upload the image as PUBLIC or PRIVATE',time()+30);
    header('Location: index.php');
    exit();
}
if($_POST['imageClass']=='public'){
    $iclass = 0;
}else{
    $iclass = 1;
}
$target_dir = "temp/";
$target_file = $target_dir .time(). basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["imageSubmit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        //echo "File is an image - " . $check["mime"] . "." . '<br>';
        $uploadOk = 1;
    } else {
        //echo "File is not an image.<br>";
        setcookie('uploadErr','Uploaded file is not an image',time()+30);
        header('Location: index.php');
        exit();
        $uploadOk = 0;
    }
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" &&  $imageFileType != "gif" ) {
    //echo "Sorry, only JPG, PNG & GIF files are allowed.<br>";
    setcookie('uploadErr','Wrong format, only JPG, PNG & GIF files are allowed',time()+30);
    header('Location: index.php');
    exit();
    $uploadOk = 0;
}
$check_img = new Imagick($_FILES["fileToUpload"]["tmp_name"]);
$img_info = $check_img->identifyImage();
$real_format = $img_info['format'];

if($imageFileType == 'jpg'){
    if(!($real_format == 'jpeg'||$real_format == 'jpg')){
        setcookie('uploadErr','Uploaded file extension does not match its content',time()+30);
        header('Location: index.php');
        exit();
        $uploadOk = 0;
    }
}
if($imageFileType == 'gif'){
    if(!$real_format == 'gif'){
        setcookie('uploadErr','Uploaded file extension does not match its content',time()+30);
        header('Location: index.php');
        exit();
        $uploadOk = 0;
    }
}
if($imageFileType == 'png'){
    if(!$real_format == 'png'){
        setcookie('uploadErr','Uploaded file extension does not match its content',time()+30);
        header('Location: index.php');
        exit();
        $uploadOk = 0;
    }
}


// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    //echo "Sorry, your file was not uploaded.<br>";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        // Upload File succeed
        setcookie('img_name',$target_file,time()+3600);
        setcookie('class',$iclass,time()+3600);
        header('Location: edit_photo.php');
        exit();
    } else {
        setcookie('uploadErr','Sorry, there was an error uploading your file',time()+30);
        header('Location: index.php');
        exit();
    }
}

//echo 'This page will return to index page in 3 seconds.<br>';
//header('Refresh: 3; URL = index.php');
echo '<a href="index.php">Back to index page</a>';
