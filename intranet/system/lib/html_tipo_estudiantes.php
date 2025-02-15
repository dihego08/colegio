<?php
class html_tipo_estudiantes extends f{
    private $baseurl = "";

    function html_tipo_estudiantes(){
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
                .select2-container{
                    width: 100% !important;
                }
            </style>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Formulario de Nuevo Tipo de Estudiantes
                        </h5>
                        <small>
                            <i class="fa fa-edit"></i> Aquí podrá añadir o modificar la información de los tipos de estudiantes
                        </small>
                        <hr>
                        <div class="col-md-12">
                            <label>Tipo de Estudiante</label>
                            <input id="tipo_estudiante" class="form-control" name="tipo_estudiante" type="text"/>
                        </div>
                        <div class="col-md-12 mt-3">
                            <button type="submit" class="btn btn-success pull-right" id="btn_finalizar">Guardar</button>
                            <span class="btn btn-danger" type="button" style="margin-left: 10px">
                                Cancelar
                            </span>
                        </div>
                    </div>
                    <div class="col-12 col-md-8">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Lista de Tipo de Estudiantes
                        </h5>
                        <small>
                            <i class="fa fa-edit"></i> Aquí podrá ver toda la información de todos los Tipo de Estudiantes
                        </small>
                        <hr>
                        <div class="container" style="max-width: 100%;">
                            <div class="row">
                                <div class="table-responsive" >
                                    <table  class="datatable table dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Tipo de Estudiante</th>
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
                $("#form_nuevo").on("submit", function(e) {
                    e.preventDefault();
                    if($("#id_padre").val() == "" || $("#id_padre").val() == 0){
                        alertify.notify("Campo <strong> Padre - Tutor </strong> vacío.", "custom", 4, function() {});
                        $("#padre_autocomplete").focus();
                    }else{
                        var f = $(this);
                        var metodo = f.attr("method");
                        var url = f.attr("action");
                        var formData = new FormData(this);
                        $.ajax({
                            url: url,
                            type: metodo,
                            dataType: "html",
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            beforeSend: function() {},
                            success: function(data) {
                                if (data == 1) {
                                    alertify.notify("Campo <strong>código interno</strong> vacío.", "custom", 4, function() {});
                                }
                                if (data == 2) {
                                    alertify.notify("Campo <strong>nombre</strong> vacío.", "custom", 4, function() {});
                                }
                                if (data == 0) {
                                    f[0].reset();
                                    table = $(".datatable").DataTable();
                                    table.ajax.reload();
                                    alertify.notify("Se agrego el <strong>Alumno</strong> correctamente.", "custom-black", 4, function() {})
                                    limpiar_formulario();
                                    $("#cerrar_formulario_docente").click();
                                    $("#cerrar_alerta").click();
                                };
                            },
                            error: function() {},
                        });
                    }
                });
                function eliminar_padre(){
                    $("#id_padre").val("");
                }
                $(document).ready(function() {
                    
                    $(".js-example-basic-single").select2();
                    
                    $( ".datepicker" ).datetimepicker({
                        format: "Y-m-d",
                        timepicker:false
                    });
                    $.datetimepicker.setLocale(\'es\');
                    
                    var table = $(".datatable").DataTable({
                        "ajax": {
                            url: "' . $this->baseurl . INDEX . 'tipo_estudiantes/loadtipo_estudiante/",
                            "dataSrc": ""
                        },
                        "columns": [{
                            "data": "id"
                        },  {
                            "data": "tipo_estudiante",
                        }, {
                            "defaultContent": "<button id=\"btn_editar\" data-toggle=\"modal\" data-target=\"#formulario\" style=\"display: block;\" class=\"w-100 btn btn-info btn-sm\" ><i class=\"fa fa-pencil\"></i></button><button id=\"btn_eliminar\"  style=\"display: block;\" class=\"w-100 mt-1 btn btn-danger btn-sm\"><i class=\"fa fa-trash\"></i></button>"
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
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el Alumno <strong>" + rowData["apellidos"] + "</strong>?",
                            function() {
                                eliminar(rowData["id"]);
                                alertify.notify("Se elimino el Alumno <strong>" + rowData["apellidos"] + "</strong> correctamente.", "custom-black", 4, function() {});
                            },
                            function() {
                                alertify.notify("Se cancelo la <strong>eliminación</strong>.", "custom-black", 4, function() {});
                            }).set("labels", { ok: "Eliminar", cancel: "Cancelar" });
                        } else {
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el Alumno <strong>" + data["apellidos"] + "</strong>?",
                            function() {
                                eliminar(data["id"]);
                                alertify.notify("Se elimino el Alumno <strong>" + data["apellidos"] + "</strong> correctamente.", "custom-black", 4, function() {});
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
                
                function nuevo_alumno(){
                    $("#exampleModalLabel").text("Nuevo Alumno");
                    //$("#form_nuevo").attr("action", "'. $this->baseurl . INDEX . 'alumnos/save");
                    $("#btn_finalizar").text("Guardar");
                    $("#btn_finalizar").attr("onclick", "guardar_alumno();");
                    limpiar_formulario();
                }
                function eliminar(id) {
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'alumnos/eliminar",
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
                    $("#tipo_estudiante").val("");
                    $("#btn_finalizar").text("Guardar");
                    $("#btn_finalizar").attr("onclick", "guardar_alumno();");
                }
                function editar(id){
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'tipo_estudiantes/editar",
                        type: "POST",
                        dataType: "json",
                        data: {
                            "id": id,
                        },
                        success: function(data) {
                            $("#tipo_estudiante").val(data.tipo_estudiante);

                            $("#btn_finalizar").text("Actualizar");
                            
                            $("#btn_finalizar").attr("onclick", "actualizar_alumno("+data.id+");");
                            $("#exampleModalLabel").text("Editar Tipo de Estudiante");
                        }
                    });
                }
                $("#cerrar_formulario_docente").click(function(){
                    limpiar_formulario();
                });
                function guardar_alumno(){
                    var form_data = new FormData();
                    
                    form_data.append("tipo_estudiante", $("#tipo_estudiante").val());
                    $.ajax({
                        url: "'. $this->baseurl . INDEX . 'tipo_estudiantes/save",
                        dataType: "script",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,                         // Setting the data attribute of ajax with file_data
                        type: "post",
                        success: function(response){
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            alertify.notify("<strong>Alumno</strong> agregado correctamente.", "custom-black", 3, function() {});
                            limpiar_formulario();
                        },error: function() {
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            alertify.notify("<strong>Alumno</strong> agregado correctamente.", "custom-black", 3, function() {});
                            limpiar_formulario();
                        }
                    });
                }
                function actualizar_alumno(id){
                    
                    var form_data = new FormData();
                    form_data.append("tipo_estudiante", $("#tipo_estudiante").val());
                    form_data.append("id", id)
                    $.ajax({
                        url: "'.$this->baseurl . INDEX . 'tipo_estudiantes/editarBD",
                        dataType: "script",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,                         // Setting the data attribute of ajax with file_data
                        type: "post",
                        success: function(response){
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            alertify.notify("<strong>Alumno</strong> modificado correctamente.", "custom-black", 3, function() {});
                            limpiar_formulario();
                        },error: function() {
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            alertify.notify("<strong>Alumno</strong> modificado correctamente.", "custom-black", 3, function() {});
                            limpiar_formulario();
                        }
                    });
                }
            </script>';     
            return $r;
        }
    }
?>
