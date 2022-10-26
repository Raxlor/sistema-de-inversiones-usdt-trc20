window.addEventListener("load", function (event) {
  escritorio();
});
function editar_usuario() {
  $.ajax({
    url: "vistas/modificar.php",
    type: "POST",
  }).always(function (html) {
    console.log("complete");
    $(".page_vista").html(html);
  });
}

function Mantenimiento() {
  alertify.error("Mantenimiento");
}

function escritorio() {
  $.ajax({
    type: "POST",
    url: "../vistas/asset/escritorio.php",
    success: function (resp) {
      $("#body-global").html(resp);
    },
    error: function (error) {
      alertify.error(error);
    },
  });
}

function deposito() {
  $.ajax({
    type: "POST",
    url: "../vistas/asset/deposito.php",
    beforeSend: function () { },
    success: function (resp) {
      $("#body-global").html(resp);
    },
    error: function (error) {
      alertify.error(error);
    },
  });
}

function conteo_regresivo(tiempo_end_wallet) {
  var timestamp = tiempo_end_wallet - Date.now();
  timestamp /= 1000; // from ms to seconds

  function component(x, v) {
    return Math.floor(x / v);
  }
  var $div = $("#end_time");

  setInterval(function () {
    timestamp--;

    var minutes = component(timestamp, 60) % 60,
      seconds = component(timestamp, 1) % 60;

    $div.html(minutes + ":" + seconds);
  }, 1000);
}

function Generar_wallet() {
  $.ajax({
    type: "POST",
    url: "../vistas/asset/orden.php",
    beforeSend: function () {
      $("#spinner-load-generar").removeAttr("hidden");
      $(".btn-smart-login").attr("hidden", true);
    },
    success: function (repuesta) {
      $("#wallet_deposit").html(repuesta);

      $("#wallet-img")
        .load(function () {
          $(".btn-smart-login").attr("hidden", true);
          $("#wallet_deposit").removeAttr("hidden");
          $("#spinner-load-generar").attr("hidden", true);
        })
        .error(function () {
          alert(
            "Hubo un Error cargando el QR, se te enviara a la pagina principal"
          );
          escritorio();
        });
    },
    error: function (error) {
      alertify.error(error);
    },
  });
}
function cancel_orden() {
  alertify.confirm(
    "Cancelacion de deposito",
    "Se cancelara la orden de deposito, seguro de continuar",
    function () {
      $("#wallet_deposit").attr("hidden", true);
      $.ajax({
        type: "POST",
        url: "../vistas/asset/cancelar_deposito.php",
        beforeSend: function () {
          $("#spinner-load-generar").removeAttr("hidden");
          $(".btn-smart-login").attr("hidden", true);
        },
        success: function (repuesta) {
          if (repuesta.cancelado == "0") {
            alertify.error(repuesta.msg);
          } else {
            alertify.success("Se cancelo la orden con exito");
            actualizar_transaciones_tabla_orden();
          }
          $(".btn-smart-login").removeAttr("hidden", true);

          $("#spinner-load-generar").attr("hidden", true);
        },
        error: function (error) {
          alertify.error("No se puede cargar la pagina");
        },
      });
    },
    function () {
      //no pasa nada
    }
  );
}

function cancel_orden_direct(id) {
  $.ajax({
    type: "POST",
    data: { id: id },
    url: "../vistas/asset/cancelar_deposito.php",
  });
}

function error_conexion_db_consulta() {
  alertify.error(
    "hay un problema con la conexion a  la base de datos, favor comunicar a un administrador"
  );
}
const status_save = true;
const destroy_glob = true;
const responsive = true;
function actualizar_transaciones_tabla_orden() {
  $("#spinner-load-generar-table").removeAttr("hidden");
  $("#section_table").attr("hidden", true);

  setTimeout(() => {
    $("#spinner-load-generar-table").attr("hidden", true);
    $("#section_table").removeAttr("hidden");

    $("#transaciones").DataTable({
      stateSave: status_save,
      destroy: destroy_glob,
      responsive: responsive,
      ajax: {
        url: "../vistas/asset/transacciones.php",
        type:"POST",
        dataSrc: "data",
      },
      columns: [
        {
          data: "id",
        },
        {
          data: "razon",
        },
        {
          data: "status",
        },
        {
          data: "monto",
        },
        {
          data: "fecha_registro",
        },
      ],
    });
  }, 1500);
}

