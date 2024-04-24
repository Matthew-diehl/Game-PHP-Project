<?php
// Enable error reporting and logging
error_reporting(E_ALL);
ini_set('display_errors', 1);

require "vendor/autoload.php";

$container = new Container;

$genreRepo = $container->get(GenreRepository::class);
$gameRepo = $container->get(GameRepository::class);

$genre = $genreRepo->getAll();

// Check if the button has been clicked and a genre has been selected
if (isset($_POST['filter_games']) && isset($_POST['genre'])) {
    $selectedGenre = $_POST['genre'];
    // If the selected genre is "all", fetch all games, otherwise, filter games by genre
    if ($selectedGenre === "all") {
        $games = $gameRepo->getAll();
    } else {
        $games = $gameRepo->getAll($selectedGenre);
    }

    // Output table rows only
    foreach ($games as $game) {
        echo "<tr>";
        echo "<td>{$game['Title']}</td>";
        echo "<td>{$game['Price']}</td>";
        echo "<td>{$game['Publisher']}</td>";
        // Add more table cells if needed
        echo "</tr>";
    }

    // Exit to prevent further output
    exit();
}

// Fetch all games by default
$games = $gameRepo->getAll();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Games - My PHP Web App</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> <!-- Include jQuery UI library -->
    <script>
    $(document).ready(function(){
        $("#filter_games_btn").click(function(){
                var selectedGenreId = $("#genre").val();
                $.ajax({
                    url: "games.php",
                    type: "POST",
                    data: { filter_games: true, genre: selectedGenreId },
                    success: function(response){
                        $(".games-table tbody").html(response); // Replace table content with updated games
                    }
                });
            });
        // Function to open the pop-up dialog form
        $("#add_games_btn").click(function(){
            $("#dialog-overlay").show(); // Show overlay
            $("#dialog-form").dialog("open");
        });

        // Initialize the pop-up dialog form
        $("#dialog-form").dialog({
            autoOpen: false,
            modal: true,
            buttons: {
                "Submit": function() {
                    // Create an object to hold form data
                    var gameData = {
                        title: $("#title").val(),
                        price: $("#price").val(),
                        publisher: $("#publisher").val(),
                        release_date: $("#release_date").val().replace("T", " ") // Replace 'T' with space
                    };
                    // Submit the form data via AJAX
                    $.ajax({
                        url: "process_game.php", // Update this URL with the PHP file handling the form submission
                        type: "POST",
                        data: { gameData: gameData }, // Pass the form data as an object
                        success: function(response){
                            alert(response); // Display response message
                            // Close the dialog form
                            $("#dialog-form").dialog("close");
                            $("#dialog-overlay").hide();
                            // Refresh the table content
                            $("#filter_games_btn").click();
                        }
                    });
                },
                "Cancel": function() {
                    $(this).dialog("close");
                    $("#dialog-overlay").hide(); // Hide overlay on cancel
                }
            }
        });
        // Handle click event for submit button
        $("#submit-btn").click(function() {
            // Trigger the submit action of the dialog form
            $("#dialog-form").dialog("option", "buttons")["Submit"].apply();
        });
         // Handle click event for cancel button
        $("#cancel-btn").click(function() {
            // Close the dialog form
            $("#dialog-form").dialog("close");
            $("#dialog-overlay").hide(); // Hide overlay on cancel
        });

    });
</script>

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
    <div class="content">
        <h1>Games</h1>
        <div class="filter">
            <label for="genre">Select Genre:</label>
            <select id="genre" name="genre">
                <option value="all">All Genre</option>
                <?php
                    foreach($genre as $item) {
                        echo "<option value={$item['Name']}>{$item['Name']}</option>";
                    }                    
                ?>
            </select>
            <button id="filter_games_btn" class="filter-btn">Filter Games</button>
            <button id="add_games_btn" class="filter-btn">Add Game</button>
        </div>
        <!-- Dialog form for adding a new game -->
<div id="dialog-overlay" class="dialog-overlay"></div> <!-- Add the overlay container -->
<div id="dialog-form" title="Add New Game" class="dialog-container"> <!-- Apply the dialog-container class -->
    <form id="game-form">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title"><br>
        <label for="price">Price:</label><br>
        <input type="text" id="price" name="price"><br>
        <label for="publisher">Publisher:</label><br>
        <input type="text" id="publisher" name="publisher"><br>
        <label for="release_date">Release Date:</label><br>
        <input type="datetime-local" id="release_date" name="release_date"><br>
    </form>
    <!-- Add buttons for submit and cancel -->
    <button id="submit-btn" class="filter-btn">Submit</button>
    <button id="cancel-btn" class="filter-btn">Cancel</button>
</div>
        <table class="games-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Publisher</th>
                    <th>Actions</th>
                    <!-- Add more table headers if needed -->
                </tr>
            </thead>
            <tbody>
            <?php
                    // Populate table rows with games
                    foreach ($games as $game) {
                        echo "<tr>";
                        echo "<td>{$game['Title']}</td>";
                        echo "<td>{$game['Price']}</td>";
                        echo "<td>{$game['Publisher']}</td>";
                        echo "<td><a href='gameDetails.php?GameId={$game['GameId']}'>View Details</a></td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
