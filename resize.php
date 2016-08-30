#!/usr/bin/php
<?php
/*
$width_2x = intval($argv[1]);
$width_3x = intval($argv[2]);
$filename = $argv[3];
*/

function resizeImage($width_2x, $width_3x, $filename) {
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $basename = pathinfo($filename, PATHINFO_FILENAME);

    $output2x = dirname(__FILE__) . '/out/' . $basename . '_2x.' . $ext;  
    $output3x = dirname(__FILE__) . '/out/' . $basename . '_3x.' . $ext;     

    if($ext == "jpg") {
        $source = imagecreatefromjpeg($filename);
        $imagesavefunction = "imagejpeg";
    } else if ($ext == "gif") {
        $source = imagecreatefromgif($filename);
        $imagesavefunction = "imagegif";
    } else if ($ext == "png") {
        $source = imagecreatefrompng($filename);
        $imagesavefunction = "imagepng";
    } else {
        die("filetype not support");                       
    }

    list($srcwidth, $srcheight) = getimagesize($filename);
    $ratio = $srcwidth / $srcheight;

    $height_2x = round($width_2x / $ratio);
    $img2x = imagecreatetruecolor($width_2x, $height_2x);
    $height_3x = round($width_3x / $ratio);
    $img3x = imagecreatetruecolor($width_3x, $height_3x);

    if($ext == "png") {
        $alpha = imagecolorallocatealpha($img2x, 0, 0, 0, 127);
        imagefill($img2x, 0, 0, $alpha);
        imagefill($img3x, 0, 0, $alpha);
    }

    imagecopyresampled( $img2x, $source, 0 , 0, 0 ,0 , $width_2x, $height_2x, $srcwidth, $srcheight);
    imagecopyresampled( $img3x, $source, 0 , 0, 0 ,0 , $width_3x, $height_3x, $srcwidth, $srcheight);

    echo $filename  . " $srcwidth x $srcheight " . PHP_EOL;
    echo $output2x  . " $width_2x x $height_2x " . PHP_EOL;
    echo $output3x  . " $width_3x x $height_3x " . PHP_EOL;

    if($ext == "png") {
        imagesavealpha($img2x, true);
        imagesavealpha($img3x, true);
    }
    $imagesavefunction($img2x,  $output2x);
    $imagesavefunction($img3x,  $output3x);
    
}

$outdir = dirname(__FILE__) . '/out';
if(!file_exists($outdir))
{
    mkdir($outdir);
}

$config = json_decode(file_get_contents("config.json"), true);
print_r($config);
foreach ($config['images'] as $c) {
    resizeImage($c['width2x'], $c['width3x'], $c['name']);
}
