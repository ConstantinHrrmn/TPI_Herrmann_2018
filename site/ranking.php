<?php
include "php/functions.inc.php";
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
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">

          <div class="row db-padding-btm db-attached">

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class="light-pricing ">
                <div class="type">
                  Kinball
                </div>
                <table class="table table-dark table-bordered">
                  <thead>
                    <tr>
                      <th scope="col">Pos.</th>
                      <th scope="col">Nom/num.</th>
                      <th scope="col">P.</th>
                      <th scope="col">M.</th>
                      <th scope="col">R.</th>
                      <th scope="col">D.</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $teams = GetClassement("A");
                    for ($i=0; $i < count($teams); $i++) :
                      $id = $teams[$i]['id'];
                      $nom = $teams[$i]['nom'];
                      $points = $teams[$i]['points'];
                      $marques = $teams[$i]['marques'];
                      $recus = $teams[$i]['recus'];
                      $diff = $teams[$i]['difference'];
                      ?>

                      <tr>
                        <th scope="row"><?php echo $i+1 ?></th>
                        <td><b><?php echo $nom." (".$id.")"; ?></b></td>
                        <td><?php echo $points ?></td>
                        <td><?php echo $marques ?></td>
                        <td><?php echo $recus ?></td>
                        <td><?php echo $diff ?></td>
                      </tr>

                    <?php endfor; ?>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class="light-pricing ">
                <div class="type">
                  TchouckBall
                </div>
                <table class="table table-dark table-bordered">
                  <thead>
                    <tr>
                      <th scope="col">Pos.</th>
                      <th scope="col">Nom/num.</th>
                      <th scope="col">P.</th>
                      <th scope="col">M.</th>
                      <th scope="col">R.</th>
                      <th scope="col">D.</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $teams = GetClassement("B");
                    for ($i=0; $i < count($teams); $i++) :
                      $id = $teams[$i]['id'];
                      $nom = $teams[$i]['nom'];
                      $points = $teams[$i]['points'];
                      $marques = $teams[$i]['marques'];
                      $recus = $teams[$i]['recus'];
                      $diff = $teams[$i]['difference'];
                      ?>

                      <tr>
                        <th scope="row"><?php echo $i+1 ?></th>
                        <td><b><?php echo $nom." (".$id.")"; ?></b></td>
                        <td><?php echo $points ?></td>
                        <td><?php echo $marques ?></td>
                        <td><?php echo $recus ?></td>
                        <td><?php echo $diff ?></td>
                      </tr>

                    <?php endfor; ?>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class="light-pricing ">
                <div class="type">
                  Course-Agile
                </div>
                <table class="table table-dark table-bordered">
                  <thead>
                    <tr>
                      <th scope="col">Pos.</th>
                      <th scope="col">Nom/num.</th>
                      <th scope="col">P.</th>
                      <th scope="col">M.</th>
                      <th scope="col">R.</th>
                      <th scope="col">D.</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $teams = GetClassement("C");

                    for ($i=0; $i < count($teams); $i++) :
                      $id = $teams[$i]['id'];
                      $nom = $teams[$i]['nom'];
                      $points = $teams[$i]['points'];
                      $marques = $teams[$i]['marques'];
                      $recus = $teams[$i]['recus'];
                      $diff = $teams[$i]['difference'];
                      ?>

                      <tr>
                        <th scope="row"><?php echo $i+1 ?></th>
                        <td><b><?php echo $nom." (".$id.")"; ?></b></td>
                        <td><?php echo $points ?></td>
                        <td><?php echo $marques ?></td>
                        <td><?php echo $recus ?></td>
                        <td><?php echo $diff ?></td>
                      </tr>

                    <?php endfor; ?>
                  </tbody>
                </table>
              </div>
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
