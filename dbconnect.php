<?php

//Настройки подключения к БД
$db_host = 'mihey83.ru';
$db_user = 'kis'; //имя пользователя совпадает с именем БД
$db_password = 'kis211-362kis211-362'; //пароль, указаный при создании БД
$database = 'iot'; //имя БД, которое было указано при создании
$link = pg_connect("host=$db_host port=5432 user=$db_user password=$db_password dbname=$database");
if ($link == False) {
    die("Cannot connect DB");
}
pg_query($connect, "set search_path = 'IoT'");
?>
