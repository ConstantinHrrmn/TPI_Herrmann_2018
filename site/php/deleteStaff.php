<?php
include "functions.inc.php";

// Vérifie si l'id est indiqué dans l'url
if (!isset($_GET['id'])) {
  // On redirige vers la page Admin staff si l'id n'est pas indiqué dans l'url
  header("Location: ../adminStaff.php");
  exit;
}
else{
  // On vérifie si l'utilisateur est connecté et qu'il s'agit bien d'un administrateur
  if (isset($_SESSION['user']) || $_SESSION['user']['idRole'] == "1") {
  // On récupère l'id de L'url
  $id = $_GET['id'];

  // On supprime le membre du staff
  // Supprime également le lien entre une équipe et lui
  DeleteStaff($id);

  }
  // Redirection sur la page Admin Staff
  header("Location: ../adminStaff.php");
  exit;
}
