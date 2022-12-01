<?php

include "dbconnect.php";
$login = "";
$pass = "";
$id = $_GET['id'];
$login = $_POST['login'];
$pass = $_POST['pass'];
$passHash = md5($pass);
$query = "SELECT device_login FROM device_table WHERE device_id = '$id' AND device_login = '$login' AND device_hash = '$passHash'";
$result = pg_query($link, $query);
$row = pg_fetch_row($result);
if ($pass != "" && $login != ""){

    if (is_countable($row) && count($row) > 0){
        //header('x-data: '.$id);
        //header('Location: status.php');
        RedirectWithMethodPost("./status.php?id=$id");

    }
    else{
        echo "<br> Неправильно введен пароль или логин от устройства";
    }
}else{
    echo "<br> Заполните все поля";
}

function RedirectWithMethodPost($dest){
    $url = $params = '';
    if( strpos($dest,'?') ) { list($url,$params) = explode('?',$dest,2); }
    else { $url = $dest; }
    echo "<form id='the-form' 
            method='post' 
            enctype='multipart/form-data' 
            action='$url'>\n";
    foreach( explode('&',$params) as $kv )
    {
        if( strpos($kv,'=') === false ) { continue; }
        list($k,$v) = explode('=',$kv,2);
        echo "<input type='hidden' name='$k' value='$v'>\n";
    }
    echo <<<ENDOFFORM
            <p id="the-button" style="display:none;">
            Click the button if page doesn't redirect within 3 seconds.
            <br><input type="submit" value="Click this button">
            </p>
            </form>
            <script type="text/javascript">
            function DisplayButton()
            {
            document.getElementById("the-button").style.display="block";
            }
            setTimeout(DisplayButton,3000);
            document.getElementById("the-form").submit();
            </script>
            ENDOFFORM;
}
?>