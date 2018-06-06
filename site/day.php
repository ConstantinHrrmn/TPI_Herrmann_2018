<?php
include "php/functions.day.inc.php";

if (!isset($_GET['id'])) {
  header("location:index.php");
  exit();
}
else{
  $DEFAULT_DAY = 1;
  $id = $_GET['id'];

  $times = GetAllTimesOnDay($id);
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

        <?php if ($times == false): ?>

          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <div class="services-wrapper">
              <h1>AUCUN MATCH PREVU AUJOURD'HUI</h1>
            </div>
          </div>

        <?php else: ?>
          <?php
          for ($time=0; $time < count($times); $time++):
            $time_provisoire = GetTimeById($times[$time]['idTime']);
            ?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
              <div class="services-wrapper">
                <h1><?php echo substr($time_provisoire['start'], 0, -3). " - ".substr($time_provisoire['end'], 0, -3) ?></h1>
              </div>
            </div>

            <?php
            $matchs = GetMatchsOnDayAndTime($id ,$times[$time]['idTime']);

            for ($m =0; $m < count($matchs); $m++):
              ?>
              <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="text-align: center">
                <div class="services-wrapper">
                  <?php $match = GetAllMatchInfos($matchs[$m]['id']);?>
                  <?php if ($match['infos']['played']): ?>
                    <?php
                    if (isset($_SESSION['user']) && $_SESSION['user']['idRole'] = '1'):
                      $link_to_edit = "editScore.php?id=".$match['infos']['id'];
                      ?>
                      <a href="<?php echo $link_to_edit ?>" style="color:red">Modifier les résultats</a>
                    <?php endif; ?>
                    <h2 style="color: green;" >Match terminé</h2>
                    <?php
                    $score_label = "";
                    for ($team=0; $team < count($match['teams']); $team++):?>
                    <h2 style="margin: 0;"><?php  echo $score_label." <br> n°".$match['teams'][$team]['numero']." | ".$match['teams'][$team]['score'];?></h2>
                  <?php  endfor; ?>
                <?php else: ?>
                  <?php
                  $terrain = $match['infos']['terrain'];
                  $terrain_label = "Terrain: ";
                  $is_match = true;
                  ?>
                  <?php
                  if (strpos($terrain, 'A') !== false){
                    $terrain_label = "Atelier: ";
                    $is_match = false;
                  }
                  ?>
                  <h3><?php echo $terrain_label.$match['infos']['terrain'] ?></h3>

                  <?php
                  $link_to_match = "match.php?id=".$match['infos']['id'];
                  $teamId_label = $match['teams'][0]['numero'];

                  for ($team=1; $team < count($match['teams']); $team++) {
                    $teamId_label = $teamId_label." | ".$match['teams'][$team]['numero'];
                  }
                  ?>

                  <h1><?php echo $teamId_label; ?></h1>

                  <?php if ($is_match): ?>
                    <a href="<?php echo $link_to_match ?>"><h4 style="color: black;"><b>Plus d'infos</b></h4></a>
                  <?php endif; ?>

                <?php endif; ?>

              </div>
            </div>
          <?php endfor; ?>
        <?php endfor; ?>

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
