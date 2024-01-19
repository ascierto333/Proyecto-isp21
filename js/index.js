const nombreUsuario = document.getElementById("usuario");
const contraseñaUsuario = document.getElementById("pass");
const formulario = document.getElementById("loguin"); // Agregamos una referencia al formulario

formulario.addEventListener('submit', checkFormulario);

function checkFormulario(e) {
    let errors = [];
    let input = false;

    if (!nombreUsuario.value) {
        errors.push("Usuario: Debe llenar este campo");
        input = nombreUsuario;
    } else if (nombreUsuario.value.length <= 5 || nombreUsuario.value.length >= 11) {
        errors.push("Usuario: El nombre de usuario debe tener entre 6 y 10 caracteres");
        input = nombreUsuario;
    } else if (!(/^[0-9a-zA-Z]+$/.test(nombreUsuario.value))) {
        errors.push("Usuario: Solo debe introducir valores alfanuméricos");
        input = nombreUsuario;
    }
    if (!contraseñaUsuario.value) {
        errors.push("Contraseña: Debe llenar este campo");
        if (!input) {
            input = contraseñaUsuario;
        }
    } else if (!(/^[a-zA-Z0-9]+$/.test(contraseñaUsuario.value))) {
        errors.push("Contraseña: Solo debe introducir valores alfanuméricos");
        if (!input) {
            input = contraseñaUsuario;
        }
    } else if (!(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,18}$/.test(contraseñaUsuario.value))) {
        errors.push("Contraseña: Debe contener al menos 1 letra minúscula, 1 letra mayúscula y 1 número");
        if (!input) {
            input = contraseñaUsuario;
        }
    } else if (contraseñaUsuario.value.length !== 8) {
        errors.push("Contraseña: Debe contener exactamente 8 caracteres");
        if (!input) {
            input = contraseñaUsuario;
        }
    }

    if (errors.length > 0) {
        e.preventDefault();
        formulario.removeEventListener('submit', checkFormulario); // Desactivamos el evento de envío
        Swal.fire({
            title: 'Error',
            text: 'Error al ingresar los datos en \n' + errors.join('\n'),
            icon: "error",
        }).then(() => {
            formulario.addEventListener('submit', checkFormulario); // Reactivamos el evento de envío
            // Después de cerrar la alerta, enfocar el botón "OK"
            const okButton = document.querySelector(".swal2-confirm");
            if (okButton) {
                okButton.focus();
            }
        });
        if (input) {
            input.focus();
        }
    }
}

function mostrarContrasena() {
    if (contraseñaUsuario.type === "password") {
        contraseñaUsuario.type = "text";
    } else {
        contraseñaUsuario.type = "password";
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const dniInput = document.getElementById("dni");
    const cantProdInput = document.getElementById("codProd");

    formulario.addEventListener('submit', function (event) {
        if (!validarSoloNumeros(dniInput.value)) {
            alert("DNI inválido. Debe contener solo números.");
            event.preventDefault();
        }

        if (!validarSoloNumeros(cantProdInput.value)) {
            alert("Cantidad inválida. Debe ser un número entre 1 y 99.");
            event.preventDefault();
        }
    });

    function validarSoloNumeros(valor) {
        return /^\d+$/.test(valor);
    }
});