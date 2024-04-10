<?php
class Repository {
    public function __construct(private Database $database) 
    {
    }

    public function getAll(): array
    {
        $conn = $this->database->getConnection();

        $stmt = sqlsrv_query($conn, "SELECT * FROM UserInfo");

        $results = [];
        while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $results[] = $row;
        }

        return $results;
    }
}
