<?php
class html_clientes extends f{
	private $baseurl = "";
	function html_clientes(){

		$this->load()->lib_html("Table", false);

		$this->baseurl = BASEURL;
	}

	function containerUsers(){
    $r='
                    <a class="btn btn-sm btn_personalizado" href="' . $this->baseurl . INDEX . 'clientes/nuevo">Nuevo</a>
                    <table class="datatable table table-striped table-bordered dt-responsive" style="width:100%">
    <thead>
        <tr>
        <th>Id Cliente</th>
        <th>Nombre </th>
        <th>Direccion</th>
        <th>Empresa</th>
        <th>RUC</th>
        <th>DNI</th>
        <th>LISTA PRECIO</th>
        <th>Telefono</th>
        <th>Celular</th>
        <th>Acciones</th>
        </tr>
    </thead>
    <tfoot>
       <tr>
        <th>Id Cliente</th>
        <th>Nombre </th>
        <th>Direccion</th>
        <th>Empresa</th>
        <th>RUC</th>
        <th>DNI</th>
        <th>LISTA PRECIO</th>
        <th>Telefono</th>
        <th>Celular</th>
        <th>Acciones</th>
        </tr>
    </tfoot>
</table>
        <!-- modal para editar clientes -->

                <div id="form_editar" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title">Editar Cliente</h1>
                      </div>
                      <div class="modal-body">
                        <form id="form_editar" action="'.$this->baseurl.INDEX.'clientes/editarBD" method="post" enctype="multipart/form-data" class="ocultar">
                            <input name="id" type="hidden" >
                            <div class="form-group row">
                                <label for="" class="col-5">RUC :</label>
                                <div class="col-7">
                                    <input class="form-control form-control-sm" type="text" name="ruc" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-5">DNI :</label>
                                <div class="col-7">
                                    <input class="form-control form-control-sm" type="text" name="dni" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-5">Raz&oacuten Social :</label>
                                <div class="col-7">
                                    <input class="form-control form-control-sm" type="text" name="empresa" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-5">Nombre :</label>
                                <div class="col-7">
                                    <input class="form-control form-control-sm" type="text" name="nombre" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-5">Lista Precio</label>
                                <div class="col-7">
                                  <select name="lista_precio" id=lista_precio class="form-control form-control-sm select2_lista_precio"></select>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="" class="col-5">Direcci&oacuten :</label>
                                <div class="col-7">
                                  <input class="form-control form-control-sm" type="text" name="direccion" autocomplete="off" >
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="" class="col-5">Celular :</label>
                                <div class="col-7">
                                    <input class="form-control form-control-sm" type="text" name="celular" cols="30" rows="3" placeholder="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-5">Tel&eacutefono :</label>
                                <div class="col-7">
                                    <input class="form-control form-control-sm" type="text" name="telefono" cols="30" rows="3" placeholder="">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="" class="col-5 "></label>
                                <div class="col-7">
                                    <button class="btn btn-dark btn-sm">Modificar</button>
                                </div>
                            </div>
                        </form>
                      </div>
                      <!--<div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                      </div>-->
                    </div>
                    
                      </div>
                </div>
			
			


		 <div id="form_more_direccion" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title">Direcciones</h1>
                        <br><h6> Para Eliminar Deje vac&iacuteo</h6>
                      </div>
                      <div class="modal-body">
                        <form id="form_more_direccion" action="'.$this->baseurl.INDEX.'clientes/agregarDireccion" method="post" enctype="multipart/form-data" class="ocultar">
                            <input name="id" type="hidden" >
                            <div id=c_direcciones name=c_direcciones>
                            
                            
                            </div>
                            <div id=footer_dire name=footer_dire>
                            
                            
                            </div>
                            
                        </form>
                      </div>
                      <!--<div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                      </div>-->
                    </div>
                    
                      </div>
                </div>	


<script>
$(document).ready(function() {
    lista_precios();

    function lista_precios() {
        $.ajax({
              url: "'.$this->baseurl.INDEX.'lista_precio/loadListaprecio",
            type: "POST",
            dataType: "json",
            beforeSend: function() {},
            success: function(data) {
                var e = $(".select2_lista_precio");
                e.find("option").each(function() {
                    $(this).remove();
                });
                e.append("<option value=-1 disabled selected>Seleccione una Lista </option>");
                $.each(data, function(i, item) {
                    e.append("<option value="+item.id +">"  +item.nombre.toUpperCase()+ "</option>");
                });
            },
         });
    }
  var table = $(".datatable").DataTable({
        "ajax": {
            "url": "'.$this->baseurl.INDEX.'clientes/loadClientes/",
            "dataSrc": ""
        },
        "columns": [{
            "data": "id"
        }, {
            "data": "cli_nombre"
        }, {
            "data": "cli_direccion"
        }, {
            "data": "cli_empresa"
        }, {
            "data": "cli_ruc"
        }, {
            "data": "cli_dni"
        }, {
            "data": "lista_precio"
        }, {
            "data": "cli_telefono"
        }, {
            "data": "cli_celular"
        }, {
            //"defaultContent": "<div class=\"row botones_datables\" >  <div class=\"col-4\"> <button id=\"btn_editar\" class=\"btn btn-primary btn-sm\"><i class=\"fas fa-edit\"></i></button> </div> <div class=\"col-4\"> <button id=\"btn_eliminar\" class=\"btn btn-primary btn-sm\"><i class=\"fas fa-trash-alt\"></i></button> </div>  </div>"
            "defaultContent": "<div class=\"row botones_datables\" >  <div class=\"col-6\"> <button id=\"btn_editar\" class=\"btn btn-primary btn-sm\"><i class=\"fas fa-edit\"></i></button> </div> <div class=\"col-4\"> <button id=\"btn_eliminar\" class=\"btn btn-primary btn-sm\"><i class=\"fas fa-trash-alt\"></i></button> </div> <div class=\"col-4\"> <button id=\"btn_add_direccion\" class=\"btn btn-primary btn-sm\"><i class=\"fas fa-plus\"></i></button> </div> </div>"
        }, ],
        "language": {
            "url": "'.$this->baseurl.'includes/datatables/Spanish.json"
        },
        "lengthMenu": [
            [10, 15, 20, -1],
            [10, 15, 20, "All"]
        ]
    });
    
     $(".datatable tbody").on("click", "#btn_editar", function() {
        var data = table.row($(this).parents("tr")).data();
        if (data == undefined) {
            var selected_row = $(this).parents("tr");
            if (selected_row.hasClass("child")) {
                selected_row = selected_row.prev();
            }
            var rowData = $(".datatable").DataTable().row(selected_row).data();
            editar(rowData["id"]);
        } else {
            editar(data["id"]);
        }
    });
    $(".datatable tbody").on("click", "#btn_eliminar", function() {
        var data = table.row($(this).parents("tr")).data();
        if (data == undefined) {
            var selected_row = $(this).parents("tr");
            if (selected_row.hasClass("child")) {
                selected_row = selected_row.prev();
            }
            var rowData = $(".datatable").DataTable().row(selected_row).data();
            eliminar(rowData["id"],rowData["cli_nombre"]);
        } else {
            eliminar(data["id"],data["cli_nombre"]);
        }
    });
    $(".datatable tbody").on("click", "#btn_add_direccion", function() {
        alert("ss");
        var data = table.row($(this).parents("tr")).data();
        if (data == undefined) {
            var selected_row = $(this).parents("tr");
            if (selected_row.hasClass("child")) {
                selected_row = selected_row.prev();
            }
            var rowData = $(".datatable").DataTable().row(selected_row).data();
            moreDireccion(rowData["id"]);
        } else {
            moreDireccion(data["id"]);
        }
    });
    $(".datatable tbody").on("click", ".C_DIRECCIONES", function() {
        var data = table.row($(this).parents("tr")).data();
        if (data == undefined) {
            var selected_row = $(this).parents("tr");
            if (selected_row.hasClass("child")) {
                selected_row = selected_row.prev();
            }
            var rowData = $(".datatable").DataTable().row(selected_row).data();
            detalle(rowData["id"]);
        } else {
            detalle(data["id"]);
        }
    });
});

</script>
<script type="text/javascript">

function moreDireccion(id) {
        var cliente_id =id;
      $("#form_more_direccion").modal("show");
	    $.ajax({
            url: "'.$this->baseurl.INDEX.'/clientes/getDirecciones",
            type: "POST",
            dataType: "json",
            data: {
            "id": id,
            },
            success: function(data) {
                console.log(data);
                cantidadd=0;
                var form = $("#form_more_direccion");
                form.find("div[name=c_direcciones]").html("");
                if(data!=null){
                    for(var i=0;i<data.length;i++){
                        cantidadd++;
                        form.find("div[name=c_direcciones]").append("<div class=\"form-group row\">"+
                                    "<label class=\"col-5\">Direccion "+(i+1)+" :</label>"+
                                    "<div class=\"col-7\">"+
                                        "<textarea class=\"form-control form-control-sm\" rows=4 name=\"cli_dir"+(i+1)+"\" >"+
                                        data[i].direccion+"</textarea>"+
                                    "</div>"+
                                "</div>");
                    }
                }
                form.find("div[name=footer_dire]").html("<div class=\"form-group row\">"+
                                "<input type=hidden id=cantidad_direcciones name=cantidad_direcciones value="+cantidadd+" />"+
                                 "<input type=hidden id=id_cliente_dir name=id_cliente_dir value="+cliente_id+" />"+
                                "<div class=\"col-7\">"+
                                    "<input type=button id=button_more_dir onclick=\"addTextDir("+cantidadd+")\" class=\"btn btn-dark btn-sm\" value=\"+ Direccion \">"+
                                "</div>"+
                                    "<button class=\"btn btn-dark btn-sm\">Guardar Informacion</button>"+
                                    
                            "</div>");
            }
        });
}
function addTextDir(cantidad){
    var form = $("#form_more_direccion");
    form.find("div[name=c_direcciones]").append("<div class=\"form-group row\">"+
                                "<label class=\"col-5\">Direccion "+(cantidad+1)+" :</label>"+
                                "<div class=\"col-7\">"+
                                    "<textarea class=\"form-control form-control-sm\" type=text rows=3 name=\"cli_dir"+(cantidad+1)+"\" ></textarea>"+
                                "</div>"+
                            "</div>");
    $("#cantidad_direcciones").val(parseInt($("#cantidad_direcciones").val())+1);                      
    $("#button_more_dir").removeAttr("onclick");
    $("#button_more_dir").attr("onclick","addTextDir("+(cantidad+1)+")");
}
function detalle(id_cliente){
    
    $.ajax({
        url: "'.$this->baseurl.INDEX.'clientes/lista",
        type: "POST",
        data: {
            id_cliente: id_cliente,
        },
        success: function(data) {                   
            //alert(data);
             alertify.alert().set("message", data).show(); 

        }
    });
}
function editar(id) {
      $("#form_editar").modal("show");
	    $.ajax({
            url: "'.$this->baseurl.INDEX.'/clientes/editar",
            type: "POST",
            dataType: "json",
            data: {
            "id": id,
            },
            success: function(data) {
                console.log(data);
                var form = $("#form_editar");
                form.find("input[name=id]").val(data[0].id);
                form.find("input[name=ruc]").val(data[0].cli_ruc);
                form.find("input[name=dni]").val(data[0].cli_dni);
                form.find("input[name=empresa]").val(data[0].cli_empresa);
                form.find("input[name=nombre]").val(data[0].cli_nombre);
                form.find("input[name=direccion]").val(data[0].cli_direccion);
                form.find("input[name=celular]").val(data[0].cli_celular);
                form.find("input[name=telefono]").val(data[0].cli_telefono);
                form.find("select[name=lista_precio]").val(data[0].cli_lista_precio);
            }
        });
}
function eliminar(id,nombre) {
      $.prompt("&#191;Desea eliminar al cliente "+nombre+" ?", {
            title: "Eliminar",
            buttons: { "Eliminar": true, "Cancelar": false },
            submit: function(e, v, m, f) {
                if(v){
                e.preventDefault();
                $.ajax({
                url: "'.$this->baseurl.INDEX.'clientes/delete",
                type: "POST",
                dataType: "html",
                data: {
                    "id": id,
                },
                success: function(data) {                   
                    table = $(".datatable").DataTable();
                    table.ajax.reload();
                }
            });
            }
            $.prompt.close();
            }
        });
}   
</script>';

    return $r;
	}
	function Users($rows, $data, $show, $currentPage, $txt){

		//$show = 5;
		$numRows = count($rows);
		$pages = ceil($numRows / $show);


		$r = '<table width="100%" class="table-hover"  cellspacing="0">';
		$r .= '<tr class="thhead"><th align="left">ID</th>
		<th align="left">NOMBRES</th>
		<th align="left">COD CLIENTE</th>
		<th align="left">DNI</th>
		<th align="left">CEL </th>
		<th align="left">Tel&eacute;fono</th><th align="center" >Acci&oacute;n</th>';
		foreach ($data as $d){
				$r .= '<tr ><td style="border-bottom:1px solid #dddddd;">'.$d->id_client.'</td>';
			$r .= '<td style="border-bottom:1px solid #dddddd;">' .$d->nombre.'</td>';

				$r .= '<td style="border-bottom:1px solid #dddddd;">'.$d->cod_cliente.'</td>';
			$r .= '<td style="border-bottom:1px solid #dddddd;">'.$d->dni.'</td>';

			$r .= '<td style="border-bottom:1px solid #dddddd;">'.$d->agencia.'</td>';
			$r .= '<td style="border-bottom:1px solid #dddddd;">'.$d->telef.'</td>';

			$r .= '<td align="right" style="border-bottom:1px solid #dddddd;width:125px;">';

			$r .= '<div class="ui-state-default ui-corner-all" title="Editar"><a class="edit" href="'.$this->baseurl.INDEX.'clientes/userEdit/'.$d->id_client.'"><span class="ui-icon ui-icon-gear"></a></span></div>';
			$r .= '<div class="ui-state-default ui-corner-all" title="Eliminar" onclick="deleteUser('.$d->id_client.');"><span class="ui-icon ui-icon-trash"></span></div>';

			$r .= '</td></tr>';
		}
		$r .= '</table>';


		$r .= '<br/><table width="622" cellspacing="0"><tr><td>';

				$r .= 'Total:&nbsp;'.$numRows.',&nbsp;';

				// if($pages > 1){
					$r .= 'Mostrar:&nbsp;<select id="showRows" onchange="viewPage(1, \'limit 0,\');">';
					for($inc = 5; $inc < 21;$inc+=5)
					{
					if($show == $inc)
						$r .= '<option value="'.$inc.'" selected>'.$inc.'</option>';
						else
						$r .= '<option value="'.$inc.'" >'.$inc.'</option>';
					}
					$r .= '</select>';
				// }

				$r .= '&nbsp;P&aacute;ginas:&nbsp;';
					for($i=0;$i<$pages;$i++)
					{
					if($currentPage == ($i+1))
					$r .= '<a style="color:#888888;" href="javascript:;" onclick="viewPage('.($i+1).',\'limit '.($i*$show).',\');"><b>'.($i+1).'</b></a>&nbsp;&nbsp;';
					else
					$r .= '<a style="color:#888888;" href="javascript:;" onclick="viewPage('.($i+1).',\'limit '.($i*$show).',\');">'.($i+1).'</a>&nbsp;&nbsp;';
					}


		$r .= '</td></tr></table>';
		
		

		$r .= '<script type="text/javascript">';

		$r .='$("select#showRows").customStyle();';



		$r .= 'function viewPage(page, limit){';
				$r .= 'showLoading();';
					$r .= '$.post("'.$this->baseurl.INDEX.'clientes/loadUsers",';
					$r .= '{"limit":limit+$("#showRows").val(), "show":$("#showRows").val(), "page":page, "text":"'.$txt.'"},';
					$r .= 'function(data) {';
							$r .= 'hideLoading();';
							$r .= '$("#content").html(data);';
					$r .= '});';
		$r .= '}';

		$r .= '$("a.edit").colorbox({width:"470", height:"530"});';


		$r .= '$(\'.ui-state-default\').hover(';
			$r .= 'function(){ $(this).addClass(\'ui-state-hover\'); }, ';
			$r .= 'function(){ $(this).removeClass(\'ui-state-hover\'); }';
		$r .= ');';



		$r .= 'function deleteUser(id){';

			$r .= '$.prompt("&#191;Desea eliminar este Cliente?",{ buttons: { Aceptar: true, Cancelar: false },callback: function(v){';
				$r .= 'if(v){';
						$r .= 'showLoading();';
							$r .= '$.post("'.$this->baseurl.INDEX.'clientes/deleteUser",';
							$r .= '{"id":id},';
							$r .= 'function(data) {';

								$r .= 'loadItems();';

							$r .= '});';
				$r .= '}';

			$r .= ' }});';

		$r .= '}';



		$r .= 'function loadItems(){';

						$r .= 'var numRows = 100;';
							$r .= '$.post("'.$this->baseurl.INDEX.'clientes/loadUsers",';
							$r .= '{"limit":"limit 0,"+numRows, "show":numRows, "page":1, "text":""},';
							$r .= 'function(data) {';
									$r .= 'hideLoading();';
									$r .= '$("#content").html(data);';
							$r .= '});';

		$r .= '}';
	

		$r .= '</script>';

		return $r;
	}
	
