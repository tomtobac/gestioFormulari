<?php
require_once "funcions.php";
$mysqli = conecta();

//GET ALL DATA FROM REQUEST {OP WAY}
foreach ($_REQUEST as $key => $value) {
    ${$key} = !empty($_REQUEST[$key]) ? $value : NULL;
    //echo $key . " : " . ${$key} . "<br>";
}

$update  = "UPDATE LLIBRES SET ";
$update .= "TITOL = ?, NUMEDICIO = ?, ANYEDICIO = ?, ";
$update .= "DESCRIP_LLIB = ?, ISBN = ?, DEPLEGAL = ?, SIGNTOP = ?, ";
$update .= "FK_COLLECCIO = ?, FK_DEPARTAMENT = ?, FK_IDEDIT = ?, ";
$update .= "FK_LLENGUA = ? ";
$update .= "WHERE ID_LLIB = ?";

$stmt = $mysqli->prepare($update);
$stmt->bind_param("siissssssisi", $Titol, $NumEdicio, $AnyEdicio, $Descripcio, $ISBN, $DepositLegal, $SigTop, $collecio, $Departament, $Editorial, $Llengua, $CodiLlibre) or die($mysqli->error . __LINE__);

if ($stmt->execute()) {
   // it worked
	$result = "<span class='glyphicon glyphicon-ok' aria-hidden='true'></span> <strong>Enhorabona!</strong> El llibre <strong>" . $Titol . "</strong> ha estat editat correctament.";
} else {
   // it didn't
	$result = $stmt->error;
}

//UPDATE LLIBRES TITOL = "LLIBRE D'AMIC E AMAT", NUMEDICIO = 2, ANYEDICIO = 1991, DESCRIP_LLIB = "107 P. 20 CM", ISBN = "84-273-051", DEPLEGAL = "B.28.461", SIGNTOP = "CAT-LLU", FK_COLLECCIO = NULL, FK_DEPARTAMENT = "Català", FK_IDEDIT = 391, FK_LLENGUA = "Castellana" WHERE ID_LLIB = 1
?>
