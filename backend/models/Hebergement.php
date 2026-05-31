<?php

class Hebergement
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
            FROM hebergements
            ORDER BY nom
        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->conn->prepare("
            SELECT *
            FROM hebergements
            WHERE id_hebergement = :id
        ");

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->conn->prepare("
            INSERT INTO hebergements
            (
                nom,
                description,
                adresse,
                prix_nuit,
                capacite,
                image,
                statut,
                id_destination,
                id_prestataire
            )
            VALUES
            (
                :nom,
                :description,
                :adresse,
                :prix_nuit,
                :capacite,
                :image,
                'disponible',
                :destination,
                :prestataire
            )
        ");

        return $stmt->execute([
            ':nom' => $data['nom'],
            ':description' => $data['description'],
            ':adresse' => $data['adresse'],
            ':prix_nuit' => $data['prix_nuit'],
            ':capacite' => $data['capacite'],
            ':image' => $data['image'],
            ':destination' => $data['id_destination'],
            ':prestataire' => $data['id_prestataire']
        ]);
    }

    public function update($id,$data)
    {
        $stmt = $this->conn->prepare("
            UPDATE hebergements
            SET
                nom = :nom,
                description = :description,
                adresse = :adresse,
                prix_nuit = :prix_nuit,
                capacite = :capacite
            WHERE id_hebergement = :id
        ");

        return $stmt->execute([
            ':id'=>$id,
            ':nom'=>$data['nom'],
            ':description'=>$data['description'],
            ':adresse'=>$data['adresse'],
            ':prix_nuit'=>$data['prix_nuit'],
            ':capacite'=>$data['capacite']
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("
            DELETE FROM hebergements
            WHERE id_hebergement = :id
        ");

        return $stmt->execute([
            ':id'=>$id
        ]);
    }

    public function search($keyword)
    {
        $stmt = $this->conn->prepare("
            SELECT *
            FROM hebergements
            WHERE
                nom LIKE :keyword
                OR adresse LIKE :keyword
        ");

        $stmt->execute([
            ':keyword'=>"%$keyword%"
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function filter($prixMax)
    {
        $stmt = $this->conn->prepare("
            SELECT *
            FROM hebergements
            WHERE prix_nuit <= :prix
        ");

        $stmt->execute([
            ':prix'=>$prixMax
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
