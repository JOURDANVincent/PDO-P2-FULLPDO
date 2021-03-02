<?php

// appel fichier constantes regex
require_once ROOT. 'app/regex.php';

trait Validator {


    protected $form_check = array();


    function sanitize_get_input(){

        $this->limit = intval(trim(filter_input(INPUT_GET, 'limit', FILTER_SANITIZE_NUMBER_INT)));
        $this->offset = intval(trim(filter_input(INPUT_GET, 'offset', FILTER_SANITIZE_NUMBER_INT)));
        $this->search = trim(filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING));
        $this->id = intval(trim(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT)));
        $this->lastctrl = intval(trim(filter_input(INPUT_GET, 'lastctrl', FILTER_SANITIZE_NUMBER_INT)));
    
        return true;
    }

    function sanitize_post_input(){

        $this->firstname = trim(filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING));
        $this->lastname = trim(filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING));
        $this->birthdate = trim(filter_input(INPUT_POST, 'birthdate', FILTER_SANITIZE_STRING));
        $this->phone = trim(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING));
        $this->mail = trim(filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_EMAIL));

        return true;
    }

    function check_form_data(){

        //nettoyage du post
        $check = $this->sanitize_post_input();

        if($check){
            // controle si champs vides
            $check = $this->is_field_empty();
        }

        if(!$check){
            // controle si champs valides
            $check = $this->is_field_match();
        }

        //var_dump($check); die;

        return $check;
    }

    function is_field_empty(){

        foreach($_POST as $var => $value){

            if (empty($value)){
                $this->form_check[$var] = '* champ obligatoire';
            }
        }

        return $this->form_check;
    }

    function is_field_match(){

        // traitement input lastname
        if (!preg_match(R_STR ,$this->lastname)) {
            $this->form_check['lastname'] = 'données invalides';
        }
        
        // traitement input firstname
        if (!preg_match(R_STR ,$this->firstname)) {
            $this->form_check['firstname'] = 'données invalides';
        }

        // traitement input birthdate
        if (!preg_match(R_DATE ,$this->birthdate)) {
            $this->form_check['birthdate'] = 'données invalides';
        }

        // traitement input mail //
        if (!filter_var($this->mail, FILTER_VALIDATE_EMAIL)) {
            $this->form_check['mail'] = '* L\'email n\'est pas valide';
        }

        // traitement input phone
        if (!preg_match(R_PHONE ,$this->phone)) {
            $this->form_check['phone'] = 'données invalides';
        }
       
        return $this->form_check;
    }
}