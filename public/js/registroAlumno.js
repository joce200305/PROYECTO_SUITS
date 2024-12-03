document.addEventListener('DOMContentLoaded', () => {
    // Ya no necesitamos cargar roles
});

// Función para agregar un alumno
const agregarAlumno = () => {
    const nombre = document.getElementById('nombre').value.trim();
    const usuario = document.getElementById('usuario').value.trim();
    const password = document.getElementById('password').value.trim();

    if (!nombre || !usuario || !password) {
        Swal.fire('Error', 'Todos los campos son obligatorios', 'error');
        return;
    }

    const datos = new URLSearchParams();
    datos.append('metodo', 'insertar_alumno');
    datos.append('nombre', nombre);
    datos.append('usuario', usuario);
    datos.append('password', password);

    fetch('./app/controller/registroAlumno.php', {
        method: 'POST',
        body: datos
    })
        .then(respuesta => respuesta.json())
        .then(data => {
            if (data[0] === 1) {
                // Alumno agregado correctamente
                Swal.fire('Éxito', data[1], 'success');
                $('#agregarModal').modal('hide');
                $(".modal-backdrop").removeClass("modal-backdrop");
            } else {
                // Si el usuario ya existe o hay otro error
                Swal.fire('Error', data[1], 'error');
            }
        })
        .catch(error => {
            console.error('Error al agregar alumno:', error);
            Swal.fire('Error', 'No se pudo registrar el alumno', 'error');
        });
};

// Evento de botón para registrar alumno
$('#btn_registro').on('click', () => {
    agregarAlumno();
});
