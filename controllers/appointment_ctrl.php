<?php

class Appointment extends Controller {

    use Validator;
    private $layout_data = array();


    public function __construct(){

        $this->sanitize_get_input(); // nettoyage des paramètres recu
        $this->load_model('Appointments'); // chargement du model 
    }


    function index(){

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

        // charge model Patients
        $this->load_model('Patients');

        // demande de liste patient
        $limit = $this->Patients->get_total();

        // demande de liste patient
        $this->patients_list = $this->Patients->get_list(0,$limit);

        // récuper date et heur actuelle
        $this->actual_date = implode('T',explode(' ', date('Y-m-d H:i')));

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
