<?php


class Controller {

    // tableau de variable commune à l'ensemble des controllers
    private $global_data = array();


    function set($data) {

        // merge des données du controller principale avec controller en cours
        $this->global_data = array_merge($this->global_data, $data);
    }

    function render($filename) {

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
        
        // on instancie le model à utiliser
        $this->$modelname = new $modelname();
    }

    function paging() {

        // traitement de limit pour gérer l'affichage
        if ($this->limit <= 10) {
            $this->limit = 10;
        } 

        // traitement de offset pour gérer l'affichage
        if($this->offset <= 0) {
            $this->offset = 0;
        } else if ($this->offset >= $this->total) {
            $this->offset = $this->offset - $this->limit;
        } 

    }

}