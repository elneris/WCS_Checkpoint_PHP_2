<?php


namespace App\Controller;

use App\Model\BeastManager;
use App\Model\MovieManager;
use App\Model\PlanetManager;

/**
 * Class BeastController
 * @package Controller
 */
class BeastController extends AbstractController
{


    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function list() : string
    {
        $beastsManager = new BeastManager();
        $beasts = $beastsManager->selectAll();
        return $this->twig->render('Beast/list.html.twig', ['beasts' => $beasts]);
    }


    /**
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function details(int $id)  : string
    {
        $beastManager = new BeastManager();
        $beast = $beastManager->selectOneById($id);

        $movieManager = new MovieManager();
        $movie = $movieManager->selectMovieByBeastIdMovie($beast['id_movie']);

        $planetManager = new PlanetManager();
        $planet = $planetManager->selectPlanetByBeastIdMovie($beast['id_planet']);

        return $this->twig->render('Beast/details.html.twig', [
            'beast' => $beast,
            'movie' => $movie,
            'planet' => $planet
        ]);
    }


    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add()  : string
    {
      // TODO : A creation page where your can add a new beast.

        return $this->twig->render('Beast/add.html.twig');
    }


    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit() : string
    {
      // TODO : An edition page where your can add a new beast.
        return $this->twig->render('Beast/edit.html.twig');
    }
}
