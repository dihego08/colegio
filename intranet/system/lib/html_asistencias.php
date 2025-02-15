<?php
    
class html_asistencias extends f{
    private $baseurl = "";

    function html_asistencias(){
        $this->load()->lib_html("Table", false);
        $this->baseurl = BASEURL;
    }
    function container(){
        $r = '<script>
                function abrir_modal(b,a){alertify.dialog(b,function(){return{main:function(c){this.setContent(c);},setup:function(){return{focus:{element:function(){return this.elements.body.querySelector(this.get("selector"));
                },select:true},options:{basic:false,title:a,maximizable:false,resizable:false,padding:true,modal:true,transition:false,}};},settings:{selector:undefined}};
                });}
            </script>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Seleccionar Alumno
                        </h5>
                        <small>
                            <i class="fa fa-edit"></i> Seleccionar Alumno para cargar el reporte de asistencias.
                        </small>
                        <div class="form-row">
                            <div class="col-md-4">
                                <label>Alumno</label>
                                <select class="form-control mt-2 mb-1" id="id_alumno">
                                    <option value="-1">--SELECCIONAR--</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Fecha Desde</label>
                                <input type="text" class="form-control datepicker" id="fecha_desde">
                            </div>
                            <div class="col-md-4">
                                <label>Fecha Desde</label>
                                <input type="text" class="form-control datepicker" id="fecha_hasta">
                            </div>
                            <div class="col-md-12 mt-3">
                                <button class="btn btn-primary" onclick="realizar_busqueda();">Ver Asistencias</button>
                            </div>
                        </div>
                        
                        <hr>         
                        <div class="container">
                            <div class="row">
                                <div class="table-responsive" >
                                    <table  class="datatable table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Curso</th>
                                                <th>Asistencias</th>
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
                function llenar_alumnos(){
                    $.post("' . $this->baseurl . INDEX . 'alumnos/loadalumnos/", function(response){
                        var obj = JSON.parse(response);

                        $.each(obj, function(index, val){
                            $("#id_alumno").append(`<option value="${val.id}">${val.nombres}</option>`);
                        });
                    });
                }
                function realizar_busqueda(){
                    table = $(".datatable").DataTable();
                    table.ajax.reload();
                }
                $(document).ready(function() {
                    $( ".datepicker" ).datetimepicker({
                        format: "Y-m-d",
                        timepicker:false
                    });
                    $.datetimepicker.setLocale(\'es\');
                    llenar_alumnos();
                    
                    $("#id_alumno").select2();

                    var table = $(".datatable").DataTable({
                        "ajax": {
                            url: "' . $this->baseurl . INDEX . 'asistencias/loadasistencias/",
                            "dataSrc": "",
                            "data": function(d) {
                                d.id_alumno = $("#id_alumno").val();
                                d.fecha_desde = $("#fecha_desde").val();
                                d.fecha_hasta = $("#fecha_hasta").val();
                            },
                        },
                        "columns": [{
                            "data": "fecha"
                        }, {
                            "data": "asistencias"
                        }, ],
                        "language": {
                            "url": "'.$this->baseurl.'includes/datatables/Spanish.json"
                        },
                        "lengthMenu": [
                            [10, 15, 20, -1],
                            [10, 15, 20, "All"]
                        ],
                    });
                });
                function guardar_asistencias(id_alumno, id){
                    var promedio = parseFloat($("#examen_"+id_alumno).val() * 0.60) + parseFloat($("#informe_"+id_alumno).val() * 0.30) + parseFloat($("#asistencias_"+id_alumno).val() * 0.10);
                    $("#promedio_"+id_alumno).val(promedio.toFixed(2));
                    $.post("'. $this->baseurl . INDEX . 'asistencias/editarBD", {
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
            </script>';     
            return $r;
        }
    }
?>
