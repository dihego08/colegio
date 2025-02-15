<?php
class html_choferes extends f{
    private $baseurl = "";

    function html_choferes(){
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
                        <span style="float: right; margin-bottom: 10px;" class="btn btn-sm btn-success" data-toggle="modal" data-target="#formulario" id="btn_nuevo" onclick="nuevo_docente();">Nuevo Conductor</span>
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Lista de Docentes
                        </h5>
                        <small>
                            <i class="far fa-edit"></i> Aquí podrá ver toda la información de todos los Docentes
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
                                                <th>Celular</th>
                                                <th>Fec. Nacimiento</th>
                                                <th>Licencia</th>
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
            <div class="modal fade" id="formulario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="max-width: 80%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLabel">Nuevo Conductor</h3>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group" style="width: 100%;">
                                <!--<form id="form_nuevo" action="'. $this->baseurl . INDEX . 'choferes/save"  method="post">-->
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <label>DNI</label>
                                            <input id="dni" class="form-control" name="dni" type="text"/>
                                            <input id="id" class="form-control" name="id" type="hidden"/>
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
                                        <div class="col-md-6">
                                            <label>Celular</label>
                                            <input id="celular" class="form-control" name="celular" type="text"/>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Licencia</label>
                                            <select class="form-control" id="licencia" name="licencia">
                                                <option value="A-I">A-I</option>
                                                <option value="A-IIa">A-IIa</option>
                                                <option value="A-IIb">A-IIb</option>
                                                <option value="A-IIIa">A-IIIa</option>
                                                <option value="A-IIIb">A-IIIb</option>
                                                <option value="A-IIIc">A-IIIc</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12" style="margin-top: 15px;">
                                            <button type="submit" class="btn btn-success pull-right" id="btn_finalizar">Guardar</button>
                                            <span class="btn btn-danger" type="button" data-dismiss="modal" id="cerrar_formulario_docente" style="margin-left: 10px">
                                                Cancelar
                                            </span>
                                        </div>
                                    </div>
                                <!--</form>-->
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
                    $( ".datepicker" ).datepicker({
                        dateFormat: "yy/mm/dd"
                    });
                    $("#form_agregar input[name=nombre]").focus();
                    $("#form_agregar input[name=nombre]").keyup(function() {
                        var letras = $(this).val().substring(0, 4);
                        var numeros = $(this).val().length;
                        $("#form_agregar input[name=codinterno]").val(letras + numeros + "_fam");
                    });
                    var table = $(".datatable").DataTable({
                        "ajax": {
                            url: "' . $this->baseurl . INDEX . 'choferes/loadconductores/",
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
                            "data": "celular"
                        }, {
                            "data": "fecha_nacimiento"
                        }, {
                            "data": "licencia"
                        }, {
                            "defaultContent": "<button id=\"btn_editar\" data-toggle=\"modal\" data-target=\"#formulario\" class=\"btn btn-info btn-sm\" ><i class=\"fas fa-pencil-alt\"></i></button>"
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
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el Docente <strong>" + rowData["apellidos"] + "</strong>?",
                            function() {
                                eliminar(rowData["id"]);
                                alertify.notify("Se elimino el Docente <strong>" + rowData["apellidos"] + "</strong> correctamente.", "custom-black", 4, function() {});
                            },
                            function() {
                                alertify.notify("Se cancelo la <strong>eliminación</strong>.", "custom-black", 4, function() {});
                            }).set("labels", { ok: "Eliminar", cancel: "Cancelar" });
                        } else {
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el Docente <strong>" + data["apellidos"] + "</strong>?",
                            function() {
                                eliminar(data["id"]);
                                alertify.notify("Se elimino el Docente <strong>" + data["apellidos"] + "</strong> correctamente.", "custom-black", 4, function() {});
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
                    $("#exampleModalLabel").text("Nuevo Conductor");
                    //$("#form_nuevo").attr("action", "'. $this->baseurl . INDEX . 'choferes/save");
                    $("#btn_finalizar").text("Guardar");
                    $("#btn_finalizar").attr("onclick", "registrar_conductor();");
                    limpiar_formulario();
                    $("#alerta_pass").attr("hidden", "hidden");
                }
                function eliminar(id) {
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'choferes/eliminar",
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
                    $("#celular").val("");
                    $("#direccion").val("");
                    $("#correo").val("");
                    $("#usuario").val("");
                    /*$("#btn_finalizar").removeAttr("onclick");
                    $("#btn_finalizar").text("Guardar");*/
                }
                function editar(id){
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'choferes/editar",
                        type: "POST",
                        dataType: "json",
                        data: {
                            "id": id,
                        },
                        success: function(data) {
                            $("#dni").val(data.dni);
                            $("#nombres").val(data.nombres);
                            $("#apellidos").val(data.apellidos);
                            $("#id").val(data.id);
                            $("#fecha_nacimiento").val(data.fecha_nacimiento);
                            $("#celular").val(data.celular);
                            $("#licencia option[value="+data.licencia+"]").attr("selected", true);
                            $("#btn_finalizar").text("Actualizar");
                            $("#btn_finalizar").attr("onclick", "actualizar_docente("+data.id+");");
                            $("#exampleModalLabel").text("Editar Docente");
                            $("#alerta_pass").removeAttr("hidden");
                        }
                    });
                }
                $("#cerrar_formulario_docente").click(function(){
                    limpiar_formulario();
                });
                function registrar_conductor(){
                    $.post("'. $this->baseurl . INDEX . 'choferes/save", {
                        nombres: $("#nombres").val(),
                        apellidos: $("#apellidos").val(),
                        fecha_nacimiento: $("#fecha_nacimiento").val(),
                        celular: $("#celular").val(),
                        dni: $("#dni").val(),
                        licencia: $("#licencia").val()
                    }, function(response){
                        var obj = JSON.parse(response);
                        if(obj.Result == "OK"){
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            alertify.notify("<strong>Conductor</strong> Agregado Correctamente.", "custom-black", 3, function() {});
                            $("#cerrar_formulario_docente").click();
                        }else{
                            alertify.notify("<strong>Algo ha salido mal!!!</strong>", "custom-black", 3, function() {});
                        }
                    });
                }
                function actualizar_docente(id){
                    $.post("'. $this->baseurl . INDEX . 'choferes/editarBD", {
                        nombres: $("#nombres").val(),
                        apellidos: $("#apellidos").val(),
                        fecha_nacimiento: $("#fecha_nacimiento").val(),
                        celular: $("#celular").val(),
                        dni: $("#dni").val(),
                        licencia: $("#licencia").val(),
                        id: id
                    }, function(response){
                        var obj = JSON.parse(response);
                        if(obj.Result == "OK"){
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            alertify.notify("<strong>Conductor</strong> Modificado Correctamente.", "custom-black", 3, function() {});
                            $("#cerrar_formulario_docente").click();
                        }else{
                            alertify.notify("<strong>Algo ha salido mal!!!</strong>", "custom-black", 3, function() {});
                        }
                    });
                }
            </script>';     
            return $r;
        }
    }
?>
