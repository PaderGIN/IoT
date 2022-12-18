<?php
include "db/connection.php";

class DAO {
    private $link;

    function __construct($link) {
        $this->link = $link;
    }

    function get_device($device_id) {
        $query = "SELECT * FROM DEVICE_TABLE WHERE DEVICE_ID='".$device_id."'";
        $result = pg_query($this->link, $query);
        return $result;
    }

    function get_all_devices() {
        $query = "SELECT * FROM DEVICE_TABLE";
        $result = pg_query($this->link, $query);
        return $result;
    }

    function get_out_state_device($device_id) {
        $query = "SELECT * FROM OUT_STATE_TABLE WHERE DEVICE_ID = '".$device_id."'";
        $result = pg_query($this->link, $query);
        return $result;
    }

    function update_out_state_device($rele, $device_id) {
        $date_today = date("Y-m-d H:i:s");
        $query = "UPDATE OUT_STATE_TABLE SET OUT_STATE='".$rele."', DATE_TIME='". $date_today . "' WHERE DEVICE_ID = '".$device_id."'";
        $result = pg_query($this->link, $query);
        return $result;
    }

    function set_out_state_device($rele, $device_id) {
        $date_today = date("Y-m-d H:i:s");
        $query = "INSERT OUT_STATE_TABLE (DEVICE_ID, OUT_STATE, DATE_TIME) VALUES ('".$device_id."', '".$rele."', '".$date_today."')";
        $result = pg_query($this->link, $query);
        return $result;
    }

    function get_temperature_device($device_id) {
        $query = "SELECT * FROM TEMPERATURE_TABLE WHERE DEVICE_ID = '".$device_id."'";
        $result = pg_query($this->link, $query);
        return $result;
    }

    function update_temperature_device($temperature, $device_id) {
        $date_today = date("Y-m-d H:i:s");
        $query = "UPDATE TEMPERATURE_TABLE SET TEMPERATURE='".$temperature."', DATE_TIME='".$date_today."' WHERE DEVICE_ID = '".$device_id."'";
        $result = pg_query($this->link, $query);
        return $result;
    }

    function set_temperature_device($temperature, $device_id) {
        $date_today = date("Y-m-d H:i:s");
        $query = "INSERT TEMPERATURE_TABLE (DEVICE_ID, TEMPERATURE, DATE_TIME) VALUES ('".$device_id."', '".$temperature."', '".$date_today."')";
        $result = pg_query($this->link, $query);
        return $result;
    }

    function get_command_device($device_id) {
        $query = "SELECT * FROM COMMAND_TABLE WHERE DEVICE_ID = '".$device_id."'";
        $result = pg_query($this->link, $query);
        return $result;
    }

    function set_device_status($device_id, $status){
        $date_today = date("Y-m-d H:i:s");
        $query = "INSERT INTO table_status (id_device, status, time) VALUES ($device_id, '$status', '$date_today')";
        $result = pg_query($this->link, $query);
        return $result;
    }

    function get_count_device_status($device_id, $mins){
        $query = "SELECT COUNT(*) AS count FROM table_status WHERE time > (now() - make_interval(mins => 5)) AND id_device = '$device_id';";
        $result = pg_query($this->link, $query);
        return $result;
    }

    function get_validation_time_from_table_status($device_id, $mins){
        $query = "SELECT time FROM table_status 
        WHERE time > (now() - make_interval(mins => $mins))  AND id_device = '$device_id';";;
        $result = pg_query($this->link, $query);
        return $result;
    }

    function get_device_login($device_id, $device_login, $password){
        $query = "SELECT device_login FROM device_table WHERE device_id = '$device_id' AND device_login = '$device_login' AND device_hash = '$password'";
        $result = pg_query($this->link, $query);
        return $result;
    }

    function get_device_login_by_id($device_id){
        $query = "SELECT device_login FROM device_table WHERE device_id = '$device_id'";
        $result = pg_query($this->link, $query);
        return $result;
    }

    function get_table_status_by_device_id($device_id){
        $query = "SELECT * FROM table_status WHERE id_device = '$device_id'";
        $result = pg_query($this->link, $query);
        return $result;
    }


}

$dao = new DAO($link);

?>