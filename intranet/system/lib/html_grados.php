<?php
class html_grados extends f{
    private $baseurl = "";

    function html_grados(){
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
                        <span style="float: right; margin-bottom: 10px;" class="btn btn-sm btn-success" data-toggle="modal" data-target="#formulario" id="btn_nuevo" onclick="nuevo_grado();">Nuevo Grado</span>
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Lista de Grados
                        </h5>
                        <small>
                            <i class="far fa-edit"></i> Aquí podrá ver toda la información de todos los Grados
                        </small>
                        <hr>         
                        <div class="container">
                            <div class="row">
                                <div class="col-12" >
                                    <table  class="datatable table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Grado</th>
                                                <th>Editar</th>
                                                <th>Eliminar</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!----------------------------------------------------------------------->
            <div class="modal fade" id="formulario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="max-width: 25%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLabel">Nuevo Grado</h3>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group" style="width: 100%;">
                                <form id="form_nuevo" action="'. $this->baseurl . INDEX . 'grados/save"  method="post">
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <label>Grado</label>
                                            <input id="grado" class="form-control" name="grado" type="text"/>
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
                                alertify.notify("Se agrego el <strong>Grado</strong> correctamente.", "custom-black", 4, function() {})
                                limpiar_formulario();
                                $("#cerrar_formulario_grado").click();
                            };
                        },
                        error: function() {},
                    });
                });
                $(document).ready(function() {
                    cbo_aulas(0);
                    $( ".datepicker" ).datepicker();
                    $("#form_agregar input[name=nombre]").focus();
                    $("#form_agregar input[name=nombre]").keyup(function() {
                        var letras = $(this).val().substring(0, 4);
                        var numeros = $(this).val().length;
                        $("#form_agregar input[name=codinterno]").val(letras + numeros + "_fam");
                    });
                    var table = $(".datatable").DataTable({
                        "ajax": {
                            url: "' . $this->baseurl . INDEX . 'grados/loadgrados/",
                            "dataSrc": ""
                        },
                        "columns": [{
                            "data": "id"
                        },  {
                            "data": "grado"
                        },  {
                            "defaultContent": "<button id=\"btn_editar\" data-toggle=\"modal\" data-target=\"#formulario\" class=\"btn btn-outline-warning btn-sm\" ><i class=\"fa fa-edit\"></i></button>"
                        }, {
                            "defaultContent": "<button id=\"btn_eliminar\" class=\"btn btn-outline-danger btn-sm\"><i class=\"fa fa-trash\"></i></button>"
                        }, ],
                        "language": {
                            "url": "'.$this->baseurl.'includes/datatables/Spanish.json"
                        },
                        "lengthMenu": [
                            [10, 15, 20, -1],
                            [10, 15, 20, "All"]
                        ]
                    });
                    $(".datatable tbody").on("click", "#btn_eliminar", function() {
                        var data = table.row($(this).parents("tr")).data();
                        if (data == undefined) {
                            var selected_row = $(this).parents("tr");
                            if (selected_row.hasClass("child")) {
                                selected_row = selected_row.prev();
                            }
                            var rowData = $(".datatable").DataTable().row(selected_row).data();
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el Grado <strong>" + rowData["grado"] + "</strong>?",
                            function() {
                                eliminar(rowData["id"]);
                                alertify.notify("Se elimino el Grado <strong>" + rowData["grado"] + "</strong> correctamente.", "custom-black", 4, function() {});
                            },
                            function() {
                                alertify.notify("Se cancelo la <strong>eliminación</strong>.", "custom-black", 4, function() {});
                            }).set("labels", { ok: "Eliminar", cancel: "Cancelar" });
                        } else {
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el Grado <strong>" + data["grado"] + "</strong>?",
                            function() {
                                eliminar(data["id"]);
                                alertify.notify("Se elimino el Grado <strong>" + data["grado"] + "</strong> correctamente.", "custom-black", 4, function() {});
                            },
                            function() {
                                alertify.notify("Se cancelo la <strong>eliminación</strong>.", "custom-black", 4, function() {});
                            }).set("labels", { ok: "Eliminar", cancel: "Cancelar" });
                        }
                    });
                    $(".datatable tbody").on("click", "#btn_editar", function() {
                        var data = table.row($(this).parents("tr")).data();
                        if (data == undefined) {
                            var selected_row = $(this).parents("tr");
                            if (selected_row.hasClass("child")) {
                                selected_row = selected_row.prev();
                            }
                            var rowData = $(".datatable").DataTable().row(selected_row).data();
                            editar(rowData["id"]);
                        } else {
                            editar(data["id"]);
                        }
                    });
                });
                function cbo_aulas(id_aula){
                    $.get("' . $this->baseurl . INDEX . 'aulas/loadaulas", function(response){
                        var obj = JSON.parse(response);
                        $.each(obj, function(index, val){
                            if(val.id == id_aula){
                                $("#id_aula").append("<option value="+val.id+" selected>"+val.aula+"</option>");
                            }else{
                                $("#id_aula").append("<option value="+val.id+">"+val.aula+"</option>");
                            }
                        });
                    });
                }
                function nuevo_grado(){
                    $("#id_aula option").removeAttr("selected");
                    $("#id_aula option[value=0]").attr("selected", true);
                    $("#exampleModalLabel").text("Nuevo Grado");
                    $("#form_nuevo").attr("action", "'. $this->baseurl . INDEX . 'grados/save");
                    $("#btn_finalizar").text("Guardar");
                    $("#btn_finalizar").removeAttr("onclick");
                    limpiar_formulario();
                    $("#alerta_pass").attr("hidden", "hidden");
                }
                function eliminar(id) {
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'grados/eliminar",
                        type: "POST",
                        dataType: "html",
                        data: {
                            "id": id,
                        },
                        success: function(data) {
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                        }
                    });
                }
                function limpiar_formulario(){
                    $("#grado").val("");
                    $("#descripcion").val("");
                    $("#btn_finalizar").removeAttr("onclick");
                    $("#btn_finalizar").text("Guardar");
                }
                function editar(id){
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'grados/editar",
                        type: "POST",
                        dataType: "json",
                        data: {
                            "id": id,
                        },
                        success: function(data) {
                            $("#grado").val(data[0].grado);
                            $("#btn_finalizar").text("Actualizar");
                            $("#btn_finalizar").attr("onclick", "actualizar_grado("+data[0].id+");");
                            $("#form_nuevo").attr("action", "'.$this->baseurl . INDEX . 'grados/editarBD");
                            $("#exampleModalLabel").text("Editar Grado");
                        }
                    });
                }
                $("#cerrar_formulario_grado").click(function(){
                    limpiar_formulario();
                });
                function actualizar_grado(id){
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
                                f[0].reset();
                                table = $(".datatable").DataTable();
                                table.ajax.reload();
                                //alertify.modalcursos().close();
                                alertify.notify("<strong>Grado</strong> modificada correctamente.", "custom-black", 3, function() {});
                                $("#cerrar_formulario_grado").click();
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
