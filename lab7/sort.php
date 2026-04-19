<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Результат сортировки</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php
function arg_is_not_Num($arg) {
    $arg = trim($arg);
    if ($arg === '') return true;
    
    for ($i = 0; $i < strlen($arg); $i++) {
        $ch = $arg[$i];
        if ($i === 0 && $ch === '-') continue;
        if ($ch !== '0' && $ch !== '1' && $ch !== '2' && 
           $ch !== '3' && $ch !== '4' && $ch !== '5' && 
           $ch !== '6' && $ch !== '7' && $ch !== '8' && $ch !== '9') {
            return true; // встретился не цифровой символ
        }
    }
    return false;
}

$iteration_count = 0;

function printArrayState($arr, $iteration_num, $message = '') {
    echo '<div class="iteration">';
    echo '<span class="iteration-num">Итерация ' . $iteration_num . ':</span> ';
    foreach ($arr as $key => $value) echo '<div class="arr_element">' . $key . ': ' . $value . '</div>';
    if ($message) echo '<span style="margin-left: 10px;">' . $message . '</span>';
    echo '</div>';
}

function sort_by_choice(&$arr, &$iter_count) {
    $n = count($arr);
    printArrayState($arr, $iter_count++, 'Начало сортировки выбором');
    
    for ($i = 0; $i < $n - 1; $i++) {
        $min_idx = $i;
        for ($j = $i + 1; $j < $n; $j++) {
            if ($arr[$j] < $arr[$min_idx]) {
                $min_idx = $j;
            }
            printArrayState($arr, $iter_count++, 'Поиск минимального...');
        }
        
        if ($min_idx != $i) {
            $temp = $arr[$i];
            $arr[$i] = $arr[$min_idx];
            $arr[$min_idx] = $temp;
            printArrayState($arr, $iter_count++, 'Обмен: элемент ' . $i . ' с ' . $min_idx);
        }
    }
    printArrayState($arr, $iter_count++, 'Сортировка выбором завершена');
}

function sort_bubble(&$arr, &$iter_count) {
    $n = count($arr);
    printArrayState($arr, $iter_count++, 'Начало пузырьковой сортировки');
    
    for ($i = 0; $i < $n - 1; $i++) {
        for ($j = 0; $j < $n - $i - 1; $j++) {
            if ($arr[$j] > $arr[$j + 1]) {
                $temp = $arr[$j];
                $arr[$j] = $arr[$j + 1];
                $arr[$j + 1] = $temp;
                printArrayState($arr, $iter_count++, 'Обмен элементов ' . $j . ' и ' . ($j+1));
            } 
            else printArrayState($arr, $iter_count++, 'Сравнение ' . $j . ' и ' . ($j+1) . ' - без обмена');
        }
    }
    printArrayState($arr, $iter_count++, 'Пузырьковая сортировка завершена');
}

function sort_shell(&$arr, &$iter_count) {
    $n = count($arr);
    printArrayState($arr, $iter_count++, 'Начало сортировки Шелла');
    
    $gap = floor($n / 2);
    while ($gap >= 1) {
        printArrayState($arr, $iter_count++, 'Шаг = ' . $gap);
        for ($i = $gap; $i < $n; $i++) {
            $temp = $arr[$i];
            $j = $i;
            while ($j >= $gap && $arr[$j - $gap] > $temp) {
                $arr[$j] = $arr[$j - $gap];
                $j -= $gap;
                printArrayState($arr, $iter_count++, 'Сдвиг элемента');
            }
            $arr[$j] = $temp;
            printArrayState($arr, $iter_count++, 'Вставка элемента на позицию ' . $j);
        }
        $gap = floor($gap / 2);
    }
    printArrayState($arr, $iter_count++, 'Сортировка Шелла завершена');
}

function sort_gnome(&$arr, &$iter_count) {
    $n = count($arr);
    printArrayState($arr, $iter_count++, 'Начало сортировки гнома');
    
    $i = 1;
    while ($i < $n) {
        if ($i == 0 || $arr[$i - 1] <= $arr[$i]) {
            $i++;
            printArrayState($arr, $iter_count++, 'Шаг вперёд');
        } 
        else {
            $temp = $arr[$i];
            $arr[$i] = $arr[$i - 1];
            $arr[$i - 1] = $temp;
            $i--;
            printArrayState($arr, $iter_count++, 'Обмен, шаг назад');
        }
    }
    printArrayState($arr, $iter_count++, 'Сортировка гнома завершена');
}

$quick_iter_count = 0;

