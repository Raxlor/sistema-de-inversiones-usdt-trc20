<form class="" method="post" id="reset_form" action="javascript:void(0)" enctype="multipart/form-data">
    <div style="text-align: center; margin-bottom:20px;">
        <h4 style="color:#094267">RESTABLECER CONTREASEÑA </h4>
    </div>
    <label class="single-input-wrap">
        <input type="number" minlength="6" name="code" id="code" value="<?php echo $_GET['otp'] ?>" autocomplete="off" required maxlength="6" placeholder="Código de verificación">
    </label>
    <div class="row">
        <div class="col-6">
            <label class="single-input-wrap">
                <input type="password" name="myPassword" id="myPassword" autocomplete="off" required maxlength="18" placeholder="Contraseña">
            </label>
        </div>
        <div class="col-6">
            <label class="single-input-wrap">
                <input type="password" name="myConfirmPassword" autocomplete="off" id="myConfirmPassword" required maxlength="18"
                    placeholder="confirmar contraseña">
            </label>
        </div>
        <div class="col-12">
            <div id="errors" class="color:red" style="color: red;"></div>
        </div>
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
    <button type="submit" class="btn btn-smart-login text-white">   RESTABLECER </button>
    <div style="text-align: center; margin-top:20px;">
        <span class="mt-2" style="text-align: center;">
            ¿Ya tienes una cuenta?
            <a href="/"><strong class="" style="color: #2196f3;">
                    Acceder
                </strong></a>
            </a>
        </span>
    </div>
</form>
