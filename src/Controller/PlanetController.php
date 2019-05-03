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

    /**
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function details(int $id)  : string
    {
        $planetManager = new PlanetManager();
        $planet = $planetManager->selectOneById($id);

        return $this->twig->render('Planet/details.html.twig', [
            'planet' => $planet,
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
        $planetsManager = new PlanetManager();

        $errors = [];
        $success = [];

        if ($_SERVER['REQUEST_METHOD'] = 'POST'){
            if (empty($_POST['name'])){
                $errors[] = 'Veuillez Renseigner TOUT les champs';
            } else {
                foreach ($_POST as $key => $value){
                    $_POST[$key] = $this->checkForm($value);
                }

                $planetsManager->insert($_POST);
                $success[] = 'ajout bien effectués';

            }

        }


        return $this->twig->render('Planet/add.html.twig', [
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

        $planetManager = new PlanetManager();

        $errors = [];
        $success = [];

        if (isset($_POST['delete'])){
            $planetManager->delete($id);
            header('location: /Planet/list');
        }
        if ($_SERVER['REQUEST_METHOD'] = 'POST'){

            if (empty($_POST['name']) ){
                $errors[] = 'Veuillez Renseigner TOUT les champs';
            } else {
                foreach ($_POST as $key => $value){
                    $_POST[$key] = $this->checkForm($value);
                }

                $planetManager->update($_POST, $id);
                $success[] = 'Changement bien effectués';

            }

        }

        $planet = $planetManager->selectOneById($id);

        return $this->twig->render('Planet/edit.html.twig',[
            'planet' => $planet,
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