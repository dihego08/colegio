<?php

class html_detalle_matricula extends f
{
    private $baseurl = "";

    function html_detalle_matricula()
    {
        $this->load()->lib_html("Table", false);
        $this->baseurl = BASEURL;
    }
    function container()
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
            </style>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Lista de Matriculados por Grado
                        </h5>
                        <small>
                            <i class="fa fa-edit"></i> Seleccionar Grado para ver la lista de matriculados.
                        </small>
                        <div class="row">
                            <div class="col-md-12">
                                <label>Grado</label>
                                <select class="form-control mt-2 mb-1" id="id_grado">
                                    <option value="-1">--SELECCIONAR--</option>
                                </select>
                            </div>
                        </div>
                        <hr>         
                        <div class="container">
                            <div class="row">
                                <div class="table-responsive" >
                                    <table  class="datatable table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Apellidos</th>
                                                <th>Nombres</th>
                                                <th>Grado</th>
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


            <div class="modal fade" id="busbienes">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header py-2">
                            <h5 class="modal-title">Detalle de Compra</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <div class="col-md-12 border-bottom border-right py-2">
                                    <label for="" class="w-100">Cargar Excel</label>
                                    <label for="cargar_excel" class="btn bg-maroon">
                                        Seleccionar Archivo
                                        <input type="file" name="cargar_excel" id="cargar_excel" style="display:none;">
                                    </label>
                                </div>
                                <div class="col-md-12 py-2 mt-2 text-center">
                                    <span class="btn btn-success" onclick="cargar_excel();">Cargar Archivo</span>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
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
                $(document).ready(function() {
                    llenar_grados();
                    $("#id_grado").on("change", function(){
                        table = $(".datatable").DataTable();
                        table.ajax.reload();
                    });

                    var table = $(".datatable").DataTable({
                        "ajax": {
                            url: "' . $this->baseurl . INDEX . 'detalle_matricula/loadmatriculas/",
                            "dataSrc": "",
                            "data": function(d) {
                                d.id_grado = $("#id_grado").val();
                            },
                        },
                        "columns": [{
                            "data": "id"
                        }, {
                            "data": "apellidos"
                        }, {
                            "data": "nombres"
                        },  {
                            "data": "grado",
                        }, {
                            "render": function(a, b, c){
                                return `<a class="btn btn-sm btn-outline-success" title="Ver Cursos" href="' . $this->baseurl . INDEX . 'cursos_alumno/index/${c.id}"><i class="fa fa-list-alt"></i></a>`;
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
