<?php
include("../database/database.php");

// Verifica que la conexión esté definida correctamente
if (!isset($conn)) {
    die("Error: No se estableció la conexión a la base de datos.");
}

// Recibe los datos en formato JSON desde el frontend
$datos = json_decode(file_get_contents("php://input"), true);

// Verifica que se hayan recibido datos válidos
if (!$datos) {
    echo "Error: No se recibieron datos válidos";
    exit;
}

// Escapa los datos para evitar inyección SQL
$tipoServicio = mysqli_real_escape_string($conn, $datos['tipoServicio']);
$nombre = mysqli_real_escape_string($conn, $datos['nombre']);
$apellido = mysqli_real_escape_string($conn, $datos['apellido']);
$telefono = mysqli_real_escape_string($conn, $datos['telefono']);
$correo = mysqli_real_escape_string($conn, $datos['correo']);
$fecha = mysqli_real_escape_string($conn, $datos['fecha']);
$hora = mysqli_real_escape_string($conn, $datos['hora']);

// Consulta para insertar la cita en la base de datos
$sql = "INSERT INTO citas (tipo_corte, nombre_usuario, apellido_usuario, celular, correo, fecha, hora) 
        VALUES ('$tipoServicio', '$nombre', '$apellido', '$telefono', '$correo', '$fecha', '$hora')";

// Ejecuta la consulta y muestra el resultado
if (mysqli_query($conn, $sql)) {
    echo "Cita registrada";
} else {
    echo "Error al guardar la cita: " . mysqli_error($conn);
}
?>
