<?php
// Récupères toutes les heures
function GetTimes(){
  $req = "SELECT `id`, `start`, `end` FROM `Time`";
  $query = connecteur()->prepare($req);
  $query->execute();
  $teams = $query->fetchAll(PDO::FETCH_ASSOC);
  return $teams;
}

function GetAllTimesOnDay($id){
  $req = "SELECT `idTime` FROM `Games` WHERE `idJour` = :idJour GROUP BY `idTime`";
  $query = connecteur()->prepare($req);
  $query->bindParam(':idJour', $id, PDO::PARAM_STR);
  $query->execute();
  $times = $query->fetchAll(PDO::FETCH_ASSOC);
  return $times;
}

function GetTimeById($id){

  static $query = null;

  if ($query == null) {
    $req = "SELECT `start`, `end` FROM `Time` WHERE `id` = :id";
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
