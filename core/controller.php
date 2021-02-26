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

    function paging() {

        // traitement de limit pour gérer l'affichage
        if ($this->limit <= 10) {
            $this->limit = 10;
        } else {
            $this->limit = 10;
        }

        // traitement de offset pour gérer l'affichage
        if($this->offset <= 0) {
            $this->offset = 0;
        } else if ($this->offset >= $this->total) {
            $this->offset = $this->offset - $this->limit;
        } 

    }

    function check_input($offset, $limit, $search){

        $this->limit = intval(trim(filter_var($limit, FILTER_SANITIZE_NUMBER_INT)));
        $this->offset = intval(trim(filter_var($offset, FILTER_SANITIZE_NUMBER_INT)));
        $this->search = trim(filter_var($search, FILTER_SANITIZE_STRING));
    }

}