<?php
$db_host = "localhost";
$db_user = "root";
$db_pass = "godevil90qwe";
$db_name = "biblioteca";
$mysqli  = new MySQLi($db_host, $db_user, $db_pass, $db_name);
$myQuery = "SELECT ID_LLIB, TITOL, NUMEDICIO, ANYEDICIO, DESCRIP_LLIB, ISBN, DEPLEGAL, SIGNTOP, DATBAIXA_LLIB, MOTIUBAIXA, FK_COLLECCIO, FK_DEPARTAMENT, FK_IDEDIT, FK_LLENGUA, IMG_LLIB LLIBRES FROM LLIBRES WHERE ID_LLIB = 1";
$result  = $mysqli->query($myQuery) or die($mysqli->error);
$data = array();
while ( $row = $result->fetch_assoc() ){
    $data[] = json_encode($row);
}
echo json_encode( $data );