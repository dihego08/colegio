<?php
    
class html_notas extends f{
    private $baseurl = "";

    function html_notas(){
        $this->load()->lib_html("Table", false);
        $this->baseurl = BASEURL;
    }
    function container(){
        $r = '
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <a style="float: right; margin-bottom: 10px;" id="btn_excel" hidden class="btn btn-sm btn-info" href="">
                            <span >Exportar EXCEL</span>
                        </a>
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Seleccionar Fecha de Examen de Ranking
                        </h5>
                        <small>
                            <i class="fa fa-edit"></i> Seleccionar Fecha de Ranking para cargar el listado de notas.
                        </small>
                        <!--<select class="form-control mt-2 mb-1" id="id_ranking" >
                            <option value="-1">--SELECCIONAR--</option>
                        </select>-->
                        <input type="text" class="form-control datepicker" id="fecha" name="fecha">
                        <hr>         
                        <div class="container">
                            <div class="row">
                                <div class="table-responsive" >
                                    <table  class="datatable table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Alumno</th>
                                                <th>Puntaje</th>
                                                <th>Eliminar</th>
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
                function llenar_rankings(){
                    $.post("' . $this->baseurl . INDEX . 'examenes/loadexamenes/", function(response){
                        var obj = JSON.parse(response);

                        $.each(obj, function(index, val){
                            $("#id_ranking").append(`<option value="${val.id}">${val.identificador} // ${val.fecha}</option>`);
                        });
                    });
                }
                $(document).ready(function() {
                    $( ".datepicker" ).datetimepicker({
                        format: "Y-m-d",
                        timepicker:false
                    });
                    /*llenar_rankings();
                    $("#id_ranking").select2();
                    $("#id_ranking").on("change", function(){
                        table = $(".datatable").DataTable();
                        table.ajax.reload();
   
   						if($(this).val() == -1 || $(this).val() == "-1"){
   							$("#btn_excel").attr("hidden", true);
   						}else{
   							$("#btn_excel").removeAttr("hidden");
   							$("#btn_excel").attr("href", "system/lib/exportar_excel_notas.php?id_ranking="+$(this).val());
   						}
                    });*/

                    $("#fecha").on("change", function(){
                        table = $(".datatable").DataTable();
                        table.ajax.reload();
   
   						if($(this).val() == -1 || $(this).val() == "-1"){
   							$("#btn_excel").attr("hidden", true);
   						}else{
   							$("#btn_excel").removeAttr("hidden");
   							$("#btn_excel").attr("href", "system/lib/exportar_excel_notas.php?fecha="+$(this).val());
   						}
                    });

                    var table = $(".datatable").DataTable({
                        "ajax": {
                            url: "' . $this->baseurl . INDEX . 'notas/loadnotas/",
                            "dataSrc": "",
                            "data": function(d) {
                                d.fecha = $("#fecha").val();
                            },
                        },
                        "columns": [{
                            "data": "nombres"
                        }, {
                            "data": "examen"
                        }, {
                            "defaultContent": "<button id=\"btn_eliminar\" class=\"btn btn-danger btn-sm\" style=\"display: block;\"><i class=\"fa fa-trash\"></i></button>"
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
                    $.post("'. $this->baseurl . INDEX . 'notas/editarBD", {
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
            </script>';     
            return $r;
        }
    }
?>
