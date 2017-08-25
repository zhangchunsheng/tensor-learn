<?php
if(count($argv) < 2) {
    echo "usage: php text_to_image.php path\n";
    exit();
}
$path = $argv[1];

$trainPath = $path . "/train";
$testPath = $path . "/test";

$file = fopen("chn_sim.txt", "r");

$strs = "";
while (!feof($file)) {
    $line = fgets($file);
    if (!empty($line)) {
        $strs += $line;
    }
}

foreach($strs as $str) {
    drawTrainText($str);

    $random = mt_rand(1, 10);
    if($random < 2) {
        drawTestText($str);
    }
}

fclose($file);

function drawTrainText($character) {
    global $trainPath;

    drawText($trainPath, $character);
}

function drawTestText($character) {
    global $testPath;

    drawText($testPath, $character);
}

function drawText($path, $character) {
    $file = $path . "/$character.png";

    $width = 60;
    $height = 60;

    // Create the image
    $im = imagecreatetruecolor($width, $height);

    // Create some colors
    $white = imagecolorallocate($im, 255, 255, 255);
    $grey = imagecolorallocate($im, 128, 128, 128);
    $black = imagecolorallocate($im, 0, 0, 0);

    $left = 0;
    $right = 0;
    imagefilledrectangle($im, $left, $right, $width, $height, $white);

    // The text to draw
    $text = "$character";
    // Replace path by your own font path
    $font = 'font-type/micro_yahei.ttf';

    $size = 40;
    $angle = 0;
    $fontfile = $font;
    $bbox = imagettfbbox($size, $angle, $fontfile, $text);

    $dx = abs($bbox[2] - $bbox[0]);
    $dy = abs($bbox[5] - $bbox[3]);

    $px = abs($width / 2) - abs($dx / 2);
    $py = abs($dy - (abs($height - $dy)) / 2);

    $py = $size + ($height - $size) / 2;

    // Add the text
    imagettftext($im, $size, $angle, $px, $py, $black, $fontfile, $text);

    // Using imagepng() results in clearer text compared with imagejpeg()
    imagepng($im, $file);
    imagedestroy($im);
}