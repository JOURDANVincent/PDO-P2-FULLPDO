<!-- Start Main Row -->
<div id='' class="row h-100 justify-content-center align-items-center">

    <img id="wall" class="img-fluid text-center" src="/assets/img/psyWall.jpg" alt="Photo du chu d'amiens">

    <?php if(!empty($alert_msg)) : ?>
        <div class="col-12 alert alert-<?= $alert_type ?? 'danger' ?> alert-dismissible align-self-start">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?= $alert_msg ?>
        </div>
    <?php endif ?>

    <div class="col-4 justify-content-center">
        <div class="card pt-4 bl8 bdc1 sha1 bg22 txtW" >

            <h1 class="text-center">Profil patient</h1>

            <div class="text-center">
                <!-- <img class="card-img-top img-fluid" style="max-width:150px;" src="assets/icon/medical-records.svg" alt="logo raport"> -->
            </div>

            <div class="card-body row mt-3">
                <div class="col-6">
                    <h5 class="card-title">Informations</h5>
                    <div>nom <span class="txt1"><?= $this->patient_profil->lastname?></span></div>
                    <div>prenom <span class="txt1"><?= $this->patient_profil->firstname?></span></div>
                    <div>date de naissance <span class="txt1"><?= $this->patient_profil->birthdate?></span></div>
                    <div>téléphone <span class="txt1"><?= $this->patient_profil->phone?></span></div>
                    <div>email <span class="txt1"><?= $this->patient_profil->mail?></span></div>
                </div>

                <div class="col-6">
                    <h5 class="card-title">Liste des rendez-vous</h5>
                    <?php if (empty($this->patient_appointments)) : ?>
                        <div>Aucun rendez-vous..</div>
                    <?php else : foreach($this->patient_appointments as $appointment) : ?>
                        <div><?= date('d-m-Y', strtotime($appointment->dateHour)) ?><span class="txt1"> à </span><?= date('H:i', strtotime($appointment->dateHour)) ?></div>
                    <?php endforeach; endif ?>
                </div>

                <div class="col-12 text-center">
                    <?php if ($this->lastctrl) : ?>
                        <a href="/home/index" class="btn bgW mt-4 mr-3 px-4">Accueil</a>
                    <?php else : ?>
                        <a href="/patient/patients_list" class="btn bgW mt-4 mr-3 px-4">Retour</a>
                    <?php endif ?>
                    <a href="index.php?ctrl=4&id=<?= $this->patient_profil->id ?>" class="btn bg1 bdc1 mt-4 px-4">Modifier</a>
                </div>
                
            </div>

        </div>
    </div>
</div>