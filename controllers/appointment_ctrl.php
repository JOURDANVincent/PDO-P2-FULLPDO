<?php

class Appointment extends Controller {


    private $apapa_data = array();


    public function __construct(){

        $this->load_model('Appointments'); // chargement du model 
    }


    function index(){

        // envoi des données du tableau $array dans la vue
        $this->set($this->layout_data);

        // renvoi la vue index
        $this->render('aptmts_list');
    }

    function add_aptmt(){

        // envoi des données du tableau $array dans la vue
        $this->set($this->layout_data);

        // renvoi la vue index
        $this->render('add_aptmt');
    }

    function update_aptmt(){

        // envoi des données du tableau $array dans la vue
        $this->set($this->layout_data);

        // renvoi la vue index
        $this->render('update_aptmt');
    }

    function aptmt_profile(){

        // envoi des données du tableau $array dans la vue
        $this->set($this->layout_data);

        // renvoi la vue index
        $this->render('aptmt_profile');
    }

    
}
