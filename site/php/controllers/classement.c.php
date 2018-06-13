<?php
/**
* Récupère le classement sélectionner
* A = Kinball
* B = Tchouckball
* C = Course agile
*
* @param string l'id du match
* @param array le match en question
* @return array un tableau avec le classement
*           [index]
*              ['id'] -> l'id de l'équipe
*              ['nom'] -> le nom de l'équipe
*              ['points'] -> les points de l'équipe
*              ['marques'] -> score marqué par l'équipe
*              ['recus'] -> nombre de score encaisser
*              ['difference'] -> la différence des scores
*/
function GetClassement($classement){
  try {
    $req = "SELECT `id`, `nom`, `p_$classement` as points,`m_$classement` as marques, `r_$classement` as recus, `m_$classement`-`r_$classement` as difference FROM `Teams` ORDER BY `p_$classement` DESC, `m_$classement`-`r_$classement` DESC";
    $query = connecteur()->prepare($req);
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
 * Retourne le classement principale pour une équipe dans un classement
 *
 * @param string l'id de l'équipe
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
