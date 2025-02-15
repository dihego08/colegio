<?php
class html_clases extends f
{
    private $baseurl = "";

    function html_clases()
    {
        $this->load()->lib_html("Table", false);
        $this->baseurl = BASEURL;
    }
    function container()
    {
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
                            <i class="fa fa-bars" aria-hidden="true"></i> Nueva Clase
                        </h5>
                        <small>
                            <i class="far fa-edit"></i> Aquí podrá Agregar y Modificar la información de las Clases
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
                                <label>Clase Precedesora</label>
                                <select class="js-example-basic-single form-control" id="id_predecesor" name="id_predecesor">
                                    <option value="0">SELECCIONA...</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label>Clase</label>
                                <textarea class="form-control" id="titulo" name="titulo"></textarea>
                            </div>
                            <div class="col-md-12 mt-3">
                                <span class="btn btn-success" style="width: 100%;" id="btn_funcion">Guardar</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-9">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Lista de Clases
                        </h5>
                        <small>
                            <i class="far fa-edit"></i> Aquí podrá ver toda la información de todos los Clases
                        </small>
                        <hr>         
                        <div class="container">
                            <div class="row">
                                <div class="table-responsive" >
                                    <table  class="datatable table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Curso</th>
                                                <th>Clase</th>
                                                <th>Predecesor</th>
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
                    $(".js-example-basic-single").select2();
                    load_cursos();
                    
                    $("#id_curso").on("change", function(){
                        load_clases($("#id_curso").val());
                    });
                    $("#btn_funcion").attr("onclick", "guardar_clase();");

                    var table = $(".datatable").DataTable({
                        "ajax": {
                            url: "' . $this->baseurl . INDEX . 'clases/loadclases/",
                            "dataSrc": ""
                        },
                        "columns": [{
                            "data": "id"
                        },  {
                            "data": "curso"
                        },  {
                            "data": "titulo"
                        },  {
                            "data": "precedesor"
                        }, {
                            "defaultContent": "<button id=\"btn_editar\" data-toggle=\"modal\" data-target=\"#formulario\" class=\"btn btn-info btn-sm\" ><i class=\"fa fa-pencil\"></i></button>"
                        }, {
                            "defaultContent": "<button id=\"btn_eliminar\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-trash\"></i></button>"
                        }, ],
                        "language": {
                            "url": "' . $this->baseurl . 'includes/datatables/Spanish.json"
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
                                alertify.notify("Se elimino la Clase <strong>" + rowData["titulo"] + "</strong> correctamente.", "custom-black", 4, function() {});
                            },
                            function() {
                                alertify.notify("Se cancelo la <strong>eliminación</strong>.", "custom-black", 4, function() {});
                            }).set("labels", { ok: "Eliminar", cancel: "Cancelar" });
                        } else {
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar la Clase <strong>" + data["titulo"] + "</strong>?",
                            function() {
                                eliminar(data["id"]);
                                alertify.notify("Se elimino la Clase <strong>" + data["titulo"] + "</strong> correctamente.", "custom-black", 4, function() {});
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
                function load_clases(id_curso){
                    $("#id_predecesor").empty();
                    $.post("' . $this->baseurl . INDEX . 'clases/clases_by", {
                        id_curso: id_curso
                    }, function(response){
                        var obj = JSON.parse(response);
                        $.each(obj.Records, function(index, val){
                            $("#id_predecesor").append("<option value=" + val.id + ">" + val.titulo + "</option>");
                        });
                    });
                }
                function nuevo_docente(){
                    $("#exampleModalLabel").text("Nuevo Docente");
                    //$("#form_nuevo").attr("action", "' . $this->baseurl . INDEX . 'profesores/save");
                    $("#btn_finalizar").text("Guardar");
                    $("#btn_finalizar").removeAttr("onclick");
                    limpiar_formulario();
                    $("#alerta_pass").attr("hidden", "hidden");
                }
                function eliminar(id) {
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'clases/eliminar",
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
                    
                    $("#btn_funcion").attr("onclick", "guardar_clase();");
                    $("#btn_funcion").text("Guardar");
                }
                function editar(id){
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'clases/editar",
                        type: "POST",
                        dataType: "json",
                        data: {
                            "id_clase": id,
                        },
                        success: function(data) {
                            $("#titulo").val(data.titulo);

                            //$("#id_curso").select2("val", data.id_curso);
                            $("#id_predecesor").select2("val", data.id_predecesor);
                            
                            $("#id_curso").val(data.id_curso);
                            $("#id_curso").select2().trigger(\'change\');
                            
                            $("#btn_funcion").text("Actualizar");
                            $("#btn_funcion").attr("onclick", "actualizar_clase("+id+");");
                        }
                    });
                }
                $("#cerrar_formulario_docente").click(function(){
                    limpiar_formulario();
                });
                function guardar_clase(){
                    $.post("' . $this->baseurl . INDEX . 'clases/save", {
                        id_curso: $("#id_curso").val(),
                        titulo: $("#titulo").val(),
                        id_predecesor: $("#id_predecesor").val()
                    }, function(response){
                        var obj = JSON.parse(response);
                        if(obj.Result == "OK"){
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            alertify.notify("<strong>Clase</strong> agregada correctamente.", "custom-black", 3, function() {});
                            load_clases($("#id_curso").val());
                        }else{
                            alertify.notify("<strong>Algo ha salido terriblemente mal</strong>.", "custom-black", 3, function() {});
                        }
                    });
                }
                function actualizar_clase(id){
                    $.post("' . $this->baseurl . INDEX . 'clases/editarBD", {
                        id: id,
                        id_curso: $("#id_curso").val(),
                        titulo: $("#titulo").val(),
                        id_predecesor: $("#id_predecesor").val()
                    }, function(response){
                        var obj = JSON.parse(response);
                        if(obj.Result == "OK"){
                            limpiar_formulario();
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            alertify.notify("<strong>Clase</strong> modificada correctamente.", "custom-black", 3, function() {});
                        }else{
                            alertify.notify("<strong>Algo ha salido terriblemente mal</strong>.", "custom-black", 3, function() {});
                        }
                    });
                }
            </script>';
        return $r;
    }
}
