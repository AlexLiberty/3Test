<?php
session_start();

function loadQuestions($filename) {
    $questions = [];
    $lines = file($filename, FILE_IGNORE_NEW_LINES);

    foreach ($lines as $line) {
        $parts = explode('|', $line);
        $questionText = $parts[0];
        $options = explode(',', $parts[1]);
        $correctAnswers = explode(',', $parts[2]);

        $questions[] = [
            'question' => $questionText,
            'options' => $options,
            'correct' => $correctAnswers,
        ];
    }
    shuffle($questions);
    return $questions;
}

$questions = loadQuestions('test2.txt');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $score = 0;
    foreach ($questions as $index => $question) {
        if (isset($_POST['question' . $index])) {
            $userAnswers = $_POST['question' . $index];
            if (is_array($userAnswers) && count(array_intersect($userAnswers, $question['correct'])) === count($question['correct'])) {
                $score++;
            }
        }
    }
    $_SESSION['score_part2'] = $score;
    header('Location: page3.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Частина 2</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h2>Частина 2: Кілька правильних відповідей</h2>
    <form method="POST">
        <?php foreach ($questions as $index => $question): ?>
            <div class="question">
                <p><?php echo ($index + 1) . '. ' . $question['question']; ?></p>
                <?php foreach ($question['options'] as $option): ?>
                    <label>
                        <input type="checkbox" name="question<?php echo $index; ?>[]" value="<?php echo $option; ?>">
                        <?php echo $option; ?>
                    </label><br>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
        <button type="submit">Далі</button>
    </form>
</div>
</body>
</html>
