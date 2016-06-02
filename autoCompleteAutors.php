<?php
require_once "funcions.php";
$conexio = conecta();
$terma   = $_GET["term"];
$cadena  = "select ID_AUT as id, NOM_AUT as value FROM AUTORS where NOM_AUT like '%$terma%' order by NOM_AUT";
$query   = $conexio->query($cadena);
$taula   = array();
while ($row = $query->fetch_assoc()) {
    $taula[] = $row;
}
header('Content-type: application/json');
echo json_encode($taula);
