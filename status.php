<!DOCTYPE HTML>
<html id="App_interface">
<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>MyApp</title>
<a href="index.php"> Назад</a>
</head>
    <body>
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
                    <tr>
                        <td width=100px> Устройство:
                        </td>
                            <td width=40px>' . $device_name . '
                        </td>
                    </tr>
                ';
                echo '<table border=1>';
                while ($rowName = pg_fetch_assoc($result)) {
                    echo '
                        <tr>
                            <td width=100px> Статус
                            </td>
                            <td width=40px>' . $rowName['status'] . '
                            </td>
                            <td width=150px>' . $rowName['time'] . '
                            </td>
                        </tr>
                    ';
                }
                echo '</table>';
            ?>