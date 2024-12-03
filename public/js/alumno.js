// Función para obtener los datos desde el controlador y cargar en la tabla
const obtenerDatos = () => {
    let data = new FormData();
    data.append("metodo", "obtener_datos"); // Especificamos el método que debe ejecutar el controlador

    fetch("./app/controller/Alumno.php", {
        method: "POST",
        body: data
    })
    .then(respuesta => respuesta.json())  // Convertir la respuesta en formato JSON
    .then(datos => {
        let contenido = '';  // Variable donde almacenamos las filas de la tabla
        let i = 1;

        // Iteramos sobre los datos y agregamos las filas a la tabla
        datos.forEach(calificacion => {
            contenido += `
                <tr>
                    <th>${i++}</th>
                    <td>${calificacion.alumno}</td>
                    <td>${calificacion.materia}</td>
                    <td>${calificacion.profesor}</td>
                    <td>${calificacion.calificacion}</td>
                    <td>${calificacion.fecha}</td>
                </tr>
            `;
        });

        // Insertamos el contenido en el cuerpo de la tabla
        document.getElementById('contenido_calificaciones').innerHTML = contenido;

        // Opcional: Si usas DataTables, inicializa el plugin
        $('#myTable').DataTable();
    })
    .catch(error => {
        console.error('Error al obtener los datos:', error);  // Mostrar cualquier error ocurrido durante la consulta
    });
};

// Llamamos a la función al cargar la página
document.addEventListener('DOMContentLoaded', () => {
    obtenerDatos();
});
