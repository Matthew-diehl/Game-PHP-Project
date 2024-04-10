<?php

class Database
{
    private string $serverName = "i4-cs-dba.ad.psu.edu";
    private string $dbName = "mqd5800";
    private string $username = "sqlmqd5800";
    private string $password = "BMKp%kP?2V";

    public function getConnection()
    {
        $connectionOptions = array(
            "Database" => $this->dbName,
            "Uid" => $this->username,
            "PWD" => $this->password,
            "TrustServerCertificate" => true
        );

        //Establishes the connection
        $conn = sqlsrv_connect($this->serverName, $connectionOptions);

        if($conn === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        return $conn;
    }
}
?>
