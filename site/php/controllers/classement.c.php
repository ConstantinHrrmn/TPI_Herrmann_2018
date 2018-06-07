<?php
/**
* Récupère le classement sélectionner
* A = Kinball
* B = Tchouckball
* C = Course agile
*
* @param int l'id du match
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
  static $query = null;
  if ($query == null) {
    $req = "SELECT `id`, `nom`, `p_$classement` as points,`m_$classement` as marques, `r_$classement` as recus, `m_$classement`-`r_$classement` as difference FROM `Teams` ORDER BY `p_$classement` DESC, `m_$classement`-`r_$classement` DESC";
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
