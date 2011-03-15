<?php

// Панель администратора.
// Главная панель представляет собой типичную админскую панель с категориями.

// К админке имеют доступ только специальные пользователи: операторы и админы.

// Категории админки (GET параметр mode). К некоторым категориям операторы не могут получить доступ.
// - Контроль полётов (все)
// - История переходов (только админ)
// - Жалобы (все)
// - Баны (все)
// - Пользователи (операторы могут только смотреть и часть изменять (например отключать проверку IP), админ может изменять)
// - Планеты (операторы могут только смотреть и часть изменять (например названия планет), админ может изменять)
// - Задания (только админ)
// - Настройки Вселенной (только админ)
// - Ошибки (только админ)

if (CheckSession ( $_GET['session'] ) == FALSE) die ();
if ( $GlobalUser['admin'] == 0 ) RedirectHome ();    // обычным пользователям доступ запрещен
$session = $_GET['session'];
$mode = $_GET['mode'];

// ========================================================================================
// Главная страница.

function Admin_Home ()
{
    global $session;
?>
    <table width=100% border="0" cellpadding="0" cellspacing="1" align="top" class="s">
    <tr>
    <th><a href="index.php?page=admin&session=<?=$session;?>&mode=Fleetlogs"><img src="img/admin_fleetlogs.png"><br>Контроль полётов</a></th>
    <th><a href="index.php?page=admin&session=<?=$session;?>&mode=Browse"><img src="img/admin_browse.png"><br>История переходов</a></th>
    <th><a href="index.php?page=admin&session=<?=$session;?>&mode=Reports"><img src="img/admin_report.png"><br>Жалобы</a></th>
    <th><a href="index.php?page=admin&session=<?=$session;?>&mode=Bans"><img src="img/admin_ban.png"><br>Баны</a></th>
    <th><a href="index.php?page=admin&session=<?=$session;?>&mode=Users"><img src="img/admin_users.png"><br>Пользователи</a></th>
    </tr>
    <tr>
    <th><a href="index.php?page=admin&session=<?=$session;?>&mode=Planets"><img src="img/admin_planets.png"><br>Планеты</a></th>
    <th><a href="index.php?page=admin&session=<?=$session;?>&mode=Queue"><img src="img/admin_queue.png"><br>Задания</a></th>
    <th><a href="index.php?page=admin&session=<?=$session;?>&mode=Uni"><img src="img/admin_uni.png"><br>Настройки Вселенной</a></th>
    <th><a href="index.php?page=admin&session=<?=$session;?>&mode=Errors"><img src="img/admin_error.png"><br>Ошибки</a></th>
    <th><a href="index.php?page=admin&session=<?=$session;?>&mode=Debug"><img src="img/admin_debug.png"><br>Отладочные сообщения</a></th>
    </tr>
    </table>
<?php
}

// ========================================================================================
// Глобальная очередь событий.

function Admin_Queue ()
{
    global $session;
    global $db_prefix;
    $query = "SELECT * FROM ".$db_prefix."queue ORDER BY end ASC";
    $result = dbquery ($query);

    $rows = dbrows ($result);
    while ($rows--) 
    {
        $queue = dbarray ( $result );
        print_r ($queue);
        echo "<br>";
    }
}

// ========================================================================================
// Настройки Вселенной.

function Admin_Uni ()
{
    global $session;
    $unitab = LoadUniverse ();

    print_r ($unitab);

    echo "<table >\n";
    echo "<form action=\"index.php?page=admin&session=$session&mode=Uni\" method=\"POST\" >\n";
    echo "<tr><td class=c colspan=2>Настройки Вселенной ".$unitab['num']."</td></tr>\n";
    echo "<tr><th>Дата открытия</th><th>".date ("Y-m-d H:i:s", $unitab['startdate'])."</th></tr>\n";
    echo "<tr><th>Количество игроков</th><th>".$unitab['usercount']."</th></tr>\n";
    echo "<tr><th>Максимальное количество игроков</th><th><input type=\"text\" name=\"maxusers\" maxlength=\"10\" size=\"10\" value=\"".$unitab['maxusers']."\" /></th></tr>\n";
    echo "<tr><th>Количество галактик</th><th>".$unitab['galaxies']."</th></tr>\n";
    echo "<tr><th>Количество систем в галактике</th><th>".$unitab['systems']."</th></tr>\n";
    echo "<tr><th>Скорострел</th><th><input type=\"checkbox\" name=\"rapid\"  checked=checked /></th></tr>\n";
    echo "<tr><th>Луны и Звёзды Смерти</th><th><input type=\"checkbox\" name=\"moons\"  checked=checked /></th></tr>\n";
    echo "<tr><th colspan=2><input type=\"submit\" value=\"Сохранить\" /></th></tr>\n";
    echo "</form>\n";
    echo "</table>\n";
}

// ========================================================================================
// Ошибки.

function Admin_Errors ()
{
    global $session;
    global $db_prefix;
    $query = "SELECT * FROM ".$db_prefix."errors ORDER BY date DESC";
    $result = dbquery ($query);

    $rows = dbrows ($result);
    while ($rows--) 
    {
        $error = dbarray ( $result );
        print_r ($error);
        echo "<br>";
    }
}

// ========================================================================================
// Отладочные сообщения.

function Admin_Debug ()
{
    global $session;
    global $db_prefix;
    $query = "SELECT * FROM ".$db_prefix."debug ORDER BY date DESC";
    $result = dbquery ($query);

    $rows = dbrows ($result);
    while ($rows--) 
    {
        $msg = dbarray ( $result );
        print_r ($msg);
        echo "<br>";
    }
}

// ========================================================================================

PageHeader ("admin", true);

echo "<!-- CONTENT AREA -->\n";
echo "<div id='content'>\n";
echo "<center>\n";
echo "<table width=\"750\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\">\n\n";

if ( $mode === "Home" ) Admin_Home ();
else if ( $mode === "Queue" ) Admin_Queue ();
else if ( $mode === "Uni" ) Admin_Uni ();
else if ( $mode === "Errors" ) Admin_Errors ();
else if ( $mode === "Debug" ) Admin_Debug ();
else Admin_Home ();

echo "</table>\n";
echo "<br><br><br><br>\n";
echo "</center>\n";
echo "</div>\n";
echo "<!-- END CONTENT AREA -->\n";

PageFooter ("", "", false, 81);
ob_end_flush ();
?>