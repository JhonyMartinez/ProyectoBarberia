<?php
// dashboard_cliente.php

include("../../database/database.php");

if (!isset($conn)) {
    die("Error: No se estableció la conexión a la base de datos.");
}

// Obtener correo desde GET
if (!isset($_GET['correo']) || empty($_GET['correo'])) {
    die("Correo no proporcionado.");
}

$correo = $_GET['correo'];

// Validar formato de correo
$correo = filter_var($correo, FILTER_VALIDATE_EMAIL);
if (!$correo) {
    die("Correo inválido.");
}

// Consulta para obtener citas del cliente
$sql = "SELECT id, fecha, hora, nombre_usuario, apellido_usuario, correo, celular, tipo_corte FROM citas WHERE correo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Dashboard Cliente - Barbería</title>
    <link rel="stylesheet" href="../../css/style-dashboard.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <style>
        main {
            padding: 20px;
        }
        h1 {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #aaa;
        }
        th, td {
            padding: 8px 12px;
            text-align: left;
        }
        .acciones a {
            margin-right: 10px;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 4px;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
        }
        .editar {
            background-color: #007bff;
        }
        .eliminar {
            background-color: #dc3545;
        }
    </style>
</head>
<body>
    <!-- Barra de Navegación Lateral -->
    <nav class="nav_lateral">
        <div class="parte1">
            <div class="logo">
                <img src="../../img/logo.png" alt=""/>
            </div>
            <span id="menu" class="material-symbols-outlined">menu</span>
        </div>
        <div class="parte2">
            <ul class="lista">
                <li class="e-lista">
                    <a href="#" class="seccion seleccionado" target="_self">
                        <span class="material-symbols-outlined">summarize</span>
                        <h3>Citas agendadas</h3>
                    </a>
                </li>
            </ul>
        </div>
        <div class="parte3">
            <div class="boton">
                <a href="../../index.php">Salir</a>
            </div>
        </div>
    </nav>

    <main>
        <h1>Citas para: <?= htmlspecialchars($correo) ?></h1>

        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Correo</th>
                    <th>Celular</th>
                    <th>Tipo de corte</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows === 0): ?>
                    <tr>
                        <td colspan="8" style="text-align:center;">No hay citas para este correo.</td>
                    </tr>
                <?php else: ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['fecha']) ?></td>
                            <td><?= htmlspecialchars($row['hora']) ?></td>
                            <td><?= htmlspecialchars($row['nombre_usuario']) ?></td>
                            <td><?= htmlspecialchars($row['apellido_usuario']) ?></td>
                            <td><?= htmlspecialchars($row['correo']) ?></td>
                            <td><?= htmlspecialchars($row['celular']) ?></td>
                            <td><?= htmlspecialchars($row['tipo_corte']) ?></td>
                            <td class="acciones">
                                <a class="editar" href="../../controller/editar_cita.php?id=<?= $row['id'] ?>">Editar</a><br><br>
                                <a class="eliminar" href="../../controller/eliminar_cita.php?id=<?= $row['id'] ?>">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </main>

    <script src="../../script/script-dashboard.js"></script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
