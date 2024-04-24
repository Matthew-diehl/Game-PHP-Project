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
    // Set VIP Status for Task 2
    public function setVIP($CustomerId, $VipStatus)
{
    // Determine the new VIP status
    $newVipStatus = $VipStatus == 0 ? 1 : 0;
    
    // Prepare parameters for the SQL query
    $params = array($newVipStatus, $CustomerId);
    
    // Get the database connection
    $conn = $this->database->getConnection();
    
    // Prepare the SQL statement
    $stmt = sqlsrv_prepare($conn,
        "UPDATE Customer
        SET VipStatus = ?
        WHERE CustomerId = ?",
        $params
    );
    
    // Check if the statement was prepared successfully
    if ($stmt === false) {
        // Handle error if the statement could not be prepared
        die(print_r(sqlsrv_errors(), true)); 
    }

    // Execute the SQL statement
    $result = sqlsrv_execute($stmt);

    // Check if the execution was successful
    if ($result === false) {
        // Handle error if the execution failed
        die(print_r(sqlsrv_errors(), true)); 
    } else {
        // Provide feedback on success
        return "VIP Status Successfully Updated";
    }
}

}
