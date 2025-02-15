<?php
class html_asistencia_diaria_2 extends f
{
    private $baseurl = "";

    function html_asistencia_diaria_2()
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
            <style>
                .select2-container{
                    width: 100% !important;
                }
                  #myelement {
                    background: url(/img/logo_rotado.jpeg);
                    background-position: center;
                    background-size: 90%;
                    background-repeat: no-repeat;
                  }
                                    
            </style>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Lista de Alumnos Asistentes
                        </h5>
                        <small>
                            <i class="fa fa-edit"></i> Aquí podrá ver toda la información de todos los Alumnos Asistentes
                        </small>
                        <hr>         
                        <div class="container" style="max-width: 100%;">
                            <div class="row">

                                <div class="col-md-12">
                                    <label>Seleccionar Día</label>
                                    <input type="text" class="form-control datepicker" id="fecha">
                                </div>
                                <div class="col-md-12 text-center">
                                    <button class="btn btn-success" id="filter"><i class="fa fa-search"></i> Filtrar</button>
                                </div>
                                <div class="table-responsive" >
                                    
                                    <table  class="datatable table dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Alumno</th>
                                                <th>Ciclo</th>
                                                <th>Grupo</th>
                                                <th>Fecha</th>
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
            
            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>
            
            <script>
                $(document).ready(function() {
                    $( ".datepicker" ).datetimepicker({
                        format: "Y-m-d",
                        timepicker:false
                    });
                    $.datetimepicker.setLocale(\'es\');
                    
                    var table = $(".datatable").DataTable({
                        "ajax": {
                            url: "' . $this->baseurl . INDEX . 'asistencia_diaria_2/load_asistencia_diaria/",
                            "dataSrc": "",
                            "data": function (data) {
                                var _date = $("#fecha").val();
                                data.date = _date;
                            }
                        },
                        "columns": [{
                            "data": "id"
                        },  {
                            "data": "alumno"
                        }, {
                            "data": "ciclo"
                        }, {
                            "data": "grupo"
                        }, {
                            "data": "hoy"
                        }, {
                            "data": "",
                            "render": function(data){
                                return `<span class="badge badge-success">PRESENTE</span>`;
                            },
                        }, ],
                        "language": {
                            "url": "' . $this->baseurl . 'includes/datatables/Spanish.json"
                        },
                        "lengthMenu": [
                            [10, 15, 20, -1],
                            [10, 15, 20, "All"]
                        ]
                    });
                    $("#filter").click(function () {
                        table.ajax.reload();
                    });
                });
            </script>';
        return $r;
    }
}
