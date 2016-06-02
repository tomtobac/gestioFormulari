<?php
require_once "funcions.php";

$ID_LLIB = $_REQUEST['ID_LLIB'];
$mysqli  = conecta();


// ==========================================================================//
//                                                           LLIBRE          //
// ==========================================================================//
$sql = "SELECT ID_LLIB, TITOL, NUMEDICIO, ANYEDICIO, LLOCEDICIO, DESCRIP_LLIB, ISBN, DEPLEGAL, SIGNTOP, DATBAIXA_LLIB, MOTIUBAIXA, FK_COLLECCIO, FK_DEPARTAMENT, FK_IDEDIT, FK_LLENGUA, IMG_LLIB LLIBRES FROM LLIBRES WHERE ID_LLIB = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $ID_LLIB) or die($mysqli->error . __LINE__);
$stmt->execute();
$stmt->bind_result($ID_LLIB, $TITOL, $NUMEDICIO, $ANYEDICIO, $LLOCEDICIO, $DESCRIP_LLIB, $ISBN, $DEPLEGAL, $SIGNTOP, $DATBAIXA_LLIB, $MOTIUBAIXA, $FK_COLLECCIO, $FK_DEPARTAMENT, $FK_IDEDIT, $FK_LLENGUA, $IMG_LLIB);

$arrayTemporal = array();

while ($stmt->fetch()) {

    $arrayTemporal[] = array(
     "ID_LLIB"        => $ID_LLIB,
     "TITOL"          => htmlentities($TITOL),
     "NUMEDICIO"      => $NUMEDICIO,
     "LLOCEDICIO"     => htmlentities($LLOCEDICIO),
     "ANYEDICIO"      => $ANYEDICIO,
     "DESCRIP_LLIB"   => htmlentities($DESCRIP_LLIB),
     "ISBN"           => $ISBN,
     "DEPLEGAL"       => $DEPLEGAL,
     "SIGNTOP"        => $SIGNTOP,
     "DATBAIXA_LLIB"  => $DATBAIXA_LLIB,
     "MOTIUBAIXA"     => $MOTIUBAIXA,
     "FK_COLLECCIO"   => $FK_COLLECCIO,
     "FK_DEPARTAMENT" => $FK_DEPARTAMENT,
     "FK_IDEDIT"      => $FK_IDEDIT,
     "FK_LLENGUA"     => htmlentities($FK_LLENGUA),
     "IMG_LLIB"       => $IMG_LLIB
     );

}

$LLIBRE = array('LLIBRE' => $arrayTemporal);


// ==========================================================================//
//                                                           AUTORS          //
// ==========================================================================//
$sql = "SELECT ID_AUT, NOM_AUT, DNAIX_AUT, FK_NACIONALITAT, IMG_AUT FROM AUTORS JOIN LLI_AUT ON ID_AUT = FK_IDAUT WHERE FK_IDLLIB = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $ID_LLIB) or die($mysqli->error . __LINE__);
$stmt->execute();
$stmt->bind_result($ID_AUT, $NOM_AUT, $DNAIX_AUT, $FK_NACIONALITAT, $IMG_AUT);

$arrayTemporal = array();

while ($stmt->fetch()) {
    $arrayTemporal[] = array(
        "ID_AUT"          => $ID_AUT,
        "NOM_AUT"         => $NOM_AUT,
        "DNAIX_AUT"       => $DNAIX_AUT,
        "FK_NACIONALITAT" => $FK_NACIONALITAT,
        "IMG_AUT"         => $IMG_AUT
        );
}

$AUTORS = array('AUTORS' => $arrayTemporal);


// ==========================================================================//
//                                                        EXEMPLARS          //
// ==========================================================================//
$sql = "SELECT FK_IDLLIB, NUM_EXM, NREG, FK_UBICEXM, DATALTA_EXM, ORIGEN_EXM FROM EXEMPLARS WHERE FK_IDLLIB = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $ID_LLIB) or die($mysqli->error . __LINE__);
$stmt->execute();
$stmt->bind_result($FK_IDLLIB, $NUM_EXM, $NREG, $FK_UBICEXM, $DATALTA_EXM, $ORIGEN_EXM);

$arrayTemporal = array();

