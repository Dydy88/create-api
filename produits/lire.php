<?php

/**
 * EEFFECTUER REQUETE A l'API ç l'aide de Curl, Postman, Insomnia
 * create-api.test/produits/lire.php
 */

// Accès depuis n'importe quel site ou appareil (*)
header("Access-Control-Allow-Origin: *");
// Format des données envoyées
header("Content-Type: application/json; charset=UTF-8");
// Méthode autorisée
header("Access-Control-Allow-Methods: GET");
// Durée de vie de la requête
header("Access-Control-Max-Age: 3600");
// Entêtes autorisées
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// Si la bonne méthode est utilisée
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // On inclut les fichiers de configuration et d'accès aux données
    include_once '../config/Database.php';
    include_once '../models/Produits.php';

    // On instancie la base de données
    $database = new DB();
    $db = $database->getConnection();

    // On instancie les produits avec la connexion à la base de donnée.
    $produit = new Produits($db);

    // On récupère les données sous forme de statement
    $stmt = $produit->lire();

    // On vérifie si on a au moins 1 produit
    if ($stmt->rowCount() > 0) {

        // On parcourt les produits avec fetch ou fetchAll
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            //On extrait les données dans un tableau associatif
            extract($row);

            $prod = [
                "id" => $id,
                "nom" => $nom,
                "description" => $description,
                "prix" => $prix,
                "categories_id" => $categories_id,
                "categories_nom" => $categories_nom
            ];

            // On initialise un tableau associatif ou l'on stocke les données de la base de donnée.
            $tableauProduits['produits'][] = $prod;
        }
        // On envoie le code réponse 200 OK et on encode en json et on envoie
        http_response_code(200);
        echo json_encode($tableauProduits);
    }
} else {
    // Mauvaise méthode, on gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}
