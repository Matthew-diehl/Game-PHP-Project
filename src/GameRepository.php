<?php
class GameRepository {
    private $database;

    public function __construct(Database $database) 
    {
        $this->database = $database;
    }

    // Used for task 3 Getting all games / Filtering by Genre
    public function getAll($genre = null): array
    {
        $conn = $this->database->getConnection();

        if($genre === null) 
        {
            $stmt = sqlsrv_query($conn, "SELECT * FROM Game");
        }
        else {
            $stmt = sqlsrv_prepare(
                $conn,
                 "SELECT Game.* 
                 FROM Game 
                 JOIN GameGenre ON Game.GameId = GameGenre.GameId 
                 JOIN Genre ON GameGenre.GenreId = Genre.GenreId 
                 WHERE Genre.Name LIKE ? ", 
                 array('%' . $genre . '%')
                 );
            sqlsrv_execute($stmt);
        }

        $results = [];
        while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $results[] = $row;
        }

        return $results;
    }

    // Used for Task 1 Inserting New Games into the Database
    public function createGame($game)
{
    $conn = $this->database->getConnection();

    // Prepare the SQL statement
    $stmt = sqlsrv_prepare(
        $conn,
        "INSERT INTO Game (Title, Price, Publisher, ReleaseDateTime, isDeleted)
         VALUES (?,?,?,?,0)",
         $game
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
        echo "Game created successfully!";
    }
}

public function detailedView($GameId)
{
    $conn = $this->database->getConnection();

    $params = array($GameId);

    // Prepare the SQL queries
    $gameQuery = sqlsrv_prepare(
        $conn,
        "SELECT g.Title, g.Price, g.Publisher, g.ReleaseDateTime 
        FROM Game AS g 
        WHERE g.GameId = ?;",
        $params
    );

    $genreQuery = sqlsrv_prepare(
        $conn,
        "SELECT gen.[Name]
        FROM Genre AS gen 
        INNER JOIN GameGenre AS gg ON gen.GenreId = gg.GenreId
        INNER JOIN Game AS g ON gg.GameId = g.GameId
        WHERE g.GameId = ?;",
        $params
    );

    $platformQuery = sqlsrv_prepare(
        $conn,
        "SELECT p.[Name]
        FROM [dbo].[Platform] AS p
        INNER JOIN GamePlatform AS gp ON p.PlatformId = gp.PlatformId
        INNER JOIN Game AS g ON gp.GameId = g.GameId
        WHERE g.GameId = ?;",
        $params
    );

    // Execute the queries
    sqlsrv_execute($gameQuery);
    sqlsrv_execute($genreQuery);
    sqlsrv_execute($platformQuery);

    // Fetch game details
    $gameDetails = sqlsrv_fetch_array($gameQuery, SQLSRV_FETCH_ASSOC);

    // Fetch genres
    $genres = [];
    while ($genre = sqlsrv_fetch_array($genreQuery, SQLSRV_FETCH_ASSOC)) {
        $genres[] = $genre['Name'];
    }

    // Fetch platforms
    $platforms = [];
    while ($platform = sqlsrv_fetch_array($platformQuery, SQLSRV_FETCH_ASSOC)) {
        $platforms[] = $platform['Name'];
    }

    // Construct the object
    $result = [
        'Title' => $gameDetails['Title'],
        'Price' => $gameDetails['Price'],
        'Publisher' => $gameDetails['Publisher'],
        'ReleaseDateTime' => $gameDetails['ReleaseDateTime'],
        'GenreList' => $genres,
        'PlatformList' => $platforms
    ];

    // Return the data
    return $result;
}


}
