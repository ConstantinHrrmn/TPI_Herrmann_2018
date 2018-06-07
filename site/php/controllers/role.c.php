<?php
/**
* Retourne le nom (intitule) d'un rôle d'après son id
*
* @param int id du Role
* @return array un tableau avec le nom
*        ['intitule'] -> le nom du Role
*/
function GetRoleById($id){
  static $query = null;
  if ($query == null) {
    $req = "SELECT `intitule` FROM `Role` WHERE `id` = :id LIMIT 1";
    $query = connecteur()->prepare($req);
  }
  try {
    $query->bindParam(':id', $id, PDO::PARAM_STR);
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
* Retourne tous les noms (intitule) des rôles de la table Role
*
* @return array un tableau avec les noms
*        ['id'] -> l'id du Role
*        ['intitule'] -> le nom du Role
*/
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
