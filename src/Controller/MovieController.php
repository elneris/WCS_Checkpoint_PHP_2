<?php

namespace App\Controller;

use App\Model\MovieManager;

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
}