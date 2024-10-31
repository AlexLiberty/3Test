<?php
session_start();

function loadQuestions($filename) {
    $questions = [];
    $lines = file($filename, FILE_IGNORE_NEW_LINES);

    foreach ($lines as $line) {
        $parts = explode('|', $line);
        $questionText = $parts[0];
        $correctAnswer = $parts[1];

        $questions[] = [
            'question' => $questionText,
            'correct' => $correctAnswer,
        ];
    }
    shuffle($questions);
    return $questions;
}

$questions = loadQuestions('test3.txt');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $score = 0;
    foreach ($questions as $index => $question) {
        if (isset($_POST['question' . $index]) && trim($_POST['question' . $index]) === $question['correct']) {
            $score++;
        }
    }
    $_SESSION['score_part3'] = $score;
    header('Location: results.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Частина 3</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h2>Частина 3: Відповідь текстом</h2>
    <form method="POST">
        <?php foreach ($questions as $index => $question): ?>
            <div class="question">
                <p><?php echo ($index + 1) . '. ' . $question['question']; ?></p>
                <input type="text" name="question<?php echo $index; ?>" required>
            </div>
        <?php endforeach; ?>
        <button type="submit">Завершити</button>
    </form>
</div>
</body>
</html>
