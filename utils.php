<?php

class Utils {

    public static $hostname = "localhost";
    public static $dbname = "mobilesystem";
    public static $username = "root";
    public static $password = "";
    public static $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_PERSISTENT => true
    ];

    public static $conn = null; 

}
?>
