const mensaje_error = (msj) => {
    Swal.fire({
        title: "Error!",
        text: msj,
        icon: "warning",
        confirmButtonText: "Aceptar"
    });
};

const mensaje_exito = (msj) => {
    Swal.fire({
        title: "Correcto!",
        text: msj,
        icon: "success",
        confirmButtonText: "Aceptar"
    });
};

const iniciar_sesion = () => {
    let data = new FormData();
    data.append("usuario", $("#usuario").val());
    data.append("password", $("#password").val());
    data.append("metodo", "iniciar_sesion");

    fetch("./app/controller/Login.php", {
        method: "POST",
        body: data
    })
        .then(respuesta => respuesta.json())
        .then(respuesta => {
            if (respuesta[0] == 1) {
                mensaje_exito(respuesta[1]);
                setTimeout(() => {
                    window.location = respuesta[2];
                }, 1500);
            } else {
                mensaje_error(respuesta[1]);
            }
        })
        .catch(error => {
            console.error("Error en la solicitud:", error);
            mensaje_error("Hubo un problema con la conexión. Intenta de nuevo.");
        });
};

$("#btn_iniciar").on('click', () => {
    iniciar_sesion();
});
$("#btn_registro").on('click', () => {
    registro();
});
