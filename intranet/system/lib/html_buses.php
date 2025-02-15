<?php
class html_buses extends f{
	private $baseurl = "";

	function html_buses(){
		$this->load()->lib_html("Table", false);
		$this->baseurl = BASEURL;
	}
    function container(){
        $r = '<script>
                function abrir_modal(b,a){alertify.dialog(b,function(){return{main:function(c){this.setContent(c);},setup:function(){return{focus:{element:function(){return this.elements.body.querySelector(this.get("selector"));
                },select:true},options:{basic:false,title:a,maximizable:false,resizable:false,padding:true,modal:true,transition:false,}};},settings:{selector:undefined}};
                });}
            </script>
            <style>
                fieldset {
                    width: 100%;
                    border: 1px solid #ddd !important;
                    margin: 0;
                    xmin-width: 0;
                    padding: 10px;       
                    position: relative;
                    border-radius:4px;
                    background-color:#f5f5f5;
                    padding-left:10px!important;
                }   
                legend{
                    font-size:14px;
                    font-weight:bold;
                    margin-bottom: 0px; 
                    width: 35%; 
                    border: 1px solid #ddd;
                    border-radius: 4px; 
                    padding: 5px 5px 5px 10px; 
                    background-color: #ffffff;
                }
            </style>
            <div class="container-fluid" style="margin-top: 56px;">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <span style="float: right; margin-bottom: 10px;" class="btn btn-sm btn-success" data-toggle="modal" data-target="#formulario" id="btn_nuevo" onclick="nuevo_bus();">Nuevo Bus</span>
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Lista de Buses
                        </h5>
                        <small>
                            <i class="far fa-edit"></i> Aquí podrá ver la información de todos los Buses registrados
                        </small>
                        <hr>         
                        <div class="container" style="max-width: 100%;">
                            <div class="row">
                                <div class="col-12" >
                                    <table  class="datatable table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Placa</th>
                                                <th>Modelo</th>
                                                <th>Asientos</th>
                                                <th>Pisos</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!----------------------------------------------------------------------->
            <div class="modal fade" id="formulario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="max-width: 80%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLabel">Registrar Bus</h3>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group" style="width: 100%;">
                                <!--<form id="form_nuevo" action="'. $this->baseurl . INDEX . 'buses/save"  method="post">-->
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <label>Placa</label>
                                            <input id="placa" class="form-control" name="placa" type="text"/>
                                            <input type="hidden" id="id_n" name="id_n">
                                            <input type="hidden" id="placa_borrar" name="placa_borrar">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Modelo</label>
                                            <input id="modelo" class="form-control" name="modelo" type="text"/>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <label>N° Pisos</label><br>
                                            <!-- Default inline 1-->
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input" id="defaultInline1" name="pisos" value="1" id="p_1">
                                                <label class="custom-control-label" for="defaultInline1">1 Piso</label>
                                            </div>
                                            <!-- Default inline 2-->
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input" id="defaultInline2" name="pisos" value="2" id="p_2">
                                                <label class="custom-control-label" for="defaultInline2">2 Pisos</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Total de Asientos</label>
                                            <input type="text" class="form-control" name="t_asientos" id="t_asientos">
                                        </div>
                                    </div>
                                    <div class="form-row" style="margin-top: 10px; margin-bottom: 10px;" id="asientos">
                                        <fieldset>
                                            <legend style="white-space: nowrap; width: auto;">
                                                Cantidad de Asientos por Piso
                                            </legend>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Piso 1</label>
                                                    <input type="text" class="form-control" id="n_p_1" name="n_p_1">
                                                </div>
                                                <div class="col-md-6 remover" id="s_2" hidden>
                                                    <label>Piso 2</label>
                                                    <input type="text" class="form-control" id="n_p_2" name="n_p_2">
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="form-row" style="margin-top: 10px; margin-bottom: 10px;">
                                        <div id="div_padre" style="width: 100%;">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <button type="submit" class="btn btn-success pull-right" id="btn_finalizar">Guardar</button>
                                        <span class="btn btn-danger" type="button" data-dismiss="modal" id="cerrar_formulario_docente" style="margin-left: 10px">
                                            Cancelar
                                        </span>
                                    </div>
                                <!--</form>-->
                            </div>
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>
            <!----------------------------------------------------------------------->
            <script>
                $(document).ready(function() {
                    $("input[name=pisos]").on("change", function() {
                        if($("input[name=pisos]:checked").val() == 1){
                            $("#asientos").removeAttr("hidden");
                            $("#s_2").attr("hidden", true);
                        }else{
                            $("#asientos").removeAttr("hidden");
                            $("#s_2").removeAttr("hidden");
                        }
                    });
                    var table = $(".datatable").DataTable({
                        "ajax": {
                            url: "' . $this->baseurl . INDEX . 'buses/loadbuses/",
                            "dataSrc": ""
                        },
                        "columns": [{
                            "data": "id"
                        },  {
                            "data": "placa"
                        }, {
                            "data": "modelo"
                        }, {
                            "data": "t_asientos"
                        }, {
                            "data": "pisos"
                        }, {
                            "defaultContent": "<button id=\"btn_editar\" data-toggle=\"modal\" data-target=\"#formulario\" class=\"btn btn-info btn-sm\" ><i class=\"fas fa-pencil-alt\"></i></button><button id=\"btn_eliminar\" class=\"btn btn-danger btn-sm\"><i class=\"far fa-trash-alt\"></i></button>"
                        }, ],
                        "language": {
                            "url": "'.$this->baseurl.'includes/datatables/Spanish.json"
                        },
                        "lengthMenu": [
                            [10, 15, 20, -1],
                            [10, 15, 20, "All"]
                        ]
                    });
                    $(".datatable tbody").on("click", "#btn_eliminar", function() {
                        var data = table.row($(this).parents("tr")).data();
                        if (data == undefined) {
                            var selected_row = $(this).parents("tr");
                            if (selected_row.hasClass("child")) {
                                selected_row = selected_row.prev();
                            }
                            var rowData = $(".datatable").DataTable().row(selected_row).data();
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el Bus <strong>" + rowData["placa"] + "</strong>?",
                            function() {
                                eliminar(rowData["id"]);
                                alertify.notify("Se elimino el Bus <strong>" + rowData["placa"] + "</strong> correctamente.", "custom-black", 4, function() {});
                            },
                            function() {
                                alertify.notify("Se cancelo la <strong>eliminación</strong>.", "custom-black", 4, function() {});
                            }).set("labels", { ok: "Eliminar", cancel: "Cancelar" });
                        } else {
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el Bus <strong>" + data["placa"] + "</strong>?",
                            function() {
                                eliminar(data["id"]);
                                alertify.notify("Se elimino el Bus <strong>" + data["placa"] + "</strong> correctamente.", "custom-black", 4, function() {});
                            },
                            function() {
                                alertify.notify("Se cancelo la <strong>eliminación</strong>.", "custom-black", 4, function() {});
                            }).set("labels", { ok: "Eliminar", cancel: "Cancelar" });
                        }
                    });
                    $(".datatable tbody").on("click", "#btn_editar", function() {
                        var data = table.row($(this).parents("tr")).data();
                        if (data == undefined) {
                            var selected_row = $(this).parents("tr");
                            if (selected_row.hasClass("child")) {
                                selected_row = selected_row.prev();
                            }
                            var rowData = $(".datatable").DataTable().row(selected_row).data();
                            editar(rowData["id"], rowData["placa"]);
                        } else {
                            editar(data["id"], data["placa"]);
                        }
                    });
                });
                function nuevo_bus(){
                    $("#exampleModalLabel").text("Nuevo Bus");
                    //$("#form_nuevo").attr("action", "'. $this->baseurl . INDEX . 'buses/save");
                    $("#btn_finalizar").text("Guardar");
                    $("#btn_finalizar").attr("onclick", "registrar_bus();");
                    limpiar_formulario();
                }
                function eliminar(id) {
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'buses/eliminar",
                        type: "POST",
                        dataType: "html",
                        data: {
                            "id": id
                        },
                        success: function(data) {
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                        }
                    });
                }
                function limpiar_formulario(){
                    $("#placa").val("");
                    $("#modelo").val("");
                    $("#t_asientos").val("");
                    $("#n_p_1").val("");
                    $("#n_p_2").val("");
                    $("#defaultInline1").prop("checked",true);
                    $("#s_2").attr("hidden", true);
                    $("#btn_finalizar").text("Guardar");
                }
                function editar(id, placa){
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'buses/editar",
                        type: "POST",
                        dataType: "json",
                        data: {
                            "id": id,
                            "placa": placa,
                        },
                        success: function(data) {
                            $("#placa").val(data.placa);
                            $("#modelo").val(data.modelo);
                            if(data.pisos == 1){
                                $("#defaultInline1").prop("checked",true);
                            }else{
                                if(data.pisos == 2){
                                    $("#defaultInline2").prop("checked",true);
                                }
                            }
                            $("#placa_borrar").val(data.placa);
                            $("#t_asientos").val(data.t_asientos);
                            $("#btn_finalizar").text("Actualizar");
                            $("#btn_finalizar").attr("onclick", "actualizar_bus("+data.id+");");
                            
                            if(data.pisos == 1){
                                $("#asientos").removeAttr("hidden");
                                $("#s_2").attr("hidden", true);
                            }else{
                                $("#asientos").removeAttr("hidden");
                                $("#s_2").removeAttr("hidden");
                            }

                            $("#n_p_1").val(data.p_1_asientos);
                            $("#n_p_2").val(data.p_2_asientos);

                            $("#exampleModalLabel").text("Editar Bus");
                        }
                    });
                }
                $("#cerrar_formulario_docente").click(function(){
                    limpiar_formulario();
                });
                function registrar_bus(){
                    $.post("'. $this->baseurl . INDEX . 'buses/save", {
                        placa: $("#placa").val(),
                        modelo: $("#modelo").val(),
                        pisos: $("input[name=pisos]:checked").val(),
                        t_asientos: $("#t_asientos").val(),
                        p_1_asientos: $("#n_p_1").val(),
                        p_2_asientos: $("#n_p_2").val()
                    }, function(response){
                        table = $(".datatable").DataTable();
                        table.ajax.reload();
                        var obj = JSON.parse(response);
                        if(obj.Result == "OK"){
                            alertify.notify("<strong>Bus</strong> Agregado correctamente.", "custom-black", 3, function() {});
                            $("#cerrar_formulario_docente").click();
                            $("#cerrar_alerta").click();
                        }else{
                            alertify.notify("<strong>Algo ha salido mal!!!</strong>", "custom-black", 3, function() {});
                        }
                    });
                }
                function actualizar_bus(id){
                    $.post("'. $this->baseurl . INDEX . 'buses/editarBD", {
                        placa: $("#placa").val(),
                        modelo: $("#modelo").val(),
                        pisos: $("input[name=pisos]:checked").val(),
                        t_asientos: $("#t_asientos").val(),
                        id: id,
                        p_1_asientos: $("#n_p_1").val(),
                        p_2_asientos: $("#n_p_2").val(),
                        placa_borrar: $("#placa_borrar").val()
                    }, function(response){
                        table = $(".datatable").DataTable();
                        table.ajax.reload();
                        var obj = JSON.parse(response);
                        if(obj.Result == "OK"){
                            alertify.notify("<strong>Bus</strong> modificado correctamente.", "custom-black", 3, function() {});
                            $("#cerrar_formulario_docente").click();
                            $("#cerrar_alerta").click();
                        }else{
                            alertify.notify("<strong>Algo ha salido mal!!!</strong>", "custom-black", 3, function() {});
                        }
                    });
                }
            </script>';     
            return $r;
        }
    }
?>
