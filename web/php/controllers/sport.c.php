<?php
/*******************************************************************************
AUTEUR      : Constantin Herrmann
LIEU        : CFPT Informatique Genève
DATE        : 14.06.2018

TITRE PROJET: KidsGames Geneva Score

TITRE PAGE  : sport.c
DESCRIPTION : Ce script contient toutes les fonctions concernant les sports
VERSION     : 1.0
*******************************************************************************/

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

/**
* Retourne tous le sport d'après son id
*
* @param string l'id du sport
* @return array un tableau avec le sport
*        ['id'] -> l'id du sport
*        ['Nom'] -> le nom du sport
*        ['nbEquipes'] -> le nombre d'équipes pour le sport
*/
function GetSportById($id){
  static $query = null;
  if ($query == null) {
    $req = "SELECT `id`, `Nom`, `nbEquipes` FROM `Sport` WHERE `id` = :id";
    $query = connecteur()->prepare($req);
  }
  try {
    $query->bindParam(':id', $id, PDO::PARAM_STR);
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
* Retourne le nombre de joueur pour un sport d'après son id
*
* @param string le nombre de joueurs
* @return array un tableau avec le sport
*        ['id'] -> l'id du sport
*        ['Nom'] -> le nom du sport
*        ['nbEquipes'] -> le nombre d'équipes pour le sport
*/
function GetIdsByPlayerCount($count){
  static $query = null;
  if ($query == null) {
    $req = "SELECT `id`, `Nom`, `nbEquipes` FROM `Sport` WHERE `nbEquipes` = :amount";
    $query = connecteur()->prepare($req);
  }
  try {
    $query->bindParam(':amount', $count, PDO::PARAM_STR);
    $query->execute();
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
  }
  catch (Exception $e) {
    error_log($e->getMessage());
    $res = false;
  }
  return $res;
}
