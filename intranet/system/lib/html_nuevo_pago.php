<?php
class html_nuevo_pago extends f{
	private $baseurl = "";

	function html_nuevo_pago(){
		$this->load()->lib_html("Table", false);
		$this->baseurl = BASEURL;
	}
    function container(){
        $r = '<script>
                function abrir_modal(b,a){alertify.dialog(b,function(){return{main:function(c){this.setContent(c);},setup:function(){return{focus:{element:function(){return this.elements.body.querySelector(this.get("selector"));
                },select:true},options:{basic:false,title:a,maximizable:false,resizable:false,padding:true,modal:true,transition:false,}};},settings:{selector:undefined}};
                });}
            </script>
            <div class="container-fluid" style="margin-top: 56px;">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <!--<span style="float: right; margin-bottom: 10px;" class="btn btn-sm btn-success" data-toggle="modal" data-target="#formulario" id="btn_nuevo" onclick="nuevo_alumno();">Nuevo Alumno</span>-->
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Nuevo Pago
                        </h5>
                        <small>
                            <i class="far fa-edit"></i> Registro de Nuevo Pago
                        </small>
                        <hr>
                        <div class="container" style="max-width: 100%;">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Filtrar Alumno</h4>
                                </div>
                                <div class="col-md-12">
                                    <label>Apellidos de Alumno</label>
                                    <input type="text" class="form-control ui-autocomplete-input" id="apellidos" name="apellidos" placeholder="Ingrese Nombres o Apellidos">
                                </div>
                            </div>
                            <div class="col-12" style="margin-top: 10px;">
                                <!--<span class="btn btn-success" style=" width: 100%;" onclick="buscar();">Buscar</span>-->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 15px;">
                    <div class="col-md-12" style="border-right: solid rgba(0, 0, 0, 0.3); border-top-right-radius: 8px; border-bottom-right-radius: 8px;" id="div_mostrar" hidden>
                        <h4 style="text-align: center;">Registrar Pago de Alumno</h4>
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Concepto</label>
                                <input type="text" class="form-control" name="concepto" id="concepto">
                            </div>
                            <div class="col-md-4">
                                <label>Monto Paga</label>
                                <input type="text" class="form-control" name="m_paga" id="m_paga">
                            </div>
                            <div class="col-md-4">
                                <label>Monto Adeuda</label>
                                <input type="text" class="form-control" name="m_adeuda" id="m_adeuda">
                            </div>
                        </div>
                        <div class="row" style="margin-top: 15px;">
                            <h4>
                                Conceptos Pagados
                            </h4>
                            <table class="table table-bordered" id="tabla_pagos">
                                <thead>
                                    <tr>
                                        <th>Dni</th>
                                        <th>Alumno</th>
                                        <th>Concepto</th>
                                        <th>Pagado</th>
                                        <th>Adeuda</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="row" style="margin-top: 15px;">
                            <div class="col-md-12" style="text-align: center; margin-bottom: 5px;">
                                <span class="btn btn-success" onclick="registrar_matricula();">Registrar Pago</span>
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
                    $("#apellidos").autocomplete({
                        source: "' . $this->baseurl . INDEX . 'alumnos/get_alumno/",
                        minLength: 2,
                        focus: true,
                        select: function(event, ui) {
                            id_alumno = ui.item.id;
                            $.get("' . $this->baseurl . INDEX . 'nuevo_pago/get_historial/", {
                                id_alumno: ui.item.id
                            }, function(responseText){
                                $("#div_mostrar").removeAttr("hidden");
                                $("#div_historial").empty();
                                if(responseText == "" || responseText == "null"){
                                    $("#tabla_pagos").find("tbody").append(`<tr><td colspan="6">Sin Historial de Pagos</td></tr>`);
                                }else{
                                    var obj = JSON.parse(responseText);
                                    /*$("#div_historial").append(`<h5 style="text-align: center; margin-bottom:10px;">`+ui.item.value+` - Historial de Matrícula</h5>`);*/
                                    $.each(obj, function(index, val){
                                        var cls = "";
                                        var btn = "";
                                        if(val.m_adeuda == 0 || val.m_adeuda == "" || val.m_adeuda == "null" || val.m_adeuda == null){
                                            
                                        }else{
                                            cls = "table-danger";
                                            btn = `<span class="btn btn-sm btn-success" onClick="cancelar_deuda(`+val.id_pago+`, `+val.m_adeuda+`);" style="cursor: pointer;"><i class="fa fa-check"></i></span>`;
                                        }
                                        $("#tabla_pagos").append(`<tr class="`+cls+`"><td>`+val.dni+`</td>
                                            <td>`+val.alumno+`</td>
                                            <td>`+val.concepto+`</td>
                                            <td>`+val.m_pagado+`</td>
                                            <td>`+val.m_adeuda+`</td>
                                            <td>`+btn+`</td></tr>`);
                                        
                                    });
                                    //var nn = parseInt() + parseInt(1);
                                }
                            });
                        }
                    });
                });
                function cancelar_deuda(id_pago, m_adeuda){
                    $.get("' . $this->baseurl . INDEX . 'pagos/cancelar_deuda", {
                        id_pago: id_pago,
                        m_adeuda: m_adeuda
                    }, function(responseText){

                    });
                }
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