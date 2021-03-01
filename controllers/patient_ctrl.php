<?php

class Patient extends Controller {

    use Validator;
    private $layout_data = array();


    public function __construct(){

        $this->sanitize_get_input(); // nettoyage des paramètres recu
        $this->load_model('Patients'); // chargement du model 
    }


    function index(){
        $this->patients_list();
    }


    // function index($offset = 0, $limit = 10, $search = null){
    function patients_list(){

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

            // appel methode hydrate
            $this->Patients->hydrate($this->firstname, $this->lastname, $this->birthdate, $this->phone, $this->mail);
            //var_dump($this->Patients); die;

            // enregistrement en bdd
            if ($this->Patients->add_new_patient()) {

                // affichage profil et message success !
                $last_id = $this->Patients->get_last_insert_id();
                // header('location: index.php?ctrl=3&id='.$this->Patients->last_id.'&lastctrl=1&alert=1');
                header('location: /patient/patient_profile/id='.$last_id.'/lastctrl=1/alert=1');
                
            } else {

                // bdd alert message
                $this->alert_type = 'danger';
                $this->alert_msg = 'L\'adresse email '.$this->mail.' est déjà enregistré en base de données..';

                // renvoi la vue add_patient
                $this->render('add_patient');
            }
        }

        
    }


    function update_patient(){

        // envoi des données du tableau $array dans la vue
        $this->set($this->layout_data);

        // renvoi la vue index
        $this->render('update_patient');
    }


    function patient_profile(){

        // récupère profil patient
        $this->patient_profil = $this->Patients->get_patient_profile($this->id);
        //var_dump($this->patient_profil); die;

        // récupère rdv
        require ROOT. 'models/appointments.php';
        $Appointments = new Appointments();
        $this->patient_appointments = $Appointments->get_patient_appointments($this->id);

        // envoi des données du tableau $array dans la vue
        $this->set($this->layout_data);

        // renvoi la vue index
        $this->render('patient_profile');
    }

}
