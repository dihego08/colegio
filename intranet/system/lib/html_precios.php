<?php
class html_precios extends f
{
    private $baseurl = "";

    function html_precios()
    {
        $this->load()->lib_html("Table", false);
        $this->baseurl = BASEURL;
    }
    function container()
    {
        $r = '<script>
                function abrir_modal(b,a){alertify.dialog(b,function(){return{main:function(c){this.setContent(c);},setup:function(){return{focus:{element:function(){return this.elements.body.querySelector(this.get("selector"));
                },select:true},options:{basic:false,title:a,maximizable:false,resizable:false,padding:true,modal:true,transition:false,}};},settings:{selector:undefined}};
                });}
            </script>
            <style type="text/css">
                .uploadArea {
                    min-height: 300px;
                    height: auto;
                    border: 1px dotted #ccc;
                    padding: 10px;
                    cursor: move;
                    margin-bottom: 10px;
                    position: relative;
                }
            </style>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-3">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Nuevo Precio
                        </h5>
                        <small>
                            <i class="fa fa-edit"></i> Aquí podrá Agregar y Modificar la información de los Precios
                        </small>
                        <hr>
                        <div class="form-row">
                            <div class="col-md-12">
                                <label>Tipo de Estudiante</label>
                                <select class="form-control" id="id_tipo_estudiante">
                                    <option value="-1" selected>--SELECCIONA--</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label>Precio Soles</label>
                                <input type="text" name="precio" id="precio" class="form-control">
                            </div>
                            <!--<div class="col-md-12">
                                <label>Precio Dolares</label>
                                <input type="text" name="precio_dolares" id="precio_dolares" class="form-control">
                            </div>-->
                            <div class="col-md-12">
                                <label>Desde</label>
                                <input type="text" name="desde" id="desde" class="form-control datepicker">
                            </div>
                            <div class="col-md-12">
                                <label>Hasta</label>
                                <input type="text" name="hasta" id="hasta" class="form-control datepicker">
                            </div>
                            <div class="col-md-12 mt-3">
                                <progress id="progressBar" class="mt-2" value="0" max="100" style="width:100%;"></progress>
                                <p id="status"></p>
                                <p id="loaded_n_total"></p>
                            </div>
                            <div class="col-md-12 mt-3">
                                <span onclick="guardar_precio()" id="btn_funcion" class="btn btn-success" style="width: 100%;">Guardar</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-9">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Lista de Precios
                        </h5>
                        <small>
                            <i class="fa fa-edit"></i> Aquí podrá ver toda la información de todos los Precios
                        </small>
                        <hr>         
                        <div class="container">
                            <div class="row">
                                <div class="table-responsive">
                                    <table  class="datatable table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Tipo</th>
                                                <th>Precio (S/)</th>
                                                <!--<th>Precio ($)</th>-->
                                                <th>Desde</th>
                                                <th>Hasta</th>
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
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/jquery.datetimepicker.full.min.js"></script>
            <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/build/jquery.datetimepicker.min.css" rel="stylesheet" />
            <script>
                function _(el){
                    return document.getElementById(el);
                }
                function uploadFile(){
                    var file = _("file1").files[0];
                    // alert(file.name+" | "+file.size+" | "+file.type);
                    var formdata = new FormData();
                    formdata.append("file1", file);
                    formdata.append("id_curso", $("#id_curso").val());
                    formdata.append("id_clase", $("#id_clase").val());
                    var ajax = new XMLHttpRequest();
                    ajax.upload.addEventListener("progress", progressHandler, false);
                    ajax.addEventListener("load", completeHandler, false);
                    ajax.addEventListener("error", errorHandler, false);
                    ajax.addEventListener("abort", abortHandler, false);
                    ajax.open("POST", "' . $this->baseurl . INDEX . 'videos/save/");
                    ajax.send(formdata);
                }
                function progressHandler(event){
                    _("loaded_n_total").innerHTML = "Uploaded "+event.loaded+" bytes of "+event.total;
                    var percent = (event.loaded / event.total) * 100;
                    _("progressBar").value = Math.round(percent);
                    //_("status").innerHTML = Math.round(percent)+"% uploaded... please wait";
                    table = $(".datatable").DataTable();
                    table.ajax.reload();
                }
                function completeHandler(event){
                    //_("status").innerHTML = event.target.responseText;
                    table = $(".datatable").DataTable();
                    table.ajax.reload();
                    _("progressBar").value = 0;
                }
                function errorHandler(event){
                    _("status").innerHTML = "Upload Failed";
                }
                function abortHandler(event){
                    _("status").innerHTML = "Upload Aborted";
                }
            </script>
            <script>
                function llenar_tipos_estudiantes(){
                    $.post("' . $this->baseurl . INDEX . 'precios/llenar_tipos_estudiantes/", function(response){
                        var obj = JSON.parse(response);

                        $.each(obj, function(index, val){
                            $("#id_tipo_estudiante").append(`<option value="${val.id}">${val.tipo_estudiante}</option>`);
                        });
                    });
                }
                $(document).ready(function() {
                    llenar_tipos_estudiantes();
                    $(".js-example-basic-single").select2();

                    $(".datepicker").datetimepicker({
                        format: "Y-m-d",
                        timepicker: false
                    });
                    $.datetimepicker.setLocale(\'es\');

                    $("#id_modulo").on("change", function(){
                        load_temas($("#id_modulo").val());
                    });

                    $("#btn_funcion").attr("onclick", "guardar_precio();");

                    var table = $(".datatable").DataTable({
                        "ajax": {
                            url: "' . $this->baseurl . INDEX . 'precios/loadprecios/",
                            "dataSrc": ""
                        },
                        "columns": [{
                            "data": "tipo_estudiante",
                        }, {
                            "data": "precio",
                        }/*, {
                            "data": "precio_dolares",
                        }*/, {
                            "data": "desde",
                        }, {
                            "data": "hasta",
                        },  {
                            "defaultContent": `<button id="btn_editar" class="w-100 btn btn-warning btn-sm" style="display: block;"><i class="fa fa-pencil"></i></button>`+"<button id=\"btn_eliminar\" class=\"btn btn-danger btn-sm w-100 mt-1\" style=\"display: block;\"><i class=\"fa fa-trash\"></i></button>"
                        }, ],
                        "language": {
                            "url": "' . $this->baseurl . 'includes/datatables/Spanish.json"
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
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el Precio?",
                            function() {
                                eliminar(rowData["id"]);
                                alertify.notify("Se elimino el Precio correctamente.", "custom-black", 4, function() {});
                            },
                            function() {
                                alertify.notify("Se cancelo la <strong>eliminación</strong>.", "custom-black", 4, function() {});
                            }).set("labels", { ok: "Eliminar", cancel: "Cancelar" });
                        } else {
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el Precio?",
                            function() {
                                eliminar(data["id"]);
                                alertify.notify("Se elimino el Precio correctamente.", "custom-black", 4, function() {});
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
                function guardar_precio(){
                    $.post("' . $this->baseurl . INDEX . 'precios/save", {
                        id_tipo_estudiante: $("#id_tipo_estudiante").val(),
                        precio: $("#precio").val(),
                        precio_dolares: $("#precio_dolares").val(),
                        desde: $("#desde").val(),
                        hasta: $("#hasta").val(),
                    }, function(response){
                        var obj = JSON.parse(response);
                        if(obj.Result == "OK"){
                            limpiar_formulario();
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            alertify.notify("<strong>Precio</strong> agregada correctamente.", "custom-black", 3, function() {});
                        }else{
                            alertify.notify("<strong>Algo ha salido terriblemente mal</strong>.", "custom-black", 3, function() {});
                        }
                    });
                }
                function actualizar_precio(id){
                    $.post("' . $this->baseurl . INDEX . 'precios/editarBD", {
                        id_tipo_estudiante: $("#id_tipo_estudiante").val(),
                        precio: $("#precio").val(),
                        precio_dolares: $("#precio_dolares").val(),
                        desde: $("#desde").val(),
                        hasta: $("#hasta").val(),
                        id: id
                    }, function(response){
                        var obj = JSON.parse(response);
                        if(obj.Result == "OK"){
                            limpiar_formulario();
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            alertify.notify("<strong>Precio</strong> actualizado correctamente.", "custom-black", 3, function() {});
                        }else{
                            alertify.notify("<strong>Algo ha salido terriblemente mal</strong>.", "custom-black", 3, function() {});
                        }
                    });
                }
                function eliminar(id) {
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'precios/eliminar",
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
                    $("#id_tipo_estudiante").val("");
                    $("#precio").val("");
                    $("#precio_dolares").val("");
                    $("#desde").val("");
                    $("#hasta").val("");
                    
                    $("#btn_funcion").text("Guardar");
                    $("#btn_funcion").attr("onclick", "guardar_precio();");
                }
                function editar(id){
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'precios/editar",
                        type: "POST",
                        dataType: "json",
                        data: {
                            "id": id,
                        },
                        success: function(data) {
                            $("#id_tipo_estudiante").val(data.id_tipo_estudiante);
                            $("#precio").val(data.precio);
                            $("#precio_dolares").val(data.precio_dolares);
                            $("#desde").val(data.desde);
                            $("#hasta").val(data.hasta);

                            $("#btn_funcion").text("Actualizar");
                            $("#btn_funcion").attr("onclick", "actualizar_precio("+id+");");
                        }
                    });
                }
            </script>';
        return $r;
    }
}
