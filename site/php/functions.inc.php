<?php

include "pdo.php";
include "controllers/admin.c.php";
include "controllers/classement.c.php";
include "controllers/day.c.php";
include "controllers/field.c.php";
include "controllers/points_counting.c.php";
include "controllers/role.c.php";
include "controllers/sport.c.php";
include "controllers/staff.c.php";
include "controllers/team.c.php";
include "controllers/time.c.php";
include "controllers/game.c.php";

// Le login retourne un utilisateur d'après son prénom et mot de passe si il existe
// Si l'utilisateur n'existe pas le return sera égal a FALSE
function login($id, $pass){
  static $query = null;
  if ($query == null) {
    $req = "SELECT `id`, `nom`, `prenom`, `age`, `idRole` FROM `Staff` WHERE `prenom` = :id AND `nom` = :pass";
    $query = connecteur()->prepare($req);
  }
  try {
    $query->bindParam(':id', $id, PDO::PARAM_STR);
    $query->bindParam(':pass', $pass, PDO::PARAM_STR);
    $query->execute();
    $res = $query->fetch(PDO::FETCH_ASSOC);
  }
  catch (Exception $e) {
    error_log($e->getMessage());
    $res = false;
  }
  return $res;
}
