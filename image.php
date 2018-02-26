<?php
<<<<<<< HEAD
=======

>>>>>>> c81fd3cb228653092e3f06924f918db91d68c47c
if (empty($_POST['user_name'])) {
        http_response_code(400);
        echo "Введите фамилилю и имя.";
        exit();
    } 
<<<<<<< HEAD

if (empty($_POST['user_rating'])) {
        http_response_code(400);
        echo "Вы не прошли тест!";
        exit();
    } 
    else {
=======
    elseif (empty($_POST['user_rating'])) {
        http_response_code(400);
        echo "Вы не прошли тест!";
        exit();
     } 
     else 
     {
>>>>>>> c81fd3cb228653092e3f06924f918db91d68c47c
        $userName = $_POST['user_name'];
        $rating = $_POST['user_rating'];
    }

$image = imagecreatetruecolor(965, 685);
$backcolor = imagecolorallocate($image, 255, 255, 555);
$textcolor = imagecolorallocate($image, 50, 50, 50);
<<<<<<< HEAD
=======

>>>>>>> c81fd3cb228653092e3f06924f918db91d68c47c
$boxFile = __DIR__ . '/sertificate.jpg';
if (!file_exists($boxFile)) {
    echo "Файл с картинкой не найден";
    exit();
}
<<<<<<< HEAD
$imBox = imagecreatefromjpeg($boxFile);
imagefill($image, 0, 0, $backcolor);
imagecopy($image, $imBox, 0, 0, 0, 0, 965, 685);
=======

$imBox = imagecreatefromjpeg($boxFile);
imagefill($image, 0, 0, $backcolor);
imagecopy($image, $imBox, 0, 0, 0, 0, 965, 685);

>>>>>>> c81fd3cb228653092e3f06924f918db91d68c47c
$fontFile = __DIR__ . '/timesbi.ttf';
if (!file_exists($fontFile)) {
    echo "Файл со шрифтом не найден";
    exit();
}
<<<<<<< HEAD
=======

>>>>>>> c81fd3cb228653092e3f06924f918db91d68c47c
imagettftext($image, 25, 0, 390, 340, $textcolor, $fontFile, $userName);  
imagettftext($image, 14, 0, 450, 395, $textcolor, $fontFile, $rating);
header('Content-type: image/jpeg');
imagejpeg($image); 

<<<<<<< HEAD
?>
=======
?>
>>>>>>> c81fd3cb228653092e3f06924f918db91d68c47c
