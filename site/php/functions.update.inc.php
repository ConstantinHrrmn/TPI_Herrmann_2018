<?php
include "pdo.php";
include "match.data.inc.php";

function UpdateScore($Teams, $idGame){

  $old_results = GetMatchResults($idGame);

  for ($team=0; $team < count($Teams); $team++) {
    $idTeam = $Teams[$team]['infos']['numero'];
    $score = $Teams[$team]['score'];

    $old_score = GetScoreForTeamInMatch($idTeam, $idGame);

    if ($old_score != false) {
      $new_score = $score - $old_score['score'];
    }

    static $query = null;

    if ($query == null) {
      $req = "UPDATE `plays` SET `score`= :score WHERE `idTeam` = :idTeam AND `idGame` = :idGame";
      $query = connecteur()->prepare($req);
    }
    try {
      $query->bindParam(':idTeam', $idTeam, PDO::PARAM_STR);
      $query->bindParam(':idGame', $idGame, PDO::PARAM_STR);
      $query->bindParam(':score', $score, PDO::PARAM_STR);
      $query->execute();
      $query->fetch();
    }
    catch (Exception $e) {
      error_log($e->getMessage());
    }
  }

  $classment = GetTypeOfClassement($idGame);
  $c_label = null;
  if ($classment['sport'] == 1) {
    $c_label = 'B';
  }elseif ($classment['sport'] == 2) {
    $c_label = 'A';
  }elseif ($classment['sport'] == 3) {
    $c_label = 'C';
  }

  $new_results = GetMatchResults($idGame);

  for ($team=0; $team < count($Teams); $team++) {
    $idTeam = $Teams[$team]['infos']['numero'];
    $score = $Teams[$team]['score'];

    $old_provisoire = null;
    $new_provisoire = null;

    for ($res=0; $res < count($old_results); $res++) {
      if ($old_results[$res]['id'] == $idTeam) {
          $old_provisoire = $old_results[$res];
        break;
      }
    }
    for ($res=0; $res < count($new_results); $res++) {
      if ($new_results[$res]['id'] == $idTeam) {
          $new_provisoire = $new_results[$res];
        break;
      }
    }

    //echo '<pre>' , "OLD" , '</pre>';
    //echo '<pre>' , var_dump($old_provisoire) , '</pre>';

    //echo '<pre>' , "NEW" , '</pre>';
    //echo '<pre>' , var_dump($new_provisoire) , '</pre>';

    $main = GetMainClassement($idTeam, $c_label);

    //echo '<pre>' , "ACTUAL CLASSEMENT" , '</pre>';
    //echo '<pre>' , var_dump($c_label) , '</pre>';
    //echo '<pre>' , var_dump($main) , '</pre>';

    $p_label = "p_".$c_label;
    $m_label = "m_".$c_label;
    $r_label = "r_".$c_label;

    $final_new_results = [];

    $final_new_results['p'] = $main['p'] + ($new_provisoire['points'] - $old_provisoire['points']);
    $final_new_results['m'] = $main['m'] + ($new_provisoire['m'] - $old_provisoire['m']);
    $final_new_results['r'] = $main['r'] + ($new_provisoire['r'] - $old_provisoire['r']);
    //echo '<pre>' , "THE NEW DATA" , '</pre>';
    //echo '<pre>' , var_dump($final_new_results) , '</pre>';

    UpdateMainTable($idTeam, $final_new_results['p'], $final_new_results['m'], $final_new_results['r'], $c_label);

    $main = GetMainClassement($idTeam, $c_label);
    //echo '<pre>' , "NEW CLASSEMENT" , '</pre>';
    //echo '<pre>' , var_dump($main) , '</pre>';
  }
}

function GetMainClassement($idTeam, $classment){
  static $query = null;
  if ($query == null) {
    $req = "SELECT `id`, `p_".$classment."` as p, `m_".$classment."` as m, `r_".$classment."` as r FROM `Teams` WHERE `id` = :idTeam";
    $query = connecteur()->prepare($req);
  }
  try {
    $query->bindParam(':idTeam', $idTeam, PDO::PARAM_STR);
    $query->execute();

    $res = $query->fetch(PDO::FETCH_ASSOC);
  }
  catch (Exception $e) {
    error_log($e->getMessage());
    $res = false;
  }
  return $res;
}

function GetMatchResults($idGame){
  static $query = null;

  if ($query == null) {
    $req = "SELECT `idTeam` as id, `score` FROM `plays` WHERE `idGame` = :idGame ORDER BY `score` DESC";
    $query = connecteur()->prepare($req);
  }

  try {
      $query->bindParam(':idGame', $idGame, PDO::PARAM_STR);
      $query->execute();
      $res = $query->fetchAll(PDO::FETCH_ASSOC);
  }
  catch (Exception $e) {
    error_log($e->getMessage());
    $res = false;
  }

  $result = $res;
  $old_points = MakeTheResults($result);
  return $old_points;
}

