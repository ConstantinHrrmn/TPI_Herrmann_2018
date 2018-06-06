<?php

// Récupère le classement sélectionner
// A = Kinball
// B = Tchouckball
// C = Course agile
function GetClassement($classement){
  $req = "SELECT `id`, `nom`, `p_$classement` as points,`m_$classement` as marques, `r_$classement` as recus, `m_$classement`-`r_$classement` as difference FROM `Teams` ORDER BY `p_$classement` DESC, `m_$classement`-`r_$classement` DESC";
  $query = connecteur()->prepare($req);
  $query->execute();
  $teams = $query->fetchAll(PDO::FETCH_ASSOC);
  return $teams;
}
