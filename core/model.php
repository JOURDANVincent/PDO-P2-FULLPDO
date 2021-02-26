<?php

class Model {


    //protected $_table = '';
    protected $_pdo;
    protected $_total;


    protected function connect() {

        $server_name = 'localhost';
        $db_name = 'hospitale2n';
        $dsn = "mysql:host=$server_name;dbname=$db_name";
        $server_user = 'hospitale2n';
        $server_password = 'dl6X1gnJpveIGaSh';

        if (is_null($this->_pdo)) { // contrôle si la connexion existe avant de la créer

            $this->_pdo = new PDO(
                $dsn, $server_user, $server_password,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ]
            );

        }
        
        return $this->_pdo; // retourne la connexion
    }

    
    public function get_total() {

        try{  //On essaie de se connecter

            // Préparation de la requête 
            $sql = "SELECT COUNT(`id`) FROM `patients` ";
            $sth = $this->_pdo->query($sql);

            // envoi le nombre de patient enregistré
            return $sth->fetchColumn();
            
        } catch(PDOException $e){  // sinon on capture les exceptions si une exception est lancée et on affiche les informations relatives à celle-ci*/
            
            return false;
        }
        
    }
}