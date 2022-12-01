<!DOCTYPE HTML>
<html id="App_interface">
<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>MyApp</title>
    <a href="index.php"> Назад</a> <br>
</head>
<body>
<?php
require "dbconnect.php";
$id = $_POST['id'];
$query = "SELECT device_login FROM device_table WHERE device_id = '$id';";
$result = pg_query($conn, $query);
$row = pg_fetch_array($result);
?>

<form action = 'test.php' method = 'post'>
    <p><b>Авторизация</b></p>

    <input type="text" maxlength="30" size="40" name="login" placeholder="Введите логин " value = <?php echo $row['DEVIСE_LOGIN'] ?>><br>

    <input type="text" maxlength="30" size="40" name="pass" placeholder="Введите пароль" ><br>

    <input type="submit" placeholder="Авторизоваться">
</form>




</body>