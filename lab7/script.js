function setHTML(element, txt) {
    if(element.innerHTML !== undefined) element.innerHTML = txt;
    else {
        var range = document.createRange();
        range.selectNodeContents(element);
        range.deleteContents();
        var fragment = range.createContextualFragment(txt);
        element.appendChild(fragment);
    }
}

// Функция добавления одного элемента
function addElement(table_name) {
    var t = document.getElementById(table_name);
    var index = t.rows.length;  // индекс новой строки
    var row = t.insertRow(index);
    var cel1 = row.insertCell(0);
    var cel2 = row.insertCell(1);
    cel1.className = 'element_index';
    cel2.className = 'element_row';
    setHTML(cel1, (index + 1) + '.'); // Формируем содержимое ячейки с номером элемента
    setHTML(cel2, '<input type="text" name="element' + index + '">'); // Формируем поле ввода с уникальным именем elementX
    document.getElementById('arrLength').value = t.rows.length; // Обновляем скрытое поле с количеством элементов
}

function submitForm() {
    document.getElementById('sortForm').submit();
}