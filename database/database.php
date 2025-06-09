<?php
$host = "localhost";         
$usuario = "root";           
$contrasena = "";            
$basedatos = "barberia";    

$conn = new mysqli($host, $usuario, $contrasena, $basedatos);


if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


?>




