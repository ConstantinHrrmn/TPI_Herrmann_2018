<?php
/*******************************************************************************
AUTEUR      : Constantin Herrmann
LIEU        : CFPT Informatique Genève
DATE        : 14.06.2018

TITRE PROJET: KidsGames Geneva Score

TITRE PAGE  : time.c
DESCRIPTION : Ce script contient toutes les fonctions concernant les heures
VERSION     : 1.0
*******************************************************************************/

// Récupères toutes les heures
/**
* Récupère tout les fuseaux horaires de la table Time
*
* @return array un tableau avec tout les fuseaux horaires
*     [index]
*        ['id'] -> l'id du fuseaux
*        ['start'] -> l'heure de début
*        ['end'] -> l'heure de fin
*/
function GetTimes(){
  static $query = null;

  if ($query == null) {
    $req = "SELECT `id`, `start`, `end` FROM `Time`";
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

/**
* Récupère tout les fuseaux horaires de la table Time pour une journeée (day)
*
* @param string id du jour
* @return array un tableau avec tout les fuseaux horaires
*     [index]
*        ['idTime'] -> l'id du fuseaux
*/
function GetAllTimesOnDay($id){
  static $query = null;

  if ($query == null) {
    $req = "SELECT `idTime` FROM `Games` WHERE `idJour` = :idJour GROUP BY `idTime`";
    $query = connecteur()->prepare($req);
  }
  try {
      $query->bindParam(':idJour', $id, PDO::PARAM_STR);
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
* Récupère les infos du fuseaux horaire d'après son id
*
* @param string id du fuseaux horaire
* @return array un tableau avec tout les fuseaux horaires
*        ['id'] -> l'id
*        ['start'] -> l'heure de début
*        ['end'] -> l'heure de fin
*/
function GetTimeById($id){
  static $query = null;

  if ($query == null) {
    $req = "SELECT `id`, `start`, `end` FROM `Time` WHERE `id` = :id";
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
* Récupère l'heure de début et l'heure de fin d'un match
*
* @param string $idGame -> l'id du match
* @return array un tableau avec le nombre de matchs
*              ['debut'] -> l'heure du début
*              ['fin'] -> l'heure de fin
*/
function GetTimeForMatch($idGame){
  static $query = null;

  if ($query == null) {
    $req = "SELECT `Time`.`start` as debut, `Time`.`end` as fin FROM `Time` WHERE `Time`.`id` IN (SELECT `Games`.`idTime` FROM `Games` WHERE `Games`.`id` = :idGame)";
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
