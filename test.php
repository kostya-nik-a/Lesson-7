<?php

$test_number = ($_GET['test_number']);
$testDir = "./tests/";
$tests_list = scandir($testDir);
$numFiles=count($tests_list)-1;
if ($test_number < 1 || !ctype_digit($test_number) || $test_number > count($tests_list) - 2) {
   header("HTTP/1.1 404 Not Found"); 
   exit();
}
$test = $tests_list[$test_number+1];
$contents = file_get_contents(__DIR__ . $testDir.DIRECTORY_SEPARATOR.$test);
$tests = json_decode($contents, true);

$trueAnswer = 0;
$falseAnswer = 0;
$noAnswer = 0;
$userAnswers = [];
$i = 0;

foreach ($tests as $userAnswers) {
    if (empty($_POST)) {   
    } 
    elseif (empty($_POST["answerUser$i"])) {
            $noAnswer++;            
    } elseif ($_POST["answerUser$i"] == $userAnswers["correct-answer"]) {
            $trueAnswer++;            
    } else {
            $falseAnswer++;            
    }
            $i++; 
}

if (!empty($_POST)) {
    $userName = $_POST['user_name']; 

if (empty($_POST['user_name'])) {
    http_response_code(400);
    echo "Введите фамилилю и имя.";
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

imagettftext($image, 26, 0, 400, 300, $textcolor, $fontFile, $userName);  
imagettftext($image, 16, 0, 450, 350, $textcolor, $fontFile, $trueAnswer);
header('Content-type: image/jpeg');
imagejpeg($image); 

}


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Test</title>
    </head>
    <body>
        <h1>Вы проходите тест: <?php echo '<i style="color: blue;">'.$tests['title'].'</i>' ?> </h1>
        <form action="" method="POST">
            <div style="text-align: left;">
                <?php 
                    $i = 0;
                    foreach ($tests as $userAnswers) {
                ?>
                <fieldset>
                    <legend>
                        <h2><?php echo $userAnswers['question'] ?></h2>
                    </legend>
                <label>
                    <input name="<?php echo 'answerUser'.$i ?>" type="radio" value="<?php echo $userAnswers['answer1']; ?>"><?php echo $userAnswers['answer1']; ?>
                    <input name="<?php echo 'answerUser'.$i ?>" type="radio" value="<?php echo $userAnswers['answer2']; ?>"><?php echo $userAnswers['answer2']; ?>
                    <input name="<?php echo 'answerUser'.$i ?>" type="radio" value="<?php echo $userAnswers['answer3']; ?>"><?php echo $userAnswers['answer3']; ?>
                    <input name="<?php echo 'answerUser'.$i ?>" type="radio" value="<?php echo $userAnswers['answer4']; ?>"><?php echo $userAnswers['answer4']; ?>
                </label>
                </fieldset>
                <?php
                $i++;
                }
                ?>

                <label> Введите свое имя и фамилию <input  name="user_name" type="text" value=""></label><br> 
                <button type="submit">Результат</button>   
                                       
            </div>
        </form>
    </body>
</html>