function MakeTheResults($teams){
  $result = [];

  for ($temp=0; $temp < count($teams); $temp++) {
    $result[$temp]['id'] = $teams[$temp]['id'];
    $result[$temp]['m'] = $teams[$temp]['score'];
    $result[$temp]['r'] = 0;
    $result[$temp]['d'] = $teams[$temp]['score'];
    $result[$temp]['points'] = 0;
    for ($r=0; $r < count($teams); $r++) {
      if ($r != $temp) {
        $result[$temp]['d'] = $result[$temp]['d'] - $teams[$r]['score'];
        $result[$temp]['r'] = $result[$temp]['r'] + $teams[$r]['score'];
      }
    }
  }
  $result = MakethePoints($result);
  return $result;
}

function MakethePoints($teams){
  $table = $teams;

  if (count($teams) == 2) {
    $t1 = $teams[0]['m'];
    $t2 = $teams[1]['m'];

    if ($t1 > $t2) {
      $table[0]['points'] = 3;
      $table[1]['points'] = 0;
    }elseif ($t1 == $t2) {
      $d1 = $table[0]['d'];
      $d2 = $table[1]['d'];
      if ($d1 == $d2 && $d1 == 0) {
        $table[0]['points'] = 0;
        $table[1]['points'] = 0;
      }else{
        $table[0]['points'] = 1;
        $table[1]['points'] = 1;
      }
    }else{
      $table[0]['points'] = 0;
      $table[1]['points'] = 3;
    }

  }elseif(count($teams) == 3){
    $t1 = $teams[0]['m'];
    $t2 = $teams[1]['m'];
    $t3 = $teams[2]['m'];
    if ($t1 > $t2 && $t1 > $t3) {
      $table[0]['points'] = 3;
      if ($t2 > $t3) {
        $table[1]['points'] = 1;
        $table[2]['points'] = 0;
      }elseif ($t2 == $t3) {
        $table[1]['points'] = 1;
        $table[2]['points'] = 1;
      }
    }elseif ($t1 == $t2 && $t1 > $t3) {
      $table[0]['points'] = 1;
      $table[1]['points'] = 1;
      $table[2]['points'] = 0;
    }
    elseif ($t1 == $t2 && $t1 == $t3) {
      $d1 = $table[0]['d'];
      $d2 = $table[1]['d'];
      $d3 = $table[2]['d'];
      if ($d1 == $d2 && $d1 == $d3) {
        $table[0]['points'] = 0;
        $table[1]['points'] = 0;
        $table[2]['points'] = 0;
      }else{
        $table[0]['points'] = 1;
        $table[1]['points'] = 1;
        $table[2]['points'] = 1;
      }

    }
  }

  return $table;
}

function UpdateMainTable($idTeam, $points_to_add, $points_m, $points_r, $classement){
  try {
    $req = "UPDATE `Teams` SET `p_$classement` = $points_to_add,`m_$classement` = $points_m,`r_$classement` = $points_r WHERE `id` = $idTeam";
    $query = connecteur()->prepare($req);
    $query->execute();
    $query->fetch();
  }
  catch (Exception $e) {
    error_log($e->getMessage());
  }
}

function GetTypeOfClassement($idGame){
  static $query = null;

  if ($query == null) {
    //$req = "SELECT `Nom` FROM `Field` WHERE `id` IN (SELECT `Games`.`idTerrain` FROM `Games` WHERE `Games`.`id` = :idGame)";
    $req = "SELECT `idSport` as sport FROM `Games` WHERE `id` = :idGame";
    $query = connecteur()->prepare($req);
  }
  try {
    $query->bindParam(':idGame', $idGame, PDO::PARAM_STR);
    $query->execute();
    $res = $query->fetch(PDO::FETCH_ASSOC);
  }
  catch (Exception $e) {
    error_log($e->getMessage());
    $res = false;
  }
  return $res;
}

function SetGameToDone($id){
  static $query = null;

  if ($query == null) {
    $req = "UPDATE `Games` SET `played`= 1 WHERE `id` = :id";
    $query = connecteur()->prepare($req);
  }
  try {
    $query->bindParam(':id', $id, PDO::PARAM_STR);
    $query->execute();
    $query->fetch();
  }
  catch (Exception $e) {
    error_log($e->getMessage());
  }
}

function GetScoreForTeamInMatch($idTeam, $idGame){
  static $query = null;

  if ($query == null) {
    $req = "SELECT `score` FROM `plays` WHERE `idTeam` = :idTeam AND `idGame` = :idGame";
    $query = connecteur()->prepare($req);
  }
  try {
    $query->bindParam(':idTeam', $idTeam, PDO::PARAM_STR);
    $query->bindParam(':idGame', $idGame, PDO::PARAM_STR);
    $query->execute();
    $res = $query->fetch(PDO::FETCH_ASSOC);
  }
  catch (Exception $e) {
    error_log($e->getMessage());
    $res = false;
  }
  return $res;
}
