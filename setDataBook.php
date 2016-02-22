<?php
require_once "funcions.php";
$mysqli = conecta();

/*
 * GET ALL DATA FROM REQUEST {OP WAY}
 */
foreach ($_REQUEST as $key => $value) {
    ${$key} = !empty($_REQUEST[$key]) ? $value : "null";
    echo $key . " : " . ${$key} . "<br>";
}

$update = "UPDATE LLIBRES ";
$update .= "TITOL = ?, NUMEDICIO = ?, LLOCEDICIO = ?, ANYEDICIO = ?, ";
$update .= "DESCRIP_LLIB = ?, ISBN = ?, DEPLEGAL = ?, SIGNTOP = ?, ";
$update .= "FK_COLLECCIO = ?, FK_DEPARTAMENT = ?, FK_IDEDIT = ?, ";
$update .= "FK_LLENGUA = ? ";
$update .= "WHERE ID_LLIB = ?";

//echo $update;

$stmt = $mysqli->prepare($update);
$stmt->bind_param("siissssssis", $Titol, $NumEdicio, $AnyEdicio, $Descripcio, $ISBN, $DepositLegal, $SigTop, $collecio, $Departament, $Editorial, $Llengua) or die($mysqli->error . __LINE__);
$stmt->execute();
