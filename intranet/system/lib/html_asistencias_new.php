<?php
    
class html_asistencias_new extends f{
    private $baseurl = "";

    function html_asistencias_new(){
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
            </style>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12" id="div_notas">
                        <label for="codigo_dni">Código de Estudiante:</label>
                        <input type="text" name="codigo_dni" id="codigo_dni" class="form-control" >
                    </div>
                </div>
                <div id="div_elemento" >
                    <div class="content-popup">
                        <div>
                            <h3 id="fecha_hoy" style="text-align: center;">Hoy es: '.date("Y-m-d").'</h3>
                            <div class="alert alert-success" role="alert">
                                Debe utilizar la lectora de Código de Barras para que haga la detección automática de sus asistencia respectiva al día de hoy.
                                En caso no se pueda utilizar dicha Lectora haga el ingreso de su código de estudiante y presione la tecla "Enter" para hacer el marcaje respectivo.
                            </div>

                            <div id="div_data_alumno"></div>
                        </div>
                    </div>
                </div>
            </div>
            <link rel="stylesheet" href="system/lib/style_cal.css">
            <script type="text/javascript" src="system/lib/calendarize.js"></script>
            <script>
                $(document).ready(function() {
                    var f = new Date();
                    /*$("#fecha_hoy").text("Hoy es: "+f.getDate() + "/" + (f.getMonth() +1) + "/" + f.getFullYear());*/
                    $("#codigo_dni").keypress(function(e) {
                        var code = (e.keyCode ? e.keyCode : e.which);
                        if(code==13){
                            marcar_asistencia($("#codigo_dni").val());
                        }
                    });
                    $("#codigo_dni").focus();
                });
                function marcar_asistencia(codigo_dni){
                    $.post("' . $this->baseurl . INDEX . 'asistencias_new/marcar_asistencia/",{
                        codigo_dni: codigo_dni
                    }, function(responseText) {
                        var obj = JSON.parse(responseText);
                        if(obj.Code == \'100\'){
                            /*bootbox.alert({
                                message: \'<div class="alert alert-success" style="margin-top: 5%; margin-bottom: 0;">\'+
                                        \'<strong>Guardado Correctamente.</strong>\'+
                                    \'</div>\'
                            });*/
                            alertify.notify("Realizado Correctamente.</strong>", "custom-black", 4, function() {});
                            $("#div_data_alumno").empty();
                            $("#div_data_alumno").append(`
                                <h5>${obj.Data.nombres} ${obj.Data.apellidos}</h5>
                                <h5><strong>Fecha de pago:</strong> ${obj.Data.fecha_pago} de cada mes.</h5>
                                <h5><strong>Estado de cuenta:</strong> ${obj.Ecuenta.ecuenta}</h5>

                                <h5><strong>Aula:</strong> ${obj.aula}</h5>
                                <h5><strong>Área:</strong> ${obj.area}</h5>
                            `);
                            $("#codigo_dni").val("");
                        }else{
                            if(obj.Code == \'404\'){
                                bootbox.alert({
                                    message: \'<div class="alert alert-danger" style="margin-top: 5%; margin-bottom: 0;">\'+
                                            \'<strong>Código de estudiante no encontrado.</strong>\'+
                                        \'</div>\'
                                });
                            }else{
                                if(obj.Code == \'502\'){
                                    /*bootbox.alert({
                                        message: \'<div class="alert alert-danger" style="margin-top: 5%; margin-bottom: 0;">\'+
                                                \'<strong>Ya se registró la asistencia de este alumno anteriormente.</strong>\'+
                                            \'</div>\'
                                    });*/
                                    alertify.notify("Realizado Correctamente.</strong>", "custom-black", 4, function() {});
                                    $("#div_data_alumno").empty();
                                    $("#div_data_alumno").append(`
                                        <h5>${obj.Data.nombres} ${obj.Data.apellidos}</h5>
                                        <h5><strong>Fecha de pago:</strong> ${obj.Data.fecha_pago} de cada mes.</h5>
                                        <h5><strong>Estado de cuenta:</strong> ${obj.Ecuenta.ecuenta}</h5>

                                        <h5><strong>Aula:</strong> ${obj.aula}</h5>
                                        <h5><strong>Área:</strong> ${obj.area}</h5>
                                    `);
                                }
                            }              
                        }
                    });
                }
            </script>';     
            return $r;
        }
    }
?>
