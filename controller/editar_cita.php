<?php
// controller/editar_cita.php
include("../database/database.php");

if (!isset($conn)) {
    die("Error en la conexión.");
}

if (!isset($_GET['id'])) {
    die("ID no proporcionada.");
}

$id = intval($_GET['id']);
$error = "";
$exito = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recibir datos del formulario
    $fecha = $_POST['fecha'] ?? '';
    $hora = $_POST['hora'] ?? '';
    $nombre = $_POST['nombre_usuario'] ?? '';
    $apellido = $_POST['apellido_usuario'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $celular = $_POST['celular'] ?? '';
    $tipo_corte = $_POST['tipo_corte'] ?? '';

    // Validar datos
    if (!$fecha || !$hora || !$nombre || !$apellido || !filter_var($correo, FILTER_VALIDATE_EMAIL) || !$celular || !$tipo_corte) {
        $error = "Todos los campos son obligatorios y el correo debe ser válido.";
    } else {
        $sql = "UPDATE citas SET fecha=?, hora=?, nombre_usuario=?, apellido_usuario=?, correo=?, celular=?, tipo_corte=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssi", $fecha, $hora, $nombre, $apellido, $correo, $celular, $tipo_corte, $id);
        if ($stmt->execute()) {
            $exito = "Cita actualizada correctamente.";
        } else {
            $error = "Error al actualizar: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Obtener los datos actuales para mostrar en el formulario
$sql = "SELECT * FROM citas WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Cita no encontrada.");
}

$cita = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Editar Cita</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        form { max-width: 500px; }
        input, select { width: 100%; margin: 8px 0; padding: 8px; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <h2>Editar Cita</h2>

    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <?php if ($exito): ?>
        <p class="success"><?= htmlspecialchars($exito) ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label>Fecha:</label>
        <input type="date" name="fecha" value="<?= htmlspecialchars($cita['fecha']) ?>" required />

        <label>Hora:</label>
        <input type="time" name="hora" value="<?= htmlspecialchars($cita['hora']) ?>" required />

        <label>Nombre:</label>
        <input type="text" name="nombre_usuario" value="<?= htmlspecialchars($cita['nombre_usuario']) ?>" required />

        <label>Apellido:</label>
        <input type="text" name="apellido_usuario" value="<?= htmlspecialchars($cita['apellido_usuario']) ?>" required />

        <label>Correo:</label>
        <input type="email" name="correo" value="<?= htmlspecialchars($cita['correo']) ?>" required />

        <label>Celular:</label>
        <input type="text" name="celular" value="<?= htmlspecialchars($cita['celular']) ?>" required />

        <label>Tipo de corte:</label>
        <input type="text" name="tipo_corte" value="<?= htmlspecialchars($cita['tipo_corte']) ?>" required />

        <button type="submit">Actualizar cita</button>
    </form>

    <p><a href="../views/cliente/dashboard_cliente.php?correo=<?= urlencode($cita['correo']) ?>">Volver al Dashboard</a></p>
</body>
</html>
