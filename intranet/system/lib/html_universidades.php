<?php
class html_universidades extends f{
    private $baseurl = "";

    function html_universidades(){
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
                    <div class="col-md-4">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Nueva Universidad
                        </h5>
                        <small>
                            <i class="fa fa-edit"></i> Aquí podrá ver agregar y modificar la información de las Universidades
                        </small>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="">Universidad</label>
                                <input type="text" class="form-control" id="universidad">
                            </div>
                            <div class="col-md-12 mt-3">
                                <button class="w-100 btn btn-success" id="btn_finalizar" onclick="guardar_universidad();">Guardar</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <span style="float: right; margin-bottom: 10px;" class="btn btn-sm btn-success" data-toggle="modal" data-target="#formulario" id="btn_nuevo" onclick="nuevo_aula();">Nueva Aula</span>
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Lista de Universidades
                        </h5>
                        <small>
                            <i class="fa fa-edit"></i> Aquí podrá ver toda la información de todos los Universidades
                        </small>
                        <hr>         
                        <div class="container">
                            <div class="row">
                                <div class="col-12" >
                                    <table  class="datatable table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
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
            <script>
                $(document).ready(function() {

                    $( ".datepicker" ).datepicker();
                    var table = $(".datatable").DataTable({
                        "ajax": {
                            url: "' . $this->baseurl . INDEX . 'universidades/loaduniversidades/",
                            "dataSrc": ""
                        },
                        "columns": [{
                            "data": "id"
                        }, {
                            "data": "universidad"
                        }, {
                            "defaultContent": "<button id=\"btn_editar\" data-toggle=\"modal\" data-target=\"#formulario\" class=\"btn btn-info btn-sm w-100 mb-1\" style=\"display: block;\"><i class=\"fa fa-pencil\"></i></button>"+"<button id=\"btn_eliminar\" class=\"btn btn-danger btn-sm w-100 \" style=\"display: block;\"><i class=\"fa fa-trash\"></i></button>"
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
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar la Universidad <strong>" + rowData["universidad"] + "</strong>?",
                            function() {
                                eliminar(rowData["id"]);
                                alertify.notify("Se elimino la Universidad <strong>" + rowData["universidad"] + "</strong> correctamente.", "custom-black", 4, function() {});
                            },
                            function() {
                                alertify.notify("Se cancelo la <strong>eliminación</strong>.", "custom-black", 4, function() {});
                            }).set("labels", { ok: "Eliminar", cancel: "Cancelar" });
                        } else {
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar la Universidad <strong>" + data["universidad"] + "</strong>?",
                            function() {
                                eliminar(data["id"]);
                                alertify.notify("Se elimino la Universidad <strong>" + data["universidad"] + "</strong> correctamente.", "custom-black", 4, function() {});
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
                        url: "' . $this->baseurl . INDEX . 'universidades/eliminar",
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
                    $("#universidad").val("");
                    $("#btn_finalizar").text("Guardar");
                    $("#btn_finalizar").attr("onclick", "guardar_universidad();");
                }
                function editar(id){
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'universidades/editar",
                        type: "POST",
                        dataType: "json",
                        data: {
                            "id": id,
                        },
                        success: function(data) {
                            $("#universidad").val(data.universidad);
                            $("#btn_finalizar").text("Actualizar");
                            $("#btn_finalizar").attr("onclick", "actualizar_universidad("+data.id+");");
                            
                            $("#exampleModalLabel").text("Editar Aula");
                            $("#alerta_pass").removeAttr("hidden");
                        }
                    });
                }
                $("#cerrar_formulario_aula").click(function(){
                    limpiar_formulario();
                });
                function guardar_universidad(){
                    $.post("' . $this->baseurl . INDEX . 'universidades/save", {
                        universidad: $("#universidad").val()
                    }, function(data){
                        var obj = JSON.parse(data);
                        if(obj.Result == "OK"){
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            alertify.notify("<strong>Universidad</strong> agregada correctamente.", "custom-black", 3, function() {});
                            limpiar_formulario();
                            alertify.closeAll();

                        }
                    });
                }
                function actualizar_universidad(id){
                    $.post("' . $this->baseurl . INDEX . 'universidades/editarBD", {
                        universidad: $("#universidad").val(),
                        id: id
                    }, function(data){
                        var obj = JSON.parse(data);
                        if(obj.Result == "OK"){
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            alertify.notify("<strong>Universidad</strong> modificada correctamente.", "custom-black", 3, function() {});
                            limpiar_formulario();
                            alertify.closeAll();
                        }
                    });
                }
            </script>';     
            return $r;
        }
    }
?>
