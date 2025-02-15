<?php
class html_videos_web extends f
{
    private $baseurl = "";

    function html_videos_web()
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
                    <div class="col-12 col-md-4">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Nuevo Vídeo
                        </h5>
                        <small>
                            <i class="fa fa-edit"></i> Aquí podrá Agregar y Modificar la información de los Vídeos
                        </small>
                        <hr>
                        <div class="form-row">
                            <div class="col-md-12">
                                <label>Vídeo Nosotros</label>
                                <input type="text" name="nosotros" id="nosotros" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label>Vídeo Web</label>
                                <input type="text" name="pagina" id="pagina" class="form-control">
                            </div>
                            <div class="col-md-12 mt-3">
                                <progress id="progressBar" class="mt-2" value="0" max="100" style="width:100%;"></progress>
                                <p id="status"></p>
                                <p id="loaded_n_total"></p>
                            </div>
                            <div class="col-md-12 mt-3">
                                <span onclick="guardar_video()" id="btn_funcion" class="btn btn-success" style="width: 100%;">Guardar</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-8">
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
                                    <table  class="datatable table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Nosotros</th>
                                                <th>Pagina</th>
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
                
                $(document).ready(function() {
                    
                    $(".js-example-basic-single").select2();

                    load_modulos();

                    $("#id_modulo").on("change", function(){
                        load_temas($("#id_modulo").val());
                    });

                    $("#btn_funcion").attr("onclick", "guardar_categoria();");

                    var table = $(".datatable").DataTable({
                        "ajax": {
                            url: "' . $this->baseurl . INDEX . 'videos_web/loadvideos/",
                            "dataSrc": ""
                        },
                        "columns": [ {
                            "defaultContent": `<button id="btn_editar" class="w-100 btn btn-warning btn-sm" style="display: block;"><i class="fa fa-pencil"></i></button>`+"<button id=\"btn_eliminar\" class=\"btn btn-danger btn-sm w-100 mt-1\" style=\"display: block;\"><i class=\"fa fa-trash\"></i></button>"
                        }, {
                            "data": "nosotros",
                            "render": function(data){
                                return `<div >${data}</div>`
                            }
                        }, {
                            "data": "pagina",
                            "render": function(data){
                                return `<div >${data}</div>`
                            }
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
                function guardar_video(){
                    $.post("' . $this->baseurl . INDEX . 'videos_web/save", {
                        nosotros: $("#nosotros").val(),
                        pagina: $("#pagina").val(),
                    }, function(response){
                        var obj = JSON.parse(response);
                        if(obj.Result == "OK"){
                            limpiar_formulario();
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            alertify.notify("<strong>Videos</strong> agregada correctamente.", "custom-black", 3, function() {});
                        }else{
                            alertify.notify("<strong>Algo ha salido terriblemente mal</strong>.", "custom-black", 3, function() {});
                        }
                    });
                }
                function actualizar_video(id){
                    $.post("' . $this->baseurl . INDEX . 'videos_web/editarBD", {
                        nosotros: $("#nosotros").val(),
                        pagina: $("#pagina").val(),
                        id: id
                    }, function(response){
                        var obj = JSON.parse(response);
                        if(obj.Result == "OK"){
                            limpiar_formulario();
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            alertify.notify("<strong>Videos</strong> actualizado correctamente.", "custom-black", 3, function() {});
                        }else{
                            alertify.notify("<strong>Algo ha salido terriblemente mal</strong>.", "custom-black", 3, function() {});
                        }
                    });
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
                        url: "' . $this->baseurl . INDEX . 'videos_web/eliminar",
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
                    $("#nosotros").val("");
                    $("#pagina").val("");
                    
                    $("#btn_funcion").text("Guardar");
                    $("#btn_funcion").attr("onclick", "guardar_video();");
                }
                function editar(id){
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'videos_web/editar",
                        type: "POST",
                        dataType: "json",
                        data: {
                            "id": id,
                        },
                        success: function(data) {
                            $("#nosotros").val(data.nosotros);
                            $("#pagina").val(data.pagina);

                            $("#btn_funcion").text("Actualizar");
                            $("#btn_funcion").attr("onclick", "actualizar_video("+id+");");
                        }
                    });
                }
            </script>';
        return $r;
    }
}
