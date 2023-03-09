<?php

/**
 * EEFFECTUER REQUETE A l'API à l'aide de Curl, Postman, Insomnia
 * create-api.test/produits/modifier.php
 * Envoie des données en JSON avec la la méthode HTTP PUT. 

 * La requête "PUT" utilisée exactement comme décrit dans le standard HTTP doit :
 * Mettre à jour l'enregistrement si il existe
 * Créer l'enregistrement si il n'existe pas
 
{
    "id":67,
    "nom":"Produit1",
    "description":"Nouvelle description modifié du produit",
    "prix":90.00,
    "categories_id":5
 }
 */

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {

    include_once '../config/Database.php';
    include_once '../models/Produits.php';

    $database = new DB();
    $db = $database->getConnection();
    $produit = new Produits($db);
    $donnees = json_decode(file_get_contents("php://input"));

    if (!empty($donnees->id) && !empty($donnees->nom) && !empty($donnees->description) && !empty($donnees->prix) && !empty($donnees->categories_id)) {

        // On hydrate notre objet
        $produit->id = $donnees->id;
        $produit->nom = $donnees->nom;
        $produit->description = $donnees->description;
        $produit->prix = $donnees->prix;
        $produit->categories_id = $donnees->categories_id;

        if ($produit->modifier()) {

            http_response_code(200);
            echo json_encode(["message" => "La modification a été effectuée"]);
        } else {

            http_response_code(503);
            echo json_encode(["message" => "La modification n'a pas été effectuée"]);
        }
    }
} else {
    // Mauvaise méthode, on gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}
