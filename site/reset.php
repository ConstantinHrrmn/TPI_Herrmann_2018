<?php
/*******************************************************************************
AUTEUR      : Constantin Herrmann
LIEU        : CFPT Informatique Genève
DATE        : 14.06.2018

TITRE PROJET: KidsGames Geneva Score

TITRE PAGE  : reset
DESCRIPTION : Cette page permet à un administrateur de remttre à zéro le camp en cours
VERSION     : 1.0
*******************************************************************************/

include "php/functions.inc.php";

// On vérifie si l'utilisateur est connecté et qu'il s'agit bien d'un administrateur
if (!isset($_SESSION['user']) || $_SESSION['user']['idRole'] != 1) {
  header("Location: index.php");
  exit;
}

if(filter_has_var(INPUT_POST, "submit")){
  $admin_pwd = $id = trim(filter_input(INPUT_POST, "pwd", FILTER_SANITIZE_STRING));
  // On verifie le mot de passe super-admin
  if (sha1($admin_pwd) == "f3b3f056c16229db159a1d7400d604ca56e293f5") {
    // On remet à zero le camp
    ResetCamp();
    $message = "Camp réinitialisé avec succès";
    echo "<script type='text/javascript'>alert('$message');</script>";
  }else{
    $message = "Mot de passe éronné !";
    echo "<script type='text/javascript'>alert('$message');</script>";
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
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="contact-wrapper">
              <?php echo $youpi; ?>
              <form class="" action="#" method="post">
                <div class="form-group">
                  <label for="formGroupExampleInput">VERIFICATION</label>
                  <input type="password" class="form-control" name="pwd" id="pwd" placeholder="Mot de passe administrateur">
                </div>

                <div class="form-group">
                  <input type="submit" name="submit" value="Valider Réinitialisation" class="btn btn-default">
                </div>
              </form>

            </div>
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
