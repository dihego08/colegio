<?php
class html_resultados extends f{
    private $baseurl = "";

    function html_resultados(){
        $this->load()->lib_html("Table", false);
        $this->baseurl = BASEURL;
    }
    function container(){
        $r = '<script>
                function abrir_modal(b,a){alertify.dialog(b,function(){return{main:function(c){this.setContent(c);},setup:function(){return{focus:{element:function(){return this.elements.body.querySelector(this.get("selector"));
                },select:true},options:{basic:false,title:a,maximizable:false,resizable:false,padding:true,modal:true,transition:false,}};},settings:{selector:undefined}};
                });}
            </script>
            <style type="text/css">
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
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Lista de Exámenes
                        </h5>
                        <small>
                            <i class="far fa-edit"></i> Aquí podrá ver toda la información de todos los Exámenes
                        </small>
                        <hr>         
                        <div class="container" style="max-width: 100%;">
                            <!--<div class="form-row">
                                <div class="col-md-4">
                                    <div class="card border-success mb-3" style="max-width: 18rem; margin-left: auto; margin-right: auto;">
                                        <div class="card-header">Exámenes Activos</div>
                                        <div class="card-body text-success">
                                            <h5 class="card-title">0</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card border-danger mb-3" style="max-width: 18rem;  margin-left: auto; margin-right: auto;">
                                        <div class="card-header">Próximos Exámenes</div>
                                        <div class="card-body text-danger">
                                            <h5 class="card-title">0</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card border-warning mb-3" style="max-width: 18rem;  margin-left: auto; margin-right: auto;">
                                        <div class="card-header">Exámenes Pasados</div>
                                        <div class="card-body text-warning">
                                            <h5 class="card-title">0</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>-->
                            
                            <div class="row">
                                <div class="col-12" >
                                    <table  class="table table-bordered table-hover" style="width:100%" id="table_examenes">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;">Id</th>
                                                <th style="text-align: center;">Exámen</th>
                                                <th style="text-align: center;">Curso</th>
                                                <th style="text-align: center;">Fecha de Rendición</th>
                                                <th style="text-align: center;">Resultado</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!----------------------------------------------------------------------->
            <div class="modal fade" id="formulario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="max-width: 80%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLabel">Resultados</h3>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-row" style="width: 100%;" id="contenedor_">
                            </div>
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>
            <!----------------------------------------------------------------------->
            <script>
                $(document).ready(function() {
                    load_examenes();
                });
                function load_examenes(){
                    $("#table_examenes").find("tbody").empty();
                    $.post("'. $this->baseurl . INDEX . 'resultados/load_examenes", function(response){
                        var obj = JSON.parse(response);
                        $.each(obj.Records, function(index, val){
                            $("#table_examenes").find("tbody").append(`<tr>
                                <td style="vertical-align: middle; text-align: center;">`+val.id+`</td>
                                <td style="vertical-align: middle; text-align: center;">`+val.identificador+`</td>
                                <td style="vertical-align: middle; text-align: center;">`+val.titulo+`</td>
                                <td style="text-align: center;"><span class="badge badge-danger mt-1" style="font-size: 1rem;">`+val.fecha+`</span></td>
                                <td style="text-align: center;"><span data-toggle="modal" data-target="#formulario" class="btn btn-primary btn-sm" onclick="resultado();">Ver</span></td>
                            </tr>`);
                        });
                    });
                }
                function resultado(id_examen){
                    $("#contenedor_").empty();
                    $.post("'. $this->baseurl . INDEX . 'resultados/load_resultados", {
                        id_examen: id_examen
                    }, function(response){
                        var obj = JSON.parse(response);
                        var html = "";
                        $.each(obj, function(index, val){
                            html += `<div class="col-md-4">
                                    <div class="card text-white bg-warning mb-3" style="max-width: 18rem;">
                                        <div class="card-header">
                                            <div style="height: 45px; width: 45px; background-color: #ffffff; border-radius: 50%; color: #4b7d42; margin-top: 6px; padding: 14px; border: 1px solid #666666;">
                                                <span>`+parseInt(index + 1)+`</span>
                                            </div>
                                        </div>`;
                                        var cls = "";
                                        if(val.res.length == 1){
                                            cls = "bg-success";
                                        }else{
                                            cls = "bg-danger";
                                        }
                                        html += `<div class="card-body `+cls+`">
                                            <h5 class="card-title">`+val.pregunta+`</h5>`;
                                            var fg = "";
                                            
                                            if(val.res.length == 1){
                                                fg = `<p class="card-text">Respuesta Correcta: <strong id="r_respuesta">`+val.res[0].alternativa+`</strong></p>
                                                    <hr>
                                                    <p class="card-text">Tu respuesta: <strong id="t_respuesta">`+val.res[0].alternativa+`</strong></p>`;
                                            }else{
                                                fg = `<p class="card-text">Respuesta Correcta: <strong id="r_respuesta">`+val.res[0].alternativa+`</strong></p>
                                                <hr>
                                                <p class="card-text">Tu respuesta: <strong id="t_respuesta">`+val.res[1].alternativa+`</strong></p>`;
                                            }
                                            html += fg;
                                        html += `</div>
                                    </div>
                                </div>`;
                        });
                        $("#contenedor_").append(html);
                    });
                }
            </script>';     
            return $r;
        }
    }
?>
