<?php

include "pdo.php";

// Le login retourne un utilisateur d'après son prénom et mot de passe si il existe
// Si l'utilisateur n'existe pas le return sera égal a FALSE
function login($id, $pass){
  $req = "SELECT `id`, `nom`, `prenom`, `age`, `idRole` FROM `Staff` WHERE `prenom` = :id AND `nom` = :pass";
  $query = connecteur()->prepare($req);
  $query->bindParam(':id', $id, PDO::PARAM_STR);
  $query->bindParam(':pass', $pass, PDO::PARAM_STR);
  $query->execute();
  $user = $query->fetch(PDO::FETCH_ASSOC);
  return $user;
}

// Récupère tout les jours
// Retourne sous forme de array
function GetAllDays(){
  $req = "SELECT `id`, `nomJour` FROM `Day`";
  $array = (connecteur()->query($req, PDO::FETCH_NUM)->fetchAll());
  return $array;
}

// Récupère toutes les équipes de la base de données
function GetAllteams(){
  $req = "SELECT `id`, `nom`, `idCoach`, `p_A` + `p_B` + `p_C` as total, `m_A`-`r_A` + `m_B`-`r_B` + `m_C`-`r_C` as totalDiff FROM `Teams` ORDER BY `id` ASC";
  $query = connecteur()->prepare($req);
  $query->execute();
  $teams = $query->fetchAll(PDO::FETCH_ASSOC);
  return $teams;
}

// Récupère un coach en fonction de son id
// Si le coach ou l'id n'éxiste pas alors le return sera égal à FALSE
function GetStaffById($id){
  $req = "SELECT `id`, `nom`, `prenom`, `age`, `idRole`, `phone` FROM `Staff` WHERE `id` = :id";
  $query = connecteur()->prepare($req);
  $query->bindParam(':id', $id, PDO::PARAM_STR);
  $query->execute();
  $coach = $query->fetch(PDO::FETCH_ASSOC);
  return $coach;
}

// Récupère tout les membres du staff
function GetAllStaff(){
  $req = "SELECT `id`, `nom`, `prenom`, `age`, `idRole`, `phone` FROM `Staff`";
  $query = connecteur()->prepare($req);
  $query->execute();
  $coach = $query->fetchAll(PDO::FETCH_ASSOC);
  return $coach;
}

// Retourne une équipe d'après son id
// Retourne FALSE si aucune équipe ne correspond à l'id reçu
function GetTeamById($id){
  $req = "SELECT `id`, `nom`, `idCoach` FROM `Teams` WHERE `id` = :id LIMIT 1";
  $query = connecteur()->prepare($req);
  $query->bindParam(':id', $id, PDO::PARAM_STR);
  $query->execute();
  return ($query->fetch(PDO::FETCH_ASSOC));
}

// Récupère l'équipe d'un coach d'après son ID
function GetTeamByCoachId($id){
  $req = "SELECT `id`, `nom` FROM `Teams` WHERE `idCoach` = :id LIMIT 1";
  $query = connecteur()->prepare($req);
  $query->bindParam(':id', $id, PDO::PARAM_STR);
  $query->execute();
  return ($query->fetch(PDO::FETCH_ASSOC));
}

// Retourne tout les coachs
function GetAllCoachsWithoutTeam(){
  $req = "SELECT `id`, `nom`, `prenom` FROM `Staff` WHERE `idRole` = 2 AND `id` NOT IN (SELECT idCoach FROM TEAMS WHERE id != 0) ORDER BY `prenom`";
  $sth = connecteur()->prepare($req);
  $sth->execute();
  return ($sth->fetchAll(PDO::FETCH_ASSOC));
}

// Retourne tout les coachs
function GetArbitres(){
  $req = "SELECT `id`, `nom`, `prenom` FROM `Staff` WHERE `idRole` = 3 ORDER BY `prenom`";
  $sth = connecteur()->prepare($req);
  $sth->execute();
  return ($sth->fetchAll(PDO::FETCH_ASSOC));
}

