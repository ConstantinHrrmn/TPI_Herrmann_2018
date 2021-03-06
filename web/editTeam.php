<?php
/*******************************************************************************
AUTEUR      : Constantin Herrmann
LIEU        : CFPT Informatique Genève
DATE        : 14.06.2018

TITRE PROJET: KidsGames Geneva Score

TITRE PAGE  : editTeam
DESCRIPTION : Cette page permet à un administrateur de modifier les infos d'une équipe
VERSION     : 1.0
*******************************************************************************/

// On include le fichier avec les fonctions
include "php/functions.inc.php";

// On vérifie si l'utilisateur est connecté et qu'il s'agit bien d'un administrateur
if (!isset($_SESSION['user']) || $_SESSION['user']['idRole'] != "1") {
  header("Location: index.php");
  exit;
}

// On vérifie si l'id ce trouve dans l'url
if (isset($_GET['id'])) {
  // On récupère l'id
  $idTeam = $_GET['id'];
  // On recherche l'équipe d'après son id
  $team = GetTeamById($idTeam);
  // On recherche tout les coachs sans équipes
  $coachs = GetAllCoachsWithoutTeam();
}

// Regarde si le bouton valider à été appuyer
if(filter_has_var(INPUT_POST, "Valider")){
  // On filtre les données
  $name = trim(filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING));
  $idCoach = trim(filter_input(INPUT_POST, "coach", FILTER_SANITIZE_STRING));

  // On vérifie si l'id ce trouve dans l'url
  if (isset($_GET['id'])) {
    // On récupère l'id dans l'url
    $id = $_GET['id'];
    // On met à jour l'équipe
    UpdateTeam($id, $name, $idCoach);
    // Redirection sur la page des membres
    header("Location: teams.php");
    exit;
  }
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
  <link href=".assets/css/font-awesome.css" rel="stylesheet" />
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
          <div class="services-wrapper">
            <a href="teams.php">Retour</a>
            <h1>Modification de l'équipe n° <?php echo $idTeam ?></h1>
            <form class="" action="#" method="post">
              <div class="form-group">
                <label for="formGroupExampleInput">Nom de l'équipe</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Nom" value="<?php echo $team['nom'] ?>">
              </div>

              <div class="form-group">
                <label for="formGroupExampleInput2">Coach</label>
                <select class="form-control" name="coach">
                  <option value="-1">Aucun coach</option>
                  <?php $selectedCoach = GetStaffById($team['idCoach']) ?>
                  <?php if ($selectedCoach != false): ?>
                    <option selected value="<?php echo $selectedCoach['id']?>"><?php echo $selectedCoach['prenom']." (".$selectedCoach['nom'].")"?></option>
                  <?php endif; ?>

                  <?php

                  for ($coach=0; $coach < count($coachs); $coach++):
                    if ($coachs[$coach]['id'] != intval($team['idCoach'])):
                      ?>
                      <option value="<?php echo $coachs[$coach]['id']?>"><?php echo $coachs[$coach]['prenom']." (".$coachs[$coach]['nom'].")"?></option>
                    <?php endif; ?>
                  <?php endfor; ?>
                </select>

              </div>
              <div class="form-group">
                <input type="submit" name="Valider" value="Valider" class="btn btn-default">
              </div>
            </form>
          </div>
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
