<?php
// Enable error reporting and logging
error_reporting(E_ALL);
ini_set('display_errors', 1);

require "vendor/autoload.php";

$container = new Container;

$customerRepo = $container->get(CustomerRepository::class);

// Check if customerId and vipStatus are set in the POST request
if(isset($_POST['customerId']) && isset($_POST['vipStatus'])) {
    // Get customerId and vipStatus from the POST request
    $customerId = $_POST['customerId'];
    $vipStatus = $_POST['vipStatus'];

    // Call the setVIP method with the provided customerId and vipStatus
    $result = $customerRepo->setVIP($customerId, $vipStatus);

    // Check if the result is successful
    if ($result) {
        // If successful, redirect back to the customers.php page
        header("Location: customers.php");
        exit();
    } else {
        // If not successful, display an error message
        echo "Error: Unable to set VIP status.";
    }
} else {
    // If customerId or vipStatus is not set, display an error message
    echo "Error: customerId or vipStatus not provided.";
}
?>
