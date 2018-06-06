<?php

// Récupère toutes les équipes de la base de données
function GetAllteams(){
  static $query = null;
  if ($query == null) {
    $req = "SELECT `id`, `nom`, `idCoach`, `p_A` + `p_B` + `p_C` as total, `m_A`-`r_A` + `m_B`-`r_B` + `m_C`-`r_C` as totalDiff FROM `Teams` ORDER BY `id` ASC";
    $query = connecteur()->prepare($req);
  }
  try {
    $query->execute();
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
  }
  catch (Exception $e) {
    error_log($e->getMessage());
    $res = false;
  }
  return $res;
}

// Récupère toutes les équipes
function GetTeams(){
  $req = "SELECT `id`, `nom` FROM `Teams`";
  $query = connecteur()->prepare($req);
  $query->execute();
  $teams = $query->fetchAll(PDO::FETCH_ASSOC);
  return $teams;
}


// Retourne une équipe d'après son id
// Retourne FALSE si aucune équipe ne correspond à l'id reçu
function GetTeamById($id){
  static $query = null;
  if ($query == null) {
    $req = "SELECT `id`, `nom`, `idCoach` FROM `Teams` WHERE `id` = :id LIMIT 1";
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
  return $res;
}

// Récupère l'équipe d'un coach d'après son ID
function GetTeamByCoachId($id){
  $req = "SELECT `id`, `nom` FROM `Teams` WHERE `idCoach` = :id LIMIT 1";
  $query = connecteur()->prepare($req);
  $query->bindParam(':id', $id, PDO::PARAM_STR);
  $query->execute();
  return ($query->fetch(PDO::FETCH_ASSOC));
}


// Met a jour une équipe a l'index indiqué
// Mise a jour du nom de l'équipe et l'id du coach
function UpdateTeam($idTeam, $name, $idCoach){
  $req = "UPDATE `Teams` SET `nom`= :nom,`idCoach`= :coach WHERE `id` = :id";
  $query = connecteur()->prepare($req);
  $query->bindParam(':id', $idTeam, PDO::PARAM_STR);
  $query->bindParam(':nom', $name, PDO::PARAM_STR);
  $query->bindParam(':coach', $idCoach, PDO::PARAM_STR);
  $query->execute();
  $query->fetch();
}


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
