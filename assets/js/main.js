
$("#login_form").submit(function () {
  // var response = grecaptcha.getResponse();
  if (false) {
    alertify.error("Captcha no verificado");
  } else {
    contraseña = $("#pass").val();
    cedula = $("#cedula").val();
    $.ajax({
      type: "POST",
      data: "nick=" + cedula + "&contraseña=" + contraseña,
      url: "./control/login.php",
      success: function (resp) {
        if (resp.access === true) {
          alertify.success("Acceso aprobado");
          setTimeout(() => {
            location.href = "/";
          }, 1000);
        } else {
          alertify.error(resp.msg);
        }
      },
      error: function (error) {
        alertify.error("Pagina tiene un erro interno, verifica tu conexion");
      },
    });
  }
});

$("#reset").submit(function () {
  // var response = grecaptcha.getResponse();
  if (false) {
    alertify.error("Captcha no verificado");
  } else {
    code = $("#code").val();
    myPassword = $("#myPassword").val();
    $.ajax({
      type: "POST",
      data: "code=" + code + "&myPassword=" + myPassword,
      url: "/control/forms_proceso/form_restablecimiento.php",
      success: function (resp) {
        if (resp.status == true) {
          alertify.success(resp.msg);
          setTimeout(() => {
            location.href = "/";
          }, 1000);
        } else {
          alertify.error(resp.msg);
        }
      },
      error: function (error) {
        alertify.error("Pagina tiene un erro interno, verifica tu conexion");
      },
    });
  }
});
function link_referido() {
  $(".btn").attr("disabled", true);
  $.ajax({
type: "POST",
url: "../../vistas/asset/link_generar.php",
success: function (resp) {
  if (true) {
    alertify.success("Link Creado");
    setTimeout(() => {
      perfil()
      $(".btn").removeAttr("disabled");

    }, 1000);
  } else {
    alertify.error(resp);
  }
},
error: function (error) {
  alertify.error("Pagina tiene un erro interno, verifica tu conexion");
},
});
}
$(function () {
  $("#register_form").on("submit", function (e) {
    $(".btn").attr("disabled", true);
    /* Prevención de la acción predeterminada del formulario. */
    e.preventDefault();
    /* Crear un nuevo objeto FormData, que es una forma de enviar fácilmente datos de formulario a un
    servidor. */
    var formData = new FormData(document.getElementById("register_form"));
    /* Envío de los datos del formulario al servidor. */
    $.ajax({
      url: "../../control/forms_proceso/form_registro_usuario.php",
      type: "post",
      dataType: "json",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      beforeSend: function () {
        //nada de momento
      },
    })
      /* Una función que se ejecuta cuando se realiza la solicitud. */
      .done(function (res) {
        if (res.status) {
          alertify.success(res.msg);
          $("#register_form").trigger("reset");
          setTimeout(() => {
            //location.href = '/';
          }, 1000);
        } else {
          if (res.msg !== "Recuperar") {
            alertify.error(`El ` + res.msg + ` no se encuentra disponible`);
          } else {
            Swal.fire({
              icon: "question",
              title: "¿Tienes problemas?",
              text: "Encontramos que correo y nombre de usuario estan en nuestra base de datos, Quiere recuperar la contraseña de su cuenta o tiene algun tipo de problema",
              showCancelButton: true,
              showConfirmButton: true,
              confirmButtonText: "Si, Por favor",
              denyButtonText: `No, Gracias`,
            }).then((result) => {
              /* Read more about isConfirmed, isDenied below */
              if (result.isConfirmed) {
                location.href = '/?restablecer';
              } else if (result.isDenied) {
              }
            });
          }
        }
        setTimeout(() => {
          $("#registrar").removeAttr("disabled");
        }, 100);
      })
      // Mensaje de error al enviar el formulario
      .fail(function (res) {
        $(".msg").html(res);
      });
  });
});

/**
 * Crea un elemento div temporal, copia el contenido del elemento que desea copiar, selecciona el
 * contenido del elemento div temporal, copia el contenido del elemento div temporal y luego elimina el
 * elemento div temporal.
 */

function ejecutar(idelemento){
  var aux = document.createElement("div");
  aux.setAttribute("contentEditable", true);
  aux.innerHTML = idelemento
  aux.setAttribute("onfocus", "document.execCommand('selectAll',false,null)");
  document.body.appendChild(aux);
  aux.focus();
  document.execCommand("copy");
  document.body.removeChild(aux);
  alertify.success('Link de referido copiado.');
}