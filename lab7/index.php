<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Сортировка массивов</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js"></script>
</head>
<body>
    <h1>Сортировка массива</h1>
    <form id="sortForm" action="sort.php" method="POST" target="_blank">
        <table id="elements">
            <tr>
                <td class="element_index">1.</td>
                <td class="element_row"><input type="text" name="element0"></td>
            </tr>
        </table>
        <input type="hidden" id="arrLength" name="arrLength" value="1">
        <label>Выберите алгоритм сортировки:</label>
        <select name="algorithm">
            <option value="choice">Сортировка выбором</option>
            <option value="bubble">Пузырьковый алгоритм</option>
            <option value="shell">Алгоритм Шелла</option>
            <option value="gnome">Алгоритм садового гнома</option>
            <option value="quick">Быстрая сортировка</option>
            <option value="php_sort">Встроенная функция PHP sort()</option>
        </select>
        <br>
        <input type="button" value="Добавить еще один элемент" onclick="addElement('elements');">
        <input type="button" value="Сортировать массив" onclick="submitForm();">
    </form>
</body>
</html>