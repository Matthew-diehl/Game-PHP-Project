<?php
class GameRepository {
    private $database;

    public function __construct(Database $database) 
    {
        $this->database = $database;
    }

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

}
