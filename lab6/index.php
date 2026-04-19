<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Тест</title>
    <link rel="stylesheet" href="source.css">
    <script>
        function toggleMail() {
            let block = document.getElementById('mail_block');
            block.style.display = document.getElementById('send_mail').checked ? 'block' : 'none';
        }
    </script>
</head>
<?php
$result = null;
$out_text = "";

function toFloat($val) {
    return floatval(str_replace(',', '.', $val));
}

if (isset($_POST['A'])) {
    $A = toFloat($_POST['A']);
    $B = toFloat($_POST['B']);
    $C = toFloat($_POST['C']);
    $user_result = $_POST['user_result'] !== "" ? toFloat($_POST['user_result']) : null;
    $task = $_POST['TASK'];
    $task_name = "";
    switch ($task) {
        case 'mean':
            $result = round(($A + $B + $C) / 3, 2);
            $task_name = "Среднее арифметическое";
            break;
        case 'perimeter':
            $result = $A + $B + $C;
            $task_name = "Периметр треугольника";
            break;
        case 'area':
            $p = ($A + $B + $C) / 2;
            $result = round(sqrt($p * ($p - $A) * ($p - $B) * ($p - $C)), 2);
            $task_name = "Площадь треугольника (Герон)";
            break;
        case 'volume':
            $result = $A * $B * $C;
            $task_name = "Объем параллелепипеда";
            break;
        case 'max':
            $result = max($A, $B, $C);
            $task_name = "Максимум";
            break;
        case 'sum_sq':
            $result = $A*$A + $B*$B + $C*$C;
            $task_name = "Сумма квадратов";
            break;
    }
    $out_text .= "<h2>Результаты теста</h2>";
    $out_text .= "ФИО: " . $_POST['FIO']."<br>";
    $out_text .= "Группа: " . $_POST['GROUP']."<br>";
    if (!empty($_POST['ABOUT'])) $out_text .= "<br>О себе:<br>".nl2br($_POST['ABOUT'])."<br>";
    $out_text .= "<br>Задача: $task_name<br>";
    $out_text .= "A=$A, B=$B, C=$C<br>";
    if ($user_result === null) $out_text .= "<b>Задача самостоятельно решена не была</b><br>";
    else {
        $out_text .= "Ваш ответ: $user_result<br>";
        $out_text .= "Правильный ответ: $result<br>";
        if (abs($result - $user_result) < 0.01) $out_text .= "<b style='color:green;'>Тест пройден</b><br>";
        else $out_text .= "<b style='color:red;'>Ошибка: тест не пройден</b><br>";
    }
    echo "<div class='container ".$_POST['VIEW']."'>";
    echo $out_text;
    if (isset($_POST['send_mail'])) {
        mail($_POST['MAIL'], "Результат теста",
            strip_tags(str_replace("<br>", "\n", $out_text)),
            "Content-Type: text/plain; charset=utf-8"
        );
        echo "<p>Результаты отправлены на: " . $_POST['MAIL'] . "</p>";
    }
    if ($_POST['VIEW'] == 'browser') echo "<a class='btn' href='?fio=".$_POST['FIO']."&group=".$_POST['GROUP']."'>Повторить тест</a>";
    echo "</div>";
}
else {
    $A = mt_rand(1,100);
    $B = mt_rand(1,100);
    $C = mt_rand(1,100);
    $fio = $_GET['fio'] ?? '';
    $group = $_GET['group'] ?? '';
?>
<body>
    <div class="container">
        <h2>Математический тест</h2>
        <form method="post">
            <label>ФИО</label>
            <input type="text" name="FIO" value="<?= $fio ?>" required>
            <label>Группа</label>
            <input type="text" name="GROUP" value="<?= $group ?>" required>
            <label>A</label>
            <input type="text" name="A" value="<?= $A ?>">
            <label>B</label>
            <input type="text" name="B" value="<?= $B ?>">
            <label>C</label>
            <input type="text" name="C" value="<?= $C ?>">
            <label>Ваш ответ</label>
            <input type="text" name="user_result">
            <label>О себе</label>
            <textarea name="ABOUT"></textarea>
            <label>Задача</label>
            <select name="TASK">
                <option value="mean">Среднее арифметическое</option>
                <option value="perimeter">Периметр</option>
                <option value="area">Площадь треугольника</option>
                <option value="volume">Объем</option>
                <option value="max">Максимум</option>
                <option value="sum_sq">Сумма квадратов</option>
            </select>
            <div style="margin-bottom:10px;">
                <input type="checkbox" id="send_mail" name="send_mail" onclick="toggleMail()">
                <label for="send_mail">Отправить по email</label>
            </div>
            <div id="mail_block" style="display:none;">
                <label>Email</label>
                <input type="email" name="MAIL">
            </div>
            <label>Версия</label>
            <select name="VIEW">
                <option value="browser">Для браузера</option>
                <option value="print">Для печати</option>
            </select>
            <input type="submit" value="Проверить">
        </form>
    </div>
</body>
</html>
<?php } ?>