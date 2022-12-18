<?php
//Настройки подключения к БД
include "db/dao.php";


if(isset($_GET["ID"])){ 
    //Если запрос от устройства содержит идентификатор
    $device = $dao -> get_device($_GET['ID']);

    if(pg_num_rows($device) == 1){ 
        //Если найдено устройство с таким ID в БД

        if(isset($_GET['Rele'])) { 
            //Если устройство передало новое состояние реле
            //проверяем есть ли в БД предыдущее значение этого параметра
            $uot_state_device = $dao -> get_out_state_device($_GET['ID']);

            if(pg_num_rows($uot_state_device) == 1){ 
                //Если в таблице есть данные для этого устройства - обновляем
                $dao -> update_out_state_device($_GET['Rele'], $_GET['ID']);
            } else { 
                //Если данных для такого устройства нет - добавляем
                $dao -> set_out_state_device($_GET['Rele'], $_GET['ID']);
            }
        }

        if(isset($_GET['Term'])) { 
            //Если устройство передало новое значение температуры
            //проверяем есть ли в БД предыдущее значение этого параметра
            $temperature_device = $dao -> get_temperature_device($_GET['ID']);
            if(pg_num_rows($temperature_device) == 1){ 
                //Если в таблице есть данные для этого устройства - обновляем
                $dao -> update_temperature_device($_GET['Term'], $_GET['ID']);
            } else { 
                //Если данных для этого устройства нет - добавляем
                $dao -> set_temperature_device($_GET['Term'], $_GET['ID']);
            }
        }

        //Достаём из БД текущую команду управления реле
        $command_device = $dao -> get_command_device($_GET['ID']);
        if(pg_num_rows($command_device) == 1){ 
            //Если в таблице есть данные для этого устройства
            $Arr = pg_fetch_array($command_device);
            $command = $Arr['COMMAND'];
        }

        //Отвечаем на запрос текущей командой
        if($command != -1) 
            echo "COMMAND $command EOC";
        else 
            echo "COMMAND ? EOC";
    }
}

?>