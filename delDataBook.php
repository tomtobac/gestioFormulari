<?php
require_once "funcions.php";
$mysqli = conecta();

//GET ALL DATA FROM REQUEST {OP WAY}
foreach ($_REQUEST as $key => $value) {
    ${$key} = !empty($_REQUEST[$key]) ? $value : NULL;
    //echo $key . " : " . ${$key} . "<br>";
}

if (isset($id_llib) && isset($id_autor)){

	$delete = "DELETE FROM LLI_AUT WHERE FK_IDLLIB = ? AND FK_IDAUT = ?";
	$stmt   = $mysqli->prepare($delete);
	$stmt->bind_param("ii", $id_llib, $id_autor) or die($mysqli->error . __LINE__);
	$prompt = " relació entre l'autor i el llibre!";

}else if(isset($id_llib) && isset($num_exm)){

	$delete = "DELETE FROM EXEMPLARS WHERE FK_IDLLIB = ? AND NUM_EXM = ?";
	$stmt   = $mysqli->prepare($delete);
	$stmt->bind_param("ii", $id_llib, $num_exm) or die($mysqli->error . __LINE__);
	$prompt = " l'exemplar d'aquest llibre!";
}


if ($stmt->execute()) {
   // it worked
	$result = "<span class='glyphicon glyphicon-ok' aria-hidden='true'></span> <strong>Esborrat</strong>" . $prompt;
} else {
   // it didn't
	$result = $stmt->error;
}

echo $result;

?>
