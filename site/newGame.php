<?php
include "php/functions.inc.php";
if (!isset($_SESSION['user']) || $_SESSION['user']['idRole'] != "1") {
  header("Location: index.php");
  exit;
}

$times = GetTimes();
$days = GetDays();
$fields = GetFields();
$arbitres = GetArbitres();
$sports = GetSportTypes();

if(filter_has_var(INPUT_POST, "continuer")){

  $time = trim(filter_input(INPUT_POST, "time", FILTER_SANITIZE_STRING));
  $day = trim(filter_input(INPUT_POST, "day", FILTER_SANITIZE_STRING));
  $field = trim(filter_input(INPUT_POST, "field", FILTER_SANITIZE_STRING));
  $arbitre = trim(filter_input(INPUT_POST, "arbitre", FILTER_SANITIZE_STRING));
  $type = trim(filter_input(INPUT_POST, "type", FILTER_SANITIZE_STRING));

  $_SESSION['newGame']['time'] = $time;
  $_SESSION['newGame']['day'] = $day;
  $_SESSION['newGame']['field'] = $field;
  $_SESSION['newGame']['arbitre'] = $arbitre;
  $_SESSION['newGame']['type'] = substr($type, 0, 1);
  $_SESSION['newGame']['sport'] = substr($type, -1);

  header("Location: addTeamsToGame.php");
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
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <div class="services-wrapper">

            <h1>Création du match</h1>
            <form class="" action="#" method="post">

              <div class="form-group">
                <label for="formGroupExampleInput">Horaire</label>
                <select class="form-control" name="time">
                  <?php for ($t=0; $t < count($times); $t++):?>
                    <option value="<?php echo $times[$t]['id']?>"><?php echo $times[$t]['start']. " - ". $times[$t]['end']?></option>
                  <?php endfor; ?>
                </select>
              </div>

              <div class="form-group">
                <label for="formGroupExampleInput">Jour</label>
                <select class="form-control" name="day">
                  <?php for ($d=0; $d < count($days); $d++):?>
                    <option value="<?php echo $days[$d]['id']?>"><?php echo $days[$d]['nomJour']?></option>
                  <?php endfor; ?>
                </select>
              </div>

              <div class="form-group">
                <label for="formGroupExampleInput2">Terrain</label>
                <select class="form-control" name="field">
                  <?php for ($f=0; $f < count($fields); $f++):?>
                    <option value="<?php echo $fields[$f]['id']?>"><?php echo $fields[$f]['Nom']?></option>
                  <?php endfor; ?>
                </select>
              </div>

              <div class="form-group">
                <label for="formGroupExampleInput2">Arbitre</label>
                <select class="form-control" name="arbitre">
                  <?php for ($a = 0; $a < count($arbitres); $a++):?>
                    <option value="<?php echo $arbitres[$a]['id']?>"><?php echo $arbitres[$a]['prenom']?></option>
                  <?php endfor; ?>
                </select>
              </div>

              <div class="form-group">
                <label for="formGroupExampleInput2">Type de match</label>
                <select class="form-control" name="type">
                  <?php
                    for ($sport=0; $sport < count($sports); $sport++):
                  ?>
                  <option value="<?php echo $sports[$sport]['nbEquipes'].$sports[$sport]['id'] ?>"><?php echo $sports[$sport]['Nom']; ?></option>
                <?php endfor; ?>
                </select>
              </div>

              <div class="form-group">
                <input type="submit" name="continuer" value="Continuer" class="btn btn-default">
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