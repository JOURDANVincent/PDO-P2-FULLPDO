<?php

class Model {

    public static $pdo = null;


    public static function connect() {

        $server_name = 'localhost';
        $db_name = 'hospitale2n';
        $dsn = "mysql:host=$server_name;dbname=$db_name";
        $server_user = 'hospitale2n';
        $server_password = 'dl6X1gnJpveIGaSh';

        if (is_null(self::$pdo)) {

            self::$pdo = new PDO(
                $dsn, $server_user, $server_password,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ]
            );

        }
        
        return self::$pdo;
    }


        // public function connect() {

    //     $server_name = 'localhost';
    //     $db_name = 'hospitale2n';
    //     $dsn = "mysql:host=$server_name;dbname=$db_name";
    //     $server_user = 'hospitale2n';
    //     $server_password = 'dl6X1gnJpveIGaSh';

    //     if (is_null($this->_pdo)) {

    //         $this->_pdo = new PDO(
    //             $dsn, $server_user, $server_password,
    //             [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    //             PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ]
    //         );

    //     }
        
    //     return $this->_pdo;
    // }


}