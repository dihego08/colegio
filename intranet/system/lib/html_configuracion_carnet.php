<?php
class html_configuracion_carnet extends f
{
    private $baseurl = "";

    function html_horario_ciclo()
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
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Diseño de Carnet de Alumno
                        </h5>
                        <small>
                            <i class="fa fa-edit"></i> Aquí podrá modificar los colores del Carnet de Alumno
                        </small>
                        <hr>         
                        <div class="container">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Imagen</label>
                                    <input type="file" id="imagen" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label>Color Principal</label>
                                    <input type="color" style="height:25px;" id="color_principal" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label>Color Secundario</label>
                                    <input type="color" style="height:25px;" id="color_secundario" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label>Color Texto</label>
                                    <input type="color" style="height:25px;" id="color_texto" class="form-control">
                                </div>
                                <div class="col-md-12 mt-1 text-center">
                                    <span class="btn btn-outline-success rounded-pill" onclick="guardar();">Guardar</span>
                                </div>
                            </div>
                            <hr>
                            <div class="row" style="position:relative;">
                                <table class="m-auto">
                                    <td style="width: 50%; padding-top: 1%; padding-bottom:2%; padding-left: 6%; padding-right: 16%; margin: 0; min-height: 400px;">
                                        <div style="position:relative; border: solid 1px; width: 80mm; height: 48mm; background-size: contain;background-position: center;background-repeat: no-repeat;" id="div-elemento">
                                            <table style="width: 100%; margin-left: 1rem; margin-top: 15%;">
                                                <tr>
                                                    <td style="width: 30%;">
                                                        <img src="https://laclave.diegoaranibar.com/intranet/system/controllers/photo/user-2935527_1280.png" style="width: 100%; z-index: 0;">
                                                    </td>
                                                    <td>
                                                        <table border="0" style="width: 100%;">
                                                            <tr>
                                                                <td style="width: 50%;">
                                                                    <h5 class="color_texto" style="font-size: 12px; margin: 0px 0px 0px 0px; color: green;">Nombres:</h5>
                                                                </td>
                                                                <td style="width: 50%;">
                                                                    <h5 style="font-size: 11px; margin: 0px 0px 0px 0px;"></h5>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <h5 class="color_texto" style="font-size: 12px; margin: 0px 0px 0px 0px; color: green;">Apellidos:</h5>
                                                                </td>
                                                                <td>
                                                                    <h5 style="font-size: 11px; margin: 0px 0px 0px 0px;"></h5>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <h5 class="color_texto" style="font-size: 12px; margin: 0px 0px 0px 0px; color: green;">Horario:</h5>
                                                                </td>
                                                                <td><h5 style="font-size: 11px; margin: 0px 0px 0px 0px;"></h5></td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <h5 class="color_texto" style="font-size: 12px; margin: 0px 0px 0px 0px; color: green;">Código:</h5>
                                                                </td>
                                                                <td>
                                                                    <h5 style="font-size: 5px; margin: 0px 0px 0px 0px;"></h5>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                            <h5 class="color_texto" style="position: absolute; font-size: 15px; font-weight: 700; color: green; right: 2%; bottom: 0;">
                                                ' . date("Y") . '
                                            </h5>
                                        </div>
                                    </td>
                                </table>
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
                            <h3 class="modal-title" id="exampleModalLabel">Nueva Grado</h3>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group" style="width: 100%;">
                                <div class="form-row">
                                    <div class="form-row col-md-12 mt-2">
                                        <div class="col-md-6">
                                            <label class="bold">Ciclo Academico</label><br>
                                            <select class="form-control" id="id_ciclo">
                                                <option value="-1">--SELECCIONA--</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="bold">Grupo</label><br>
                                            <select class="form-control" id="id_grupo">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Dia</label>
                                        <select class="form-control" id="dia" name="dia">
                                            <option value="1">Lunes</option>
                                            <option value="2">Martes</option>
                                            <option value="3">Miercoles</option>
                                            <option value="4">Jueves</option>
                                            <option value="5">Viernes</option>
                                            <option value="6">Sabado</option>
                                        </select>
                                        <!--<input id="fecha" class="form-control datepicker" name="fecha" type="text"/>-->
                                    </div>
                                    <div class="col-md-4">
                                        <label>Hora Inicio</label>
                                        <input id="hora_inicio" class="form-control timepicker" name="hora_inicio" type="text"/>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Hora Fin</label>
                                        <input id="hora_fin" class="form-control timepicker" name="hora_fin" type="text"/>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12" style="margin-top: 15px;">
                                        <button type="submit" class="btn btn-success pull-right" id="btn_finalizar">Guardar</button>
                                        <span class="btn btn-danger" type="button" data-dismiss="modal" id="cerrar_formulario_grado" style="margin-left: 10px">
                                            Cancelar
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>
            <!----------------------------------------------------------------------->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/jquery.datetimepicker.full.min.js"></script>
            <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/build/jquery.datetimepicker.min.css" rel="stylesheet"/>

