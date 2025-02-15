<?php
class html_asientos extends f{
    private $baseurl = "";

    function html_asientos(){
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
                    width: 100%;
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
                            <i class="fa fa-bars" aria-hidden="true"></i> Configuración de Asientos
                        </h5>
                        <small>
                            <i class="far fa-edit"></i> Aquí podrá gestionar la configuración de los Asientos
                        </small>
                        <hr>         
                        <div class="container" style="max-width: 100%;">
                            <div class="row">
                                <fieldset style="margin-top: 10px;">
                                    <legend>
                                        Buscar Bus
                                    </legend>
                                    <label>Número de Placa</label>
                                    <input type="text" class="form-control" id="placa_autocomplete" name="placa_autocomplete">
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <div class="row col-md-12" style="margin-top: 25px;">
                        <div class="col-md-3">
                            <fieldset style="margin-top: 10px;">
                                <legend style="white-space: nowrap; width: auto;">
                                    Datos del Bus
                                </legend>
                                <label>Placa</label>
                                <input type="text" class="form-control texto" id="placa" name="placa" disabled>
                                <label>Modelo</label>
                                <input type="text" class="form-control texto" id="modelo" name="modelo" disabled>
                                <label>Pisos</label>
                                <input type="text" class="form-control texto" id="pisos" name="pisos" disabled>
                                <label>Tot. Asientos</label>
                                <input type="text" class="form-control texto" id="t_asientos" name="t_asientos" disabled>
                            </fieldset>
                        </div>
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
                    </div>
                </div>
            </div>
            <div class="modal fade" id="formulario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="max-width: 30%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLabel">Tipo de Asiento</h3>
                            <button id="cerrar_modal" class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body" style="text-align: center;" id="tipos_asiento">
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" id="id_asiento_alternativo">
                            <input type="hidden" id="id_piso_alternativo">
                            <input type="hidden" id="id_bus_alternativo">
                        </div>
                    </div>
                </div>
            </div>
            <script>
                $(document).ready(function() {
                    llenar_modal();
                    $("#placa_autocomplete").autocomplete({
                        source: "' . $this->baseurl . INDEX . 'buses/get_bus/",
                        minLength: 2,
                        focus: true,
                        select: function(event, ui) {
                            $.get("' . $this->baseurl . INDEX . 'buses/get_one/", {
                                id_bus: ui.item.id
                            }, function(responseText){
                                var obj = JSON.parse(responseText);
                                $("#placa").val(obj.placa);
                                $("#modelo").val(obj.modelo);
                                $("#pisos").val(obj.pisos);
                                $("#t_asientos").val(obj.t_asientos);

                                if(obj.pisos == 1){
                                    $("#piso_selector").attr("disabled", true);
                                }else{
                                    //$("#piso_selector").empty();
                                    $("#piso_selector").removeAttr("disabled");
                                    /*$("#piso_selector").append(`<option value="`+obj.p_1_asientos+`">Piso 1</option>`);
                                    $("#piso_selector").append(`<option value="`+obj.p_2_asientos+`">Piso 2</option>`);*/
                                }
                                dibujar(1);
                                //$("#id_bus_alternativo").val(obj.id);
                            });
                        }
                    });
                    $("#piso_selector").on("change", function(){
                        dibujar($("#piso_selector").val());
                    });
                    function llenar_modal(){
                        $.post("' . $this->baseurl . INDEX . 'conf_precios/loadprecios/", function(responseText){
                            var obj = JSON.parse(responseText);
                            $.each(obj, function(index, val){
                                $("#tipos_asiento").append(`<span class="btn" onclick="guardar_tipo_asiento(`+val.id+`, \'`+val.background+`\');" style="background-color: `+val.background+`; margin: 2px;">`+val.tipo+`</span>`);
                            });
                        });
                    }
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
                                    $("#tr_"+aux).append(`<td class="td_a"><span data-toggle="modal" data-target="#formulario" class="btn btn-sm" onclick="asignar_tipo(`+piso+`, `+(parseInt(index) + parseInt(1))+`);" id="a_`+(parseInt(index) + parseInt(1))+`" style="background-color: #333; color: white;">` + (parseInt(index) + parseInt(1)) + `</span></td>`);
                                }else{
                                    $("#tr_"+aux).append(`<td class="td_a"><span data-toggle="modal" data-target="#formulario" class="btn btn-sm" onclick="asignar_tipo(`+piso+`, `+(parseInt(index) + parseInt(1))+`);" id="a_`+(parseInt(index) + parseInt(1))+`" style="background-color: `+val.background+`">` + (parseInt(index) + parseInt(1)) + `</span></td>`);
                                }
                                aux++;
                            });
                        });
                    }
                });
                function asignar_tipo(piso, asiento){
                    $("#id_asiento_alternativo").val(asiento);
                    $("#id_piso_alternativo").val(piso);
                }
                function guardar_tipo_asiento(id_tipo, background){
                    $.post("' . $this->baseurl . INDEX . 'asientos/guardar_tipo_asiento/", {
                        placa_bus: $("#placa").val(),
                        piso: $("#id_piso_alternativo").val(),
                        id_tipo: id_tipo,
                        n_asiento: $("#id_asiento_alternativo").val(),
                        background: background
                    }, function(responseText){
                        var obj = JSON.parse(responseText);
                        if(obj.Result == "OK"){
                            alertify.notify("Guardado <strong>Correctamente</strong>.", "custom-black", 4, function() {});
                            
                            $("#a_" + $("#id_asiento_alternativo").val()).removeAttr("style");
                            $("#a_" + $("#id_asiento_alternativo").val()).css("background-color", background);
                        }else{
                            alertify.notify("<strong>Algo ha Salido Mal!!!</strong>.", "custom-black", 4, function() {});
                        }
                    });
                    $("#cerrar_modal").click();
                }
            </script>';     
            return $r;
        }
    }
?>
