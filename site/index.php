<?php

include "php/functions.inc.php";

$error = false;

if(filter_has_var(INPUT_POST, "submit")){

  $id = trim(filter_input(INPUT_POST, "user", FILTER_SANITIZE_STRING));
  $pass = trim(filter_input(INPUT_POST, "pwd", FILTER_SANITIZE_STRING));
  $user = login($id, $pass);

  if ($user != false) {

    $_SESSION['user'] = $user;

    if ($user['idRole'] == "2") {
      $team = GetTeamByCoachId($user['id']);
      if ($team != false) {
        $_SESSION['MyTeam'] = $team;
      }
    }
  }else{
    $error = true;
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

        <?php
        $days = GetDays();
        for ($day=0; $day < count($days); $day++):
          $linktoDay = "day.php?id=".$days[$day]['id'];
          ?>

          <a href="<?php echo $linktoDay; ?>" style="color: white">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4" style="text-align: center">
              <div class="services-wrapper">
                <h1 style="font-size: 500%"><?php echo $days[$day]['nomJour'] ?></h1>
              </div>
            </div>
          </a>

        <?php endfor; ?>

      </div>
    </div>
  </section>

  <?php if (!isset($_SESSION['user'])): ?>
      <section id="connexion" >
        <div class="container">
          <div class="row text-center header animate-in" data-anim-type="fade-in-up">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <h3>Connexion</h3>
              <hr />
            </div>
          </div>

          <div class="row animate-in" data-anim-type="fade-in-up">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class="contact-wrapper">
                <?php if ($error):
                  $message = "Utilisateur ou identifiant éronné";
                  echo "<script type='text/javascript'>alert('$message');</script>";
                  ?>
                  <div class="alert alert-danger" role="alert">
                    <strong>Oups !</strong> Identifiant ou mot de passe éronné...
                  </div>
                <?php endif; ?>

                <form class="" action="#" method="post">
                  <div class="form-group">
                    <label for="formGroupExampleInput">Login</label>
                    <input type="text" class="form-control" name="user" id="user" placeholder="Nom d'utilisateur">
                  </div>
                  <div class="form-group">
                    <label for="formGroupExampleInput2">Mot de passe</label>
                    <input type="password" class="form-control" name="pwd" id="pwd" placeholder="mot de passe">
                  </div>
                  <div class="form-group">
                    <input type="submit" name="submit" value="Connexion" class="btn btn-default">
                  </div>
                </form>

              </div>
            </div>
          </div>
        </div>
      </section>
    <?php endif; ?>

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