function actualizar_contrato_tabla() {
  $("#spinner-load-generar-table").removeAttr("hidden");
  $("#section_table").attr("hidden", true);

  setTimeout(() => {
    $("#spinner-load-generar-table").attr("hidden", true);
    $("#section_table").removeAttr("hidden");
    $("#contratos").DataTable({
      stateSave: status_save,
      destroy: destroy_glob,
      responsive: responsive,
      ajax: {
        url: "../vistas/asset/contrato.php",
        type:"POST",
        dataSrc: "data",
      },
      columns: [
        {
          data: "id",
        },
        {
          data: "razon",
        },
        {
          data: "cantidad",
        },
        {
          data: "recibido",
        },
        {
          data: "fecha_start",
        },
      ],
    });
  }, 1000);
}
setInterval(() => {
  $.ajax({
    type: "POST",
    url: "../../control/helpers/session.php",
    success: function (repuesta) {
      if (repuesta.finalizado == 1) {
        window.location.href = "/";
      } else if (repuesta.finalizado == 2) {

        Swal.fire({
          icon: 'error',
          title: 'Inicio de sesion',
          text: 'Se inicio session desde otro dispositvo',
          showCancelButton: false,
          showConfirmButton: false
        })

        setTimeout(() => {
          window.location.href = "../../../../../?deslog";
        }, 2000);
      } else {
      }
    },
  });
}, 4500);
function info_membresia(e) {
  if (e > 0) {
    var formData = {
      id: e,
    };
    $.ajax({
      type: "POST",
      data: formData,
      url: "../../control/helpers/info_productos.php",
      beforeSend: function () { },
      success: function (resp) {
        Swal.fire({
          heightAuto: false,
          backdrop: false,
          title: "Información de beneficios",
          iconHtml: '<i class="fas fa-piggy-bank fx-4"></i>',

          iconColor: "rgb(62 185 15 / 70%)",
          html: resp,
          customClass: {
            icon: "no-border",
          },
        });
      },
      error: function (error) {
        alertify.error(error);
      },
    });
  }
}
/* It's a function that loads a page into a div. */
setInterval(() => {
  $.ajax({
    type: "POST",

    url: "../control/helpers/mensajes.php",
    success: function (repuesta) {
      if (repuesta.razon === "Deposito") {
        alertify.notify(repuesta.mensaje, "success", 3, function () {
          escritorio();
        });
      } else if (repuesta.razon === "Deposito-Cancelado") {
        alertify.notify(repuesta.mensaje, "error", 3, function () {
          escritorio();
        });
      } else {
      }
    },
  });
}, 4500);


/**
 * Es una función que carga una página en un div.
 */
function inversion() {
  $.ajax({
    type: "POST",
    url: "../vistas/asset/inversion.php",
    beforeSend: function () { },
    success: function (resp) {
      $("#body-global").html(resp);
    },
    error: function (error) {
      alertify.error(error);
    },
  });
}
function referidos() {
  $.ajax({
    type: "POST",
    url: "../vistas/asset/gestionar_referidos.php",
    beforeSend: function () { },
    success: function (resp) {
      $("#body-global").html(resp);
    },
    error: function (error) {
      alertify.error(error);
    },
  });
}
/**
 * It's a function that loads a page into a div.
 */
function perfil() {
  $.ajax({
    type: "POST",
    url: "../vistas/asset/perfil.php",
    beforeSend: function () { },
    success: function (resp) {
      $("#body-global").html(resp);
    },
    error: function (error) {
      alertify.error(error);
    },
  });
}
/**
 * It takes the values of two form fields, sends them to a PHP script, and then displays a message
 * based on the response from the PHP script.
 */
function activar_form_inv() {
  // deshabilito el btn para evitar que se duplique aunque le descontara igual y no procedera si esta sobre-pasada
  $(".btn").attr("disabled", true);
  var formData = {
    mont_id: $("#mont_id").val(),
    produc_id: $("#produc_id").val(),
  };
  $.ajax({
    type: "POST",
    url: "../control/forms_proceso/form_inversiones.php",
    data: formData,
    dataType: "json",
    encode: true,
  }).done(function (data) {
    if (data.status == true) {
      alertify.notify(data.mensaje, "success", 1, function () {
        escritorio();
      });
    } else {
      alertify.notify(data.mensaje, "error", 3, function () {
        //void()
      });
      $(".btn").removeAttr("disabled");
    }
  });
}
function waterpercent(value) {
  $("#contrato").removeAttr("hidden");
  $("#spinner-load-generar-contrato").attr("hidden", true);
  if (value > 0) {
  } else {
    cnt.innerHTML = 0;
  }
  var cnt = document.getElementById("count");
  var percent = cnt.innerText;
  var interval;
  interval = setInterval(function () {
    percent++;
    cnt.innerHTML = percent + "%";
    $(
      ".cloud"
    ).css(`background: -webkit-linear-gradient(top,rgb(27, 133, 185) 5%, #f1f1f1 100%);
     background: -o - linear - gradient(top, rgb(27, 133, 185) 5 %, #f1f1f1 100 %);
    background: -ms - linear - gradient(top, rgb(27, 133, 185) 5 %, #f1f1f1 100 %);
    background: linear - gradient(top, rgb(27, 133, 185) 5 %, #f1f1f1 100 %);`);
    if (percent == value) {
      clearInterval(interval);
    }
  }, 120);
}
