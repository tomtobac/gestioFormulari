<?php
require_once "funcions.php";
$mysqli = conecta();

/*
 * GET ALL DATA FROM REQUEST {OP WAY}
 */
foreach ($_REQUEST as $key => $value) {
    ${$key} = !empty($_REQUEST[$key]) ? $value : null;
    //echo $key . " : " . ${$key} . "<br>";
}

if (isset($NOM_AUT) && isset($DNAIX_AUT)) {

	//Cercam el valor més alt de ID_AUT i l'assignam a una varriable que emplearem més endevant.
    $insert = "SET @MAX_ID_AUT = (SELECT MAX(ID_AUT) FROM AUTORS) +1";
    $stmt   = $mysqli->prepare($insert);
	  $stmt->execute();

	//Afegim l'autor nou, i empleam la variable d'abans comentada. @MAX_ID_AUT
    $insert = "INSERT INTO AUTORS VALUES (@MAX_ID_AUT, ?, ?, NULL, NULL)";
    $stmt   = $mysqli->prepare($insert);
    $stmt->bind_param("ss", $NOM_AUT, $DNAIX_AUT) or die($mysqli->error . __LINE__);
    if ($stmt->execute()) {
        $result = "<span class ='glyphicon glyphicon-ok' aria-hidden ='true'></span> <strong>Afegit correctament!</strong> l'autor: " . $NOM_AUT . " a la base de dades!";
    } else {
        $result = $stmt->error;
    }

    echo $result;
}
