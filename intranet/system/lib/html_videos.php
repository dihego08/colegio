<?php
class html_videos extends f
{
    private $baseurl = "";

    function html_videos()
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
                .table-bordered td, .table-bordered th{
                    font-size: 13px !important;
                }
            </style>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-3">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Nuevo Vídeo
                        </h5>
                        <small>
                            <i class="fa fa-edit"></i> Aquí podrá Agregar y Modificar la información de los Vídeos
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
                                <label>Curso</label>
                                <select id="id_curso" name="id_curso" class="form-control">
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label>Tema</label>
                                <input type="text" class="form-control" placeholder="Nombre del tema" id="tema">
                            </div>
                            <div class="col-md-12">
                                <label>Enlace Video</label>
                                <input type="text" name="video" id="video" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label>Fecha</label>
                                <input type="text" name="fecha" id="fecha" class="form-control datepicker">
                            </div>
                            <div class="col-md-12">
                                <label>Material Adicional</label>
                                <input type="file" name="material_adicional[]" id="material_adicional" multiple class="form-control">
                            </div>

                            <div class="col-md-12 mt-3">
                                <progress id="progressBar" class="mt-2" value="0" max="100" style="width:100%;"></progress>
                                <p id="status"></p>
                                <p id="loaded_n_total"></p>
                            </div>

                            <div class="col-md-12 mt-3">
                                <span onclick="guardar_video()" class="btn btn-success" style="width: 100%;">Guardar</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-9">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Lista de Vídeos
                        </h5>
                        <small>
                            <i class="fa fa-edit"></i> Aquí podrá ver toda la información de todos los Vídeos
                        </small>
                        <hr>         
                        <div class="container">
                            <div class="row">
                                <div class="table-responsive">
                                    <table  class="datatable table table-striped table-bordered dt-responsive wrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Ciclo</th>
                                                <th>Grupo</th>
                                                <th>Curso</th>
                                                <th>Tema</th>
                                                <th>Enlace</th>
                                                <th>Material Adicional</th>
                                                <th>Fecha</th>
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
            <div class="modal fade" id="formulario_3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="max-width: 80%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLabel">Lista de Materiales</h3>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close" id="close_formulario_3">
                                <span aria-hidden="true">×</span>
                            </button>

                        </div>

