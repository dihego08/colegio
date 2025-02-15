<?php
class html_temas extends f{
    private $baseurl = "";

    function html_temas(){
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
		        .select2-container{
		            width: 100% !important;
		        }
            </style>
            <div class="container-fluid" >
                <div class="row">
                    <div class="col-12 col-md-3">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Nuevo Tema
                        </h5>
                        <small>
                            <i class="fa fa-edit"></i> Aquí podrá Agregar y Modificar la información de los Temas
                        </small>
                        <hr>
                        <div class="form-row">
                            <div class="col-md-12">
                                <label class="bold">Ciclo Academico</label><br>
                                <select class="form-control" id="id_ciclo">
                                    <option value="-1">--SELECCIONA--</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="bold">Grupo</label><br>
                                <select class="form-control" id="id_grupo">
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label>Curso</label>
                                <select class="form-control" id="id_curso" name="id_curso"></select>
                            </div>
                            <div class="col-md-12">
                                <label>Tema</label>
                                <textarea type="text" class="form-control" id="tema" name="tema" style="resize: none;"></textarea>
                            </div>
                            <div class="col-md-12 mt-3">
                                <span class="btn btn-success" style="width: 100%;" id="btn_funcion">Guardar</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-9">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Lista de Temas
                        </h5>
                        <small>
                            <i class="fa fa-edit"></i> Aquí podrá ver toda la información de todos los Temas
                        </small>
                        <hr>         
                        <div class="container">
                            <div class="row">
                                <div class="table-responsive" >
                                    <table  class="datatable table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Tema</th>
                                                <th>Curso</th>
                                                <th>Grupo</th>
                                                <th></th>
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
                function llenar_ciclos(){
                    $.post("' . $this->baseurl . INDEX . 'ciclos/loadciclos/", function(data){
                        var obj = JSON.parse(data);
        
                        $.each(obj, function(index, val){
                            $("#id_ciclo").append(`<option value="${val.id}">${val.ciclo}</option>`);
                        });
                    });
                }
                function llenar_grupos(id_ciclo, id_grupo){
                    $.post("' . $this->baseurl . INDEX . 'grupos/loadgrupos/", {
                        id_ciclo: id_ciclo
                    }, function(data){
                        var obj = JSON.parse(data);
        
                        $("#id_grupo").empty();
                        $("#id_grupo").append(`<option value="-1">--SELECCIONA--</option>`);
                        $.each(obj, function(index, val){
                            if(val.id == id_grupo){
                                $("#id_grupo").append(`<option value="${val.id}" selected>${val.grupo}</option>`);
                            }else{
                                $("#id_grupo").append(`<option value="${val.id}">${val.grupo}</option>`);
                            }
                        });
                    });
                }
                function llenar_cursos(id_grupo, id_curso){
                    $.post("' . $this->baseurl . INDEX . 'cursos/loadcursos/", {
                        id_grupo: id_grupo
                    }, function(response){
                        var obj = JSON.parse(response);

                        $("#id_curso").empty();
                        $("#id_curso").append(`<option value="-1">--SELECCIONA--</option>`);
                        $.each(obj, function(index, val){
                            if(val.id == id_curso){
                                $("#id_curso").append(`<option value="${val.id}" selected>${val.curso}</option>`);
                            }else{
                                $("#id_curso").append(`<option value="${val.id}">${val.curso}</option>`);
                            }
                        });
                    });
                }
                $(document).ready(function() {
                	$(".js-example-basic-single").select2();
                    
                    llenar_ciclos();

                    $("#id_ciclo").on("change", function(){
                        if($(this).val() == "-1" || $(this).val() == -1){
                        }else{
                            llenar_grupos($(this).val(), 0);
                        }
                    });

                    $("#id_grupo").on("change", function(){
                        if($(this).val() == "-1" || $(this).val() == -1){
                        }else{
                            llenar_cursos($(this).val(), 0);
                        }
                    });

                    $("#btn_funcion").attr("onclick", "guardar_tema();");

                    var table = $(".datatable").DataTable({
                        "ajax": {
                            url: "' . $this->baseurl . INDEX . 'temas/loadtemas/",
                            "dataSrc": ""
                        },
                        "columns": [{
                            "data": "id"
                        },  {
                            "data": "tema",
                            "render": function(data){
                                return `<span style="width: 150px; display: block; white-space: break-spaces;">${data}</span>`
                            }
                        },  {
                            "data": "curso"
                        },  {
                            "data": "grupo",
                        },  {
                            "defaultContent": "<button id=\"btn_editar\" data-toggle=\"modal\" style=\"display: block;\" data-target=\"#formulario\" class=\"btn btn-warning btn-sm\" ><i class=\"fa fa-pencil\"></i></button> <button id=\"btn_eliminar\" class=\"btn btn-danger btn-sm mt-1\"><i class=\"fa fa-trash\" style=\"display: block;\"></i></button>"
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
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el Tema <strong>" + rowData["tema"] + "</strong>?",
                            function() {
                                eliminar(rowData["id"]);
                                alertify.notify("Se elimino el Tema <strong>" + rowData["tema"] + "</strong> correctamente.", "custom-black", 4, function() {});
                            },
                            function() {
                                alertify.notify("Se cancelo la <strong>eliminación</strong>.", "custom-black", 4, function() {});
                            }).set("labels", { ok: "Eliminar", cancel: "Cancelar" });
                        } else {
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el Tema <strong>" + data["tema"] + "</strong>?",
                            function() {
                                eliminar(data["id"]);
                                alertify.notify("Se elimino el Tema <strong>" + data["tema"] + "</strong> correctamente.", "custom-black", 4, function() {});
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
                function eliminar(id) {
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'temas/eliminar",
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
                    $("#tema").val("");
                    $("#descripcion").val("");
                    $("#tipo").val("");
                    
                    $("#btn_funcion").attr("onclick", "guardar_tema();");
                    $("#btn_funcion").text("Guardar");
                }
                function editar(id){
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'temas/editar",
                        type: "POST",
                        dataType: "json",
                        data: {
                            "id": id,
                        },
                        success: function(data) {
                            $("#id_ciclo").val(data.id_ciclo);
                            llenar_grupos(data.id_ciclo, data.id_grupo);
                            llenar_cursos(data.id_grupo, data.id_curso);
                            $("#tema").val(data.tema);

                            $("#descripcion").val(data.descripcion);
                            $("#tipo").val(data.tipo);
                            $("#id_profesor option[value="+data.id_profesor+"]").prop("selected", true);

                            $("#btn_funcion").text("Actualizar");
                            $("#btn_funcion").attr("onclick", "actualizar_categoria("+id+");");
                        }
                    });
                }
                $("#cerrar_formulario_docente").click(function(){
                    limpiar_formulario();
                });
                function guardar_tema(){
                    $.post("'. $this->baseurl . INDEX . 'temas/save", {
                        id_curso: $("#id_curso").val(),
                        tema: $("#tema").val(),
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
                    $.post("'. $this->baseurl . INDEX . 'temas/editarBD", {
                        id: id,
                        id_curso: $("#id_curso").val(),
                        tema: $("#tema").val(),
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
