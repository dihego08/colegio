<?php
class html_niveles extends f{
    private $baseurl = "";

    function html_niveles(){
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
                    <div class="col-12 col-md-4">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Nueva Categoría
                        </h5>
                        <small>
                            <i class="far fa-edit"></i> Aquí podrá Agregar y Modificar la información de los Niveles
                        </small>
                        <hr>
                        <div class="form-row">
                            <div class="col-md-12">
                                <label>Categoria</label>
                                <input type="text" class="form-control" id="nivel" name="nivel">
                            </div>
                            <div class="col-md-12 mt-3">
                                <span class="btn btn-success" style="width: 100%;" id="btn_funcion">Guardar</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-8">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Lista de Niveles
                        </h5>
                        <small>
                            <i class="far fa-edit"></i> Aquí podrá ver toda la información de todos los Niveles
                        </small>
                        <hr>         
                        <div class="container">
                            <div class="row">
                                <div class="col-12" >
                                    <table  class="datatable table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Nivel</th>
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
            <script>
                
                $(document).ready(function() {
                    $("#btn_funcion").attr("onclick", "guardar_nivel();");

                    var table = $(".datatable").DataTable({
                        "ajax": {
                            url: "' . $this->baseurl . INDEX . 'niveles/loadniveles/",
                            "dataSrc": ""
                        },
                        "columns": [{
                            "data": "id"
                        },  {
                            "data": "nivel"
                        }, {
                            "defaultContent": "<button id=\"btn_editar\" data-toggle=\"modal\" data-target=\"#formulario\" class=\"btn btn-info btn-sm\" ><i class=\"fas fa-pencil-alt\"></i></button>"
                        }, {
                            "defaultContent": "<button id=\"btn_eliminar\" class=\"btn btn-danger btn-sm\"><i class=\"far fa-trash-alt\"></i></button>"
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
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el Nivel <strong>" + rowData["nivel"] + "</strong>?",
                            function() {
                                eliminar(rowData["id"]);
                                alertify.notify("Se elimino el Nivel <strong>" + rowData["nivel"] + "</strong> correctamente.", "custom-black", 4, function() {});
                            },
                            function() {
                                alertify.notify("Se cancelo la <strong>eliminación</strong>.", "custom-black", 4, function() {});
                            }).set("labels", { ok: "Eliminar", cancel: "Cancelar" });
                        } else {
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el Nivel <strong>" + data["nivel"] + "</strong>?",
                            function() {
                                eliminar(data["id"]);
                                alertify.notify("Se elimino el Nivel <strong>" + data["nivel"] + "</strong> correctamente.", "custom-black", 4, function() {});
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
                function nuevo_docente(){
                    $("#exampleModalLabel").text("Nuevo Docente");
                    //$("#form_nuevo").attr("action", "'. $this->baseurl . INDEX . 'profesores/save");
                    $("#btn_finalizar").text("Guardar");
                    $("#btn_finalizar").removeAttr("onclick");
                    limpiar_formulario();
                    $("#alerta_pass").attr("hidden", "hidden");
                }
                function eliminar(id) {
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'niveles/eliminar",
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
                    $("#nivel").val("");
                    
                    $("#btn_funcion").attr("onclick", "guardar_nivel();");
                    $("#btn_funcion").text("Guardar");
                }
                function editar(id){
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'niveles/editar",
                        type: "POST",
                        dataType: "json",
                        data: {
                            "id_nivel": id,
                        },
                        success: function(data) {
                            $("#nivel").val(data.nivel);

                            $("#btn_funcion").text("Actualizar");
                            $("#btn_funcion").attr("onclick", "actualizar_categoria("+id+");");
                        }
                    });
                }
                $("#cerrar_formulario_docente").click(function(){
                    limpiar_formulario();
                });
                function guardar_nivel(){
                    $.post("'. $this->baseurl . INDEX . 'niveles/save", {
                        nivel: $("#nivel").val()
                    }, function(response){
                        var obj = JSON.parse(response);
                        if(obj.Result == "OK"){
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            alertify.notify("<strong>Categoría</strong> agregada correctamente.", "custom-black", 3, function() {});
                        }else{
                            alertify.notify("<strong>Algo ha salido terriblemente mal</strong>.", "custom-black", 3, function() {});
                        }
                    });
                }
                function actualizar_categoria(id){
                    $.post("'. $this->baseurl . INDEX . 'niveles/editarBD", {
                        id: id,
                        nivel: $("#nivel").val()
                    }, function(response){
                        var obj = JSON.parse(response);
                        if(obj.Result == "OK"){
                            limpiar_formulario();
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            alertify.notify("<strong>Categoria</strong> modificada correctamente.", "custom-black", 3, function() {});
                        }else{
                            alertify.notify("<strong>Algo ha salido terriblemente mal</strong>.", "custom-black", 3, function() {});
                        }
                    });
                }
            </script>';     
            return $r;
        }
    }
?>
