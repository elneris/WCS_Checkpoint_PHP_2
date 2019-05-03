<?php

namespace App\Controller;

use App\Model\MovieManager;
use App\Model\PlanetManager;

class MovieController extends AbstractController
{
    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function list() : string
    {
        $moviesManager = new MovieManager();
        $movies = $moviesManager->selectAll();
        return $this->twig->render('Movie/list.html.twig', ['movies' => $movies]);
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
        $movieManager = new MovieManager();
        $movie = $movieManager->selectOneById($id);

        return $this->twig->render('Movie/details.html.twig', [
            'movie' => $movie,
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
        $moviesManager = new MovieManager();

        $errors = [];
        $success = [];

        if ($_SERVER['REQUEST_METHOD'] = 'POST'){
            if (empty($_POST['title'])){
                $errors[] = 'Veuillez Renseigner TOUT les champs';
            } else {
                foreach ($_POST as $key => $value){
                    $_POST[$key] = $this->checkForm($value);
                }

                $moviesManager->insert($_POST);
                $success[] = 'ajout bien effectués';

            }

        }


        return $this->twig->render('Movie/add.html.twig', [
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

        $movieManager = new MovieManager();

        $errors = [];
        $success = [];

        if (isset($_POST['delete'])){
            $movieManager->delete($id);
            header('location: /Movie/list');
        }
        if ($_SERVER['REQUEST_METHOD'] = 'POST'){

            if (empty($_POST['title']) ){
                $errors[] = 'Veuillez Renseigner TOUT les champs';
            } else {
                foreach ($_POST as $key => $value){
                    $_POST[$key] = $this->checkForm($value);
                }

                $movieManager->update($_POST, $id);
                $success[] = 'Changement bien effectués';

            }

        }

        $movie = $movieManager->selectOneById($id);

        return $this->twig->render('Movie/edit.html.twig',[
            'movie' => $movie,
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