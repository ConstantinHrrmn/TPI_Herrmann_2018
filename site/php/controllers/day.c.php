<?php

/**
* Récupère tout les jours
*
* @return array un tableau avec tout les jours
*           [index]
*              ['id'] -> l'id du jour
*              ['nomJour'] -> le nom du jour
*/
function GetDays(){
  static $query = null;
  if ($query == null) {
    $req = "SELECT `id`, `nomJour` FROM `Day`";
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
* Récupère tout les matchs
*
* @param int l'id du jour
* @param int l'id du crénau horaire
* @return array un tableau avec le classement
*           [index]
*              ['id'] -> l'id de l'équipe
*/
function GetMatchsOnDayAndTime($day, $time){
  static $query = null;
  if ($query == null) {
    $req = "SELECT `id` FROM `Games` WHERE `idJour` = :day AND `idTime` = :time";
    $query = connecteur()->prepare($req);
  }
  try {
    $query->bindParam(':day', $day, PDO::PARAM_STR);
    $query->bindParam(':time', $time, PDO::PARAM_STR);
    $query->execute();

    $res = $query->fetchAll(PDO::FETCH_ASSOC);
  }
  catch (Exception $e) {
    error_log($e->getMessage());
    $res = false;
  }
  return $res;
}
