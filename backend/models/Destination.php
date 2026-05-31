<?php

class Destination
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        $sql = "
            SELECT *
            FROM destinations
            ORDER BY nom ASC
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $sql = "
            SELECT *
            FROM destinations
            WHERE id_destination = :id
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $sql = "
            INSERT INTO destinations
            (
                nom,
                pays,
                ville,
                description,
                image,
                categorie,
                budget_moyen
            )
            VALUES
            (
                :nom,
                :pays,
                :ville,
                :description,
                :image,
                :categorie,
                :budget
            )
        ";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':nom' => $data['nom'],
            ':pays' => $data['pays'],
            ':ville' => $data['ville'],
            ':description' => $data['description'],
            ':image' => $data['image'],
            ':categorie' => $data['categorie'],
            ':budget' => $data['budget_moyen']
        ]);
    }

    public function update($id, $data)
    {
        $sql = "
            UPDATE destinations
            SET
                nom = :nom,
                pays = :pays,
                ville = :ville,
                description = :description,
                image = :image,
                categorie = :categorie,
                budget_moyen = :budget
            WHERE id_destination = :id
        ";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':id' => $id,
            ':nom' => $data['nom'],
            ':pays' => $data['pays'],
            ':ville' => $data['ville'],
            ':description' => $data['description'],
            ':image' => $data['image'],
            ':categorie' => $data['categorie'],
            ':budget' => $data['budget_moyen']
        ]);
    }

    public function delete($id)
    {
        $sql = "
            DELETE FROM destinations
            WHERE id_destination = :id
        ";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }

    public function search($keyword)
    {
        $sql = "
            SELECT *
            FROM destinations
            WHERE
                nom LIKE :keyword
                OR pays LIKE :keyword
                OR ville LIKE :keyword
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':keyword' => "%$keyword%"
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function filter($categorie, $budgetMax)
    {
        $sql = "
            SELECT *
            FROM destinations
            WHERE categorie = :categorie
            AND budget_moyen <= :budget
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':categorie' => $categorie,
            ':budget' => $budgetMax
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
