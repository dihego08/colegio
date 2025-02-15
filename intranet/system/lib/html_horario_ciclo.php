<?php
class html_horario_ciclo extends f{
    private $baseurl = "";

    function html_horario_ciclo(){
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
                        <span style="float: right; margin-bottom: 10px;" class="btn btn-sm btn-success" data-toggle="modal" data-target="#formulario" id="btn_nuevo" onclick="nuevo_horario();">Nuevo Horario</span>
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Lista de Horarios
                        </h5>
                        <small>
                            <i class="fa fa-edit"></i> Aquí podrá ver toda la información de todos los Horarios
                        </small>
                        <hr>         
                        <div class="container">
                            <div class="row">
                                <div class="col-12" >
                                    <table  class="datatable table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Ciclo</th>
                                                <th>Grupo</th>
                                                <th>Dia</th>
                                                <th>Hora Inicio</th>
                                                <th>Hora Fin</th>
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
                            <h3 class="modal-title" id="exampleModalLabel">Nueva Grado</h3>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group" style="width: 100%;">
                                <div class="form-row">
                                    <div class="form-row col-md-12 mt-2">
                                        <div class="col-md-6">
                                            <label class="bold">Ciclo Academico</label><br>
                                            <select class="form-control" id="id_ciclo">
                                                <option value="-1">--SELECCIONA--</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="bold">Grupo</label><br>
                                            <select class="form-control" id="id_grupo">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Dia</label>
                                        <select class="form-control" id="dia" name="dia">
                                            <option value="1">Lunes</option>
                                            <option value="2">Martes</option>
                                            <option value="3">Miercoles</option>
                                            <option value="4">Jueves</option>
                                            <option value="5">Viernes</option>
                                            <option value="6">Sabado</option>
                                        </select>
                                        <!--<input id="fecha" class="form-control datepicker" name="fecha" type="text"/>-->
                                    </div>
                                    <div class="col-md-4">
                                        <label>Hora Inicio</label>
                                        <input id="hora_inicio" class="form-control timepicker" name="hora_inicio" type="text"/>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Hora Fin</label>
                                        <input id="hora_fin" class="form-control timepicker" name="hora_fin" type="text"/>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12" style="margin-top: 15px;">
                                        <button type="submit" class="btn btn-success pull-right" id="btn_finalizar">Guardar</button>
                                        <span class="btn btn-danger" type="button" data-dismiss="modal" id="cerrar_formulario_grado" style="margin-left: 10px">
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
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/jquery.datetimepicker.full.min.js"></script>
            <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/build/jquery.datetimepicker.min.css" rel="stylesheet"/>

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
                                alertify.notify("Se agrego el <strong>Grado</strong> correctamente.", "custom-black", 4, function() {})
                                limpiar_formulario();
                                $("#cerrar_formulario_grado").click();
                            };
                        },
                        error: function() {},
                    });
                });
                var dias = ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"];
                $(document).ready(function() {

                    $("#id_ciclo").on("change", function(){
                        if($(this).val() == "-1" || $(this).val() == -1){
                        }else{
                            llenar_grupos($(this).val());
                        }
                    });

                    llenar_ciclos();

                    $( ".datepicker" ).datetimepicker({
                        format: "Y-m-d",
                        timepicker:false
                    });
                    $(".timepicker").datetimepicker({
                        datepicker:false,
                        format:"H:i"
                    });
                    $.datetimepicker.setLocale(\'es\');
                    

                    var table = $(".datatable").DataTable({
                        "ajax": {
                            url: "' . $this->baseurl . INDEX . 'horario_ciclo/loadhorarios/",
                            "dataSrc": ""
                        },
                        "columns": [{
                            "data": "ciclo"
                        },  {
                            "data": "grupo"
                        },  {
                            "data": "dia",
                            "render": function(data){
                                return dias[data]
                            }
                        }, {
                            "data": "hora_inicio"
                        }, {
                            "data": "hora_fin"
                        }, {
                            "defaultContent": "<button id=\"btn_editar\" data-toggle=\"modal\" data-target=\"#formulario\" class=\"btn-warning btn-sm btn\" style=\"display: block;\"><i class=\"fa fa-pencil\"></i></button>"+"<button id=\"btn_eliminar\" class=\"btn-danger btn-sm mt-1 btn\" style=\"display: block;\"><i class=\"fa fa-trash\"></i></button>"
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
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el curso <strong>" + rowData["curso"] + "</strong>?",
                            function() {
                                eliminar(rowData["id"]);
                                alertify.notify("Se elimino el curso <strong>" + rowData["curso"] + "</strong> correctamente.", "custom-black", 4, function() {});
                            },
                            function() {
                                alertify.notify("Se cancelo la <strong>eliminación</strong>.", "custom-black", 4, function() {});
                            }).set("labels", { ok: "Eliminar", cancel: "Cancelar" });
                        } else {
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el curso <strong>" + data["curso"] + "</strong>?",
                            function() {
                                eliminar(data["id"]);
                                alertify.notify("Se elimino el curso <strong>" + data["curso"] + "</strong> correctamente.", "custom-black", 4, function() {});
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
                
                function llenar_ciclos(){
                    $.post("' . $this->baseurl . INDEX . 'ciclos/loadciclos/", function(data){
                        var obj = JSON.parse(data);

                        $.each(obj, function(index, val){
                            $("#id_ciclo").append(`<option value="${val.id}">${val.ciclo}</option>`);
                        });
                    });
                }
                function llenar_grupos(id_ciclo, id_grupo){
                    $.post("' . $this->baseurl . INDEX . 'grupos/loadgrupos/", {
                        id_ciclo: id_ciclo
                    }, function(data){
                        var obj = JSON.parse(data);

                        $("#id_grupo").empty();
                        $("#id_grupo").append(`<option value="-1">--SELECCIONA--</option>`);
                        $.each(obj, function(index, val){
                            if(val.id == id_grupo){
                                $("#id_grupo").append(`<option value="${val.id}" selected>${val.grupo}</option>`);
                            }else{
                                $("#id_grupo").append(`<option value="${val.id}">${val.grupo}</option>`);
                            }
                        });
                    });
                }

                function nuevo_horario(){
                    $("#id_modulo option").removeAttr("selected");
                    $("#id_modulo option[value=0]").attr("selected", true);

                    $("#exampleModalLabel").text("Agregar Horario");

                    $("#btn_finalizar").text("Guardar");
                    $("#btn_finalizar").attr("onclick", "guardar_horario();");

                    limpiar_formulario();
                }
                function eliminar(id) {
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'horario_ciclo/eliminar",
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
                    $("#hora_inicio").val("");
                    $("#hora_fin").val("");
                }
                function editar(id){
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'horario_ciclo/editar",
                        type: "POST",
                        dataType: "json",
                        data: {
                            "id": id,
                        },
                        success: function(data) {

                            $("#hora_inicio").val(data.hora_inicio);
                            $("#hora_fin").val(data.hora_fin);
                            $("#dia").val(data.dia);

                            $("#id_ciclo").val(data.id_ciclo);

                            llenar_grupos(data.id_ciclo, data.id_grupo);

                            $("#btn_finalizar").text("Actualizar");
                            $("#btn_finalizar").attr("onclick", "actualizar_horario("+data.id+");");
                            $("#exampleModalLabel").text("Editar Horario");
                            
                        }
                    });
                }
                $("#cerrar_formulario_grado").click(function(){
                    limpiar_formulario();
                });
                function guardar_horario(){
                    $.post("'.$this->baseurl . INDEX . 'horario_ciclo/save", {
                        fecha: $("#fecha").val(),
                        hora_inicio: $("#hora_inicio").val(),
                        hora_fin: $("#hora_fin").val(),
                        dia: $("#dia").val(),
                        id_grupo: $("#id_grupo").val()
                    }, function(response){
                        var obj = JSON.parse(response);

                        if(obj.Result == "OK"){
                            limpiar_formulario();
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            $("#cerrar_formulario_grado").click();
                            alertify.notify("<strong>Horario</strong> registrado correctamente.", "custom-black", 3, function() {});
                        }else{
                            alert("Algo ha salido mal.");
                        }
                    });
                }
                function actualizar_horario(id){
                    $.post("'.$this->baseurl . INDEX . 'horario_ciclo/editarBD", {
                        fecha: $("#fecha").val(),
                        hora_inicio: $("#hora_inicio").val(),
                        hora_fin: $("#hora_fin").val(),
                        dia: $("#dia").val(),
                        id: id,
                        id_grupo: $("#id_grupo").val(),
                    }, function(response){
                        var obj = JSON.parse(response);

                        if(obj.Result == "OK"){
                            limpiar_formulario();
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            $("#cerrar_formulario_grado").click();
                            alertify.notify("<strong>Horario</strong> modificado correctamente.", "custom-black", 3, function() {});
                        }else{
                            alert("Algo ha salido mal.");
                        }
                    });
                }
            </script>';
            return $r;
        }
    }
?>
