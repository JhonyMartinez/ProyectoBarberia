<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto - Barbería Login</title>
    <link rel="stylesheet" href="../css/style-login.css">
    <style>
        /* Estilo del modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 999;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.6);
        }
        .modal-content {
            background: white;
            margin: 20% auto;
            padding: 20px;
            width: 90%;
            max-width: 400px;
            border-radius: 10px;
            text-align: center;
        }
        .modal-content button {
            margin: 10px;
            padding: 10px 20px;
            border: none;
            color: white;
            border-radius: 5px;
        }
        .btn-confirmar { background-color: #28a745; }
        .btn-cancelar { background-color: #dc3545; }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="../img/logo.png" alt="Logo">
        </div>
        <div class="boton">
            <a href="../index.html">Agendar Citas</a>
            <a href="login.php">Ingresar</a>
        </div>
    </header>
    <main>
        <div class="principal">
            <img src="../img/Male User.png" alt="">
            <h1>Ver citas</h1>
            <form id="form-ver-citas">
                <div class="campo">
                    <label>Correo:</label>
                    <input type="email" id="correo" required>
                </div>
                <button class="blue" type="submit">Ver mis citas</button>
            </form>
            <p id="mensaje-error" style="color: red;"></p>
        </div>
    </main>

    <!-- Modal de confirmación -->
    <div class="modal" id="modal-confirmacion">
        <div class="modal-content">
            <p>¿Está seguro que ese es su correo?</p>
            <p id="correo-confirmar" style="font-weight: bold;"></p>
            <button class="btn-confirmar" onclick="confirmarCorreo()">Sí</button>
            <button class="btn-cancelar" onclick="cerrarModal()">Cancelar</button>
        </div>
    </div>

    <footer>
        <p>Proyecto Barbería - Copyright 2025</p>
    </footer>

    <script>
        let correoTemp = "";

        document.getElementById('form-ver-citas').addEventListener('submit', function (e) {
            e.preventDefault();
            correoTemp = document.getElementById('correo').value;
            document.getElementById('correo-confirmar').textContent = correoTemp;
            document.getElementById('modal-confirmacion').style.display = 'block';
        });

        function cerrarModal() {
            document.getElementById('modal-confirmacion').style.display = 'none';
            correoTemp = "";
        }

        function confirmarCorreo() {
            console.log("Enviando correo a verificar_correo.php:", correoTemp); // ✅
            fetch('../controller/verificar_correo.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ correo: correoTemp })
            })
            .then(res => res.json())
            .then(data => {
                if (data.existe) {
                    localStorage.setItem('correoCliente', correoTemp);
                    window.location.href = "./cliente/dashboard_cliente.php?correo=" + encodeURIComponent(correoTemp);
                } else {
                    alert("❌ No se encontró ninguna cita con ese correo.");
                }
                cerrarModal();
            })
            .catch(err => {
                console.error("Error al convertir en JSON o al conectar:", err);
                document.getElementById('mensaje-error').textContent = "❌ Error inesperado: " + err.message;
                cerrarModal();
            });

        }
    </script>
</body>
</html>
