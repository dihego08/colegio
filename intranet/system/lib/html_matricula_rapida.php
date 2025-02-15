<?php
class html_matricula_rapida extends f{
	private $baseurl = "";

	function html_matricula_rapida(){
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
                        <!--<span style="float: right; margin-bottom: 10px;" class="btn btn-sm btn-success" data-toggle="modal" data-target="#formulario" id="btn_nuevo" onclick="nuevo_alumno();">Nuevo Alumno</span>-->
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Nueva Matrícula
                        </h5>
                        <small>
                            <i class="fa fa-edit"></i> Registro de Nueva Matrícula
                        </small>
                        <hr>         
                        <div class="container" style="max-width: 100%;">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="mt-0">Filtros de Búsqueda</h4>
                                </div>
                                <div class="col-md-6">
                                    <label>DNI de Alumno</label>
                                    <input type="text" class="form-control ui-autocomplete-input" id="dni" name="dni" placeholder="Ingrese DNI">
                                </div>
                                <div class="col-md-6">
                                    <label>Apellidos de Alumno</label>
                                    <input type="text" class="form-control ui-autocomplete-input" id="apellidos" name="apellidos" placeholder="Ingrese Nombres o Apellidos">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="w-100">
                <div class="row">
                    <div class="col-md-4" style="border-right: solid rgba(0, 0, 0, 0.3); border-top-right-radius: 8px; border-bottom-right-radius: 8px;">
                        <div id="div_historial" style="width: 100%; text-align: center;">
                        </div>
                    </div>
                    <div class="col-md-8" style="border-right: solid rgba(0, 0, 0, 0.3); border-top-right-radius: 8px; border-bottom-right-radius: 8px;" id="div_mostrar" hidden>
                        <h4 style="text-align: center;">Registrar Matrícula</h4>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                            <input type="hidden" id="cupos_2">
                                <label>Grado</label>
                                <select class="form-control" id="id_grado" name="id_grado">
                                    <option value="0">SELECCIONA...</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="text-align: center; margin-bottom: 5px;">
                                <span class="btn btn-success" onclick="registrar_matricula();">Registrar Matrícula</span>
                            </div>
                            <div class="col-md-12" style="text-align: center;">
                                <button class="btn btn-danger" onClick="location.reload();">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                var id_alumno = 0; 
                $(document).ready(function() {
                    $("#dni").val("");
                    $("#apellidos").val("");
                    cbo_grado(0);
                    $("#dni").autocomplete({
                        source: "' . $this->baseurl . INDEX . 'alumnos/get_alumno_dni/",
                        minLength: 2,
                        focus: true,
                        select: function(event, ui) {
                            id_alumno = ui.item.id;
                            $.get("' . $this->baseurl . INDEX . 'matricula_rapida/get_historial/", {
                                id_alumno: ui.item.id
                            }, function(responseText){
                                $("#div_mostrar").removeAttr("hidden");
                                $("#div_historial").empty();
                                if(responseText == "" || responseText == "null"){
                                    $("#div_historial").append(`<h5 style="text-align: center; margin-bottom:10px;">Sin Historial de Matrícula</h5>`);
                                }else{
                                    var obj = JSON.parse(responseText);
                                    $("#div_historial").append(`<h5 style="text-align: center; margin-bottom:10px;">`+ui.item.value+` - <strong>Historial de Matrícula</strong></h5>`);
                                    $.each(obj, function(index, val){
                                        $("#div_historial").append(`<span style="font-size: 15px; margin-bottom: 5px; text-wrap: auto;" class="badge badge-pill badge-primary">`+val.grado+` - `+val.fecha+`</span>`);
                                    });
                                }
                            });
                        }
                    });
                    $("#apellidos").autocomplete({
                        source: "' . $this->baseurl . INDEX . 'alumnos/get_alumno/",
                        minLength: 2,
                        focus: true,
                        select: function(event, ui) {
                            id_alumno = ui.item.id;
                            $.get("' . $this->baseurl . INDEX . 'matricula_rapida/get_historial/", {
                                id_alumno: ui.item.id
                            }, function(responseText){
                                $("#div_mostrar").removeAttr("hidden");
                                $("#div_historial").empty();
                                if(responseText == "" || responseText == "null"){
                                    $("#div_historial").append(`<h5 style="text-align: center; margin-bottom:10px;">Sin Historial de Matrícula</h5>`);
                                }else{
                                    var obj = JSON.parse(responseText);
                                    $("#div_historial").append(`<h5 style="text-align: center; margin-bottom:10px;">`+ui.item.value+` - <strong>Historial de Matrícula</strong></h5>`);
                                    $.each(obj, function(index, val){
                                        $("#div_historial").append(`<span style="font-size: 15px; text-wrap: auto;" class="badge badge-pill badge-primary">`+val.grado+` - `+val.fecha+`</span>`);
                                    });
                                    //var nn = parseInt() + parseInt(1);
                                }
                            });
                        }
                    });
                    function cbo_grado(id_grado){
                        $.get("' . $this->baseurl . INDEX . 'grados/loadgrados", function(response){
                            var obj = JSON.parse(response);
                            $.each(obj, function(index, val){
                                $("#id_grado").append("<option value=" + val.id + ">" + val.grado + "</option>");
                            });
                        });
                    }
                });
                function registrar_matricula(){
                    var dd = parseInt($("#cupos_2").val()) + parseInt(1);
                    $.post("' . $this->baseurl . INDEX . 'matricula_rapida/save", {
                        id_alumno: id_alumno,
                        id_grado: $("#id_grado").val(),
                        cupos_2: dd
                    }, function(responseText){
                        var obj = JSON.parse(responseText);
                        //$.colorbox.close();
                        alertify.notify("Matrícula <strong>Registrada</strong> correctamente.", "custom-black", 4, function() {})
                    });
                }
            </script>';     
            return $r;
        }
    }
?>