<?php
// Enable error reporting and logging
error_reporting(E_ALL);
ini_set('display_errors', 1);

require "vendor/autoload.php";

$container = new Container;

$customerRepo = $container->get(CustomerRepository::class);

$customers = $customerRepo->getAll();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Customers - My PHP Web App</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <span>
        <ul class="nav">
            <li><a href="index.php">Home</a></li>
            <li><a href="games.php">Games</a></li>
            <li><a href="customers.php">Customers</a></li> <!-- Link to the customers page -->
            <li><a href="#employees">Employees</a></li>
        </ul>
    </span>
    <div class="content">
        <h1>Customers</h1>
        <table class="customers-table">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Vip Status</th>
                    <th>Action</th> <!-- New column header for the action button -->
                </tr>
            </thead>
            <tbody>
            <?php
                // Populate table rows with customers
                foreach ($customers as $customer) {
                    echo "<tr>";
                    echo "<td>{$customer['FirstName']}</td>";
                    echo "<td>{$customer['LastName']}</td>";
                    echo "<td>{$customer['Email']}</td>";
                    echo "<td>{$customer['Phone']}</td>";
                    echo "<td>{$customer['VipStatus']}</td>";
                    echo "<td><form action='set_vip.php' method='post'><input type='hidden' name='customerId' value='{$customer['CustomerId']}'><input type='hidden' name='vipStatus' value='{$customer['VipStatus']}'><button class='filter-btn' type='submit'>Set VIP</button></form></td>"; // Button to set VIP status
                    echo "</tr>";
                }
            ?>
            </tbody>
        </table>
    </div>
</body>
</html>

