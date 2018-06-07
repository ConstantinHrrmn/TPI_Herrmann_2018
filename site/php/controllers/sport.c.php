<?php
/**
* Retourne tous les types de scores de la table Sport
*
* @return array un tableau avec le nom
*        ['id'] -> l'id du sport
*        ['Nom'] -> le nom du sport
*        ['nbEquipes'] -> le nombre d'équipes pour le sport
*/
function GetSportTypes(){
  static $query = null;
  if ($query == null) {
    $req = "SELECT `id`, `Nom`, `nbEquipes` FROM `Sport`";
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
