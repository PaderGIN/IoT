<!DOCTYPE HTML>
<html id="App_interface">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Device status</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
    <body>
    <div>
            <?php
                include "dbconnect.php";
                $id = $_POST['id'];
                $queryCount = "SELECT device_id from device_table;";
                $resultCount = pg_query($link, $queryCount);
                $rowName = pg_fetch_array($resultCount);
                //-----------------Получаем из БД все данные об устройстве-------------------
                $query = "SELECT * from device_table WHERE device_id=$id";
                $result = pg_query($link, $query);

                if (pg_num_rows($result) == 1) { //Если в БД есть данные о имени для этого устройства
                    $Arr = pg_fetch_array($result);
                    $device_name = $Arr['name'];
                } else { //Если в БД нет данных о имени для этого устройства
                    $device_name = '?';
                }

                $query = "SELECT * FROM table_status WHERE id_device = $id";
                $result = pg_query($link, $query);

                echo '
                <div style="display: flex; justify-content: center; margin-top: 25px;">
                    <a class="btn btn-primary" style="margin-right: 20px; height: 85%; margin-top: 11px;" href="index.php"> Назад</a>
                    <h1 style="text-align: center"> Устройство: ' . $device_name . '</h1>
                </div>';

                echo '<div style="display: flex; flex-direction: column; gap: 15px; align-items: center; margin-top: 20px;">';
                while ($rowName = pg_fetch_assoc($result)) {
                    echo '
                        <div style="display: flex; gap: 7px">
                            <div> Статус</div>
                            <div>' . $rowName['status'] . '</div>
                            <div>' . $rowName['time'] . '</div>
                        </div>
                    ';
                }
                echo '</table>';
            ?>
        </div>
    </body>
</html>
