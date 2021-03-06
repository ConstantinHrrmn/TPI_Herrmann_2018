<?php
/*******************************************************************************
AUTEUR      : Constantin Herrmann
LIEU        : CFPT Informatique Genève
DATE        : 14.06.2018

TITRE PROJET: KidsGames Geneva Score

TITRE PAGE  : adminStaff
DESCRIPTION : Cette page permet à un administrateur de gérer les membres du staff
VERSION     : 1.0
*******************************************************************************/

// On vérifie si l'utilisateur est connecté et qu'il s'agit bien d'un administrateur
include "php/functions.inc.php";

$edit = false;
$staff = null;

// On vérifie si l'utilisateur est connecté et qu'il s'agit bien d'un administrateur
if (!isset($_SESSION['user']) || $_SESSION['user']['idRole'] != "1") {
  header("Location: index.php");
  exit;
}else {
  // on récupères tout les rôles
  $roles = GetAllRoles();
}

// Regarde si le bouton ajouter à été appuyer
if(filter_has_var(INPUT_POST, "ajouter")){
  // On filtre toutes les données
  $nom = trim(filter_input(INPUT_POST, "nom", FILTER_SANITIZE_STRING));
  $prenom = trim(filter_input(INPUT_POST, "prenom", FILTER_SANITIZE_STRING));
  $idRole = trim(filter_input(INPUT_POST, "role", FILTER_SANITIZE_STRING));

  $role = GetRoleById($idRole);

  if ($nom != null && $prenom != null && $role != false) {
    // On ajoute un nouveau membre du staff
    AddStaff($nom, $prenom, $idRole);
  }else{
    $message = "Veuillez remplir tout les champs";
    echo "<script type='text/javascript'>alert('$message');</script>";
  }
}

// Regarde si le bouton modifier à été appuyer
if(filter_has_var(INPUT_POST, "modifier")){
  // On filtre les données
  $nom = trim(filter_input(INPUT_POST, "nom", FILTER_SANITIZE_STRING));
  $prenom = trim(filter_input(INPUT_POST, "prenom", FILTER_SANITIZE_STRING));
  $idRole = trim(filter_input(INPUT_POST, "role", FILTER_SANITIZE_STRING));

  // On met à jour le staff
  UpdateStaff($_SESSION['staff_to_change']['id'], $nom, $prenom, $idRole);

  // On remet la variable de la session à null
  $_SESSION['staff_to_change'] = NULL;
}

if (isset($_SESSION['staff_to_change']) && $_SESSION['staff_to_change'] != NULL) {
  $edit  = true;
  // Le staff devvient le staff qui ce trouve dans la session
  $staff = $_SESSION['staff_to_change'];
  $_SESSION['staff_to_change'] = null;
}
?>

<!DOCTYPE html>
<html lang="en" class="no-js" >

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>KidsGames Genève Scores</title>

  <link href="assets/css/bootstrap.css" rel="stylesheet" />
  <link href="assets/css/ionicons.css" rel="stylesheet" />
  <link href="assets/css/font-awesome.css" rel="stylesheet" />
  <link href="assets/js/source/jquery.fancybox.css" rel="stylesheet" />
  <link href="assets/css/animations.min.css" rel="stylesheet" />
  <link href="assets/css/style-blue.css" rel="stylesheet" />


</head>

