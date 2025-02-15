<?php
    
class html_inasistencias extends f{
    private $baseurl = "";

    function html_inasistencias(){
        $this->load()->lib_html("Table", false);
        $this->baseurl = BASEURL;
    }
    function container(){
        $r = '<script>
                function abrir_modal(b,a){alertify.dialog(b,function(){return{main:function(c){this.setContent(c);},setup:function(){return{focus:{element:function(){return this.elements.body.querySelector(this.get("selector"));
                },select:true},options:{basic:false,title:a,maximizable:false,resizable:false,padding:true,modal:true,transition:false,}};},settings:{selector:undefined}};
                });}
            </script>
            
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
                }
                .dataTables_wrapper{
                    width: 100%;
                }
            </style>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Seleccionar Fecha
                        </h5>
                        <small>
                            <i class="fa fa-edit"></i> Reporte de Inasistencias.
                        </small>
                        <div class="form-row">
                            <div class="col-md-12">
                                <label>Seleccionar Fecha</label>
                                <input type="text" class="form-control datepicker" id="fecha" value="'.date("Y-m-d").'">
                            </div>
                            <div class="col-md-12 mt-3">
                                <button class="btn btn-primary w-100 hideprint" onclick="realizar_busqueda();">Ver Inasistencias</button>
                            </div>
                        </div>
                        
                        <hr>         
                        <div class="container">
                            <div class="row">
                                <table class="datatable table dt-responsive nowrap w-100" id="table-inasistencias">
                                    <thead>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th>Celular</th>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <link rel="stylesheet" href="system/lib/style_cal.css">
            
            <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
            <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
            
            <script>
                function realizar_busqueda(){
                    $(".datatable").DataTable().destroy();
                    $.get("' . $this->baseurl . INDEX . 'inasistencias/loadinasistencias/",{
                        fecha: $("#fecha").val(),
                    }, function(response){
                        var obj = JSON.parse(response);
                        $("#table-inasistencias").find("tbody").empty();
                        $.each(obj.inasistencias_1, function(index, val){
                            $("#table-inasistencias").find("tbody").append(`<tr>
                                <td>${val.nombres}</td>
                                <td>${val.apellidos}</td>
                                <td>${val.telefono}</td>
                            </tr>`);
                        });

                        $(".datatable").DataTable({
                            dom: "Bfrtip",
                            language: {
                                "decimal": "",
                                "emptyTable": "No hay información",
                                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                                "infoPostFix": "",
                                "thousands": ",",
                                "lengthMenu": "Mostrar _MENU_ Entradas",
                                "loadingRecords": "Cargando...",
                                "processing": "Procesando...",
                                "search": "Buscar:",
                                "zeroRecords": "Sin resultados encontrados",
                                "paginate": {
                                    "first": "Primero",
                                    "last": "Ultimo",
                                    "next": "Siguiente",
                                    "previous": "Anterior"
                                }
                            },
                            buttons: [
                                "excel"
                            ]
                        });
                    });
                }
                $(document).ready(function() {

                    $( ".datepicker" ).datetimepicker({
                        format: "Y-m-d",
                        timepicker:false
                    });
                    $.datetimepicker.setLocale(\'es\');
                    
                });
            </script>';     
            return $r;
        }
    }
