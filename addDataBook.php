<?php
require_once "funcions.php";
$mysqli = conecta();

//GET ALL DATA FROM REQUEST {OP WAY}
foreach ($_REQUEST as $key => $value) {
    ${$key} = !empty($_REQUEST[$key]) ? $value : null;
    //echo $key . " : " . ${$key} . "<br>";
}

if (isset($id_llib) && isset($id_autor)) {

    $insert = "INSERT INTO LLI_AUT VALUES ( ?, ?, NULL)";
    $stmt   = $mysqli->prepare($insert);
    $stmt->bind_param("ii", $id_llib, $id_autor) or die($mysqli->error . __LINE__);
    $prompt = " l'autor a n'aquest llibre!";

} else if (isset($id_llib) && isset($num_exm) && isset($nreg) && isset($data)) {
    $insert = "INSERT INTO EXEMPLARS VALUES (?, ?, ?, NULL, ?, NULL)";
    $stmt   = $mysqli->prepare($insert);
    $stmt->bind_param("iiss", $id_llib, $num_exm, $nreg, $data) or die($mysqli->error . __LINE__);
    $prompt = " l'exemplar a n'aquest llibre!";

} else if (isset($nova_colleccio)) {
    $insert = "INSERT INTO COLLECCIONS VALUES (?)";
    $stmt   = $mysqli->prepare($insert);
    $stmt->bind_param("s", $nova_colleccio) or die($mysqli->error . __LINE__);
    $prompt = " La nova col·lecció, <strong>" . $nova_colleccio . "</strong>!";
}

if ($stmt->execute()) {
    // it worked
    $result = "<span class='glyphicon glyphicon-ok' aria-hidden='true'></span> <strong>Afegit correctament!</strong>" . $prompt;
} else {
    // it didn't
    $result = $stmt->error;
}

echo $result;
