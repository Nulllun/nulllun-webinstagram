<?php
if(isset($_COOKIE['img_name'])){
    //echo 'Cookie Set<br>';
    $source_file = $_COOKIE['img_name'];
    //echo $target_file.'<br>';
    $target_file = pathinfo($source_file);
    $target_file = $target_file['dirname'] .'/tar'. $target_file['basename'];
}

if(isset($_GET['filter'])){
    $filter = $_GET['filter'];
}else{
    $filter = 'none';
    copy($source_file,$target_file);
}
echo 'Photo editor<br>';
//echo '$source_file: '.$source_file.'<br>';
//echo '$target_file: '.$target_file.'<br>';

$ext = pathinfo($source_file);
$ext = $ext['extension'];
$tmp_img = file_get_contents($source_file);

$img = new Imagick();
$img->readImageBlob($tmp_img);

if($filter == 'border'){
    $color = new ImagickPixel();
    $color->setColor('rgba(150, 150, 150, 1.0)');
    $img->borderImage($color,20,20);
    $color->destroy();
}
if($filter == 'lomo'){
    $pixels = $img->getImageWidth() * $img->getImageHeight();
    $img->gammaImage(0.5,3);
    $img->modulateImage(100,100,100);
    $img->linearStretchImage(0.2*$pixels,0.2*$pixels);
}
if($filter == 'lensFlare'){
    $lens = new Imagick();
    $lens->readImageBlob(file_get_contents('lensFlare.jpg'));
    $lens->resizeImage($img->getImageWidth(),$img->getImageHeight(),1,1,False);
    $opacity = new \Imagick();
    $opacity->newPseudoImage(
        $img->getImageWidth(),
        $img->getImageHeight(),
        "gradient:gray(10%)-gray(90%)"
    );
    $opacity->rotateimage('black', 0);
    $lens->compositeImage($opacity, \Imagick::COMPOSITE_COPYOPACITY, 0, 0);
    $img->compositeImage($lens,\Imagick::COMPOSITE_ATOP,0,0);
    $lens->destroy();
    $opacity->destroy();
}
if($filter == 'blackWhite'){
    $img->modulateImage(100,0,100);
}
if($filter == 'blur'){
    $img->blurImage(10,10,2);
}

file_put_contents($target_file,$img->getImageBlob());
echo "<img src='data:image/".$ext.";base64,".base64_encode($img)."' /><br>";
echo '<br>'.'Filters: ';
echo '<div style="display: inline"><button><a href="edit_photo.php?filter=border">Border filter</a></button></div>';
echo ' ';
echo '<div style="display: inline"><button><a href="edit_photo.php?filter=lomo">Lomo filter</a></button></div>';
echo ' ';
echo '<div style="display: inline"><button><a href="edit_photo.php?filter=lensFlare">Lens Flare filter</a></button></div>';
echo ' ';
echo '<div style="display: inline"><button><a href="edit_photo.php?filter=blackWhite">Black White filter</a></button></div>';
echo ' ';
echo '<div style="display: inline"><button><a href="edit_photo.php?filter=blur">Blur filter</a></button></div>';
echo ' ';
echo '<div style="display: inline"><button><a href="edit_photo.php?filter=none">Cancel effect</a></button></div>';

echo '<br><br>';

echo '<div style="display: inline"><button><a href="discard.php">Discard</a></button></div>';
echo ' ';
echo '<div style="display: inline"><button><a href="finish.php">Finish</a></button></div>';

$img->destroy();
