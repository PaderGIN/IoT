<!DOCTYPE HTML>
<html device_id="App_interface">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>IoT</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
</head>
<body>
    <h1 style="text-align: center; margin-bottom: 50px; margin-top: 30px;">Устройства</h1>
    <div style="display: flex; gap: 30px; flex-wrap: wrap; margin: 0 320px; justify-content: space-between">
        <?php
            include "db/dao.php";

            $devices = $dao -> get_all_devices();
            while ($device_row = pg_fetch_assoc($devices)) {

                $device_id = $device_row['device_id'];
                $device_row = $dao -> get_device($device_id);

                //Если в БД есть данные о имени для этого устройства
                if (pg_num_rows($device_row) == 1) 
                    $device_name = pg_fetch_array($device_row)['name'];
                else 
                    $device_name = '?';
            

                $temp_row = $dao -> get_temperature_device($device_id);
                if (pg_num_rows($temp_row) == 1) { 
                    //Если в БД есть данные о температуре для этого устройства
                    $temp_array = pg_fetch_array($temp_row);
                    $temperature = $temp_array['temperature'];
                    $temperature_dt = $temp_array['date_time'];
                } else { 
                    //Если в БД нет данных о температуре для этого устройства
                    $temperature = '?';
                    $temperature_dt = '?';
                }

                $out_state_row = $dao -> get_out_state_device($device_id);
                if (pg_num_rows($out_state_row) == 1) { 
                    //Если в БД есть данные о реле для этого устройства
                    $out_state_array = pg_fetch_array($out_state_row);
                    $out_state = $out_state_array['out_state'];
                    $out_state_dt = $out_state_array['date_time'];
                } else { 
                    //Если в БД нет данных о реле для этого устройства
                    $out_state = '?';
                    $out_state_dt = '?';
                }

                //------Проверяем данные, полученные от пользователя---------------------

                if (isset($_POST['button_on' . $device_id . ''])) {
                    $result_update = $dao -> update_out_state_device(1, $device_id);
                    $dao -> set_device_status($device_id, "1");

                    if (pg_affected_rows($result_update) != 1) {
                        //Если не смогли обновить - значит в таблице просто нет данных о команде для этого устройства
                        //вставляем в таблицу строчку с данными о команде для устройства
                        $dao -> set_out_state_device(1, $device_id);
                    }
                }

                if (isset($_POST['button_off' . $device_id . ''])) {
                    $result = $dao -> update_out_state_device(0, $device_id);
                    $dao -> set_device_status($device_id, 0);

                    if (pg_affected_rows($result) != 1) 
                        $dao -> set_out_state_device(0, $device_id);
                }

                $countDevice = pg_fetch_array($dao -> get_count_device_status($device_id, 5))['count'];
                echo '
                        <div style="padding-bottom: 50px; padding-left: 20px; display: flex; justify-content: space-between">        
                            <div style="padding: 10px; margin-right: 5px">
                            <table>
                                <tr>
                                    <td width=100px> Устройство:
                                    </td>
                                    <td width=40px>' . $device_name . '
                                    </td>
                                </tr>
                            </table>';
                if ($countDevice < 5) {
                    echo '<table border=1>
                        <tr>
                            <td width=100px> Tемпература
                            </td>
                            <td width=40px>' . $temperature . '
                            </td>
                            <td width=150px>' . $temperature_dt . '
                            </td>
                        </tr>
                        <tr>
                            <td width=100px> Реле
                            </td>
                            <td width=40px>' . $out_state . '
                            </td>
                            <td width=150px> ' . $out_state_dt . '
                            </td>
                        </tr>
                    </table>
                    
                            <form>
                                    <button formmethod=POST style="margin-top: 10px" class="btn btn-success" name=button_on' . $device_id . '  value=' . $device_id . ' >Включить реле</button>
                            </form>
                            <form>
                                    <button formmethod=POST style="margin-top: 10px" class="btn btn-danger" name=button_off' . $device_id . ' value=' . $device_id . ' >Выключить реле</button>
                            </form>
                            <form action="auth.php" method="post">
                                    <button formmethod=POST style="margin-top: 10px" class="btn btn-info" name="device_id" value=' . $device_id . ' >История управления устройством</button>
                            </form>
                        </div>
                    </div>
                ';
                } else {
                    echo "Количество обращений за последние пять минут превысело максимальное количество.<br> Устройство разблокируется позже.<br> ";
                    $resultCondition = $dao -> get_validation_time_from_table_status($device_id, 5);
                    echo 'Время последних изменений устройствa: ';
                    echo '<table border=1 style = "width: 150px">';
                    while ($rowCondition = pg_fetch_array($resultCondition)) {
                        echo '
                        <tr>
                            </td>
                            <td width=40px>' . $rowCondition['time'] . '
                            </td>
                        </tr>
                    ';
                    }
                }
            }
        ?>
    </div>
</body>
</html>