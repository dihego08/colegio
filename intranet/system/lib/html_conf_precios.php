<?php
class html_conf_precios extends f{
	private $baseurl = "";

	function html_conf_precios(){
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
                .texto{
                    text-align: center;
                    font-size: 25px;
                    font-weight: bold;
                    color: #00009F;
                }
                .td_a{
                    width: 65px;
                    height: 65px;
                }
                .td_a > span{
                    width: 100%;
                    height: 100%;
                }
            </style>
            <div class="container-fluid" style="margin-top: 56px;">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Venta de Boletos
                        </h5>
                        <hr>         
                        <div class="container" style="max-width: 100%;">
                            <fieldset style="margin-top: 10px;">
                                <legend>
                                    Detalle Salida
                                </legend>
                                <div class="row col-md-12">
                                    <div class="col-md-4">
                                        <label>Tipo de Asiento</label>
                                        <input type="text" id="t_asiento" name="t_asiento" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Color</label>
                                        <input type="color" id="color" name="color" class="form-control" style="height: 38px;">
                                    </div>
                                    <div class="col-md-12" style="margin-top: 15px; text-align: right;">
                                        <span class="btn btn-success" onclick="registrar_conf_precios();" id="span_guardar">Guardar</span>
                                    </div>
                                    <!--<div class="row col-md-2">
                                        <button class="btn btn-info">+</button>
                                        <button class="btn btn-info">-</button>
                                    </div>-->
                                </div>
                            </fieldset>
                            <hr>
                            <div class="row" style="margin-top: 25px;">
                                <div class="col-md-12">
                                    <table  class="datatable table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Tipo</th>
                                                <th>Color</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <hr>
                            <div class="row col-md-12" style="margin-top: 25px;">
                                <button class="btn btn-primary" style="margin-right: 10px; margin-left: auto;">Guardar</button>
                                <button class="btn btn-danger">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                            url: "' . $this->baseurl . INDEX . 'conf_precios/loadprecios/",
                            "dataSrc": ""
                        },
                        "columns": [{
                            "data": "id"
                        },  {
                            "data": "tipo"
                        }, {
                            "mData": "background",
                            "mRender": function (data, type, row) {
                                return "<span class=\"btn\" style=\"background-color:"+data+";height: 20px; width: 65px;\"></span>";
                            }
                        }, {
                            "defaultContent": "<button id=\"btn_editar\" data-toggle=\"modal\" data-target=\"#formulario\" class=\"btn btn-info btn-sm\" ><i class=\"fas fa-pencil-alt\"></i></button>"
                        }, {
                            "defaultContent": "<button id=\"btn_eliminar\" class=\"btn btn-danger btn-sm\"><i class=\"far fa-trash-alt\"></i></button>"
                        },],
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
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el Precio <strong>" + rowData["placa"] + "</strong>?",
                            function() {
                                eliminar(rowData["id"]);
                                alertify.notify("Se elimino el Precio <strong>" + rowData["placa"] + "</strong> correctamente.", "custom-black", 4, function() {});
                            },
                            function() {
                                alertify.notify("Se cancelo la <strong>eliminación</strong>.", "custom-black", 4, function() {});
                            }).set("labels", { ok: "Eliminar", cancel: "Cancelar" });
                        } else {
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el Precio <strong>" + data["placa"] + "</strong>?",
                            function() {
                                eliminar(data["id"]);
                                alertify.notify("Se elimino el Precio <strong>" + data["placa"] + "</strong> correctamente.", "custom-black", 4, function() {});
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
                            editar(rowData["id"]);
                        } else {
                            editar(data["id"]);
                        }
                    });
                });
                function eliminar(id) {
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'conf_precios/eliminar",
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
                    $("#t_asiento").val("");
                }
                function editar(id){
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'conf_precios/editar",
                        type: "POST",
                        dataType: "json",
                        data: {
                            "id": id
                        },
                        success: function(data) {
                            $("#t_asiento").val(data.tipo);
                            $("#color").val(data.background);
                            $("#t_asiento").focus();
                            $("#span_guardar").removeAttr("onclick");
                            $("#span_guardar").attr("onclick", "actualizar_conf_precios("+id+");");
                        }
                    });
                }
                function registrar_conf_precios(){
                    $.post("'. $this->baseurl . INDEX . 'conf_precios/save", {
                        tipo: $("#t_asiento").val(),
                        background: $("#color").val(),
                        border: $("#color").val()
                    }, function(response){
                        table = $(".datatable").DataTable();
                        table.ajax.reload();
                        var obj = JSON.parse(response);
                        if(obj.Result == "OK"){
                            alertify.notify("<strong>Precio</strong> Agregado correctamente.", "custom-black", 3, function() {});
                            limpiar_formulario();
                        }else{
                            alertify.notify("<strong>Algo ha salido mal!!!</strong>", "custom-black", 3, function() {});
                        }
                    });
                }
                function actualizar_conf_precios(id){
                    $.post("'. $this->baseurl . INDEX . 'conf_precios/editarBD", {
                        id: id,
                        tipo: $("#t_asiento").val(),
                        background: $("#color").val(),
                        border: $("#color").val()
                    }, function(response){
                        table = $(".datatable").DataTable();
                        table.ajax.reload();
                        var obj = JSON.parse(response);
                        if(obj.Result == "OK"){
                            alertify.notify("<strong>Precio</strong> modificado correctamente.", "custom-black", 3, function() {});
                            limpiar_formulario();
                            $("#span_guardar").removeAttr("onclick");
                            $("#span_guardar").attr("onclick", "registrar_conf_precios();");
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
