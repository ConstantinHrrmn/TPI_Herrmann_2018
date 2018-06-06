<?php
session_start();

//Constantes
define("DB_HOST", "localhost");
define("DB_NAME", "TPI_kggs");
define("DB_USER", "TPI_dba");
define("DB_PASSWORD", "Tpi2018");

function connecteur(){
    static $dbc = null;

    if ($dbc == null) {
        try{
            $dbc = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD,
                    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::ATTR_PERSISTENT => TRUE));
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage() . '<br/>';
            echo 'N° : ' . $e->getCode();
            echo "<script>console.log( 'Debug Objects: " . $e->getMessage() . "' );</script>";
            die('Could not connect to MySQL');
        }
    }
    return $dbc;
}
