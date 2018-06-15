<div class="navbar-collapse collapse">
  <ul class="nav navbar-nav navbar-right">
    <li><a href="index.php">HORAIRES</a></li>
    <li><a href="ranking.php">CLASSEMENT</a></li>
    <li><a href="teams.php">EQUIPES</a></li>

    <?php if (!isset($_SESSION['user'])):?>
      <li><a href="index.php#connexion">CONNEXION</a></li>
    <?php else: ?>
      <?php $idRole = $_SESSION['user']['idRole']; ?>
      <?php if ($idRole == "1"): ?>
        <li><a href="adminStaff.php">STAFF</a></li>
        <li><a href="reset.php">RESET</a></li>
        <li><a href="newGame.php">NOUV. MATCH</a></li>
      <?php endif; ?>
      <?php if ($idRole == "3"): ?>
        <li><a href="myMatchs.php">MES MATCHS</a></li>
      <?php endif; ?>
      <?php if ($idRole == "2" && isset($_SESSION['MyTeam'])): ?>
        <li><a href="myTeam.php?id=<?php echo $_SESSION['MyTeam']['id'] ?>">MON EQUIPE (<?php echo $_SESSION['MyTeam']['nom'] ?>)</a></li>
      <?php endif; ?>
      <li><a href="php/logout.php">DECONNEXION</a></li>
    <?php endif; ?>
  </ul>
</div>
