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
$rating = 0;

foreach ($tests as $qkey => $questions) {
    if (is_array($questions)) {
        $i = 0;
        foreach ($questions as $answers) {
            if (empty($_POST)) {   
            } 
            elseif (empty($_POST["answerUser$i"])) {
                $noAnswer++;            
            } elseif ($_POST["answerUser$i"] == $answers["correct-answer"]) {
                $trueAnswer++;            
            } else {
                $falseAnswer++;            
            }
            $i++; 
        }
    }
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
        <form action="image.php" method="POST">
            <div style="width: 50%; text-align: left;">
                <?php 
                        foreach ($tests as $qkey => $questions) {
                            if (is_array($questions)) {
                                $x = 0;
                                foreach ($questions as $answers) {
                    ?>
                    <fieldset>
                    <legend>
                        <h3><?php echo $answers['question'] ?></h3>
                    </legend>
                    <label>
                        <?php 
                            for ($i=0; $i < count($answers['answers']);$i++) { 
                        ?>
                    <input name="<?php echo 'answerUser'.$x ?>" type="radio" value="<?php echo $answers['answers'][$i]; ?>"><?php echo $answers['answers'][$i]; ?>
                    <?php 
                        }
                    ?>
                    </label>
                </fieldset>
                <?php
                        $x++;
                        }
                    }
                }

                ?>
                <?php 
                if (!empty($_POST)) {
                echo  
                "<p> Количество правильных ответов: " . $trueAnswer . "</p>" .
                "<p> Количество НЕ правильных ответов: " . $falseAnswer . "</p>" .
                "<p> Нет ответов на " .$noAnswer. " вопросов </p>";
                }  

                $numQuestions = $x;

                if ($trueAnswer == $numQuestions) {
                    $rating = "Супер!";
                    $_POST['user_rating'] = $rating;
                } 
                elseif ($trueAnswer < $numQuestions && $trueAnswer >= $numQuestions-1 ) {
                    $rating = "Очень хорошо!";
                    $_POST['user_rating'] = $rating;
                } 
                elseif ($trueAnswer <= $numQuestions-2 && $trueAnswer >= $numQuestions-3 ) {
                    $rating = "Могли бы и лучше!";
                    $_POST['user_rating'] = $rating;
                }
                else {
                    $rating = "Печально!";
                    $_POST['user_rating'] = $rating;
                }

                ?>

                <br><br><strong>Введите ваши фамилию и имя: </strong><input type="text" name="user_name" value="">
                <input type="hidden" name="user_rating" value="<?php echo $rating ?>">
                <br>
                <button type="submit">Результат</button>            
            </div>
        </form>
    </body>
</html>
