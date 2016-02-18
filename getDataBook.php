<?php
require_once "funcions.php";

$ID_LLIB = $_REQUEST['ID_LLIB'];
$mysqli  = conecta();

$sql = "SELECT ID_LLIB, TITOL, NUMEDICIO, ANYEDICIO, DESCRIP_LLIB, ISBN, DEPLEGAL, SIGNTOP, DATBAIXA_LLIB, MOTIUBAIXA, FK_COLLECCIO, FK_DEPARTAMENT, FK_IDEDIT, FK_LLENGUA, IMG_LLIB LLIBRES FROM LLIBRES WHERE ID_LLIB = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $ID_LLIB) or die($mysqli->error . __LINE__);
$stmt->execute();
$stmt->bind_result($ID_LLIB, $TITOL, $NUMEDICIO, $ANYEDICIO, $DESCRIP_LLIB, $ISBN, $DEPLEGAL, $SIGNTOP, $DATBAIXA_LLIB, $MOTIUBAIXA, $FK_COLLECCIO, $FK_DEPARTAMENT, $FK_IDEDIT, $FK_LLENGUA, $IMG_LLIB);

//echo json_encode($stmt->fetchAll());

$myArray = array();

while ($stmt->fetch()) {
    /*
    $ID_LLIB        = ($ID_LLIB != null) ? $ID_LLIB : "NULL";
    $TITOL          = ($TITOL != null) ? $TITOL : "NULL";
    $NUMEDICIO      = ($NUMEDICIO != null) ? $NUMEDICIO : "NULL";
    $ANYEDICIO      = ($ANYEDICIO != null) ? $ANYEDICIO : "NULL";
    $DESCRIP_LLIB   = ($DESCRIP_LLIB != null) ? $DESCRIP_LLIB : "NULL";
    $ISBN           = ($ISBN != null) ? $ISBN : "NULL";
    $DEPLEGAL       = ($DEPLEGAL != null) ? $DEPLEGAL : "NULL";
    $SIGNTOP        = ($SIGNTOP != null) ? $SIGNTOP : "NULL";
    $DATBAIXA_LLIB  = ($DATBAIXA_LLIB != null) ? $DATBAIXA_LLIB : "NULL";
    $MOTIUBAIXA     = ($MOTIUBAIXA != null) ? $MOTIUBAIXA : "NULL";
    $FK_COLLECCIO   = ($FK_COLLECCIO != null) ? $FK_COLLECCIO : "NULL";
    $FK_DEPARTAMENT = ($FK_DEPARTAMENT != null) ? $FK_DEPARTAMENT : "NULL"; // PETA X S'ACCENT
    $FK_IDEDIT      = ($FK_IDEDIT != null) ? $FK_IDEDIT : "NULL";
    $FK_LLENGUA     = ($FK_LLENGUA != null) ? $FK_LLENGUA : "NULL";
    $IMG_LLIB       = ($IMG_LLIB != null) ? $IMG_LLIB : "NULL";

     */

    $FK_DEPARTAMENT = "CATALA";
    //https://www.google.es/webhp?sourceid=chrome-instant&ion=1&espv=2&ie=UTF-8#safe=off&q=php+array+accent

    //echo $ID_LLIB . "<br>" . $TITOL . "<br>" . $NUMEDICIO . "<br>" . $ANYEDICIO . "<br>" . $DESCRIP_LLIB . "<br>" . $ISBN . "<br>" . $DEPLEGAL . "<br>" . $SIGNTOP . "<br>" . $DATBAIXA_LLIB . "<br>" . $MOTIUBAIXA . "<br>" . $FK_COLLECCIO . "<br>" . $FK_DEPARTAMENT . "<br>" . $FK_IDEDIT . "<br>" . $FK_LLENGUA . "<br>" . $IMG_LLIB;

    $myArray[] = array("ID_LLIB" => $ID_LLIB, "TITOL" => $TITOL, "NUMEDICIO" => $NUMEDICIO, "ANYEDICIO" => $ANYEDICIO, "DESCRIP_LLIB" => $DESCRIP_LLIB, "ISBN" => $ISBN, "DEPLEGAL" => $DEPLEGAL, "SIGNTOP" => $SIGNTOP, "DATBAIXA_LLIB" => $DATBAIXA_LLIB, "MOTIUBAIXA" => $MOTIUBAIXA, "FK_COLLECCIO" => $FK_COLLECCIO, "FK_DEPARTAMENT" => $FK_DEPARTAMENT, "FK_IDEDIT" => $FK_IDEDIT, "FK_LLENGUA" => $FK_LLENGUA, "IMG_LLIB" => $IMG_LLIB);

    //print_r($myArray);
}

echo json_encode($myArray);

$stmt->close();
$mysqli->close();
