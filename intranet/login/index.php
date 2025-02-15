<?php
ob_start();
session_start();
require_once 'dbconnect.php';

// it will never let you open index(login) page if session is set
if (isset($_SESSION['user']) != "") {
	header("Location: home.php");
	exit;
}

$error = false;

if (isset($_POST['btn-login'])) {

	// prevent sql injections/ clear user invalid inputs
	$email = trim($_POST['email']);
	$email = strip_tags($email);
	$email = htmlspecialchars($email);

	$pass = trim($_POST['pass']);
	$pass = strip_tags($pass);
	$pass = htmlspecialchars($pass);
	// prevent sql injections / clear user invalid inputs

	if (empty($email)) {
		$error = true;
		$emailError = "Porfavor ingrese su E-mail.";
	} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$error = true;
		$emailError = "Porfavor ingrese su E-mail.";
	}

	if (empty($pass)) {
		$error = true;
		$passError = "Por favor ingrese su clave.";
	}

	// if there's no error, continue to login
	if (!$error) {

		//	$password = hash('sha256', $pass); // password hashing using SHA256
		$password =  md5($pass);
		$res = mysqli_query($conn, "SELECT id_user, fullname, email, usuario, level, passt,id_ubicacion FROM users WHERE email='$email'");
		$row = mysqli_fetch_array($res, MYSQLI_ASSOC);
		$count = mysqli_num_rows($res); // if uname/pass correct it returns must be 1 row

		if ($count == 1 && $row['passt'] == $password) {
			$_SESSION['user_level'] = $row['level'];
			$_SESSION['id'] = $row['id_user'];
			$_SESSION['fullname'] = $row['fullname'];
			$_SESSION['id_ubicacion'] = $row['id_ubicacion'];
			header("Location: ../?/");
		} else {
			$errMSG = "Datos incorectos intente otra vez.";
		}
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
	<link rel="icon" type="image/png" href="../assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>
		Login Administradores
	</title>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
	<!--     Fonts and icons     -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
	<!-- CSS Files -->
	<link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
	<link href="../assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link href="../assets/demo/demo.css" rel="stylesheet" />


	<!--   Core JS Files   -->
	<script src="../assets/js/core/jquery.min.js"></script>
	<script src="../assets/js/core/popper.min.js"></script>
	<script src="../assets/js/core/bootstrap.min.js"></script>
	<script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
	<!-- Chart JS -->
	<script src="../assets/js/plugins/chartjs.min.js"></script>
	<!--  Notifications Plugin    -->
	<script src="../assets/js/plugins/bootstrap-notify.js"></script>
	<!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
	<script src="../assets/js/paper-dashboard.min.js?v=2.0.1" type="text/javascript"></script>
	<!-- Paper Dashboard DEMO methods, don't include it in your project! -->
	<script src="../assets/demo/demo.js"></script>

	<style type="text/css">
		/* WebKit and Opera browsers */
		@-webkit-keyframes spinner {
			from {
				-webkit-transform: rotateY(0deg);
			}

			to {
				-webkit-transform: rotateY(-360deg);
			}
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


		.text-danger {
			color: white;
			font-size: 11px;
			padding: 0px;
		}
	</style>
</head>

<body style="background-color: #115f89;">
	<!-- count particles -->
	<div class="count-particles">

		<div class="content">
			<div class="row">
				<div class="col-md-6 mx-auto">
					<div class="card card-user">
						<div class="card-header">
							<p id="spinner" style=" text-align: center; "><img src="/img/logo.png" style="width: 20%; border-radius: 100%; box-shadow: 0px 2px 2px #313131;"> </p>
							<h5 class="card-title w-100 text-center">Formulario de Inicio de Sesion</h5>
						</div>
						<div class="card-body">
							<div class="row">
								<form class="w-100" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
									<div class="col-md-12">
										<div class="form-group">
											<div id="stage">
											</div>
											<?php
											if (isset($errMSG)) {

											?>
												<div class="form-group">
													<div class="alert alert-danger">
														<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
													</div>
												</div>
											<?php
											}
											?>

											<div class="form-group">
												<div class="input-group">
													<span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
													<input type="email" name="email" class="form-control icon user" onblur="requiredField(this)" placeholder="Direccion de Correo" value="<?php echo $email; ?>" maxlength="40" />
												</div>
												<span class="text-danger"><?php echo $emailError; ?></span>
											</div>
											<div class="form-group">
												<div class="input-group">
													<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
													<input type="password" onblur="requiredField(this)" name="pass" onblur="charCount()" class="form-control icon lock" placeholder="Contraseña" maxlength="15" />
												</div>
												<span class="text-danger"><?php echo $passError; ?></span>
											</div>
											<div class="form-group">
												<input type="submit" name="btn-login" class="btn-success btn w-100" value="Entrar">
											</div>

											<div class="form-group">
												Power by &copy; <a href="https://softluttion.com">Softluttion</a>
											</div>
										</div>
									</div>
								</form>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>



	<!-- stats.js -->

	<script>
		//onblur function
		function requiredField(input) {
			if (input.value.length < 1) {
				//red border
				input.style.borderColor = "#2ecc71";

			} else if (input.type == "email") {
				console.log("this is an email type");

				if (input.value.indexOf("@") != -1 && input.value.indexOf(".") != -1) {
					//green border
					input.style.borderColor = "#2ecc71";

				} else {
					//red border
					input.style.borderColor = "#e74c3c";
				}

			} else {
				//green border
				input.style.borderColor = "#2ecc71";
			}
		}


		//great artical on how to pull the broswer's errors and then display these fields when the end user tries submitting the form https://www.tjvantoll.com/2012/08/05/html5-form-validation-showing-all-error-messages/

		var createAllErrors = function() {
			var form = $(this),
				errorList = $("ul.errorMessages", form);

			var showAllErrorMessages = function() {
				errorList.empty();

				// Find all invalid fields within the form.
				var invalidFields = form.find(":invalid").each(function(index, node) {

					// Find the field's corresponding label
					var label = $("label[for=" + node.id + "] "),
						// Opera incorrectly does not fill the validationMessage property.
						message = node.validationMessage || 'Invalid value.';

					errorList
						.show()
						.append("<li><span>" + label.html() + "</span> " + message + "</li>");
				});
			};

			// Support Safari
			form.on("submit", function(event) {
				if (this.checkValidity && !this.checkValidity()) {
					$(this).find(":invalid").first().focus();
					event.preventDefault();
				}
			});

			$("input[type=submit], button:not([type=button])", form)
				.on("click", showAllErrorMessages);

			$("input", form).on("keypress", function(event) {
				var type = $(this).attr("type");
				if (/date|email|month|number|search|tel|text|time|url|week/.test(type) &&
					event.keyCode == 13) {
					showAllErrorMessages();
				}
			});
		};

		$("form").each(createAllErrors);
	</script>
</body>

</html>
<?php ob_end_flush(); ?>