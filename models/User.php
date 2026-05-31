<?php

class User
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create($nom, $prenom, $email, $password)
    {
        $sql = "
            INSERT INTO utilisateurs
            (
                nom,
                prenom,
                email,
                mot_de_passe,
                id_role
            )
            VALUES
            (
                :nom,
                :prenom,
                :email,
                :password,
                1
            )
        ";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ":nom" => $nom,
            ":prenom" => $prenom,
            ":email" => $email,
            ":password" => $password
        ]);
    }

    public function findByEmail($email)
    {
        $sql = "
            SELECT *
            FROM utilisateurs
            WHERE email = :email
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ":email" => $email
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
