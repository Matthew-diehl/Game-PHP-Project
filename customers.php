<?php
// Enable error reporting and logging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Now your PHP code follows...

require "vendor/autoload.php";

$container = new Container;

$customerRepo = $container->get(CustomerRepository::class);

$customers = $customerRepo->getAll(); // Assuming a method like getAll() in CustomerRepository

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
        <table class="customers-table"> <!-- Assuming you have a CSS class for styling -->
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Vip Status</th>
                    <!-- Add more table headers if needed -->
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
                    echo "</tr>";
                }
            ?>
            </tbody>
        </table>
    </div>
</body>
</html>
