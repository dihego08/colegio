<?php
class html_profesores extends f
{
    private $baseurl = "";

    function html_profesores()
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
            <style>
                td{
                    vertical-align: middle !important;
                }
            </style>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <span style="float: right; margin-bottom: 10px;" class="btn btn-sm btn-success" data-toggle="modal" data-target="#formulario" id="btn_nuevo" onclick="nuevo_docente();">Nuevo Docente</span>
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Lista de Docentes
                        </h5>
                        <small>
                            <i class="far fa-edit"></i> Aquí podrá ver toda la información de todos los Docentes
                        </small>
                        <hr>         
                        <div class="container" style="max-width: 100%;">
                            <div class="row">
                                <div class="table-responsive" >
                                    <table  class="datatable table dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Mostrar</th>
                                                <th></th>
                                                <th>Nombres</th>
                                                <th>Red Social</th>
                                                <th>Profesión</th>
                                                <th>Nacionalidad</th>
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
            <!----------------------------------------------------------------------->
            <div class="modal fade" id="formulario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="max-width: 80%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLabel">Nuevo Docente</h3>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group" style="width: 100%;">
                                <!--<form id="form_nuevo" action="' . $this->baseurl . INDEX . 'profesores/save"  method="post">-->
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <label>Nombres</label>
                                            <input id="nombres" class="form-control" name="nombres" type="text"/>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Red Social</label>
                                            <input id="red_social" class="form-control" name="red_social" type="text"/>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <label>Profesión</label>
                                            <input id="profesion" class="form-control" name="profesion" type="text"/>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <label>Correo</label>
                                            <input id="correo" class="form-control" name="correo" type="text"/>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Usuario</label>
                                            <input id="usuario" class="form-control" name="usuario" type="text"/>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Contraseña</label>
                                            <input id="pass" class="form-control" name="pass" type="password"/>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <label>Nacionalidad</label>
                                            <select class="form-control" id="nacionalidad">
                                                <option value="CHILE">Chile 🇨🇱</option>
                                                <option value="PERU">Perú 🇵🇪</option>
                                                <option value="COLOMBIA">Colombia 🇨🇴</option>
                                                <option value="ESPAÑA">España 🇪🇸</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <label>Presentación</label>
                                            <input id="presentacion" class="form-control" name="presentacion" type="text"/>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <label>Trayectoria</label>
                                        <textarea name="editor1" id="editor1" rows="10" cols="80">
                                        </textarea>
                                        <script>
                                            CKEDITOR.replace( "editor1" );
                                        </script>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <label class="w-100">Foto</label>
                                            <label for="foto" style="font-weight: bold;">Seleccionar imagen
                                                <input id="foto" class="form-control" name="foto" type="file" style="display: none;"/>
                                            </label>
                                        </div>
                                        <div class="col-md-12" id="alerta_pass" hidden>
                                            <label></label>
                                            <div class="alert alert-success" role="alert">
                                                Al dejar en blanco el campo "<b>Contraseña</b>" se mantendrá la anteriormente registrada.
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-center">
                                            <img class="mt-2" src="" id="profile-img-tag" width="200px" style="margin-left: auto;margin-right: auto;" />
                                        </div>
                                        <div class="col-md-6 text-center">
                                            <img class="mt-2" src="" id="profile-img-tag_2" width="200px" style="margin-left: auto;margin-right: auto;" />
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12" style="margin-top: 15px;">
                                            <button type="submit" class="btn btn-success pull-right" id="btn_finalizar">Guardar</button>
                                            <span class="btn btn-danger" type="button" data-dismiss="modal" id="cerrar_formulario_docente" style="margin-left: 10px">
                                                Cancelar
                                            </span>
                                        </div>
                                    </div>
                                <!--</form>-->
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
                                alertify.notify("Se agrego el <strong>Docente</strong> correctamente.", "custom-black", 4, function() {})
                                limpiar_formulario();
                                $("#cerrar_formulario_docente").click();
                            };
                        },
                        error: function() {},
                    });
                });
                $(document).ready(function() {
                    function readURL(input) {
                        if (input.files && input.files[0]) {
                            var reader = new FileReader();
                            reader.onload = function (e) {
                                $("#profile-img-tag").attr("src", e.target.result);
                            }
                            reader.readAsDataURL(input.files[0]);
                        }
                    }
                    $("#foto").change(function(){
                        readURL(this);
                    });
                    
                    
                    function readURL_(input) {
                        if (input.files && input.files[0]) {
                            var reader = new FileReader();
                            reader.onload = function (e) {
                                $("#profile-img-tag_2").attr("src", e.target.result);
                            }
                            reader.readAsDataURL(input.files[0]);
                        }
                    }
                    $("#foto_2").change(function(){
                        readURL_(this);
                    });
                    
                    
                    
                    
                    $( ".datepicker" ).datepicker();
                    $("#form_agregar input[name=nombre]").focus();
                    $("#form_agregar input[name=nombre]").keyup(function() {
                        var letras = $(this).val().substring(0, 4);
                        var numeros = $(this).val().length;
                        $("#form_agregar input[name=codinterno]").val(letras + numeros + "_fam");
                    });
                    var table = $(".datatable").DataTable({
                        "ajax": {
                            url: "' . $this->baseurl . INDEX . 'profesores/loadprofesores/",
                            "dataSrc": ""
                        },
                        "columns": [{
                            "data": "id"
                        }, {
                            "data": "estado",
                            "render": function(data){
                                if(data == 1){
                                    return "<button id=\"btn_rem\" class=\"btn btn-danger btn-sm\" ><i class=\"fa fa-times\"></i></button>"
                                }else{
                                    return "<button id=\"btn_add\" class=\"btn btn-success btn-sm\" ><i class=\"fa fa-check\"></i></button>"
                                }
                            },
                        }, {
                            "data": "foto",
                                "render": function (data) {
                                    return "<img src=\"system/controllers/uploads/"+data+"\" style=\"width: 50px;\">";
                                }
                        },  {
                            "data": "nombres"
                        }, {
                            "data": "red_social"
                        }, {
                            "data": "profesion"
                        }, {
                            "data": "nacionalidad"
                        }, {
                            "defaultContent": "<button style=\"display: block;\" id=\"btn_editar\" data-toggle=\"modal\" data-target=\"#formulario\" class=\"btn-info btn-sm btn w-100\" ><i class=\"fa fa-pencil\"></i></button> <button style=\"display: block;\" id=\"btn_eliminar\" class=\"btn-danger btn-sm btn w-100 mt-1\"><i class=\"fa fa-trash\"></i></button>"
                        }, ],
                        "language": {
                            "url": "' . $this->baseurl . 'includes/datatables/Spanish.json"
                        },
                        "lengthMenu": [
                            [10, 15, 20, -1],
                            [10, 15, 20, "All"]
                        ], buttons: [
                            "copy", "excel", "pdf"
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
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el Docente <strong>" + rowData["nombres"] + "</strong>?",
                            function() {
                                eliminar(rowData["id"]);
                                alertify.notify("Se elimino el Docente <strong>" + rowData["nombres"] + "</strong> correctamente.", "custom-black", 4, function() {});
                            },
                            function() {
                                alertify.notify("Se cancelo la <strong>eliminación</strong>.", "custom-black", 4, function() {});
                            }).set("labels", { ok: "Eliminar", cancel: "Cancelar" });
                        } else {
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el Docente <strong>" + data["nombres"] + "</strong>?",
                            function() {
                                eliminar(data["id"]);
                                alertify.notify("Se elimino el Docente <strong>" + data["nombres"] + "</strong> correctamente.", "custom-black", 4, function() {});
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
                    $.post("' . $this->baseurl . INDEX . 'profesores/add_index", {
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
                    $.post("' . $this->baseurl . INDEX . 'profesores/rem_index", {
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
                function nuevo_docente(){
                    $("#exampleModalLabel").text("Nuevo Docente");
                    $("#btn_finalizar").text("Guardar");
                    $("#btn_finalizar").attr("onclick", "guardar_profesor();");
                    limpiar_formulario();
                    $("#alerta_pass").attr("hidden", "hidden");
                }
                function guardar_profesor(){
                    
                    var file_data = $("#foto").prop("files")[0];
                    var form_data = new FormData();
                    form_data.append("file1", file_data)
                    form_data.append("nombres", $("#nombres").val());
                    form_data.append("red_social", $("#red_social").val());
                    //form_data.append("correo", $("#correo").val());
                    form_data.append("profesion", $("#profesion").val());
                    form_data.append("nacionalidad", $("#nacionalidad").val());
                    form_data.append("presentacion", $("#presentacion").val());
                    form_data.append("correo", $("#correo").val());
                    form_data.append("usuario", $("#usuario").val());
                    form_data.append("pass", $("#pass").val());
                    var data = CKEDITOR.instances.editor1.getData();
                    form_data.append("sobre_mi", data);
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'profesores/save",
                        dataType: "script",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,                         // Setting the data attribute of ajax with file_data
                        type: "post",
                        success: function(response){
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            alertify.notify("<strong>Profesor</strong> agregado correctamente.", "custom-black", 3, function() {});
                            $("#cerrar_formulario_docente").click();
                        },error: function() {
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            alertify.notify("<strong>Profesor</strong> agregado correctamente.", "custom-black", 3, function() {});
                            $("#cerrar_formulario_docente").click();
                        }
                    });
                }
                function eliminar(id) {
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'profesores/eliminar",
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
                    $("#nombres").val("");
                    $("#red_social").val("");
                    $("#profesion").val("");
                    $("#nacionalidad").val("");
                    $("#presentacion").val("");
                    $("#correo").val("");
                    $("#usuario").val("");
                    $("#pass").val("");
                    $("#editor1").val("");
                    CKEDITOR.instances.editor1.setData("");

                    $("#btn_finalizar").text("Guardar");
                    /*$("#profile-img-tag").attr("src", "");
                        
                    $("#profile-img-tag_2").attr("src", "");*/
                    
                    $("#foto").val("");
                    
                    $("#profile-img-tag").removeAttr("src");
                        
                }
                function editar(id){
                    $.post("' . $this->baseurl . INDEX . 'profesores/editar", {
                        id: id
                    }, function(response){
                        var obj = JSON.parse(response);
                        $("#nombres").val(obj.nombres);
                        $("#red_social").val(obj.red_social);
                        $("#profesion").val(obj.profesion);
                        $("#nacionalidad").val(obj.nacionalidad);
                        $("#presentacion").val(obj.presentacion);
                        $("#correo").val(obj.correo);
                        $("#usuario").val(obj.usuario);
                        
                        CKEDITOR.instances.editor1.setData(obj.sobre_mi);
                        
                        $("#profile-img-tag").attr("src", "system/controllers/uploads/" + obj.foto);
                        

                        $("#btn_finalizar").text("Actualizar");

                        $("#btn_finalizar").attr("onclick", "actualizar_docente("+obj.id+");");
                        $("#exampleModalLabel").text("Editar Docente");
                        $("#alerta_pass").removeAttr("hidden");
                    });
                }
                $("#cerrar_formulario_docente").click(function(){
                    limpiar_formulario();
                });
                function actualizar_docente(id){
                    var file_data = $("#foto").prop("files")[0];
                    var form_data = new FormData();
                    form_data.append("file1", file_data)
                    form_data.append("nombres", $("#nombres").val());
                    form_data.append("red_social", $("#red_social").val());
                    form_data.append("profesion", $("#profesion").val());
                    form_data.append("nacionalidad", $("#nacionalidad").val());
                    form_data.append("presentacion", $("#presentacion").val());
                    form_data.append("correo", $("#correo").val());
                    form_data.append("usuario", $("#usuario").val());
                    form_data.append("pass", $("#pass").val());
                    var data = CKEDITOR.instances.editor1.getData();
                    form_data.append("sobre_mi", data);
                    form_data.append("id", id);
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'profesores/editarBD",
                        dataType: "script",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,
                        type: "post",
                        success: function(response){
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            alertify.notify("<strong>Profesor</strong> modificado correctamente.", "custom-black", 3, function() {});
                            $("#cerrar_formulario_docente").click();
                        },error: function() {
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            alertify.notify("<strong>Profesor</strong> modificado correctamente.", "custom-black", 3, function() {});
                            $("#cerrar_formulario_docente").click();
                        }
                    });
                }
            </script>';
        return $r;
    }
}
