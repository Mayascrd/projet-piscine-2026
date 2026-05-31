<?php

class ReservationTransport
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function reserver($userId, $transportId)
    {
        $stmt = $this->conn->prepare("
            INSERT INTO reservations_transport
            (
                id_user,
                id_transport
            )
            VALUES
            (
                :user,
                :transport
            )
        ");

        return $stmt->execute([
            ':user' => $userId,
            ':transport' => $transportId
        ]);
    }

    public function annuler($id)
    {
        $stmt = $this->conn->prepare("
            UPDATE reservations_transport
            SET statut='annulee'
            WHERE id_reservation_transport=:id
        ");

        return $stmt->execute([
            ':id'=>$id
        ]);
    }
}
