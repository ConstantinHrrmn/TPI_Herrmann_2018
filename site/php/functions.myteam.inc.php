<?php

include "functions.inc.php";
include "functions.times.inc.php";

function GetAllMatchForTeamOnDayAndTime($idTeam, $idDay, $idTime){
  static $query = null;
  if ($query == null) {
    $req = "SELECT `Games`.`id`, `Staff`.`nom` as arbitre, `Field`.`Nom` as terrain, `idJour`, `idTime`, `Sport`.`Nom`, `played` FROM `Games` INNER JOIN `Staff` ON `staff`.`id` = `Games`.`idArbitre` INNER JOIN `Field` ON `Field`.`id` = `Games`.`idTerrain` INNER JOIN `Sport` ON `Sport`.`id` = `Games`.`idSport` WHERE `Games`.`id` IN (SELECT `plays`.`idGame` FROM `plays` WHERE `plays`.`idTeam` = :idTeam) AND `Games`.`idJour` = :idDay AND `Games`.`idTime` = :idTime";
    $query = connecteur()->prepare($req);
  }
  try {
    $query->bindParam(':idTeam', $idTeam, PDO::PARAM_STR);
    $query->bindParam(':idDay', $idDay, PDO::PARAM_STR);
    $query->bindParam(':idTime', $idTime, PDO::PARAM_STR);
    $query->execute();

    $res = $query->fetch(PDO::FETCH_ASSOC);
  }
  catch (Exception $e) {
    error_log($e->getMessage());
    $res = false;
  }
  return $res;
}
