<?php
function conecta(){
//conectarse a la base de datos
$mysqli = new mysqli("localhost", "root", "password", "biblioteca");
	if (mysqli_connect_errno()) {
		printf("Error: %s\n", mysqli_connect_error()); exit();
	}
$mysqli->set_charset("utf8");
return $mysqli;
}

function consulta($connexio, $sql){
	return $connexio->query($sql);
}
?>
