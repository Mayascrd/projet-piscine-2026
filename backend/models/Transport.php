<?php

class Transport
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        $stmt = $this->conn->prepare("
            SELECT *
            FROM transports
            ORDER BY date_depart ASC
        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->conn->prepare("
            SELECT *
            FROM transports
            WHERE id_transport = :id
        ");

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->conn->prepare("
            INSERT INTO transports
            (
                type_transport,
                ville_depart,
                ville_arrivee,
                date_depart,
                date_arrivee,
                prix,
                places_disponibles,
                id_destination,
                id_prestataire
            )
            VALUES
            (
                :type_transport,
                :ville_depart,
                :ville_arrivee,
                :date_depart,
                :date_arrivee,
                :prix,
                :places,
                :destination,
                :prestataire
            )
        ");

        return $stmt->execute([
            ':type_transport' => $data['type_transport'],
            ':ville_depart' => $data['ville_depart'],
            ':ville_arrivee' => $data['ville_arrivee'],
            ':date_depart' => $data['date_depart'],
            ':date_arrivee' => $data['date_arrivee'],
            ':prix' => $data['prix'],
            ':places' => $data['places_disponibles'],
            ':destination' => $data['id_destination'],
            ':prestataire' => $data['id_prestataire']
        ]);
    }

    public function search($depart, $arrivee)
    {
        $stmt = $this->conn->prepare("
            SELECT *
            FROM transports
            WHERE ville_depart LIKE :depart
            AND ville_arrivee LIKE :arrivee
        ");

        $stmt->execute([
            ':depart' => "%$depart%",
            ':arrivee' => "%$arrivee%"
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function decreasePlaces($id)
    {
        $stmt = $this->conn->prepare("
            UPDATE transports
            SET places_disponibles = places_disponibles - 1
            WHERE id_transport = :id
            AND places_disponibles > 0
        ");

        return $stmt->execute([
            ':id' => $id
        ]);
    }
}
