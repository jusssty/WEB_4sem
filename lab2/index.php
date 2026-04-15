<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Звягинцев А. М., группа 241-353, ЛР№2</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
    <img src="logo.png" alt="Логотип" class="logo">
    <h1>Звягинцев Артемий Максимович</h1>
    <h2>Группа: 241-353</h2>
    <h3>Лабораторная работа №2</h3>
</header>

<main>
<?php
$x = -5;
$encounting = 25;
$step = 1;
$type = 'A';
$min_value = -100000;
$max_value = 100000;
$values = [];
$i = 0;

switch ($type) {
    case 'B': echo "<ul>"; break;
    case 'C': echo "<ol>"; break;
    case 'D':
        echo "<table border='1'>
        <tr><th>#</th><th>x</th><th>f(x)</th></tr>";
        break;
    case 'E': echo "<div class='flex'>"; break;
}
for ($i = 0; $i < $encounting; $i++, $x += $step) {
    if ($x <= 10) {
        if ($x - 5 == 0) $f = "error";
        else $f = 6 / ($x - 5) * $x - 5;
    }
    elseif ($x < 20) $f = ($x * $x - 1) * $x + 7;
    else $f = 4 * $x + 5;
    if ($f !== "error") {
        $f = round($f, 3);
        $values[] = $f;
    }
    if ($f !== "error" && ($f >= $max_value || $f <= $min_value)) break;
    switch ($type) {
        case 'A': echo "f($x)=$f<br>"; break;
        case 'B':
        case 'C': echo "<li>f($x)=$f</li>"; break;
        case 'D': echo "<tr><td>".($i+1)."</td><td>$x</td><td>$f</td></tr>"; break;
        case 'E': echo "<div class='box'>f($x)=$f</div>"; break;
    }
}
switch ($type) {
    case 'B': echo "</ul>"; break;
    case 'C': echo "</ol>"; break;
    case 'D': echo "</table>"; break;
    case 'E': echo "</div>"; break;
}
if (count($values) > 0) {
    $sum = array_sum($values);
    $avg = round($sum / count($values), 3);
    $min = min($values);
    $max = max($values);
    echo "<p>Сумма: $sum</p>";
    echo "<p>Среднее: $avg</p>";
    echo "<p>Минимум: $min</p>";
    echo "<p>Максимум: $max</p>";
}
?>
</main>

<footer>
    Тип верстки: <?php echo $type; ?>
</footer>

</body>
</html>