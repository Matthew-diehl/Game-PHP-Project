<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the necessary dependencies
require "vendor/autoload.php";

// Initialize the container
$container = new Container;

// Get the GameRepository instance from the container
$gameRepo = $container->get(GameRepository::class);

// Check if the form data is received
if(isset($_POST['gameData'])) {
    // Retrieve the game data from the POST request
    $gameData = $_POST['gameData'];

    // Extract the form data into individual variables
    $title = $gameData['title'];
    $price = $gameData['price'];
    $publisher = $gameData['publisher'];
    $release_date = $gameData['release_date'];

    // Prepare the game data as an array
    $game = array($title, $price, $publisher, $release_date);

    // Insert the game into the database
    try {
        $gameRepo->createGame($game); // Call the createGame function with the game data
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage(); // Handle any exceptions
    }
} else {
    echo "Error: No data received"; // Handle if no data is received
}
?>
