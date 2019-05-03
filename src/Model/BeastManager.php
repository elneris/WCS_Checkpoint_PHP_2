<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 18:20
 * PHP version 7
 */

namespace App\Model;

/**
 * Class BeastManager
 * @package Model
 */
class BeastManager extends AbstractManager
{

    /**
     *
     */
    const TABLE = 'beast';


    /**
     * BeastManager constructor.
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
            JOIN movie
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
            SET name = :name, picture = :picture, size = :size, 
            area = :area, id_movie = :movies, id_planet = :planet
            WHERE id = :id");
        $statement->bindValue(':name',$informations['name'],\PDO::PARAM_STR);
        $statement->bindValue(':picture',$informations['picture'],\PDO::PARAM_STR);
        $statement->bindValue(':size',$informations['size'],\PDO::PARAM_INT);
        $statement->bindValue(':area',$informations['area'],\PDO::PARAM_STR);
        $statement->bindValue(':movies',$informations['movies'],\PDO::PARAM_INT);
        $statement->bindValue(':planet',$informations['planet'],\PDO::PARAM_INT);
        $statement->bindValue(':id',$id,\PDO::PARAM_INT);

        $statement->execute();
    }
}
