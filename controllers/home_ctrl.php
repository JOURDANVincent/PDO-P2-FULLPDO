<?php

class Home extends Controller {

    public $initial_data = array(

        'title' => 'Accueil'
    );

    function index(){

        // chargement du model 
        //$this->load_model('home');

        // envoi des données du tableau $array dans la vue
        $this->set($this->initial_data);

        // renvoi la vue index
        $this->render('home');
    }
}


