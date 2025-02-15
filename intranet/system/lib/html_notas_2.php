<?php

class html_notas_2 extends f
{
    private $baseurl = "";

    function html_notas_2()
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
                        <!--<div class="w-100 text-right">
                            <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#busbienes">
                                Cargar Excel Notas
                            </button>
                            <button style="margin-bottom: 10px;" id="btn_excel" hidden class="btn btn-sm btn-info hideprint" onclick="window.print()">
                                <span >Imprimir</span>
                            </button>
                        </div>-->
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Compendio de notas del alumno
                        </h5>
                        <small>
                            <i class="fa fa-edit"></i> Seleccionar Alumno para cargar el listado de notas.
                        </small>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Alumno</label>
                                <select class="form-control mt-2 mb-1" id="id_alumno">
                                    <option value="-1">--SELECCIONAR--</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Curso</label>
                                <select class="form-control mt-2 mb-1" id="id_curso">
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
                                                <th>Descripción</th>
                                                <th>Porcentaje</th>
                                                <th>Nota</th>
                                                <th>Cálculo</th>
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
            <script>
                function llenar_alumnos(){
                    $.post("' . $this->baseurl . INDEX . 'alumnos/get_alumnos/", function(response){
                        var obj = JSON.parse(response);

                        $.each(obj, function(index, val){
                            $("#id_alumno").append(`<option value="${val.id}">${val.nombres} ${val.apellidos}</option>`);
                        });
                    });
                }
                function llenar_cursos(id_alumno){
                    $.post("' . $this->baseurl . INDEX . 'cursos/loadcursosbyalumno/", {
                        id_alumno: id_alumno
                    }, function(response){
                        var obj = JSON.parse(response);
                        $("#id_curso").empty();
                        $("#id_curso").append(`<option value="0">--SELECCIONAR--</option>`);
                        $.each(obj.Records, function(index, val){
                            $("#id_curso").append(`<option value="${val.id}">${val.curso}</option>`);
                        });
                    });
                }
                $(document).ready(function() {
                    llenar_alumnos();
                    $("#id_alumno").select2();

                    $("#id_alumno").on("change", function(){
                        llenar_cursos($(this).val());
                    });
                    $("#id_curso").on("change", function(){
                        table = $(".datatable").DataTable();
                        table.ajax.reload();
   
   						if($(this).val() == -1 || $(this).val() == "-1"){
   							$("#btn_excel").attr("hidden", true);
   						}else{
   							$("#btn_excel").removeAttr("hidden");
   						}
                    });

                    var table = $(".datatable").DataTable({
                        "ajax": {
                            url: "' . $this->baseurl . INDEX . 'notas_2/loadnotas/",
                            "dataSrc": "",
                            "data": function(d) {
                                d.id_alumno = $("#id_alumno").val();
                                d.id_curso = $("#id_curso").val();
                            },
                        },
                        "columns": [{
                            "data": "identificador"
                        }, {
                            "data": "porcentaje"
                        }, {
                            "data": "nota",
                            "render": function(a, b, c){
                                return `<input type="text" class="form-control" id="txt_examen_${c.id}" value="${$.trim(a)}">`
                            }
                        },  {
                            "data": "nota",
                            "render": function(a, b, c){
                                return `<span>${a*(c.porcentaje/100)}</span>`
                            }
                        }, {
                            "render": function(a, b, c){
                                return `<span class="btn btn-sm btn-success" title="Actualizar Nota" onclick="actualizar_nota(${c.id});"><i class="fa fa-check"></i></span>`;
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
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar esta Nota <strong></strong>?",
                            function() {
                                eliminar(rowData["id"]);
                                alertify.notify("Se elimino esta Nota correctamente.", "custom-black", 4, function() {});
                            },
                            function() {
                                alertify.notify("Se cancelo la <strong>eliminación</strong>.", "custom-black", 4, function() {});
                            }).set("labels", { ok: "Eliminar", cancel: "Cancelar" });
                        } else {
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar esta Nota <strong></strong>?",
                            function() {
                                eliminar(data["id"]);
                                alertify.notify("Se elimino esta Nota correctamente.", "custom-black", 4, function() {});
                            },
                            function() {
                                alertify.notify("Se cancelo la <strong>eliminación</strong>.", "custom-black", 4, function() {});
                            }).set("labels", { ok: "Eliminar", cancel: "Cancelar" });
                        }
                    });
                });
                function guardar_notas(id_alumno, id){
                    var promedio = parseFloat($("#examen_"+id_alumno).val() * 0.60) + parseFloat($("#informe_"+id_alumno).val() * 0.30) + parseFloat($("#asistencias_"+id_alumno).val() * 0.10);
                    $("#promedio_"+id_alumno).val(promedio.toFixed(2));
                    $.post("' . $this->baseurl . INDEX . 'notas/editarBD", {
                        id_alumno: id_alumno,
                        examen: $("#examen_"+id_alumno).val(),
                        informe: $("#informe_"+id_alumno).val(),
                        asistencias: $("#asistencias_"+id_alumno).val(),
                        promedio: $("#promedio_"+id_alumno).val(),
                        id: id,
                        id_modulo: $("#id_modulo").val(),
                    }, function(response){
                        var obj = JSON.parse(response);
                        if(obj.Result == "OK"){
                            //limpiar_formulario();
                            /*table = $(".datatable").DataTable();
                            table.ajax.reload();*/
                            alertify.notify("<strong>Nota Registrada</strong> correctamente.", "custom-black", 3, function() {});
                        }else{
                            alertify.notify("<strong>Algo ha salido terriblemente mal</strong>.", "custom-black", 3, function() {});
                        }
                    });
                }
                function actualizar_nota(id){
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'notas_2/actualizar_nota",
                        type: "POST",
                        dataType: "html",
                        data: {
                            "id": id,
                            "id_curso": $("#id_curso").val(),
                            "id_alumno": $("#id_alumno").val(),
                            "nota": $("#txt_examen_"+id).val()
                        },
                        success: function(data) {
                            var obj = JSON.parse(data);
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            
                            if(obj.Result == "OK"){
                                alertify.notify("Realizado Correctamente.</strong>", "custom-black", 4, function() {});
                            }else{
                                alertify.notify("Algo ha salido mal.</strong>", "custom-black", 4, function() {});
                            }
                            
                        }
                    });
                }
                function eliminar(id) {
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'notas/eliminar",
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

                function completeHandler() {
                    //$(\'#spinnerModal\').modal(\'hide\');
                    //alert("HECHO");
                    //add_respuestas(id);

                    alertify.notify("<strong>Nota Registrada</strong> correctamente.", "custom-black", 3, function() {});
                }
                function errorHandler() {
                    $("#mensaje").removeAttr("hidden");
                    //Swal.fire("ERROR!", "Algo ha salido mal", "error");
                }
                function cargar_excel() {
                    var file_data = $("#cargar_excel").prop("files")[0];
                    
                    var form_data = new FormData();
                    form_data.append("archivo", file_data);

                    /*form_data.append("id_proveedor", id_proveedor);
                    form_data.append("id_cotizacion", id_cotizacion);
                    form_data.append("monto", $("#monto_" + id_proveedor).val());
                    form_data.append("tiempo_entrega", $("#tiempo_entrega_" + id_proveedor).val());
                    form_data.append("observaciones", $("#observaciones_" + id_proveedor).val());
                    form_data.append("tipo_moneda", $("#tipo_moneda_"+id_proveedor).val());*/

                    var ajax = new XMLHttpRequest();
                    ajax.addEventListener("load", completeHandler, false);
                    ajax.addEventListener("error", errorHandler, false);
                    ajax.open("POST", "' . $this->baseurl . INDEX . 'notas_2/cargar_excel");
                    ajax.send(form_data);
                }
            </script>';
        return $r;
    }
}
