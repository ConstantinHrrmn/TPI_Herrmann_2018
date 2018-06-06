<?php
function GetSportTypes(){
  $req = "SELECT `id`, `Nom`, `nbEquipes` FROM `Sport`";
  $query = connecteur()->prepare($req);
  $query->execute();
  $teams = $query->fetchAll(PDO::FETCH_ASSOC);
  return $teams;
}
