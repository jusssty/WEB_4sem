<?php
if (!isset($_GET['store'])) $_GET['store'] = '';
if (!isset($_GET['count'])) $_GET['count'] = 0;
if (isset($_GET['key'])) {
    if ($_GET['key'] == 'reset') $_GET['store'] = '';
    else $_GET['store'] .= $_GET['key'];
    $_GET['count']++;
}
$store = $_GET['store'];
$count = $_GET['count'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Виртуальная клавиатура</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="result">
        <?php echo $store; ?>
    </div>
    <div class="keyboard">
        <?php
        for ($i = 1; $i <= 9; $i++) {
            echo '<a class="btn" href="?key='.$i.'&store='.$store.'&count='.$count.'">'.$i.'</a>';
            if ($i % 3 == 0) echo '<br>';
        }
        ?>
        <a class="btn" href="?key=0&store=<?php echo $store; ?>&count=<?php echo $count; ?>">0</a>
    </div>
    <a class="reset" href="?key=reset&count=<?php echo $count ?>">СБРОС</a>
    <div class="footer">
        Количество нажатий: <?php echo $count; ?>
    </div>
</body>
</html> 