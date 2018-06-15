<?php
/*******************************************************************************
AUTEUR      : Constantin Herrmann
LIEU        : CFPT Informatique Genève
DATE        : 14.06.2018

TITRE PROJET: KidsGames Geneva Score

TITRE PAGE  : logout
DESCRIPTION : Ce script détruit la session en cours pour ce déconnecter
VERSION     : 1.0
*******************************************************************************/

session_start();
session_destroy();
header("Location: ../index.php");
exit();
