<?php
require_once "funcions.php";
$mysqli = conecta();

$sql = "SELECT ID_LLIB, TITOL FROM LLIBRES ORDER BY ID_LLIB  LIMIT 0, 20";
$stmt = $mysqli->prepare($sql);

$stmt->execute() or die($mysqli->error . __LINE__);
$stmt->bind_result($ID_LLIB, $TITOL);

$myArray = array();

while ($stmt->fetch()) {
	//$TITOL = addslashes($TITOL);
    $myArray[] = array(
    	"ID_LLIB" => $ID_LLIB, 
    	"TITOL" => htmlentities($TITOL)
    	);
}
echo json_encode($myArray);

$stmt->close();
$mysqli->close();