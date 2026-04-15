<?php $title = "Звягинцев А.М. 241-353 - ЛР №1 Главная"; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
    <?php $name='Главная'; $link='index.php'; $current_page=false; ?>
    <a href="<?php echo $link; ?>" <?php if($current_page) echo 'class="selected_menu"'; ?>><?php echo $name; ?></a>
    <?php $name='Страница 2'; $link='page2.php'; $current_page=true; ?>
    <a href="<?php echo $link; ?>" <?php if($current_page) echo 'class="selected_menu"'; ?>><?php echo $name; ?></a>
    <?php $name='Страница 3'; $link='page3.php'; $current_page=false; ?>
    <a href="<?php echo $link; ?>" <?php if($current_page) echo 'class="selected_menu"'; ?>><?php echo $name; ?></a>
</header>

<main>
    <h1>Страница 2</h1>
    <h2>Раздел 1</h2>
    <p> Итак, в заключение скажу, что фортуна непостоянна, а человек упорствует в своем образе действий, поэтому, пока между ними согласие,  человек пребывает в благополучии, когда же наступает разлад, благополучию его приходит  конец.  И все-таки я полагаю,  что натиск лучше, чем осторожность, ибо фортуна -- женщина, и кто хочет с ней сладить, должен колотить ее и пинать-таким она поддается скорее,  чем тем,  кто холодно берется за  дело. Поэтому она, как женщина,-- подруга молодых, ибо они не так осмотрительны,  более отважны и с большей дерзостью ее укрощают.
    </p>

    <h2>Раздел 2</h2>
    <p> Этим натиском  и внезапностью папа Юлий достиг то го, чего не досгиг бы со всем доступным человеку благоразумием никакой другой глава Церкви;  ибо, останься он в Риме,  выжидая,  пока все уладится и образуется,  как сделал бы всякий на его месте,  король Франции нашел бы тысячу отговорок, а все другие -- тысячу доводов против захвата.</p>

    <table border="1">
        <?php echo "<tr><th>A</th><th>B</th><th>C</th></tr>"; ?>
        <tr>
        <td><?php echo 1; ?></td>
        <td><?php echo 2; ?></td>
        <td><?php echo 3; ?></td>
        </tr>
    </table>

     <?php echo '<img src="pics/pic'.(date('s') % 2+1).'.jpg" alt="Меняющаяся фотография">'; ?>
    <img src="pics/pic1.jpg">
</main>

<footer>
    <?php date_default_timezone_set('Europe/Moscow'); echo "Сформировано ".date('d.m.Y')." в ".date('H:i:s'); ?>
</footer>
</body>
</html>