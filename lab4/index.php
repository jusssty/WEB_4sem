<?php
$cols = 3;
$tables = array(
    "A*B*C#D*E*F",
    "1*2*3#4*5*6",
    "X*Y*Z",
    "PHP*HTML*CSS#JS*SQL",
    "a*b*c#d*e",
    "q*w*e#r*t*y",
    "11*22*33",
    "яблоко*груша*слива",
    "red*green*blue",
    "one*two*three#four*five*six"
);

function getTR($data, $cols) {
    $cells = explode('*', $data);
    if (count($cells) == 0 || $data == '') return '';
    $row = "<tr>";
    for ($i = 0; $i < $cols; $i++) {
        if ($i < count($cells)) $row .= "<td>{$cells[$i]}</td>";
        else $row .= "<td></td>";
    }
    return $row . "</tr>";
}

function outTable($structure, $cols, $num) {
    if ($cols == 0) {
        echo "Неправильное число колонок<br>";
        return;
    }
    $rows = explode('#', $structure);
    if (count($rows) == 0) {
        echo "В таблице нет строк<br>";
        return;
    }
    $tableHTML = "";
    foreach ($rows as $row) {
        $tr = getTR($row, $cols);
        if ($tr != '') $tableHTML .= $tr;
    }
    if ($tableHTML == "") {
        echo "В таблице нет строк с ячейками<br>";
        return;
    }
    echo "<h2>Таблица №{$num}</h2>";
    echo "<table border='1'>{$tableHTML}</table>";
}

for ($i = 0; $i < count($tables); $i++) {
    outTable($tables[$i], $cols, $i + 1);
}
?>