while ($stmt->fetch()) {
    $arrayTemporal[] = array(
        "FK_IDLLIB"   => $FK_IDLLIB,
        "NUM_EXM"     => $NUM_EXM,
        "NREG"        => $NREG,
        "FK_UBICEXM"  => $FK_UBICEXM,
        "DATALTA_EXM" => $DATALTA_EXM,
        "ORIGEN_EXM"  => $ORIGEN_EXM
        );
}

$EXEMPLARS = array('EXEMPLARS' => $arrayTemporal);

// ==========================================================================//
//                                                      COLLECCIONS          //
// ==========================================================================//

$sql = "SELECT COLLECCIO FROM COLLECCIONS ORDER BY COLLECCIO";

$stmt = $mysqli->prepare($sql);
$stmt->execute();
$stmt->bind_result($COLLECCIO);

$arrayTemporal = array();

while ($stmt->fetch()) {
    $COL_ESCAPE      = ereg_replace("\"","'",$COLLECCIO);
    $arrayTemporal[] = array(
        "COLLECCIO" => $COL_ESCAPE
        );
}

$COLLECCIONS = array('COLLECCIONS' => $arrayTemporal);


// ==========================================================================//
//                                                      DEPARTAMENTS         //
// ==========================================================================//
$sql = "SELECT DEPARTAMENT FROM DEPARTAMENTS ORDER BY DEPARTAMENT";

$stmt = $mysqli->prepare($sql);
$stmt->execute();
$stmt->bind_result($DEPARTAMENT);

$arrayTemporal = array();

while ($stmt->fetch()) {
    $arrayTemporal[] = array(
        "DEPARTAMENT" => $DEPARTAMENT
        );
}

$DEPARTAMENTS = array('DEPARTAMENTS' => $arrayTemporal);


// ==========================================================================//
//                                                           EDITORS         //
// ==========================================================================//
$sql = "SELECT ID_EDIT, NOM_EDIT FROM EDITORS ORDER BY ID_EDIT";

$stmt = $mysqli->prepare($sql);
$stmt->execute();
$stmt->bind_result($ID_EDIT, $NOM_EDIT);

$arrayTemporal = array();

while ($stmt->fetch()) {

    $COL_ESCAPE = ereg_replace("\"","",$NOM_EDIT);

    $arrayTemporal[] = array(
        "ID_EDIT"  => $ID_EDIT,
        "NOM_EDIT" => $COL_ESCAPE
        );
}

$EDITORS = array('EDITORS' => $arrayTemporal);


// ==========================================================================//
//                                                           LLENGUES        //
// ==========================================================================//
$sql = "SELECT LLENGUA FROM LLENGUES ORDER BY LLENGUA";

$stmt = $mysqli->prepare($sql);
$stmt->execute();
$stmt->bind_result($LLENGUA);

$arrayTemporal = array();

while ($stmt->fetch()) {

    $arrayTemporal[] = array(
        "LLENGUA" => $LLENGUA
        );
}

$LLENGUES = array('LLENGUES' => $arrayTemporal);


// ==========================================================================//
//                                                           NOUSAUTORS      //
// ==========================================================================//
$sql = "SELECT ID_AUT, NOM_AUT, DNAIX_AUT, FK_NACIONALITAT FROM AUTORS ORDER BY NOM_AUT ASC";

$stmt = $mysqli->prepare($sql);
$stmt->execute();
$stmt->bind_result($ID_AUT, $NOM_AUT, $DNAIX_AUT, $FK_NACIONALITAT);

$arrayTemporal = array();

while ($stmt->fetch()) {

    $arrayTemporal[] = array(
        "ID_AUT"          => $ID_AUT,
        "NOM_AUT"         => $NOM_AUT,
        "DNAIX_AUT"       => $DNAIX_AUT,
        "FK_NACIONALITAT" => $FK_NACIONALITAT
        );
}

$NOUSAUTORS = array('NOUSAUTORS' => $arrayTemporal);

$result = array_merge($LLIBRE, $AUTORS, $EXEMPLARS, $COLLECCIONS, $DEPARTAMENTS, $EDITORS, $LLENGUES, $NOUSAUTORS);
echo json_encode($result);

$stmt->close();
$mysqli->close();
