<?php
include("./database/database.php");


$sql = "SELECT id, nombre, descripcion, precio FROM tipos_corte ORDER BY id ASC";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto - Barbería</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="principal">
        <div class="info">
            <div class="logo">
                <img src="img/logo.png" alt="Logo">
            </div>
            <div class="textos">
                <h1>AGENDA TU<br>CITA EN MINUTOS</h1>
                <p>Disfruta una experiencia rápida y sin complicaciones. Completa el formulario paso a paso
                    seleccionando el servicio, fecha y hora que más te convenga. ¡Estás a unos clics de tu próximo corte
                    perfecto!</p>
            </div>
        </div>

        <div class="cont-formulario">
            <div class="header">
                <a href="views/ver-citas.html">Ver citas Cliente</a>
                <a href="views/login.html">Ingresar</a>
            </div>
            <div class="formulario">

                <!-- Paso 1: Selección de servicio -->
                <section id="paso1" class="paso-formulario">
                    <h2>Selecciona un servicio</h2>
                    <div class="servicios">

                        <?php
                        while ($row = $resultado->fetch_assoc()) {
                            $nombre = htmlspecialchars($row["nombre"]);
                            $descripcion = htmlspecialchars($row["descripcion"]);
                            $precio = number_format($row["precio"], 0, ",", ".");
                            $imagen = "";

                           
                            switch ($row["id"]) {
                                case 1:
                                    $imagen = "img/corte.PNG";
                                    break;
                                case 2:
                                    $imagen = "img/afeitado.jpg";
                                    break;
                                case 3:
                                    $imagen = "img/barba.jpg";
                                    break;
                                default:
                                    $imagen = "img/default.jpg";
                                    break;
                            }

                            echo '
                            <div class="servicio">
                                <div class="foto">
                                    <img src="' . $imagen . '" alt="">
                                </div>
                                <div class="info-servicio">
                                    <h3>' . $nombre . '</h3>
                                    <p>' . $descripcion . '</p>
                                    <h4>$' . $precio . '</h4>
                                </div>
                                <div class="icono">
                                    <button class="seleccionar-servicio" data-servicio="' . $nombre . '">
                                        <img src="img/icono-plus.png" alt="">
                                    </button>
                                </div>
                            </div>';
                        }
                        ?>


                    </div>
                </section>

                <!-- Paso 2 -->
                <section id="paso2" class="paso-formulario">
                    <h2>Detalles de tu cita</h2>
                    <div class="campos">
                        <form id="form-datos">
                            <input type="hidden" id="servicioSeleccionado">
                            <div class="grupo">
                                <div class="campo">
                                    <label>Fecha:</label>
                                    <input type="date" id="fecha" required>
                                </div>
                                <div class="campo">
                                    <label>Hora:</label>
                                    <input type="time" id="hora" required>
                                </div>
                            </div>
                            <div class="grupo">
                                <div class="campo">
                                    <label>Nombre:</label>
                                    <input type="text" id="nombre" required>
                                </div>
                                <div class="campo">
                                    <label>Apellido:</label>
                                    <input type="text" id="apellido" required>
                                </div>
                            </div>
                            <div class="campo">
                                <label>Celulares:</label>
                                <input type="tel" id="telefono" required>
                            </div>
                            <div class="campo">
                                <label>Correo:</label>
                                <input type="email" id="correo" required>
                            </div>
                            <div class="botones">
                                <button type="button" onclick="mostrarPaso(1)">Volver</button>
                                <button class="blue" type="submit">Agendar cita</button>
                            </div>
                        </form>
                    </div>
                </section>

                <!-- Paso 3 -->
                <section id="paso3" class="paso-formulario">
                    <h2>Confirma tu cita</h2>
                    <div class="resumen-cita">
                        <div class="textos">
                            <p><strong>Servicio:</strong> <span id="resumen-servicio"></span></p>
                            <p><strong>Nombre:</strong> <span id="resumen-nombre"></span></p>
                            <p><strong>Teléfono:</strong> <span id="resumen-telefono"></span></p>
                            <p><strong>Correo:</strong> <span id="resumen-correo"></span></p>
                            <p><strong>Fecha:</strong> <span id="resumen-fecha"></span></p>
                            <p><strong>Hora:</strong> <span id="resumen-hora"></span></p>
                        </div>
                        <div class="botones">
                            <button onclick="mostrarPaso(2)">Volver</button>
                            <button class="blue" onclick="enviarFormulario()">Confirmar y Enviar</button>
                        </div>
                    </div>
                </section>

                <!-- Paso 4 -->
                <section id="paso4" class="paso-formulario">
                    <h2>¡Cita agendada con éxito!</h2>
                    <div class="gracias">
                        <p><span id="gracias-nombre"></span>, tu cita ha sido registrada correctamente. Hemos enviado una confirmación a tu número de WhatsApp. Si deseas revisar o gestionar tu cita, haz clic en el botón de abajo para continuar.</p>
                        <a href="index.html" class="btn">Volver al inicio</a>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <script src="script/script.js"></script>
</body>
</html>
