<?php
include "pdo.php";
include "match.data.inc.php";

function IsArbitreOrAdmin($idStaff, $idGame){
      static $query = null;

      if ($query == null) {
        $req = "SELECT `Staff`.`prenom` FROM `Staff` WHERE `Staff`.`id` = (SELECT `Games`.`idArbitre` FROM `Games` WHERE `Games`.`id` = :idGame LIMIT 1) AND `Staff`.`id` = :idStaff";
        $query = connecteur()->prepare($req);
      }
      try {
          $query->bindParam(':idStaff', $idStaff, PDO::PARAM_STR);
          $query->bindParam(':idGame', $idGame, PDO::PARAM_STR);
          $query->execute();
          $res = $query->fetch(PDO::FETCH_ASSOC);
      }
      catch (Exception $e) {
        error_log($e->getMessage());
        $res = false;
      }

      if ($res != false)
        return true;
      else{
        return IsAdmin($idStaff);
      }
}

function IsAdmin($id){
  static $query = null;

  if ($query == null) {
    $req = "SELECT `Staff`.`prenom` FROM `Staff` WHERE `Staff`.`idRole` = (SELECT `Role`.`id` FROM `Role` WHERE `Role`.`intitule` = 'Admin') AND `Staff`.`id` = :id";
    $query = connecteur()->prepare($req);
  }
  try {
      $query->bindParam(':id', $id, PDO::PARAM_STR);
      $query->execute();
      $res = $query->fetch(PDO::FETCH_ASSOC);
  }
  catch (Exception $e) {
    error_log($e->getMessage());
    $res = false;
  }

  if ($res != false)
    return true;
  else
    return false;
}
