const consultaCalificaciones = () => {
    let data = new FormData();
    data.append("metodo", "obtener_datos");
    fetch("./app/controller/Calificaciones.php", {
        method: "POST",
        body: data
    }).then(respuesta => respuesta.json())
        .then(respuesta => {
            let contenido = '', i = 1;
            respuesta.map(calificacion => {
                contenido += `
                <tr>
                    <th>${i++}</th>
                    <td>${calificacion['alumno']}</td>
                    <td>${calificacion['materia']}</td>
                    <td>${calificacion['profesor']}</td>
                    <td>${calificacion['calificacion']}</td>
                    <td>${calificacion['fecha']}</td>
                    <td>
                        <button type="button" class="btn btn-warning" onclick="precargar(${calificacion['id_calificacion']})"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button type="button" class="btn btn-danger" onclick="eliminar(${calificacion['id_calificacion']})"><i class="fa-solid fa-trash-can"></i></button>
                    </td>
                </tr>
            `;
            });

            if ($.fn.dataTable.isDataTable('#myTable')) {
                $('#myTable').DataTable().clear().destroy();
            }
            $("#contenido_calificaciones").html(contenido);
            $('#myTable').DataTable(); 
           
        });
};


const precargar = (id) => {
    let data = new FormData();
    data.append("id_calificacion", id);
    data.append("metodo", "precargar_datos");
    fetch("./app/controller/Calificaciones.php", {
        method: "POST",
        body: data
    }).then(respuesta => respuesta.json())
        .then(respuesta => {
            if (respuesta[0] !== 0) {
                $("#edit_calificacion").val(respuesta['calificacion']);
                $("#edit_fecha").val(respuesta['fecha']);
                $("#id_calificacion_act").val(respuesta['id_calificacion']);
                $("#editarModal").modal('show');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: respuesta[1]
                });
            }
        });
};

const actualizar = () => {
    let data = new FormData();
    data.append("id_calificacion", $("#id_calificacion_act").val());
    data.append("calificacion", $("#edit_calificacion").val());
    data.append("fecha", $("#edit_fecha").val());
    data.append("metodo", "actualizar_datos");

    fetch("./app/controller/Calificaciones.php", {
        method: "POST",
        body: data
    }).then(respuesta => respuesta.json())
        .then(respuesta => {
            if (respuesta[0] == 1) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: respuesta[1],
                    timer: 1500,
                    showConfirmButton: false
                });
                consultaCalificaciones();
                $("#editarModal").modal('hide');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: respuesta[1]
                });
            }
        });
};

const agregar = () => {
    let data = new FormData();
    data.append("id_alumno", $("#id_alumno").val());
    data.append("id_materia", $("#id_materia").val());
    data.append("calificacion", $("#calificacion").val());
    data.append("fecha", $("#fecha").val());
    data.append("metodo", "insertar_datos");

    fetch("./app/controller/Calificaciones.php", {
        method: "POST",
        body: data
    }).then(respuesta => respuesta.json())
    .then(respuesta => {
        console.log(respuesta); 
        if (respuesta[0] == 1) {
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: respuesta[1],
                timer: 1500,
                showConfirmButton: false
            });
            consultaCalificaciones();
            $("#agregarModal").modal('hide');
            $(".modal-backdrop").removeClass("modal-backdrop");
        } else {
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: respuesta[1]
            });
        }
    })
    .catch(err => {
        console.error("Error en la inserción:", err); // Ver errores en la consola
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Hubo un problema al agregar la calificación.'
        });
    });
};




// Función para eliminar una calificación
const eliminar = (id) => {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás deshacer esta acción!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((resultado) => {
        if (resultado.isConfirmed) {
            let data = new FormData();
            data.append("id_calificacion", id); // Cambié el parámetro a 'id_calificacion'
            data.append("metodo", "eliminar_datos");

            fetch("./app/controller/Calificaciones.php", {
                method: "POST",
                body: data
            }).then(respuesta => respuesta.json())
                .then(respuesta => {
                    if (respuesta[0] == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Eliminado!',
                            text: respuesta[1],
                            timer: 1500,
                            showConfirmButton: false
                        });
                        consultaCalificaciones();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '¡Error!',
                            text: respuesta[1]
                        });
                    }
                });
        }
    });
};

// Función para cargar los alumnos en el select
function cargarAlumnos() {
    fetch('./app/controller/Calificaciones.php', {
        method: 'POST',
        body: new URLSearchParams({ metodo: 'obtener_alumnos' })
    })
        .then(res => res.json())
        .then(data => {
            let opciones = '<option value="">Seleccionar alumno</option>';
            data.forEach(alumno => {
                opciones += `<option value="${alumno.id_alumno}">${alumno.nombre} ${alumno.apellido}</option>`;
            });
            document.getElementById('id_alumno').innerHTML = opciones;
        })
        .catch(err => console.error('Error al cargar alumnos:', err));
}

// Función para cargar las materias en el select
function cargarMaterias() {
    fetch('./app/controller/Calificaciones.php', {
        method: 'POST',
        body: new URLSearchParams({ metodo: 'obtener_materias' })
    })
        .then(res => res.json())
        .then(data => {
            let opciones = '<option value="">Seleccionar materia</option>';
            data.forEach(materia => {
                opciones += `<option value="${materia.id_materia}">${materia.nombre_materia}</option>`;
            });
            document.getElementById('id_materia').innerHTML = opciones;
        })
        .catch(err => console.error('Error al cargar materias:', err));
}






// Inicialización de la página
$(document).ready(function () {
    cargarAlumnos();
    cargarMaterias();
    $('#myTable').DataTable();
    consultaCalificaciones();
});

// Eventos de los botones
$('#btn_actualizar').on('click', () => {
    actualizar();
});

$('#btn_agregar').on('click', () => {
    agregar();
});
