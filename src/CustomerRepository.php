<?php
class CustomerRepository {
    private $database;

    public function __construct(Database $database) 
    {
        $this->database = $database;
    }

    public function getAll(): array
    {
        $conn = $this->database->getConnection();
            $stmt = sqlsrv_query($conn, "SELECT * FROM Customer");
            sqlsrv_execute($stmt);
        $results = [];
        while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $results[] = $row;
        }

        return $results;
    }
}
