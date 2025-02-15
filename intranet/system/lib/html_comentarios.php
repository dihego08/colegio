<?php
class html_comentarios extends f{
    private $baseurl = "";

    function html_comentarios(){
        $this->load()->lib_html("Table", false);
        $this->baseurl = BASEURL;
    }
    function container(){
        $r = '<script>
                function abrir_modal(b,a){alertify.dialog(b,function(){return{main:function(c){this.setContent(c);},setup:function(){return{focus:{element:function(){return this.elements.body.querySelector(this.get("selector"));
                },select:true},options:{basic:false,title:a,maximizable:false,resizable:false,padding:true,modal:true,transition:false,}};},settings:{selector:undefined}};
                });}
            </script>
            <style type="text/css">
                .uploadArea {
                    min-height: 300px;
                    height: auto;
                    border: 1px dotted #ccc;
                    padding: 10px;
                    cursor: move;
                    margin-bottom: 10px;
                    position: relative;
                }
            </style>
            <div class="container-fluid" style="margin-top: 56px;">
                <div class="row">
                    <div class="col-12 col-md-3">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Nuevo Comentario
                        </h5>
                        <small>
                            <i class="far fa-edit"></i> Aquí podrá Agregar nuevos Comentarios
                        </small>
                        <hr>
                        <div class="form-row">
                            <div class="col-md-12">
                                <label>Curso</label>
                                <select class="js-example-basic-single form-control" id="id_curso" name="id_curso">
                                    <option value="0">SELECCIONA...</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label>Usuarios</label>
                                <select class="js-example-basic-single form-control" id="id_usuario" name="id_usuario">
                                    <option value="0">SELECCIONA...</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label>Comentario</label>
                                <textarea class="form-control" id="comentario" name="comentario"></textarea>
                            </div>
                            <div class="col-md-12 mt-3">
                                <span class="btn btn-success" style="width: 100%;" id="btn_funcion">Guardar</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-9">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Lista de Comentarios
                        </h5>
                        <small>
                            <i class="far fa-edit"></i> Aquí podrá ver todos los Comentarios registrados
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
                                                <th>Usuario</th>
                                                <th>Comentario</th>
                                                <th>Mostrar</th>
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
                    $(".js-example-basic-single").select2();
                    load_cursos();
                    load_usuarios();
                    $("#btn_funcion").attr("onclick", "guardar_comentario();");

                    var table = $(".datatable").DataTable({
                        "ajax": {
                            url: "' . $this->baseurl . INDEX . 'comentarios/loadcomentarios/",
                            "dataSrc": ""
                        },
                        "columns": [{
                            "data": "id"
                        },  {
                            "data": "titulo"
                        },  {
                            "data": "nombres"
                        },  {
                            "data": "comentario"
                        }, {
                            "data": "estado",
                            "render": function(data){
                                if(data == 1){
                                    return "<button id=\"btn_rem\" class=\"btn btn-danger btn-sm\" ><i class=\"fas fa-times\"></i></button>"
                                }else{
                                    return "<button id=\"btn_add\" class=\"btn btn-success btn-sm\" ><i class=\"fas fa-check\"></i></button>"
                                }
                            },
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
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar la Clase <strong>" + rowData["titulo"] + "</strong>?",
                            function() {
                                eliminar(rowData["id"]);
                                alertify.notify("Se elimino el comentario <strong></strong> correctamente.", "custom-black", 4, function() {});
                            },
                            function() {
                                alertify.notify("Se cancelo la <strong>eliminación</strong>.", "custom-black", 4, function() {});
                            }).set("labels", { ok: "Eliminar", cancel: "Cancelar" });
                        } else {
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar la Clase <strong>" + data["titulo"] + "</strong>?",
                            function() {
                                eliminar(data["id"]);
                                alertify.notify("Se elimino el comentario correctamente.", "custom-black", 4, function() {});
                            },
                            function() {
                                alertify.notify("Se cancelo la <strong>eliminación</strong>.", "custom-black", 4, function() {});
                            }).set("labels", { ok: "Eliminar", cancel: "Cancelar" });
                        }
                    });
                    $(".datatable tbody").on("click", "#btn_rem", function() {
                        var data = table.row($(this).parents("tr")).data();
                        if (data == undefined) {
                            var selected_row = $(this).parents("tr");
                            if (selected_row.hasClass("child")) {
                                selected_row = selected_row.prev();
                            }
                            var rowData = $(".datatable").DataTable().row(selected_row).data();
                            rem(rowData["id"]);
                        } else {
                            rem(data["id"]);
                        }
                    });
                    $(".datatable tbody").on("click", "#btn_add", function() {
                        var data = table.row($(this).parents("tr")).data();
                        if (data == undefined) {
                            var selected_row = $(this).parents("tr");
                            if (selected_row.hasClass("child")) {
                                selected_row = selected_row.prev();
                            }
                            var rowData = $(".datatable").DataTable().row(selected_row).data();
                            add(rowData["id"]);
                        } else {
                            add(data["id"]);
                        }
                    });
                });
                function add(id){
                    $.post("' . $this->baseurl . INDEX . 'comentarios/add_index", {
                        id: id
                    }, function(response){
                        var obj = JSON.parse(response);
                        if(obj.Result == "OK"){
                            table = $(".datatable").DataTable();
                            table.ajax.reload();    
                        }else{
                            alertify.notify("<strong>Algo ha salido terriblemente mal</strong>.", "custom-black", 3, function() {});
                        }
                    });
                }
                function rem(id){
                    $.post("' . $this->baseurl . INDEX . 'comentarios/rem_index", {
                        id: id
                    }, function(response){
                        var obj = JSON.parse(response);
                        if(obj.Result == "OK"){
                            table = $(".datatable").DataTable();
                            table.ajax.reload();    
                        }else{
                            alertify.notify("<strong>Algo ha salido terriblemente mal</strong>.", "custom-black", 3, function() {});
                        }
                    });
                }
                function load_cursos(){
                    $.get("' . $this->baseurl . INDEX . 'cursos/loadcursos", function(response){
                        var obj = JSON.parse(response);
                        $.each(obj, function(index, val){
                            $("#id_curso").append("<option value=" + val.id + ">" + val.titulo + " - " + val.nivel + "</option>");
                        });
                    });
                }
                function load_usuarios(){
                    $.get("' . $this->baseurl . INDEX . 'alumnos/loadalumnos", function(response){
                        var obj = JSON.parse(response);
                        $.each(obj, function(index, val){
                            $("#id_usuario").append("<option value=" + val.id + ">" + val.apellidos + ", " + val.nombres + "</option>");
                        });
                    });
                }
                function nuevo_docente(){
                    $("#exampleModalLabel").text("Nuevo Comentario");
                    $("#btn_finalizar").text("Guardar");
                    $("#btn_finalizar").removeAttr("onclick");
                    limpiar_formulario();
                    $("#alerta_pass").attr("hidden", "hidden");
                }
                function eliminar(id) {
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'comentarios/eliminar",
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
                    $("#titulo").val("");
                    
                    $("#btn_funcion").attr("onclick", "guardar_comentario();");
                    $("#btn_funcion").text("Guardar");
                }
                $("#cerrar_formulario_docente").click(function(){
                    limpiar_formulario();
                });
                function guardar_comentario(){
                    $.post("'. $this->baseurl . INDEX . 'comentarios/save", {
                        id_curso: $("#id_curso").val(),
                        id_usuario: $("#id_usuario").val(),
                        comentario: $("#comentario").val()
                    }, function(response){
                        var obj = JSON.parse(response);
                        if(obj.Result == "OK"){
                            $("#comentario").val("");
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            alertify.notify("<strong>Comentario</strong> agregado correctamente.", "custom-black", 3, function() {});
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
