<?php
$test_number = ($_GET['test_number']);
$testDir = __DIR__ ."/tests";
$tests_list = scandir($testDir);
if ($test_number < 1 || !ctype_digit($test_number) || $test_number > count($tests_list) - 2) {
   echo "Такого теста не существует. Выберите существующий номер теста на <a href='list.php'> предыдущей странице </a>";
   exit();
}

$test = $tests_list[$test_number+1];
$contents = file_get_contents($testDir.DIRECTORY_SEPARATOR.$test);
$tests = json_decode($contents, true);

$trueAnswer = 0;
$falseAnswer = 0;
$noAnswer = 0;
$i = 0;

foreach ($tests as $qkey => $questions) {
    if (is_array($questions)) {
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
        <h2>Вы проходите тест: <?php echo '<i style="color: blue;">'.$tests['title'].'</i>' ?> </h2>
        <form action="" method="POST">
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
                        //$x = 0;
                            for ($i=0; $i < count($answers['answers']); $i++) { 
                        ?>
                    <input name="<?php echo 'answerUser'.$x ?>" type="radio" value="<?php echo $answers['answers'][$i]; ?>"><?php echo $answers['answers'][$i]; ?>
                    <?php 
                       }  
                    ?>
                    </label>
                </fieldset>
                <?php
                        $x++;}  
                    }
                }

                ?>
                <button type="submit">Результат</button>   

                  <?php 
                if (!empty($_POST)) {
                echo  
                "<p> Количество правильных ответов: " . $trueAnswer . "</p>" .
                "<p> Количество НЕ правильных ответов: " . $falseAnswer . "</p>" .
                "<p> Нет ответов на " .$noAnswer. " вопросов </p>";
                }  
                ?>
                                       
            </div>
        </form>
    </body>
</html>
