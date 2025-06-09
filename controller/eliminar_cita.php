<?php
// controller/eliminar_cita.php
include("../database/database.php");

if (!isset($conn)) {
    die("Error en la conexión.");
}

if (!isset($_GET['id'])) {
    die("ID no proporcionada.");
}

$id = intval($_GET['id']);

// Obtener correo para redirigir luego
$sql = "SELECT correo FROM citas WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Cita no encontrada.");
}

$cita = $result->fetch_assoc();
$correo = $cita['correo'];
$stmt->close();

// Eliminar cita
$sql = "DELETE FROM citas WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $stmt->close();
    $conn->close();
    header("Location: ../view/dashboard_cliente.php?correo=" . urlencode($correo));
    exit;
} else {
    $error = "Error al eliminar: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Error al eliminar</title>
</head>
<body>
    <h2>Error al eliminar la cita</h2>
    <p><?= htmlspecialchars($error) ?></p>
    <p><a href="../views/cliente/dashboard_cliente.php?correo=<?= urlencode($correo) ?>">Volver al Dashboard</a></p>
</body>
</html>
