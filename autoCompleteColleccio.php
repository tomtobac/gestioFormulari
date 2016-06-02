<?php
require_once "funcions.php";
$c      = conecta();
$t      = $_GET["term"];
$cadena = "select colleccio as value from COLLECCIONS where colleccio like '%$t%' order by colleccio";
$q      = $c->query($cadena);
$taula  = array();
while($row = $q -> fetch_assoc()){
	//$value = htmlentities($row);
	//echo $row["colleccio"];
    $taula[] = $row;
}
header('Content-type: application/json');
echo json_encode($taula);
?>
