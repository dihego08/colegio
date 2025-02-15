<?php
class Header{

 function Header(){

 }

 function PrintHeader($data){


$r ='
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>'.$data["title"].'</title>
</head>';
		$r .= '<meta name="viewport" content="width=device-width, initial-scale=1.0" />';
			$baseurl = BASEURL;
	$r .= '<link rel="icon" type="image/png" href="'.$baseurl.'includes/img/icons/favicon.png"/>';

//	$r .= '<LINK href="'.$baseurl.'includes/css/layout.css" type=text/css rel=stylesheet>';
//	$r .= '<LINK href="'.$baseurl.'includes/css/bootstrap.css" type=text/css rel=stylesheet>';
//	$r .= '<LINK href="'.$baseurl.'fonts/css/font-awesome.css" type=text/css rel=stylesheet>';

//css reloj

//			$r .= '<LINK href="'.$baseurl.'includes/css/bootstrap-clockpicker.min.css" type=text/css rel=stylesheet>';


//	$r .= '<script type="text/javascript" src="'.$baseurl.'includes/js/java.js"></script>';

		//ui
//	$r .= '<LINK href="'.$baseurl.'includes/css/ui/jquery.ui.all.css" type=text/css rel=stylesheet>';
//	$r .= '<LINK href="'.$baseurl.'includes/css/ui/demos.css" type=text/css rel=stylesheet>';
//	$r .= '<script type="text/javascript" src="'.$baseurl.'includes/js/ui/jquery.ui.core.js"></script>';
//	$r .= '<script type="text/javascript" src="'.$baseurl.'includes/js/ui/jquery.ui.widget.js"></script>';

		//prompt dialog
//	$r .= '<LINK href="'.$baseurl.'includes/css/prompt_dialog/examples.css" type=text/css rel=stylesheet>';
//	$r .= '<script type="text/javascript" src="'.$baseurl.'includes/js/dialog_prompt/jquery-impromptu.3.1.min.js"></script>';

		//datepicker
//	$r .= '<script type="text/javascript" src="'.$baseurl.'includes/js/ui/jquery.ui.datepicker.js"></script>';
//	$r .= '<script type="text/javascript" src="'.$baseurl.'includes/js/bootstrap.js"></script>';


//reloj

//	$r .= '<script type="text/javascript" src="'.$baseurl.'includes/js/datep.js"></script>';
//	$r .= '<script type="text/javascript" src="'.$baseurl.'includes/js/dtp2.js"></script>';




		//icons
//	$r .= '<LINK href="'.$baseurl.'includes/css/ui/icons.css" type=text/css rel=stylesheet>';

			//menu
//			$r .= '<script type="text/javascript" src="'.$baseurl.'includes/js/menu/jquery.metadata.js"></script>';
//			$r .= '<script type="text/javascript" src="'.$baseurl.'includes/js/menu/jquery.hoverIntent.js"></script>';
//			$r .= '<script type="text/javascript" src="'.$baseurl.'includes/js/menu/mbMenu.js"></script>';
//			$r .= '<LINK href="'.$baseurl.'includes/css/menu/menu_black.css" type=text/css rel=stylesheet>';

	//select
//	$r .= '<script type="text/javascript" src="'.$baseurl.'includes/js/select/customSelect.jquery.js"></script>';
	//colorbox
//	$r .= '<script type="text/javascript" src="'.$baseurl.'includes/js/colorbox/jquery.colorbox-min.js"></script>';
//	$r .= '<LINK href="'.$baseurl.'includes/css/colorbox/colorbox.css" type=text/css rel=stylesheet>';


		/*	$r .= '<script type="text/javascript">';

			$r .= 'function showLoading(){$(".loading").css("display","inline");}';
			$r .= 'function hideLoading(){$(".loading").css("display","none");}';

			$r .= '$(function(){';

			$r .= '$(".myMenu").buildMenu(';
			$r .= '{';
			  $r .= 'template:"menuVoices.html",';
			  $r .= 'additionalData:"pippo=1",';
			  $r .= 'menuWidth:200,';
			  $r .= 'openOnRight:false,';
			  $r .= 'menuSelector: ".menuContainer",';
			  $r .= 'iconPath:"'.$baseurl.'includes/css/ico/",';
			  $r .= 'hasImages:true,';
			  $r .= 'fadeInTime:100,';
			  $r .= 'fadeOutTime:300,';
			  $r .= 'adjustLeft:2,';
			  $r .= 'minZindex:"auto",';
			  $r .= 'adjustTop:10,';
			  $r .= 'opacity:.95,';
			  $r .= 'shadow:false,';
			  $r .= 'shadowColor:"#ccc",';
			  $r .= 'hoverIntent:0,';
			  $r .= 'openOnClick:false,';
			  $r .= 'closeOnMouseOut:true,';
			  $r .= 'closeAfter:500,';
			  $r .= 'submenuHoverIntent:200';
			$r .= '});';

			$r .= '$(".vertMenu").buildMenu(';
			$r .= '{';
			  $r .= 'template:"menuVoices.html",';
			  $r .= 'menuWidth:170,';
			  $r .= 'openOnRight:true,';
			  $r .= 'menuSelector: ".menuContainer",';
			  $r .= 'iconPath:"'.$baseurl.'includes/css/ico/",';
			  $r .= 'hasImages:true,';
			  $r .= 'fadeInTime:200,';
			  $r .= 'fadeOutTime:200,';
			  $r .= 'adjustLeft:0,';
			  $r .= 'adjustTop:0,';
			  $r .= 'opacity:.95,';
			  $r .= 'openOnClick:false,';
			  $r .= 'minZindex:200,';
			  $r .= 'shadow:false,';
			  $r .= 'hoverIntent:300,';
			  $r .= 'submenuHoverIntent:300,';
			  $r .= 'closeOnMouseOut:true';
		   $r .= ' });';

			$r .= '$(document).buildContextualMenu(';
		   $r .= ' {';
			  $r .= 'template:"menuVoices.html",';
			  $r .= 'menuWidth:200,';
			  $r .= 'overflow:2,';
			  $r .= 'menuSelector: ".menuContainer",';
			  $r .= 'iconPath:"'.$baseurl.'includes/css/ico/",';
			  $r .= 'hasImages:false,';
			  $r .= 'fadeInTime:100,';
			  $r .= 'fadeOutTime:100,';
			  $r .= 'adjustLeft:0,';
			  $r .= 'adjustTop:0,';
			  $r .= 'opacity:.99,';
			  $r .= 'closeOnMouseOut:false,';
			  $r .= 'onContextualMenu:function(o,e){},';
			  $r .= 'shadow:false';
			$r .= '});';
		  $r .= '});';



		$r .= '</script>';
		*/
		$r .= '</head>';
		$r .= '<body>';


	$r .= '<div id="" style="text-align:center; position:relative; border-top: 3px solid green;"> ';
$r .= '<img src="'.$baseurl.'includes/img/logo.jpg" width="175" />';
  	$r .= '</div>';





				$r .= '<table  border="0" cellpadding="0" cellspacing="0"  class="container table">';
				  $r .= '<tr>';
					$r .= '<td class="myMenu">';
					$r .= '<table class="rootVoices" cellspacing=\'0\' cellpadding=\'0\' border=\'0\'><tr>';

						$r .= '<td align="center" class="rootVoice {menu: \'empty\'}" onclick="location.href = \''.$baseurl.'\'">Home</td>';


						if(!isset($_SESSION['user_level']))

						{
							$r .= '<td align="center" class="rootVoice {menu: \'intranet\'}" >Intranet</td>';
						}




						if(isset($_SESSION['user_level']) && $_SESSION['user_level'] == "5")
						{
							$r .= '<td align="center" class="rootVoice {menu: \'administrar\'}" >Control</td>';
					//		 $r .= '<td align="center" class="rootVoice {menu: \'servicios\'}" >Servicios</td>';


						//$r .= '<td align="center" class="rootVoice {menu: \'empty\'}" onclick="location.href = \''.$baseurl.INDEX.'habitaciones\'">Habitaciones</td>';

							$r .= '<td align="center" class="rootVoice {menu: \'empty\'}" onclick="location.href = \''.$baseurl.INDEX.'ventas\'">Creditos</td>';
							//$r .= '<td align="center" class="rootVoice {menu: \'empty\'}" onclick="location.href = \''.$baseurl.INDEX.'reservas\'">Reservas</td>';
							//$r .= '<td align="center" class="rootVoice {menu: \'empty\'}" onclick="location.href = \''.$baseurl.INDEX.'facturacion\'">Facturacion</td>';
						//	$r .= '<td align="center" class="rootVoice {menu: \'empty\'}" onclick="location.href = \'\\cocina\'">Cocina</td>';

					//	$r .= '<td align="center" class="rootVoice {menu: \'empty\'}" onclick="location.href = \'\\mozo\'">Mozo</td>';
					//		$r .= '<td align="center" class="rootVoice {menu: \'empty\'}" onclick="location.href = \''.$baseurl.INDEX.'llantas\'">Llantas</td>';
					//		$r .= '<td align="center" class="rootVoice {menu: \'camioneta\'}">Camioneta</td>';
							$r .= '<td align="center" class="rootVoice {menu: \'configuracion\'}" >Configuraci&oacute;n</td>';
							$r .= '<td align="center" class="rootVoice {menu: \'cuenta\'}" >Cuenta</td>';
							$r .= '<td align="center" class="rootVoice {menu: \'web\'}" >Web</td>';
						}






						if(isset($_SESSION['user_level']) && $_SESSION['user_level'] == "3")
						{
							$r .= '<td align="center" class="rootVoice {menu: \'administrar\'}" >Control</td>';
					//		 $r .= '<td align="center" class="rootVoice {menu: \'servicios\'}" >Servicios</td>';


						//$r .= '<td align="center" class="rootVoice {menu: \'empty\'}" onclick="location.href = \''.$baseurl.INDEX.'habitaciones\'">Habitaciones</td>';

							$r .= '<td align="center" class="rootVoice {menu: \'empty\'}" onclick="location.href = \''.$baseurl.INDEX.'ventas\'">Creditos</td>';

							//$r .= '<td align="center" class="rootVoice {menu: \'empty\'}" onclick="location.href = \''.$baseurl.INDEX.'reservas\'">Reservas</td>';
							//$r .= '<td align="center" class="rootVoice {menu: \'empty\'}" onclick="location.href = \''.$baseurl.INDEX.'facturacion\'">Facturacion</td>';
						//	$r .= '<td align="center" class="rootVoice {menu: \'empty\'}" onclick="location.href = \'\\cocina\'">Cocina</td>';

					//	$r .= '<td align="center" class="rootVoice {menu: \'empty\'}" onclick="location.href = \'\\mozo\'">Mozo</td>';
					//		$r .= '<td align="center" class="rootVoice {menu: \'empty\'}" onclick="location.href = \''.$baseurl.INDEX.'llantas\'">Llantas</td>';
					//		$r .= '<td align="center" class="rootVoice {menu: \'camioneta\'}">Camioneta</td>';
						//	$r .= '<td align="center" class="rootVoice {menu: \'configuracion\'}" >Configuraci&oacute;n</td>';
							$r .= '<td align="center" class="rootVoice {menu: \'cuenta\'}" >Cuenta</td>';
							//$r .= '<td align="center" class="rootVoice {menu: \'web\'}" >Web</td>';
						}




	if(isset($_SESSION['user_level']) && $_SESSION['user_level'] == "1")
						{
						//	$r .= '<td align="center" class="rootVoice {menu: \'administrar\'}" >Control</td>';


								//
						//$r .= '<td align="center" class="rootVoice {menu: \'empty\'}" onclick="location.href = \''.$baseurl.INDEX.'habitaciones\'">Habitaciones</td>';

							// $r .= '<td align="center" class="rootVoice {menu: \'empty\'}" onclick="location.href = \''.$baseurl.INDEX.'ventas\'">Ventas</td>';
							// $r .= '<td align="center" class="rootVoice {menu: \'empty\'}" onclick="location.href = \''.$baseurl.INDEX.'clientes\'">Clientes</td>';
							$r .= '<td align="center" class="rootVoice {menu: \'empty\'}" onclick="location.href = \''.$baseurl.INDEX.'hcredit\'">Creditos</td>';
							//$r .= '<td align="center" class="rootVoice {menu: \'empty\'}" onclick="location.href = \''.$baseurl.INDEX.'facturacion\'">Facturacion</td>';
						//	$r .= '<td align="center" class="rootVoice {menu: \'empty\'}" onclick="location.href = \'\\cocina\'">Cocina</td>';


					//		$r .= '<td align="center" class="rootVoice {menu: \'empty\'}" onclick="location.href = \''.$baseurl.INDEX.'llantas\'">Llantas</td>';
					//		$r .= '<td align="center" class="rootVoice {menu: \'camioneta\'}">Camioneta</td>';
						//	$r .= '<td align="center" class="rootVoice {menu: \'configuracion\'}" >Configuraci&oacute;n</td>';
							$r .= '<td align="center" class="rootVoice {menu: \'cuenta\'}" >Cuenta</td>';
						}


					  $r .= '</tr></table>';















		if(isset($_SESSION['user_level']))
		{
			$r .= "<div id=\"cuenta\" class=\"mbmenu\">";
			//	$r .= "<a href=\"".$baseurl.INDEX."common/myaccount\" class=\"{img: '24-book-blue-check.png'}\">Mi Cuenta</a>";
				$r .= "<a href=\"".$baseurl.INDEX."home/logout\" class=\"{img: '24-book-blue-check.png'}\">Cerrar Sesi&oacute;n</a>";
			$r .= "</div>";


			$r .= "<div id=\"web\" class=\"mbmenu\">";
			//	$r .= "<a href=\"".$baseurl.INDEX."common/myaccount\" class=\"{img: '24-book-blue-check.png'}\">Mi Cuenta</a>";
				$r .= "<a href=\"".$baseurl.INDEX."home/logout\" class=\"{img: '24-book-blue-check.png'}\">Cerrar Sesi&oacute;n</a>";
			$r .= "</div>";
		}

			$r .= "<div id=\"intranet\" class=\"mbmenu\">";
				$r .= "<a href=\"".$baseurl.INDEX."home/login\" class=\"{img: '24-book-blue-check.png'}\">Iniciar Sesi&oacute;n</a>";
			$r .= "</div>";

			if(isset($_SESSION['user_level']) && $_SESSION['user_level'] == "5")
			{
				$r .= "<div id=\"administrar\" class=\"mbmenu\">";

					$r .= "<a href=\"".$baseurl.INDEX."empleados\" class=\"{img: '24-book-blue-check.png'}\">Empleados</a>";
					//$r .= "<a href=\"".$baseurl.INDEX."habitaciones\" class=\"{img: '24-book-blue-check.png'}\">Habitaciones</a>";
					$r .= "<a href=\"".$baseurl.INDEX."ventas\" class=\"{img: '24-book-blue-check.png'}\">Creditos </a>";
					$r .= "<a href=\"".$baseurl.INDEX."hcredit\" class=\"{img: '24-book-blue-check.png'}\">Historial Crediticio</a>";
					$r .= "<a href=\"".$baseurl.INDEX."hcreditfin\" class=\"{img: '24-book-blue-check.png'}\"> Creditos finalizados</a>";


					$r .= "<a href=\"".$baseurl.INDEX."depositos\" class=\"{img: '24-book-blue-check.png'}\">Depositos</a>";
	$r .= "<a href=\"".$baseurl.INDEX."depositosf\" class=\"{img: '24-book-blue-check.png'}\"> Depositos finalizados</a>";
  	$r .= "<a href=\"".$baseurl.INDEX."hdepositos\" class=\"{img: '24-book-blue-check.png'}\">Retiros realizados</a>";
					//$r .= "<a href=\"".$baseurl.INDEX."habitaciones\" class=\"{img: '24-book-blue-check.png'}\">Habitaciones</a>";
	//$r .= "<a href=\"".$baseurl.INDEX."postpago\" class=\"{img: '24-book-blue-check.png'}\">Postpago</a>";
			//	$r .= "<a href=\"".$baseurl.INDEX."compras\" class=\"{img: '24-book-blue-check.png'}\">Compras</a>";
			//		$r .= "<a href=\"".$baseurl.INDEX."servicios\" class=\"{img: '24-book-blue-check.png'}\">Servicios</a>";

					//$r .= "<a href=\"".$baseurl.INDEX."stock\" class=\"{img: '24-book-blue-check.png'}\">Kardex</a>";

                    $r .= "<a href=\"".$baseurl.INDEX."clientes\" class=\"{img: '24-book-blue-check.png'}\">Clientes</a>";
				//$r .= "<a href=\"".$baseurl.INDEX."usuarios\" class=\"{img: '24-book-blue-check.png'}\">Usuarios</a>";
				$r .= "<a href=\"".$baseurl.INDEX."costo_servicio\" class=\"{img: '24-book-blue-check.png'}\">Stock</a>";
			//	$r .= "<a href=\"".$baseurl.INDEX."almacen\" class=\"{img: '24-book-blue-check.png'}\">Almacen</a>";
			//	$r .= "<a href=\"".$baseurl.INDEX."ingreso\" class=\"{img: '24-book-blue-check.png'}\">Ingreso</a>";

				//AGREGUE MOSOS AL MENU---
				//$r .= "<a href=\"".$baseurl.INDEX."mosos\" class=\"{img: '24-book-blue-check.png'}\">Mosos</a>";




			  $r .= "</div>";

			  $r .= "<div id=\"configuracion\" class=\"mbmenu\">";
					$r .= "<a href=\"".$baseurl.INDEX."costo_servicio\" class=\"{img: '24-book-blue-check.png'}\">Fondo Capital </a>";
					$r .= "<a href=\"".$baseurl.INDEX."costo_servicio/valores\" class=\"{img: '24-book-blue-check.png'}\">Valores por Defecto</a>";
				//	$r .= "<a href=\"".$baseurl.INDEX."costo_servicio/equip\" class=\"{img: '24-book-blue-check.png'}\">Equipamiento</a>";
			  $r .= "</div>";
			}


			if(isset($_SESSION['user_level']) && $_SESSION['user_level'] == "3")
			{
				$r .= "<div id=\"administrar\" class=\"mbmenu\">";

					//$r .= "<a href=\"".$baseurl.INDEX."empleados\" class=\"{img: '24-book-blue-check.png'}\">Empleados</a>";
					//$r .= "<a href=\"".$baseurl.INDEX."habitaciones\" class=\"{img: '24-book-blue-check.png'}\">Habitaciones</a>";
					$r .= "<a href=\"".$baseurl.INDEX."ventas\" class=\"{img: '24-book-blue-check.png'}\">Creditos </a>";
				//	$r .= "<a href=\"".$baseurl.INDEX."hcredit\" class=\"{img: '24-book-blue-check.png'}\">Historial Crediticio</a>";
				//	$r .= "<a href=\"".$baseurl.INDEX."hcreditfin\" class=\"{img: '24-book-blue-check.png'}\"> Creditos finalizados</a>";


					$r .= "<a href=\"".$baseurl.INDEX."depositos\" class=\"{img: '24-book-blue-check.png'}\">Depositos</a>";
						$r .= "<a href=\"".$baseurl.INDEX."depositosf\" class=\"{img: '24-book-blue-check.png'}\">Depositos Finalizados</a>";

            	$r .= "<a href=\"".$baseurl.INDEX."hdepositos\" class=\"{img: '24-book-blue-check.png'}\">Retiros realizados</a>";

					//$r .= "<a href=\"".$baseurl.INDEX."habitaciones\" class=\"{img: '24-book-blue-check.png'}\">Habitaciones</a>";
	//$r .= "<a href=\"".$baseurl.INDEX."postpago\" class=\"{img: '24-book-blue-check.png'}\">Postpago</a>";
			//	$r .= "<a href=\"".$baseurl.INDEX."compras\" class=\"{img: '24-book-blue-check.png'}\">Compras</a>";
			//		$r .= "<a href=\"".$baseurl.INDEX."servicios\" class=\"{img: '24-book-blue-check.png'}\">Servicios</a>";

					//$r .= "<a href=\"".$baseurl.INDEX."stock\" class=\"{img: '24-book-blue-check.png'}\">Kardex</a>";

                   // $r .= "<a href=\"".$baseurl.INDEX."clientes\" class=\"{img: '24-book-blue-check.png'}\">Clientes</a>";
				//$r .= "<a href=\"".$baseurl.INDEX."usuarios\" class=\"{img: '24-book-blue-check.png'}\">Usuarios</a>";
			//	$r .= "<a href=\"".$baseurl.INDEX."costo_servicio\" class=\"{img: '24-book-blue-check.png'}\">Stock</a>";
			//	$r .= "<a href=\"".$baseurl.INDEX."almacen\" class=\"{img: '24-book-blue-check.png'}\">Almacen</a>";
			//	$r .= "<a href=\"".$baseurl.INDEX."ingreso\" class=\"{img: '24-book-blue-check.png'}\">Ingreso</a>";

				//AGREGUE MOSOS AL MENU---
				//$r .= "<a href=\"".$baseurl.INDEX."mosos\" class=\"{img: '24-book-blue-check.png'}\">Mosos</a>";




			  $r .= "</div>";

			  $r .= "<div id=\"configuracion\" class=\"mbmenu\">";
					$r .= "<a href=\"".$baseurl.INDEX."costo_servicio\" class=\"{img: '24-book-blue-check.png'}\">Art&iacute;culos</a>";
					$r .= "<a href=\"".$baseurl.INDEX."costo_servicio/valores\" class=\"{img: '24-book-blue-check.png'}\">Valores por Defecto</a>";
				//	$r .= "<a href=\"".$baseurl.INDEX."costo_servicio/equip\" class=\"{img: '24-book-blue-check.png'}\">Equipamiento</a>";
			  $r .= "</div>";




			  $r .= "<div id=\"configuracion\" class=\"mbmenu\">";
					$r .= "<a href=\"".$baseurl.INDEX."costo_servicio\" class=\"{img: '24-book-blue-check.png'}\">Art&iacute;culos</a>";

						if(isset($_SESSION['user_level']) && $_SESSION['user_level'] == "5")
			{
					$r .= "<a href=\"".$baseurl.INDEX."costo_servicio/valores\" class=\"{img: '24-book-blue-check.png'}\">Valores por Defecto</a>";


			}
				//	$r .= "<a href=\"".$baseurl.INDEX."costo_servicio/equip\" class=\"{img: '24-book-blue-check.png'}\">Equipamiento</a>";
			  $r .= "</div>";
			}


			if(isset($_SESSION['user_level']) && $_SESSION['user_level'] == "5")
			{
				$r .= "<div id=\"servicios\" class=\"mbmenu\">";
				//	$r .= "<a href=\"".$baseurl.INDEX."servicios\" class=\"{img: '24-book-blue-check.png'}\">Ver Servicios</a>";
				//	 $r .= "<a href=\"".$baseurl.INDEX."servicios/cambio_aceite\" class=\"{img: '24-book-blue-check.png'}\">Cambio de Aceite</a>";
				//	 $r .= "<a href=\"".$baseurl.INDEX."servicios/filtros\" class=\"{img: '24-book-blue-check.png'}\">Filtros</a>";
				//	 $r .= "<a href=\"".$baseurl.INDEX."servicios/frenos\" class=\"{img: '24-book-blue-check.png'}\">Frenos</a>";
				//	 $r .= "<a href=\"".$baseurl.INDEX."servicios/sespension\" class=\"{img: '24-book-blue-check.png'}\">Suspensi&oacute;n</a>";


			  $r .= "</div>";
			}
			if(isset($_SESSION['user_level']) && $_SESSION['user_level'] == "5")
			{
				$r .= "<div id=\"llantas\" class=\"mbmenu\">";
					$r .= "<a href=\"".$baseurl.INDEX."llantas/cambios\" class=\"{img: '24-book-blue-check.png'}\">Cambios</a>";
					$r .= "<a href=\"".$baseurl.INDEX."llantas/ingresos\" class=\"{img: '24-book-blue-check.png'}\">Ingresos</a>";
					$r .= "<a href=\"".$baseurl.INDEX."llantas/placas\" class=\"{img: '24-book-blue-check.png'}\">Placas</a>";
				$r .= "</div>";

				$r .= "<div id=\"camioneta\" class=\"mbmenu\">";
					$r .= "<a href=\"".$baseurl.INDEX."camioneta\" class=\"{img: '24-book-blue-check.png'}\">Camionetas</a>";
					$r .= "<a href=\"".$baseurl.INDEX."camioneta/inventarios\" class=\"{img: '24-book-blue-check.png'}\">Inventarios</a>";
			$r .= "</div>";
			}



		  echo $r;
		  }

	  }

?>
