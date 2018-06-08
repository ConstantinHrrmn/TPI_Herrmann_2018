<?php
// On include le fichier avec les fonctions
include "php/functions.inc.php";

// On vérifie si l'utilisateur est connecté et qu'il s'agit bien d'un administrateur
// On vérifie si l'id ce trouve dans l'url
if (!isset($_GET['id']) || (!isset($_SESSION['user']) && $_SESSION['user']['idRole'] == '1')) {
  header("Location: index.php");
  exit;
}
else{
  // On récupère l'id dans l'url
  $id = $_GET['id'];
  // On récupère les infos du match
  $match = GetAllMatchInfos($id);
}

$error = false;

// Regarde si le bouton enregistrer à été appuyer
if(filter_has_var(INPUT_POST, "enregistrer")){
  $teams = [];

  // On récupères les scores des équipes dans le $_POST
  for ($team=0; $team < count($match['teams']); $team++) {
    $result_team = $_POST[$match['teams'][$team]['numero']];
    // On vérifie qu'il s'agit bien d'un numero
    if (ctype_digit($result_team)){
      $teams[$team]['score'] =  $result_team;
      $teams[$team]['infos'] = $match['teams'][$team];
    }
  }

  // On met à jour les scores
  UpdateScore($teams, $match['infos']['id']);


  // On rdirige sur l'index
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

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center">
          <div class="services-wrapper">
            <form class="" action="#" method="post">
              <?php
              $teams_playing = $match['teams'];
              for ($team=0; $team < count($teams_playing); $team++):
                ?>
                <div class="form-group">
                  <label for="">équipe: <?php echo $teams_playing[$team]['numero'] ?></label>
                  <input type="number" name="<?php echo $teams_playing[$team]['numero'] ?>" value="<?php echo $teams_playing[$team]['score'] ?>" class="btn btn-default">
                </div>
              <?php endfor; ?>
              <div class="form-group">
                <input type="submit" name="enregistrer" value="Enregistrer" class="btn btn-default">
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
