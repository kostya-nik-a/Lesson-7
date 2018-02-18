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
echo "<pre>";
//print_r($tests);
print_r($_POST);

$trueAnswer = 0;
$falseAnswer = 0;
$noAnswer = 0;

$userAnswers = [];
$trueAnswers = [];

$i = 0;
$x = 0;
foreach ($tests as $tkey => $test) {
    $trueAnswers['trueAnswerUser'.$i] = $test['correct-answer'];
    if (empty($_POST) || !isset($_POST['answerUser'.$i])) {
        $noAnswer++;            
        } 
        elseif (isset($_POST['answerUser'.$i]) && $_POST['answerUser'.$i] == $trueAnswers['trueAnswerUser'.($i+1)]) {
            $trueAnswer++;    
            $userAnswers['aUser'.$i] == $_POST['answerUser'.$i];        
        } 
        else {
            $falseAnswer++;            
        }
        $i++;
        $x++;
}

print_r($trueAnswers);
print_r($userAnswers);

echo "<br>";
echo "Количество правильных ответов:".$trueAnswer;
echo "<br>";
echo "Количество НЕ правильных ответов:".$falseAnswer;
echo "<br>";
echo "Нет ответов на ".$noAnswer." вопросов";
echo "<br>";

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
                    foreach ($tests as $tkey => $test) {
                ?>
                <fieldset>
                    <legend>
                        <h2><?php echo $test['question'] ?></h2>
                    </legend>
                <?php
                    for ($i = 0; $i < count($test['answers']); $i++) {
                ?>
                <label>
                    <input name="<?php echo 'answerUser'.$i ?>" type="radio" value="<?php echo $test['answers'][$i]; ?>"><?php echo $test['answers'][$i]; ?>
                </label>
                <?php
                    }
                ?>
                </fieldset>
                <?php
                }
                ?>

                <label> Введите свое имя и фамилию <input  name="user_name" type="text" value=""></label><br> 
                <button type="submit">Результат</button>   
                                       
            </div>
        </form>
    </body>
</html>
