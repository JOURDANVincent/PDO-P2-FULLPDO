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

        // découpe tableau $_GET, injection dans $params
        $params = explode('/', $_GET['params']);

        if (!empty($params[0])) {

            // traitement controller
            $controller = strtolower(trim(filter_var($params[0]), FILTER_SANITIZE_STRING));

        } else {
            // attribution nom de controller par défaut
            $controller = $params[0] = 'home';
        }

        if(is_file(ROOT.'controllers/'.$controller.'_ctrl.php')) { 

            // appel du controller
            require ROOT.'controllers/'.$controller.'_ctrl.php';

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

        if (!empty($params[1])) {

            // traitement de la méthode
            $action = strtolower(trim(filter_var($params[1]), FILTER_SANITIZE_STRING));
        } else {
            // valeur par défaut
            $action = $params[1] = 'index';
        }


        // suppresion variable controller et action de $_GET
        unset($params[0]); unset($params[1]);

        if(method_exists($controller, $action)) {

            //appel méthode du controller
            call_user_func_array(array($controller, $action), $params);

        } else {
            //appel méthode index par défaut
            call_user_func_array(array($controller, 'index'), $params);
        }


    }  catch(PDOException $e){  // levé des exceptions pdo
                
        $pdo_alert['msg'] = $e->getMessage();
        $pdo_alert['code'] = $e->getCode();

        // affichage message erreur
        echo $e->getMessage();

        // direction vers controller par défaut
        header('location: /home/index');
    }

   