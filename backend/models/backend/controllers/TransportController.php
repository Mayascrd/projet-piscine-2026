<?php

require_once __DIR__ . '/../models/Transport.php';
require_once __DIR__ . '/../utils/Response.php';

class TransportController
{
    private $transport;

    public function __construct($db)
    {
        $this->transport = new Transport($db);
    }

    public function getAll()
    {
        Response::json(
            $this->transport->getAll()
        );
    }

    public function getById($id)
    {
        Response::json(
            $this->transport->getById($id)
        );
    }

    public function create()
    {
        $data = json_decode(
            file_get_contents("php://input"),
            true
        );

        if(
            strtotime($data["date_arrivee"])
            <=
            strtotime($data["date_depart"])
        ){
            Response::json([
                "message" =>
                "Date d'arrivée invalide"
            ],400);
        }

        $this->transport->create($data);

        Response::json([
            "message"=>"Transport créé"
        ],201);
    }

    public function search()
    {
        $depart = $_GET["depart"] ?? "";
        $arrivee = $_GET["arrivee"] ?? "";

        Response::json(
            $this->transport->search(
                $depart,
                $arrivee
            )
        );
    }
}