function quick_sort_recursive(&$arr, $left, $right, &$iter_count) {
    if ($left >= $right) return;
    
    $pivot = $arr[floor(($left + $right) / 2)];
    $i = $left;
    $j = $right;
    
    printArrayState($arr, $iter_count++, 'Разбиение: left=' . $left . ', right=' . $right . ', опора=' . $pivot);
    
    while ($i <= $j) {
        while ($arr[$i] < $pivot) $i++;
        while ($arr[$j] > $pivot) $j--;
        
        if ($i <= $j) {
            $temp = $arr[$i];
            $arr[$i] = $arr[$j];
            $arr[$j] = $temp;
            $i++;
            $j--;
            printArrayState($arr, $iter_count++, 'Обмен элементов');
        }
    }
    
    quick_sort_recursive($arr, $left, $j, $iter_count);
    quick_sort_recursive($arr, $i, $right, $iter_count);
}

function sort_quick(&$arr, &$iter_count) {
    printArrayState($arr, $iter_count++, 'Начало быстрой сортировки');
    quick_sort_recursive($arr, 0, count($arr) - 1, $iter_count);
    printArrayState($arr, $iter_count++, 'Быстрая сортировка завершена');
}

if (!isset($_POST['element0']) || !isset($_POST['arrLength'])) {
    echo '<div class="warning">Ошибка: Массив не задан, сортировка невозможна!</div>';
    exit();
}

$arrLength = (int)$_POST['arrLength'];
$algorithm = $_POST['algorithm'];

$algorithm_names = [
    'choice' => 'Сортировка выбором',
    'bubble' => 'Пузырьковый алгоритм',
    'shell' => 'Алгоритм Шелла',
    'gnome' => 'Алгоритм садового гнома',
    'quick' => 'Быстрая сортировка',
    'php_sort' => 'Встроенная функция PHP sort()'
];

echo '<h1>Результат сортировки</h1>';
echo '<h2>Алгоритм: ' . $algorithm_names[$algorithm] . '</h2>';

$input_array = [];
$invalid_elements = [];

for ($i = 0; $i < $arrLength; $i++) {
    $field_name = 'element' . $i;
    if (isset($_POST[$field_name])) {
        $value = trim($_POST[$field_name]);
        if (arg_is_not_Num($value) || $value === '') $invalid_elements[] = $i;
        $input_array[] = $value;
    }
}

echo '<h3>Входные данные:</h3>';
echo '<div>';
foreach ($input_array as $key => $value) echo '<div class="arr_element">' . $key . ': ' . htmlspecialchars($value) . '</div>';
echo '</div>';

if (empty($input_array)) {
    echo '<div class="warning">Ошибка: Входные данные отсутствуют!</div>';
    exit();
}

if (!empty($invalid_elements)) {
    echo '<div class="warning">Ошибка валидации! Следующие элементы не являются числами: ';
    echo implode(', ', $invalid_elements);
    echo '</div>';
    exit();
}

echo '<div class="success">Массив проверен, все элементы являются числами. Сортировка возможна.</div>';

$sort_array = array_map('intval', $input_array);
$iteration_count = 0;

$start_time = microtime(true);

switch ($algorithm) {
    case 'choice':
        sort_by_choice($sort_array, $iteration_count);
        break;
    case 'bubble':
        sort_bubble($sort_array, $iteration_count);
        break;
    case 'shell':
        sort_shell($sort_array, $iteration_count);
        break;
    case 'gnome':
        sort_gnome($sort_array, $iteration_count);
        break;
    case 'quick':
        sort_quick($sort_array, $iteration_count);
        break;
    case 'php_sort':
        printArrayState($sort_array, $iteration_count++, 'Начало встроенной сортировки');
        sort($sort_array);
        printArrayState($sort_array, $iteration_count++, 'Встроенная сортировка завершена');
        break;
}

$end_time = microtime(true);
$execution_time = $end_time - $start_time;

echo '<div class="success">';
echo 'Сортировка завершена, проведено ' . $iteration_count . ' итераций. ';
echo 'Сортировка заняла ' . number_format($execution_time, 6) . ' секунд.';
echo '</div>';

echo '<h3>Отсортированный массив:</h3>';
echo '<div>';
foreach ($sort_array as $key => $value) {
    echo '<div class="arr_element">' . $key . ': ' . $value . '</div>';
}
echo '</div>';

if ($algorithm != 'php_sort') {
    $test_array = array_map('intval', $input_array);
    $php_start = microtime(true);
    sort($test_array);
    $php_time = microtime(true) - $php_start;
    echo '<hr>';
    echo '<h3>Сравнение производительности:</h3>';
    echo '<div>Встроенная функция PHP sort() выполнила сортировку за ' . number_format($php_time, 6) . ' секунд.</div>';
    if ($execution_time < $php_time) echo '<div class="success">Ваш алгоритм сработал БЫСТРЕЕ встроенной функции!</div>';
    else echo '<div>Встроенная функция сработала БЫСТРЕЕ в ' . number_format($execution_time / $php_time, 2) . ' раз(а).</div>';
}
?>
</body>
</html>