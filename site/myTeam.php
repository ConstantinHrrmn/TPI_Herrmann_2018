<?php
// On include le fichier avec les fonctions
include "php/functions.inc.php";
$redirect = false;

// On vérifie si l'id ce trouve dans l'url
if (!isset($_GET['id'])) {
  $redirect = true;
}else{
  // On récupère l'id dans l'url
  $id = $_GET['id'];
  // On récupères toutes les infos de l'équipe
  $team = GetTeamById($id);

  // On vérifie si l'équipe existe ou non
  if ($team == false)
    $redirect = true;

  // On récupère tout les jours
  $days = GetDays();
}

if ($redirect) {
  header("Location: index.php");
  exit;
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

  <!--MENU SECTION START-->

  <!--MENU SECTION START-->
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
  <!--MENU SECTION END-->

  <!--
  DAYS SECTION END
  Affichage des jours
-->
<section id="services" style="margin-top: 10%" >
  <div class="container">
    <div class="row animate-in" data-anim-type="fade-in-up">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
        <div class="services-wrapper">
          <h1>Matchs de l'équipe n° <?php echo $team['id'] ?></h1>
        </div>
      </div>
      <?php for ($day=0; $day < count($days); $day++):?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
          <div class="services-wrapper">
            <h1><?php echo $days[$day]['nomJour'] ?></h1>
          </div>
        </div>
        <?php
        // On récupère tout les fuseaux horaires
        $times_on_day = GetAllTimesOnDay($days[$day]['id']);
        // On parcours la liste des fuseaux horaires
        for ($i=0; $i < count($times_on_day); $i++):
          // On récupères tout les match de l'équipe pour un jour et un fuseau horaire
          $matchs_on_day_and_time = GetAllMatchForTeamOnDayAndTime($team['id'], $days[$day]['id'], $times_on_day[$i]['idTime']);
          ?>
          <?php
          if ($matchs_on_day_and_time != false):
            $time = GetTimeById($matchs_on_day_and_time['idTime']);
            ?>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="text-align: center">
              <div class="services-wrapper">
                <?php if ($matchs_on_day_and_time['played'] == "1"): ?>
                  <h1 style="color: green">MATCH TERMINE</h1>
                <?php endif; ?>
                <h3><?php echo substr($time['start'], 0, -3). " - ".substr($time['end'], 0, -3) ?></h3>
                <h1>Terrain: <?php echo $matchs_on_day_and_time['terrain'] ?></h1>
                <?php if ($matchs_on_day_and_time['played'] != "1"): ?>
                  <a href="match.php?id=<?php echo $matchs_on_day_and_time['id'] ?>"><h4>infos match</h4></a>
                <?php endif; ?>

              </div>
            </div>
          <?php endif; ?>
        <?php endfor; ?>
      <?php endfor; ?>
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
