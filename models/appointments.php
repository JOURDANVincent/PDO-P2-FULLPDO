<?php

class Appointments extends Model {

    private $_id;
    private $_dateHour;
    private $_idPatients;
    private $_last_insert_id;
    

    public function __construct($dateHour=null, $idPatients=null, $id=null) {

        $this->_dateHour = $dateHour;
        $this->_idPatients = $idPatients;
        $this->_id = $id;
        $this->_pdo = $this->connect();
    }
    
    public function set_id($id) {

        $this->_idPatients = $id;

        return true;
    }

    public function add_new_appointment() {

        try{  //On essaie de se connecter   
            
            $dateHour = implode(' ',explode('T', $this->_dateHour));

            // insérer le nouveau patient
            $sql = "INSERT INTO `appointments` 
                        (dateHour, IdPatients)
                    VALUES (:dateHour, :idPatients);";
        
            // préparation de la requête
            $sth = $this->_pdo->prepare($sql);

            // association des marqueurs nominatif via méthode bindvalue
            $sth->bindValue(':dateHour', $dateHour, PDO::PARAM_STR);
            $sth->bindValue(':idPatients', $this->_idPatients, PDO::PARAM_INT);

            // envoi la requête préparée
            $result = $sth->execute();

            // on récupère le dernier id
            //self::$last_insert = $this->_pdo->lastInsertId();
            $this->_last_insert_id = $this->_pdo->lastInsertId();

            // retourne le résultat
            return $result;

        } catch(PDOException $e){  // sinon on capture les exceptions si une exception est lancée et on affiche les informations relatives à celle-ci*/
            
            return false;
        }
    }

    public function get_last_insert_id() {

        return $this->_last_insert_id;
    }

    public function get_list($offset = 0, $limit = 10) {
        
        try{  //On essaie de se connecter

            // demande liste des patients
            $sql = "SELECT 
                        `appointments`.`id` AS `idAppointments`, `dateHour`, `lastname`, `firstname`, `mail`, `idPatients`
                    FROM 
                        `appointments` 
                    INNER JOIN 
                        `patients` 
                    ON 
                        `appointments`.`idPatients` = `patients`.`id` 
                    LIMIT 
                        :sql_offset, :sql_limit;";
    
            // déclare une variable qui recoit la réponse
            $sth = $this->_pdo->prepare($sql);

            // association des marqueurs nominatif via méthode bindvalue
            $sth->bindValue(':sql_offset', $offset, PDO::PARAM_INT);
            $sth->bindValue(':sql_limit', $limit, PDO::PARAM_INT);

            // envoi et retourne de la requête préparée
            $sth->execute();

            // traitement et envoi réponse
            return $sth->fetchAll();
            
        } catch(PDOException $e){  // sinon on capture les exceptions si une exception est lancée et on affiche les informations relatives à celle-ci*/
            
            return $e->getCode();
        }
    }

    public static function get_appointment_data($idA, $idP) {
        
        try{  //On essaie de se connecter

            $pdo = Database::connect();

            // demande liste des patients
            $sql = "SELECT 
                        `appointments`.`id` AS `idAppointments`, `dateHour`, `lastname`, `firstname`, `phone`, `mail`, `idPatients`
                    FROM 
                        `appointments` 
                    INNER JOIN 
                        `patients` 
                    ON 
                        `appointments`.`idPatients` = `patients`.`id` 
                    WHERE 
                        (`appointments`.`id` = :idA AND `idPatients` = :idP) ;";
    
            // déclare une variable qui recoit la réponse
            $sth = $pdo->prepare($sql);

            // association des marqueurs nominatif via méthode bindvalue
            $sth->bindValue(':idA', $idA, PDO::PARAM_INT);
            $sth->bindValue(':idP', $idP, PDO::PARAM_INT);

            // exécute la requête préparée
            $sth->execute();

            // traitement et envoi d ela réponse
            return $sth->fetch();
            
        } catch(PDOException $e){  // sinon on capture les exceptions si une exception est lancée et on affiche les informations relatives à celle-ci*/
    
            return $e->getCode();
        }
    }

