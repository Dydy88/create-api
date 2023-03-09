<?php

namespace App;

class Config {

    private $settings  = [];       //Stock notre fichier de configuration
    private static $_instance;     //Contient l'instance unique de notre Class


    //La méthode statique qui permet d'instancier ou de récupérer l'instance unique
    public static function getInstance(){

        //Si l'instance n'existe pas, je l'effectue.
        if(is_null(self::$_instance)){
            self::$_instance = new Config();
        }
        //On retourne l'instance de notre proprité.
        return self::$_instance;
    }


    //Le constrcuteur avec sa logique est privé pour émpêcher l'instanciation en dehors de la classe
    private function __construct(){
        //$this->id = uniqid();
        $this->settings = require dirname(__DIR__) . '/config.php';
    }


    //Récupère une Clé dans le tableau de Config 
    public function get($key)
{
        //Si la clé n'existe pas on retourne null.
        if(!isset($this->settings[$key])){
            return null;
        }
        return $this->settings[$key];
    }

}