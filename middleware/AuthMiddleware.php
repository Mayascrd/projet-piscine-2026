<?php

require_once __DIR__ . '/../utils/Response.php';

class AuthMiddleware
{
    public static function check()
    {
        session_start();

        if(!isset($_SESSION["user_id"]))
        {
            Response::json([
                "message" => "Non autorisé"
            ], 401);
        }
    }
}
