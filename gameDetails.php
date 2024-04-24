<?php
// Enable error reporting and logging
error_reporting(E_ALL);
ini_set('display_errors', 1);

require "vendor/autoload.php";

$container = new Container;

$gameRepo = $container->get(GameRepository::class);

?>


<!DOCTYPE html>
<html>
<head>
    <title>Game Details - My PHP Web App</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <button class="back-button" onclick="window.location.href='games.php'">Back to Games</button>
    <div class="container">
        <div class="card">
        <h1 class="header-center">Game Details</h1>
            <?php
                $GameId = $_GET['GameId'];
                $gameDetails = $gameRepo->detailedView($GameId); // Call detailedView function
            ?>
            <p><strong>Title:</strong> <?php echo $gameDetails['Title']; ?></p>
            <p><strong>Price:</strong> <?php echo $gameDetails['Price']; ?></p>
            <p><strong>Publisher:</strong> <?php echo $gameDetails['Publisher']; ?></p>
            <p><strong>Release Date:</strong> <?php echo $gameDetails['ReleaseDateTime']->format('m/d/Y'); ?></p>
            <p><strong>Genres:</strong> <?php echo implode(', ', $gameDetails['GenreList']); ?></p>
            <p><strong>Platforms:</strong> <?php echo implode(', ', $gameDetails['PlatformList']); ?></p>
        </div>
    </div>
</body>
</html>


