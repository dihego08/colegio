<?php
class html_salidas extends f{
    private $baseurl = "";

    function html_salidas(){
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
                .td_a{
                    width: 50px;
                    height: 50px;
                }
                .td_a > span{
                    width: 100%;
                    height: 100%;
                }
            </style>
            <div class="container-fluid" style="margin-top: 56px;">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <span style="float: right; margin-bottom: 10px;" class="btn btn-sm btn-success" data-toggle="modal" data-target="#formulario" id="btn_nuevo" onclick="nueva_salida();">Nueva Salida</span>
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Lista de Salidas
                        </h5>
                        <small>
                            <i class="far fa-edit"></i> Aquí podrá ver la información de todas las Salidas
                        </small>
                        <hr>         
                        <div class="container">
                            <div class="row">
                                <div class="col-12" >
                                    <table  class="datatable table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr> 
                                                <th>Id</th>
                                                <th>Ruta</th>
                                                <th>Fecha</th>
                                                <th>Hora Salida</th>
                                                <th>Bus</th>
                                                <th>Conductor</th>
                                                <th>Editar</th>
                                                <th>Eliminar</th>
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
                            <h3 class="modal-title" id="exampleModalLabel">Registrar Salida</h3>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group" style="width: 100%;">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <label>Ruta</label>
                                        <input type="text" class="form-control ui-autocomplete-input" name="ruta_autocomplete" id="ruta_autocomplete">
                                        <input type="hidden" id="id_ruta" name="id_ruta">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Bus</label>
                                        <input type="text" class="form-control ui-autocomplete-input" name="bus_autocomplete" id="bus_autocomplete">
                                        <input type="hidden" id="id_bus" name="id_bus">
                                        <input type="hidden" id="placa_bus" name="placa_bus">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <label>Conductor</label>
                                        <input type="text" class="form-control ui-autocomplete-input" name="conductor_autocomplete" id="conductor_autocomplete">
                                        <input type="hidden" id="id_conductor" name="id_conductor">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Copiloto</label>
                                        <input type="text" class="form-control ui-autocomplete-input" name="copiloto_autocomplete" id="copiloto_autocomplete">
                                        <input type="hidden" id="id_copiloto" name="id_copiloto">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <label>Fecha Salida</label>
                                        <input type="text" class="form-control datepicker" name="fecha" id="fecha">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Hora Salida</label>
                                        <input type="text" class="form-control" name="hora_salida" id="hora_salida">
                                    </div>
                                </div>
                                <div class="form-row" style="padding: 10px;">
                                    <h3>Resumen</h3>
                                    <hr>
                                    <div id="div_detalles" style="width: 100%;">
                                        <table class="table">
                                            <td id="td_ruta"></td>
                                            <td id="td_bus"></td>
                                            <td id="td_conductor"></td>
                                            <td id="td_copiloto"></td>
                                        </table>
                                    </div>
                                    <hr>
                                </div>
                                <div class="form-row" style="padding: 10px;">
                                    <h3>Precios</h3>
                                    <hr>
                                    <div id="div_precios" class="row" style="width: 100%;">
                                        
                                    </div>
                                    <hr>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12" style="margin-top: 15px;">
                                        <button class="btn btn-success pull-right" id="btn_finalizar">Guardar</button>
                                        <span class="btn btn-danger" type="button" data-dismiss="modal" id="cerrar_formulario_docente" style="margin-left: 10px">
                                            Cancelar
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/jquery.datetimepicker.full.min.js"></script>
            <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/build/jquery.datetimepicker.min.css" rel="stylesheet"/>
            <!----------------------------------------------------------------------->
            <script>
                var tipos = "0";
                //var precios = [];  
                function llenar_precios(){
                    $.post("' . $this->baseurl . INDEX . 'conf_precios/loadprecios/", function(responseText){
                        var obj = JSON.parse(responseText);
                        $.each(obj, function(index, val){
                            $("#div_precios").append(`<div class="col-md-6">
                                <label>`+val.tipo+`</label>
                                <input type="text" class="form-control" id="t_p_`+val.id+`" name="t_p_`+val.id+`">
                            </div>`);
                            tipos = tipos + "," + val.id;
                        });
                    });
                }
                $(document).ready(function() {
                    llenar_precios();
                    $(".datepicker").datetimepicker({
                        format: "Y-m-d",
                        timepicker:false
                    });
                    $.datetimepicker.setLocale("es");
                    $("#ruta_autocomplete").autocomplete({
                        source: "' . $this->baseurl . INDEX . 'rutas/get_ruta/",
                        minLength: 2,
                        focus: true,
                        select: function(event, ui) {
                            $.get("' . $this->baseurl . INDEX . 'rutas/get_one/", {
                                id_ruta: ui.item.id
                            }, function(responseText){
                                var obj = JSON.parse(responseText);
                                $("#id_ruta").val(obj.id);
                                $("#td_ruta").empty();
                                $("#td_ruta").append(`<div class="alert alert-info alert-dismissible fade show" role="alert">
                                        <b>` + obj.identificador + `
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="eliminar_ruta();" id="cerrar_alerta">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>`);
                            });
                        }
                    });
                    $("#bus_autocomplete").autocomplete({
                        source: "' . $this->baseurl . INDEX . 'buses/get_bus/",
                        minLength: 2,
                        focus: true,
                        select: function(event, ui) {
                            $.get("' . $this->baseurl . INDEX . 'buses/get_one/", {
                                id_bus: ui.item.id
                            }, function(responseText){
                                var obj = JSON.parse(responseText);
                                $("#id_bus").val(obj.id);
                                $("#placa_bus").val(obj.placa);
                                $("#td_bus").empty();
                                $("#td_bus").append(`<div class="alert alert-info alert-dismissible fade show" role="alert">
                                        <b>` + obj.placa + ` - ` + obj.modelo + `
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="eliminar_bus();" id="cerrar_alerta">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>`);
                            });
                        }
                    });
                    $("#conductor_autocomplete").autocomplete({
                        source: "' . $this->baseurl . INDEX . 'choferes/get_chofer/",
                        minLength: 2,
                        focus: true,
                        select: function(event, ui) {
                            $.get("' . $this->baseurl . INDEX . 'choferes/get_one/", {
                                id_conductor: ui.item.id
                            }, function(responseText){
                                var obj = JSON.parse(responseText);
                                $("#id_conductor").val(obj.id);
                                $("#td_conductor").empty();
                                $("#td_conductor").append(`<div class="alert alert-info alert-dismissible fade show" role="alert">
                                        <b>` + obj.apellidos + `, ` + obj.nombres + `
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="eliminar_conductor();" id="cerrar_alerta">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>`);
                            });
                        }
                    });
                    $("#copiloto_autocomplete").autocomplete({
                        source: "' . $this->baseurl . INDEX . 'choferes/get_chofer/",
                        minLength: 2,
                        focus: true,
                        select: function(event, ui) {
                            $.get("' . $this->baseurl . INDEX . 'choferes/get_one/", {
                                id_conductor: ui.item.id
                            }, function(responseText){
                                var obj = JSON.parse(responseText);
                                $("#id_copiloto").val(obj.id);
                                $("#td_copiloto").empty();
                                $("#td_copiloto").append(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <b>` + obj.apellidos + `, ` + obj.nombres + `
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="eliminar_copiloto();" id="cerrar_alerta">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>`);
                            });
                        }
                    });
                    var table = $(".datatable").DataTable({
                        "ajax": {
                            url: "' . $this->baseurl . INDEX . 'salidas/loadsalidas/",
                            "dataSrc": ""
                        },
                        "columns": [{
                            "data": "id"
                        },  {
                            "data": "identificador"
                        }, {
                            "data": "fecha"
                        }, {
                            "data": "hora_salida"
                        }, {
                            "data": "placa"
                        }, {
                            "data": "apellidos"
                        }, {
                            "defaultContent": "<button id=\"btn_editar\" data-toggle=\"modal\" data-target=\"#formulario\" class=\"btn btn-info btn-sm\" ><i class=\"fas fa-pencil-alt\"></i></button>"
                        }, {
                            "defaultContent": "<button id=\"btn_eliminar\" class=\"btn btn-danger btn-sm\"><i class=\"far fa-trash-alt\"></i></button>"
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
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar la Salida <strong>" + rowData["identificador"] + "</strong>?",
                            function() {
                                eliminar(rowData["id"]);
                                alertify.notify("Se elimino la Salida <strong>" + rowData["identificador"] + "</strong> correctamente.", "custom-black", 4, function() {});
                            },
                            function() {
                                alertify.notify("Se cancelo la <strong>eliminación</strong>.", "custom-black", 4, function() {});
                            }).set("labels", { ok: "Eliminar", cancel: "Cancelar" });
                        } else {
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar la Salida <strong>" + data["identificador"] + "</strong>?",
                            function() {
                                eliminar(data["id"]);
                                alertify.notify("Se elimino la Salida <strong>" + data["identificador"] + "</strong> correctamente.", "custom-black", 4, function() {});
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
                function nueva_salida(){
                    $("#exampleModalLabel").text("Nueva Salida");
                    //$("#form_nuevo").attr("action", "'. $this->baseurl . INDEX . 'salidas/save");
                    $("#btn_finalizar").text("Guardar");
                    $("#btn_finalizar").attr("onclick", "registrar_salida();");
                    limpiar_formulario();
                    $("#alerta_pass").attr("hidden", "hidden");
                }
                function eliminar(id) {
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'salidas/eliminar",
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
                function eliminar_ruta(){
                    $("#id_ruta").val("");
                }
                function eliminar_bus(){
                    $("#id_bus").val("");
                }
                function eliminar_conductor(){
                    $("#id_conductor").val("");
                }
                function eliminar_copiloto(){
                    $("#id_copiloto").val("");
                }
                function limpiar_formulario(){
                    $("#origen option[value="+0+"]").attr("selected", true);
                    $("#destino option[value="+0+"]").attr("selected", true);
                }
                function editar(id){
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'salidas/editar",
                        type: "POST",
                        dataType: "json",
                        data: {
                            "id": id,
                        },
                        success: function(data) {
                            $("#hora_salida").val(data[0].hora_salida);
                            $("#fecha").val(data[0].fecha);

                            $("#id_copiloto").val(data[0].id_conductor_2);
                            $("#td_copiloto").append(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <b>` + data[0].conductor_2 + `
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="eliminar_copiloto();" id="cerrar_alerta">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>`);

                            $("#id_ruta").val(data[0].id_ruta);
                            $("#td_ruta").append(`<div class="alert alert-info alert-dismissible fade show" role="alert">
                                    <b>` + data[0].identificador + `
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="eliminar_ruta();" id="cerrar_alerta">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>`);
                            $("#id_bus").val(data[0].id_bus);
                            $("#td_bus").append(`<div class="alert alert-info alert-dismissible fade show" role="alert">
                                    <b>` + data[0].placa + ` - ` + data[0].modelo + `
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="eliminar_bus();" id="cerrar_alerta">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>`);
                            $("#id_conductor").val(data[0].id_conductor_1);
                            $("#td_conductor").append(`<div class="alert alert-info alert-dismissible fade show" role="alert">
                                    <b>` + data[0].conductor_1 + `
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="eliminar_conductor();" id="cerrar_alerta">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>`);

                            $("#btn_finalizar").text("Actualizar");
                            $("#btn_finalizar").attr("onclick", "actualizar_ruta("+data[0].id+");");
                            $("#exampleModalLabel").text("Editar Salida");
                            $("#alerta_pass").removeAttr("hidden");
                        }
                    });
                }
                $("#cerrar_formulario_docente").click(function(){
                    limpiar_formulario();
                });
                function registrar_salida(){
                    var precios = {};
                    /*var obj = {
                        key1: value1,
                        key2: value2
                    };*/
                    var auz = tipos.split(",");
                    for(var i = 1; i < auz.length; i++){
                        precios[auz[i]] = $("#t_p_"+auz[i]).val();
                    }
                    $.post("'. $this->baseurl . INDEX . 'salidas/save", {
                        id_ruta: $("#id_ruta").val(),
                        fecha: $("#fecha").val(),
                        hora_salida: $("#hora_salida").val(),
                        id_bus: $("#id_bus").val(),
                        id_conductor_1: $("#id_conductor").val(),
                        id_conductor_2: $("#id_copiloto").val(),
                        placa: $("#placa_bus").val(),
                        precios: precios

                    }, function(response){
                        var obj = JSON.parse(response);
                        if(obj.Result == "OK"){
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            alertify.notify("<strong>Salida</strong> Agregada Correctamente.", "custom-black", 3, function() {});
                            $("#cerrar_formulario_docente").click();
                        }else{
                            alertify.notify("<strong>Algo ha salido mal!!!</strong>", "custom-black", 3, function() {});
                        }
                    });
                }
                function actualizar_ruta(id){
                    $.post("'. $this->baseurl . INDEX . 'salidas/editarBD", {
                        id_ruta: $("#id_ruta").val(),
                        fecha: $("#fecha").val(),
                        hora_salida: $("#hora_salida").val(),
                        id_bus: $("#id_bus").val(),
                        id_conductor_1: $("#id_conductor").val(),
                        id_conductor_2: $("#id_copiloto").val(),
                        id: id
                    }, function(response){
                        var obj = JSON.parse(response);
                        if(obj.Result == "OK"){
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            alertify.notify("<strong>Salida</strong> Modificada Correctamente.", "custom-black", 3, function() {});
                            $("#cerrar_formulario_docente").click();
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
