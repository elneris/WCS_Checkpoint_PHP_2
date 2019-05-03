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
        $beastManager = new BeastManager();

        $errors = [];
        $success = [];

        if ($_SERVER['REQUEST_METHOD'] = 'POST'){
            if (empty($_POST['name']) || empty($_POST['area']) || empty($_POST['picture'])
                || empty($_POST['size']) || empty($_POST['planet']) || empty($_POST['movies'])){
                $errors[] = 'Veuillez Renseigner TOUT les champs';
            } else {
                foreach ($_POST as $key => $value){
                    $_POST[$key] = $this->checkForm($value);
                }

                $beastManager->insert($_POST);
                $success[] = 'ajout bien effectués';

            }

        }

        $movieManager = new MovieManager();
        $movies = $movieManager->selectAll();
        $planetManager = new PlanetManager();
        $planets = $planetManager->selectAll();

        return $this->twig->render('Beast/add.html.twig', [
            'movies' => $movies,
            'planets' => $planets,
            'errors' => $errors,
            'success' => $success
            ]);
    }


    /**
     *
     * @param int $id
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit(int $id) : string
    {

        $beastManager = new BeastManager();

        $errors = [];
        $success = [];

        if (isset($_POST['delete'])){
            $beastManager->delete($id);
            header('location: /Beast/list');
        }
        if ($_SERVER['REQUEST_METHOD'] = 'POST'){

            if (empty($_POST['name']) || empty($_POST['area']) || empty($_POST['picture'])
            || empty($_POST['size']) || empty($_POST['planet']) || empty($_POST['movies'])){
                $errors[] = 'Veuillez Renseigner TOUT les champs';
            } else {
                foreach ($_POST as $key => $value){
                    $_POST[$key] = $this->checkForm($value);
                }

                $beastManager->update($_POST, $id);
                $success[] = 'Changement bien effectués';

            }

        }

        $beast = $beastManager->selectOneById($id);
        $movieManager = new MovieManager();
        $movies = $movieManager->selectAll();
        $planetManager = new PlanetManager();
        $planets = $planetManager->selectAll();

        return $this->twig->render('Beast/edit.html.twig',[
            'beast' => $beast,
            'movies' => $movies,
            'planets' => $planets,
            'errors' => $errors,
            'success' => $success
        ]);
    }

    /**
     *
     * @param string $str
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function checkForm(string $str):string
    {
        return htmlspecialchars(trim($str));
    }
}