            <script>
            function _(el){
                    return document.getElementById(el);
                }
                function uploadFile(){
                    var file = _("foto").files[0];
                    var formdata = new FormData();
                    formdata.append("foto", file);
                    formdata.append("id_curso", $("#id_curso").val());
                    formdata.append("id_tema", $("#id_tema").val());
                    formdata.append("tarea", $("#tarea").val());
                    formdata.append("fecha_entrega", $("#fecha_entrega").val());
                    formdata.append("parAccion", "guardar_tarea");
                    var ajax = new XMLHttpRequest();
                    ajax.upload.addEventListener("progress", progressHandler, false);
                    ajax.addEventListener("load", completeHandler, false);
                    ajax.addEventListener("error", errorHandler, false);
                    ajax.addEventListener("abort", abortHandler, false);
                    ajax.open("POST", "../php/tarea.php");
                    ajax.send(formdata);
                }
                function progressHandler(event){
                    _("loaded_n_total").innerHTML = "Uploaded "+event.loaded+" bytes of "+event.total;
                    var percent = (event.loaded / event.total) * 100;
                    _("progressBar").value = Math.round(percent);
                }
                function completeHandler(event){
                    var obj = JSON.parse(event.target.response);
                    if(obj.Result == "OK"){
                        alertify.notify("Realizado Correctamente.</strong>", "custom-black", 4, function() {});
                    }else{
                        if(obj.Code == 125){
                            alertify.notify("El DNI se encuentra registrado ya.</strong>", "custom-black", 4, function() {});
                        }else{
                            alertify.notify("Algo ha salido mal.</strong>", "custom-black", 4, function() {});
                        }
                        
                    }
                    table = $(".datatable").DataTable();
                    table.ajax.reload();
                    limpiar_formulario();
                    //$("#close_formulario_3").click();
                    
                    _("progressBar").value = 0;
                }
                function errorHandler(event){
                    _("status").innerHTML = "Upload Failed";
                }
                function abortHandler(event){
                    _("status").innerHTML = "Upload Aborted";
                }
                function readURL(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            //$("#profile-img-tag").attr("src", e.target.result);
                            $("#div-elemento").css("background-image", "url(\'" + e.target.result + "\')");
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                }
                $(document).ready(function() {
                    $("#imagen").change(function(){
                        readURL(this);
                    });

                    $("#color_principal").on("input", function() {
                        var colorSeleccionado = $(this).val(); // Obtener el valor del input de color
                        $("#svg_color_principal path").attr("fill", colorSeleccionado); // Actualizar el color del SVG
                    });

                    $("#color_secundario").on("input", function() {
                        var colorSeleccionado = $(this).val(); // Obtener el valor del input de color
                        $("#svg_color_secundario path").attr("fill", colorSeleccionado); // Actualizar el color del SVG
                        $("#img_logo").css("background-color", colorSeleccionado);
                    });

                    $("#color_texto").on("input", function() {
                        var colorSeleccionado = $(this).val(); // Obtener el valor del input de color
                        $(".color_texto").css("color", colorSeleccionado);
                    });
                    
                    get_colores_inicial();
                });
                
                function get_colores_inicial(){
                    $.post("' . $this->baseurl . INDEX . 'configuracion_carnet/loadconfiguracion_carnet/", function(data){
                        var obj = JSON.parse(data);

                        $("#color_principal").val(obj[0].color_principal);
                        $("#color_secundario").val(obj[0].color_secundario);
                        $("#color_texto").val(obj[0].color_texto);

                        $("#div-elemento").css("background-image", "url(\'https://laclave.diegoaranibar.com/intranet/system/controllers/fondos_carnet/" +obj[0].imagen + "\')");

                        $("#svg_color_principal path").attr("fill", obj[0].color_principal); // Actualizar el color del SVG
                        $("#svg_color_secundario path").attr("fill", obj[0].color_secundario); // Actualizar el color del SVG
                        $("#img_logo").css("background-color", obj[0].color_secundario);
                        $(".color_texto").css("color", obj[0].color_texto);
                    });
                }
                function guardar(){
                    var file = _("imagen").files[0];
                    var formdata = new FormData();
                    formdata.append("foto", file);
                    formdata.append("color_principal", $("#color_principal").val());
                    formdata.append("color_secundario", $("#color_secundario").val());
                    formdata.append("color_texto", $("#color_texto").val());
                    
                    
                    var ajax = new XMLHttpRequest();
                    ajax.upload.addEventListener("progress", progressHandler, false);
                    ajax.addEventListener("load", completeHandler, false);
                    ajax.addEventListener("error", errorHandler, false);
                    ajax.addEventListener("abort", abortHandler, false);
                    ajax.open("POST", "' . $this->baseurl . INDEX . 'configuracion_carnet/save");
                    ajax.send(formdata);

                    /*$.post("' . $this->baseurl . INDEX . 'configuracion_carnet/save", {
                        color_principal: $("#color_principal").val(),
                        color_secundario: $("#color_secundario").val(),
                        color_texto: $("#color_texto").val()
                    }, function(response){
                        var obj = JSON.parse(response);

                        if(obj.Result == "OK"){
                            alertify.notify("<strong>Configuración</strong> registrada correctamente.", "custom-black", 3, function() {});
                        }else{
                            alert("Algo ha salido mal.");
                        }
                    });*/
                }
            </script>';
        return $r;
    }
}
