<?php
class html_biblioteca_contenido extends f{
    private $baseurl = "";

    function html_biblioteca_contenido(){
        $this->load()->lib_html("Table", false);
        $this->baseurl = BASEURL;
    }
    function container($id_carpeta){
        $r = '<style type="text/css">
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
            
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <hr>         
                        <div class="container" style="max-width: 100%;">
                            
                            <div class="row">
                                <div class="col-12">
                                    <p style="font-size: 50px;"><i class="fa fa-folder-open"></i> <span id="nombre_carpeta"></span>
                                    </p>
                                </div>
                                <div class="col-12 mt-2 form-row h-100">
                                    <div class="col-md-6 form-row">
                                        <h4 class="w-100">Cargar Archivo</h4>
                                        <div class="col-md-10">
                                            <input type="file" name="file1" id="file1" class="form-control h-100">
                                        </div>
                                        <div class="col-md-2">
                                            <button onclick="uploadFile()" class="btn btn-success"><i
                                                    class="fa fa-check"></i></button>
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-row">
                                        <h4 class="w-100">Crear Carpeta</h4>
                                        <div class="col-10">
                                            <input type="text" class="form-control h-100" id="nombre_carpeta_txt"
                                                placeholder="Nombre de la Carpeta">
                                        </div>
                                        <div class="col-2">
                                            <button class="btn btn-success" onclick="crear_carpeta();">Crear</button>
                                        </div>
                                    </div>


                                    <div class="col-md-12 mt-3">
                                        <progress id="progressBar" class="mt-2" value="0" max="100"
                                            style="width:100%;"></progress>
                                        <p id="status"></p>
                                        <p id="loaded_n_total"></p>
                                    </div>

                                    <h4>Contenido</h4>
                                    <div class="w-100 h-100 row" id="lista_contenido"
                                        style="background: #313131; color: #f9f9f9; padding: 10px; border-radius: 8px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                function data_carpeta(id_carpeta) {
                    $.post("' . $this->baseurl . INDEX . 'biblioteca_contenido/data_carpeta/", {
                        id_carpeta: id_carpeta
                    }, function (data) {
                        var obj = JSON.parse(data);

                        $("#nombre_carpeta").text(obj.nombre_carpeta);
                    });
                }
                function crear_carpeta() {
                    $.post("' . $this->baseurl . INDEX . 'biblioteca/crear_carpeta/", {
                        nombre_carpeta: $("#nombre_carpeta_txt").val(),
                        id_padre: id_carpeta
                    }, function (data) {
                        var obj = JSON.parse(data);

                        if (obj.Result == "OK") {
                            lista_contenido(id_carpeta);
                        } else {
                            alert(obj.Message);
                        }
                    });
                }
                function lista_contenido(id_carpeta) {
                    $("#lista_contenido").empty();
                    $.post("' . $this->baseurl . INDEX . 'biblioteca_contenido/lista_contenido/", {
                        id_carpeta: id_carpeta
                    }, function (data) {
                        var obj = JSON.parse(data);

                        $.each(obj, function (index, val) {
                            if(val.type == "A"){
                                $("#lista_contenido").append(`
                                    <div class="col-md-2">
                                        <div class="text-center">
                                            <span ondblclick="ir_archivo(\'${val.archivo}\');"><i class="fa fa-file" style="font-size: 50px; color: #f9f9f9;"></i></span><br>
                                            <span style="font-weight: bold;">${val.archivo}</span>
                                        </div>
                                    </div>
                                `);
                            }else{
                                $("#lista_contenido").append(`
                                    <div class="col-md-2">
                                        <div class="text-center">
                                            <span ondblclick="ir_carpeta(${val.id});"><i class="fa fa-folder" style="font-size: 50px; color: #ffa726;"></i></span><br>
                                            <span style="font-weight: bold;">${val.nombre_carpeta}</span>
                                        </div>
                                    </div>
                                `);
                            }
                            
                        });
                    });
                }
                function ir_archivo(nombre_archivo) {
                    window.location.href = "/BIBLIOTECA/" + $("#nombre_carpeta").text() + "/" + nombre_archivo;
                }

