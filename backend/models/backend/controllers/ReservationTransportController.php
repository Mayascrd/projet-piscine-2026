<?php

require_once __DIR__ . '/../models/ReservationTransport.php';
require_once __DIR__ . '/../models/Transport.php';
require_once __DIR__ . '/../utils/Response.php';

class ReservationTransportController
{
    private $reservation;
    private $transport;

    public function __construct($db)
    {
        $this->reservation = new ReservationTransport($db);
        $this->transport = new Transport($db);
    }

    public function reserver()
    {
        $data = json_decode(
            file_get_contents("php://input"),
            true
        );

        $this->transport->decreasePlaces(
            $data["id_transport"]
        );

        $this->reservation->reserver(
            $data["id_user"],
            $data["id_transport"]
        );

        Response::json([
            "message"=>"Trajet réservé"
        ]);
    }

    public function annuler($id)
    {
        $this->reservation->annuler($id);

        Response::json([
            "message"=>"Réservation annulée"
        ]);
    }
}
