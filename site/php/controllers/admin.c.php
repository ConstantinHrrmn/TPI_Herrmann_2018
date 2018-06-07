<?php
/**
* ResetCamp permet de faire un reset du Camp
* Remise à zéro de tout les classements
* Efface le contenu de la table Games
* Efface toutes les référence dans la table 'plays'
*/
function ResetCamp(){
  static $query = null;

  if ($query == null) {
    $req = "UPDATE `Teams` SET `nom`= 'No name',`idCoach`= 0,`p_A`=0,`m_A`=0,`r_A`=0,`p_B`=0,`m_B`=0,`r_B`=0,`p_C`=0,`m_C`=0,`r_C`=0; DELETE FROM `Games`;";
    $query = connecteur()->prepare($req);
  }
  try {
    $query->execute();
    $query->fetch();
  }
  catch (Exception $e) {
    error_log($e->getMessage());
  }
}
