<?php

namespace App\Model;

class MovieManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'movie';


    /**
     * MovieManager constructor.
     * @param \PDO $pdo
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     * Get movie_id from database join beast.
     *
     * @param  int $id
     *
     * @return array
     */
    public function selectMovieByBeastIdMovie(int $id)
    {
        // prepared request
        $statement = $this->pdo->prepare("
            SELECT movie.title as title 
            FROM $this->table 
            JOIN beast
            ON beast.id_movie = movie.id
            WHERE id_movie=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }
}