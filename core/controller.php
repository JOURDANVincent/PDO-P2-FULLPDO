<?php

class Controller {

    // tableau de variable commune à l'ensemble des controllers
    private $global_data = array();


    function set($data) {

        // merge des données du controller principale avec controller en cours
        $this->global_data = array_merge($this->global_data, $data);

        // récupère les données à afficher dans la vue
        //$this->global_data = $model_data;
    }

    function render($filename) {

        // extraction des données globales à afficher dans la vue
        extract($this->global_data);

        // recupère le header
        require_once ROOT. 'views/templates/header.php';
        // récupère la vue
        require ROOT. 'views/'.strtolower(get_class($this)).'/'.$filename.'.php';
        // récupère le footer
        require_once ROOT. 'views/templates/footer.php';
    }

    function load_model($modelname){

        // on récupère le fichier contenant le model
        require_once ROOT.'models/'.strtolower($modelname).'.php';

        // controller existance du model avec class_exists
        
        // on instancie le model à utiliser
        $this->$modelname = new $modelname();
    }


    // function get_total() {

    //     $this->total = Model->model->get_total();
    // }

    function paging($offset, $limit, $total) {

        // traitement de limit pour gérer l'affichage
        if ($limit <= 10) {
            $limit = 10;
        } else {
            $limit = 10;
        }

        // traitement de offset pour gérer l'affichage
        if($offset <= 0) {
            $offset = 0;
        } else if ($offset >= $total) {
            $offset = $offset - $limit;
        } 

        $this->offset = $this->global_data['offset'] = $offset;
        $this->limit = $this->global_data['limit'] = $limit;
    }

}