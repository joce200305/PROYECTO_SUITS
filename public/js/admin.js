const consulta = () => {
    let data = new FormData();
    data.append("metodo", "obtener_datos");
    fetch("./app/controller/Admin.php", {  // Cambié "Productos.php" a "Alumnos.php"
        method: "POST",
        body: data
    }).then(respuesta => respuesta.json())
    .then(respuesta => {
        let contenido = '', i = 1;
        respuesta.map(alumno => {
            contenido += `
                <tr>
                    <th>${i++}</th>
                    <td>${alumno['nombre']}</td>
                    <td>${alumno['apellido']}</td>
                    <td>${alumno['fecha_nacimiento']}</td>
                    <td>${alumno['matricula']}</td>
                    <td>${alumno['semestre']}</td>
                    <td>${alumno['carrera']}</td>
                    <td>
                        <button type="button" class="btn btn-warning" onclick="precargar(${alumno['id_alumno']})"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button type="button" class="btn btn-danger" onclick="eliminar(${alumno['id_alumno']})"><i class="fa-solid fa-trash-can"></i></button>
                    </td>
                </tr>
            `;
        });
        $("#contenido_alumno").html(contenido);
        $('#myTable').DataTable();
    });
};

const precargar = (id) => {
    let data = new FormData();
    data.append("id_alumno", id);  // Cambié "id_producto" a "id_alumno"
    data.append("metodo", "precargar_datos");
    fetch("./app/controller/Admin.php", {  // 
        method: "POST",
        body: data
    }).then(respuesta => respuesta.json())
    .then(respuesta => {
        $("#edit_nombre").val(respuesta['nombre']);
        $("#edit_apellido").val(respuesta['apellido']);
        $("#edit_fecha_nacimiento").val(respuesta['fecha_nacimiento']);
        $("#edit_matricula").val(respuesta['matricula']);
        $("#edit_semestre").val(respuesta['semestre']);
        $("#edit_carrera").val(respuesta['carrera']);
        $("#id_alumno_act").val(respuesta['id_alumno']);
        $("#editarModal").modal('show');
    });
};

consulta();

const actualizar = () => {
    let data = new FormData();
    data.append("id_alumno", $("#id_alumno_act").val());
    data.append("nombre", $("#edit_nombre").val());
    data.append("apellido", $("#edit_apellido").val());
    data.append("fecha_nacimiento", $("#edit_fecha_nacimiento").val());
    data.append("matricula", $("#edit_matricula").val());
    data.append("semestre", $("#edit_semestre").val());
    data.append("carrera", $("#edit_carrera").val());
    data.append("metodo", "actualizar_datos");
    fetch("./app/controller/Admin.php", {  // Cambié "Productos.php" a "Alumnos.php"
        method: "POST",
        body: data
    }).then(respuesta => respuesta.json())
    .then(respuesta => {
        if (respuesta[0] == 1) {
            // SweetAlert de éxito
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: respuesta[1],
                timer: 1500,
                showConfirmButton: false
            });
            consulta();
            $("#editarModal").modal('hide');
        } else {
            // SweetAlert de error
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
    data.append("nombre", $("#nombre").val());
    data.append("apellido", $("#apellido").val());
    data.append("fecha_nacimiento", $("#fecha_nacimiento").val());
    data.append("matricula", $("#matricula").val());
    data.append("semestre", $("#semestre").val());
    data.append("carrera", $("#carrera").val());
    data.append("metodo", "insertar_datos");
    fetch("./app/controller/Admin.php", {  // Cambié "Productos.php" a "Alumnos.php"
        method: "POST",
        body: data
    }).then(respuesta => respuesta.json())
    .then(respuesta => {
        if (respuesta[0] == 1) {
            // SweetAlert de éxito
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: respuesta[1],
                timer: 1500,
                showConfirmButton: false
            });
            consulta();
            $("#agregarModal").modal('hide');
            $(".modal-backdrop").removeClass("modal-backdrop");
        } else {
            // SweetAlert de error
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: respuesta[1]
            });
        }
    });
};

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
            data.append("id_alumno", id);  // Cambié "id_producto" a "id_alumno"
            data.append("metodo", "eliminar_datos");
            fetch("./app/controller/Admin.php", {  // Cambié "Productos.php" a "Alumnos.php"
                method: "POST",
                body: data
            }).then(respuesta => respuesta.json())
            .then(respuesta => {
                if (respuesta[0] == 1) {
                    // SweetAlert de éxito
                    Swal.fire({
                        icon: 'success',
                        title: '¡Eliminado!',
                        text: respuesta[1],
                        timer: 1500,
                        showConfirmButton: false
                    });
                    consulta();
                } else {
                    // SweetAlert de error
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


$('#btn_actualizar').on('click', () => {
    actualizar();
});

$('#btn_agregar').on('click', () => {
    agregar();
});
