<?php
// Récupère un coach en fonction de son id
// Si le coach ou l'id n'éxiste pas alors le return sera égal à FALSE
function GetStaffById($id){
  static $query = null;
  if ($query == null) {
    $req = "SELECT `id`, `nom`, `prenom`, `age`, `idRole`, `phone` FROM `Staff` WHERE `id` = :id";
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

// Récupère tout les membres du staff
function GetAllStaff(){
  static $query = null;
  if ($query == null) {
    $req = "SELECT `id`, `nom`, `prenom`, `age`, `idRole`, `phone` FROM `Staff`";
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

function AddStaff($nom, $prenom, $idRole){
  static $query = null;

  if ($query == null) {
    $req = "INSERT INTO `Staff`(`nom`, `prenom`, `idRole`) VALUES (:nom, :prenom, :idRole)";
    $query = connecteur()->prepare($req);
  }
  try {
    $query->bindParam(':nom', $nom, PDO::PARAM_STR);
    $query->bindParam(':prenom', $prenom, PDO::PARAM_STR);
    $query->bindParam(':idRole', $idRole, PDO::PARAM_STR);
    $query->execute();
    $query->fetch();
  }
  catch (Exception $e) {
    error_log($e->getMessage());
  }
}

function UpdateStaff($id, $nom, $prenom, $idRole){
  static $query = null;

  if ($query == null) {
    $req = "UPDATE `Staff` SET `nom`= :nom,`prenom`= :prenom,`idRole`= :role WHERE `id` = :id";
    $query = connecteur()->prepare($req);
  }
  try {
    $query->bindParam(':id', $id, PDO::PARAM_STR);
    $query->bindParam(':nom', $nom, PDO::PARAM_STR);
    $query->bindParam(':prenom', $prenom, PDO::PARAM_STR);
    $query->bindParam(':role', $idRole, PDO::PARAM_STR);
    $query->execute();
    $query->fetch();
  }
  catch (Exception $e) {
    error_log($e->getMessage());
  }
}

function DeleteStaff($id){

  RemoveCoachFromHisTeam($id);

  if ($query == null) {
    $req = "DELETE FROM `Staff` WHERE `id` = :id";
    $query = connecteur()->prepare($req);
  }
  try {
    $query->bindParam(':id', $id, PDO::PARAM_STR);
    $query->execute();
    $query->fetch();
  }
  catch (Exception $e) {
    error_log($e->getMessage());
  }
}

// Retourne tout les coachs
function GetAllCoachsWithoutTeam(){
  $req = "SELECT `id`, `nom`, `prenom` FROM `Staff` WHERE `idRole` = 2 AND `id` NOT IN (SELECT idCoach FROM TEAMS WHERE id != 0) ORDER BY `prenom`";
  $sth = connecteur()->prepare($req);
  $sth->execute();
  return ($sth->fetchAll(PDO::FETCH_ASSOC));
}

function RemoveCoachFromHisTeam($idCoach){
  if ($query == null) {
    $req = "UPDATE `Teams` SET `idCoach`= -1 WHERE `idCoach` = :idCoach";
    $query = connecteur()->prepare($req);
  }
  try {
    $query->bindParam(':idCoach', $idCoach, PDO::PARAM_STR);
    $query->execute();
    $query->fetch();
  }
  catch (Exception $e) {
    error_log($e->getMessage());
  }
}

// Retourne tout les coachs
function GetArbitres(){
  $req = "SELECT `id`, `nom`, `prenom` FROM `Staff` WHERE `idRole` = 3 ORDER BY `prenom`";
  $sth = connecteur()->prepare($req);
  $sth->execute();
  return ($sth->fetchAll(PDO::FETCH_ASSOC));
}

// Verifie si l'id est un admin ou non
function IsAdmin($id){
  static $query = null;

  if ($query == null) {
    $req = "SELECT `Staff`.`prenom` FROM `Staff` WHERE `Staff`.`idRole` = (SELECT `Role`.`id` FROM `Role` WHERE `Role`.`intitule` = 'Admin') AND `Staff`.`id` = :id";
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

  if ($res != false)
  return true;
  else
  return false;
}
