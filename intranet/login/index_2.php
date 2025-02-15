<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
	<title>Inicio de Sesión</title>
	<link rel="stylesheet" type="text/css" href="https://adiasis.com/libros_veloz/web_view/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://adiasis.com/libros_veloz/web_view/css/bootstrap-theme.min.css">
	<script type="text/javascript" src="https://adiasis.com/libros_veloz/web_view/js/jquery.min.js"></script>
	<script type="text/javascript" src="https://adiasis.com/libros_veloz/web_view/js/bootstrap.min.js"></script>
	<style>
	    body{
	        background: #012356;
	    }
	    /* WebKit and Opera browsers */
        @-webkit-keyframes spinner {
            from { -webkit-transform: rotateY(0deg);    }
            to   { -webkit-transform: rotateY(-360deg); }
        }
        /* all other browsers */
        @keyframes spinner {
            from {
                -moz-transform: rotateY(0deg);
                -ms-transform: rotateY(0deg);
                transform: rotateY(0deg);
            }
            to {
                -moz-transform: rotateY(-360deg);
                -ms-transform: rotateY(-360deg);
                transform: rotateY(-360deg);
            }
        }
        #spinner {
            -webkit-animation-name: spinner;
            -webkit-animation-timing-function: linear;
            -webkit-animation-iteration-count: infinite;
            -webkit-animation-duration: 6s;
            animation-name: spinner;
            animation-timing-function: linear;
            animation-iteration-count: infinite;
            animation-duration: 6s;
            -webkit-transform-style: preserve-3d;
            -moz-transform-style: preserve-3d;
            -ms-transform-style: preserve-3d;
            transform-style: preserve-3d;
        }
        #spinner:hover {
            -webkit-animation-play-state: paused;
            animation-play-state: paused;
        }
	</style>
</head>
<body>
	<div class="container">
		<div class="form-row" style="margin-top: 2%;">
		    <div class="col-md-12">
		        <p id="spinner" style=" text-align: center; "><img src="login2/logo.png" <="" p="">
                </p>
		    </div>
			<div class="col-md-5" style="border-radius: 8px; border: solid 1px white; padding: 10px; background: #333;">
			    <h2 style="margin-bottom: 30px; color: white; text-align: center;">Formulario de Inicio de Sesión Profesores</h2>
				<div class="col-md-12">
			        <label style="color: white; font-weight: bold;">Usuario</label>
			        <input type="text" class="form-control" id="user_profesor" name="user_profesor">
			    </div>
			    <div class="col-md-12" style="margin-top: 15px;">
			        <label style="color: white; font-weight: bold;">Contraseña</label>
			        <input type="password" class="form-control" id="pass_profesor" name="pass_profesor">
			    </div>
				<div class="col-md-12 mt-2">
				    <span style="margin-top: 20px;" class="btn btn-success pull-right">Iniciar Sesión</span>
				</div>
			</div>
			<div class="col-md-2"></div>
			<div class="col-md-5" style="border-radius: 8px; border: solid 1px white; padding: 10px; background: #333;">
			    <h2 style="margin-bottom: 30px; color: white; text-align: center;">Formulario de Inicio de Sesión Alumnos</h2>
			    <div class="col-md-12">
			        <label style="color: white; font-weight: bold;">Usuario</label>
			        <input type="text" class="form-control" id="user_alumno" name="user_alumno">
			    </div>
			    <div class="col-md-12" style="margin-top: 15px;">
			        <label style="color: white; font-weight: bold;">Contraseña</label>
			        <input type="password" class="form-control" id="pass_alumno" name="pass_alumno">
			    </div>
				<div class="col-md-12 mt-2">
				    <span style="margin-top: 20px;" class="btn btn-success pull-right">Iniciar Sesión</span>
				</div>
			</div>
			<div class="col-md-12" style="margin-top: 10%;">
			    <p style="text-align: center; color: white;">Power by © Adiasoft Corporation </p>
			</div>
		</div>
	</div>
</body>
</html>