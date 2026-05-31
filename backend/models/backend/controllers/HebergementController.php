<?php

require_once '../models/Hebergement.php';
require_once '../utils/Response.php';

class HebergementController
{
    private $hebergement;

    public function __construct($db)
    {
        $this->hebergement = new Hebergement($db);
    }

    public function getAll()
    {
        Response::json(
            $this->hebergement->getAll()
        );
    }

    public function getById($id)
    {
        Response::json(
            $this->hebergement->getById($id)
        );
    }

    public function create()
    {
        $data = json_decode(
            file_get_contents("php://input"),
            true
        );

        $this->hebergement->create($data);

        Response::json([
            "message"=>"Hébergement créé"
        ],201);
    }

    public function update($id)
    {
        $data = json_decode(
            file_get_contents("php://input"),
            true
        );

        $this->hebergement->update($id,$data);

        Response::json([
            "message"=>"Hébergement modifié"
        ]);
    }

    public function delete($id)
    {
        $this->hebergement->delete($id);

        Response::json([
            "message"=>"Hébergement supprimé"
        ]);
    }

    public function search()
    {
        Response::json(
            $this->hebergement->search(
                $_GET['q'] ?? ''
            )
        );
    }

    public function filter()
    {
        Response::json(
            $this->hebergement->filter(
                $_GET['prix'] ?? 99999
            )
        );
    }
}
