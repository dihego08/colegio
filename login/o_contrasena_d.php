<!DOCTYPE html>
<html>
<head><meta charset="gb18030">
    
	<title>Reestablecer contraseña</title>
	<script src="../js/jquery-3.2.1.min.js"></script>
	<!--Custom styles-->
	<link rel="stylesheet" type="text/css" href="styles.css">
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <!--<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
   <!--Made with love by Mutiullah Samim -->
   
	<!--Bootsrap 4 CDN-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
    <!--Fontawesome CDN-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>

	<style>
        .ho:hover{
            color: #FFC312;
        }
    </style>
    
</head>
<body>
<div class="container">
	<div class="d-flex justify-content-center h-100">
		<div class="card">
			<div class="card-header">
				<h3 style="text-align: center;" class="mt-3">Iniciar Sesión</h3>
				<div class="d-flex justify-content-end social_icon">
					<!--<span><i class="fab fa-facebook-square"></i></span>
					<span><i class="fab fa-google-plus-square"></i></span>
					<span><i class="fab fa-twitter-square"></i></span>-->
				</div>
			</div>
			<div class="card-body">
				<div id="div_uno">
				    <div class="input-group form-group" style="">
    				    <label class="w-100 white">Correo Electronico</label>
    					<div class="input-group-prepend">
    						<span class="input-group-text"><i class="fas fa-user"></i></span>
    					</div>
    					<input type="text" class="form-control" placeholder="Correo Electronico" id="correo">
    				</div>
    				<div class="input-group form-group" style="">
    				    <label class="w-100 white">Usuario de Inicio de Sesion</label>
    					<div class="input-group-prepend">
    						<span class="input-group-text">@</span>
    					</div>
    					<input type="text" class="form-control" placeholder="Usuario de Inicio de Sesion" id="user">
    				</div>
    				<div class="d-flex justify-content-center mt-3">
    					<span onclick="siguiente();" class="btn login_btn btn-sm">Siguiente</span>
    				</div>
				</div>
				<div id="div_dos" hidden>
				    <div class="input-group form-group" style="width: 90%; margin-left: auto; margin-right: auto;">
				        <label class="w-100 white">Nueva Contraseña</label>
    					<div class="input-group-prepend">
    						<span class="input-group-text"><i class="fas fa-key"></i></span>
    					</div>
    					<input type="password" class="form-control" placeholder="Nueva Contraseña" id="pass">
    				</div>
    				<div class="input-group form-group" style="width: 90%; margin-left: auto; margin-right: auto;">
				        <label class="w-100 white">Repetir Contraseña</label>
    					<div class="input-group-prepend">
    						<span class="input-group-text"><i class="fas fa-key"></i></span>
    					</div>
    					<input type="password" class="form-control" placeholder="Repetir Contraseña" id="pass_2">
    				</div>
    				<div class="d-flex justify-content-center mt-3">
    					<span onclick="reestablecer();" class="btn login_btn btn-sm">Reestablecer Contraseña</span>
    				</div>
				</div>
				
				<div id="mensaje" hidden class="mt-2">
				    
				</div>
				
				<div class="d-flex justify-content-center links mt-3">
					<a href="../registro-alumno.php" class="ho" data-original-title="Crear una Cuenta">Crear Cuenta</a>
				</div>
				<div class="d-flex justify-content-center mt-3">
					<a href="../" class="btn login_btn btn-sm">Regresar el Inicio</a>
				</div>
			</div>
			<div class="card-footer">
			    <!--<div class="d-flex justify-content-center links mt-2">
					<a href="#">Crear Cuenta</a>
				</div>
				<div class="d-flex justify-content-center">
					<a href="https://adiasis.com/cursos_online_web/" class="btn login_btn btn-sm">Regresar el Inicio</a>
				</div>-->
			</div>
		</div>
	</div>
</div>
    <script type="text/javascript">
        function siguiente(){
            var usuario = $("#user").val();
            var correo = $("#correo").val();
            $.post("reestablecer.php?accion=siguiente_d", {
                usuario: usuario,
                correo: correo
            }, function(response){
                var obj = JSON.parse(response);
                if(obj.Result == "OK"){
                    id_usuario = obj.id;
                    $("#div_uno").attr("hidden", true);
                    $("#div_dos").removeAttr("hidden");
                }else{
                    $("#mensaje").removeAttr("hidden");
                    $("#mensaje").append(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> Ningun usuario coincide con los datos ingresados.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>`);
                }
            });
        }
        function reestablecer(){
            var pass = $("#pass").val();
            var pass_2 = $("#pass_2").val();
            if(pass != pass_2 || pass == "" || pass_2 == ""){
                $("#mensaje").removeAttr("hidden");
                $("#mensaje").append(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Las contraseñas no coinciden o estan vacias.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>`);
            }else{
                $.post("reestablecer.php?accion=reestablecer_d", {
                    id_usuario: id_usuario,
                    pass: pass
                }, function(response){
                    var obj = JSON.parse(response);
                    if(obj.Result == "OK"){
                        location.href = "login_a.php?cod=1";
                    }else{
                        $("#mensaje").removeAttr("hidden");
                        $("#mensaje").append(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> Algo ha salido mal, contacte al administrador.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>`);
                    }
                });
            }
            
        }
    </script>
</body>
</html>