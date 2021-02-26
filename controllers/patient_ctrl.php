<?php

class Patient extends Controller {


    private $layout_data = array();


    public function __construct(){

        $this->load_model('Patients'); // chargement du model 
    }


    function index($offset = 0, $limit = 10, $search = null){

        // nettoyage des paramètres recu
        $this->check_input($offset, $limit, $search);

        // récupère le nombre total de patient
        $this->total = $this->Patients->get_total();

        // fonction pagination
        $this->paging();

        // demande de liste patient
        $this->patients_list = $this->Patients->get_list($this->offset, $this->limit);

        // renvoi la vue index
        $this->render('patients_list');
    }


    function add_patient(){

        // envoi des données du tableau $array dans la vue
        $this->set($this->layout_data);

        // renvoi la vue index
        $this->render('add_patient');
    }

    function update_patient(){

        // envoi des données du tableau $array dans la vue
        $this->set($this->layout_data);

        // renvoi la vue index
        $this->render('update_patient');
    }

    function patient_profile(){

        // envoi des données du tableau $array dans la vue
        $this->set($this->layout_data);

        // renvoi la vue index
        $this->render('patient_profile');
    }

}
