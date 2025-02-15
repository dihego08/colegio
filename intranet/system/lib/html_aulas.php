<?php
class html_aulas extends f{
    private $baseurl = "";

    function html_aulas(){
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
                .card {
	position: relative !important;
	display: -ms-flexbox !important;
	display: flex !important;
	-ms-flex-direction: column !important;
	flex-direction: column !important;
	min-width: 0 !important;
	word-wrap: break-word !important;
	background-color: #fff !important;
	background-clip: border-box !important;
	border: 1px solid rgba(0, 0, 0, .125) !important;
	border-top-color: rgba(0, 0, 0, 0.125) !important;
	border-right-color: rgba(0, 0, 0, 0.125) !important;
	border-bottom-color: rgba(0, 0, 0, 0.125) !important;
	border-left-color: rgba(0, 0, 0, 0.125) !important;
	border-radius: .25rem !important;
}
    .card-header:first-child {
	border-radius: calc(.25rem - 1px) calc(.25rem - 1px) 0 0 !important;
}
    .card-header {
	padding: .75rem 1.25rem !important;
	margin-bottom: 0 !important;
	background-color: rgba(0, 0, 0, .03) !important;
	border-bottom: 1px solid rgba(0, 0, 0, .125) !important;
}
    .card-body {
	-ms-flex: 1 1 auto !important;
	flex: 1 1 auto !important;
	padding: 1.25rem !important;
}
    .btn_accion {
	border-radius: 50%;
	position: absolute;
	right: 0;
	top: 2px;
	opacity: .8;
}
.rounded-pill {
	border-radius: 50rem !important;
}
            </style>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <span style="float: right; margin-bottom: 10px;" class="btn btn-sm btn-success" data-toggle="modal" data-target="#formulario" id="btn_nuevo" onclick="nuevo_aula();">Nueva Aula</span>
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Lista de Aulas
                        </h5>
                        <small>
                            <i class="fa fa-edit"></i> Aquí podrá ver toda la información de todos los Aulas
                        </small>
                        <hr>         
                        <div class="container">
                            <div class="row">
                                <div class="col-12 form-row"  id="div_aulas">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!----------------------------------------------------------------------->
            <div class="modal fade" id="formulario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="max-width: 45%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLabel">Nueva Aula</h3>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group" style="width: 100%;">
                                <form id="form_nuevo" action="'. $this->baseurl . INDEX . 'aulas/save"  method="post">
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <label>Aula</label>
                                            <input id="aula" class="form-control" name="aula" type="text"/>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <label>Aforo</label>
                                            <input id="aforo" class="form-control" name="aforo" type="text"/>
                                            <input id="id" class="form-control" name="id" type="hidden"/>
                                        </div>

                                        <div class="col-md-6">
                                            <label>Orden</label>
                                            <input id="orden" class="form-control" name="orden" type="text"/>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12" style="margin-top: 15px;">
                                            <button type="submit" class="btn btn-success pull-right" id="btn_finalizar">Guardar</button>
                                            <span class="btn btn-danger" type="button" data-dismiss="modal" id="cerrar_formulario_aula" style="margin-left: 10px">
                                                Cancelar
                                            </span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>
            <!----------------------------------------------------------------------->
            <script>
                $("#form_nuevo").on("submit", function(e) {
                    e.preventDefault();
                    var f = $(this);
                    var metodo = f.attr("method");
                    var url = f.attr("action");
                    var formData = new FormData(this);
                    $.ajax({
                        url: url,
                        type: metodo,
                        dataType: "html",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        beforeSend: function() {},
                        success: function(data) {
                            if (data == 1) {
                                alertify.notify("Campo <strong>código interno</strong> vacío.", "custom", 4, function() {});
                            }
                            if (data == 2) {
                                alertify.notify("Campo <strong>nombre</strong> vacío.", "custom", 4, function() {});
                            }
                            if (data == 0) {
                                f[0].reset();
                                table = $(".datatable").DataTable();
                                table.ajax.reload();
                                alertify.notify("Se agrego el <strong>Aula</strong> correctamente.", "custom-black", 4, function() {})
                                limpiar_formulario();
                                $("#cerrar_formulario_aula").click();
                                lista_aulas();
                            };
                        },
                        error: function() {},
                    });
                });
                function guardar_aforo(id){
                    $.post("'. $this->baseurl . INDEX . 'aulas/guardaraforo", {
                        id: id,
                        aforo: $("#txt_aula_"+id).val()
                    }, function(response){
                        var obj = JSON.parse(response);
                        alertify.notify("<strong>Aula</strong> modificada correctamente.", "custom-black", 3, function() {});
                    });
                }
                function lista_aulas(){
                    $("#div_aulas").empty();
                    $.post("'. $this->baseurl . INDEX . 'aulas/loadaulas", function(response){
                        var obj = JSON.parse(response);
                        $.each(obj, function(index, val){
                            /*$("#div_aulas").append(`<div class="col-md-4 px-2 mb-3 form-row">
                            <div class="col-md-6">
                            <h5>${val.aula}</h5>
                            </div>    
                            
                            <hr class="w-100">
                            </div>`);*/
                            
                            $("#div_aulas").append(`<div class="col-md-4"><div class="card " style="padding: 0px !important; margin-bottom: 5px;">
  						<div class="card-header" style="font-weight: bold;">
    						${val.aula}
                            
    						<span class="btn btn-outline-warning rounded-pill btn-sm btn_accion" style="right: 50px;" data-toggle="modal" data-target="#formulario" onclick="editar(${val.id});"><i class="fa fa-edit"></i></span>
    						<span class="btn btn-outline-danger rounded-pill btn-sm btn_accion" style="right: 2px;" onclick="eliminar(${val.id});"><i class="fa fa-trash"></i></span>
  						</div>
						<div class="card-body form-row">
                            <div class="col-md-12">
                                <span>Orden: ${val.orden}</span>
                            </div>
                            <hr class="w-100">
    						<div class="col-md-8">
                                <input class="form-control h-100" type="text" value="${val.aforo}" id="txt_aula_${val.id}">
                            </div>    
                            <div class="col-md-4">
                                <span class="btn btn-success btn-sm w-100" title="Guardar Aforo" onclick="guardar_aforo(${val.id});"><i class="fa fa-check"></i></span>
                            </div>    
  						</div>
					</div>
                    </div>`);
                        });
                    });
                }
                $(document).ready(function() {
                    $( ".datepicker" ).datepicker();
                    $("#form_agregar input[name=nombre]").focus();
                    $("#form_agregar input[name=nombre]").keyup(function() {
                        var letras = $(this).val().substring(0, 4);
                        var numeros = $(this).val().length;
                        $("#form_agregar input[name=codinterno]").val(letras + numeros + "_fam");
                    });
                    lista_aulas();
                });
                function nuevo_aula(){
                    $("#exampleModalLabel").text("Nueva Aula");
                    $("#form_nuevo").attr("action", "'. $this->baseurl . INDEX . 'aulas/save");
                    $("#btn_finalizar").text("Guardar");
                    $("#btn_finalizar").removeAttr("onclick");
                    limpiar_formulario();
                    $("#alerta_pass").attr("hidden", "hidden");
                }
                function eliminar(id) {
                alertify.confirm(
                    "¿Eliminar Aula?", 
                    "Esta acción es irreversible.", 
                    function(){ 
                        $.ajax({
                            url: "' . $this->baseurl . INDEX . 'aulas/eliminar",
                            type: "POST",
                            dataType: "html",
                            data: {
                                "id": id,
                            },
                            success: function(data) {
                                lista_aulas();
                                alertify.success("Eliminado Correctamente") 
                            }
                        });
                        
                    }, 
                    function(){ 
                        alertify.error("Cancelado")
                    }
                );
                }
                function limpiar_formulario(){
                    $("#aula").val("");
                    $("#descripcion").val("");
                    $("#btn_finalizar").removeAttr("onclick");
                    $("#btn_finalizar").text("Guardar");
                }
                function editar(id){
                    $("#form_nuevo").attr("action", "'.$this->baseurl . INDEX . 'aulas/editarBD");
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'aulas/editar",
                        type: "POST",
                        dataType: "json",
                        data: {
                            "id": id,
                        },
                        success: function(data) {
                            $("#aula").val(data[0].aula);
                            $("#aforo").val(data[0].aforo);
                            $("#id").val(data[0].id);
                            $("#orden").val(data[0].orden);
                            
                            //$("#btn_finalizar").text("Actualizar");
                            //$("#btn_finalizar").attr("onclick", "actualizar_aula("+data[0].id+");");

                            //$("#form_nuevo").attr("action", "'.$this->baseurl . INDEX . 'aulas/editarBD");
                            $("#exampleModalLabel").text("Editar Aula");
                            //$("#alerta_pass").removeAttr("hidden");
                        }
                    });
                }
                $("#cerrar_formulario_aula").click(function(){
                    limpiar_formulario();
                });
                function actualizar_aula(id){
                    $("#form_nuevo").on("submit", function(e) {
                        e.preventDefault();
                        var f = $(this);
                        var metodo = f.attr("method");
                        var url = f.attr("action");
                        var formData = new FormData(this);
                        formData.append("id", id);
                        $.ajax({
                            url: url,
                            type: metodo,
                            dataType: "html",
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            beforeSend: function() {},
                            success: function(response) {
                                lista_aulas();
                                //alertify.modalcursos().close();
                                alertify.notify("<strong>Aula</strong> modificada correctamente.", "custom-black", 3, function() {});
                                $("#cerrar_formulario_aula").click();
                                alertify.closeAll();
                                
                            },
                            error: function() {},
                        });
                    });
                }
            </script>';     
            return $r;
        }
    }
?>
