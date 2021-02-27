<?php

    // chemin d'accès serveur complet
    define('WEBROOT', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));
    define('ROOT', str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']));

    // éléments requis
    require_once ROOT.'app/init.php';

    // appel du controller et du modèle principale
    require_once ROOT.'core/model.php';
    require_once ROOT.'core/controller.php';
    require_once ROOT.'core/validator_trait.php';


    //var_dump($_POST);

    try {

        if (!empty($_GET['ctrl']) || !empty($_POST['ctrl'])) {

            // traitement controller
            $controller = ucfirst(trim(filter_input($request_method,'ctrl', FILTER_SANITIZE_STRING)));

        } else {
            // attribution nom de controller par défaut
            $controller = 'home';
        }

        echo $controller;

        if(is_file(ROOT.'controllers/'.strtolower($controller).'_ctrl.php')) { 

            // appel du controller
            require ROOT.'controllers/'.strtolower($controller).'_ctrl.php';

        } else {
            // appel controlleur par défaut
            require ROOT.'controllers/home_ctrl.php';
        }

        if(class_exists($controller)) {

            // on instancie le controller
            $controller = new $controller();

        } else {
            // on instancie le controller Home par défaut
            $controller = new Home();
        }

        if (!empty($_GET['action']) || !empty($_POST['action'])) {

            // traitement de la méthode
            $action = strtolower(trim(filter_input($request_method, 'action'), FILTER_SANITIZE_STRING));
        } else {
            // valeur par défaut
            $action = 'index';
        }


        if(method_exists($controller, $action)) {

            //appel méthode du controller
            $controller->$action();

        } else {
            //appel méthode index par défaut
            $controller->index();
        }


    }  catch(PDOException $e){  // levé des exceptions pdo
                
        $pdo_alert['msg'] = $e->getMessage();
        $pdo_alert['code'] = $e->getCode();

        // affichage message erreur
        echo $e->getMessage();

        // direction vers controller par défaut
        echo 'catch'; die;
        header('location: /home/index');
    }

   