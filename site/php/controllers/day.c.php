<?php

// Récupère tous les jours
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

// Récupère tout les matchs
// Paramètres :
//    $day -> L'id du jour
//    $time -> l'id du crénau horaire
// Retourne tout les matchs qui ont lieu
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