    public static function get_patients_appointments($idA, $idP) { // à adapter en fonction tousles rdv d'un patient ...
        
        try{  //On essaie de se connecter

            $pdo = Database::connect();

            // demande liste des patients
            $sql = "SELECT 
                        `appointments`.`id` AS `id`, `dateHour`, `lastname`, `firstname`, `phone`, `mail`, `idPatients`
                    FROM 
                        `appointments` 
                    INNER JOIN 
                        `patients` 
                    ON 
                        `appointments`.`idPatients` = `patients`.`id` 
                    WHERE 
                        (`appointments`.`id` = :idA AND `idPatients` = :idP) ;";
    
            // déclare une variable qui recoit la réponse
            $sth = $pdo->prepare($sql);

            // association des marqueurs nominatif via méthode bindvalue
            $sth->bindValue(':idA', $idA, PDO::PARAM_INT);
            $sth->bindValue(':idP', $idP, PDO::PARAM_INT);

            // exécute la requête préparée
            $sth->execute();

            // traitement et envoi d ela réponse
            return $sth->fetch();
            
        } catch(PDOException $e){  // sinon on capture les exceptions si une exception est lancée et on affiche les informations relatives à celle-ci*/
    
            return $e->getCode();
        }
    }

    public function get_total() {

        try{  //On essaie de se connecter

            // Préparation de la requête 
            $sql = "SELECT COUNT(`id`) FROM `appointments`;";
            
            $sth = $this->_pdo->query($sql);

            // envoi le nombre de rendez-vous enregistrés
            return $sth->fetchColumn();
            
        } catch(PDOException $e){  // sinon on capture les exceptions si une exception est lancée et on affiche les informations relatives à celle-ci*/
            
            return $e->getCode();
        }
    }

    public function update_appointment() {

        try{  //On essaie de se connecter   
            
            $dateHour = implode(' ',explode('T', $this->_dateHour));

            // insérer le nouveau patient
            $sql = "UPDATE `appointments`
                    SET
                        `dateHour` = :dateHour, 
                        `idPatients` = :idPatients
                    WHERE 
                        `id` = :id ;";
        
            // préparation de la requête
            $sth = $this->_pdo->prepare($sql);

            // association des marqueurs nominatif via méthode bindvalue
            $sth->bindValue(':dateHour', $dateHour, PDO::PARAM_STR);
            $sth->bindValue(':idPatients', $this->_idPatients, PDO::PARAM_INT);
            $sth->bindValue(':id', $this->_id, PDO::PARAM_INT);

            // envoi et retourne la requête préparée
            return $sth->execute();

        } catch(PDOException $e){  // sinon on capture les exceptions si une exception est lancée et on affiche les informations relatives à celle-ci*/
            
            echo $e->getMessage();
            return false;
        }
    }

    public static function get_patient_appointment($idPatients) {

        try{  //On essaie de se connecter   
            
            $pdo = Database::connect();

            $sql = "SELECT `dateHour` 
                    FROM `appointments`
                    WHERE `idPatients` = :idPatients ;";

            // préparation de la requête
            $sth = $pdo->prepare($sql);

            // association des marqueurs nominatif via méthode bindvalue
            $sth->bindValue(':idPatients', $idPatients, PDO::PARAM_INT);

            // execute requête préparée
            $sth->execute();

            // traitement et envoi d ela réponse
            return $sth->fetchAll();

        } catch(PDOException $e){  // sinon on capture les exceptions si une exception est lancée et on affiche les informations relatives à celle-ci*/
            
            echo $e->getMessage();
            return false;
        }
    }

    public static function del_appointment($idA) {

        try{  //On essaie de se connecter   
            
            $pdo = Database::connect();

            $sql = "DELETE FROM 
                        `appointments`
                    WHERE 
                        `id` = :idA ;";

            // préparation de la requête
            $sth = $pdo->prepare($sql);

            // association des marqueurs nominatif via méthode bindvalue
            $sth->bindValue(':idA', $idA, PDO::PARAM_INT);

            // traitement et envoi d ela réponse
            return $sth->execute();

        } catch(PDOException $e){  // sinon on capture les exceptions si une exception est lancée et on affiche les informations relatives à celle-ci*/
            
            echo $e->getMessage();
            return false;
        }
    }

    public static function del_patient_appointments($idP) {

        try{  //On essaie de se connecter   
            
            $pdo = Database::connect();

            $sql = "DELETE FROM 
                        `appointments`
                    WHERE 
                        `idPatients` = :idP ;";

            // préparation de la requête
            $sth = $pdo->prepare($sql);

            // association des marqueurs nominatif via méthode bindvalue
            $sth->bindValue(':idP', $idP, PDO::PARAM_INT);

            // traitement et envoi d ela réponse
            return $sth->execute();

        } catch(PDOException $e){  // sinon on capture les exceptions si une exception est lancée et on affiche les informations relatives à celle-ci*/
            
            echo $e->getMessage();
            return $e->getCode();
        }
    }
}