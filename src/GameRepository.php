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
}
