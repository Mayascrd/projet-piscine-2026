<?php

require_once __DIR__ . '/../models/Destination.php';
require_once __DIR__ . '/../utils/Response.php';

class DestinationController
{
    private $destination;

    public function __construct($db)
    {
        $this->destination = new Destination($db);
    }

    public function getAll()
    {
        Response::json(
            $this->destination->getAll()
        );
    }

    public function getById($id)
    {
        Response::json(
            $this->destination->getById($id)
        );
    }

    public function create()
    {
        $data = json_decode(
            file_get_contents("php://input"),
            true
        );

        $this->destination->create($data);

        Response::json([
            "message" => "Destination créée"
        ], 201);
    }

    public function update($id)
    {
        $data = json_decode(
            file_get_contents("php://input"),
            true
        );

        $this->destination->update($id, $data);

        Response::json([
            "message" => "Destination modifiée"
        ]);
    }

    public function delete($id)
    {
        $this->destination->delete($id);

        Response::json([
            "message" => "Destination supprimée"
        ]);
    }

    public function search()
    {
        $keyword = $_GET['q'] ?? '';

        Response::json(
            $this->destination->search($keyword)
        );
    }

    public function filter()
    {
        $categorie = $_GET['categorie'] ?? '';
        $budget = $_GET['budget'] ?? 999999;

        Response::json(
            $this->destination->filter(
                $categorie,
                $budget
            )
        );
    }
}
