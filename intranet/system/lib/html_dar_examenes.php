<?php
class html_dar_examenes extends f{
    private $baseurl = "";

    function html_dar_examenes(){
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
                a.disabled {
                    pointer-events: none;
                    cursor: default;
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
                            <div class="form-row">
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
                            </div>
                            
                            <div class="row">
                                <div class="col-12" >
                                    <table  class="table table-bordered table-hover" style="width:100%" id="table_examenes">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Exámen</th>
                                                <th>Curso</th>
                                                <th>Fechas</th>
                                                <th>Acción</th>
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
            
            <script>
                $(document).ready(function() {
                    load_examenes();
                });
                function load_examenes(){
                    $("#table_examenes").find("tbody").empty();
                    $.post("'. $this->baseurl . INDEX . 'dar_examenes/load_examenes", function(response){
                        var obj = JSON.parse(response);
                        $.each(obj.Records, function(index, val){
                            let fecha1 = new Date(val.fecha_fin);
                            let fecha2 = new Date()

                            let resta = fecha2.getTime() - fecha1.getTime();
                            console.log(Math.round(resta/ (1000*60*60*24)))
                            var pd = "";
                            if(Math.round(resta/ (1000*60*60*24)) > 0){
                                pd = "disabled";
                            }else{

                            }
                            $("#table_examenes").find("tbody").append(`<tr>
                                <td style="vertical-align: middle;">`+val.id+`</td>
                                <td style="vertical-align: middle;">`+val.identificador+`</td>
                                <td style="vertical-align: middle;">`+val.titulo+`</td>
                                <td style="text-align: center;"><span class="badge badge-success">`+val.fecha_inicio+`</span> <br> <span class="badge badge-danger mt-1">`+val.fecha_fin+`</span></td>
                                <td><a class="btn btn-primary `+pd+`" href="'. $this->baseurl . INDEX . 'detalle_examen/index/`+val.id+`">Empezar</a></td>
                            </tr>`);
                        });
                    });
                }
            </script>';     
            return $r;
        }
    }
?>
