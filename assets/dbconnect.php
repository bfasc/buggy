<?php
function db_connect() {
    $config = parse_ini_file('assets/config.ini');
    try {
        $connection =  new PDO("mysql:host=" . $config['servername'] . ";dbname=" . $config['dbname'], $config['username'], $config['password']);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connection;
    } catch (PDOException $exc){
        echo '<pre>';
        print_r($exc);
        echo '</pre>';
    }
}

?>
