const consulta = () => {
    let data = new FormData();
    data.append("metodo", "obtener_datos");
    fetch("./app/controller/Profesores.php", { // Cambié la URL a Profesores.php
        method: "POST",
        body: data
    }).then(respuesta => respuesta.json())
    .then(respuesta => {
        let contenido = '', i = 1;
        respuesta.map(profesor => {
            contenido += `
                <tr>
                    <th>${i++}</th>
                    <td>${profesor['nombre']}</td> <!-- Mostrando 'nombre' -->
                    <td>${profesor['apellido']}</td> <!-- Mostrando 'apellido' -->
                    <td>${profesor['horario']}</td> <!-- Mostrando 'horario' -->
                    <td>
                        <button type="button" class="btn btn-warning" onclick="precargar(${profesor['id_profesor']})"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button type="button" class="btn btn-danger" onclick="eliminar(${profesor['id_profesor']})"><i class="fa-solid fa-trash-can"></i></button>
                    </td>
                </tr>
            `;
        });
        $("#contenido_profesor").html(contenido); // Cambié el ID a 'contenido_profesor'
        $('#myTable').DataTable();
    });
};

const precargar = (id) => {
    let data = new FormData();
    data.append("id_profesor", id); // Cambié el parámetro a 'id_profesor'
    data.append("metodo", "precargar_datos");
    fetch("./app/controller/Profesores.php", { // Cambié la URL a Profesores.php
        method: "POST",
        body: data
    }).then(respuesta => respuesta.json())
    .then(respuesta => {
        $("#edit_nombre").val(respuesta['nombre']); // Cambié los campos a 'nombre' y 'apellido'
        $("#edit_apellido").val(respuesta['apellido']);
        $("#edit_horario").val(respuesta['horario']);
        $("#id_profesor_act").val(respuesta['id_profesor']); // Cambié el ID a 'id_profesor'
        $("#editarModal").modal('show');
    });
};

consulta();

const actualizar = () => {
    let data = new FormData();
    data.append("id_profesor", $("#id_profesor_act").val()); // Cambié el parámetro a 'id_profesor'
    data.append("nombre", $("#edit_nombre").val()); // Cambié los campos a 'nombre' y 'apellido'
    data.append("apellido", $("#edit_apellido").val());
    data.append("horario", $("#edit_horario").val());
    data.append("metodo", "actualizar_datos");
    fetch("./app/controller/Profesores.php", { // Cambié la URL a Profesores.php
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
    data.append("nombre", $("#nombre").val()); // Cambié los campos a 'nombre' y 'apellido'
    data.append("apellido", $("#apellido").val());
    data.append("horario", $("#horario").val());
    data.append("metodo", "insertar_datos");
    fetch("./app/controller/Profesores.php", { // Cambié la URL a Profesores.php
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
            data.append("id_profesor", id); // Cambié el parámetro a 'id_profesor'
            data.append("metodo", "eliminar_datos");
            fetch("./app/controller/Profesores.php", { // Cambié la URL a Profesores.php
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