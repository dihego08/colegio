<?php
class html_modulos extends f{
    private $baseurl = "";

    function html_modulos(){
        $this->load()->lib_html("Table", false);
        $this->baseurl = BASEURL;
    }
    function container(){
        $r = '<script>
                function abrir_modal(b,a){alertify.dialog(b,function(){return{main:function(c){this.setContent(c);},setup:function(){return{focus:{element:function(){return this.elements.body.querySelector(this.get("selector"));
                },select:true},options:{basic:false,title:a,maximizable:false,resizable:false,padding:true,modal:true,transition:false,}};},settings:{selector:undefined}};
                });}
            </script>
            <div class="container-fluid" style="margin-top: 56px;">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Nuevo Modulo
                        </h5>
                        <small>
                            <i class="fa fa-edit"></i> Aquí podrá Agregar y Modificar la información de los Modulos
                        </small>
                        <hr>
                        <div class="form-row">
                            <div class="col-md-12">
                                <label>Modulo</label>
                                <input type="text" class="form-control" id="modulo" name="modulo">
                            </div>
                            <div class="col-md-12">
                                <label>Descripcion</label>
                                <input type="text" class="form-control" id="descripcion" name="descripcion">
                            </div>
                            <div class="col-md-12 mt-3">
                                <span class="btn btn-success" style="width: 100%;" id="btn_funcion">Guardar</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-8">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Lista de Modulos
                        </h5>
                        <small>
                            <i class="fa fa-edit"></i> Aquí podrá ver toda la información de todos los Modulos
                        </small>
                        <hr>         
                        <div class="container">
                            <div class="row">
                                <div class="table-responsive" >
                                    <table  class="datatable table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Modulo</th>
                                                <th>Descripcion</th>
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
                    $("#btn_funcion").attr("onclick", "guardar_modulo();");

                    var table = $(".datatable").DataTable({
                        "ajax": {
                            url: "' . $this->baseurl . INDEX . 'modulos/loadmodulos/",
                            "dataSrc": ""
                        },
                        "columns": [{
                            "data": "id"
                        },  {
                            "data": "modulo"
                        },  {
                            "data": "descripcion"
                        }, {
                            "defaultContent": "<button id=\"btn_editar\" data-toggle=\"modal\" style=\"display: block;\" data-target=\"#formulario\" class=\"btn-warning btn-sm w-100\" ><i class=\"fa fa-pencil\"></i></button> <button id=\"btn_eliminar\" class=\"btn-danger btn-sm w-100 mt-1\"><i class=\"fa fa-trash\" style=\"display: block;\"></i></button>"
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
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el Modulo <strong>" + rowData["modulo"] + "</strong>?",
                            function() {
                                eliminar(rowData["id"]);
                                alertify.notify("Se elimino el Modulo <strong>" + rowData["modulo"] + "</strong> correctamente.", "custom-black", 4, function() {});
                            },
                            function() {
                                alertify.notify("Se cancelo la <strong>eliminación</strong>.", "custom-black", 4, function() {});
                            }).set("labels", { ok: "Eliminar", cancel: "Cancelar" });
                        } else {
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el Modulo <strong>" + data["modulo"] + "</strong>?",
                            function() {
                                eliminar(data["id"]);
                                alertify.notify("Se elimino el Modulo <strong>" + data["modulo"] + "</strong> correctamente.", "custom-black", 4, function() {});
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
                    $("#btn_finalizar").text("Guardar");
                    $("#btn_finalizar").removeAttr("onclick");
                    limpiar_formulario();
                }
                function eliminar(id) {
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'modulos/eliminar",
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
                    $("#modulo").val("");
                    $("#descripcion").val("");
                    
                    $("#btn_funcion").attr("onclick", "guardar_modulo();");
                    $("#btn_funcion").text("Guardar");
                }
                function editar(id){
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'modulos/editar",
                        type: "POST",
                        dataType: "json",
                        data: {
                            "id_nivel": id,
                        },
                        success: function(data) {
                            $("#modulo").val(data.modulo);
                            $("#descripcion").val(data.descripcion);

                            $("#btn_funcion").text("Actualizar");
                            $("#btn_funcion").attr("onclick", "actualizar_modulo("+id+");");
                        }
                    });
                }
                $("#cerrar_formulario_docente").click(function(){
                    limpiar_formulario();
                });
                function guardar_modulo(){
                    $.post("'. $this->baseurl . INDEX . 'modulos/save", {
                        modulo: $("#modulo").val(),
                        descripcion: $("#descripcion").val(),
                    }, function(response){
                        var obj = JSON.parse(response);
                        if(obj.Result == "OK"){
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            alertify.notify("<strong>Modulo</strong> agregado correctamente.", "custom-black", 3, function() {});
                        }else{
                            alertify.notify("<strong>Algo ha salido terriblemente mal</strong>.", "custom-black", 3, function() {});
                        }
                    });
                }
                function actualizar_modulo(id){
                    $.post("'. $this->baseurl . INDEX . 'modulos/editarBD", {
                        id: id,
                        modulo: $("#modulo").val(),
                        descripcion: $("#descripcion").val(),
                    }, function(response){
                        var obj = JSON.parse(response);
                        if(obj.Result == "OK"){
                            limpiar_formulario();
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            alertify.notify("<strong>Modulo</strong> modificado correctamente.", "custom-black", 3, function() {});
                        }else{
                            alertify.notify("<strong>Algo ha salido terriblemente mal</strong>.", "custom-black", 3, function() {});
                        }
                    });
                }
            </script>';     
            return $r;
        }
    }
?>
