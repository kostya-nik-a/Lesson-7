<?php
if (empty($_POST['user_name'])) {
        http_response_code(400);
        echo "Введите фамилилю и имя.";
        exit();
    } 
    else {
        $userName = $userName = $_POST['user_name'];
    }

$image = imagecreatetruecolor(965, 685);
$backcolor = imagecolorallocate($image, 255, 255, 555);
$textcolor = imagecolorallocate($image, 50, 50, 50);

$boxFile = __DIR__ . '/sertificate.jpg';
if (!file_exists($boxFile)) {
    echo "Файл с картинкой не найден";
    exit();
}

$imBox = imagecreatefromjpeg($boxFile);
imagefill($image, 0, 0, $backcolor);
imagecopy($image, $imBox, 0, 0, 0, 0, 965, 685);

$fontFile = __DIR__ . '/timesbi.ttf';
if (!file_exists($fontFile)) {
    echo "Файл со шрифтом не найден";
    exit();
}

imagettftext($image, 25, 0, 350, 330, $textcolor, $fontFile, $userName);  
imagettftext($image, 14, 0, 450, 350, $textcolor, $fontFile, $trueAnswer);
header('Content-type: image/jpeg');
imagejpeg($image); 



?>
