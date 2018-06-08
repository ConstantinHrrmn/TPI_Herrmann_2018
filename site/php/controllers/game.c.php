<?php
/**
* Création d'un nouveau MATCH
*
* @param int $Time -> L'id de l'heure à laquelle à lieu le match
* @param int $day -> L'id du jour ou à lieu le match
* @param int $field -> L'id du terrains
* @param int $arbitre -> L'id de l'Arbitres
* @param array $Teams -> un tableau avec les id des équipes qui jouent le match
*/
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

/**
* Récupère toutes infos du match
*
* @param string $id -> l'id du match
* @return array un tableau avec le classement
*           [index]
*              ['id'] -> l'id de l'équipe
*              ['played'] -> 1 si il as été joué, 0 si non
*              ['terrain'] -> le nom du terrain
*              ['arbitre'] -> le prenom de l'arbitre
*/
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



/**
* Récupère toutes infos du match
*
* @param string $id -> l'id du match
* @return array un tableau avec le classement
*           [index]
*              ['id'] -> l'id de l'équipe
*              ['played'] -> 1 si il as été joué, 0 si non
*              ['terrain'] -> le nom du terrain
*              ['arbitre'] -> le prenom de l'arbitre
*/
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

/**
* Récupère le nombre de matchs qui ont lieu au jour indiqué
*
* @param string $id -> l'id du jour
* @return array un tableau avec le nombre de matchs
*              ['matchs'] -> le nombre de matchs
*/
function CountGamesOnDay($idDay){
  static $query = null;

  if ($query == null) {
    $req = "SELECT COUNT(*) as matchs FROM `Games` WHERE `idJour` = :idDay";
    $query = connecteur()->prepare($req);
  }
  try {
    $query->bindParam(':idDay', $idDay, PDO::PARAM_STR);
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
* Supprime un match
*
* @param string $id -> l'id du du match
*/
function DeleteGame($idGame){
  static $query = null;

  if ($query == null) {
    $req = "DELETE FROM `Games` WHERE `id` = :id";
    $query = connecteur()->prepare($req);
  }
  try {
    $query->bindParam(':id', $idGame, PDO::PARAM_STR);
    $query->execute();
    $query->fetch();
  }
  catch (Exception $e) {
    error_log($e->getMessage());
  }
}

/**
* Récupère le match pour l'arbitre à une heure et un jour
*
* @param string $idStaff -> l'id due l'arbitre
* @param string $idDay -> l'id du jour
* @param string $idTime -> l'id du crénau horaire
* @return array un tableau avec le nombre de matchs
*           [index]
*              ['id'] -> l'id du match
*              ['terrain'] -> le nom du terrain
*              ['played'] -> si le match à été jouer ou non
*/
function GetMacthsForArbitreDayAndTime($idStaff, $idDay, $idTime){
  static $query = null;

  if ($query == null) {
    $req = "SELECT `Games`.`id` as id, `Field`.`Nom`as terrain, `Games`.`played` as played FROM `Games` INNER JOIN `Field` ON `Field`.`id` = `Games`.`idTerrain` WHERE `Games`.`idArbitre` = :idStaff AND `Games`.`idJour` = :idDay AND `Games`.`idTime` = :idTime";
    $query = connecteur()->prepare($req);
  }
  try {
    $query->bindParam(':idStaff', $idStaff, PDO::PARAM_STR);
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
