<?php

require "vendor/autoload.php";

$container = new Container;

$repository = $container->get(GameRepository::class);

$data = $repository->getAll("Farm");

?>

<!DOCTYPE html>
<html>
<head>
    <title>My PHP Web App</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <span>
    <img class="logo" src="/images/logo.png" alt="Logo">
    <ul class="nav">
        <li><a href="#games">Games</a></li>
        <li><a href="#customers">Customers</a></li>
        <li><a href="#employees">Employees</a></li>
    </ul>
    </span>
    <div class="welcome">
        <h1>Welcome to My PHP Web App!</h1>
    </div>
    <!-- Your content goes here -->
</body>
</html>




