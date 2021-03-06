<?php
/*******************************************************************************
AUTEUR      : Constantin Herrmann
LIEU        : CFPT Informatique Genève
DATE        : 14.06.2018

TITRE PROJET: KidsGames Geneva Score

TITRE PAGE  : teams
DESCRIPTION : Cette page affiche toutes les équipes avec leur numéro et leur nom ainsi que le nom du coach
VERSION     : 1.0
*******************************************************************************/

include "php/functions.inc.php";

$admin = false;

// On vérifie si l'utilisateur est connecté et qu'il s'agit bien d'un administrateur
if (isset($_SESSION['user']) && $_SESSION['user']['idRole'] == "1") {
  $admin = true;
}

// On récupère toutes les équipes
$teams = GetAllteams();

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

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
          <div class="services-wrapper">
            <h1>Equipes</h1>
          </div>
        </div>

        <?php
        for ($team=0; $team < count($teams); $team++):
          $coach = GetStaffById($teams[$team]['idCoach']);
          ?>
          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4" style="text-align: center">
            <div class="services-wrapper">

              <?php if ($admin):
                $editLink = "editTeam.php?id=".$teams[$team]['id']?>
                <a href="<?php echo $editLink ?>">Modifier l'équipe</a>
              <?php endif; ?>

              <h3>n° <?php echo $teams[$team]['id'] ?></h3>
              <h1><?php echo $teams[$team]['nom'] ?></h1>

              <?php if ($coach == false): ?>
                <p>Aucun coach</p>
              <?php else: ?>
                <p>Coach: <?php echo $coach['prenom'] ?></p>
              <?php endif; ?>
              <a href="myTeam.php?id=<?php echo $teams[$team]['id'] ?>">infos matchs</a>
            </div>
          </div>
          <?php
        endfor;
        ?>

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
