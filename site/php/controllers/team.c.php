<?php

/**
* Récupère toutes les équipes dans la table Teams
*
* @return array un tableau avec toutes les équipes
*      [index]
*        ['id'] -> l'id de l'équipe
*        ['nom'] -> le nom de l'équipe
*        ['idCoach'] -> l'id du coach correspndant à l'équipe
*        ['total'] -> le total de points
*        ['totalDiff'] -> le total de la différence
*/
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

/**
* Retourne une équipe d'après son id
*
* @param int id de l'équipe
* @return array un tableau avec les infos de l'équipe
*        ['id'] -> l'id de l'équipe
*        ['nom'] -> le nom de l'équipe
*        ['idCoach'] -> l'id du coach correspndant à l'équipe
*/
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

/**
* Récupère l'équipe d'un coach d'après l'id du coach
*
* @param int id du coach
* @return array un tableau avec les infos de l'équipe
*        ['id'] -> l'id de l'équipe
*        ['nom'] -> le nom de l'équipe
*/
function GetTeamByCoachId($id){
  static $query = null;
  if ($query == null) {
    $req = "SELECT `id`, `nom` FROM `Teams` WHERE `idCoach` = :id LIMIT 1";
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

/**
* Met a jour une équipe a l'index indiqué
* Mise a jour du nom de l'équipe et l'id du coach
*
* @param int id de l'équipe
* @param string nom de l'équipe
* @param int id du coach
*/
function UpdateTeam($idTeam, $name, $idCoach){
  static $query = null;

  if ($query == null) {
    $req = "UPDATE `Teams` SET `nom`= :nom,`idCoach`= :coach WHERE `id` = :id";
    $query = connecteur()->prepare($req);
  }
  try {
    $query->bindParam(':id', $idTeam, PDO::PARAM_STR);
    $query->bindParam(':nom', $name, PDO::PARAM_STR);
    $query->bindParam(':coach', $idCoach, PDO::PARAM_STR);
    $query->execute();
    $query->fetch();
  }
  catch (Exception $e) {
    error_log($e->getMessage());
  }
}

/**
* Récupère tout les match pour une équipe durant la journée et un fuseau horaire
*
* @param int id de l'équipe
* @param int id du jour
* @param int id du fuseau horaire
* @return array un tableau avec les infos de l'équipe
*        ['id'] -> l'id du match (game)
*        ['arbitre'] -> le nom de l'arbitre qui arbitre le match
*        ['terrain'] -> le nom du terrain
*        ['idJour'] -> l'id du Jour
*        ['idTime'] -> l'id du fuseau horaire
*        ['Nom'] -> le nom du sport que l'équipe joue pour le match
*        ['played'] -> 1 si la match à été joué, 0 si non
*/
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
