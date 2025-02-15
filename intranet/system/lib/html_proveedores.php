<?php
class html_proveedores extends f
{
	private $baseurl = "";

	function html_proveedores()
	{

		$this->load()->lib_html("Table", false);

		$this->baseurl = BASEURL;
	}

	function containerUsers()
	{
		$r = '
		<div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-12">
						<span style="float: right; margin-bottom: 10px;" class="btn btn-outline-success btn-rounded" onclick="nuevo();">Nuevo</span>
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Lista de Proveedores
                        </h5>
                        <small>
                            <i class="fa fa-edit"></i> Aquí podrá ver toda la información de todos los Proveedores
                        </small>
                        <hr>         
                        <div class="container">
                            <div class="row">
                                <div class="col-12 form-row"  id="table-response">
									<table class="datatable table table-striped table-bordered dt-responsive" style="width:100%">
										<thead>
											<tr>
											<th>Id Proveedor</th>
											<th>RUC</th>
											<th>RAZON SOCIAL</th>
											<th>DIRECCION</th>
											<th>TELEFONO</th>
											<th>Acciones</th>
											</tr>
										</thead>
										<tfoot>
										<tr>
											<th>Id Proveedor</th>
											<th>RUC</th>
											<th>RAZON SOCIAL</th>
											<th>DIRECCION</th>
											<th>TELEFONO</th>
											<th>Acciones</th>
											</tr>
										</tfoot>
									</table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


 <!-- modal para editar proveedores -->

                <div id="form_editar" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title">Editar Proveedor</h1>
                      </div>
                      <div class="modal-body">
                            <input name="id" type="hidden" >
                            <div class="form-group row">
                                <label for="" class="col-5">RUC :</label>
                                <div class="col-7">
                                    <input class="form-control form-control-sm" type="text" name="ruc" id="ruc" >
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="" class="col-5">Raz&oacuten Social :</label>
                                <div class="col-7">
                                    <input class="form-control form-control-sm" type="text" name="empresa" id="empresa" >
                                </div>
                            </div>
                           
                            <div class="form-group row">
                                <label for="" class="col-5">Direcci&oacuten :</label>
                                <div class="col-7">
                                  <input class="form-control form-control-sm" type="text" name="direccion" id="direccion" autocomplete="off" >
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="" class="col-5">Tel&eacutefono :</label>
                                <div class="col-7">
                                    <input class="form-control form-control-sm" type="text" name="telefono" id="telefono" cols="30" rows="3" placeholder="">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="" class="col-5 "></label>
                                <div class="col-7">
                                    <button class="btn btn-dark btn-sm" id="btn_guardar">Modificar</button>
                                </div>
                            </div>
                      </div>
                      <!--<div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                      </div>-->
                    </div>
                    
                      </div>
                </div>

<script>
$(document).ready(function() {
  var table = $(".datatable").DataTable({
        "ajax": {
            "url": "' . $this->baseurl . INDEX . 'proveedores/loadProveedores/",
            "dataSrc": ""
        },
        "columns": [{
            "data": "id"
        }, {
            "data": "pro_ruc"
        }, {
            "data": "pro_razonsocial"
        }, {
            "data": "pro_direccion"
        }, {
            "data": "pro_telefono"
        }, {
            "defaultContent": "<button id=\"btn_editar\" class=\"btn btn-outline-warning btn-sm d-block\"><i class=\"fa fa-edit\"></i></button><button id=\"btn_eliminar\" class=\"btn btn-outline-danger btn-sm d-block mt-1\"><i class=\"fa fa-trash\"></i></button>"
        }, ],
        "language": {
            "url": "' . $this->baseurl . 'includes/datatables/Spanish.json"
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
            eliminar(rowData["id"],rowData["pro_razonsocial"]);
        } else {
            eliminar(data["id"],data["pro_razonsocial"]);
        }
    });
    
});

</script>
<script type="text/javascript">


function editar(id) {
      $("#form_editar").modal("show");
	    $.ajax({
            url: "' . $this->baseurl . INDEX . 'proveedores/editar",
            type: "POST",
            dataType: "json",
            data: {
            "id": id,
            },
            success: function(data) {
                console.log(data);
                var form = $("#form_editar");
                form.find("input[name=id]").val(data[0].id);
                form.find("input[name=ruc]").val(data[0].pro_ruc);
                form.find("input[name=empresa]").val(data[0].pro_razonsocial);
                form.find("input[name=direccion]").val(data[0].pro_direccion);
                form.find("input[name=telefono]").val(data[0].pro_telefono);
            }
        });
	$("#btn_guardar").text("Modificar");
	$("#btn_guardar").attr("onclick", "actualizar("+id+");");
}
function nuevo(){
	$("#form_editar").modal("show");
	$("#btn_guardar").text("Guardar");
	$("#btn_guardar").attr("onclick", "guardar();");
}
function actualizar(id){
	$.ajax({
		url: "' . $this->baseurl . INDEX . 'proveedores/editarBD",
		type: "POST",
		dataType: "json",
		data: {
			id: id,
			ruc: $("#ruc").val(),
			empresa: $("#empresa").val(),
			direccion: $("#direccion").val(),
			telefono: $("#telefono").val(),
		},
		success: function(data) {
			$("#form_editar").modal("hide");
			alertify.notify("Se agrego el <strong>Proveedor</strong> correctamente.", "custom-black", 4, function() {})
			table = $(".datatable").DataTable();
            table.ajax.reload();
		}
	});
}
function guardar(){
	$.ajax({
		url: "' . $this->baseurl . INDEX . 'proveedores/save",
		type: "POST",
		dataType: "json",
		data: {
			ruc: $("#ruc").val(),
			empresa: $("#empresa").val(),
			direccion: $("#direccion").val(),
			telefono: $("#telefono").val(),
		},
		success: function(data) {
			$("#form_editar").modal("hide");
			alertify.notify("Se agrego el <strong>Proveedor</strong> correctamente.", "custom-black", 4, function() {})
			table = $(".datatable").DataTable();
            table.ajax.reload();
		}
	});
}
function eliminar(id,nombre) {
      $.prompt("&#191;Desea eliminar al proveedor "+nombre+" ?", {
            title: "Eliminar",
            buttons: { "Eliminar": true, "Cancelar": false },
            submit: function(e, v, m, f) {
                if(v){
                e.preventDefault();
                $.ajax({
                url: "' . $this->baseurl . INDEX . 'proveedores/delete",
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
	function Users($rows, $data, $show, $currentPage, $txt)
	{

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
		foreach ($data as $d) {
			$r .= '<tr ><td style="border-bottom:1px solid #dddddd;">' . $d->id_client . '</td>';
			$r .= '<td style="border-bottom:1px solid #dddddd;">' . $d->nombre . '</td>';

			$r .= '<td style="border-bottom:1px solid #dddddd;">' . $d->cod_cliente . '</td>';
			$r .= '<td style="border-bottom:1px solid #dddddd;">' . $d->dni . '</td>';

			$r .= '<td style="border-bottom:1px solid #dddddd;">' . $d->agencia . '</td>';
			$r .= '<td style="border-bottom:1px solid #dddddd;">' . $d->telef . '</td>';

			$r .= '<td align="right" style="border-bottom:1px solid #dddddd;width:125px;">';

			$r .= '<div class="ui-state-default ui-corner-all" title="Editar"><a class="edit" href="' . $this->baseurl . INDEX . 'clientes/userEdit/' . $d->id_client . '"><span class="ui-icon ui-icon-gear"></a></span></div>';
			$r .= '<div class="ui-state-default ui-corner-all" title="Eliminar" onclick="deleteUser(' . $d->id_client . ');"><span class="ui-icon ui-icon-trash"></span></div>';

			$r .= '</td></tr>';
		}
		$r .= '</table>';


		$r .= '<br/><table width="622" cellspacing="0"><tr><td>';

		$r .= 'Total:&nbsp;' . $numRows . ',&nbsp;';

		// if($pages > 1){
		$r .= 'Mostrar:&nbsp;<select id="showRows" onchange="viewPage(1, \'limit 0,\');">';
		for ($inc = 5; $inc < 21; $inc += 5) {
			if ($show == $inc)
				$r .= '<option value="' . $inc . '" selected>' . $inc . '</option>';
			else
				$r .= '<option value="' . $inc . '" >' . $inc . '</option>';
		}
		$r .= '</select>';
		// }

		$r .= '&nbsp;P&aacute;ginas:&nbsp;';
		for ($i = 0; $i < $pages; $i++) {
			if ($currentPage == ($i + 1))
				$r .= '<a style="color:#888888;" href="javascript:;" onclick="viewPage(' . ($i + 1) . ',\'limit ' . ($i * $show) . ',\');"><b>' . ($i + 1) . '</b></a>&nbsp;&nbsp;';
			else
				$r .= '<a style="color:#888888;" href="javascript:;" onclick="viewPage(' . ($i + 1) . ',\'limit ' . ($i * $show) . ',\');">' . ($i + 1) . '</a>&nbsp;&nbsp;';
		}


		$r .= '</td></tr></table>';



		$r .= '<script type="text/javascript">';

		$r .= '$("select#showRows").customStyle();';



		$r .= 'function viewPage(page, limit){';
		$r .= 'showLoading();';
		$r .= '$.post("' . $this->baseurl . INDEX . 'clientes/loadUsers",';
		$r .= '{"limit":limit+$("#showRows").val(), "show":$("#showRows").val(), "page":page, "text":"' . $txt . '"},';
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
		$r .= '$.post("' . $this->baseurl . INDEX . 'clientes/deleteUser",';
		$r .= '{"id":id},';
		$r .= 'function(data) {';

		$r .= 'loadItems();';

		$r .= '});';
		$r .= '}';

		$r .= ' }});';

		$r .= '}';



		$r .= 'function loadItems(){';

		$r .= 'var numRows = 100;';
		$r .= '$.post("' . $this->baseurl . INDEX . 'clientes/loadUsers",';
		$r .= '{"limit":"limit 0,"+numRows, "show":numRows, "page":1, "text":""},';
		$r .= 'function(data) {';
		$r .= 'hideLoading();';
		$r .= '$("#content").html(data);';
		$r .= '});';

		$r .= '}';


		$r .= '</script>';

		return $r;
	}
	function editUser($data)
	{

		$cli = new Table(array("width" => "100%", "class" => "table"));


		$cli->addRow();
		$cli->addCell('<h3>Informaci&oacute;n del Cliente</h3>', array("colspan" => "2"));

		$cli->addRow();
		$cli->addCell('Cod Cliente');
		$cli->addCell('<input type="text" name="cod_cliente" id="cod_cliente" class="texts" value="' . $data[0]->cod_cliente . '"/>');

		$cli->addRow();
		$cli->addCell('Nombre');
		$cli->addCell('<input type="text" name="nombre" id="nombre" class="texts" value="' . $data[0]->nombre . '"/>');

		$cli->addRow();
		$cli->addCell('DNI');
		$cli->addCell('<input type="text" name="dni" id="dni" class="texts" value="' . $data[0]->dni . '"/>');

		$cli->addRow();
		$cli->addCell('Direcci&oacute;n');
		$cli->addCell('<input type="text" name="direccion" id="direccion" class="texts" value="' . $data[0]->direccion . '"/>');

		$cli->addRow();
		$cli->addCell('RUC');
		$cli->addCell('<input type="text" name="ruc" id="ruc" class="texts" value="' . $data[0]->ruc . '"/>');


		$cli->addRow();
		$cli->addCell('Cel R1');
		$cli->addCell('<input type="text" name="telefono" id="telefono" class="texts" value="' . $data[0]->telef . '"/>');

		$cli->addRow();
		$cli->addCell('Cel R2');
		$cli->addCell('<input type="text" name="celular" id="celular" class="texts" value="' . $data[0]->celular . '"/>');

		$cli->addRow();
		$cli->addCell('Agencia');
		$cli->addCell('
				<select name="agencia" id="agencia" class="texts">
			<option value="' . $data[0]->agencia . '">' . $data[0]->agencia . '</option>
			<option value="Livitaca">Livitaca</option>
			<option value="Arequipa">Arequipa</option>
			<option value="Chamaca">Chamaca</option>


			</select>
			');

		$cli->addRow();
		$cli->addCell('<a id="saveUser" class="btn_send" href="javascript:;">Guardar</a>', array("colspan" => "2", "align" => "center"));


		$r = $cli->getTable();

		$r .= '<script type="text/javascript">';



		$r .= '$("#saveUser").click(function(){';

		$r .= 'var nombre = $("#nombre").val();';
		$r .= 'var direccion = $("#direccion").val();';
		$r .= 'var ruc = $("#ruc").val();';
		$r .= 'var telefono = $("#telefono").val();';
		$r .= 'var celular = $("#celular").val();';
		$r .= 'var dni = $("#dni").val();';

		$r .= 'if(nombre == "")';
		$r .= 'alert("Escriba un nombre");';
		$r .= ' else ';
		$r .= 'if(direccion == "")';
		$r .= 'alert("Escriba Direccion");';
		$r .= ' else ';
		$r .= 'if(celular == "")';
		$r .= 'alert("Escriba Celular");';
		$r .= ' else{ ';

		$r .= 'showLoading();';

		$r .= '$.post("' . $this->baseurl . INDEX . 'clientes/updateUser",';
		$r .= '{"cod_cliente":cod_cliente,"agencia":agencia, "nombre":nombre,"telefono":telefono, "dni":dni, "direccion":direccion, "ruc":ruc, "celular":celular,"id":' . $data[0]->id_client . '},';
		$r .= 'function(data) {';
		$r .= 'hideLoading();';
		$r .= 'alert(data);';
		$r .= '$.fn.colorbox.close();';

		$r .= 'var numRows = 10;';
		$r .= 'showLoading();';
		$r .= '$.post("' . $this->baseurl . INDEX . 'clientes/loadUsers",';
		$r .= '{"limit":"limit 0,"+numRows, "show":numRows, "page":1, "text":""},';
		$r .= 'function(data) {';
		$r .= 'hideLoading();';
		$r .= '$("#content").html(data);';
		$r .= '});';

		$r .= '});';

		$r .= '}';

		$r .= '});';
		$r .= '</script>';

		return $r;
	}


	function nuevo($data)
	{
		$cli = new Table(array("width" => "100%", "class" => "table table-condensed table-hover", "id" => "tablecn", "style" => "width:350px;"));
		$cli->addRow();
		$cli->addCell();
		$cli->addCell();

		$cli->addRow();
		$cli->addCell('RUC');
		$cli->addCell('<input type="text" name="ruc" id="ruc" class="texts" value=""/>');
		$cli->addCell('<a id="btn_datos_sunat" class="btn_search" href="javascript:;">Buscar</a>', array("colspan" => "2", "align" => "center"));

		$cli->addRow();
		$cli->addCell('Raz&oacuten Social *');
		$cli->addCell('<input type="text" name="empresa" id="razonsocial" autocomplete=off class="texts" value=""/>', array("colspan" => "2"));

		$cli->addRow();
		$cli->addCell('Direcci&oacute;n (Empresa) *');
		$cli->addCell('<input type="text" name="direccion" autocomplete=off id="direccion" class="texts" value=""/>', array("colspan" => "2"));

		$cli->addRow();
		$cli->addCell('Tel&eacutefono ');
		$cli->addCell('<input type="text" name="telefono" autocomplete=off id="telefono" class="texts" value=""/>');

		$cli->addRow();
		$cli->addCell('<a id="saveUser" class="btn_send" href="#">Guardar</a>', array("colspan" => "2", "align" => "center"));
		$r = $cli->getTable();


		$r .= '<script type="text/javascript">';

		$r .= '
    //sunat requerimiento
    $("#btn_datos_sunat").click(function() {
        var caracter = $("#ruc").val().length;
        if (caracter == 11) {
            obtener_datos_sunat();
        }else{
            $.prompt("RUC - 11 d铆gitos")
        }
    });
   
function obtener_datos_sunat() {
    ruc = $("#ruc").val();
    $.ajax({
        url: "' . $this->baseurl . INDEX . 'sunat/datos_jossmp",
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
            $.prompt("No hay conexi贸n con SUNAT,vuelva a intentarlo o ingrese manualmente");
            
        },
    });
}  ';

		$r .= '$("#saveUser").click(function(){';

		$r .= 'var direccion = $("#direccion").val();';
		$r .= 'var ruc = $("#ruc").val();';
		$r .= 'var empresa = $("#razonsocial").val();';
		$r .= 'var telefono = $("#telefono").val();';
		$r .= '
					if(ruc.length != 11){
					    $.prompt("Verificar RUC");
					    document.getElementById("ruc").focus();
					    return false;
					}
					if(ruc.length==11 && empresa.length==0){
					    $.prompt("Error en Razon Social  ");
					     return false;
					}
				 else {';

		$r .= 'showLoading();';

		$r .= '$.post("' . $this->baseurl . INDEX . 'proveedores/save",';
		$r .= '{"telefono":telefono,"empresa":empresa,"direccion":direccion, "ruc":ruc},';
		$r .= 'function(data) {';
		$r .= '$.prompt(data);';
		$r .= 'location.href = "' . $this->baseurl . INDEX . 'proveedores"';
		$r .= '});';

		$r .= '}';

		$r .= '});';
		$r .= '</script>';

		return $r;
	}
	function listProveedores($data)
	{
		$tbl = new Table();
		foreach ($data as $row) {
			$tbl->addRow();
			//(id, razonsocial, RUC)
			$tbl->addCell('<a href="javascript:;" onclick="selectItem(' . $row->id . ',\'' . $row->pro_razonsocial . '\',\'' . $row->pro_ruc . '\',\'' . $row->pro_direccion . '\');">' . $row->pro_razonsocial . ' /' . $row->pro_ruc . ' </a>');
		}
		return $tbl->getTable();
	}
}