<body data-spy="scroll" data-target="#menu-section">

  <div class="navbar navbar-inverse navbar-fixed-top scroll-me" id="menu-section" >
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">
          KidsGames Genève Scores
        </a>
      </div>
      <?php include "php/navbar.inc.php" ?>
    </div>
  </div>

  <section id="services" style="margin-top: 10%" >
    <div class="container">


      <div class="row animate-in" data-anim-type="fade-in-up">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <div class="contact-wrapper">
            <form class="" action="#" method="post">

              <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-3">
                <input type="text" class="form-control" name="nom" id="nom" placeholder="Nom" value="<?php echo $edit ? $staff['nom'] : ""; ?>">
              </div>

              <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-3">
                <input type="text" class="form-control" name="prenom" id="prenom" placeholder="Prenom" value="<?php echo $edit ? $staff['prenom'] : ""; ?>">
              </div>

              <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-3">
                <select class="form-control" name="role">
                  <?php for ($i=0; $i < count($roles); $i++) :?>
                    <?php if ($edit): // Si nous sommes en mode edition?>
                      <?php if ($staff['idRole'] == $roles[$i]['id']): // Si l'id du Rôle = à l'id du Rôle du membre alors on le sélectionne?>
                        <option selected value="<?php echo $roles[$i]['id']; ?>"><?php echo $roles[$i]['intitule']; ?></option>
                      <?php else: ?>
                        <option value="<?php echo $roles[$i]['id']; ?>"><?php echo $roles[$i]['intitule']; ?></option>
                      <?php endif; ?>
                    <?php else: ?>
                      <option value="<?php echo $roles[$i]['id']; ?>"><?php echo $roles[$i]['intitule']; ?></option>
                    <?php endif; ?>

                  <?php endfor; ?>
                </select>
              </div>

              <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-3">
                <?php if ($edit): // Si on est en mode édition, alors le bouton affichera "modifier"?>
                  <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-6">
                    <input type="submit" name="modifier" value="Modifier" class="btn btn-default" style="width: 100%;">
                  </div>
                  <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-6">
                    <input type="submit" name="reset" value="Reset" class="btn btn-default" style="width: 100%;">
                  </div>
                <?php else: // sinon il affichera Ajouter?>
                  <input type="submit" name="ajouter" value="Ajouter" class="btn btn-default" style="width: 100%;">
                <?php endif; ?>

              </div>
            </form>

          </div>
        </div>
      </div>

      <div class="row animate-in" data-anim-type="fade-in-up">
        <div class="row text-center animate-in" data-anim-type="fade-in-up" >
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pad-bottom">
            <div class="caegories">
              <a href="#" data-filter="*" class="active btn btn-custom btn-custom-two btn-sm">Tout</a>
              <a href="#" data-filter=".Coach" class="btn btn-custom btn-custom-two btn-sm">Coach</a>
              <a href="#" data-filter=".Arbitre" class="btn btn-custom btn-custom-two btn-sm">Arbitres</a>
              <a href="#" data-filter=".Admin" class="btn btn-custom btn-custom-two btn-sm" >Admin</a>
              <a href="#" data-filter=".Benevole" class="btn btn-custom btn-custom-two btn-sm" >Bénévoles</a>
            </div>
          </div>
        </div>
        <div class="row text-center animate-in" data-anim-type="fade-in-up" id="work-div">
          <?php
          $staff = GetAllStaff();
          for ($staffmember=0; $staffmember < count($staff); $staffmember++):
            $role = GetRoleById($staff[$staffmember]['idRole']);
            $group = $role['intitule'];
            $editLink = "<a style=\"color: white; font-size: 90%;\" href=\"php/editStaff.php?id=".$staff[$staffmember]['id']."\">Modifier</a>";
            $deleteLink = "<a style=\"color: red; font-size: 90%;\" href=\"php/deleteStaff.php?id=".$staff[$staffmember]['id']."\">Supprimer</a>";
            ?>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 <?php echo $group ?>">
              <div class="work-wrapper">

                <h4><?php echo $staff[$staffmember]['prenom']." (".$staff[$staffmember]['nom'].") - [" .$editLink."] [".$deleteLink."]" ?></h4>
              </div>
            </div>
          <?php endfor; ?>
        </div>
      </div>
    </div>
  </section>

  <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME -->
  <!-- CORE JQUERY -->
  <script src="assets/js/jquery-1.11.1.js"></script>
  <!-- BOOTSTRAP SCRIPTS -->
  <script src="assets/js/bootstrap.js"></script>
  <!-- EASING SCROLL SCRIPTS PLUGIN -->
  <script src="assets/js/vegas/jquery.vegas.min.js"></script>
  <!-- VEGAS SLIDESHOW SCRIPTS -->
  <script src="assets/js/jquery.easing.min.js"></script>
  <!-- FANCYBOX PLUGIN -->
  <script src="assets/js/source/jquery.fancybox.js"></script>
  <!-- ISOTOPE SCRIPTS -->
  <script src="assets/js/jquery.isotope.js"></script>
  <!-- VIEWPORT ANIMATION SCRIPTS   -->
  <script src="assets/js/appear.min.js"></script>
  <script src="assets/js/animations.min.js"></script>
  <!-- CUSTOM SCRIPTS -->
  <script src="assets/js/custom.js"></script>
</body>
</html>
