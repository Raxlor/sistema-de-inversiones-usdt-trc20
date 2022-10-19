<form class="" method="post" id="register_form" action="javascript:void(0)" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-12">

            <div style="text-align: center; margin-bottom:20px;">
                <h4 style="color:#094267">REGISTRO DE CUENTA </h4>
            </div>
            <div class="row">

                <div class="col-6">
                    <label class="single-input-wrap">
                        <input type="text" name="username" id="username" required maxlength="10" placeholder="Usuario">
                    </label>
                </div>
                <div class="col-6">
                    <label class="single-input-wrap">
                        <input type="text" name="nombre_completo" id="name_full" required maxlength="20"
                            placeholder="Nombre completo">
                    </label>
                </div>
                <div class="col-12">
                    <label class="single-input-wrap">
                        <input type="email" name="email" maxlength="40" id="email" required placeholder="Correo Electronico">
                    </label>
                </div>
                <div class="col-6">
                    <label class="single-input-wrap">
                        <input type="password" name="myPassword" id="myPassword" required maxlength="18" placeholder="Contraseña">
                    </label>
                </div>
                <div class="col-6">
                    <label class="single-input-wrap">
                        <input type="password" name="myConfirmPassword" id="myConfirmPassword" required maxlength="18"
                            placeholder="confirmar contraseña">
                    </label>
                </div>
                <div class="col-12">
                    <div id="errors" class="color:red" style="color: red;"></div>
                </div>
                <div class="col-12">
                    <label class="single-input-wrap">
                        <input readonly type="text" name="1" value="<?php echo (isset($_GET['ref']))?  $_GET['ref'] : '' ; ?>" id="codigo" required maxlength="40"
                            placeholder="Patrocinador">
                    </label>
                </div>
                <script>
                $(document).ready(function() {
                    $("#myPassword").passwordValidation({"confirmField": "#myConfirmPassword"}, function(element, valid, match, failedCases) {
                        $("#errors").html(failedCases.join("\n") );
                         if(valid){
                             $(element).css("border","1px solid green");
                            }
                         if(!valid) $(element).css("border","1px solid red");
                         if(valid && match)
                            {

                                $("#myConfirmPassword").css("border","1px solid green");
                                $('#registrar').removeAttr('disabled');

                            }
                         if(!valid || !match){
                             $("#myConfirmPassword").css("border","1px solid #ff000024");
                         }
                    });
                });
                </script>

            </div>

            <div style="text-align-last: center;">
                <div class="form-check">
                    <input    class="form-check-input" style="margin-top: 0.1rem;    cursor: pointer;" type="checkbox" value="" id="flexCheckDefault" required>
                    <label class="form-check-label" for="flexCheckDefault"  style="    cursor: pointer;">
                        Acepto los <a  style="color:#2196f3;" href="/" target="_blank" rel="">términos y condiciones</a>
                    </label>
                </div>
            </div>
            <div style="text-align: center; margin-top:20px;">
                <span class="mt-2" style="text-align: center;">
                    ¿Ya tienes una cuenta?
                    <a href="/"><strong class="" style="color: #2196f3;">
                            Acceder
                        </strong></a>
                    </a>
                </span>
            </div>

            <input type="submit" class="btn btn-smart-login text-white"  id="registrar" disabled value="Registrarme"/>
        </div>
    </div> 
    <div class="msg"></div>
</form>
