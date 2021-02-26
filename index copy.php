<?php

    // chemin d'accès serveur complet
    define('WEBROOT', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));
    define('ROOT', str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']));

    // éléments requis
    require_once ROOT.'app/init.php';

    // appel du controller et du modèle principale
    require_once ROOT.'core/model.php';
    require_once ROOT.'core/controller.php';


    try {

        // on sépare les paramètres reçus
        $params = explode('/', $_GET['params']);

        if (!empty($params[0]) && !empty($params[1])) {

            // traitement controller
            $controller = strtolower(trim(filter_var($params[0], FILTER_SANITIZE_STRING)));
            // valeur par défaut
            $controller = !empty($controller) ? $controller : 'home';

            // traitement de la méthode
            $action = strtolower(trim(filter_var($params[1], FILTER_SANITIZE_STRING)));
            // valeur par défaut
            $action = !empty($action) ? $action : 'index';

            //echo des $_GET
            echo 'controller '.$controller.' et action '.$action;

            if(is_file(ROOT.'controllers/'.$controller.'_ctrl.php')) { 

                // appel du controller
                require ROOT.'controllers/'.$controller.'_ctrl.php';

                if(class_exists($controller)) {

                    // on instancie le controller
                    $controller = new $controller();

                    if(method_exists($controller, $action)) {

                        //appel méthode du controller
                        $controller->$action();

                    } else {

                        //appel méthode index par défaut
                        $controller->index();
                    }

                } else {
                    // création exception
                    throw new PDOException('La class '.$controller.' n\'existe pas');
                }

            } else {
                // création exception
                throw new PDOException('Le fichier demandé n\'existe pas !!');
            }

        } else {
            // création exception
            header('location: /home/index');
        }


    }  catch(PDOException $e){  // levé des exceptions pdo
                
        $pdo_alert['msg'] = $e->getMessage();
        $pdo_alert['code'] = $e->getCode();

        // affichage message erreur
        echo $e->getMessage();

        // direction vers controller par défaut
        header('location: /home/index');
    }

   