const formState = {
        servicio: null,
        nombre: '',
        apellido: '',
        telefono: '',
        correo: '',
        fecha: '',
        hora: ''
    };

    function mostrarPaso(n) {
        document.querySelectorAll('.paso-formulario').forEach(p => p.classList.add('hidden'));
        document.querySelector(`#paso${n}`).classList.remove('hidden');
    }

    // Paso 1: Escuchar botones de servicio
    document.querySelectorAll('#paso1 .icono button').forEach(button => {
        button.addEventListener('click', () => {
            formState.servicio = button.dataset.servicio;
            document.getElementById('servicioSeleccionado').value = formState.servicio;
            mostrarPaso(2);
        });
    });

    // Paso 2: Manejar el formulario de datos
    document.getElementById('form-datos').addEventListener('submit', function (e) {
        e.preventDefault();

        // Guardar datos
        formState.nombre = document.getElementById('nombre').value;
        formState.apellido = document.getElementById('apellido').value;
        formState.telefono = document.getElementById('telefono').value;
        formState.correo = document.getElementById('correo').value;
        formState.fecha = document.getElementById('fecha').value;
        formState.hora = document.getElementById('hora').value;

        // Insertar los datos en el HTML del paso 3
        document.getElementById('resumen-servicio').textContent = formState.servicio;
        document.getElementById('resumen-nombre').textContent = `${formState.nombre} ${formState.apellido}`;
        document.getElementById('resumen-telefono').textContent = formState.telefono;
        document.getElementById('resumen-correo').textContent = formState.correo;
        document.getElementById('resumen-fecha').textContent = formState.fecha;
        document.getElementById('resumen-hora').textContent = formState.hora;

        mostrarPaso(3);
    });

    // Paso 3: Simular envío
    function enviarFormulario() {
    console.log("Formulario enviado:", formState);

    // Insertar nombre en mensaje final
    document.getElementById('gracias-nombre').textContent = formState.nombre;

    mostrarPaso(4);
    }

    // Mostrar paso inicial al cargar
    document.addEventListener('DOMContentLoaded', () => mostrarPaso(1));