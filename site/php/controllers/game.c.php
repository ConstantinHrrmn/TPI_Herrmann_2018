<?php
// Création d'un nouveau MATCH
// $Time -> L'id de l'heure à laquelle à lieu le match
// $day -> L'id du jour ou à lieu le match
// $field -> L'id du terrains
// $arbitre -> L'id de l'Arbitres
// $Teams -> un tableau avec les id des équipes qui jouent le match
function CreateNewGame($time, $day, $field, $arbitre, $teams, $sport){
  static $query = null;
  if ($query == null) {
    $req = "INSERT INTO `Games`(`idArbitre`, `idTerrain`, `idJour`, `idTime`, `idSport`) VALUES (:arbitre,:terrain,:jour,:heure,:sport)";
    $query = connecteur()->prepare($req);
  }
  try {
    $query->bindParam(':arbitre', $arbitre, PDO::PARAM_INT);
    $query->bindParam(':terrain', $field, PDO::PARAM_INT);
    $query->bindParam(':jour', $day, PDO::PARAM_INT);
    $query->bindParam(':heure', $time, PDO::PARAM_INT);
    $query->bindParam(':sport', $sport, PDO::PARAM_INT);
    $query->execute();
    $query->fetch();
  }
  catch (Exception $e) {
    error_log($e->getMessage());
  }

  $id = connecteur()->lastInsertId();

  static $query2 = null;
  if ($query2 == null) {
    $req = "INSERT INTO `plays`(`idTeam`, `idGame`) VALUES (:team, :game)";
    $query2 = connecteur()->prepare($req);
  }

  for ($team=0; $team < count($teams); $team++) {
    try {
      $query2->bindParam(':team', $teams[$team], PDO::PARAM_STR);
      $query2->bindParam(':game', $id, PDO::PARAM_STR);
      $query2->execute();
      $query2->fetch();
    }
    catch (Exception $e) {
      error_log($e->getMessage());
    }
  }
}

// Récupère toutes infos du match
// $id -> l'id du match
// Retourne toutes les informations du match
function GetAllMatchInfos($id){
  $match = [];
  $req = "SELECT `Games`.`id` as id, `Games`.`played` as played, `Field`.`nom` as terrain, `Staff`.`prenom` as arbitre FROM `Games` INNER JOIN `Field` ON `idTerrain` = `Field`.`id` INNER JOIN `Staff` ON `idArbitre` = `Staff`.`id` WHERE `Games`.`id` = :id LIMIT 1";
  $query = connecteur()->prepare($req);
  $query->bindParam(':id', $id, PDO::PARAM_STR);
  $query->execute();
  $res = $query->fetch(PDO::FETCH_ASSOC);
  $match['infos'] = $res;

  $req = "SELECT `Teams`.`id` as numero, `Teams`.`nom` as nom, `score` FROM `Teams`, `plays` WHERE `Teams`.`id` IN (SELECT `idTeam` FROM `plays` WHERE `idGame` = :id) AND `plays`.`idGame` = :id AND `Teams`.`id` = `plays`.`idTeam`";
  $query = connecteur()->prepare($req);
  $query->bindParam(':id', $id, PDO::PARAM_STR);
  $query->execute();
  $res = $query->fetchAll(PDO::FETCH_ASSOC);
  $match['teams'] = $res;

  return $match;
}

// Regarde si l'id du staff est soit un administrateur soit l'arbitre du match en question
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
