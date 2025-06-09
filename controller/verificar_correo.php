<?php
include("../database/database.php");

$datos = json_decode(file_get_contents("php://input"), true);

if (!$datos || !isset($datos['correo'])) {
    echo json_encode(["existe" => false]);
    exit;
}

$correo = mysqli_real_escape_string($conn, $datos['correo']);
$sql = "SELECT id FROM citas WHERE correo = '$correo' LIMIT 1";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo json_encode(["existe" => true]);
} else {
    echo json_encode(["existe" => false]);
}
?>
