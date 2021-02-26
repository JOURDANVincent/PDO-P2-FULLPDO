<?php

class Patients extends Model {

    var $table = 'test table';

    private $_id;
    private $_lastname;
    private $_firstname;
    private $_birthdate;
    private $_phone;
    private $_mail;
    private $_last_insert_id;
    static $total_patient;
    private $_pdo;


    public function __construct($lastname=null, $firstname=null, $birthdate=null, $phone=null, $mail=null, $id=null) {

        $this->_lastname = $lastname;
        $this->_firstname = $firstname;
        $this->_birthdate = $birthdate;
        $this->_phone = $phone;
        $this->_mail = $mail;
        $this->_pdo = Model::connect();
    }
    
    public function add_new_patient() {

        try{  //On essaie de se connecter

            // insérer le nouveau patient
            $sql = "INSERT INTO `patients` 
                        (lastname, firstname, birthdate, phone, mail)
                    VALUES 
                        (:lastname, :firstname, :birthdate, :phone, :mail);";
        
            // préparation de la requête
            $sth = $this->_pdo->prepare($sql);

            // association des marqueurs nominatif via méthode bindvalue
            $sth->bindValue(':lastname', $this->_lastname, PDO::PARAM_STR);
            $sth->bindValue(':firstname', $this->_firstname, PDO::PARAM_STR);
            $sth->bindValue(':birthdate', $this->_birthdate, PDO::PARAM_STR);
            $sth->bindValue(':phone', $this->_phone, PDO::PARAM_STR);
            $sth->bindValue(':mail', $this->_mail, PDO::PARAM_STR);

            // éxecute requête
            $result = $sth->execute();

            // récupère dernier id
            $this->_last_insert_id = $this->_pdo->lastInsertId();

            // envoi et retourne la requête préparée
            return $result;
            
        } catch(PDOException $e){  // sinon on capture les exceptions si une exception est lancée et on affiche les informations relatives à celle-ci*/

            return false;
        }
    }

    public static function add_patient_and_appointment($patient, $appointment) {

        try{  //On essaie de se connecter

            $pdo = Database::connect();

            // debut de transaction
            $pdo->beginTransaction();

            //ajout patient
            if(!$patient->add_new_patient()) {
                throw new PDOException('error_mail');
            }

            // on réécrit l'id dans l'objet $appointment
            if(!$appointment->set_id($patient->_last_insert_id)) {
                throw new PDOException('error_id');
            }

            // ajout rendez-vous
            if(!$appointment->add_new_appointment()) {
                throw new PDOException('error_datetime');
            }

            // fin de transaction
            $pdo->commit();

            // envoi liste des patients
            return true;
            
        } catch(PDOException $e){  // sinon on capture les exceptions si une exception est lancée et on affiche les informations relatives à celle-ci*/
            
            //retour arrière transaction
            $pdo->rollBack();

            return $e->getMessage();
        }
    }

    public function get_last_insert_id() {

        return $this->_last_insert_id;
    }

    public static function get_list($offset = 0, $limit = 10) {

        try{  //On essaie de se connecter

            $pdo = Model::connect();

            // demande liste des patients
            $sql = "SELECT * FROM `patients` LIMIT :sql_offset, :sql_limit ;";
    
            // déclare une variable qui recoit la réponse
            $sth = $pdo->prepare($sql);

            // association des marqueurs nominatif via méthode bindvalue
            $sth->bindValue(':sql_offset', $offset, PDO::PARAM_INT);
            $sth->bindValue(':sql_limit', $limit, PDO::PARAM_INT);

            // exécute la requête préparée
            $sth->execute();

            // envoi liste des patients
            return $sth->fetchAll();
            
        } catch(PDOException $e){  // sinon on capture les exceptions si une exception est lancée et on affiche les informations relatives à celle-ci*/
            
            return $e->getCode();
        }
        
    }

    public static function get_total_patients() {

        try{  //On essaie de se connecter

            $pdo = Database::connect();

            // Préparation de la requête 
            $sql = "SELECT COUNT(`id`) FROM `patients`;";
            $sth = $pdo->query($sql);

            // envoi le nombre de patient enregistré
            return $sth->fetchColumn();
            
        } catch(PDOException $e){  // sinon on capture les exceptions si une exception est lancée et on affiche les informations relatives à celle-ci*/
            
            return $e->getCode();
        }
        
    }

