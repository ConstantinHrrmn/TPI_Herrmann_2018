<?php
// Récupère tous les terrains
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
