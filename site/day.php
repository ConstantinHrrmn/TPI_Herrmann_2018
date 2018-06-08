<?php
// On include le fichier avec les fonctions
include "php/functions.inc.php";

// On vérifie si l'id ce trouve dans l'url
if (!isset($_GET['id'])) {
  // Si non, on redirige
  header("location:index.php");
  exit();
}
// Si l'id est dans l'url
else{
  // Déclaration d'un jour par défaut qui est 1
  $DEFAULT_DAY = 1;
  // On récupère l'id dans l'url
  $id = $_GET['id'];

  // On recherche tout les fuseaux horaires pour un jour
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

        <?php if ($times == false): // Si il n'y pas de fuseaux horaires pour le jour?>

          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
            <div class="services-wrapper">
              <h1>AUCUN MATCH PREVU AUJOURD'HUI</h1>
            </div>
          </div>

        <?php else: // Si il y'a des fuseaux horaires?>
          <?php
          // On parcours la liste des fuseaux
          for ($time=0; $time < count($times); $time++):
            // On récupères les infos pour le fuseaux actuel
            $time_provisoire = GetTimeById($times[$time]['idTime']);
            ?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
              <div class="services-wrapper">
                <h1><?php echo substr($time_provisoire['start'], 0, -3). " - ".substr($time_provisoire['end'], 0, -3) ?></h1>
              </div>
            </div>

            <?php
            // On récupère tout les match pour le jour et le fuseau horaire
            $matchs = GetMatchsOnDayAndTime($id ,$times[$time]['idTime']);

            // On parcours toutes la liste des matchs
            for ($m =0; $m < count($matchs); $m++):
              ?>
              <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="text-align: center">
                <div class="services-wrapper">
                  <?php $match = GetAllMatchInfos($matchs[$m]['id']); // On récupère les infos du match?>
                  <?php if ($match['infos']['played']): // Si le match à été joué ?>
                    <?php
                    // si un utilisateur est connecté et qu'il est administrateur
                    if (isset($_SESSION['user']) && $_SESSION['user']['idRole'] == "1"):
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
                <?php else: // Si le match n'as pas encore eu lieu?>
                  <?php
                  // On récupère les infos du matcg
                  $terrain = $match['infos']['terrain'];
                  $terrain_label = "Terrain: ";

                  // Is match est un boolean qui regarde si il s'agit d'un match ou d'un atelier
                  $is_match = true;
                  ?>
                  <?php
                  // Si le terrain contient la lettre A, alors il s'agit d'un atelier
                  if (strpos($terrain, 'A') !== false){
                    $terrain_label = "Atelier: ";
                    $is_match = false;
                  }
                  ?>
                  <h3><?php echo $terrain_label.$match['infos']['terrain'] ?></h3>

                  <?php
                  // Création des liens de modification
                  $link_to_match = "match.php?id=".$match['infos']['id'];
                  $teamId_label = $match['teams'][0]['numero'];
                  $link_to_delete_match = "php/deleteMatch.php?id=".$match['infos']['id'];
                  for ($team=1; $team < count($match['teams']); $team++) {
                    $teamId_label = $teamId_label." | ".$match['teams'][$team]['numero'];
                  }
                  ?>

                  <h1><?php echo $teamId_label; ?></h1>

                  <?php if ($is_match): ?>
                    <a href="<?php echo $link_to_match ?>"><h4 style="color: black;"><b>Plus d'infos</b></h4></a>
                  <?php endif; ?>
                  <?php if (!$match['played'] && isset($_SESSION['user']) && $_SESSION['user']['idRole'] == "1"): ?>
                    <a href="<?php echo $link_to_delete_match ?>"><h4 style="color: red;"><b>EFFACER</b></h4></a>
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
