<?php
include "dbconnect.php";
$login = "";
$pass = "";

$login = $_POST['login'];
$pass = $_POST['pass'];
$passHash = md5($pass);
$query = "SELECT DEVIСE_LOGIN FROM `DEVICE_TABLE` WHERE DEVIСE_LOGIN = '$login' AND DEVICE_HASH = '$passHash'";
$result = mysqli_query($conn, $query);

if ($pass != "" && $login != ""){
    while($row = mysqli_fetch_assoc($result)){


        if (count($row) == 0){
            echo '1';
            echo "<br> <div class = 'error'> Неправильно введен пароль или логин от устройства</div>";
        }
        else{
            echo '2';
            header('Location: status.php');
            echo 'вы авторизованы';
        }
        echo '3';
    }
}else{
    echo "<br> <div class = 'error'>Заполните все поля</div>";
}
?>