                function ir_carpeta(id_carpeta) {
                    //window.location.href = "la_carpeta.html?id_carpeta=" + id_carpeta;
                    window.location.href = "' . $this->baseurl . INDEX . 'biblioteca_contenido/index/"+id_carpeta;
                }
            </script>
            <script>
                function _(el) {
                    return document.getElementById(el);
                }
                function uploadFile() {
                    var file = _("file1").files[0];
                    var formdata = new FormData();
                    formdata.append("id_carpeta", id_carpeta);
                    formdata.append("file1", file);

                    var ajax = new XMLHttpRequest();
                    ajax.upload.addEventListener("progress", progressHandler, false);
                    ajax.addEventListener("load", completeHandler, false);
                    ajax.addEventListener("error", errorHandler, false);
                    ajax.addEventListener("abort", abortHandler, false);
                    ajax.open("POST", "' . $this->baseurl . INDEX . 'biblioteca_contenido/guardar_material_permanente/");
                    ajax.send(formdata);
                }
                function progressHandler(event) {
                    _("loaded_n_total").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
                    var percent = (event.loaded / event.total) * 100;
                    _("progressBar").value = Math.round(percent);
                    //lista_contenido(id_carpeta);
                }
                function completeHandler(event) {
                    lista_contenido(id_carpeta);
                    _("progressBar").value = 0;
                }
                function errorHandler(event) {
                    _("status").innerHTML = "Upload Failed";
                }
                function abortHandler(event) {
                    _("status").innerHTML = "Upload Aborted";
                }
            </script>
            <script>
                var id_carpeta = 0;
                $(document).ready(function () {
                    id_carpeta = '.$id_carpeta.';

                    data_carpeta(id_carpeta);
                    lista_contenido(id_carpeta);
                });
                function get_areas(universidad) {
                    $.post("../php/material.php", {
                        parAccion: "get_areas",
                        universidad: universidad
                    }, function (response) {
                        var obj = JSON.parse(response);
                        $("#carrera").empty();
                        $.each(obj, function (index, val) {
                            $("#carrera").append(`<option value="${val.id}">${val.universidad}</option>`);
                        });
                    });
                }
                function get_cursos(universidad) {
                    $.post("../php/material.php", {
                        parAccion: "get_carreras",
                        area: universidad,
                        universidad: $("#universidad").val()
                    }, function (response) {
                        var obj = JSON.parse(response);
                        $("#curso").empty();
                        $.each(obj, function (index, val) {
                            $("#curso").append(`<option value="${val.ID}">${val.NombreCurso}</option>`);
                        });
                    });
                }
                function all_materiales() {
                    $.post("../php/material.php", {
                        parAccion: "all_materiales_curso"
                    }, function (response) {
                        $("#tabla_videos").find("tbody").empty();
                        var obj = JSON.parse(response);
                        $.each(obj, function (index, val) {
                            $("#tabla_videos").find("tbody").append(`<tr>
                                <td>`+ val.id + `</td>
                                <td>${val.curso}</td>
                                <td>`+ val.nombre + `</td>
                                <td><a href="../material/`+ val.archivo + `" target="_blank">` + val.archivo + `</a></td>
                                <td><span class="btn btn-sm btn-danger" onclick="eliminar(`+ val.id + `);"><i class="fa fa-trash-alt"></i></span></td>
                            </tr>`);
                        });
                    });
                }
                function get_universidades() {
                    $.post("../php/material.php", {
                        parAccion: "get_universidades"
                    }, function (data) {
                        var obj = JSON.parse(data);
                        $("#universidad").append(`<option value="-1">SELECCIONA...</option>`);
                        $.each(obj, function (index, val) {

                            $("#universidad").append(`<option value="${val.id}">${val.universidad}</option>`);
                        });
                    });
                }
                function eliminar(id) {
                    $.ajax({
                        url: "../php/material.php",
                        type: "POST",
                        dataType: "html",
                        data: {
                            "id": id,
                            "parAccion": "eliminar",
                        },
                        success: function (data) {
                            all_materiales();
                        }
                    });
                }
            </script>
            ';     
            return $r;
        }
    }
?>
