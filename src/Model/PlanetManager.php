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
     * Get planet_id from database join beast.
     *
     * @param  int $id
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
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }
}