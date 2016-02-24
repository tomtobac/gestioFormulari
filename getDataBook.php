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

$myArray = array();

while ($stmt->fetch()) {

    $myArray[] = array(
     "ID_LLIB" => $ID_LLIB,
     "TITOL" => htmlentities($TITOL), 
     "NUMEDICIO" => $NUMEDICIO,
     "LLOCEDICIO" => htmlentities($LLOCEDICIO), 
     "ANYEDICIO" => $ANYEDICIO, 
     "DESCRIP_LLIB" => htmlentities($DESCRIP_LLIB), 
     "ISBN" => $ISBN, 
     "DEPLEGAL" => $DEPLEGAL, 
     "SIGNTOP" => $SIGNTOP, 
     "DATBAIXA_LLIB" => $DATBAIXA_LLIB, 
     "MOTIUBAIXA" => $MOTIUBAIXA, 
     "FK_COLLECCIO" => $FK_COLLECCIO, 
     "FK_DEPARTAMENT" => $FK_DEPARTAMENT,
     "FK_IDEDIT" => $FK_IDEDIT, 
     "FK_LLENGUA" => htmlentities($FK_LLENGUA), 
     "IMG_LLIB" => $IMG_LLIB
     );

}

$LLIBRE = array('LLIBRE' => $myArray);


// ==========================================================================// 
//                                                           AUTORS          //        
// ==========================================================================//  
$sql = "SELECT ID_AUT, NOM_AUT, DNAIX_AUT, FK_NACIONALITAT, IMG_AUT FROM AUTORS JOIN LLI_AUT ON ID_AUT = FK_IDAUT WHERE FK_IDLLIB = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $ID_LLIB) or die($mysqli->error . __LINE__);
$stmt->execute();
$stmt->bind_result($ID_AUT, $NOM_AUT, $DNAIX_AUT, $FK_NACIONALITAT, $IMG_AUT);

$mySecondArray = array();

while ($stmt->fetch()) {
    $mySecondArray[] = array(
        "ID_AUT" => $ID_AUT,
        "NOM_AUT" => $NOM_AUT,
        "DNAIX_AUT" => $DNAIX_AUT,
        "FK_NACIONALITAT" => $FK_NACIONALITAT,
        "IMG_AUT" => $IMG_AUT
        );
}

$AUTORS = array('AUTORS' => $mySecondArray);


// ==========================================================================// 
//                                                        EXEMPLARS          //        
// ==========================================================================//  
$sql = "SELECT FK_IDLLIB, NUM_EXM, NREG, FK_UBICEXM, DATALTA_EXM, ORIGEN_EXM FROM EXEMPLARS WHERE FK_IDLLIB = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $ID_LLIB) or die($mysqli->error . __LINE__);
$stmt->execute();
$stmt->bind_result($FK_IDLLIB, $NUM_EXM, $NREG, $FK_UBICEXM, $DATALTA_EXM, $ORIGEN_EXM);

$myThirdArray = array();

while ($stmt->fetch()) {
    $myThirdArray[] = array(
        "FK_IDLLIB" => $FK_IDLLIB,
        "NUM_EXM" => $NUM_EXM,
        "NREG" => $NREG,
        "FK_UBICEXM" => $FK_UBICEXM,
        "DATALTA_EXM" => $DATALTA_EXM,
        "ORIGEN_EXM" => $ORIGEN_EXM
        );
}

$EXEMPLARS = array('EXEMPLARS' => $myThirdArray);

// ==========================================================================// 
//                                                      COLLECCIONS          //        
// ==========================================================================//  

$sql = "SELECT COLLECCIO FROM COLLECCIONS ORDER BY COLLECCIO";

$stmt = $mysqli->prepare($sql);
$stmt->execute();
$stmt->bind_result($COLLECCIO);

$myFourthArray = array();

while ($stmt->fetch()) {
    $COL_ESCAPE = ereg_replace("\"","'",$COLLECCIO);
    $myFourthArray[] = array(
        "COLLECCIO" => $COL_ESCAPE
        );
}

$COLLECCIONS = array('COLLECCIONS' => $myFourthArray);


// ==========================================================================// 
//                                                      DEPARTAMENTS         //        
// ==========================================================================//  
$sql = "SELECT DEPARTAMENT FROM DEPARTAMENTS ORDER BY DEPARTAMENT";

$stmt = $mysqli->prepare($sql);
$stmt->execute();
$stmt->bind_result($DEPARTAMENT);

$myFifthArray = array();

while ($stmt->fetch()) {
    $myFifthArray[] = array(
        "DEPARTAMENT" => $DEPARTAMENT
        );
}

$DEPARTAMENTS = array('DEPARTAMENTS' => $myFifthArray);


// ==========================================================================// 
//                                                           EDITORS         //        
// ==========================================================================//  
$sql = "SELECT ID_EDIT, NOM_EDIT FROM EDITORS ORDER BY ID_EDIT";

$stmt = $mysqli->prepare($sql);
$stmt->execute();
$stmt->bind_result($ID_EDIT, $NOM_EDIT);

$mySixthArray = array();

while ($stmt->fetch()) {

    $COL_ESCAPE = ereg_replace("\"","",$NOM_EDIT);

    $mySixthArray[] = array(
        "ID_EDIT" => $ID_EDIT,
        "NOM_EDIT" => $COL_ESCAPE
        );
}

$EDITORS = array('EDITORS' => $mySixthArray);


// ==========================================================================// 
//                                                           LLENGUES        //        
// ==========================================================================//  
$sql = "SELECT LLENGUA FROM LLENGUES ORDER BY LLENGUA";

$stmt = $mysqli->prepare($sql);
$stmt->execute();
$stmt->bind_result($LLENGUA);

$mySeventhArray = array();

while ($stmt->fetch()) {

    $mySeventhArray[] = array(
        "LLENGUA" => $LLENGUA
        );
}

$LLENGUES = array('LLENGUES' => $mySeventhArray);


// ==========================================================================// 
//                                                           NOUSAUTORS      //        
// ==========================================================================//  
$sql = "SELECT ID_AUT, NOM_AUT, DNAIX_AUT, FK_NACIONALITAT FROM AUTORS ORDER BY NOM_AUT ASC";

$stmt = $mysqli->prepare($sql);
$stmt->execute();
$stmt->bind_result($ID_AUT, $NOM_AUT, $DNAIX_AUT, $FK_NACIONALITAT);

$myEighthArray = array();

while ($stmt->fetch()) {

    $myEighthArray[] = array(
        "ID_AUT" => $ID_AUT,
        "NOM_AUT" => $NOM_AUT,
        "DNAIX_AUT" => $DNAIX_AUT,
        "FK_NACIONALITAT" => $FK_NACIONALITAT
        );
}

$NOUSAUTORS = array('NOUSAUTORS' => $myEighthArray);

$result = array_merge($LLIBRE, $AUTORS, $EXEMPLARS, $COLLECCIONS, $DEPARTAMENTS, $EDITORS, $LLENGUES, $NOUSAUTORS);
echo json_encode($result);

$stmt->close();
$mysqli->close();
