<?php
// On include le fichier avec les fonctions
include "php/functions.inc.php";

if (!isset($_SESSION['user']) && $_SESSION['user']['idRole'] != "3") {
  header("Location: index.php");
  exit;
}

$arbitre = $_SESSION['user'];
$days = GetDays();

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
        <?php
        for ($day=0; $day < count($days); $day++):
          $times = GetAllTimesOnDay($days[$day]['id']);
          ?>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <div class="services-wrapper">
              <h1><?php echo $days[$day]['nomJour'] ?></h1>
            </div>
          </div>
          <?php
          for ($time=0; $time < count($times); $time++) :
            $time_provisoire = GetTimeById($times[$time]['idTime']);
            $match = GetMacthsForArbitreDayAndTime($arbitre['id'], $time_provisoire['id'], $days[$day]['id']);

            $link_to_edit = "editScore.php?id=".$match['id'];
            ?>
            <?php if ($match != false): ?>
              <?php if ($match['played'] == "1"): ?>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="text-align: center">
                  <div class="services-wrapper">
                    <h1>MATCH TERMINE</h1>
                    <?php $match_done = GetAllMatchInfos($match['id']); ?>
                    <?php for ($team=0; $team < count($match_done['teams']); $team++):?>
                      <h4><?php echo "n°".$match_done['teams'][$team]['numero']." --> ".$match_done['teams'][$team]['score']?></h4>
                    <?php endfor; ?>
                  </div>
                </div>
              <?php else: ?>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="text-align: center">
                  <div class="services-wrapper">
                    <?php $time = GetTimeForMatch($match['id']); ?>
                    <h1><?php echo substr($time['debut'], 0, -3). " - ".substr($time['fin'], 0, -3) ?></h1>
                    <h1>Terrain: <b><?php echo $match['terrain'] ?></b></h1>
                    <a href="<?php echo $link_to_edit ?>"><h3 style="color: green;">Enrengistrer un résultat</h3></a>
                  </div>
                </div>
              <?php endif; ?>
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
