<!DOCTYPE HTML>
<html id="App_interface">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>MyApp</title>
    <a href="index.php"> Назад</a> <br>
</head>
<body>
    <?php
        include "db/dao.php";

        $device_id = $_POST['device_id'];
        $device_login = pg_fetch_array($dao -> get_device_login_by_id($device_id))['device_login'];
    ?>

    <form action="test.php?device_id=<?php echo $device_id ?>" method='post'>
        <p><b>Авторизация</b></p>

        <input type="text" maxlength="30" size="40" name="login" placeholder="Введите логин "
            value= <?php echo $device_login ?>><br>

        <input type="text" maxlength="30" size="40" name="pass" placeholder="Введите пароль"><br>

        <input type="submit" placeholder="Авторизоваться">
    </form>
</body>