	function nuevo($data){
            $cli = new Table(array("width" => "100%", "class"=>"table table-condensed table-hover", "id"=>"tablecn","style"=>"width:350px;"));
            $cli->addRow();
			$cli->addCell();
			$cli->addCell();
            
			$cli->addRow();
			$cli->addCell('RUC');
			$cli->addCell('<input type="text" name="ruc" id="ruc" class="texts" value=""/>');
			$cli->addCell('<a id="btn_datos_sunat" class="btn_search" href="javascript:;">Buscar</a>', array("colspan"=>"2", "align"=>"center"));

			$cli->addRow();
			$cli->addCell('DNI *');
			$cli->addCell('<input type="text" name="dni" id="dni" autocomplete=off class="texts" value=""/>');
        	$cli->addCell('<a id="btn_datos_reniec" class="btn_search" href="javascript:;">Buscar</a>', array("colspan"=>"2", "align"=>"center"));

    		$cli->addRow();
			$cli->addCell('Raz&oacuten Social *');
			$cli->addCell('<input type="text" name="empresa" id="razonsocial" autocomplete=off class="texts" value=""/>',array("colspan"=>"2"));

			$cli->addRow();
			$cli->addCell('Nombre *');
			$cli->addCell('<input type="text" name="nombre" id="nombre" autocomplete=off class="texts" value=""/>',array("colspan"=>"2"));

			$cli->addRow();
			$cli->addCell('Direcci&oacute;n (Empresa) *');
			$cli->addCell('<input type="text" name="direccion" autocomplete=off id="direccion" class="texts" value=""/>',array("colspan"=>"2"));


			$cli->addRow();
			$cli->addCell('Celular ');
			$cli->addCell('<input type="text" name="celular" autocomplete=off id="celular" class="texts" value=""/>');
			
			
			$cli->addRow();
			$cli->addCell('Tel&eacutefono ');
			$cli->addCell('<input type="text" name="telefono" autocomplete=off id="telefono" class="texts" value=""/>');
			
			$cli->addRow();
			$cli->addCell('Lista Precio');
			$cli->addCell('<select name="lista_precio" id=lista_precio class="form-control form-control-sm select2_lista_precio"></select>',array("colspan"=>"2"));
			

      $cli->addRow();
			$cli->addCell('<a id="saveUser" class="btn_send" href="#">Guardar</a>', array("colspan"=>"2", "align"=>"center"));
      $r = $cli->getTable();


	$r .= '<script type="text/javascript">';

    $r .= '
    //sunat requerimiento
    $("#btn_datos_sunat").click(function() {
        var caracter = $("#ruc").val().length;
        if (caracter == 11) {
            obtener_datos_sunat();
        }else{
            $.prompt("RUC - 11 dígitos")
        }
    });
    //reniec requerimiento
    $("#btn_datos_reniec").click(function(){
        var caracter = $("#dni").val().length;
        if (caracter == 8) {
            datos_dni($("#dni").val());
        }else{
            $.prompt("DNI - 8 dígitos")
        }
    });
    
    
function obtener_datos_sunat() {
    ruc = $("#ruc").val();
    $.ajax({
        url: "'.$this->baseurl.INDEX.'sunat/datos_jossmp",
        type: "POST",
        dataType: "json",
        data: {
            "ruc": ruc
        },
        success: function(data) {
            console.log(data);
            if (!data["success"]) {
                $.prompt("No se encontro <b>RUC</b>");
            } else {
                //$.prompt("DATOS obtenidos correctamente");
                //alertify.notify("<strong>DATOS</strong> obtenidos correctamente", "custom-black", 2, function() {});

                $("#razonsocial").val(data["result"]["RazonSocial"]);
                $("#direccion").val(data["result"]["Direccion"]);
            }
        },
        error: function(data) {
            $.prompt("No hay conexión con SUNAT,vuelva a intentarlo o ingrese manualmente");
            
        },
    });
}
    function datos_dni(dni) {
        $.ajax({
            url: "'.$this->baseurl.INDEX.'reniec/datos",
            type: "POST",
            dataType: "json",
            data: {
                "dni": dni
            },
            success: function(data) {
                console.log(data);
                if (Object.entries(data).length === 0) {
                    $.prompt("No se encontro DNI");
                } else {
                    $("#nombre").val(data.nombres+" "+data.apellidos);
                }
            }
        });
    }
    ';

	$r .= '$("#saveUser").click(function(){';

		$r .= 'var nombre = $("#nombre").val();';
		$r .= 'var direccion = $("#direccion").val();';
		$r .= 'var ruc = $("#ruc").val();';
    $r .= 'var celular = $("#celular").val();';
		$r .= 'var dni = $("#dni").val();';
		$r .= 'var empresa = $("#razonsocial").val();';
		$r .= 'var telefono = $("#telefono").val();';
		$r .= 'var lista_precio = $("#lista_precio").val();';
					$r .='			
					if( ruc.length != 11 && dni.length!=8){
					    $.prompt("Verificar DNI o RUC");
					    document.getElementById("ruc").focus();
					    return false;
					}		
					if(dni.length==8 && nombre.length==0 ){
					    $.prompt("Error Nombre del Cliente  ");
					    return false;
					}		
					if(ruc.length==11 && empresa.length==0){
					    $.prompt("Error en Razón Social  ");
					     return false;
					}
				 else {
                    console.log("h");		';
                
				$r .= 'showLoading();';

				$r .= '$.post("'.$this->baseurl.INDEX.'clientes/save",';
				$r .= '{"lista_precio":lista_precio,"nombre":nombre,"telefono":telefono,"empresa":empresa, "dni":dni,"direccion":direccion, "ruc":ruc, "celular":celular},';
				$r .= 'function(data) {';
				$r .='$.prompt(data);';
                $r .= 'location.href = "'.$this->baseurl.INDEX.'clientes"';
				$r .= '});';

			$r .= '}';

	$r .= '});';
	$r .= '
	lista_precios();

    function lista_precios() {
        $.ajax({
              url: "'.$this->baseurl.INDEX.'lista_precio/loadListaprecio",
            type: "POST",
            dataType: "json",
            beforeSend: function() {},
            success: function(data) {
                var e = $(".select2_lista_precio");
                e.find("option").each(function() {
                    $(this).remove();
                });
                e.append("<option value=-1 disabled selected>Seleccione una Lista </option>");
                $.each(data, function(i, item) {
                    if(item.id==1){
                        e.append("<option value="+item.id +" selected>"  +item.nombre.toUpperCase()+ "</option>");
                    }else{
                        e.append("<option value="+item.id +">"  +item.nombre.toUpperCase()+ "</option>");
                    }
                    
                });e.select2({ maximumSelectionLength: 10 });
            },
         });
    }';
	$r .= '</script>';

		return $r;

	}
	/*function listClients($data){
		$tbl = new Table();
		foreach($data as $row) {
				$tbl->addRow();
        //(id, name,empresa,ruc,direccion)
				$tbl->addCell('<a href="javascript:;" onclick="selectItem('.$row->id.',\''.$row->cli_nombre.'\',\''.$row->cli_empresa.'\',\''.$row->cli_ruc.'\',\''.$row->cli_direccion.'\');">'.$row->cli_nombre.' / </a>');
			}
			return $tbl->getTable();
	}*/
	function listClients($data){
		$tbl = new Table();
		foreach($data as $row) {
				$tbl->addRow();
        //(id, name,empresa,ruc,direccion)
                if($row->cli_ruc==""){
				    $tbl->addCell('<a href="javascript:;" onclick="selectItem('.$row->id.',\''.$row->cli_nombre.'\',\''.$row->cli_empresa.'\',\''.$row->cli_dni.'\',\''.$row->cli_direccion.'\',\''.$row->cli_telefono.'\',\''.$row->cli_celular.'\');">'.$row->cli_dni."/".$row->cli_nombre.' / </a>');
				}else if(substr($row->cli_ruc,0,1)==1){
				        $tbl->addCell('<a href="javascript:;" onclick="selectItem('.$row->id.',\''.$row->cli_nombre.'\',\''.$row->cli_nombre.'\',\''.$row->cli_ruc.'\',\''.$row->cli_direccion.'\',\''.$row->cli_telefono.'\',\''.$row->cli_celular.'\');">'.$row->cli_ruc."/".$row->cli_nombre.' / </a>');
				    }else
				       $tbl->addCell('<a href="javascript:;" onclick="selectItem('.$row->id.',\''.$row->cli_empresa.'\',\''.$row->cli_empresa.'\',\''.$row->cli_ruc.'\',\''.$row->cli_direccion.'\',\''.$row->cli_telefono.'\',\''.$row->cli_celular.'\');">'.$row->cli_ruc."/".$row->cli_empresa.' / </a>');
		}
		return $tbl->getTable();
	}
    function listClientsRapida($data){
        $tbl = new Table();
        foreach($data as $row) {
                $tbl->addRow();
                $tbl->addCell('<a href="javascript:;" onclick="selectItem('.$row->id.',\''.$row->cli_nombre.'\',\''.$row->cli_dni.'\');">'.$row->cli_dni."/".$row->cli_nombre.' / </a>');
        }
        return $tbl->getTable();
    }

    function listClientsRapidaDni($data){
		$tbl = new Table();
		foreach($data as $row) {
				$tbl->addRow();
				$tbl->addCell('<a href="javascript:;" onclick="selectItemDni('.$row->id.',\''.$row->cli_nombre.'\',\''.$row->cli_dni.'\',\''.$row->cli_descuento.'\');">'.$row->cli_dni."/".$row->cli_nombre.' / </a>');
		}
		return $tbl->getTable();
	}
	function listClientsRapidaRuc($data){
		$tbl = new Table();
		foreach($data as $row) {
				$tbl->addRow();
				$tbl->addCell('<a href="javascript:;" onclick="selectItemRuc('.$row->id.',\''.$row->cli_empresa.'\',\''.$row->cli_ruc.'\',\''.$row->cli_descuento.'\');">'.$row->cli_ruc."/".$row->cli_empresa.' / </a>');
		}
		return $tbl->getTable();
	}
















}
