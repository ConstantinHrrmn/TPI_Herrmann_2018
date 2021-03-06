<?php
/*******************************************************************************
AUTEUR      : Constantin Herrmann
LIEU        : CFPT Informatique Genève
DATE        : 14.06.2018

TITRE PROJET: KidsGames Geneva Score

TITRE PAGE  : field.c
DESCRIPTION : Ce script contient toutes les fonctions concernant les terrains
VERSION     : 1.0
*******************************************************************************/

/**
* Récupère tout les terrains
*
* @return array un tableau avec les terrains
*           [index]
*              ['id'] -> l'id du terrain
*              ['Nom'] -> le nom du terrain
*/
function GetFields(){
 static $query = null;
 if ($query == null) {
   $req = "SELECT `id`, `Nom` FROM `Field`";
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
* Récupère un terrain d'après son id
*
* @param string l'id du terrain
* @return array un tableau avec le terrain
*              ['id'] -> l'id du terrain
*              ['Nom'] -> le nom du terrain
*/
function GetFieldById($id){
 static $query = null;
 if ($query == null) {
   $req = "SELECT `id`, `Nom` FROM `Field` WHERE `id` = :id";
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
