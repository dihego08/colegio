<?php
class html_preguntas extends f{
    private $baseurl = "";

    function html_preguntas(){
        $this->load()->lib_html("Table", false);
        $this->baseurl = BASEURL;
    }
    function container(){
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
                .select2-container{
                    width: 100% !important;
                }
            </style>
            <div class="container-fluid" style="margin-top: 56px;">
                <div class="row">
                    <div class="col-md-12">
                        <span style="float: right; margin-bottom: 10px;" class="btn btn-sm btn-success" data-toggle="modal" data-target="#formulario" id="btn_nuevo" onclick="nueva_pregunta();">Nueva Pregunta</span>
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Lista de Preguntas
                        </h5>
                        <small>
                            <i class="far fa-edit"></i> Aquí podrá ver toda la información de todos las Preguntas
                        </small>
                        <hr>
                        <div class="container" style="max-width: 100%;">
                            <div class="row">
                                <div class="col-12" >
                                    <table  class="datatable table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Pregunta</th>
                                                <th>Alternativas</th>
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
                            <h3 class="modal-title" id="exampleModalLabel">Nueva Pregunta</h3>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <label>Pregunta</label>
                                    <input type="text" id="pregunta" name="pregunta" class="form-control">
                                </div>
                            </div>
                            <div class="form-row mt-2">
                                <div class="col-md-12" style="text-align: right;">
                                    <span class="btn-sm btn btn-danger" data-dismiss="modal" id="btn_btn_cancelar">Cancelar</span>
                                    <span class="btn-sm btn btn-success" id="btn_finalizar">Guardar</span>
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
            <div class="modal fade" id="add_alter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="max-width: 80%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLabel">Configurar Alternativas</h3>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label>Alternativa</label>
                                    <input type="text" class="form-control" id="alternativa" name="alternativa">
                                </div>
                                <div class="col-md-4" style="text-align: center;">
                                    <label>¿Es la Respuesta Correcta?</label>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="correc_resp">
                                        <!--<label class="form-check-label" for="exampleCheck1">Check me out</label>-->
                                    </div>
                                </div>
                                <div class="col-md-2" style="text-align: center;">
                                    <span style="height: 100%;" class="btn btn-sm btn-primary" title="Guardar" onclick="guardar_alternativa();"><i class="fa fa-plus"></i></span>
                                </div>
                            </div>
                            <table id="data_qu" class="mt-3 table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Alternativa</th>
                                        <th>¿Correcta?</th>
                                        <th>Borrar</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                </table>
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>
            <!----------------------------------------------------------------------->
            <script>
                var id_pregunta = 0;
                function guardar_alternativa(){
                    var co = 0;
                    if( $("#correc_resp").prop("checked")) {
                        co = 1;
                    }
                    $.post("' . $this->baseurl . INDEX . 'preguntas/save_alternativas", {
                        alternativa: $("#alternativa").val(),
                        id_pregunta: id_pregunta,
                        correcta: co
                    }, function(response){
                        var obj = JSON.parse(response);
                        if(obj.Result == "OK"){
                            configurar(id_pregunta);
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                        }else{
                            alertify.notify("<strong>Algo ha salido muy mal</strong>.", "custom-black", 4, function() {});
                        }
                    });
                }
                $(document).ready(function() {
                    
                    $(".js-example-basic-single").select2();

                    load_cursos(1);

                    $("#id_curso").on("change", function(){
                        load_clases($("#id_curso").val());
                    });

                    limpiar_formulario();

                    var table = $(".datatable").DataTable({
                        "ajax": {
                            url: "' . $this->baseurl . INDEX . 'preguntas/loadpreguntas/",
                            "dataSrc": ""
                        },
                        "columns": [{
                            "data": "id"
                        },  {
                            "data": "pregunta"
                        },  {
                            "data": "alternativas",
                            "render": function (data) {
                                    return "<span class=\"btn btn-secondary btn-sm\" data-toggle=\"modal\" data-target=\"#add_alter\" id=\"btn_alter\">"+data+"</span>";
                                }
                        },  {
                            "defaultContent": "<button id=\"btn_editar\" data-toggle=\"modal\" data-target=\"#formulario\" class=\"btn btn-warning btn-sm\"><i class=\"fa fa-pencil\"></i></button>"
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
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el Vídeo <strong>" + rowData["video"] + "</strong>?",
                            function() {
                                eliminar(rowData["id"]);
                                alertify.notify("Se elimino el Vídeo <strong>" + rowData["video"] + "</strong> correctamente.", "custom-black", 4, function() {});
                            },
                            function() {
                                alertify.notify("Se cancelo la <strong>eliminación</strong>.", "custom-black", 4, function() {});
                            }).set("labels", { ok: "Eliminar", cancel: "Cancelar" });
                        } else {
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el Vídeo <strong>" + data["video"] + "</strong>?",
                            function() {
                                eliminar(data["id"]);
                                alertify.notify("Se elimino el Vídeo <strong>" + data["video"] + "</strong> correctamente.", "custom-black", 4, function() {});
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
                    $(".datatable tbody").on("click", "#btn_alter", function() {
                        var data = table.row($(this).parents("tr")).data();
                        if (data == undefined) {
                            var selected_row = $(this).parents("tr");
                            if (selected_row.hasClass("child")) {
                                selected_row = selected_row.prev();
                            }
                            var rowData = $(".datatable").DataTable().row(selected_row).data();
                            configurar(rowData["id"]);
                        } else {
                            configurar(data["id"]);
                        }
                    });                    
                });
                function load_cursos(id_docente){
                    $.post("' . $this->baseurl . INDEX . 'cursos/cursos_by", {
                        id: id_docente
                    }, function(response){
                        var obj = JSON.parse(response);
                        $.each(obj, function(index, val){
                            $("#id_curso").append("<option value=" + val.id + ">" + val.titulo + " - " + val.nivel + "</option>");
                        });
                    });
                }
                function load_clases(id_curso){
                    $.post("' . $this->baseurl . INDEX . 'clases/get_clases", {
                        id_curso: id_curso
                    }, function(response){
                        var obj = JSON.parse(response);
                        $.each(obj.Records, function(index, val){
                            $("#id_clase").append("<option value=" + val.id + ">" + val.titulo + "</option>");
                        });
                    });
                }
                function nueva_pregunta(){
                    $("#exampleModalLabel").text("Nueva Pregunta");
                    $("#btn_finalizar").text("Guardar");
                    $("#btn_finalizar").attr("onclick", "guardar_pregunta();");
                    limpiar_formulario();
                }
                function eliminar(id) {
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'videos/eliminar",
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
                    $("#pregunta").val("");
                }
                function configurar(id){
                    id_pregunta = id;
                    $.post("' . $this->baseurl . INDEX . 'preguntas/loadalternativas", {
                        id_pregunta: id
                    }, function(response){
                        var obj = JSON.parse(response);
                        $("#data_qu").find("tbody").empty();
                        $.each(obj.Records, function(index, val){
                            var ff = "";
                            if(val.correcta == 1){
                                ff = "checked =\"checked\"";
                            }
                            $("#data_qu").find("tbody").append(`<tr>
                            <td>`+val.id+`</td>
                            <td>`+val.alternativa+`</td>
                            <td style="text-align: center;">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="correc_`+val.id+`" `+ff+` disabled>
                                    <!--<label class="form-check-label" for="exampleCheck1">Check me out</label>-->
                                </div>
                            </td>
                            <td><span class="btn btn-danger btn-sm" onclick="del_alt(`+val.id+`);"><i class="fa fa-ban" ></i></span></td></tr>`);
                        });
                    });
                }
                function del_alt(id_alternativa){
                    $.post("'. $this->baseurl . INDEX . 'preguntas/eliminar_alternativa", {
                        id_alternativa: id_alternativa
                    }, function(response){
                        var obj = JSON.parse(response);
                        if(obj.Result == "OK"){
                            configurar(id_pregunta);
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                        }else{
                            alertify.notify("<strong>Algo ha salido terriblemente mal</strong>.", "custom-black", 3, function() {});
                        }
                    });
                }
                function editar(id){
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'preguntas/editar",
                        type: "POST",
                        dataType: "json",
                        data: {
                            "id_pregunta": id,
                        },
                        success: function(data) {
                            $("#pregunta").val(data.pregunta);
                            $("#exampleModalLabel").text("Editar Pregunta");

                            $("#btn_finalizar").text("Actualizar");
                            $("#btn_finalizar").attr("onclick", "actualizar_pregunta("+id+");");
                        }
                    });
                }
                $("#cerrar_formulario_docente").click(function(){
                    limpiar_formulario();
                });
                function guardar_pregunta(){
                    $.post("'. $this->baseurl . INDEX . 'preguntas/save", {
                        pregunta: $("#pregunta").val()
                    }, function(response){
                        var obj = JSON.parse(response);
                        if(obj.Result == "OK"){
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            alertify.notify("<strong>Pregunta</strong> agregada correctamente.", "custom-black", 3, function() {});
                            $("#btn_btn_cancelar").click();
                            limpiar_formulario();
                        }else{
                            alertify.notify("<strong>Algo ha salido terriblemente mal</strong>.", "custom-black", 3, function() {});
                        }
                    });
                }
                function actualizar_pregunta(id){
                    $.post("'. $this->baseurl . INDEX . 'preguntas/editarBD", {
                        id: id,
                        pregunta: $("#pregunta").val()
                    }, function(response){
                        var obj = JSON.parse(response);
                        if(obj.Result == "OK"){
                            $("#btn_btn_cancelar").click();
                            limpiar_formulario();
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            alertify.notify("<strong>Pregunta</strong> modificada correctamente.", "custom-black", 3, function() {});
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
