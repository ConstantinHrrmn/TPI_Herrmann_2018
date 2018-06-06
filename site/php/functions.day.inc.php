<?php
include "pdo.php";
include "match.data.inc.php";
include "functions.times.inc.php";


function GetMatchsOnDayAndTime($day, $time){
  $req = "SELECT `id` FROM `Games` WHERE `idJour` = :day AND `idTime` = :time";
  $query = connecteur()->prepare($req);
  $query->bindParam(':day', $day, PDO::PARAM_STR);
  $query->bindParam(':time', $time, PDO::PARAM_STR);
  $query->execute();
  $res = $query->fetchAll(PDO::FETCH_ASSOC);
  return $res;
}
