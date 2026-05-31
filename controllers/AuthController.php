<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../utils/Response.php';

class AuthController
{
    private $user;

    public function __construct($db)
    {
        $this->user = new User($db);
    }

    public function register()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if(
            empty($data["nom"]) ||
            empty($data["prenom"]) ||
            empty($data["email"]) ||
            empty($data["password"])
        ){
            Response::json([
                "message" => "Tous les champs sont obligatoires"
            ], 400);
        }

        $existingUser = $this->user->findByEmail($data["email"]);

        if($existingUser){
            Response::json([
                "message" => "Email déjà utilisé"
            ], 400);
        }

        $hashedPassword = password_hash(
            $data["password"],
            PASSWORD_BCRYPT
        );

        $this->user->create(
            $data["nom"],
            $data["prenom"],
            $data["email"],
            $hashedPassword
        );

        Response::json([
            "message" => "Compte créé avec succès"
        ], 201);
    }

    public function login()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $user = $this->user->findByEmail(
            $data["email"]
        );

        if(
            !$user ||
            !password_verify(
                $data["password"],
                $user["mot_de_passe"]
            )
        ){
            Response::json([
                "message" => "Identifiants invalides"
            ], 401);
        }

        session_start();

        $_SESSION["user_id"] = $user["id_user"];
        $_SESSION["role"] = $user["id_role"];

        Response::json([
            "message" => "Connexion réussie",
            "user" => [
                "id" => $user["id_user"],
                "nom" => $user["nom"],
                "prenom" => $user["prenom"],
                "email" => $user["email"],
                "role" => $user["id_role"]
            ]
        ]);
    }

    public function logout()
    {
        session_start();

        session_destroy();

        Response::json([
            "message" => "Déconnexion réussie"
        ]);
    }
}
