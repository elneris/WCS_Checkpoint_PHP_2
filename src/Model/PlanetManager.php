<?php

namespace App\Model;

class PlanetManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'planet';


    /**
     * PlanetManager constructor.
     * @param \PDO $pdo
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
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
            SET name = :name
            WHERE id = :id");
        $statement->bindValue(':name',$informations['name'],\PDO::PARAM_STR);
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
            INSERT INTO $this->table(name)
            VALUES (:name)");
        $statement->bindValue(':name',$informations['name'],\PDO::PARAM_STR);

        $statement->execute();
    }
    
    /**
     * select planet from database.
     *
     * @param int $id
     *
     * @return array
     */
    public function selectPlanetByBeastIdMovie(int $id)
    {
        // prepared request
        $statement = $this->pdo->prepare("
            SELECT planet.name as name 
            FROM $this->table 
            JOIN beast
            ON beast.id_planet = planet.id
            WHERE id_planet=:id");
        $statement->bindValue(':id', $id, \PDO::PARAM_INT);
        
        $statement->execute();
        return $statement->fetch();
    }
}
