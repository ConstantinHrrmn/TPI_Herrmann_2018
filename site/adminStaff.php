<?php
include "php/functions.inc.php";
if (!isset($_SESSION['user']) || $_SESSION['user']['idRole'] != "1") {
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
              $editLink = "<a style=\"color: white; font-size: 90%;\" href=\"#\">Modifier</a>";
              $deleteLink = "<a style=\"color: red; font-size: 90%;\" href=\"#\">Supprimer</a>";
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
