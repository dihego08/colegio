<?php
    /*ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);*/
class html_examenes extends f{
    private $baseurl = "";

    function html_examenes(){
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

                .ltr{
                    background: #333;
                    color: white;
                    font-weight: bold;
                    border-radius: 50%;
                    padding: 1px 5px;
                    font-size: 15px;
                }
                table.dataTable.nowrap th{
                	font-size: 10px;
                }
            </style>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-3">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Nuevo Examen
                        </h5>
                        <small>
                            <i class="fa fa-edit"></i> Aquí podrá Agregar y Modificar la información de los Examenes
                        </small>
                        <hr>
                        <div class="form-row">
                            <div class="col-md-12">
                                <label class="bold">Ciclo Academico</label><br>
                                <select class="form-control" id="id_ciclo">
                                    <option value="-1">--SELECCIONA--</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="bold">Grupo</label><br>
                                <select class="form-control" id="id_grupo">
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label>Area</label>
                                <select class="js-example-basic-single form-control w-100" id="id_area" name="id_area">
                                    <option value="0">SELECCIONA...</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label>Fecha</label>
                                <input type="text" name="fecha" id="fecha" class="form-control datepicker">
                            </div>
                            <div class="col-md-12 mt-1">
                                <label>Identificador</label>
                                <input type="text" name="identificador" id="identificador" class="form-control">
                            </div>
                            <div class="col-md-12 mt-1">
                                <label>N° Preguntas</label>
                                <input type="text" name="n_preguntas" id="n_preguntas" class="form-control">
                            </div>
                            <div class="col-md-12 mt-3">
                                <progress id="progressBar" class="mt-2" value="0" max="100" style="width:100%;"></progress>
                                <p id="status"></p>
                                <p id="loaded_n_total"></p>
                            </div>
                            <div class="col-md-12 mt-3">
                                <span class="btn btn-success" id="btn_funcion" onclick="guardar_examen();" style="width: 100%;">Guardar</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-9">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Lista de Examenes
                        </h5>
                        <small>
                            <i class="fa fa-edit"></i> Aquí podrá ver toda la información de todos los Examenes
                        </small>
                        <hr>         
                        <div class="container">
                            <div class="row">
                                <div class="table-responsive" >
                                    <table  class="datatable table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr style="font-size: 15px;">
                                                <th>Id</th>
                                                <th>Exámen</th>
                                                <th>Área</th>
                                                <th>Día</th>
                                                <th>Preg.</th>
                                                <th>Ciclo -<br>Grupo</th>
                                                <th>N° P.</th>
                                                <th>Res.</th>
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
                            <h3 class="modal-title" id="exampleModalLabel">Configuración de Respuestas</h3>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>

                        </div>

                        <div class="modal-body">
                            <div style="width: 100%;">
                                <!--<span class="btn btn-success btn-sm" style="float: right; margin-bottom: 10px;:" data-toggle="modal" data-target="#add_pregunta">Añadir Pregunta</span>-->
                            </div>
                            <div class="form-row" style="width: 100%;" id="cuerpo_respuestas">
                                
                            </div>
                        </div>
                        <div class="modal-footer text-right">
                            <button class="btn btn-primary" id="btn_guardar_respuestas">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!----------------------------------------------------------------------->
            <!----------------------------------------------------------------------->
            <div class="modal fade" id="formulario_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="max-width: 80%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLabel">Cargar Excel de Respuestas</h3>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close" id="close_formulario_2">
                                <span aria-hidden="true">×</span>
                            </button>

                        </div>

                        <div class="modal-body">
                            <div class="w-100">
                                <h4>Seleccionar Archivo</h4>
                                <div class="col-md-12">
                                    <label>Archivo</label>
                                    <input type="file" name="file1_alt" id="file1_alt" class="form-control">
                                </div>
                                <div class="col-md-12 mt-3">
                                    <progress id="progressBar" class="mt-2" value="0" max="100" style="width:100%;"></progress>
                                    <p id="status"></p>
                                    <p id="loaded_n_total"></p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer text-right">
                            <button class="btn btn-primary" id="btn_guardar_respuestas_alt">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!----------------------------------------------------------------------->
            <!----------------------------------------------------------------------->
            <div class="modal fade" id="formulario_3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="max-width: 80%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLabel">Cargar Preguntas</h3>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close" id="close_formulario_3">
                                <span aria-hidden="true">×</span>
                            </button>

                        </div>

                        <div class="modal-body">
                            <div class="w-100 clase_preguntas">
                                
                            </div>
                        </div>
                        <div class="modal-footer text-right">
                            <!--<button class="btn btn-primary" id="btn_guardar_preguntas">Guardar</button>-->
                        </div>
                    </div>
                </div>
            </div>
            <!----------------------------------------------------------------------->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/jquery.datetimepicker.full.min.js"></script>
            <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/build/jquery.datetimepicker.min.css" rel="stylesheet"/>
            <script>
                function _(el){
                    return document.getElementById(el);
                }
                function uploadFile(){
                    var file = _("file1").files[0];
                    var formdata = new FormData();
                    formdata.append("file1", file);
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
                        alertify.notify("Algo ha salido mal.</strong>", "custom-black", 4, function() {});
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
            </script>
            <script>
                var id_ranking = 0;
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
                        $.each(obj, function(index, val){
                            if(val.id == id_grupo){
                                $("#id_grupo").append(`<option value="${val.id}" selected>${val.grupo}</option>`);
                            }else{
                                $("#id_grupo").append(`<option value="${val.id}">${val.grupo}</option>`);
                            }
                        });
                    });
                }
                function load_areas(){
                    $.post("' . $this->baseurl . INDEX . 'areas/loadareas", function(response){
                        var obj = JSON.parse(response);
                        $.each(obj, function(index, val){
                            $("#id_area").append("<option value=" + val.id + ">" + val.area + "</option>");
                        });
                    });
                }
                function nueva_pregunta(){
                    $.post("' . $this->baseurl . INDEX . 'preguntas/save", {
                        pregunta: $("#pregunta").val()
                    }, function(response){
                        var obj = JSON.parse(response);
                        if(obj.Result == "OK"){
                            $("#btn_btn_cancelar").click();
                            configurar(id_ranking);
                            $("#pregunta").val("");
                        }else{
                            alertify.notify("<strong>Algo ha salido muy mal</strong>.", "custom-black", 4, function() {});
                        }
                    });
                }
                function add(id_ranking, id_pregunta){
                    $.post("' . $this->baseurl . INDEX . 'examenes_2/save_que", {
                        id_ranking: id_ranking,
                        id_pregunta: id_pregunta
                    }, function(response){
                        var obj = JSON.parse(response);
                        if(obj.Result == "OK"){
                            configurar(id_ranking);
                            $("#btn_a_" + id_pregunta).text("Added");
                        }else{
                            alertify.notify("<strong>Algo ha salido muy mal</strong>.", "custom-black", 4, function() {});
                        }
                    });
                }
                function drop(id_pregunta_examen){
                    $.post("' . $this->baseurl . INDEX . 'preguntas/del_que", {
                        id: id_pregunta_examen
                    }, function(response){
                        var obj = JSON.parse(response);
                        if(obj.Result == "OK"){
                            //(this).text("añadido");
                            configurar(id_ranking);
                        }else{
                            alertify.notify("<strong>Algo ha salido muy mal</strong>.", "custom-black", 4, function() {});
                        }
                    });
                }
                $(document).ready(function() {
                	load_areas();
                    $(".datepicker").datetimepicker({
                        format: "Y-m-d",
                        timepicker:false
                    });
                    $.datetimepicker.setLocale("es");
                    $(".js-example-basic-single").select2();

                    llenar_ciclos();

                    $("#id_ciclo").on("change", function(){
                        if($(this).val() == "-1" || $(this).val() == -1){
                        }else{
                            llenar_grupos($(this).val());
                        }
                    });

                    limpiar_formulario();

                    var table = $(".datatable").DataTable({
                        "ajax": {
                            url: "' . $this->baseurl . INDEX . 'examenes/loadexamenes/",
                            "dataSrc": ""
                        },
                        "columns": [{
                            "data": "id"
                        }, {
                            "data": "identificador"
                        }, {
                            "data": "area"
                        },  {
                            "data": "fecha"
                        }, {
                            "defaultContent": "<button data-toggle=\"modal\" data-target=\"#formulario_3\" id=\"btn_add_preguntas\" class=\"btn btn-success btn-sm w-100\"><i class=\"fa fa-search-plus\"></i></button>"
                        },  {
                            "data": "ciclo"
                        }, {
                            "data": "n_preguntas"
                        }, {
                            "defaultContent": "<button data-toggle=\"modal\" data-target=\"#formulario_2\" id=\"btn_configurar\" class=\"btn btn-success btn-sm w-100\"><i class=\"fa fa-search-plus\"></i></button>"
                        }, {
                            "defaultContent": "<button id=\"btn_editar\" class=\"btn btn-warning btn-sm w-100\" style=\"display: block;\"><i class=\"fa fa-pencil\"></i></button> <button id=\"btn_eliminar\" class=\"btn btn-danger btn-sm w-100 mt-1\" style=\"display: block;\"><i class=\"fa fa-trash\"></i></button>"
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
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el Ranking <strong>" + rowData["identificador"] + "</strong>?",
                            function() {
                                eliminar(rowData["id"]);
                                alertify.notify("Se elimino el Ranking <strong>" + rowData["identificador"] + "</strong> correctamente.", "custom-black", 4, function() {});
                            },
                            function() {
                                alertify.notify("Se cancelo la <strong>eliminación</strong>.", "custom-black", 4, function() {});
                            }).set("labels", { ok: "Eliminar", cancel: "Cancelar" });
                        } else {
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el Ranking <strong>" + data["identificador"] + "</strong>?",
                            function() {
                                eliminar(data["id"]);
                                alertify.notify("Se elimino el Ranking <strong>" + data["identificador"] + "</strong> correctamente.", "custom-black", 4, function() {});
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
                    $(".datatable tbody").on("click", "#btn_add_preguntas", function() {
                        var data = table.row($(this).parents("tr")).data();
                        if (data == undefined) {
                            var selected_row = $(this).parents("tr");
                            if (selected_row.hasClass("child")) {
                                selected_row = selected_row.prev();
                            }
                            var rowData = $(".datatable").DataTable().row(selected_row).data();
                            add_preguntas(rowData["id"], rowData["n_preguntas"]);
                        } else {
                            add_preguntas(data["id"], data["n_preguntas"]);
                        }
                    });
                    $(".datatable tbody").on("click", "#btn_configurar", function() {
                        var data = table.row($(this).parents("tr")).data();
                        if (data == undefined) {
                            var selected_row = $(this).parents("tr");
                            if (selected_row.hasClass("child")) {
                                selected_row = selected_row.prev();
                            }
                            var rowData = $(".datatable").DataTable().row(selected_row).data();
                            alternativas(rowData["id"], rowData["n_preguntas"]);
                        } else {
                            alternativas(data["id"], data["n_preguntas"]);
                        }
                    });
                    $(".datatable tbody").on("click", "#btn_preview", function() {
                        var data = table.row($(this).parents("tr")).data();
                        if (data == undefined) {
                            var selected_row = $(this).parents("tr");
                            if (selected_row.hasClass("child")) {
                                selected_row = selected_row.prev();
                            }
                            var rowData = $(".datatable").DataTable().row(selected_row).data();
                            preview(rowData["id"]);
                        } else {
                            preview(data["id"]);
                        }
                    });
                });
                function preview(id){
                    $.post("' . $this->baseurl . INDEX . 'examenes_2/preview", {
                        id: id
                    }, function(response){
                        var obj = JSON.parse(response);
                        var html = "";
                        $.each(obj.QUES, function(index, val){
                            html += `<p class="mt-2" style="font-weight: bold;">`+parseInt(index + 1) + `.- `+val.pregunta+`</p>`;
                            $.each(val.alternativas, function(i, v){
                                html += `<p class="p-0 m-0" style="border-bottom: solid 1px rgba(0, 0, 0, .3);"><span class="ltr">`+ get_letra(i) + `</span> ` +v.alternativa+`</p>`;
                            });
                        });
                        $("#preguntas").append(html);
                    });
                }
                function add_preguntas(id, n_preguntas){
                    $(".clase_preguntas").empty();
                    for(var i = 1; i <= n_preguntas; i++){

                        $(".clase_preguntas").append(`
                            <div class="col-md-12" >
                                <h5>Pregunta `+i+`</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label style="font-weight: bold;">Enunciado</label>
                                        <input type="file" id="enunciado_`+i+`" name="file_file" class="form-control input_file_enunciado">
                                        <img class="mt-2" src="" id="enunciado_id_${i}" style="box-shadow: 0px 1px 5px 1px #313131;">
                                    </div>
                                    <div class="col-md-6">
                                        <label style="font-weight: bold;">Pregunta</label>
                                        <input type="file" id="pregunta_`+i+`" name="file_file" class="form-control input_file_pregunta">
                                        <img class="mt-2" src="" id="pregunta_id_${i}" style="box-shadow: 0px 1px 5px 1px #313131;">
                                    </div>
                                </div>
                                
                                <input type="hidden" id="h_pregunta_`+i+`" value="${i}">
                            </div>
                            <hr class="w-100">
                        `);
                    }


                    $.post("' . $this->baseurl . INDEX . 'examenes/get_preguntas_guardadas", {
                        id_ranking: id
                    }, function(response){
                        var obj = JSON.parse(response);

                        $.each(obj, function(index, val){
                            $("#enunciado_id_"+val.n_pregunta).attr("src", "../intranet/system/controllers/ranking_"+id+"/"+val.enunciado);
                            $("#pregunta_id_"+val.n_pregunta).attr("src", "../intranet/system/controllers/ranking_"+id+"/"+val.pregunta);
                        });
                    });

                    $("#btn_guardar_preguntas").attr("onclick", "guardar_preguntas("+id+");");
                    
                    $($(".input_file_pregunta")).change(function(e){
                        var id_rescatado = $(this).attr("id");
                        guardar_imagen_pregunta(id_rescatado, id);
                    });

                    $($(".input_file_enunciado")).change(function(e){
                        var id_rescatado = $(this).attr("id");
                        guardar_imagen_enunciado(id_rescatado, id);
                    });
                }
                function guardar_imagen_enunciado(id_input_file, id_ranking){
                    var file = _(id_input_file).files[0];
                    var formdata = new FormData();
                    formdata.append("file1", file);
                    
                    var n_pregunta = id_input_file.split("_");

                    formdata.append("id", id_ranking);
                    formdata.append("n_pregunta", n_pregunta[1]);
                    var ajax = new XMLHttpRequest();
                    ajax.upload.addEventListener("progress", progressHandler, false);
                    ajax.addEventListener("load", completeHandler, false);
                    ajax.addEventListener("error", errorHandler, false);
                    ajax.addEventListener("abort", abortHandler, false);
                    ajax.open("POST", "'.$this->baseurl . INDEX . 'examenes/save_preguntas_enunciado");
                    ajax.send(formdata);
                }
                function guardar_imagen_pregunta(id_input_file, id_ranking){
                    var file = _(id_input_file).files[0];
                    var formdata = new FormData();
                    formdata.append("file1", file);
                    
                    var n_pregunta = id_input_file.split("_");

                    formdata.append("id", id_ranking);
                    formdata.append("n_pregunta", n_pregunta[1]);
                    var ajax = new XMLHttpRequest();
                    ajax.upload.addEventListener("progress", progressHandler, false);
                    ajax.addEventListener("load", completeHandler, false);
                    ajax.addEventListener("error", errorHandler, false);
                    ajax.addEventListener("abort", abortHandler, false);
                    ajax.open("POST", "'.$this->baseurl . INDEX . 'examenes/save_preguntas");
                    ajax.send(formdata);
                }
                function get_letra(i){
                    var letras = ["A", "B", "C", "D", "E", "F", "G", "H"];
                    return letras[i];
                }
                function eliminar(id) {
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'examenes/eliminar",
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
                    $("#identificador").val("");
                    $("#duracion").val("");
                    $("#fecha_inicio").val("");
                    $("#fecha_fin").val("");
                    $("#dia").val("");
                    $("#n_preguntas").val("");
                    $("#btn_funcion").attr("onclick", "guardar_examen();");
                    $("#btn_funcion").text("Guardar");
                }
                function alternativas(id, n_preguntas){
                    $("#btn_guardar_respuestas_alt").attr("onclick", "guardar_respuestas("+id+", "+n_preguntas+");");
                }
                function guardar_respuestas(id_examen, n_preguntas){
                    var file = _("file1_alt").files[0];
                    var formdata = new FormData();
                    formdata.append("file1", file);

                    formdata.append("id_examen", id_examen);
                    formdata.append("n_preguntas", n_preguntas);
                    
                    var ajax = new XMLHttpRequest();
                    ajax.upload.addEventListener("progress", progressHandler, false);
                    ajax.addEventListener("load", completeHandler, false);
                    ajax.addEventListener("error", errorHandler, false);
                    ajax.addEventListener("abort", abortHandler, false);
                    ajax.open("POST", "'.$this->baseurl . INDEX . 'examenes/save_respuestas_alt");
                    ajax.send(formdata);

                    $("#close_formulario_2").click();
                }
                function editar(id){
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'examenes/editar",
                        type: "POST",
                        dataType: "json",
                        data: {
                            "id_ranking": id,
                        },
                        success: function(data) {
                            $("#identificador").val(data.identificador);

                            $("#id_modulo").select2("val", data.id_modulo);

                            $("#id_area").select2("val", data.id_area);

                            $("#iframe").val(data.archivo);

                            $("#fecha").val(data.fecha);
                            $("#n_preguntas").val(data.n_preguntas);

                            $("#id_ciclo").val(data.id_ciclo);
                            llenar_grupos(data.id_ciclo, data.id_grupo);

                            $("#btn_funcion").text("Actualizar");
                            $("#btn_funcion").attr("onclick", "actualizar_examen("+id+");");
                        }
                    });
                }
                $("#cerrar_formulario_docente").click(function(){
                    limpiar_formulario();
                });
                function guardar_examen(){
                    var formdata = new FormData();

                    formdata.append("iframe", $("#iframe").val());
                    
                    formdata.append("id_modulo", $("#id_modulo").val());
                    formdata.append("identificador", $("#identificador").val());
                    formdata.append("duracion", $("#duracion").val());
                    formdata.append("fecha_inicio", $("#fecha_inicio").val());
                    formdata.append("fecha_fin", $("#fecha_fin").val());
                    formdata.append("fecha", $("#fecha").val());
                    formdata.append("n_preguntas", $("#n_preguntas").val());
                    formdata.append("id_grupo", $("#id_grupo").val());

                    formdata.append("id_area", $("#id_area").val());
                    
                    var ajax = new XMLHttpRequest();
                    ajax.upload.addEventListener("progress", progressHandler, false);
                    ajax.addEventListener("load", completeHandler, false);
                    ajax.addEventListener("error", errorHandler, false);
                    ajax.addEventListener("abort", abortHandler, false);
                    ajax.open("POST", "'.$this->baseurl . INDEX . 'examenes/save");
                    ajax.send(formdata);
                }
                function guardar_preguntas(id){
                    //var file = _("file1").files[0];
                    var formdata = new FormData();
                    //formdata.append("file1", file);

                    for(var i = 1; i <= 50; i++){
                        formdata.append("file"+i, _("pregunta_"+i).files[0]);
                    }

                    formdata.append("id", id);
                    var ajax = new XMLHttpRequest();
                    ajax.upload.addEventListener("progress", progressHandler, false);
                    ajax.addEventListener("load", completeHandler, false);
                    ajax.addEventListener("error", errorHandler, false);
                    ajax.addEventListener("abort", abortHandler, false);
                    ajax.open("POST", "'.$this->baseurl . INDEX . 'examenes/save_preguntas");
                    ajax.send(formdata);
                }
                function actualizar_examen(id){
                    var formdata = new FormData();

                    formdata.append("iframe", $("#iframe").val());

                    formdata.append("id_modulo", $("#id_modulo").val());
                    formdata.append("identificador", $("#identificador").val());
                    formdata.append("duracion", $("#duracion").val());
                    formdata.append("fecha_inicio", $("#fecha_inicio").val());
                    formdata.append("fecha_fin", $("#fecha_fin").val());
                    formdata.append("fecha", $("#fecha").val());
                    formdata.append("n_preguntas", $("#n_preguntas").val());
                    formdata.append("id_grupo", $("#id_grupo").val());

                    formdata.append("id_area", $("#id_area").val());

                    formdata.append("id", id);
                    var ajax = new XMLHttpRequest();
                    ajax.upload.addEventListener("progress", progressHandler, false);
                    ajax.addEventListener("load", completeHandler, false);
                    ajax.addEventListener("error", errorHandler, false);
                    ajax.addEventListener("abort", abortHandler, false);
                    ajax.open("POST", "'.$this->baseurl . INDEX . 'examenes/editarBD");
                    ajax.send(formdata);
                }
            </script>';     
            return $r;
        }
    }
?>