// Met a jour une équipe a l'index indiqué
// Mise a jour du nom de l'équipe et l'id du coach
function UpdateTeam($idTeam, $name, $idCoach){
  $req = "UPDATE `Teams` SET `nom`= :nom,`idCoach`= :coach WHERE `id` = :id";
  $query = connecteur()->prepare($req);
  $query->bindParam(':id', $idTeam, PDO::PARAM_STR);
  $query->bindParam(':nom', $name, PDO::PARAM_STR);
  $query->bindParam(':coach', $idCoach, PDO::PARAM_STR);
  $query->execute();
  $query->fetch();
}

// Récupère le classement sélectionner
// A = Kinball
// B = Tchouckball
// C = Course agile
function GetClassement($classement){
  $req = "SELECT `id`, `nom`, `p_$classement` as points,`m_$classement` as marques, `r_$classement` as recus, `m_$classement`-`r_$classement` as difference FROM `Teams` ORDER BY `p_$classement` DESC, `m_$classement`-`r_$classement` DESC";
  $query = connecteur()->prepare($req);
  $query->execute();
  $teams = $query->fetchAll(PDO::FETCH_ASSOC);
  return $teams;
}

// Récupère le role grace a son id
function GetRoleById($id){
  $req = "SELECT `intitule` FROM `Role` WHERE `id` = :id LIMIT 1";
  $query = connecteur()->prepare($req);
  $query->bindParam(':id', $id, PDO::PARAM_STR);
  $query->execute();
  return ($query->fetch(PDO::FETCH_ASSOC));
}

// Récupère tous les jours
function GetDays(){
  $req = "SELECT `id`, `nomJour` FROM `Day` ";
  $query = connecteur()->prepare($req);
  $query->execute();
  $teams = $query->fetchAll(PDO::FETCH_ASSOC);
  return $teams;
}
 // Récupère tous les terrains
function GetFields(){
  $req = "SELECT `id`, `Nom` FROM `Field`";
  $query = connecteur()->prepare($req);
  $query->execute();
  $teams = $query->fetchAll(PDO::FETCH_ASSOC);
  return $teams;
}

// Récupères toutes les heures
function GetTimes(){
  $req = "SELECT `id`, `start`, `end` FROM `Time`";
  $query = connecteur()->prepare($req);
  $query->execute();
  $teams = $query->fetchAll(PDO::FETCH_ASSOC);
  return $teams;
}

// Récupère toutes les équipes
function GetTeams(){
  $req = "SELECT `id`, `nom` FROM `Teams`";
  $query = connecteur()->prepare($req);
  $query->execute();
  $teams = $query->fetchAll(PDO::FETCH_ASSOC);
  return $teams;
}

// Création d'un nouveau MATCH
// $Time -> L'id de l'heure à laquelle à lieu le match
// $day -> L'id du jour ou à lieu le match
// $field -> L'id du terrains
// $arbitre -> L'id de l'Arbitres
// $Teams -> un tableau avec les id des équipes qui jouent le match
function CreateNewGame($time, $day, $field, $arbitre, $teams, $sport){
  $req = "INSERT INTO `Games`(`idArbitre`, `idTerrain`, `idJour`, `idTime`, `idSport`) VALUES (:arbitre,:terrain,:jour,:heure,:sport)";
  $query = connecteur()->prepare($req);
  $query->bindParam(':arbitre', $arbitre, PDO::PARAM_INT);
  $query->bindParam(':terrain', $field, PDO::PARAM_INT);
  $query->bindParam(':jour', $day, PDO::PARAM_INT);
  $query->bindParam(':heure', $time, PDO::PARAM_INT);
  $query->bindParam(':sport', $sport, PDO::PARAM_INT);
  $query->execute();
  $query->fetch();

  $id = connecteur()->lastInsertId();

  for ($team=0; $team < count($teams); $team++) {
    $req = "INSERT INTO `plays`(`idTeam`, `idGame`) VALUES (:team, :game)";
    $query = connecteur()->prepare($req);
    $query->bindParam(':team', $teams[$team], PDO::PARAM_STR);
    $query->bindParam(':game', $id, PDO::PARAM_STR);
    $query->execute();
    $query->fetch();
  }

}

function GetSportTypes(){
  $req = "SELECT `id`, `Nom`, `nbEquipes` FROM `Sport`";
  $query = connecteur()->prepare($req);
  $query->execute();
  $teams = $query->fetchAll(PDO::FETCH_ASSOC);
  return $teams;
}
