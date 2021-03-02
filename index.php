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


    try {

        // traitement controller
        $controller = ucfirst(trim(filter_input($request_method,'ctrl', FILTER_SANITIZE_STRING)));
        $controller = !empty($controller) ? $controller : 'home';

        // chargement du fichier requis
        $file = ROOT.'controllers/'.strtolower($controller).'_ctrl.php';
        is_file($file) ? require $file : require ROOT.'controllers/home_ctrl.php';

        // on instancie le controller
        $controller = class_exists($controller) ? new $controller() : new Home();

        // traitement action
        $action = strtolower(trim(filter_input($request_method, 'action'), FILTER_SANITIZE_STRING));
        $action = !empty($action) ? $action : 'index';

        // appel méthode du controller
        method_exists($controller, $action) ? $controller->$action() : $controller->index();


    }  catch(PDOException $e){  // levé des exceptions pdo
                
        $pdo_alert['msg'] = $e->getMessage();
        $pdo_alert['code'] = $e->getCode();

        // affichage message erreur
        echo $e->getMessage();

        // direction vers controller par défaut
        echo 'catch'; die;
        header('location: /home/index');
    }

   