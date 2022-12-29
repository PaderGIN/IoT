<!DOCTYPE HTML>
<html id="App_interface">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>MyApp</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <?php
        include "db/dao.php";

        $device_id = $_POST['device_id'];
        $device_login = pg_fetch_array($dao -> get_device_login_by_id($device_id))['device_login'];
    ?>

    <div class="container">
        <div class="row">
            <div class="col-md-offset-3 col-md-6">
                <form class="form-horizontal" action="auth.php?device_id=<?php echo $device_id ?>" method='post'>
                    <span class="heading">АВТОРИЗАЦИЯ</span>
                    <div class="form-group">
                        <input type="text" name="login" class="form-control" placeholder="Введите логин" 
                            value= <?php echo $device_login ?>>
                        <i class="fa fa-user"></i>
                    </div>
                    <div class="form-group help">
                        <input type="password" name="pass" class="form-control" placeholder="Введите пароль">
                        <i class="fa fa-lock"></i>
                        <a href="#" class="fa fa-question-circle"></a>
                    </div>
                    <div class="form-group" style='display: flex; justify-content: space-around;'>
                        <a href="index.php" class="btn btn-default">Назад</a>
                        <button type="submit" class="btn btn-default">ВХОД</button>
                    </div>
                </form>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container -->
</body>