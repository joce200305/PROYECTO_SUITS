document.addEventListener('DOMContentLoaded', () => {
    cargarRoles();
    cargarUsuarios();
});

// Función para cargar los roles al `select`
const cargarRoles = () => {
    fetch('./app/controller/Registro.php', {
        method: 'POST',
        body: new URLSearchParams({ metodo: 'obtenerRoles' })
    })
        .then(respuesta => {
            if (!respuesta.ok) {
                throw new Error("Error en la respuesta del servidor");
            }
            return respuesta.json();
        })
        .then(roles => {
            let options = '';
            roles.forEach(rol => {
                options += `<option value="${rol.id_roles}">${rol.descripcion}</option>`;
            });
            document.getElementById('rol').innerHTML = options;
            document.getElementById('edit_rol').innerHTML = options;
        })
        .catch(error => {
            console.error("Error al cargar roles:", error);
        });
};

// Función para cargar los usuarios
let usuarios = []; // Declarar globalmente al inicio del script

const cargarUsuarios = () => {
    fetch('./app/controller/Registro.php', {
        method: 'POST',
        body: new URLSearchParams({ metodo: 'obtener_datos' })
    })
        .then(respuesta => {
            if (!respuesta.ok) {
                throw new Error("Error en la respuesta del servidor");
            }
            return respuesta.json();
        })
        .then(data => {
            usuarios = data; // Guarda los usuarios globalmente
            let contenido = '';
            if (usuarios.length === 0) {
                console.warn("No se recibieron usuarios del servidor.");
            }
            usuarios.forEach(usuario => {
                contenido += `
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">${usuario.nombre}</h5>
                        <p class="card-text">Usuario: ${usuario.usuario}</p>
                        <p class="card-text">Rol: ${usuario.rol}</p>
                        <button class="btn btn-primary" onclick="editarUsuario(${usuario.id_usuario})">Editar</button>
                        <button class="btn btn-danger" onclick="eliminarUsuario(${usuario.id_usuario})">Eliminar</button>
                    </div>
                </div>
            </div>
            `;
            });
            document.getElementById('contenido_usuarios').innerHTML = contenido;
        })
        .catch(error => console.error("Error al cargar usuarios:", error));
};

// Función para agregar un usuario
const agregarUsuario = () => {
    const nombre = document.getElementById('nombre_usuario').value.trim();
    const usuario = document.getElementById('usuario').value.trim();
    const password = document.getElementById('password').value.trim();
    const rol = document.getElementById('rol').value;

    if (!nombre || !usuario || !password || !rol) {
        Swal.fire('Error', 'Todos los campos son obligatorios', 'error');
        return;
    }

    const datos = new URLSearchParams();
    datos.append('metodo', 'insertar_datos');
    datos.append('nombre', nombre);
    datos.append('usuario', usuario);
    datos.append('password', password);
    datos.append('id_rol', rol);

    fetch('./app/controller/Registro.php', {
        method: 'POST',
        body: datos
    })
        .then(respuesta => respuesta.json())
        .then(data => {
            if (data[0] === 1) {
                // Usuario agregado correctamente
                Swal.fire('Éxito', data[1], 'success');
                cargarUsuarios(); // Recargar la lista de usuarios
                $('#agregarModal').modal('hide');
                $(".modal-backdrop").removeClass("modal-backdrop");
            } else {
                // Aquí se maneja si el usuario ya existe o si hubo otro error
                Swal.fire('Error', data[2], 'error');
            }
        })
        .catch(error => {
            console.error('Error al agregar usuario:', error);
            Swal.fire('Error', 'No se pudo agregar el usuario', 'error');
        });
};


// Función para editar un usuario
const editarUsuario = (id_usuario) => {
    const usuario = usuarios.find(user => user.id_usuario === id_usuario);
    if (usuario) {
        document.getElementById('id_usuario_act').value = usuario.id_usuario;
        document.getElementById('edit_nombre_usuario').value = usuario.nombre;
        document.getElementById('edit_usuario').value = usuario.usuario;
        document.getElementById('edit_password').value = ''; // No mostrar contraseña si no es necesario
        document.getElementById('edit_rol').value = usuario.id_rol;  // Asignar el rol correctamente

        // Mostrar el modal de edición
        $('#editarModal').modal('show');
    }
};

// Función para actualizar un usuario
const actualizarUsuario = () => {
    const id_usuario = document.getElementById('id_usuario_act').value;
    const nombre = document.getElementById('edit_nombre_usuario').value.trim();
    const usuario = document.getElementById('edit_usuario').value.trim();
    const password = document.getElementById('edit_password').value.trim();
    const rol = document.getElementById('edit_rol').value;

    if (!id_usuario || !nombre || !usuario || !rol) {
        Swal.fire('Error', 'Todos los campos son obligatorios', 'error');
        return;
    }

    const datos = new URLSearchParams();
    datos.append('metodo', 'actualizar_usuario');
    datos.append('id_usuario', id_usuario);
    datos.append('nombre', nombre);
    datos.append('usuario', usuario);
    if (password) {
        datos.append('password', password);
    }
    datos.append('id_rol', rol);

    fetch('./app/controller/Registro.php', {
        method: 'POST',
        body: datos
    })
        .then(response => response.json())
        .then(result => {
            if (result[0] === 1) {
                Swal.fire('Éxito', 'Usuario actualizado correctamente', 'success');
                $('#editarModal').modal('hide');
                cargarUsuarios();
            } else {
                Swal.fire('Error', result[1], 'error');
            }
        })
        .catch(error => {
            console.error('Error al actualizar usuario:', error);
            Swal.fire('Error', 'No se pudo actualizar el usuario', 'error');
        });
};

// Función para eliminar un usuario
const eliminarUsuario = (id_usuario) => {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "No podrás revertir esta acción",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar'
    }).then((result) => {
        if (result.isConfirmed) {
            const datos = new URLSearchParams();
            datos.append('metodo', 'eliminar_usuario');
            datos.append('id_usuario', id_usuario);

            fetch('./app/controller/Registro.php', {
                method: 'POST',
                body: datos
            })
                .then(response => response.json())
                .then(data => {
                    if (data[0] === 1) {
                        Swal.fire('Eliminado', data[1], 'success');
                        cargarUsuarios();
                    } else {
                        Swal.fire('Error', data[1], 'error');
                    }
                })
                .catch(error => console.error("Error al eliminar usuario:", error));
        }
    });
};


// Eventos de botones
$('#btn_agregar').on('click', () => {
    agregarUsuario();
});

$('#btn_actualizar').on('click', () => {
    actualizarUsuario();
});
