<?php
class html_padres extends f{
    private $baseurl = "";

    function html_padres(){
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
                    <div class="col-12 col-md-12">
                        <span style="float: right; margin-bottom: 10px;" class="btn btn-sm btn-success" data-toggle="modal" data-target="#formulario" id="btn_nuevo" onclick="nuevo_padre();">Nuevo Padre/Apoderado</span>
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Lista de Padres - Apoderados
                        </h5>
                        <small>
                            <i class="far fa-edit"></i> Aquí podrá ver toda la información de todos los Padres - Apoderados
                        </small>
                        <hr>         
                        <div class="container">
                            <div class="row">
                                <div class="col-12" >
                                    <table  class="datatable table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>DNI</th>
                                                <th>Nombres</th>
                                                <th>Apellidos</th>
                                                <th>Teléfono</th>
                                                <th>Dirección</th>
                                                <th>Correo</th>
                                                <th>Usuario</th>
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
            <div class="modal fade" id="detalle" tabindex="-1" role="dialog" aria-labelledby="detalle_titulo" aria-hidden="true">
                <div class="modal-dialog" role="document" style="max-width: 80%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="detalle_titulo">Detalle Padre/Apoderado</h3>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group" style="width: 100%;">
                                <div class="form-row">
                                    <table class="table table-bordered" id="tabla_hijos">
                                        <thead>
                                            <tr>
                                                <th>DNI</th>
                                                <th>Apellidos</th>
                                                <th>Nombres</th>
                                                <th>Grado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12" style="margin-top: 15px;">
                                        <span class="btn btn-danger" type="button" data-dismiss="modal" id="cerrar_detalle" style="margin-left: 10px">
                                            Cerrar
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
            <!----------------------------------------------------------------------->
            <div class="modal fade" id="formulario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="max-width: 80%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLabel">Nuevo Padre/Apoderado</h3>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group" style="width: 100%;">
                                <form id="form_nuevo" action="'. $this->baseurl . INDEX . 'padres/save"  method="post">
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <label>DNI</label>
                                            <input id="dni" class="form-control" name="dni" type="text"/>
                                        </div>
                                        <div class="col-md-8">
                                            <label>Nombres</label>
                                            <input id="nombres" class="form-control" name="nombres" type="text"/>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-8">
                                            <label>Apellidos</label>
                                            <input id="apellidos" class="form-control" name="apellidos" type="text"/>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Fec. Nacimiento</label>
                                            <input id="fecha_nacimiento" class="form-control datepicker" name="fecha_nacimiento" type="text"/>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <label>Teléfono</label>
                                            <input id="telefono" class="form-control" name="telefono" type="text"/>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Dirección</label>
                                            <input id="direccion" class="form-control" name="direccion" type="text"/>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Correo</label>
                                            <input id="correo" class="form-control" name="correo" type="text"/>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <label>Usuario</label>
                                            <input id="usuario" class="form-control" name="usuario" type="text"/>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Contraseña</label>
                                            <input id="pass" class="form-control" name="pass" type="password"/>
                                        </div>
                                        <div class="col-md-12" id="alerta_pass" hidden>
                                            <label></label>
                                            <div class="alert alert-success" role="alert">
                                                Al dejar en blanco el campo "<b>Contraseña</b>" se mantendrá la anteriormente registrada.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12" style="margin-top: 15px;">
                                            <button type="submit" class="btn btn-success pull-right" id="btn_finalizar">Guardar</button>
                                            <span class="btn btn-danger" type="button" data-dismiss="modal" id="cerrar_formulario_padre" style="margin-left: 10px">
                                                Cancelar
                                            </span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>
            <!----------------------------------------------------------------------->
            <script>
                $("#form_nuevo").on("submit", function(e) {
                    e.preventDefault();
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
                                alertify.notify("Se agrego el <strong>padre</strong> correctamente.", "custom-black", 4, function() {})
                                limpiar_formulario();
                                $("#cerrar_formulario_padre").click();
                            };
                        },
                        error: function() {},
                    });
                });
                $(document).ready(function() {
                    $( ".datepicker" ).datepicker({
                        dateFormat: "yy-mm-dd"
                    });
                    $("#form_agregar input[name=nombre]").focus();
                    $("#form_agregar input[name=nombre]").keyup(function() {
                        var letras = $(this).val().substring(0, 4);
                        var numeros = $(this).val().length;
                        $("#form_agregar input[name=codinterno]").val(letras + numeros + "_fam");
                    });
                    var table = $(".datatable").DataTable({
                        "ajax": {
                            url: "' . $this->baseurl . INDEX . 'padres/loadpadres/",
                            "dataSrc": ""
                        },
                        "columns": [{
                            "data": "id"
                        },  {
                            "data": "dni"
                        }, {
                            "data": "nombres"
                        }, {
                            "data": "apellidos"
                        }, {
                            "data": "telefono"
                        }, {
                            "data": "direccion"
                        }, {
                            "data": "correo"
                        }, {
                            "data": "usuario"
                        }, {
                            "defaultContent": "<button id=\"btn_editar\" data-toggle=\"modal\" data-target=\"#formulario\" class=\"btn btn-info btn-sm\" ><i class=\"fas fa-pencil-alt\"></i></button> <button id=\"btn_mas\" data-toggle=\"modal\" data-target=\"#detalle\" class=\"btn btn-success btn-sm\"><i class=\"fas fa-search-plus\"></i></button>"
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
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el padre <strong>" + rowData["apellidos"] + "</strong>?",
                            function() {
                                eliminar(rowData["id"]);
                                alertify.notify("Se elimino el padre <strong>" + rowData["apellidos"] + "</strong> correctamente.", "custom-black", 4, function() {});
                            },
                            function() {
                                alertify.notify("Se cancelo la <strong>eliminación</strong>.", "custom-black", 4, function() {});
                            }).set("labels", { ok: "Eliminar", cancel: "Cancelar" });
                        } else {
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el padre <strong>" + data["apellidos"] + "</strong>?",
                            function() {
                                eliminar(data["id"]);
                                alertify.notify("Se elimino el padre <strong>" + data["apellidos"] + "</strong> correctamente.", "custom-black", 4, function() {});
                            },
                            function() {
                                alertify.notify("Se cancelo la <strong>eliminación</strong>.", "custom-black", 4, function() {});
                            }).set("labels", { ok: "Eliminar", cancel: "Cancelar" });
                        }
                    });
                    $(".datatable tbody").on("click", "#btn_mas", function(){
                        var data = table.row($(this).parents("tr")).data();
                        if (data == undefined) {
                            var selected_row = $(this).parents("tr");
                            if (selected_row.hasClass("child")) {
                                selected_row = selected_row.prev();
                            }
                            var rowData = $(".datatable").DataTable().row(selected_row).data();
                            detalle(rowData["id"]);
                        } else {
                            detalle(data["id"]);
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
                function detalle(id_padre){
                    $.post("' . $this->baseurl . INDEX . 'alumnos/by_padre", {
                        id: id_padre
                    }, function(response){
                        var obj = JSON.parse(response);
                        $("#tabla_hijos").find("tbody").empty();
                        $.each(obj, function(index, val){
                            $("#tabla_hijos").find("tbody").append(`
                                <tr>
                                    <th scope="row">` + val.dni + `</th>
                                    <td>` + val.apellidos + `</td>
                                    <td>` + val.nombres + `</td>
                                    <td>` + val.id_grado + `</td>
                                </tr>
                            `);
                        });
                    });
                }
                function nuevo_padre(){
                    $("#exampleModalLabel").text("Nuevo Padre");
                    $("#form_nuevo").attr("action", "'. $this->baseurl . INDEX . 'padres/save");
                    $("#btn_finalizar").text("Guardar");
                    $("#btn_finalizar").removeAttr("onclick");
                    limpiar_formulario();
                    $("#alerta_pass").attr("hidden", "hidden");
                }
                function eliminar(id) {
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'padres/eliminar",
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
                    $("#dni").val("");
                    $("#nombres").val("");
                    $("#apellidos").val("");
                    $("#fecha_nacimiento").val("");
                    $("#telefono").val("");
                    $("#direccion").val("");
                    $("#correo").val("");
                    $("#usuario").val("");
                    $("#btn_finalizar").removeAttr("onclick");
                    $("#btn_finalizar").text("Guardar");
                }
                function editar(id){
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'padres/editar",
                        type: "POST",
                        dataType: "json",
                        data: {
                            "id": id,
                        },
                        success: function(data) {
                            $("#dni").val(data[0].dni);
                            $("#nombres").val(data[0].nombres);
                            $("#apellidos").val(data[0].apellidos);
                            $("#fecha_nacimiento").val(data[0].fecha_nacimiento);
                            $("#telefono").val(data[0].telefono);
                            $("#direccion").val(data[0].direccion);
                            $("#correo").val(data[0].correo);
                            $("#usuario").val(data[0].usuario);
                            $("#btn_finalizar").text("Actualizar");
                            $("#btn_finalizar").attr("onclick", "actualizar_padre("+data[0].id+");");
                            $("#form_nuevo").attr("action", "'.$this->baseurl . INDEX . 'padres/editarBD");
                            $("#exampleModalLabel").text("Editar Padre/Apoderado");
                            $("#alerta_pass").removeAttr("hidden");
                        }
                    });
                }
                $("#cerrar_formulario_padre").click(function(){
                    limpiar_formulario();
                });
                function actualizar_padre(id){
                    $("#form_nuevo").on("submit", function(e) {
                        e.preventDefault();
                        var f = $(this);
                        var metodo = f.attr("method");
                        var url = f.attr("action");
                        var formData = new FormData(this);
                        formData.append("id", id);
                        $.ajax({
                            url: url,
                            type: metodo,
                            dataType: "html",
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            beforeSend: function() {},
                            success: function(response) {
                                f[0].reset();
                                table = $(".datatable").DataTable();
                                table.ajax.reload();
                                //alertify.modalcursos().close();
                                alertify.notify("<strong>padre</strong> modificado correctamente.", "custom-black", 3, function() {});
                                $("#cerrar_formulario_padre").click();
                                alertify.closeAll();
                            },
                            error: function() {},
                        });
                    });
                }
            </script>';     
            return $r;
        }
    }
?>
