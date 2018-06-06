<?php
include "php/functions.inc.php";
$match = null;

if (!isset($_GET['id'])) {
  header("Location: index.php");
  exit;
}else{
  $id = $_GET['id'];
  $match = GetAllMatchInfos($id);
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
      <div class="" data-anim-type="">

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
          <div class="services-wrapper">
            <h3>match arbitré par: <?php echo $match['infos']['arbitre'];?></h3>
          </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
          <div class="services-wrapper">

            <h4 style="color: black;">Terrain: <?php echo $match['infos']['terrain'];?></h4>

            <h1>
              <?php
                echo $match['teams'][0]['numero'];
                for ($team = 1; $team < count($match['teams']); $team++):
                  echo " | ".$match['teams'][$team]['numero'];
                endfor;
              ?>
            </h1>

            <h1 style="font-size: 600%;">
              <?php
              echo $match['teams'][0]['score'];
              for ($team = 1; $team < count($match['teams']); $team++):
                echo " - ".$match['teams'][$team]['score'];
              endfor;
              ?>
            </h1>

          </div>
        </div>

        <?php if (IsArbitreOrAdmin($_SESSION['user']['id'], $match['infos']['id'])): ?>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <div class="services-wrapper">
              <?php $link_to_edit = "editScore.php?id=".$match['infos']['id']; ?>
              <a href="<?php echo $link_to_edit ?>"><h3 style="color: red;">Enrengistrer un résultat</h3></a>
            </div>
          </div>
        <?php endif; ?>

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
