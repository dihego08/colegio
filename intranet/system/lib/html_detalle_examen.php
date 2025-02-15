<?php
class html_detalle_examen extends f{
    private $baseurl = "";

    function html_detalle_examen(){
        $this->load()->lib_html("Table", false);
        $this->baseurl = BASEURL;
    }
    function container($id_examen){
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
            
            <div class="container-fluid" style="margin-top: 56px;">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <h5 class="" id="titulo_examen">
                            
                        </h5>
                        <small>
                            <i class="far fa-edit"></i> Aquí podrá ver toda la información de este Exámen
                        </small>
                        <hr>         
                        <div class="container" style="max-width: 100%;">
                            
                            <div class="row">
                                <div class="col-12" >
                                    <table  class="table table-bordered table-hover" style="width:100%" id="table_examenes">
                                        <tr>
                                            <td style="font-size: 20px; color: #444; font-weight: bold;" scope="row">Exámen</td>
                                            <td id="td_examen"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 20px; color: #444; font-weight: bold;" scope="row">Fecha de Inicio</td>
                                            <td id="td_fecha_inicio" style=" font-weight: bold;"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 20px; color: #444; font-weight: bold;" scope="row">Fecha de Finalización</td>
                                            <td id="td_fecha_fin" style=" font-weight: bold;"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 20px; color: #444; font-weight: bold;" scope="row">Duración (Min)</td>
                                            <td id="td_duracion"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 20px; color: #444; font-weight: bold;" scope="row">Curso</td>
                                            <td id="td_curso"></td>
                                        </tr>
                                    </table>
                                    <div style="width: 100%; text-align: right;">
                                        <a href="'. $this->baseurl . INDEX . 'live_test/index/'.$id_examen.'" class="btn btn-warning">¡Empezar Ya!</a>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                $(document).ready(function(){
                    get_detalle_examen();
                });
                function get_detalle_examen(){
                    $.post("'. $this->baseurl . INDEX . 'detalle_examen/get_detalle_examen/'.$id_examen.'", function(response){
                        var obj = JSON.parse(response);
                        $("#titulo_examen").text(obj.identificador);
                        $("#td_examen").text(obj.identificador);
                        $("#td_fecha_inicio").text(obj.fecha_inicio);
                        $("#td_fecha_fin").text(obj.fecha_fin);
                        $("#td_duracion").text(obj.duracion);
                        $("#td_curso").text(obj.titulo);
                    });
                }
            </script>';     
            return $r;
        }
    }
?>
