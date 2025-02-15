<?php
define('DB_SERVER','localhost');
define('DB_USER','root');
define('DB_PASS' ,'password');
define('DB_NAME', 'sisfinancial');

class DB_con
{
	function __construct()
	{
		$conn = mysql_connect(DB_SERVER,DB_USER,DB_PASS) or die('localhost connection problem'.mysql_error());
		mysql_select_db(DB_NAME, $conn);
	}
	
	public function insert($titulo,$texto,$fecha)
	{
		$res = mysql_query("INSERT paginas(titulo, texto, fecha) VALUES('$titulo','$texto','$fecha')");
		return $res;
	}
	
	public function select()
	{
		$res=mysql_query("SELECT * FROM paginas");
		return $res;
	}
}

$con = new DB_con();

// data insert code starts here.
if(isset($_POST['btn-save']))
{
	$titulo = $_POST['titulo'];
	$texto = $_POST['texto'];
	$fecha = $_POST['fecha'];
	
	$res=$con->insert($titulo,$texto,$fecha);
	if($res)
	{
		?>
		<script>
		alert('Record inserted...');
        window.location='index.php'
        </script>
		<?php
	}
	else
	{
		?>
		<script>
		alert('error inserting record...');
        window.location='index.php'
        </script>
		<?php
	}
}
// data insert code ends here.

?>

<!DOCTYPE HTML>
<html>
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script src="editor.js"></script>
		<script>
			$(document).ready(function() {
				$("#txtEditor").Editor();
			});
		</script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<link href="editor.css" type="text/css" rel="stylesheet"/>
	
	</head>
	<body>
		<div class="container-fluid">
			<div class="row">
				<h2 class="demo-text">Nueva Web</h2>
				<div class="container">
					<div class="row">
						<div class="col-lg-12 nopadding">
							<form method="post">
<input type="text" name="titulo"><br>
<input type="text" name="fecha"><br>

							<textarea name="texto" id="txtEditor"></textarea> 
<br>
    <button type="submit" name="btn-save"><strong>SAVE</strong></button></td></form>

						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container-fluid footer">
			<p class="pull-right">&copy;  <script>document.write(new Date().getFullYear())</script>. All rights reserved.</p>
		</div>
	</body>
</html>
