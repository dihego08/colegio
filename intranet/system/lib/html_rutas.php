<?php
class html_rutas extends f{
    private $baseurl = "";

    function html_rutas(){
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
                        <span style="float: right; margin-bottom: 10px;" class="btn btn-sm btn-success" data-toggle="modal" data-target="#formulario" id="btn_nuevo" onclick="nuevo_docente();">Nueva Ruta</span>
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Lista de Rutas
                        </h5>
                        <small>
                            <i class="far fa-edit"></i> Aquí podrá ver la información de todas las Rutas
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
                                                <th>Origen</th>
                                                <th>Destino</th>
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
                            <h3 class="modal-title" id="exampleModalLabel">Nueva Ruta</h3>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group" style="width: 100%;">
                                <!--<form id="form_nuevo" action="'. $this->baseurl . INDEX . 'choferes/save"  method="post">-->
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <fieldset>
                                                <legend>Origen</legend>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Departamento</label>
                                                        <select class="form-control" id="departamento">
                                                            <option value="0">SELECCIONE...</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Provincia</label>
                                                        <select class="form-control" id="provincia">
                                                        </select>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <fieldset>
                                                <legend>Destino</legend>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Departamento</label>
                                                        <select class="form-control" id="departamento_2">
                                                            <option value="0">SELECCIONE...</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Provincia</label>
                                                        <select class="form-control" id="provincia_2">
                                                        </select>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12" style="margin-top: 15px;">
                                            <button class="btn btn-success pull-right" id="btn_finalizar">Guardar</button>
                                            <span class="btn btn-danger" type="button" data-dismiss="modal" id="cerrar_formulario_docente" style="margin-left: 10px">
                                                Cancelar
                                            </span>
                                        </div>
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
                    combo_departamento(0);
                    //combo_provincia(0);
                    $("#departamento").on("change", function() {
                        combo_provincia($("#departamento").val());
                    });
                    $("#departamento_2").on("change", function() {
                        combo_provincia_2($("#departamento_2").val());
                    });
                    var table = $(".datatable").DataTable({
                        "ajax": {
                            url: "' . $this->baseurl . INDEX . 'rutas/loadrutas/",
                            "dataSrc": ""
                        },
                        "columns": [{
                            "data": "id"
                        },  {
                            "data": "identificador"
                        }, {
                            "data": "origen"
                        }, {
                            "data": "destino"
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
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar la Ruta <strong>" + rowData["identificador"] + "</strong>?",
                            function() {
                                eliminar(rowData["id"]);
                                alertify.notify("Se elimino la Ruta <strong>" + rowData["identificador"] + "</strong> correctamente.", "custom-black", 4, function() {});
                            },
                            function() {
                                alertify.notify("Se cancelo la <strong>eliminación</strong>.", "custom-black", 4, function() {});
                            }).set("labels", { ok: "Eliminar", cancel: "Cancelar" });
                        } else {
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar la Ruta <strong>" + data["identificador"] + "</strong>?",
                            function() {
                                eliminar(data["id"]);
                                alertify.notify("Se elimino la Ruta <strong>" + data["identificador"] + "</strong> correctamente.", "custom-black", 4, function() {});
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
                function nuevo_docente(){
                    $("#exampleModalLabel").text("Nueva Ruta");
                    //$("#form_nuevo").attr("action", "'. $this->baseurl . INDEX . 'rutas/save");
                    $("#btn_finalizar").text("Guardar");
                    $("#btn_finalizar").attr("onclick", "registrar_ruta();");
                    limpiar_formulario();
                    $("#alerta_pass").attr("hidden", "hidden");
                }
                function eliminar(id) {
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'rutas/eliminar",
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
                function limpiar_formulario(){
                    $("#origen option[value="+0+"]").attr("selected", true);
                    $("#destino option[value="+0+"]").attr("selected", true);
                    //$("#btn_finalizar").removeAttr("onclick");
                    //$("#btn_finalizar").text("Guardar");
                }
                function editar(id){
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'rutas/editar",
                        type: "POST",
                        dataType: "json",
                        data: {
                            "id": id,
                        },
                        success: function(data) {
                            $("#origen option[value="+data.origen+"]").attr("selected", true);
                            $("#destino option[value="+data.destino+"]").attr("selected", true);

                            $("#btn_finalizar").text("Actualizar");
                            $("#btn_finalizar").attr("onclick", "actualizar_ruta("+data.id+");");
                            $("#exampleModalLabel").text("Editar Ruta");
                            $("#alerta_pass").removeAttr("hidden");
                        }
                    });
                }
                $("#cerrar_formulario_docente").click(function(){
                    limpiar_formulario();
                });
                function registrar_ruta(){
                    $.post("'. $this->baseurl . INDEX . 'rutas/save", {
                        origen: $("#provincia option:selected" ).text(),
                        destino: $("#provincia_2 option:selected" ).text(),
                        identificador: $("#provincia option:selected" ).text() + "-" + $("#provincia_2 option:selected" ).text()
                    }, function(response){
                        var obj = JSON.parse(response);
                        if(obj.Result == "OK"){
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            alertify.notify("<strong>Ruta</strong> Agregada Correctamente.", "custom-black", 3, function() {});
                            $("#cerrar_formulario_docente").click();
                        }else{
                            alertify.notify("<strong>Algo ha salido mal!!!</strong>", "custom-black", 3, function() {});
                        }
                    });
                }
                function actualizar_ruta(id){
                    $.post("'. $this->baseurl . INDEX . 'rutas/editarBD", {
                        origen: $("#provincia option:selected" ).text(),
                        destino: $("#provincia_2 option:selected" ).text(),
                        identificador: $("#provincia option:selected" ).text() + "-" + $("#provincia_2 option:selected" ).text(),
                        id: id
                    }, function(response){
                        var obj = JSON.parse(response);
                        if(obj.Result == "OK"){
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            alertify.notify("<strong>Ruta</strong> Modificada Correctamente.", "custom-black", 3, function() {});
                            $("#cerrar_formulario_docente").click();
                        }else{
                            alertify.notify("<strong>Algo ha salido mal!!!</strong>", "custom-black", 3, function() {});
                        }
                    });
                }
                function combo_departamento(de){
                    $.get("'. $this->baseurl . INDEX . 'rutas/combo_departamento", function(data) {
                        var obj = JSON.parse(data);
                        $.each(obj.Records, function(index, val) {
                            if (val.idDepa == de) {
                                $("#departamento").append("<option value="+val.idDepa+" selected>"+val.departamento+"</option>");
                                $("#departamento_2").append("<option value="+val.idDepa+" selected>"+val.departamento+"</option>");
                            }else{
                                $("#departamento").append("<option value="+val.idDepa+">"+val.departamento+"</option>");
                                $("#departamento_2").append("<option value="+val.idDepa+">"+val.departamento+"</option>");
                            }
                        });
                    });
                }
                function combo_provincia(idDepa){
                    $.post("'. $this->baseurl . INDEX . 'rutas/combo_provincia", {
                        idDepa: idDepa
                    }, function(data) {
                        var obj = JSON.parse(data);
                        $("#provincia").empty();
                        $("#provincia").append(`<option value="0">SELECCIONE ...</option>`);
                        $.each(obj.Records, function(index, val) {
                            if (val.idProv == idDepa) {
                                $("#provincia").append("<option value="+val.idProv+" selected>"+val.provincia+"</option>");
                            }else{
                                $("#provincia").append("<option value="+val.idProv+">"+val.provincia+"</option>");  
                            }
                        });
                    });
                }
                function combo_provincia_2(idDepa){
                    $.post("'. $this->baseurl . INDEX . 'rutas/combo_provincia", {
                        idDepa: idDepa
                    }, function(data) {
                        var obj = JSON.parse(data);
                        $("#provincia_2").empty();
                        $("#provincia_2").append(`<option value="0">SELECCIONE ...</option>`);
                        $.each(obj.Records, function(index, val) {
                            if (val.idProv == idDepa) {
                                $("#provincia_2").append("<option value="+val.idProv+" selected>"+val.provincia+"</option>");
                            }else{
                                $("#provincia_2").append("<option value="+val.idProv+">"+val.provincia+"</option>");  
                            }
                        });
                    });
                }
            </script>';     
            return $r;
        }
    }
?>
