<?php

class html_cursos_alumno extends f
{
    private $baseurl = "";

    function html_cursos_alumno()
    {
        $this->load()->lib_html("Table", false);
        $this->baseurl = BASEURL;
    }
    function container($id_alumno)
    {
        $r = '
            <style>
                .bold{
                    font-weight: bold;
                }
                @media print {
                    .hideprint {
                        visibility: hidden;
                    }
                    .main-panel {
                        width: 100% !important;
                    }
                    #DataTables_Table_0_info{
                        visibility: hidden;
                    }
                    #DataTables_Table_0_paginate{
                        visibility: hidden;
                    }
                    #DataTables_Table_0_length{
                        visibility: hidden;
                    }
                }
                    .border-dark {
	border-color: #343a40 !important;
}
    .card-header:first-child {
	border-radius: calc(.25rem - 1px) calc(.25rem - 1px) 0 0;
}
    .text-dark {
	color: #343a40 !important;
}
    .card-body {
	-webkit-box-flex: 1;
	-ms-flex: 1 1 auto;
	flex: 1 1 auto;
	padding: 1.25rem;
}
    .card {
	position: relative;
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	-webkit-box-orient: vertical;
	-webkit-box-direction: normal;
	-ms-flex-direction: column;
	flex-direction: column;
	min-width: 0;
	word-wrap: break-word;
	background-color: #fff;
	background-clip: border-box;
	border: 1px solid rgba(0,0,0,.125);
	border-radius: .25rem;
}
    .card-header {
	padding: .75rem 1.25rem !important;
	margin-bottom: 0;
	background-color: rgba(0,0,0,.03) !important;
	border-bottom: 1px solid rgba(0,0,0,.125) !important;
}
            </style>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Lista de Cursos del Alumno
                        </h5>
                        <small>
                            <i class="fa fa-edit"></i> Acciones de agregar comentarios.
                        </small>
                        <hr>         
                        <div class="container">
                            <div class="row">
                                <div class="table-responsive" >
                                    <table  class="datatable table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Curso</th>
                                                <th>Promedio</th>
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
                <div class="modal-dialog" role="document" style="max-width: 50%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLabel">Comentarios del Alumno</h3>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group" style="width: 100%;">
                                <div class="col-12 mb-2">
                                    <label for="">Comentario - Observación</label>
                                    <textarea class="form-control" id="comentario"></textarea>
                                </div>
                                <div class="form-row">
                                    <button type="submit" class="btn btn-outline-success btn-sm" id="btn_finalizar">Guardar</button>
                                    <span class="btn btn-outline-danger btn-sm" type="button" data-dismiss="modal" id="cerrar_formulario_docente" style="margin-left: 10px">
                                        Cancelar
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="row w-100" id="div-comentarios"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!----------------------------------------------------------------------->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>
            <script>
                function llenar_grados(id_alumno){
                    $.post("' . $this->baseurl . INDEX . 'grados/loadgrados/", function(response){
                        var obj = JSON.parse(response);
                        $("#id_grado").empty();
                        $("#id_grado").append(`<option value="0">--SELECCIONAR--</option>`);
                        $.each(obj, function(index, val){
                            $("#id_grado").append(`<option value="${val.id}">${val.grado}</option>`);
                        });
                    });
                }
                function get_comentarios(id_alumno, id_curso){
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'cursos_alumno/loadcomentarios",
                        type: "POST",
                        dataType: "json",
                        data: {
                            "id_usuario": id_alumno,
                            "id_curso": id_curso
                        },
                        success: function(data) {
                            $("#div-comentarios").empty();
                            $.each(data, function(index, val){
                                $("#div-comentarios").append(`<div class="col-md-4"><div class="card border-dark mb-3" style="max-width: 18rem;">
                                    <div class="card-header">
                                        <div class="form-row">
                                            <div class="col-8">
                                                ${val.fecha}
                                            </div>
                                            <div class="col-4">
                                                <span class="btn btn-sm btn-outline-danger" title="Eliminar Comentario" onclick="eliminar(${val.id}, ${val.id_curso});"><i class="fa fa-trash"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body text-dark">
                                        <!--<h5 class="card-title">Dark card title</h5>-->
                                        <p class="card-text">${val.comentario}</p>
                                    </div>
                                    </div>
                                </div>`);
                            });
                        }
                    });
                }
                function eliminar(id, id_curso) {
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'cursos_alumno/eliminar",
                        type: "POST",
                        dataType: "html",
                        data: {
                            "id": id,
                        },
                        success: function(data) {
                            get_comentarios('.$id_alumno.', id_curso);
                        }
                    });
                }
                function limpiar_formulario(){
                    $("#comentario").val("");
                }
                function nuevo_comentario(id_curso){
                    $("#exampleModalLabel").text("Nuevo Comentario");
                    $("#btn_finalizar").text("Guardar");
                    $("#btn_finalizar").attr("onclick", "guardar_comentario("+id_curso+");");
                    limpiar_formulario();
                    get_comentarios(' . $id_alumno . ', id_curso);
                }
                function guardar_comentario(id_curso){
                    var formdata = new FormData();

                    if($("#comentario").val() == ""){
                        bootbox.alert("Se están dejando espacios en blanco.");
                    }else{

                        $.ajax({
                            url: "' . $this->baseurl . INDEX . 'cursos_alumno/saveComentario",
                            type: "POST",
                            dataType: "json",
                            data: {
                                "comentario": $("#comentario").val(),
                                "id_usuario":' . $id_alumno . ',
                                "id_curso": id_curso
                            },
                            success: function(data) {
                                var obj = data;
                                if(obj.Result == "OK"){
                                    /*table = $(".datatable").DataTable();
                                    table.ajax.reload();*/
                                    get_comentarios(' . $id_alumno . ', id_curso);
                                    limpiar_formulario();
                                    alertify.notify("<strong>Registro</strong> agregado correctamente.", "custom-black", 3, function() {});
                                }else{
                                    alertify.notify("<strong>Algo ha salido terriblemente mal</strong>.", "custom-black", 3, function() {});
                                }
                            }
                        });
                    }
                }
                $(document).ready(function() {
                    llenar_grados();
                    $("#id_grado").on("change", function(){
                        table = $(".datatable").DataTable();
                        table.ajax.reload();
                    });

                    var table = $(".datatable").DataTable({
                        "ajax": {
                            url: "' . $this->baseurl . INDEX . 'cursos_alumno/loadcursos/",
                            "dataSrc": "",
                            "data": function(d) {
                                d.id_alumno = ' . $id_alumno . '
                            },
                        },
                        "columns": [{
                            "data": "id"
                        }, {
                            "data": "curso"
                        }, {
                            "data": "curso",
                            "render": function(a, b, c){
                                return `<span>${parseFloat(c.notas[0].promedio).toFixed(2)}</span>`
                            }
                        }, {
                            "render": function(a, b, c){
                                return `<span class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#formulario" title="Ver Comentario" onclick="nuevo_comentario(${c.id});"><i class="fa fa-comments"></i></span>`;
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
                });
            </script>';
        return $r;
    }
}
