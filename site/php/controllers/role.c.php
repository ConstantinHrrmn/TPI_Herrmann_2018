<?php


// Récupère le role grace a son id
function GetRoleById($id){
  $req = "SELECT `intitule` FROM `Role` WHERE `id` = :id LIMIT 1";
  $query = connecteur()->prepare($req);
  $query->bindParam(':id', $id, PDO::PARAM_STR);
  $query->execute();
  return ($query->fetch(PDO::FETCH_ASSOC));
}

function GetAllRoles(){
  static $query = null;
  if ($query == null) {
    $req = "SELECT `id`, `intitule` FROM `Role`";
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
