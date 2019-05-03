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

    /**
     * update Beast from database.
     *
     * @param array $informations
     * @param int $id
     *
     * @return void
     */
    public function update(array $informations, int $id):void
    {
        // prepared request
        $statement = $this->pdo->prepare("
            UPDATE $this->table
            SET title = :title
            WHERE id = :id");
        $statement->bindValue(':title',$informations['title'],\PDO::PARAM_STR);
        $statement->bindValue(':id',$id,\PDO::PARAM_INT);

        $statement->execute();
    }

    /**
     * insert Beast from database.
     *
     * @param array $informations
     *
     * @return void
     */
    public function insert(array $informations):void
    {
        // prepared request
        $statement = $this->pdo->prepare("
            INSERT INTO $this->table(title)
            VALUES (:title)");
        $statement->bindValue(':title',$informations['title'],\PDO::PARAM_STR);

        $statement->execute();
    }
}