                        <div class="modal-body">
                            <div class="w-100 clase_preguntas">
                                <table  class="table table-striped table-bordered" id="tabla_materiales" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Material Adicional</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer text-right">
                            <!--<button class="btn btn-primary" id="btn_guardar_preguntas">Guardar</button>-->
                        </div>
                    </div>
                </div>
            </div>
            <!----------------------------------------------------------------------->

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
                function ver_materiales(id_video){
                    $.post("' . $this->baseurl . INDEX . 'videos/ver_materiales/", {
                        id_video: id_video
                    }, function(response){
                        var obj = JSON.parse(response);

                        $("#tabla_materiales").find("tbody").empty();

                        $.each(obj, function(index, val){
                            $("#tabla_materiales").find("tbody").append(`
                                <tr>
                                    <td>
                                        <a href="system/controllers/material_adicional/${val.material}" target="blank" style="display: block; white-space: break-spaces;">${val.material}</a>
                                    </td>
                                    <td></td>
                                </tr>
                            `);
                        });
                    });
                    $("#formulario_3").modal("show");
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

                function llenar_ciclos(){
                    $.post("' . $this->baseurl . INDEX . 'ciclos/loadciclos/", function(data){
                        var obj = JSON.parse(data);

                        $.each(obj, function(index, val){
                            $("#id_ciclo").append(`<option value="${val.id}">${val.ciclo}</option>`);
                        });
                    });
                }

                function llenar_cursos(id_grupo, id_curso){
                    $.post("' . $this->baseurl . INDEX . 'cursos/loadcursos", {
                        id_grupo: id_grupo
                    }, function(response){
                        var obj = JSON.parse(response);

                        $("#id_curso").empty();
                        $("#id_curso").append(`<option value="-1">--SELECCIONA--</option>`);
                        $.each(obj, function(index, val){
                            if(val.id == id_curso){
                                $("#id_curso").append(`<option value="${val.id}" selected>${val.curso}</option>`);
                            }else{
                                $("#id_curso").append(`<option value="${val.id}">${val.curso}</option>`);
                            }
                            
                        });
                    });
                }
                $(document).ready(function() {
                    $( ".datepicker" ).datetimepicker({
                        format: "Y-m-d",
                        timepicker:false
                    });
                    $(".timepicker").datetimepicker({
                        datepicker:false,
                        format:"H:i"
                    });
                    $.datetimepicker.setLocale(\'es\');

                    $(".js-example-basic-single").select2();

                    $("#id_ciclo").on("change", function(){
                        if($(this).val() == "-1" || $(this).val() == -1){
                        }else{
                            llenar_grupos($(this).val());
                        }
                    });

                    $("#id_grupo").on("change", function(){
                        if($(this).val() == "-1" || $(this).val() == -1){
                        }else{
                            llenar_cursos($(this).val(), 0);
                        }
                    });

                    llenar_ciclos();

                    $("#btn_funcion").attr("onclick", "guardar_categoria();");

                    var table = $(".datatable").DataTable({
                        "ajax": {
                            url: "' . $this->baseurl . INDEX . 'videos/loadvideos/",
                            "dataSrc": ""
                        },
                        "columns": [{
                            "data": "ciclo"
                        }, {
                            "data": "grupo"
                        }, {
                            "data": "curso"
                        }, {
                            "data": "tema",
                            "render": function(data){
                                return `<span class="" style="display: block; width: 100px; white-space: break-spaces;">${data}</span>`
                            }
                        }, {
                            "data": "video",
                            "render": function(data){
                                if(data.substring(1, 5) == "ifra"){
                                    return data;
                                }else{
                                    return "<a href=\""+data+"\" target=\"blank\" style=\"display: block; width: 100px; white-space: break-spaces;\">"+data+"</a>"
                                }
                            }
                        }, {
                            "defaultContent": "<button id=\"btn_materiales\" class=\"btn btn-info btn-sm\">Materiales</button>"
                        }, {
                            "data": "fecha"
                        }, {
                            "defaultContent": "<button id=\"btn_eliminar\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-trash\"></i></button>"
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

                    $(".datatable tbody").on("click", "#btn_materiales", function() {
                        var data = table.row($(this).parents("tr")).data();
                        if (data == undefined) {
                            var selected_row = $(this).parents("tr");
                            if (selected_row.hasClass("child")) {
                                selected_row = selected_row.prev();
                            }
                            var rowData = $(".datatable").DataTable().row(selected_row).data();
                            ver_materiales(rowData["id"]);
                        } else {
                            ver_materiales(data["id"]);
                        }
                    });
                    
                });
                function guardar_video(){
                    var formdata = new FormData();

                    for(var i = 0; i < _("material_adicional").files.length; i++){
                        formdata.append("file[]", _("material_adicional").files[i]);
                    }

                    formdata.append("id_curso", $("#id_curso").val());
                    formdata.append("video", $("#video").val());
                    formdata.append("tema", $("#tema").val());
                    formdata.append("fecha", $("#fecha").val());

                    var ajax = new XMLHttpRequest();
                    ajax.upload.addEventListener("progress", progressHandler, false);
                    ajax.addEventListener("load", completeHandler, false);
                    ajax.addEventListener("error", errorHandler, false);
                    ajax.addEventListener("abort", abortHandler, false);
                    ajax.open("POST", "' . $this->baseurl . INDEX . 'videos/save/");
                    ajax.send(formdata);
                }
                function load_modulos(){
                    $.get("' . $this->baseurl . INDEX . 'modulos/loadmodulos", function(response){
                        var obj = JSON.parse(response);
                        $.each(obj, function(index, val){
                            $("#id_modulo").append("<option value=" + val.id + ">" + val.modulo + "</option>");
                        });
                    });
                }
                function load_temas(id_modulo){
                    $("#id_tema").empty();
                    $.post("' . $this->baseurl . INDEX . 'temas/temamodulo", {
                        id_modulo: id_modulo
                    }, function(response){
                        var obj = JSON.parse(response);
                        $.each(obj.Records, function(index, val){
                            $("#id_tema").append("<option value=" + val.id + ">" + val.tema + "</option>");
                        });
                    });
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
                    $("#fecha").val("");
                    $("#video").val("");
    
                }
                function editar(id){
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'categorias/editar",
                        type: "POST",
                        dataType: "json",
                        data: {
                            "id_categoria": id,
                        },
                        success: function(data) {
                            $("#categoria").val(data.categoria);

                            $("#btn_funcion").text("Actualizar");
                            $("#btn_funcion").attr("onclick", "actualizar_categoria("+id+");");
                        }
                    });
                }
            </script>';
        return $r;
    }
}
