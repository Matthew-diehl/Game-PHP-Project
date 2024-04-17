<?php
// Enable error reporting and logging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Now your PHP code follows...


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
        });
    </script>
</head>
<body>
    <span>
        <ul class="nav">
            <li><a href="index.php">Home</a></li>
            <li><a href="games.php">Games</a></li>
            <li><a href="#customers">Customers</a></li>
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
        </div>
        <table class="games-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Publisher</th>
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
                        // Add more table cells if needed
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>