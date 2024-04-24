<?php

require "vendor/autoload.php";

$container = new Container;

$repository = $container->get(GenreRepository::class);

$data = $repository->getAll();

?>

<!DOCTYPE html>
<html>
<head>
    <title>My PHP Web App</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <span>
    <ul class="nav">
        <li><a href="index.php">Home</a></li>
        <li><a href="games.php">Games</a></li>
        <li><a href="customers.php">Customers</a></li>
        <li><a href="#employees">Employees</a></li>
    </ul>
    </span>
    <div class="welcome">
        <h1>Welcome to My PHP Web App!</h1>
    </div>
</body>
</html>




