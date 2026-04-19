<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Таблица умножения</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php
    function outNumAsLink($x) {
        if ($x <= 9) return '<a href="?content='.$x.'">'.$x.'</a>';
        else return $x;
    }
    function outRow($n) {
        for ($i = 2; $i <= 9; $i++) echo outNumAsLink($n).' x '.outNumAsLink($i).' = '.outNumAsLink($n*$i).'<br>';
    }
    function outTableForm() {
        if (!isset($_GET['content'])) {
            echo '<table><tr>';
            for ($i = 2; $i <= 9; $i++) {
                echo '<td>';
                outRow($i);
                echo '</td>';
            }
        }
        else {
            echo '<table class="bigTable"><tr><td>';
            outRow($_GET['content']);
            echo '</td>';
        }
        echo '</tr></table>';
    }
    function outDivForm() {
        if (!isset($_GET['content'])) {
            for ($i = 2; $i <= 9; $i++) {
                echo '<div class="ttRow">';
                outRow($i);
                echo '</div>';
            }
        }
        else {
            echo '<div class="ttSingleRow">';
            outRow($_GET['content']);
            echo '</div>';
        }
    }
    ?>
    <div id="main_menu">
        <?php
        echo '<a href="?html_type=TABLE';
        if (isset($_GET['content'])) echo '&content='.$_GET['content'];
        echo '"';
        if (isset($_GET['html_type']) && $_GET['html_type']=='TABLE') echo ' class="selected"';
        echo '>Табличная верстка</a>';
        echo '<a href="?html_type=DIV';
        if (isset($_GET['content'])) echo '&content='.$_GET['content'];
        echo '"';
        if (isset($_GET['html_type']) && $_GET['html_type']=='DIV') echo ' class="selected"';
        echo '>Блочная верстка</a>';
        ?>
    </div>
    <hr>
    <div id="side_menu">
        <?php
        $link = '';
        if (isset($_GET['html_type'])) $link = '?html_type='.$_GET['html_type'].'&';
        else $link = '?';
        echo '<a href="'.$link.'"';
        if (!isset($_GET['content'])) echo ' class="selected"';
        echo '>Вся таблица</a>';
        for ($i = 2; $i <= 9; $i++) {
            echo '<a href="'.$link.'content='.$i.'"';
            if (isset($_GET['content']) && $_GET['content']==$i) echo ' class="selected"';
            echo '>На '.$i.'</a>';
        }
        ?>
    </div>
    <div id="content">
        <?php
        if (!isset($_GET['html_type']) || $_GET['html_type']=='TABLE') outTableForm();
        else outDivForm();
        ?>
    </div>
    <div style="clear:both;"></div>
    <hr>
    <footer>
        <?php
        if (!isset($_GET['html_type']) || $_GET['html_type']=='TABLE') $s = 'Табличная верстка. ';
        else $s = 'Блочная верстка. ';
        if (!isset($_GET['content'])) $s .= 'Вся таблица. ';
        else $s .= 'Таблица на '.$_GET['content'].'. ';
        date_default_timezone_set('Europe/Moscow');
        echo $s.date('d.m.Y H:i:s');
        ?>
    </footer>
</body>
</html>