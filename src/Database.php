<?php

class Database
{
    private string $configFile = 'config.ini';

    public function getConnection()
    {
        // Read the INI file
        $configData = parse_ini_file($this->configFile, true);

        // Check if reading was successful
        if ($configData === false) {
            die("Error reading INI file: " . error_get_last()['message']);
        }

        // Extract connection options
        $serverName = $configData['Database']['serverName'];
        $dbName = $configData['Database']['dbName'];
        $username = $configData['Database']['username'];
        $password = $configData['Database']['password'];

        $connectionOptions = array(
            "Database" => $dbName,
            "Uid" => $username,
            "PWD" => $password,
            "TrustServerCertificate" => true
        );

        // Establish the connection
        $conn = sqlsrv_connect($serverName, $connectionOptions);

        if ($conn === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        return $conn;
    }
}
?>
