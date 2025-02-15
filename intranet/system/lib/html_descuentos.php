<?php
class html_descuentos extends f{
    private $baseurl = "";

    function html_descuentos(){
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
                    <div class="col-12 col-md-3">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Descuento
                        </h5>
                        <small>
                            <i class="far fa-edit"></i> Aquí podrá Agregar y Modificar la información de los Descuentos
                        </small>
                        <hr>
                        <div class="form-row">
                            <div class="col-md-12">
                                <label>Curso</label>
                                <select class="form-control js-example-basic-single" id="id_curso" name="id_curso">
                                    <option value="0">SELECCIONA...</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label>Precio Anterior</label>
                                <input type="text" class="form-control" id="precio_ant" name="precio_ant">
                            </div>
                            <div class="col-md-12">
                                <label>Nuevo Precio</label>
                                <input type="text" class="form-control" id="precio" name="precio">
                            </div>
                            <div class="col-md-12">
                                <label id="percent"></label>
                            </div>
                            <div class="col-md-12 mt-3">
                                <span class="btn btn-success" style="width: 100%;" id="btn_funcion">Guardar</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-9">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Lista de Descuentos 
                        </h5>
                        <small>
                            <i class="far fa-edit"></i> Aquí podrá ver toda la información de todos los Descuentos registrados
                        </small>
                        <hr>         
                        <div class="container">
                            <div class="row">
                                <div class="col-12" >
                                    <table  class="datatable table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Curso</th>
                                                <th>Precio Ant. (S/.)</th>
                                                <th>Precio Ant. ($)</th>
                                                <th>Precio Nue. (S/.)</th>
                                                <th>Precio Nue. ($)</th>
                                                <th>%</th>
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
                function get_datos(id_curso){
                    $.post("' . $this->baseurl . INDEX . 'cursos/editar", {
                        id_curso: id_curso
                    }, function(response){
                        var obj = JSON.parse(response);
                        $("#precio_ant").val(obj.precio);
                    });
                }
                $(document).ready(function() {
                    $(".js-example-basic-single").select2();
                    load_cursos();
                    
                    $("#id_curso").on("change", function(){
                        get_datos($("#id_curso").val());
                    });
                    
                    $("#btn_funcion").attr("onclick", "guardar_descuento();");

                    var table = $(".datatable").DataTable({
                        "ajax": {
                            url: "' . $this->baseurl . INDEX . 'descuentos/loaddescuentos/",
                            "dataSrc": ""
                        },
                        "columns": [{
                            "data": "id"
                        },  {
                            "data": "titulo"
                        },  {
                            "data": "precio_ant"
                        },  {
                            "data": "precio_ant_2"
                        },  {
                            "data": "precio"
                        },{
                            "data": "precio_2"
                        },  {
                            "data": "percent"
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
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar este Descuento?",
                            function() {
                                eliminar(rowData["id"]);
                                alertify.notify("Se eliminó el Descuento correctamente.", "custom-black", 4, function() {});
                            },
                            function() {
                                alertify.notify("Se cancelo la <strong>eliminación</strong>.", "custom-black", 4, function() {});
                            }).set("labels", { ok: "Eliminar", cancel: "Cancelar" });
                        } else {
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar este Descuento?",
                            function() {
                                eliminar(data["id"]);
                                alertify.notify("Se eliminó el Descuento correctamente.", "custom-black", 4, function() {});
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
                function load_cursos(){
                    $.get("' . $this->baseurl . INDEX . 'cursos/loadcursos", function(response){
                        var obj = JSON.parse(response);
                        $.each(obj, function(index, val){
                            $("#id_curso").append("<option value=" + val.id + ">" + val.titulo + " - " + val.nivel + "</option>");
                        });
                    });
                }
                function eliminar(id) {
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'descuentos/eliminar",
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
                    $("#id_curso").select2("val", 0);
                    $("#precio_ant").val("");
                    $("#precio").val("");
                    
                    $("#btn_funcion").attr("onclick", "guardar_descuento();");
                    $("#btn_funcion").text("Guardar");
                }
                function editar(id){
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'descuentos/editar",
                        type: "POST",
                        dataType: "json",
                        data: {
                            "id": id,
                        },
                        success: function(data) {
                            console.log(data.id_curso);
                            $("#precio").val(data.precio);
                            $("#id_curso").val(data.id_curso);
                            $("#id_curso").select2().trigger(\'change\');
                            //$("#id_curso").select2("val", data.id_curso);
                            //$("#id_curso").change();
                            get_datos(data.id_curso)
                            
                        
                            $("#btn_funcion").text("Actualizar");
                            $("#btn_funcion").attr("onclick", "actualizar_descuento("+id+");");
                        }
                    });
                }
                $("#cerrar_formulario_docente").click(function(){
                    limpiar_formulario();
                });
                function guardar_descuento(){
                    $.post("'. $this->baseurl . INDEX . 'descuentos/save", {
                        id_curso: $("#id_curso").val(),
                        precio: $("#precio").val(),
                        precio_ant: $("#precio_ant").val()
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
                function actualizar_descuento(id){
                    $.post("'. $this->baseurl . INDEX . 'descuentos/editarBD", {
                        id: id,
                        id_curso: $("#id_curso").val(),
                        precio: $("#precio").val(),
                        precio_ant: $("#precio_ant").val()
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
