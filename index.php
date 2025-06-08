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
                            <div class="campo">
                                <label>Tipo de Servicio:</label>
                                <input type="text" id="tipoServicio" >
                            </div>
                            <div class="botones">
                                <button type="button" onclick="mostrarPaso(1)">Volver</button>
                                <button class="blue" type="submit">Agendar cita</button>
                            </div>
                        </form>
                    </div>
                </section>
                <!-- Modal de Confirmación -->
                <div id="modalConfirmacion" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.6); z-index:9999; justify-content:center; align-items:center;">
                    <div style="background:white; padding:20px; border-radius:10px; text-align:center;">
                        <h3>¿Estás seguro de agendar esta cita?</h3>
                        <button id="confirmarEnvio" style="margin-right:10px;">Sí, confirmar</button>
                        <button id="cancelarEnvio">Cancelar</button>
                    </div>
                </div>

               
            </div>
        </div>
    </div>

    <script src="script/script.js"></script>
    <script>                   
        document.addEventListener('DOMContentLoaded', function () {
            
            const botones = document.querySelectorAll('.seleccionar-servicio');

            botones.forEach(boton => {
                boton.addEventListener('click', function () {
                const servicio = this.getAttribute('data-servicio');
                document.getElementById('tipoServicio').value = servicio;
                mostrarPaso(2);
                });
            });
        });
    </script>
    <script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('form-datos');
    const modal = document.getElementById('modalConfirmacion');
    const confirmarBtn = document.getElementById('confirmarEnvio');
    const cancelarBtn = document.getElementById('cancelarEnvio');

    let datosTemporales = null; // Para guardar los datos hasta confirmar

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        datosTemporales = {
            tipoServicio: document.getElementById('tipoServicio').value,
            nombre: document.getElementById('nombre').value,
            apellido: document.getElementById('apellido').value,
            telefono: document.getElementById('telefono').value,
            correo: document.getElementById('correo').value,
            fecha: document.getElementById('fecha').value,
            hora: document.getElementById('hora').value
        };

        // Mostrar modal
        modal.style.display = 'flex';
    });

    confirmarBtn.addEventListener('click', function () {
        // Enviar la cita solo si confirma
        fetch('./controller/guardar_cita.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(datosTemporales)
        })
        .then(res => res.text())
        .then(respuesta => {
            alert('✅ Tu cita ha sido registrada exitosamente.\n\nRespuesta del servidor:\n' + respuesta);
            form.reset();
            document.getElementById('tipoServicio').value = '';
            modal.style.display = 'none';
            mostrarPaso(1);
        })
        .catch(error => {
            console.error('Error al guardar la cita:', error);
            alert('❌ Ocurrió un error al guardar la cita. Intenta de nuevo.');
            modal.style.display = 'none';
        });
    });

    cancelarBtn.addEventListener('click', function () {
        modal.style.display = 'none'; // Ocultar modal si cancela
    });
});
</script>




    
</body>
</html>
