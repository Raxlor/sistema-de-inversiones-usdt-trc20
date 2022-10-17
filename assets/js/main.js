(function ($) {
  "use strict";
  $(document).ready(function () {
    /* -------------------------------------------------
            menu 
        ------------------------------------------------- */
    if ($(".menu-bar").length) {
      $(".menu-bar").on("click", function () {
        $(".ba-navbar").toggleClass("ba-navbar-show", "linear");
      });
      $("body").on("click", function (event) {
        if (
          !$(event.target).closest(".menu-bar").length &&
          !$(event.target).closest(".ba-navbar").length
        ) {
          $(".ba-navbar").removeClass("ba-navbar-show");
        }
      });
      $(".menu-close").on("click", function () {
        $(".ba-navbar").toggleClass("ba-navbar-show", "linear");
      });
    }
    /* -------------------------------------------------
            add balance 
        ------------------------------------------------- */
    if ($(".ba-add-balance-btn").length) {
      $(".ba-add-balance-btn").on("click", function () {
        $(".add-balance-inner-wrap").toggleClass(
          "add-balance-inner-wrap-show",
          "linear"
        );
      });
      $("body").on("click", function (event) {
        if (
          !$(event.target).closest(".ba-add-balance-btn").length &&
          !$(event.target).closest(".add-balance-inner-wrap").length
        ) {
          $(".add-balance-inner-wrap").removeClass(
            "add-balance-inner-wrap-show"
          );
        }
      });
    }

    /*------------------------------------------------
            Search Popup
        ------------------------------------------------*/
    var bodyOvrelay = $("#body-overlay");
    var searchPopup = $("#search-popup");
    var sidebarMenu = $("#sidebar-menu");

    $(document).on("click", "#body-overlay", function (e) {
      e.preventDefault();
      bodyOvrelay.removeClass("active");
      searchPopup.removeClass("active");
      sidebarMenu.removeClass("active");
    });
    $(document).on("click", ".search", function (e) {
      e.preventDefault();
      searchPopup.addClass("active");
      bodyOvrelay.addClass("active");
    });

    /* -------------------------------------------------------------
            carousels js
        ------------------------------------------------------------- */
    $(".carousel-1").owlCarousel({
      loop: true,
      nav: false,
      dots: false,
      smartSpeed: 1500,
      items: 1,
    });

    //carousel-2
    $(".carousel-2").owlCarousel({
      loop: true,
      nav: false,
      dots: false,
      smartSpeed: 1500,
      margin: 20,
      items: 2,
    });

    //carousel-3
    $(".carousel-3").owlCarousel({
      loop: true,
      nav: false,
      dots: false,
      smartSpeed: 1500,
      margin: 20,
      items: 2,
      stagePadding: 70,
    });

    //carousel-4
    $(".carousel-4").owlCarousel({
      loop: true,
      nav: false,
      dots: false,
      smartSpeed: 1500,
      margin: 20,
      items: 3,
    });

    //carousel-5
    $(".carousel-5").owlCarousel({
      loop: true,
      nav: false,
      dots: false,
      smartSpeed: 1500,
      margin: 10,
      items: 4,
    });

    /*------------------------------------------------
            trading-product-slider
        ------------------------------------------------*/
    var leftArrow = '<i class="fa fa-angle-left"></i>';
    var rightArrow = '<i class="fa fa-angle-right"></i>';
    $(".send-money-slider").owlCarousel({
      stagePadding: 50,
      loop: true,
      margin: 10,
      nav: false,
      dots: false,
      smartSpeed: 1500,
      responsive: {
        0: {
          items: 2,
        },
        374: {
          items: 3,
        },
        1000: {
          items: 5,
        },
      },
    });

    $(".blog-slider").owlCarousel({
      loop: true,
      margin: 10,
      nav: false,
      dots: false,
      smartSpeed: 1500,
      responsive: {
        0: {
          items: 2,
        },
        600: {
          items: 3,
        },
        1000: {
          items: 5,
        },
      },
    });

    /* -------------------------------------------------------------
          RoundCircle Progress js
        ------------------------------------------------------------- */
    if ($(".chart-circle").length) {
      $(".chart-circle").each(function () {
        let $this = $(this);
        $this.circleProgress({
          fill: {
            color: $this.attr("data-color"),
          },
          size: $this.height(),
          startAngle: (-Math.PI / 4) * 2,
          emptyFill: "rgba(0,0,0,0.2)",
          lineCap: "round",
        });
      });
    }

    /* circle-one */
    $(".single-goal-one .chart-circle").circleProgress({
      fill: {
        gradient: ["#1dcc70", "#1dcc70"],
      },
    });
    /* circle-two */
    $(".single-goal-two .chart-circle").circleProgress({
      fill: {
        gradient: ["#9a3ada", "#9a3ada"],
      },
    });
    /* circle-three */
    $(".single-goal-three .chart-circle").circleProgress({
      fill: {
        gradient: ["#ff396f", "#ff396f"],
      },
    });
    /* circle-four */
    $(".single-goal-four .chart-circle").circleProgress({
      fill: {
        gradient: ["#6236ff", "#6236ff"],
      },
    });

    /*-----------------
        auto notification 
        ------------------*/
    $("#overlay").modal("show");

    setTimeout(function () {
      $("#overlay").modal("hide");
    }, 1500);
  });

  $(window).on("load", function () {
    /*-----------------
            preloader
        ------------------*/
    var preLoder = $("#preloader");
    preLoder.fadeOut(0);

    /*-----------------
            back to top
        ------------------*/
    var backtoTop = $(".back-to-top");
    backtoTop.fadeOut();

    /*---------------------
            Cancel Preloader
        ----------------------*/
    $(document).on("click", ".cancel-preloader a", function (e) {
      e.preventDefault();
      $("#preloader").fadeOut(2000);
    });
  });
})(jQuery);
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
      url: "../control/login.php",
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
            location.href='/';
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
                location.href='/?restablecer';
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
