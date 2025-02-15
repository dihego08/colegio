<!DOCTYPE html>
<html>

<head>
    <meta charset="gb18030">

    <title>Inicio de Sesión</title>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!--Custom styles-->
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <!--Made with love by Mutiullah Samim -->

    <!--Bootsrap 4 CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!--Fontawesome CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>
    <style>
        .ho:hover {
            color: #FFC312;
        }

        #myVideo {
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%;
            min-height: 100%;
            /*width: 100%;*/
        }
    </style>
</head>

<body>
    <video autoplay muted loop id="myVideo">
        <source src="https://adiasis.com/cursos_online_web_v3/img/fondo-ingreso-animado.mp4" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>

    <div class="container">
        <div class="d-flex justify-content-center h-100">
            <div class="card box" style="">
                <div class="card-header">
                    <h3 style="text-align: center;" class="mt-3">Iniciar Sesión Alumnos</h3>
                    <?php
                    if (isset($_GET['cod'])) {
                        if ($_GET['cod'] == 1) {
                            echo '<small style="width: 100%; color: #ffc312; text-align: center; display: block;">Contraseña Reestablecida, Inicia Sesion con tu nueva contraseña</small>';
                        }
                    } else {
                    }
                    ?>
                </div>
                <div class="card-body">
                    <div class="input-group form-group" style="width: 90%; margin-left: auto; margin-right: auto;">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Usuario" id="user">

                    </div>
                    <div class="input-group form-group" style="width: 90%; margin-left: auto; margin-right: auto;">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="password" class="form-control" placeholder="Contraseña" id="pass">
                    </div>
                    <div class="form-group mt-5" style="text-align: center; margin-bottom: 0;">
                        <span class="btn login_btn" id="btn_iniciar">Iniciar Sesión</span>
                    </div>
                    <!--<div class="d-flex justify-content-center links mt-3">
					<a href="o_contrasena.php" class="ho" data-original-title="Olvide mi Contraseña">Olvide mi Contraseña</a>
				</div>-->
                </div>
                <div class="card-footer">

                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#btn_iniciar").on("click", function() {
                $.post('../iniciar_sesion_al.php', {
                    usuario: $("#user").val(),
                    pass: $("#pass").val()
                }, function(response) {
                    var obj = JSON.parse(response);
                    if (obj.Result == "OK") {
                        window.parent.$('#formulario').modal('hide');
                        window.parent.location.href = "../plataforma/";
                    } else {
                        if (obj.Code == "DB+1") {
                            bootbox.confirm({
                                title: "Deuda Pendiente",
                                message: obj.Message,
                                buttons: {
                                    confirm: {
                                        label: 'Realizar Pago',
                                        className: 'btn-success'
                                    },
                                    cancel: {
                                        label: 'Cancelar',
                                        className: 'btn-danger'
                                    }
                                },
                                callback: function(result) {
                                    if (result) {
                                        window.parent.$('#formulario').modal('hide');
                                        window.parent.location.href = "../pay?User_id="+obj.User_id
                                    } else {}
                                }
                            });
                        } else {
                            bootbox.alert({
                                title: "Alerta",
                                message: '<div class="alert alert-danger" style="margin-top: 5%; margin-bottom: 0;">' +
                                    '<strong>' + obj.Message + '</strong>' +
                                    '</div>'
                            });
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>