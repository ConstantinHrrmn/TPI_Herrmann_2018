<?php

/**
* Met à jour les scores et le classement général
*
* @param array un tableau contenant les infos des équipes ainsi que les scores obtenus lors du match
* @param int l'id du match dans lequel les scores on été obtenus
*/
function UpdateScore($Teams, $idGame){

  // Va rechercher les infos du match
  $game = GetAllMatchInfos($idGame);

  // Nous récupérons les résultats du match avant la mise à jour des nouveaux résultats
  $old_results = GetMatchResults($idGame, $game);

  // On parcours le tableau des équipes
  for ($team=0; $team < count($Teams); $team++) {

    // On garde l'id de l'équipe dans une variable a part
    $idTeam = $Teams[$team]['infos']['numero'];
    // Idem que pour l'id mais pour le score
    $score = $Teams[$team]['score'];

    // On éffectue la mise a jour du score dans la base de données
    // ATTENTION : On ne met pas la variable $new_score mais bien la variable $score
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

  /* On recherche de quel classement il s'agit
  Tchouckball = B
  KinBall = A
  Course Agile = C */
  $classment = GetTypeOfClassement($idGame);
  $c_label = null;
  if ($classment['sport'] == 1) {
    $c_label = 'B';
  }elseif ($classment['sport'] == 2) {
    $c_label = 'A';
  }elseif ($classment['sport'] == 3) {
    $c_label = 'C';
  }

  // Nous récupérons les résultats du match après la mise a jour des nouveaux résultats
  $new_results = GetMatchResults($idGame, $game);

  // On parcours toutes les équipes du match
  for ($team=0; $team < count($Teams); $team++) {
    // On garde l'id de l'équipe dans une variable a part
    $idTeam = $Teams[$team]['infos']['numero'];
    // Idem que pour l'id mais pour le score
    $score = $Teams[$team]['score'];

    // On déclare 2 variables provisoires représentant le vieux score et le nouveau
    // par défaut on les met a NULL
    $old_provisoire = null;
    $new_provisoire = null;

    // on parcours tout les anciens résultats
    for ($res=0; $res < count($old_results); $res++) {
      // Si l'id du détenteur du résultat est égal a l'id de l'équipe dans la boucle
      if ($old_results[$res]['id'] == $idTeam) {
        // On assigne le score à la variable provisoire : old
        $old_provisoire = $old_results[$res];
        break;
      }
    }

    // Idem que la boucle ci-dessus, sauf que cette fois-ci on le fait pour le nouveau score
    for ($res=0; $res < count($new_results); $res++) {
      if ($new_results[$res]['id'] == $idTeam) {
        $new_provisoire = $new_results[$res];
        break;
      }
    }

    // On va récuperer les données du classement général des équipes
    $main = GetMainClassement($idTeam, $c_label);

    // Création du tableau qui contiendra les nouvelles données à entrer
    $final_new_results = [];

    /*
    On calcule le nombres de points obtenus grace a la formule : points = pointsactuels + (nouveaux_points - anciens_points)

    SI C'EST UN MODIFICATION DE SCORES ERRONES :
    Ex:
      Points actuels = 6;
      nouveaux_points = 1; -> L'équipe à fait égalité avec une autre
      anciens_points = 3; -> L'équipe avait gagné le match, mais c'etait des mauvais résultats

      points = 6 + ( 1 - 3 ) = 4

    SI C'EST UN NOUVEAU MATCH :
    Ex:
      Points actuels = 6;
      nouveaux_points = 3; -> L'équipe à gagné son match
      anciens_points = 0; -> L'équipe n'avait pas encore joué le match

      points = 6 + ( 3 - 0 ) = 9


    On fait idem pour les points marqués et les points reçus
    */
    $final_new_results['p'] = $main['p'] + ($new_provisoire['points'] - $old_provisoire['points']);
    $final_new_results['m'] = $main['m'] + ($new_provisoire['m'] - $old_provisoire['m']);
    $final_new_results['r'] = $main['r'] + ($new_provisoire['r'] - $old_provisoire['r']);

    // On met à jour la table principale
    UpdateMainTable($idTeam, $final_new_results['p'], $final_new_results['m'], $final_new_results['r'], $c_label);
  }
}

/**
* Retourne le classement principale pour une équipe dans un classement
*
* @param int l'id de l'équipe
* @param string l'id du match dans lequel les scores on été obtenus
* @return array {id; p; m; r} ou false si non valide
*/
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

/**
* Retourne un tableau avec les points et les score par équipe pour un match en question
*
* @param int l'id du match
* @param array le match en question
* @return array un tableau avec tout les scores ainsi que les poitns obtenus par équipe
*/
function GetMatchResults($idGame, $game){
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
  // On va créer les résultats pour le match
  $points = MakeTheResults($result, $game);
  return $points;
}

/**
* Retourne un tableau avec les points et les score par équipe pour un match en question
*
* @param array les équipes qui ont participer au match
* @param array le match en question
* @return array un tableau avec tout les points obtenus par équipe
*/
function MakeTheResults($teams, $game){
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
  // Création des points d'après leur position dans le match
  $result = MakethePoints($result, $game);
  return $result;
}

/**
* Caclucule les points pour chaque équipe
*
* @param array les équipes
* @param array le match en question
* @return array un tableau avec tout les points pour chaque équipe
*/
function MakethePoints($teams, $game){
  $table = $teams;

  // Si il y a 2 équipes (Tchouckball)
  if (count($teams) == 2) {
    // On récupère les points marqués par les équipes
    $t1 = $teams[0]['m'];
    $t2 = $teams[1]['m'];

    // Si les score de la première équipe est plus grand que celui de la deuxième
    if ($t1 > $t2) {
      // Le gagnant reçois 3 points et le perdant 0
      $table[0]['points'] = 3;
      $table[1]['points'] = 0;
    }
    // Si les deux scores sont à égalité
    elseif ($t1 == $t2) {
      // On vérifie si c'est un nouveau match ou si il à déjà été joué (donc MODIFICATION)
      if ($game['infos']['played'] == 1) {
        $table[0]['points'] = 1;
        $table[1]['points'] = 1;
      }else{
        $table[0]['points'] = 0;
        $table[1]['points'] = 0;
      }
    }
    // Si le score de la première équipe est plus petit que le score de la deuxième
    else{
      // Le gagnant reçois 3 points et le perdant 0
      $table[0]['points'] = 0;
      $table[1]['points'] = 3;
    }

  }
  // Si il y a 3 équipes (KinBall et course agile)
  elseif(count($teams) == 3){
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
    }elseif ($t1 == $t2 && $t1 == $t3) {
      if ($game['infos']['played'] == 1) {
        $table[0]['points'] = 1;
        $table[1]['points'] = 1;
        $table[2]['points'] = 1;
      }else{
        $table[0]['points'] = 0;
        $table[1]['points'] = 0;
        $table[2]['points'] = 0;
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
