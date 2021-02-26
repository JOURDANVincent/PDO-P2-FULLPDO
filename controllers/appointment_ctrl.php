<?php

class Appointment extends Controller {


    private $layout_data = array();


    public function __construct(){

        $this->load_model('Appointments'); // chargement du model 
    }


    function index($offset = 0, $limit = 10, $search = null){

        // nettoyage des paramètres recu
        $this->check_input($offset, $limit, $search);

        // envoi des données du tableau $array dans la vue
        $this->total = $this->Appointments->get_total();

        // fonction pagination
        $this->paging();

        // demande de liste patient
        $this->appointments_list = $this->Appointments->get_list($this->offset, $this->limit);

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
