<?php
class html_pagos_2 extends f
{
    private $baseurl = "";

    function html_pagos_2()
    {
        $this->load()->lib_html("Table", false);
        $this->baseurl = BASEURL;
    }
    function container()
    {
        $r = '<style>
                .select2-container{
                    width: 100% !important;
                }
                .table > thead > tr > th { 
                    font-size: 11px !important;

                }
                .table > tbody > tr > td { 
                    font-size: 11px !important;

                }
                tbody td {
                    padding: 5px 7px;
                }
            </style>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <span style="float: right; margin-bottom: 10px;" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#formulario" id="btn_nuevo" onclick="nuevo_pago();"><i class="fa fa-plus"></i> Registrar Pago</span>
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Registro de Pagos
                        </h5>
                        <small>
                            <i class="fa fa-edit"></i> Aquí podrá ver toda la información de todos los Pagos registrados
                        </small>
                        <hr>         
                        <div class="container" style="max-width: 100%;">
                            <div class="row">
                                <div class="table-responsive" >
                                    <table  class="datatable table table-sm dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Fecha</th>    
                                                <th>Alumno</th>
                                                <th>M. Pagado</th>
                                                <th>Concepto</th>
                                                <th>Fecha</th>
                                                <th>Metodo Pago</th>
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
            <div class="modal fade" id="formulario" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="max-width: 80%;">
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
                                    <label for="">Alumno</label>
                                    <select class="form-control mt-2 mb-1" id="id_alumno">
                                        <option value="-1">--SELECCIONAR--</option>
                                    </select>
                                </div>
                                <div class="col-12 mb-2 form-row">
                                    <div class="col-6 mb-2">
                                        <label for="">Monto</label>
                                        <input type="text" class="form-control" id="monto">
                                    </div>
                                    <div class="col-6 mb-2">
                                        <label for="">Fecha</label>
                                        <input type="text" class="form-control datepicker" id="fecha">
                                    </div>
                                </div>
                                <div class="col-12 mb-2 form-row">
                                    <div class="col-12">
                                        <label >Concepto de Pago</label>
                                        <select class="form-control" id="id_concepto"></select>
                                    </div>
                                </div>
                                <div class="col-12 mb-2 form-row">
                                    <div class="col-6">
                                        <label >Método de Pago</label>
                                        <select class="form-control" id="id_metodo_pago"></select>
                                    </div>
                                    <div class="col-3">
                                        <label class="d-block">Adjuntar Comprobante</label>
                                        <label for="foto" style="font-weight: bold;">
                                            <i class="fa fa-camera" style="font-size: 2rem; cursor: pointer;"></i>
                                            <input id="foto" class="form-control" name="foto" type="file" style="display: none;"/>
                                        </label>
                                    </div>

                                    <div class="col-md-3 text-center">
                                        <img src="" id="profile-img-tag" width="200px" style="margin-left: auto;margin-right: auto;" />
                                    </div>

                                </div>
                                <div class="col-md-12 mt-3">
                                    <progress id="progressBar" class="mt-2" value="0" max="100" style="width:100%;"></progress>
                                    <p id="status"></p>
                                    <p id="loaded_n_total"></p>
                                </div>
                                <div class="form-row text-center">
                                    <button type="submit" class="btn btn-success" id="btn_finalizar">Guardar</button>
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

        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script>
        
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
            <!----------------------------------------------------------------------->
            <script>
                function get_metodos_pagos(){
                    $.post("' . $this->baseurl . INDEX . 'pagos_2/get_metodos_pagos", function(response){
                        var obj = JSON.parse(response);
                        $("#id_metodo_pago").append(`<option value="0">--SELECCIONAR--</option>`);
                        $.each(obj, function(index, val){
                            $("#id_metodo_pago").append(`<option value="${val.id}">${val.metodo_pago}</option>`);
                        });
                    });
                }
                $(document).ready(function() {
                    get_metodos_pagos();
                    function readURL(input) {
                        if (input.files && input.files[0]) {
                            var reader = new FileReader();
                            reader.onload = function (e) {
                                $("#profile-img-tag").attr("src", e.target.result);
                            }
                            reader.readAsDataURL(input.files[0]);
                        }
                    }
                    $("#foto").change(function(){
                        readURL(this);
                    });
                    $("#id_alumno").select2({
                        dropdownParent: $("#formulario")
                    });
                    llenar_conceptos();
                    llenar_alumnos();

                    $( ".datepicker" ).datetimepicker({
                        format: "Y-m-d",
                        timepicker:false
                    });
                    var meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
                    $.datetimepicker.setLocale(\'es\');
                    var table = $(".datatable").DataTable({
                        "ajax": {
                            url: "' . $this->baseurl . INDEX . 'pagos_2/loadpagos/",
                            "dataSrc": ""
                        },
                        order: [[ 0, "desc" ]],
        dom: "Bfrtip",
                        "columns": [{
                            "data": "fecha"
                        },{
                            "data": "alumno"
                        },  {
                            "data": "monto",
                            "render": function(data){
                                return `<span class="badge badge-success" style="font-size: 13px;">S/ ${data}</span>`
                            }
                        }, {
                            "data": "concepto",
                            "render": function(data){
                                return `<span class="" style="white-space: break-spaces;">${$.trim(data)}</span>`
                            }
                        }, {
                            "data": "fecha",
                            "render": function(data){
                                return `<span class="badge badge-danger" style="font-size: 100%;">${data}</span>`
                            }
                        }, {
                            "data": "metodo_pago"
                        }, {
                            data: "id",
                            "render": function(data, a, b){
                                var boton_ver_imagen = "";
                                if(b.foto_comprobante == null || b.foto_comprobante == "null" || b.foto_comprobante == ""){ }else{
                                    boton_ver_imagen = `<a class="btn btn-outline-primary btn-sm d-block" target="_blank" href="system/controllers/comprobantes_pago/${b.foto_comprobante}"><i class="fa fa-image"></i></a>`;
                                }
                                return `<span id="btn_editar" class="btn btn-outline-warning btn-sm d-block mb-1 w-100" data-toggle="modal" data-target="#formulario"><i class="fa fa-edit"></i></span>`+"<button id=\"btn_eliminar\" class=\"btn btn-outline-danger btn-sm d-block mb-1 w-100\"><i class=\"fa fa-trash\"></i></button>" + `<span  title="Imprimir" class="btn btn-outline-info btn-sm mb-1 d-block"><a href="system/lib/pdf_venta.php?id_venta=${data}" target="_blank"><i class="fa fa-file"></i></a></span>`+
                                `${boton_ver_imagen}`
                            }
                        }, ],
                        "language": {
                            "url": "' . $this->baseurl . 'includes/datatables/Spanish.json"
                        },
        buttons: [
            "excel"
        ],
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
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el pago del Alumno <strong>" + rowData["alumno"] + "</strong>?",
                            function() {
                                eliminar(rowData["id"]);
                                alertify.notify("Se elimino el pago del Alumno <strong>" + rowData["alumno"] + "</strong> correctamente.", "custom-black", 4, function() {});
                            },
                            function() {
                                alertify.notify("Se cancelo la <strong>eliminación</strong>.", "custom-black", 4, function() {});
                            }).set("labels", { ok: "Eliminar", cancel: "Cancelar" });
                        } else {
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el pago del Alumno <strong>" + data["alumno"] + "</strong>?",
                            function() {
                                eliminar(data["id"]);
                                alertify.notify("Se elimino el pago del Alumno <strong>" + data["alumno"] + "</strong> correctamente.", "custom-black", 4, function() {});
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
                function nuevo_pago(){
                    $("#exampleModalLabel").text("Registrar Pago");
                    $("#btn_finalizar").text("Guardar");
                    $("#btn_finalizar").attr("onclick", "guardar_pago();");
                    limpiar_formulario();
                }
                function eliminar(id) {
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'pagos_2/eliminar_pago",
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
                function llenar_conceptos(){
                    $.post("' . $this->baseurl . INDEX . 'pagos_2/loadconceptos/", function(response){
                        var obj = JSON.parse(response);
                        $("#id_concepto").append(`<option value="0">--SELECCIONE--</option>`);
                        $.each(obj, function(index, val){
                            $("#id_concepto").append(`<option value="${val.id}">${val.concepto}</option>`);
                        });
                    });
                }
                function llenar_alumnos(){
                    $.post("' . $this->baseurl . INDEX . 'alumnos/get_alumnos/", function(response){
                        var obj = JSON.parse(response);

                        $.each(obj, function(index, val){
                            $("#id_alumno").append(`<option value="${val.id}">${val.nombres} ${val.apellidos}</option>`);
                        });
                    });
                }
                function limpiar_formulario(){
                    $("#dni").val("");
                    $("#nombres").val("");
                    $("#apellidos").val("");
                    $("#fecha_nacimiento").val("");
                    $("#telefono").val("");
                    $("#direccion").val("");
                    $("#correo").val("");
                    $("#id_padre").val("");
                    $("#concepto").val("");
                    $("#plazo").val("");
                    $("#btn_finalizar").text("Guardar");
                }
                function editar(id){
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'pagos_2/editar",
                        type: "POST",
                        dataType: "json",
                        data: {
                            "id": id,
                        },
                        success: function(data) {
                            $("#monto").val(data.monto);
                            $("#id_alumno").val(data.id_usuario).trigger("change");
                            //$("#id_alumno").select2().trigger();
                            $("#fecha").val(data.fecha);
                            $("#id_concepto").val(data.id_concepto);
                            $("#id_metodo_pago").val(data.id_metodo_pago);
                            $("#btn_finalizar").text("Actualizar");
                            
                            if(!$.trim(data.foto_comprobante) == ""){
                                $("#profile-img-tag").attr("src", "system/controllers/comprobantes_pago/" + data.foto_comprobante);
                            }
                            
                            $("#btn_finalizar").attr("onclick", "actualizar_pago("+data.id+");");
                            //$("#form_nuevo").attr("action", "' . $this->baseurl . INDEX . 'alumnos/editarBD");
                            $("#exampleModalLabel").text("Editar Alumno");
                        }
                    });
                }
                $("#cerrar_formulario_docente").click(function(){
                    limpiar_formulario();
                });
                function _(el){
                    return document.getElementById(el);
                }
                function uploadFile(){
                    var file = _("foto").files[0];
                    var formdata = new FormData();
                    formdata.append("foto", file);
                    formdata.append("id_curso", $("#id_curso").val());
                    formdata.append("id_tema", $("#id_tema").val());
                    formdata.append("tarea", $("#tarea").val());
                    formdata.append("fecha_entrega", $("#fecha_entrega").val());
                    formdata.append("parAccion", "guardar_tarea");
                    var ajax = new XMLHttpRequest();
                    ajax.upload.addEventListener("progress", progressHandler, false);
                    ajax.addEventListener("load", completeHandler, false);
                    ajax.addEventListener("error", errorHandler, false);
                    ajax.addEventListener("abort", abortHandler, false);
                    ajax.open("POST", "../php/tarea.php");
                    ajax.send(formdata);
                }
                function progressHandler(event){
                    _("loaded_n_total").innerHTML = "Uploaded "+event.loaded+" bytes of "+event.total;
                    var percent = (event.loaded / event.total) * 100;
                    _("progressBar").value = Math.round(percent);
                }
                function completeHandler(event){
                    var obj = JSON.parse(event.target.response);
                    if(obj.Result == "OK"){
                        alertify.notify("Realizado Correctamente.</strong>", "custom-black", 4, function() {});
                    }else{
                        if(obj.Code == 125){
                            alertify.notify("El DNI se encuentra registrado ya.</strong>", "custom-black", 4, function() {});
                        }else{
                            alertify.notify("Algo ha salido mal.</strong>", "custom-black", 4, function() {});
                        }
                        
                    }
                    table = $(".datatable").DataTable();
                    table.ajax.reload();
                    limpiar_formulario();
                    //$("#close_formulario_3").click();
                    
                    _("progressBar").value = 0;
                }
                function errorHandler(event){
                    _("status").innerHTML = "Upload Failed";
                }
                function abortHandler(event){
                    _("status").innerHTML = "Upload Aborted";
                }
                function actualizar_pago(id){
                    var form_data = new FormData();
                    
                    var file = _("foto").files[0];
                    form_data.append("foto", file);
                    
                    form_data.append("id_usuario", $("#id_alumno").val());
                    form_data.append("monto", $("#monto").val());
                    form_data.append("fecha", $("#fecha").val());
                    form_data.append("id_concepto", $("#id_concepto").val());
                    form_data.append("id_metodo_pago", $("#id_metodo_pago").val());
                    form_data.append("id", id);
                    
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'pagos_2/editarBD",
                        dataType: "script",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,                         // Setting the data attribute of ajax with file_data
                        type: "post",
                        success: function(response){
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            alertify.notify("<strong>Pago</strong> agregado correctamente.", "custom-black", 3, function() {});
                            $("#cerrar_formulario_docente").click();
                        },error: function() {
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            alertify.notify("<strong>Pago</strong> agregado correctamente.", "custom-black", 3, function() {});
                            $("#cerrar_formulario_docente").click();
                        }
                    });
                }
                function guardar_pago(){
                    var form_data = new FormData();
                    
                    var file = _("foto").files[0];
                    form_data.append("foto", file);
                    
                    form_data.append("id_usuario", $("#id_alumno").val());
                    form_data.append("monto", $("#monto").val());
                    form_data.append("fecha", $("#fecha").val());
                    form_data.append("id_concepto", $("#id_concepto").val());
                    form_data.append("id_metodo_pago", $("#id_metodo_pago").val());
                    
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'pagos_2/save",
                        dataType: "script",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,                         // Setting the data attribute of ajax with file_data
                        type: "post",
                        success: function(response){
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            alertify.notify("<strong>Pago</strong> agregado correctamente.", "custom-black", 3, function() {});
                            $("#cerrar_formulario_docente").click();
                        },error: function() {
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            alertify.notify("<strong>Pago</strong> agregado correctamente.", "custom-black", 3, function() {});
                            $("#cerrar_formulario_docente").click();
                        }
                    });
                }
            </script>';
        return $r;
    }
}
