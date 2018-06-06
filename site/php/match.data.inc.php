<?php

function GetAllMatchInfos($id){
  $match = [];
  $req = "SELECT `Games`.`id` as id, `Games`.`played` as played, `Field`.`nom` as terrain, `Staff`.`prenom` as arbitre FROM `Games` INNER JOIN `Field` ON `idTerrain` = `Field`.`id` INNER JOIN `Staff` ON `idArbitre` = `Staff`.`id` WHERE `Games`.`id` = :id LIMIT 1";
  $query = connecteur()->prepare($req);
  $query->bindParam(':id', $id, PDO::PARAM_STR);
  $query->execute();
  $res = $query->fetch(PDO::FETCH_ASSOC);
  $match['infos'] = $res;

  $req = "SELECT `Teams`.`id` as numero, `Teams`.`nom` as nom, `score` FROM `Teams`, `plays` WHERE `Teams`.`id` IN (SELECT `idTeam` FROM `plays` WHERE `idGame` = :id) AND `plays`.`idGame` = :id AND `Teams`.`id` = `plays`.`idTeam`";
  $query = connecteur()->prepare($req);
  $query->bindParam(':id', $id, PDO::PARAM_STR);
  $query->execute();
  $res = $query->fetchAll(PDO::FETCH_ASSOC);
  $match['teams'] = $res;

  return $match;
}
