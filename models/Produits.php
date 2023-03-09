<?php

class Produits
{
    // Connexion
    private $connexion;
    private $table = "produits"; // Table dans la base de données

    // Propriétés
    public $id;
    public $nom;
    public $description;
    public $prix;
    public $categories_id;
    public $categories_nom;
    public $created_at;

    
    /**
     * Constructeur avec $db, qui réprésente l'instance pour la connexion à la base de données
     * @param $db
     */

    public function __construct($db)
    {
        $this->connexion = $db;
    }


    /**
     * Lecture des produits  @return void
     */

    public function lire()
    {
        // On écrit la requête
        $sql = "SELECT c.nom as categories_nom, p.id, p.nom, p.description, p.prix, p.categories_id, p.created_at FROM "
            . $this->table . " p LEFT JOIN categories c ON p.categories_id = c.id ORDER BY p.created_at DESC";

        // On prépare et on execute la requête puis on retourne le résultat
        $query = $this->connexion->prepare($sql);
        $query->execute();
        return $query;
    }



    /**
     * Créer un produit
     * @return void
     */

    public function creer()
    {

        // Ecriture de la requête SQL en y insérant le nom de la table
        $sql = "INSERT INTO " . $this->table . " SET nom=:nom, prix=:prix, description=:description, 
        categories_id=:categories_id";

        // Préparation de la requête
        $query = $this->connexion->prepare($sql);

        // Protection contre les injections
        $this->nom = htmlspecialchars($this->nom));
        $this->prix = htmlspecialchars($this->prix));
        $this->description = htmlspecialchars($this->description));
        $this->categories_id = htmlspecialchars($this->categories_id));

        // Ajout des données protégées
        $query->bindParam(":nom", $this->nom);
        $query->bindParam(":prix", $this->prix);
        $query->bindParam(":description", $this->description);
        $query->bindParam(":categories_id", $this->categories_id);

        // Exécution de la requête
        if ($query->execute()) {
            return true;
        }
        return false;
    }


    /**
     * Supprimer un produit
     * @return void
     */

    public function supprimer()
    {
        // On prepare et on exécute la requete (synthaxe alternative)
        $query = $this->connexion->prepare("DELETE FROM $this->table WHERE id = ?");
        $query->execute([$this->id]);
        $count = $query->rowCount();

        //RowCount, retourne le nombre de ligne affecté par la dernière requete.
        //Si aucune ligne n'a été affecté celà signifie que l'ID passé en paramètre ,e correspond a aucun élément.
        if($count > 0){
            return true;
        }
        return false;
    
    }


    /**
     * Mettre à jour un produit
     * @return void
     */

    public function modifier()
    {
        // On écrit la requête
        $sql = "UPDATE " . $this->table . " SET nom = :nom, prix = :prix, description = :description, categories_id = :categories_id WHERE id = :id";
        $query = $this->connexion->prepare($sql);

        // On sécurise les données
        $this->nom = htmlspecialchars($this->nom));
        $this->prix = htmlspecialchars($this->prix));
        $this->description = htmlspecialchars($this->description));
        $this->categories_id = htmlspecialchars($this->categories_id));
        $this->id = htmlspecialchars($this->id));

        // On attache les variables
        $query->bindParam(':nom', $this->nom);
        $query->bindParam(':prix', $this->prix);
        $query->bindParam(':description', $this->description);
        $query->bindParam(':categories_id', $this->categories_id);
        $query->bindParam(':id', $this->id);

        // On exécute
        if ($query->execute()) {
            return true;
        } 
        return false;
    }
    
}
