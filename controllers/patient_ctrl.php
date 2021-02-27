<?php

class Patient extends Controller {

    use Validator;
    private $layout_data = array();


    public function __construct(){

        $this->load_model('Patients'); // chargement du model 
    }


    // function index($offset = 0, $limit = 10, $search = null){
    function index(){

        // nettoyage des paramètres recu
        $this->sanitize_get_input();

        // récupère le nombre total de patient
        $this->total = $this->Patients->get_total();

        // fonction pagination
        $this->paging();

        // demande de liste patient
        $this->patients_list = $this->Patients->get_list($this->offset, $this->limit);

        // renvoi la vue patients_list
        $this->render('patients_list');
    }

    function add_patient_view(){

        // renvoi la vue add_patient
        $this->render('add_patient');
    }

    function add_patient_check(){

        if($this->check_form_data()){

            // envoi des données du tableau $array dans la vue
            $this->set($this->layout_data);

            // renvoi la vue add_patient
            $this->render('add_patient');
            
        } else {
            // redirection
            header('location: /home/index');
        }

        
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
