<?php


namespace App\Controller;

use App\Model\PlanetManager;

class PlanetController extends AbstractController
{
    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function list() : string
    {
        $planetsManager = new PlanetManager();
        $planets = $planetsManager->selectAll();
        return $this->twig->render('Planet/list.html.twig', ['planets' => $planets]);
    }
}