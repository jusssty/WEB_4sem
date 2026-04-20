<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Результат анализа текста</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
<?php
function formatSpecialChar($ch) {
    switch($ch) {
        case ' ':
            return 'ПРОБЕЛ';
        case "\n":
            return 'НОВАЯ СТРОКА';
        case "\r":
            return 'ВОЗВРАТ КАРЕТКИ';
        case "\t":
            return 'ТАБУЛЯЦИЯ';
        default:
            return $ch;
    }
}

function countPunctuation($text) {
    $punctuation = array(
        '.' => true, ',' => true, '!' => true, '?' => true,
        ';' => true, ':' => true, '-' => true, '(' => true,
        ')' => true, '"' => true, '\'' => true
    );
    $count = 0;
    for ($i = 0; $i < strlen($text); $i++) {
        if (isset($punctuation[$text[$i]])) {
            $count++;
        }
    }
    return $count;
}

function countLetters($text) {
    $letters = 0;
    $upper = 0;
    $lower = 0;
    for ($i = 0; $i < strlen($text); $i++) {
        $ch = $text[$i];
        // русские буквы (192-255)
        $ord = ord($ch);
        
        // А-Я (192-223)
        if ($ord >= 192 && $ord <= 223) {
            $letters++;
            $upper++;
        } 
        // а-я (224-255) кроме ё
        elseif ($ord >= 224 && $ord <= 255) {
            $letters++;
            $lower++;
        }
        // A-Z (65-90)
        elseif ($ord >= 65 && $ord <= 90) {
            $letters++;
            $upper++;
        }
        // a-z (97-122)
        elseif ($ord >= 97 && $ord <= 122) {
            $letters++;
            $lower++;
        }
        // ё 184
        elseif ($ord == 184) {
            $letters++;
            $lower++;
        }
        // Ё 168
        elseif ($ord == 168) {
            $letters++;
            $upper++;
        }
    }
    return [$letters, $upper, $lower];
}

function countDigits($text) {
    $digits = array('0'=>true,'1'=>true,'2'=>true,'3'=>true,'4'=>true,
                    '5'=>true,'6'=>true,'7'=>true,'8'=>true,'9'=>true);
    $count = 0;
    for ($i = 0; $i < strlen($text); $i++) {
        if (isset($digits[$text[$i]])) $count++;
    }
    return $count;
}

function countWords($text) {
    $words = array();
    $word = '';
    for ($i = 0; $i < strlen($text); $i++) {
        $ch = $text[$i];
        $ord = ord($ch);
        $isLetter = ($ord >= 65 && $ord <= 90) ||   // A-Z
                    ($ord >= 97 && $ord <= 122) ||  // a-z
                    ($ord >= 192 && $ord <= 255) || // русские буквы
                    ($ord == 168) || ($ord == 184);  // Ё и ё
        
        $isDigit = ($ord >= 48 && $ord <= 57); // 0-9
        
        if ($isLetter || $isDigit) $word .= $ch;
        elseif ($word !== '') {
            $wordLower = mb_strtolower($word, 'CP1251');
            $words[$wordLower] = isset($words[$wordLower]) ? $words[$wordLower] + 1 : 1;
            $word = '';
        }
    }
    if ($word !== '') {
        $wordLower = mb_strtolower($word, 'CP1251');
        $words[$wordLower] = isset($words[$wordLower]) ? $words[$wordLower] + 1 : 1;
    }
    return $words;
}

function countChars($text) {
    $chars = array();
    $textLower = mb_strtolower($text, 'CP1251');
    $len = strlen($textLower);
    for ($i = 0; $i < $len; $i++) {
        $ch = $textLower[$i];
        $chars[$ch] = isset($chars[$ch]) ? $chars[$ch] + 1 : 1;
    }
    return $chars;
}

function test_it($text_cp1251) {
    $text_utf8 = iconv("cp1251", "utf-8//IGNORE", $text_cp1251);
    echo '<div class="source-text">Исходный текст: ' . nl2br(htmlspecialchars($text_utf8)) . '</div><br>';
    $len = mb_strlen($text_utf8, 'UTF-8');
    echo "Количество символов (включая пробелы): $len<br>";
    list($letters, $upper, $lower) = countLetters($text_cp1251);
    echo "Количество букв: $letters<br>";
    echo "Заглавных букв: $upper<br>";
    echo "Строчных букв: $lower<br>";
    $punctuation = countPunctuation($text_cp1251);
    echo "Количество знаков препинания: $punctuation<br>";
    $digits = countDigits($text_cp1251);
    echo "Количество цифр: $digits<br>";
    $words = countWords($text_cp1251);
    $totalWords = array_sum($words);
    echo "Количество слов: $totalWords<br><br>";
    echo "<h3>Количество вхождений каждого символа (без учёта регистра):</h3>";
    $chars = countChars($text_cp1251);
    $counter = 0;
    $colsPerRow = 15;
    echo "<table class='symbol-table'>";
    foreach ($chars as $ch_cp1251 => $cnt) {
        if ($counter % $colsPerRow == 0) {
            if ($counter > 0) echo "</tr>";
            echo "<tr>";
        }
        $ch_utf8 = iconv("cp1251", "utf-8//IGNORE", $ch_cp1251);
        $displayChar = formatSpecialChar($ch_utf8);
        $specialClass = ($ch_cp1251 == ' ' || $ch_cp1251 == "\n" || $ch_cp1251 == "\r" || $ch_cp1251 == "\t") ? "special-symbol" : "";
        echo "<td class='$specialClass'><strong>" . htmlspecialchars($displayChar) . "</strong><br>" . $cnt . "</td>";
        $counter++;
    }
    if ($counter % $colsPerRow != 0) echo "</tr>";
    echo "</table><br>";
    echo "<h3>Список слов и количество их вхождений (по алфавиту):</h3>";
    ksort($words);
    echo "<table>";
    foreach ($words as $word => $cnt) {
        $word_utf8 = iconv("cp1251", "utf-8//IGNORE", $word);
        echo "<tr><td>" . htmlspecialchars($word_utf8) . "</td><td>$cnt</td></tr>";
    }
    echo "</table>";
}

if (isset($_POST['data']) && trim($_POST['data']) !== '') {
    $text_utf8 = $_POST['data'];
    $text_cp1251 = iconv("utf-8", "cp1251//IGNORE", $text_utf8);
    test_it($text_cp1251);
} 
else echo '<div class="error">Нет текста для анализа</div>';
?>
<br>
<a href="index.html">Другой анализ</a>

</body>
</html>