<?php
session_start();

$score_part1 = isset($_SESSION['score_part1']) ? $_SESSION['score_part1'] : 0;
$score_part2 = isset($_SESSION['score_part2']) ? $_SESSION['score_part2'] : 0;
$score_part3 = isset($_SESSION['score_part3']) ? $_SESSION['score_part3'] : 0;

$total_score = ($score_part1 * 1) + ($score_part2 * 3) + ($score_part3 * 5);

if ($total_score >= 90)
{
    $result_message = "Відмінний результат!";
}
elseif ($total_score >= 60)
{
    $result_message = "Добрий результат!";
}
elseif ($total_score >= 45)
{
    $result_message = "Спробуйте ще раз!";
}
else
{
    $result_message = "На жаль, ви не набрали жодного балу.";
}

session_destroy();
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Результати тесту</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h2>Результати тесту</h2>
    <p>Кількість правильних відповідей у першій частині: <?php echo $score_part1; ?></p>
    <p>Кількість правильних відповідей у другій частині: <?php echo $score_part2; ?></p>
    <p>Кількість правильних відповідей у третій частині: <?php echo $score_part3; ?></p>
    <h3>Загальна кількість балів: <?php echo $total_score; ?></h3>
    <h4><?php echo $result_message; ?></h4>
    <a href="index.php" class="buttons">Почати занову</a>
</div>
</body>
</html>
