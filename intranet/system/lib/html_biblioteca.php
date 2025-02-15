<?php
class html_biblioteca extends f{
    private $baseurl = "";

    function html_biblioteca(){
        $this->load()->lib_html("Table", false);
        $this->baseurl = BASEURL;
    }
    function container(){
        $r = '
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Lista de Biblioteca
                        </h5>
                        <small>
                            <i class="fa fa-edit"></i> Aquí podrá ver toda la información de todos los Biblioteca
                        </small>
                        <hr>         
                        <div class="container">
                            <div class="row">
                                <h4 class="w-100">Crear Carpeta</h4>
                                <div class="col-10">
                                    <input type="text" class="form-control h-100" id="nombre_carpeta" placeholder="Nombre de la Carpeta">
                                </div>
                                <div class="col-2">
                                    <button class="btn btn-success" onclick="crear_carpeta();">Crear</button>
                                </div>
                                <div class="col-12 mt-2 h-100">
                                    <h4>Lista de Carpetas</h4>
                                    <div class="w-100 h-100 row" id="lista_carpetas"
                                        style="background: #313131; color: #f9f9f9; padding: 10px; border-radius: 8px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                function crear_carpeta() {
                    $.post("' . $this->baseurl . INDEX . 'biblioteca/crear_carpeta/", {
                        nombre_carpeta: $("#nombre_carpeta").val()
                    }, function (data) {
                        var obj = JSON.parse(data);

                        if (obj.Result == "OK") {
                            lista_carpetas();
                        } else {
                            alert(obj.Message);
                        }
                    });
                }
                function lista_carpetas() {
                    $("#lista_carpetas").empty();
                    $.post("' . $this->baseurl . INDEX . 'biblioteca/lista_carpetas/", {
                        nombre_carpeta: $("#nombre_carpeta").val()
                    }, function (data) {
                        var obj = JSON.parse(data);

                        $.each(obj, function (index, val) {
                            $("#lista_carpetas").append(`
                                
                                <div class="col-md-2">
                                    <div class="text-center">
                                        <span ondblclick="ir_carpeta(${val.id});"><i class="fa fa-folder" style="font-size: 50px; color: #ffa726;"></i></span><br>
                                        <span style="font-weight: bold;">${val.nombre_carpeta}</span>
                                    </div>
                                </div>
                            `);
                        });
                    });
                }
                function ir_carpeta(id_carpeta) {
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
                    formdata.append("parAccion", "guardar_material_curso");
                    formdata.append("id_curso", $("#curso").val());
                    formdata.append("nombre", $("#nombre").val());
                    formdata.append("universidad", $("#universidad").val());
                    formdata.append("file1", file);


                    //universidad: $("#universidad").val()
                    var ajax = new XMLHttpRequest();
                    ajax.upload.addEventListener("progress", progressHandler, false);
                    ajax.addEventListener("load", completeHandler, false);
                    ajax.addEventListener("error", errorHandler, false);
                    ajax.addEventListener("abort", abortHandler, false);
                    ajax.open("POST", "../php/material.php");
                    ajax.send(formdata);
                }
                function progressHandler(event) {
                    _("loaded_n_total").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
                    var percent = (event.loaded / event.total) * 100;
                    _("progressBar").value = Math.round(percent);
                    all_materiales();
                }
                function completeHandler(event) {
                    all_materiales();
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

                $(document).ready(function () {
                    lista_carpetas();

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
