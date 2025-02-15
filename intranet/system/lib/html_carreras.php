<?php
class html_carreras extends f{
    private $baseurl = "";

    function html_carreras(){
        $this->load()->lib_html("Table", false);
        $this->baseurl = BASEURL;
    }
    function container(){
        $r = '<script>
                function abrir_modal(b,a){alertify.dialog(b,function(){return{main:function(c){this.setContent(c);},setup:function(){return{focus:{element:function(){return this.elements.body.querySelector(this.get("selector"));
                },select:true},options:{basic:false,title:a,maximizable:false,resizable:false,padding:true,modal:true,transition:false,}};},settings:{selector:undefined}};
                });}
            </script>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <span style="float: right; margin-bottom: 10px;" class="btn btn-sm btn-success" data-toggle="modal" data-target="#formulario" id="btn_nuevo" onclick="nuevo_aula();">Nueva Carrera</span>
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Lista de Carreras
                        </h5>
                        <small>
                            <i class="fa fa-edit"></i> Aquí podrá ver toda la información de todos los Carreras
                        </small>
                        <hr>         
                        <div class="container">
                            <div class="row">
                                <div class="col-12" >
                                    <table  class="datatable table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Carrera</th>
                                                <th>Área</th>
                                                <th>Universidad</th>
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
                            <h3 class="modal-title" id="exampleModalLabel">Nueva Aula</h3>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group" style="width: 100%;">
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <label>Carrera</label>
                                            <input id="carrera" class="form-control" name="carrera" type="text"/>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <label>Universidad</label>
                                            <select name="" id="id_universidad" class="form-control">
                                                <option value="0">SELECCIONA...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Área</label>
                                            <select name="" id="id_area" class="form-control">
                                                <option value="0">SELECCIONA...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12" style="margin-top: 15px;">
                                            <button type="submit" class="btn btn-success pull-right" id="btn_finalizar">Guardar</button>
                                            <span class="btn btn-danger" type="button" data-dismiss="modal" id="cerrar_formulario_aula" style="margin-left: 10px">
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
            <!----------------------------------------------------------------------->
            <script>
                $(document).ready(function() {

                    $( ".datepicker" ).datepicker();
                    llenar_areas();
                    llenar_universidades();
                    var table = $(".datatable").DataTable({
                        "ajax": {
                            url: "' . $this->baseurl . INDEX . 'carreras/loadcarreras/",
                            "dataSrc": ""
                        },
                        "columns": [{
                            "data": "id"
                        },  {
                            "data": "carrera"
                        },  {
                            "data": "area"
                        },  {
                            "data": "universidad"
                        }, {
                            "defaultContent": "<button id=\"btn_editar\" data-toggle=\"modal\" data-target=\"#formulario\" class=\"w-100 mb-1 btn btn-warning btn-sm\" style=\"display: block;\"><i class=\"fa fa-pencil\"></i></button>" + "<button id=\"btn_eliminar\" class=\"btn btn-danger btn-sm w-100\" style=\"display: block;\"><i class=\"fa fa-trash\"></i></button>"
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
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar la Carrera <strong>" + rowData["carrera"] + "</strong>?",
                            function() {
                                eliminar(rowData["id"]);
                                alertify.notify("Se elimino la Carrera <strong>" + rowData["carrera"] + "</strong> correctamente.", "custom-black", 4, function() {});
                            },
                            function() {
                                alertify.notify("Se cancelo la <strong>eliminación</strong>.", "custom-black", 4, function() {});
                            }).set("labels", { ok: "Eliminar", cancel: "Cancelar" });
                        } else {
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar la Carrera <strong>" + data["carrera"] + "</strong>?",
                            function() {
                                eliminar(data["id"]);
                                alertify.notify("Se elimino la Carrera <strong>" + data["carrera"] + "</strong> correctamente.", "custom-black", 4, function() {});
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
                function llenar_areas(){
                    $.post("'. $this->baseurl . INDEX . 'areas/loadareas", function(data){
                        var obj = JSON.parse(data);
                        $.each(obj, function(index, val){
                            $("#id_area").append(`<option value="`+val.id+`">`+val.area+`</option>`);
                        })
                    });
                }
                function llenar_universidades(){
                    $.post("'. $this->baseurl . INDEX . 'universidades/loaduniversidades", function(data){
                        var obj = JSON.parse(data);
                        $.each(obj, function(index, val){
                            $("#id_universidad").append(`<option value="`+val.id+`">`+val.universidad+`</option>`);
                        })
                    });
                }
                function nuevo_aula(){
                    $("#exampleModalLabel").text("Nueva Carrera");
                    
                    $("#btn_finalizar").text("Guardar");
                    $("#btn_finalizar").attr("onclick", "guardar_carrera();");
                    limpiar_formulario();
                    $("#alerta_pass").attr("hidden", "hidden");
                }
                function eliminar(id) {
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'carreras/eliminar",
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
                    $("#carrera").val("");
                    $("#btn_finalizar").text("Guardar");
                }
                function editar(id){
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'carreras/editar",
                        type: "POST",
                        dataType: "json",
                        data: {
                            "id": id,
                        },
                        success: function(data) {
                            $("#carrera").val(data.carrera);
                            
                            $("#id_universidad option[value="+data.id_universidad+"]").attr("selected", true);
                            $("#id_area option[value="+data.id_area+"]").attr("selected", true);

                            $("#btn_finalizar").text("Actualizar");
                            $("#btn_finalizar").attr("onclick", "actualizar_carrera("+data.id+");");
                            
                            $("#exampleModalLabel").text("Editar Aula");
                            $("#alerta_pass").removeAttr("hidden");
                        }
                    });
                }
                $("#cerrar_formulario_aula").click(function(){
                    limpiar_formulario();
                });
                function guardar_carrera(){
                    $.post("' . $this->baseurl . INDEX . 'carreras/save", {
                        carrera: $("#carrera").val(),
                        id_universidad: $("#id_universidad").val(),
                        id_area: $("#id_area").val()
                    }, function(data){
                        var obj = JSON.parse(data);
                        if(obj.Result == "OK"){
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            alertify.notify("<strong>Aula</strong> modificada correctamente.", "custom-black", 3, function() {});
                            $("#cerrar_formulario_aula").click();
                            alertify.closeAll();
                        }
                    });
                }
                function actualizar_carrera(id){
                    $.post("' . $this->baseurl . INDEX . 'carreras/editarBD", {
                        carrera: $("#carrera").val(),
                        id_universidad: $("#id_universidad").val(),
                        id_area: $("#id_area").val(),
                        id: id
                    }, function(data){
                        var obj = JSON.parse(data);
                        if(obj.Result == "OK"){
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            alertify.notify("<strong>Carrera</strong> agregada correctamente.", "custom-black", 3, function() {});
                            $("#cerrar_formulario_aula").click();
                            alertify.closeAll();
                        }
                    });
                }
            </script>';     
            return $r;
        }
    }
?>
