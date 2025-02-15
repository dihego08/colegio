<?php
    /*ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);*/
class html_salas extends f{
    private $baseurl = "";

    function html_salas(){
        $this->load()->lib_html("Table", false);
        $this->baseurl = BASEURL;
    }
    function container(){
        $r = '<div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="card mt-1">
                            <div class="card-header ">
                                <h4 class="card-title">Cursos de Hoy</h4>
                                <p class="card-category">Listado de Cursos que tocan hoy.</p>
                            </div>
                            <div class="card-body " id="div_temas_profesor_hoy">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!----------------------------------------------------------------------->
            <div class="modal fade" id="formulario_sala" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="max-width: 50%;">
                    <div class="modal-content" style="background-color: #f1f1f1; height: auto;">
                        <div class="modal-header" style="position: relative; padding-top: 0; padding-bottom: 0;">
                            <h3 class="modal-title mb-4 w-100 text-center" id="curso_nombre" style="border-bottom: solid #f3e444; color: #313131;">Crear Sala para la clase EN VIVO</h3>
                        </div>
                        <div class="modal-body pt-0">
                            <div class="form-row mb-3" style="width: 100%;" id="form_row_sala">
                                <div class="col-md-12 mb-2">
                                    <label for="">Ingresar Identificador de Sala (Alfanumerico)</label>
                                    <input type="text" name="" id="sala" class="form-control" placeholder="Ex: sala-452-tema">
                                </div>
                                <div class="col-md-12 text-right">
                                    <span class="btn btn-danger" type="button" data-dismiss="modal" id="cerrar_formulario_sala">
                                        Cerrar
                                    </span>
                                    <button class="btn btn-success" id="btn_crear_sala">Guardar</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!----------------------------------------------------------------------->

            <!----------------------------------------------------------------------->
            <div class="modal fade" id="formulario_externo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="max-width: 50%;">
                    <div class="modal-content" style="background-color: #f1f1f1; height: auto;">
                        <div class="modal-header" style="position: relative; padding-top: 0; padding-bottom: 0;">
                            <h3 class="modal-title mb-4 w-100 text-center" id="curso_nombre" style="border-bottom: solid #f3e444; color: #313131;">Añadir Enlace de Zoom o Meet</h3>
                        </div>
                        <div class="modal-body pt-0">
                            <div class="form-row mb-3" style="width: 100%;" id="form_row_sala">
                                <div class="col-md-12 mb-2">
                                    <label for="">Enlace de la reunion</label>
                                    <input type="text" name="" id="externo" class="form-control" placeholder="...">
                                </div>
                                <div class="col-md-12 text-right">
                                    <span class="btn btn-danger" type="button" data-dismiss="modal" id="cerrar_formulario_externo">
                                        Cerrar
                                    </span>
                                    <button class="btn btn-success" id="btn_crear_externo">Guardar</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!----------------------------------------------------------------------->

            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/jquery.datetimepicker.full.min.js"></script>
            <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/build/jquery.datetimepicker.min.css" rel="stylesheet"/>
            
            <script>
                $(document).ready(function () {
                    mis_cursos_profesor_hoy();
                });
                function mis_cursos_profesor_hoy() {
                    $.post("' . $this->baseurl . INDEX . 'salas/mis_cursos_profesor_hoy", function (data) {
                        var obj = JSON.parse(data);

                        $.each(obj, function (index, val) {
                            var sala = "";
                            if(val.sala == "sin_sala"){
                                sala = `<small data-toggle="modal" data-target="#formulario_sala" class="badge badge-info" style="cursor: pointer;" onclick="preparar_crear_sala(${val.id});">Crear Sala</small>`;
                            }else{
                                sala = `<small class="badge badge-info"><a href="transmision.html?sala=${val.sala}" style="color: #fff;">Ir a la Sala</a></small>`;
                            }
                            $("#div_temas_profesor_hoy").append(`
                                <div class="w-100 p-1 card">
                                    <h2 class="mb-0 mt-0">
                                        <a href="#" style="display: block; font-size: 16px;" class="w-100 text-left p-0">
                                            ${val.curso} - <small style="text-decoration: underline;">${val.profesor}</small>
                                        </a>
                                        <small style="display: block; color: #384253; font-size: 10px;" class="mt-1">${val.ciclo} - ${val.grupo}</small>
                                    </h2>
                                    <small class="my-1" style="color: #313131;"><i class="nc-icon nc-time-alarm icon-horario"></i> ${val.horario.inicio} - ${val.horario.fin}</small>
                                    <div class="card-body text-right">
                                        <small data-toggle="modal" data-target="#formulario_externo" class="badge badge-success" style="cursor: pointer;" onclick="preparar_crear_externo(${val.id});">MEET/ZOOM</small>
                                        ${sala}
                                    </div>
                                </div>
                            `);
                        });
                    });
                }
                function preparar_crear_sala(id_curso) {
                    $("#btn_crear_sala").attr("onclick", "crear_sala(" + id_curso + ")");
                }
                function preparar_crear_externo(id_curso){
                    $("#externo").val("");
                    $.post("' . $this->baseurl . INDEX . 'salas/devolver_sala", {
                        id_curso: id_curso,
                    }, function(response){
                        var obj = JSON.parse(response);

                        $("#externo").val(obj[0].externo);
                    });
                    $("#btn_crear_externo").attr("onclick", "crear_externo(" + id_curso + ")");
                }
                function crear_externo(id_curso) {
                    $.post("' . $this->baseurl . INDEX . 'salas/crear_externo", {
                        id_curso: id_curso,
                        externo: $("#externo").val()
                    }, function (data) {
                        var obj = JSON.parse(data);

                        if (obj.Result == "OK") {
                            mis_cursos_profesor_hoy();
                            alert("Hecho");
                        } else {
                            bootbox.alert({
                                message: `<div class="alert alert-danger" style="margin-top: 5%; margin-bottom: 0;">
                                    <strong>Algo ha salido mal.</strong>
                                </div>`
                            });
                        }
                    });
                }
                function crear_sala(id_curso) {
                    $.post("' . $this->baseurl . INDEX . 'salas/crear_sala", {
                        id_curso: id_curso,
                        sala: $("#sala").val()
                    }, function (data) {
                        var obj = JSON.parse(data);

                        if (obj.Result == "OK") {
                            /*window.location.href = "transmision.html?sala=" + $("#sala").val();*/
                            mis_cursos_profesor_hoy();
                            alert("Hecho");
                        } else {
                            bootbox.alert({
                                message: `<div class="alert alert-danger" style="margin-top: 5%; margin-bottom: 0;">
                                    <strong>Algo ha salido mal.</strong>
                                </div>`
                            });
                        }
                    });
                }
            </script>';     
            return $r;
        }
    }
?>
