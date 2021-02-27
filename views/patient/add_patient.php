
<!-- Start Main Row -->
<div class="row h-100 justify-content-center align-items-center">

    <img id="wall" class="img-fluid text-center" src="/assets/img/crazyPatient.jpg" alt="Photo du chu d'amiens">

    <?php if(!empty($alert_msg)) : ?>
        <div class="col-12 alert alert-<?= $alert_type ?? 'danger' ?> alert-dismissible align-self-start">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?= $alert_msg ?>
        </div>
    <?php endif ?>

    <div id="mainContent" class="form-group col-12 col-lg-5 bdc1 bl8 bg22 sha1 bgForm px-4 py-3">

        <!------------------------------------------ nouveau patient ------------------------------------------------>

        <form action="" method="POST">

            <fieldset class="mb-2">

                <h1 class="py-3 text-center txtW">Nouveau patient</h1>

                <div class="form-inline">
                    <input 
                        class="form-control col <?= (!empty($this->form_check['lastname'])) ? 'bgError' : '' ;?> mb-2 mr-3" 
                        type="text" 
                        name="lastname" 
                        placeholder="nom" 
                        value="<?= $this->lastname ?? '' ;?>"
                        pattern ="^[a-zA-Z\-][^0-9]{2,}$" 
                        title="2 lettres mini / aucun chiffre ou caractères spéciaux"
                    >
                    <input 
                        class="form-control col <?= (!empty($this->form_check['firstname'])) ? 'bgError' : '' ;?> mb-2 ml-3" 
                        type="text" 
                        name="firstname" 
                        placeholder="prénom" 
                        value="<?= $this->firstname ?? '' ;?>"
                        required pattern ="^[a-zA-Z\-][^0-9]{2,}$" title="2 lettres mini / aucun chiffre ou caractères spéciaux"
                    >
                </div>

                <div class="form-inline">
                    <div class="txt1 mb-2 mt-0 mr-3"><?= $this->form_check['lastname'] ?? '' ;?></div>
                    <div class="txt1 mb-2 mt-0 ml-3"><?= $this->form_check['firstname'] ?? '' ;?></div>
                </div>

                <div class="form-inline">
                    <input 
                        class="form-control col <?= (!empty($this->form_check['birthdaybirthdate'])) ? 'bgError' : '' ;?> mb-2 mr-3" 
                        type="date" 
                        name="birthdate" 
                        placeholder="jj-mm-aaaa" 
                        value="<?= $this->birthdate ?? '' ;?>"
                        required  
                        title="format jj-mm-aaaa (ex: 20/12/1983)"
                    > 
                    <input class="form-control col <?= (!empty($this->form_check['phone'])) ? 'bgError' : '' ;?> mb-2 ml-3" 
                        type="phone" 
                        name="phone" 
                        placeholder="téléphone" 
                        value="<?= $this->phone ?? '' ;?>"
                        pattern="^(0|\+33)[1-9]( *[0-9]{2}){4}$" 
                        title="ex: 06-12-34-56-78"
                    >
                </div>

                <div class="form-inline">
                    <div class="txt1 col mb-2 mt-0 mr-3"><?= $this->form_check['birthdate'] ?? '' ;?></div>
                    <div class="txt1 col mb-2 mt-0 ml-3"><?= $this->form_check['phone'] ?? '' ;?></div>
                </div>

                <input 
                    class="form-control <?= !empty($alert_msg) ? 'bgError' : '' ;?> mb-2" 
                    type="email" name="mail" 
                    placeholder="email" 
                    value="<?= $this->mail ?? '' ;?>"
                    required pattern="^[\w-\.]+@([\w-]+\.)+\.[\w-]{2,5}$" 
                    title="ex: contact@moi.fr"
                >
                <div class="txt1 mb-2 mt-0 pl-3"><?= $this->form_check['mail'] ?? '' ;?></div>

            </fieldset>  

            <!------------------------------------------ submit ------------------------------------------------>
            <div class="text-center my-4">
                <input type="hidden" name="ctrl" value="patient">
                <input type="hidden" name="action" value="add_patient_check">
                <input class="btn bg1 bdc1 px-5" type="submit" value="ajouter">
            </div>  

        </form>

    </div>

</div>