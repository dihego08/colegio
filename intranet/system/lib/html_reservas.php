<?php
class html_reservas extends f{
	private $baseurl = "";

	function html_reservas(){
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
                fieldset {
                    border: 1px solid #ddd !important;
                    margin: 0;
                    xmin-width: 0;
                    padding: 10px;       
                    position: relative;
                    border-radius:4px;
                    background-color:#f5f5f5;
                    padding-left:10px!important;
                }   
                legend{
                    font-size:14px;
                    font-weight:bold;
                    margin-bottom: 0px; 
                    width: 35%; 
                    border: 1px solid #ddd;
                    border-radius: 4px; 
                    padding: 5px 5px 5px 10px; 
                    background-color: #ffffff;
                }
                .texto{
                    text-align: center;
                    font-size: 25px;
                    font-weight: bold;
                    color: #00009F;
                }
                .td_a{
                    width: 65px;
                    height: 65px;
                }
                .td_a > span{
                    width: 100%;
                    height: 100%;
                }
            </style>
            <div class="container-fluid" style="margin-top: 56px;">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Reserva de Boletos
                        </h5>
                        <hr>         
                        <div class="container" style="max-width: 100%;">
                            <div class="row col-md-12">
                                <label style="font-weight: bold;">Buscar Salida</label>
                                <input type="text" class="form-control ui-autocomplete-input" name="salida_autocomplete" id="salida_autocomplete" placeholder="Búsqueda de Salidas">
                                <input type="hidden" id="id_salida" name="id_salida">
                            </div>
                            <fieldset style="margin-top: 10px;">
                                <legend>
                                    Detalle Salida
                                </legend>
                                <div>
                                    <div class="row col-md-12">
                                        <div class="col-md-2">
                                            <label>Origen</label>
                                            <input type="text" class="form-control texto" id="origen" name="origen">
                                        </div>
                                        <div class="col-md-2">
                                            <label>Parada</label>
                                            <input type="text" class="form-control texto" id="parada" name="parada">
                                            <!--<select class="form-control">
                                                <option>-</option>
                                                <option>Lima</option>
                                                <option>Ica</option>
                                            </select>-->
                                        </div>
                                        <div class="col-md-2">
                                            <label>Destino</label>
                                            <input type="text" class="form-control texto" id="destino" name="destino">
                                        </div>
                                        <!--<div class="col-md-4">
                                            <label>F. y H. Salida</label>
                                            <input type="text" class="form-control datepicker">
                                        </div>-->
                                        <div class="col-md-2">
                                            <label>F. Salida</label>
                                            <input type="text" class="form-control texto" name="fecha" id="fecha">
                                        </div>
                                        <div class="col-md-2">
                                            <label>H. Salida</label>
                                            <input type="text" class="form-control texto" name="hora_salida" id="hora_salida">
                                        </div>
                                        <!--<div class="col-md-2">
                                            <label>Precio</label>
                                            <input type="text" class="form-control texto" name="precio" id="precio">
                                        </div>-->
                                    </div>
                                    <!--<div class="row col-md-2">
                                        <button class="btn btn-info">+</button>
                                        <button class="btn btn-info">-</button>
                                    </div>-->
                                </div>
                            </fieldset>
                            <hr>
                            <div class="row" style="margin-top: 25px;">
                                <div class="col-md-9">
                                    <label>Piso</label>
                                    <select class="form-control" id="piso_selector">
                                        <option value="1">Piso 1</option>
                                        <option value="2">Piso 2</option>
                                    </select>
                                    <h3 style="margin-top: 10px; margin-bottom: 10px;">Detalle de Asientos - Piso 1</h3>
                                    <table calss="table" style="margin-top: 15px; width: 100%;" id="tabla_asientos">
                                        <tr id="tr_1">
                                        </tr>
                                        <tr id="tr_2">
                                        </tr>
                                        <tr id="tr_p">
                                            <td class="td_a"><span>  </span></td>
                                        </tr>
                                        <tr id="tr_3">
                                        </tr>
                                        <tr id="tr_4">
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-3">
                                    <fieldset style="margin-top: 10px;">
                                        <legend style="white-space: nowrap; width: auto;">
                                            Datos Pasajero
                                        </legend>
                                        <label>DNI</label>
                                        <input type="text" class="form-control" name="dni" id="dni">
                                        <label>NOMBRE</label>
                                        <input type="text" class="form-control" name="nombre" id="nombre">
                                    </fieldset>
                                    <fieldset style="margin-top: 10px;">
                                        <legend style="white-space: nowrap; width: auto;">
                                            Datos Vehiculo
                                        </legend>
                                        <label>Placa</label>
                                        <input type="text" class="form-control texto" id="placa" name="placa">
                                        <label>Asientos</label>
                                        <input type="text" class="form-control texto" id="t_asientos" name="t_asientos">
                                        <label>Modelo</label>
                                        <input type="text" class="form-control texto" id="modelo" name="modelo">
                                    </fieldset>
                                    <fieldset style="margin-top: 10px; text-align: center;">
                                        <legend style="white-space: nowrap; width: auto;">
                                            Imprimir Manifiesto
                                        </legend>
                                        <button class="btn btn-secondary"><i class="fa fa-print"></i></button>
                                    </fieldset>
                                </div>
                            </div>
                            <hr>
                            <div class="row col-md-12" style="margin-top: 25px;">
                                <button class="btn btn-primary" style="margin-right: 10px; margin-left: auto;">Guardar</button>
                                <button class="btn btn-danger">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/jquery.datetimepicker.full.min.js"></script>
            <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/build/jquery.datetimepicker.min.css" rel="stylesheet"/>
            <script>
                function dibujar(piso){
                    $("#tr_1").empty();
                    $("#tr_2").empty();
                    $("#tr_3").empty();
                    $("#tr_4").empty();
                    $.get("' . $this->baseurl . INDEX . 'asientos/get_asientos/", {
                        placa_bus: $("#placa").val(),
                        piso: piso
                    }, function(responseText){
                        var obj = JSON.parse(responseText);
                        var aux = 1;
                        $.each(obj.Records, function(index, val){
                            if(aux == 5){
                                aux = 1;
                            }
                            if(val.background == null || val.background == ""){
                                $("#tr_"+aux).append(`<td class="td_a"><span data-toggle="modal" data-target="#formulario" class="btn btn-sm" onclick="reservar(`+(parseInt(index) + parseInt(1))+`);" id="a_`+(parseInt(index) + parseInt(1))+`" style="background-color: #333; color: white;">` + (parseInt(index) + parseInt(1)) + `</span></td>`);
                            }else{
                                $("#tr_"+aux).append(`<td class="td_a"><span data-toggle="modal" data-target="#formulario" class="btn btn-sm" onclick="reservar(`+(parseInt(index) + parseInt(1))+`);" id="a_`+(parseInt(index) + parseInt(1))+`" style="background-color: `+val.background+`">` + (parseInt(index) + parseInt(1)) + `</span></td>`);
                            }
                            aux++;
                        });
                    });
                }
                function reservar(asiento){
                    if($("#dni").val() == ""){
                        $("#dni").focus();
                        alertify.notify("<strong>Campo DNI VACIO</strong>.", "custom-black", 3, function() {});
                    }else{
                        $.post("' . $this->baseurl . INDEX . 'reservas/save/", {
                            id_salida: $("#id_salida").val(),
                            dni: $("#dni").val(),
                            nombres: $("#nombre").val(),
                            asiento: asiento,
                            placa_bus: $("#placa").val(),
                            piso: $("#piso_selector").val()
                        }, function(responseText){
                            var obj = JSON.parse(responseText);
                            if(obj.Result == "OK"){
                                alertify.notify("<strong>Reserva Registrada</strong> Correctamente.", "custom-black", 3, function() {});
                                $("#cerrar_formulario_docente").click();
                                $("#cerrar_alerta").click();
                                $("#dni").val("");
                                $("#nombre").val("");
                                $("#dni").focus();
                                //$("#a_" + asiento).removeCss();
                                $("#a_" + asiento).css({"background-color": "red", "color": "white"});
                                $("#a_" + asiento).attr("disabled", true);
                                $("#a_" + asiento).removeAttr("onclick");

                            }else{
                                alertify.notify("<strong>Algo ha salido mal!!!</strong>", "custom-black", 3, function() {});
                            }
                        });
                    }
                }
                $(document).ready(function() {
                    /*$("#salida_autocomplete").on("keydown", function(e) {
                        if (e.which == 13) {
                            $("#dni").focus();
                        }
                    });*/
                    $("#dni").on("keydown", function(e) {
                        if (e.which == 13) {
                            $("#nombre").focus();
                        }
                    });
                    $("#piso_selector").on("change", function(){
                        dibujar($("#piso_selector").val());
                    });
                    $("#salida_autocomplete").autocomplete({
                        source: "' . $this->baseurl . INDEX . 'salidas/get_salida/",
                        minLength: 2,
                        focus: true,
                        select: function(event, ui) {
                            $.get("' . $this->baseurl . INDEX . 'salidas/get_one/", {
                                id_ruta: ui.item.id
                            }, function(responseText){
                                var obj = JSON.parse(responseText);
                                var a = obj[0].identificador.split("-");
                                $("#id_salida").val(obj[0].id);
                                $("#origen").val(a[0]);
                                $("#destino").val(a[1]);
                                $("#fecha").val(obj[0].fecha);
                                $("#hora_salida").val(obj[0].hora_salida);
                                $("#placa").val(obj[0].placa);
                                $("#t_asientos").val(obj[0].t_asientos);
                                $("#modelo").val(obj[0].modelo);
                                dibujar($("#piso_selector").val());
                                $("#dni").focus();
                            });
                        }
                    });
                });
            </script>';     
            return $r;
        }
    }
?>
