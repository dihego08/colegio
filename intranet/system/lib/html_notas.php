<?php
    
class html_notas extends f{
    private $baseurl = "";

    function html_notas(){
        $this->load()->lib_html("Table", false);
        $this->baseurl = BASEURL;
    }
    function container(){
        $r = '
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <a style="float: right; margin-bottom: 10px;" id="btn_excel" hidden class="btn btn-sm btn-info" href="">
                            <span >Exportar EXCEL</span>
                        </a>
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Configuración de Notas por Curso
                        </h5>
                        <small>
                            <i class="fa fa-edit"></i> Esta Configuración Afectará a todos los Cursos registrados
                        </small>
                        <div class="w-100 text-right">
                            <span class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#formulario" id="btn_nuevo" onclick="nuevo_registro();">Nuevo Registro</span>
                        </div>
                        <hr>         
                        <div class="container">
                            <div class="row">
                                <div class="table-responsive" >
                                    <table  class="datatable table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Descripción</th>
                                                <th>Porcentaje</th>
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
                <div class="modal-dialog" role="document" style="max-width: 50%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLabel">Nuevo Alumno</h3>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group" style="width: 100%;">
                                <div class="col-12 mb-2">
                                    <label for="">Descripción</label>
                                    <input type="text" class="form-control" id="identificador">
                                </div>
                                <div class="col-12 mb-2">
                                    <label for="">Porcentaje</label>
                                    <input type="text" class="form-control" id="porcentaje">
                                </div>
                                <div class="col-md-12 mt-3">
                                    <progress id="progressBar" class="mt-2" value="0" max="100" style="width:100%;"></progress>
                                    <p id="status"></p>
                                    <p id="loaded_n_total"></p>
                                </div>
                                <div class="form-row">
                                    <button type="submit" class="btn btn-success pull-right" id="btn_finalizar">Guardar</button>
                                    <span class="btn btn-danger" type="button" data-dismiss="modal" id="cerrar_formulario_docente" style="margin-left: 10px">
                                        Cancelar
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>
            <!----------------------------------------------------------------------->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>
            <script>
                function limpiar_formulario(){
                    $("#identificador").val("");
                    $("#porcentaje").val("");
                }
                function nuevo_registro(){
                    $("#exampleModalLabel").text("Nuevo Registro");
                    $("#btn_finalizar").text("Guardar");
                    $("#btn_finalizar").attr("onclick", "guardar_registro();");
                    limpiar_formulario();
                }
                function guardar_registro(){
                    var formdata = new FormData();

                    if($("#identificador").val() == "" || $("#porcentaje").val() == ""){
                        bootbox.alert("Se están dejando espacios en blanco.");
                    }else{

                        $.ajax({
                            url: "' . $this->baseurl . INDEX . 'notas/save",
                            type: "POST",
                            dataType: "json",
                            data: {
                                "identificador": $("#identificador").val(),
                                "porcentaje": $("#porcentaje").val(),
                            },
                            success: function(data) {
                                var obj = data;
                                if(obj.Result == "OK"){
                                    table = $(".datatable").DataTable();
                                    table.ajax.reload();
                                    limpiar_formulario();
                                    alertify.notify("<strong>Registro</strong> agregado correctamente.", "custom-black", 3, function() {});
                                }else{
                                    alertify.notify("<strong>Algo ha salido terriblemente mal</strong>.", "custom-black", 3, function() {});
                                }
                            }
                        });
                    }
                }
                $(document).ready(function() {
                    var table = $(".datatable").DataTable({
                        "ajax": {
                            url: "' . $this->baseurl . INDEX . 'notas/loadnotas/",
                            "dataSrc": "",
                            "data": function(d) {
                                d.fecha = $("#fecha").val();
                            },
                        },
                        "columns": [{
                            "data": "id"
                        }, {
                            "data": "identificador"
                        }, {
                            "data": "porcentaje"
                        }, {
                            "defaultContent": `<span data-toggle="modal" data-target="#formulario" style="display: block;" class="w-100 mb-1 btn btn-outline-warning btn-sm" id="btn_editar"><i class="fa fa-edit"></i></span>`+"<button id=\"btn_eliminar\" class=\"btn btn-outline-danger btn-sm w-100\" style=\"display: block;\"><i class=\"fa fa-trash\"></i></button>"
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
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar esta Nota <strong></strong>?",
                            function() {
                                eliminar(rowData["id"]);
                                alertify.notify("Se elimino esta Nota correctamente.", "custom-black", 4, function() {});
                            },
                            function() {
                                alertify.notify("Se cancelo la <strong>eliminación</strong>.", "custom-black", 4, function() {});
                            }).set("labels", { ok: "Eliminar", cancel: "Cancelar" });
                        } else {
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar esta Nota <strong></strong>?",
                            function() {
                                eliminar(data["id"]);
                                alertify.notify("Se elimino esta Nota correctamente.", "custom-black", 4, function() {});
                            },
                            function() {
                                alertify.notify("Se cancelo la <strong>eliminación</strong>.", "custom-black", 4, function() {});
                            }).set("labels", { ok: "Eliminar", cancel: "Cancelar" });
                        }
                    });
                });
                function actualizar_registro(id){
                    var formdata = new FormData();

                    if($("#identificador").val() == "" || $("#porcentaje").val() == ""){
                        bootbox.alert("Se están dejando espacios en blanco.");
                    }else{
                        $.ajax({
                            url: "' . $this->baseurl . INDEX . 'notas/editarBD",
                            type: "POST",
                            dataType: "json",
                            data: {
                                "id": id,
                                "identificador": $("#identificador").val(),
                                "porcentaje": $("#porcentaje").val(),
                            },
                            success: function(data) {
                                var obj = data;
                                if(obj.Result == "OK"){
                                    table = $(".datatable").DataTable();
                                    table.ajax.reload();
                                    limpiar_formulario();
                                    alertify.notify("<strong>Registro</strong> agregado correctamente.", "custom-black", 3, function() {});
                                }else{
                                    alertify.notify("<strong>Algo ha salido terriblemente mal</strong>.", "custom-black", 3, function() {});
                                }
                            }
                        });
                    }
                }
                function editar(id){
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'notas/editar",
                        type: "POST",
                        dataType: "json",
                        data: {
                            "id": id,
                        },
                        success: function(data) {

		                    $("#identificador").val(data.identificador);
                            $("#porcentaje").val(data.porcentaje);
                            
                            $("#btn_finalizar").attr("onclick", "actualizar_registro("+data.id+");");
                            $("#btn_finalizar").text("Actualizar");
                            $("#exampleModalLabel").text("Editar Registro");
                        }
                    });
                }
                function eliminar(id) {
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'notas/eliminar",
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
            </script>';     
            return $r;
        }
    }
?>
