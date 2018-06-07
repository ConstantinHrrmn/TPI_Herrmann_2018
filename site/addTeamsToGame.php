<?php
// On include le fichier avec les fonctions
include "php/functions.inc.php";

// On vérifie si l'utilisateur est connecté et qu'il s'agit bien d'un administrateur
if (!isset($_SESSION['user']) || $_SESSION['user']['idRole'] != "1") {
 header("Location: ../index.php");
 exit;
}

// On vérifie si on est bien passé par l'étape des propriété du match
if (!isset($_SESSION['newGame'])) {
  // sinon on redirige sur la page adéquate
  header("Location: newGame.php");
  exit;
}

// On récupère les propriétés du match
$match = $_SESSION['newGame'];
// On récupère toutes les équipes
$teams = GetAllteams();

// Regarde si le bouton valider à été appuyer
if(filter_has_var(INPUT_POST, "valider")){
  $teamsSelected = [];
  // On parcours toutes les équipes sélectionnées
  for ($team = 0; $team < $match['type']; $team++) {
    $teamsSelected[$team] = $_POST[$team];
  }
  $ma = $_SESSION['newGame'];

  // Création du nouveau match (game)
  CreateNewGame($match['time'], $match['day'], $match['field'], $match['arbitre'], $teamsSelected, $match['sport']);
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
      <div class="" data-anim-type="">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <div class="services-wrapper">
            <h1>Création du match</h1>
            <form class="" action="#" method="post">

              <div class="form-group">
                <?php for ($t=0; $t < $match['type']; $t++):?>
                  <br>
                <select class="form-control" name="<?php echo $t ?>">
                  <?php for ($team=0; $team < count($teams); $team++):?>
                    <option value="<?php echo $teams[$team]['id']?>"><?php echo $teams[$team]['id']. " - ". $teams[$team]['nom']?></option>
                  <?php endfor; ?>
                </select>
                <?php endfor; ?>
              </div>

              <div class="form-group">
                <input type="submit" name="valider" value="Créer match" class="btn btn-default">
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
