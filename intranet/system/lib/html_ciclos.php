<?php
class html_ciclos extends f{
    private $baseurl = "";

    function html_ciclos(){
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
                    <div class="col-12 col-md-4">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Nuevo Ciclo Academico
                        </h5>
                        <small>
                            <i class="fa fa-edit"></i> Aquí podrá Agregar y Modificar la información de los Ciclos Academicos
                        </small>
                        <hr>
                        <div class="form-row">
                            <div class="col-md-12">
                                <label>Universidad</label>
                                <select class="form-control" id="id_universidad">

                                </select>
                            </div>
                            <div class="col-md-12">
                                <label>Ciclo Academico</label>
                                <input type="text" class="form-control" id="ciclo" name="ciclo">
                            </div>
                            <div class="col-md-12">
                                <label>Fecha Inicio</label>
                                <input type="text" class="form-control datepicker" id="fecha_inicio" name="fecha_inicio">
                            </div>
                            <div class="col-md-12">
                                <label>Fecha Fin</label>
                                <input type="text" class="form-control datepicker" id="fecha_fin" name="fecha_fin">
                            </div>
                            <div class="col-md-12 mt-3">
                                <span class="btn btn-success" style="width: 100%;" id="btn_funcion">Guardar</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-8">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Lista de Ciclos Academicos
                        </h5>
                        <small>
                            <i class="fa fa-edit"></i> Aquí podrá ver toda la información de todos los Ciclos Academicos
                        </small>
                        <hr>         
                        <div class="container">
                            <div class="row">
                                <div class="table-responsive" >
                                    <table  class="datatable table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>C. Academico</th>
                                                <th>Fec. Inicio</th>
                                                <th>Fec. Fin</th>
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
                    llenar_universidades();

                    $( ".datepicker" ).datetimepicker({
                        format: "Y-m-d",
                        timepicker:false
                    });
                    $.datetimepicker.setLocale(\'es\');

                    $("#btn_funcion").attr("onclick", "guardar_ciclo();");
                    limpiar_formulario();

                    var table = $(".datatable").DataTable({
                        "ajax": {
                            url: "' . $this->baseurl . INDEX . 'ciclos/loadciclos/",
                            "dataSrc": ""
                        },
                        "columns": [{
                            "data": "id"
                        },  {
                            "data": "ciclo"
                        },  {
                            "data": "fecha_inicio"
                        },  {
                            "data": "fecha_fin"
                        }, {
                            "data": "universidad"
                        }, {
                            "defaultContent": "<button id=\"btn_editar\" data-toggle=\"modal\" style=\"display: block;\" data-target=\"#formulario\" class=\"btn btn-warning btn-sm w-100\" ><i class=\"fa fa-pencil\"></i></button> <button id=\"btn_eliminar\" class=\"btn btn-danger btn-sm w-100 mt-1\"><i class=\"fa fa-trash\" style=\"display: block;\"></i></button>"
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
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el Ciclo Academico <strong>" + rowData["ciclo"] + "</strong>?",
                            function() {
                                eliminar(rowData["id"]);
                                alertify.notify("Se elimino el Ciclo Academico <strong>" + rowData["ciclo"] + "</strong> correctamente.", "custom-black", 4, function() {});
                            },
                            function() {
                                alertify.notify("Se cancelo la <strong>eliminación</strong>.", "custom-black", 4, function() {});
                            }).set("labels", { ok: "Eliminar", cancel: "Cancelar" });
                        } else {
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el Ciclo Academico <strong>" + data["ciclo"] + "</strong>?",
                            function() {
                                eliminar(data["id"]);
                                alertify.notify("Se elimino el Ciclo Academico <strong>" + data["ciclo"] + "</strong> correctamente.", "custom-black", 4, function() {});
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
                function llenar_universidades(){
                    $.post("' . $this->baseurl . INDEX . 'universidades/loaduniversidades", function(response){
                        var obj = JSON.parse(response);

                        $.each(obj, function(index, val){
                            $("#id_universidad").append(`<option value="${val.id}">${val.universidad}</option>`);
                        });
                    });
                }
                function eliminar(id) {
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'ciclos/eliminar",
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
                    $("#ciclo").val("");
                    $("#fecha_inicio").val("");
                    $("#fecha_fin").val("");
                    
                    $("#btn_funcion").attr("onclick", "guardar_ciclo();");
                    $("#btn_funcion").text("Guardar");
                }
                function editar(id){
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'ciclos/editar",
                        type: "POST",
                        dataType: "json",
                        data: {
                            "id": id,
                        },
                        success: function(data) {
                            $("#ciclo").val(data.ciclo);
                            $("#fecha_inicio").val(data.fecha_inicio);
                            $("#fecha_fin").val(data.fecha_fin);

                            $("#id_universidad").val(data.id_universidad);

                            $("#btn_funcion").text("Actualizar");
                            $("#btn_funcion").attr("onclick", "actualizar_ciclo("+id+");");
                        }
                    });
                }
                function guardar_ciclo(){
                    $.post("'. $this->baseurl . INDEX . 'ciclos/save", {
                        ciclo: $("#ciclo").val(),
                        fecha_inicio: $("#fecha_inicio").val(),
                        fecha_fin: $("#fecha_fin").val(),
                        id_universidad: $("#id_universidad").val()
                    }, function(response){
                        var obj = JSON.parse(response);
                        if(obj.Result == "OK"){
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            limpiar_formulario();
                            alertify.notify("<strong>Ciclo Academico</strong> agregado correctamente.", "custom-black", 3, function() {});
                        }else{
                            alertify.notify("<strong>Algo ha salido terriblemente mal</strong>.", "custom-black", 3, function() {});
                        }
                    });
                }
                function actualizar_ciclo(id){
                    $.post("'. $this->baseurl . INDEX . 'ciclos/editarBD", {
                        id: id,
                        ciclo: $("#ciclo").val(),
                        fecha_inicio: $("#fecha_inicio").val(),
                        fecha_fin: $("#fecha_fin").val(),
                        id_universidad: $("#id_universidad").val()
                    }, function(response){
                        var obj = JSON.parse(response);
                        if(obj.Result == "OK"){
                            limpiar_formulario();
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            alertify.notify("<strong>Ciclo Academico</strong> modificado correctamente.", "custom-black", 3, function() {});
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
