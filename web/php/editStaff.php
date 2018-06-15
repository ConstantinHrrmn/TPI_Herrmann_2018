<?php
/*******************************************************************************
AUTEUR      : Constantin Herrmann
LIEU        : CFPT Informatique Genève
DATE        : 14.06.2018

TITRE PROJET: KidsGames Geneva Score

TITRE PAGE  : editStaff
DESCRIPTION : Ce script est appeler au moment de modifier un membre du staff
VERSION     : 1.0
*******************************************************************************/

include "functions.inc.php";

// Vérifie si l'id est indiqué dans l'url
if (!isset($_GET['id'])) {
  // On redirige vers la page Admin staff si l'id n'est pas indiqué dans l'url
  header("Location: ../adminStaff.php");
  exit;
}
else{
  // On récupère l'id de L'url
  $id = $_GET['id'];
  // On récupère le membre du staff qui possède l'id indiqué
  $staff = GetStaffById($id);
  // Ajoute le staff à modifier dans la session
  $_SESSION['staff_to_change'] = $staff;

  // On redirige vers la page Admin staff
  header("Location: ../adminStaff.php");
  exit;
}