    public static function get_patient_profil($id) {

        try{  //On essaie de se connecter

            $pdo = Database::connect();

            // demande liste des patients
            $sql = "SELECT * FROM `patients` WHERE `id` = :id ;";
    
            // préparation de la requête
            $sth = $pdo->prepare($sql);

            // association des marqueurs nominatif via méthode bindvalue
            $sth->bindValue(':id', $id, PDO::PARAM_INT);

            // envoi de la requête préparée
            $sth->execute();

            // envoi du profil demandé
            return $sth->fetch();
            
        } catch(PDOException $e){  // sinon on capture les exceptions si une exception est lancée et on affiche les informations relatives à celle-ci*/
            
            return $e->getCode();
        }

    }

    public function update_patient() {

        try{  //On essaie de se connecter

            // insérer le nouveau patient
            $sql = "UPDATE `patients`
                    SET 
                        `lastname` = :lastname,
                        `firstname` = :firstname,
                        `birthdate` = :birthdate,
                        `phone` = :phone,
                        `mail` = :mail
                    WHERE 
                        `id` = :id ;";
        
            // préparation de la requête
            $sth = $this->_pdo->prepare($sql);

            // association des marqueurs nominatif via méthode bindvalue
            $sth->bindValue(':lastname', $this->_lastname, PDO::PARAM_STR);
            $sth->bindValue(':firstname', $this->_firstname, PDO::PARAM_STR);
            $sth->bindValue(':birthdate', $this->_birthdate, PDO::PARAM_STR);
            $sth->bindValue(':phone', $this->_phone, PDO::PARAM_STR);
            $sth->bindValue(':mail', $this->_mail, PDO::PARAM_STR);
            $sth->bindValue(':id', $this->_id, PDO::PARAM_INT);

            // envoi et retourne la requête préparée
            return $sth->execute();
            
        } catch(PDOException $e){  // sinon on capture les exceptions si une exception est lancée et on affiche les informations relatives à celle-ci*/
            
            return false;
        }
        
    }

    public static function del_patient_data($idP) {

        try{  //On essaie de se connecter   
            
            $pdo = Database::connect();

            $sql = "DELETE FROM 
                        `patients`
                    WHERE 
                        `id` = :idP ;";

            // préparation de la requête
            $sth = $pdo->prepare($sql);

            // association des marqueurs nominatif via méthode bindvalue
            $sth->bindValue(':idP', $idP, PDO::PARAM_INT);

            // traitement et envoi d ela réponse
            return $sth->execute();

        } catch(PDOException $e){  // sinon on capture les exceptions si une exception est lancée et on affiche les informations relatives à celle-ci*/
            
            echo $e->getMessage();
            return false;
        }
    }

    public static function get_total_patients_search($search) {

        try{  //On essaie de se connecter   
            
            $pdo = Database::connect();

            $sql = "SELECT count(*) 
                    AS `total` 
                    FROM `patients`
                    WHERE 
                        (`lastname` LIKE :ln OR `firstname` LIKE :fn OR `mail` LIKE :ml) ;";

            // préparation de la requête
            $sth = $pdo->prepare($sql);

            // association des marqueurs nominatif via méthode bindvalue
            $sth->bindValue(':ln', '%'.$search.'%', PDO::PARAM_STR);
            $sth->bindValue(':fn', '%'.$search.'%', PDO::PARAM_STR);
            $sth->bindValue(':ml', '%'.$search.'%', PDO::PARAM_STR);

            // traitement et envoi d ela réponse
            $sth->execute();

            return $sth->fetch();

        } catch(PDOException $e){  // sinon on capture les exceptions si une exception est lancée et on affiche les informations relatives à celle-ci*/
            
            echo $e->getMessage();
            return false;
        }
    }

    public static function get_patient_search($search, $offset = 0, $limit = 10) {

        try{  //On essaie de se connecter   
            
            $pdo = Database::connect();

            $sql = "SELECT * FROM 
                        `patients`
                    WHERE 
                        (`lastname` LIKE :ln OR `firstname` LIKE :fn OR `mail` LIKE :ml) 
                    LIMIT :sql_offset, :sql_limit;";

            // préparation de la requête
            $sth = $pdo->prepare($sql);

            // association des marqueurs nominatif via méthode bindvalue
            $sth->bindValue(':ln', '%'.$search.'%', PDO::PARAM_STR);
            $sth->bindValue(':fn', '%'.$search.'%', PDO::PARAM_STR);
            $sth->bindValue(':ml', '%'.$search.'%', PDO::PARAM_STR);
            $sth->bindValue(':sql_offset', $offset, PDO::PARAM_INT);
            $sth->bindValue(':sql_limit', $limit, PDO::PARAM_INT);

            // traitement et envoi d ela réponse
            $sth->execute();

            return $sth->fetchAll();

        } catch(PDOException $e){  // sinon on capture les exceptions si une exception est lancée et on affiche les informations relatives à celle-ci*/
            
            echo $e->getMessage();
            return false;
        }
    }

}