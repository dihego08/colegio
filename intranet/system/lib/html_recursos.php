<?php
class html_recursos extends f{
    private $baseurl = "";

    function html_recursos(){
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
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Nuevo Recurso
                        </h5>
                        <small>
                            <i class="far fa-edit"></i> Aquí podrá Agregar y Modificar la información de los Recursos
                        </small>
                        <hr>
                        <div class="form-row">
                            <form action="' . $this->baseurl . INDEX . 'recursos/save/" name="demoFiler" id="demoFiler" enctype="multipart/form-data" method="POST">
                                <div class="col-md-12">
                                    <label>Curso</label>
                                    <select class="js-example-basic-single form-control" id="id_curso" name="id_curso">
                                        <option value="0">SELECCIONA...</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label>Clase</label>
                                    <select class="js-example-basic-single form-control" id="id_clase" name="id_clase">
                                        <option value="0">SELECCIONA...</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label>Recursos</label>
                                    <input type="file" name="file1[]" multiple="multiple" id="file1" class="form-control">
                                </div>
                                <div class="col-md-12 mt-3">
                                    <input type="submit" value="Guardar" class="btn btn-success" style="width: 100%;">
                                    <progress id="progressBar" class="mt-2" value="0" max="100" style="width:100%;"></progress>
                                    <p id="status"></p>
                                    <p id="loaded_n_total"></p>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-12 col-md-8">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Lista de Recursos
                        </h5>
                        <small>
                            <i class="far fa-edit"></i> Aquí podrá ver toda la información de todos los Recursos
                        </small>
                        <hr>         
                        <div class="container">
                            <div class="row">
                                <div class="col-12" >
                                    <table  class="datatable table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Recurso</th>
                                                <th>Clase</th>
                                                <th>Curso</th>
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
                    $("#demoFiler").on("submit", function(e) {
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
                                var obj = JSON.parse(data);
                                if(obj.Result == "OK"){
                                    f[0].reset();
                                    //$("#form_agregar input[name=fecha]").focus();
                                    table = $(".datatable").DataTable();
                                    table.ajax.reload();
                                    alertify.notify("<strong>Agregado</strong> correctamente.", "custom-black", 4, function() {})
                                }else{
                                    alertify.notify("Algo ha Salido Mal <strong></strong>.", "custom-black", 4, function() {})
                                    f[0].reset();
                                }
                            },
                            error: function() {},
                        });
                    });
                    
                    $(".js-example-basic-single").select2();

                    load_cursos();

                    $("#id_curso").on("change", function(){
                        load_clases($("#id_curso").val());
                    });

                    $("#btn_funcion").attr("onclick", "guardar_categoria();");

                    var table = $(".datatable").DataTable({
                        "ajax": {
                            url: "' . $this->baseurl . INDEX . 'recursos/loadrecursos/",
                            "dataSrc": ""
                        },
                        "columns": [{
                            "data": "id"
                        },  {
                            "data": "recurso",
                            "render": function(data){
                                return "<a href=\"https://adiasis.com/cursos_online/system/controllers/uploads/"+data+"\" target=\"blank\">"+data+"</a>"
                            }
                        },  {
                            "data": "clase"
                        },  {
                            "data": "curso"
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
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el Recurso <strong>" + rowData["recurso"] + "</strong>?",
                            function() {
                                eliminar(rowData["id"]);
                                alertify.notify("Se elimino el Recurso <strong>" + rowData["recurso"] + "</strong> correctamente.", "custom-black", 4, function() {});
                            },
                            function() {
                                alertify.notify("Se cancelo la <strong>eliminación</strong>.", "custom-black", 4, function() {});
                            }).set("labels", { ok: "Eliminar", cancel: "Cancelar" });
                        } else {
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el Recurso <strong>" + data["recurso"] + "</strong>?",
                            function() {
                                eliminar(data["id"]);
                                alertify.notify("Se elimino el Recurso <strong>" + data["recurso"] + "</strong> correctamente.", "custom-black", 4, function() {});
                            },
                            function() {
                                alertify.notify("Se cancelo la <strong>eliminación</strong>.", "custom-black", 4, function() {});
                            }).set("labels", { ok: "Eliminar", cancel: "Cancelar" });
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
                function load_clases(id_curso){
                    $.post("' . $this->baseurl . INDEX . 'clases/get_clases", {
                        id_curso: id_curso
                    }, function(response){
                        var obj = JSON.parse(response);
                        $.each(obj.Records, function(index, val){
                            $("#id_clase").append("<option value=" + val.id + ">" + val.titulo + "</option>");
                        });
                    });
                }
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
                        url: "' . $this->baseurl . INDEX . 'recursos/eliminar",
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
                    $("#categoria").val("");
                    
                    $("#btn_funcion").attr("onclick", "guardar_categoria();");
                    $("#btn_funcion").text("Guardar");
                }
                function editar(id){
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'categorias/editar",
                        type: "POST",
                        dataType: "json",
                        data: {
                            "id_categoria": id,
                        },
                        success: function(data) {
                            $("#categoria").val(data.categoria);

                            $("#btn_funcion").text("Actualizar");
                            $("#btn_funcion").attr("onclick", "actualizar_categoria("+id+");");
                        }
                    });
                }
                $("#cerrar_formulario_docente").click(function(){
                    limpiar_formulario();
                });
                function guardar_categoria(){
                    $.post("'. $this->baseurl . INDEX . 'categorias/save", {
                        categoria: $("#categoria").val()
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
                    $.post("'. $this->baseurl . INDEX . 'categorias/editarBD", {
                        id: id,
                        categoria: $("#categoria").val()
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
