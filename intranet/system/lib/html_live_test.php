<?php
class html_live_test extends f{
    private $baseurl = "";

    function html_live_test(){
        $this->load()->lib_html("Table", false);
        $this->baseurl = BASEURL;
    }
    function container($id_examen){
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
                .op{
                    border-bottom: 1px solid #eeeeee;
                    padding: 5px;
                }
                td {
                    font-size: 14px;
                    padding: 4px;
                }
            </style>
            <div class="container-fluid" style="margin-top: 56px;">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <h5 class="" id="titulo_examen">
                            <i class="fa fa-bars" aria-hidden="true"></i> Examen en Línea
                        </h5>
                        <hr>         
                        <div class="container" style="max-width: 100%;">
                            <div class="row">
                                <div class="col-9" id="pregunta_div">
                                    <!--<div id="la_pregunta">
                                    </div>-->
                                    <!--Accordion wrapper-->
                                    <div class="accordion md-accordion accordion-3 z-depth-1-half" id="accordionEx194" role="tablist" aria-multiselectable="true">
                                        <hr class="mb-0">
                                        
                                    </div>
                                    <!--/.Accordion wrapper-->
                                </div>
                                <div class="col-3" style="background: #CEDDF0;" id="total_div">
                                    <div id="countdown" style="font-weight: 900; font-size: 3em; color: #444; text-align: center;"></div>
                                </div>
                                <div class="col-md-12 mt-3" style="background: #3D4A5D; padding: 10px; text-align: center;">
                                    <span class="btn btn-danger">Limpiar</span>
                                    <span class="btn btn-success ml-2" onclick="finalizar_evaluacion();">Finalizar Evaluación</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <script>
                var seconds = 0;//65; //número de segundos a contar
                var ids = 0;
                $(document).ready(function() {
                    get_pregunta();
                    function secondPassed() {
                        var minutes = Math.round((seconds - 30)/60); //calcula el número de minutos
                        var remainingSeconds = seconds % 60; //calcula los segundos
                        //si los segundos usan sólo un dígito, añadimos un cero a la izq
                        if (remainingSeconds < 10) { 
                            remainingSeconds = "0" + remainingSeconds; 
                        } 
                        document.getElementById("countdown").innerHTML = minutes + ":" +     remainingSeconds; 
                        if (seconds == 0) { 
                            clearInterval(countdownTimer);
                            //alert("Se acabó el tiempo");
                            //document.getElementById("countdown").innerHTML = "Buzz Buzz";
                            localStorage.setItem("rt", null);
                        } else { 
                            seconds--; 
                            localStorage.setItem("rt", seconds);
                        } 
                    } 
                    var countdownTimer = setInterval(secondPassed, 1000);
                });
                function finalizar_evaluacion(){
                    var rd = ids.split(",");
                    //var arr = [];
                    var obj = {};
                    for(var i = 1; i < rd.length; i++){
                        obj[rd[i]] = $(`input[name="rpta_`+rd[i]+`"]:checked`).val();
                    }

                    $.post("'. $this->baseurl . INDEX . 'live_test/finalizar_evaluacion", {
                        arr: obj,
                        id_examen: 1,
                        id_alumno: 1
                    }, function(response){
                        var obj = JSON.parse(response);
                        /*$("#td_examen").text(obj.identificador);
                        $("#td_fecha_inicio").text(obj.fecha_inicio);
                        $("#td_fecha_fin").text(obj.fecha_fin);
                        $("#td_duracion").text(obj.duracion);
                        $("#td_curso").text(obj.titulo);*/
                    });
                }
                function get_pregunta(){
                    pregunta_div
                    $.post("'. $this->baseurl . INDEX . 'live_test/get_pregunta/'.$id_examen.'", function(response){
                        var obj = JSON.parse(response);
                        var html = "";
                        if(localStorage.getItem("rt") != null || localStorage.getItem("rt") != ""){
                            seconds = localStorage.getItem("rt");
                        }else{
                            var tt = obj.duracion.split(":");
                            seconds = (parseInt(tt[0]) * 60);
                        }

                        $.each(obj.QUES, function(index, val){
                            ids += "," + val.id_pregunta;
                            html += `<!-- Accordion card -->
                            <div class="card">
                                <!-- Card header -->
                                <div class="card-header" role="tab" id="heading6">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx194" href="#collapse`+val.id_pregunta+`" aria-expanded="false" aria-controls="collapse`+val.id_pregunta+`">
                                        <h3 class="mb-0 mt-3 red-text">
                                            `+val.pregunta+` <i style="float: right; font-size: 2rem;" class="fas fa-angle-down rotate-icon fa-2x"></i>
                                        </h3>
                                    </a>
                                </div>
                                <!-- Card body -->
                                <div id="collapse`+val.id_pregunta+`" class="collapse" role="tabpanel" aria-labelledby="heading6" data-parent="#accordionEx194">
                                    <div class="card-body pt-0">`;
                                        $.each(val.alternativas, function(index, val){
                                            html += `
                                                <div class="op">
                                                    <table>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    `+parseInt(index + 1)+`
                                                                    <input type="radio" name="rpta_`+val.id_pregunta+`" id="rpta_`+val.id_pregunta+`_`+val.id+`" value="`+val.id+`">
                                                                </td>
                                                                <td>
                                                                    `+val.alternativa+`
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            `;
                                        });
                                    html += `</div>
                                </div>
                            </div>`;
                        });

                        $("#accordionEx194").append(html);

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
