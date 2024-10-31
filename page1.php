<?php
session_start();

function loadQuestions($filename) {
    $questions = [];
    $lines = file($filename, FILE_IGNORE_NEW_LINES);

    foreach ($lines as $line) {
        $parts = explode('|', $line);
        $questionText = $parts[0];
        $options = explode(',', $parts[1]);
        $correctAnswer = $parts[2];

        $questions[] = [
            'question' => $questionText,
            'options' => $options,
            'correct' => $correctAnswer,
        ];
    }
    shuffle($questions);
    return $questions;
}

$questions = loadQuestions('test1.txt');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $score = 0;
    foreach ($questions as $index => $question) {
        if (isset($_POST['question' . $index]) && $_POST['question' . $index] === $question['correct']) {
            $score++;
        }
    }
    $_SESSION['score_part1'] = $score;
    header('Location: page2.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Частина 1</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h2>Частина 1: Одна правильна відповідь</h2>
    <form method="POST">
        <?php foreach ($questions as $index => $question): ?>
            <div class="question">
                <p><?php echo ($index + 1) . '. ' . $question['question']; ?></p>
                <?php foreach ($question['options'] as $option): ?>
                    <label>
                        <input type="radio" name="question<?php echo $index; ?>" value="<?php echo $option; ?>" required>
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
