<?php
/*******************************************************************************
AUTEUR      : Constantin Herrmann
LIEU        : CFPT Informatique Genève
DATE        : 14.06.2018

TITRE PROJET: KidsGames Geneva Score

TITRE PAGE  : deleteMatch
DESCRIPTION : Ce script permet de supprimer un match
VERSION     : 1.0
*******************************************************************************/

// On vérifie si l'utilisateur est connecté et qu'il s'agit bien d'un administrateur
include "functions.inc.php";
if (isset($_GET['id'])) {
  // On vérifie si l'utilisateur est connecté et qu'il s'agit bien d'un administrateur
  if (isset($_SESSION['user']) || $_SESSION['user']['idRole'] == "1") {
    // On récupère l'id
    $id = $_GET['id'];
    $match = GetAllMatchInfos($id);

    // On vérifie bien que le match n'as pas été joué
    if ($match['infos']['played'] == 0) {
      DeleteGame($match['infos']['id']);
    }
  }
}

header("Location: ../index.php");
exit();
