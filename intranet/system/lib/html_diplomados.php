<?php
    ini_set('upload_max_filesize', '1024M');
    ini_set('post_max_size', '1024M');
    ini_set('max_input_time', 3600);
    ini_set('max_execution_time', 3600);
class html_diplomados extends f{
	private $baseurl = "";

	function html_diplomados(){
		$this->load()->lib_html("Table", false);
		$this->baseurl = BASEURL;
	}
    function container(){
    
    $r='<style>
        td{
            vertical-align: middle !important;
        }
        .select2-container{
            width: 100% !important;
        }
        div.loading, .loading {
            background-color: #FFFFFF;
            background-image: url("system/lib/ajax-loader(1).gif");
            background-position: center center;
            background-repeat: no-repeat;
            width: 100%;
            height: 150px;
            z-index: 1400;
        }
        div.loading * {
            visibility: hidden;
        }
        .padre{
            max-width: 150px;
            white-space: break-spaces;
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="w-100 text-right">
                <span style="margin-bottom: 10px;" class="btn btn-sm btn-success" data-toggle="modal" data-target="#formulario" id="btn_nuevo" onclick="nuevo_diplomado();">Nuevo Diplomado</span>
            </div>
            <div class="col-md-12">
                <hr>
                <h5 class=""><i class="fa fa-bars" aria-hidden="true"></i> Lista de Diplomados</h5>
                <small><i class="far fa-edit"></i> Aquí podrá ver toda la información de todos los Diplomados</small>
                <hr>
                <div class="container" style="max-width: 100%;">
                    
                    <hr>
                    <div class="row mt-3">
                        <div class="col-12" >
                            <table  class="datatable table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th></th>
                                        <th>Título</th>
                                        <th>Desc.</th>
                                        <th>Area</th>
                                        <th>Modalidad</th>
                                        <th>Destacar</th>
                                        <th>Detalles</th>
                                        <th></th>
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
    <div class="modal fade" id="formulario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 80%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">Registrar Diplomado</h3>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group" style="width: 100%;">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <label>Título</label>
                                    <input id="titulo" class="form-control" name="titulo" type="text"/>
                                </div>
                            </div>
                            <div id="editor" class="mt-2">
                                <label>Descripción</label>
                                <textarea name="editor1" id="editor1" rows="10" cols="80">
                                </textarea>
                            </div>
                            <script>
                                CKEDITOR.replace( "editor1" );
                            </script>
                            <div class="form-row mt-2">
                                <div class="col-md-6">
                                    <label>Area</label><br>
                                    <select class="form-control" id="id_area" name="id_area"></select>
                                </div>
                                <div class="col-md-6">
                                    <label>Modalidad</label><br>
                                    <select class="form-control" id="id_modalidad" name="id_modalidad"></select>
                                </div>
                            </div>
                            <div class="form-row mt-2">
                                <div class="col-md-12">
                                    <label>Imagen</label>
                                    <input type="file" class="form-control" name="imagen" id="imagen">
                                </div>
                                <img src="" id="profile-img-tag" width="200px" style="margin-left: auto; margin-right: auto; margin-top: 1rem;" />
                            </div>
                            <div class="col-md-12 mt-3">
                                <progress id="progressBar" class="mt-2" value="0" max="100" style="width:100%;"></progress>
                                <p id="status"></p>
                                <p id="loaded_n_total"></p>
                            </div>
                            <div class="grid"></div>
                            <div class="form-row">
                                <button type="submit" class="btn btn-success pull-right" id="btn_finalizar">Guardar</button>
                                <span class="btn btn-danger" type="button" data-dismiss="modal" id="cerrar_formulario_docente" style="margin-left: 10px">
                                    Cancelar
                                </span>
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="los_detalles" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel_2" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 80%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel_2">Detalles del Diplomado</h3>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group" style="width: 100%;">
                        <div class="form-row">
                            <div class="col-md-6">
                                <label style="font-weight: bold;" for="">Dirigido a</label>
                                <textarea name="dirigido_a" id="dirigido_a" rows="10" cols="80">
                                </textarea>
                                <script>
                                    CKEDITOR.replace( "dirigido_a" );
                                </script>
                            </div>
                            <div class="col-md-6">
                                <label style="font-weight: bold;" for="">Metodologia</label>
                                <textarea name="metodologia" id="metodologia" rows="10" cols="80">
                                </textarea>
                                <script>
                                    CKEDITOR.replace( "metodologia" );
                                </script>
                            </div>
                        </div>
                        <hr>
                        <div class="form-row">
                            <div class="col-md-6">
                                <label style="font-weight: bold;" for="">Certificacion</label>
                                <textarea name="certificacion" id="certificacion" rows="10" cols="80">
                                </textarea>
                                <script>
                                    CKEDITOR.replace( "certificacion" );
                                </script>
                            </div>
                            <div class="col-md-6">
                                <label style="font-weight: bold;" for="">Ventajas</label>
                                <textarea name="ventajas" id="ventajas" rows="10" cols="80">
                                </textarea>
                                <script>
                                    CKEDITOR.replace( "ventajas" );
                                </script>
                            </div>
                        </div>
                        <hr>
                        <div class="form-row">
                            <div class="col-md-6">
                                <label style="font-weight: bold;" for="">Plan de Estudios</label>
                                <textarea name="plan_estudios" id="plan_estudios" rows="10" cols="80">
                                </textarea>
                                <script>
                                    CKEDITOR.replace( "plan_estudios" );
                                </script>
                            </div>
                            <div class="col-md-6">
                                <label style="font-weight: bold;" for="">Competencias</label>
                                <textarea name="competencias" id="competencias" rows="10" cols="80">
                                </textarea>
                                <script>
                                    CKEDITOR.replace( "competencias" );
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <span class="btn btn-danger" type="button" data-dismiss="modal" id="cerrar_formulario_detalles" style="margin-left: 10px">
                        Cancelar
                    </span>
                    <button class="btn btn-success pull-right" id="btn_finalizar_detalles">Guardar Info</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/jquery.datetimepicker.full.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/build/jquery.datetimepicker.min.css" rel="stylesheet"/>
    <script>
        function _(el){
            return document.getElementById(el);
        }
        function uploadFile(){
            var file = _("imagen").files[0];
            var formdata = new FormData();
            formdata.append("imagen", file);
            formdata.append("id_curso", $("#id_curso").val());
            formdata.append("id_tema", $("#id_tema").val());
            formdata.append("tarea", $("#tarea").val());
            formdata.append("fecha_entrega", $("#fecha_entrega").val());
            formdata.append("parAccion", "guardar_tarea");
            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandler, false);
            ajax.addEventListener("load", completeHandler, false);
            ajax.addEventListener("error", errorHandler, false);
            ajax.addEventListener("abort", abortHandler, false);
            ajax.open("POST", "../php/tarea.php");
            ajax.send(formdata);
        }
        function progressHandler(event){
            _("loaded_n_total").innerHTML = "Uploaded "+event.loaded+" bytes of "+event.total;
            var percent = (event.loaded / event.total) * 100;
            _("progressBar").value = Math.round(percent);
        }
        function completeHandler(event){
            table = $(".datatable").DataTable();
            table.ajax.reload();
            limpiar_formulario();
            _("progressBar").value = 0;
            $("#cerrar_formulario_docente").click();
        }
        function errorHandler(event){
            _("status").innerHTML = "Upload Failed";
        }
        function abortHandler(event){
            _("status").innerHTML = "Upload Aborted";
        }
    </script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $("#profile-img-tag").attr("src", e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imagen").change(function(){
            readURL(this);
        });
        function fill_areas(){
            $.post("' . $this->baseurl . INDEX . 'areas/loadareas/", function(response){
                var obj = JSON.parse(response);
                $.each(obj, function(index, val){
                    $("#id_area").append(`<option value="`+val.id+`">`+val.area+`</option>`);
                });
            });
        }
        function fill_modalidades(){
            $.post("' . $this->baseurl . INDEX . 'modalidades/loadmodalidades/", function(response){
                var obj = JSON.parse(response);
                $.each(obj, function(index, val){
                    $("#id_modalidad").append(`<option value="`+val.id+`">`+val.modalidad+`</option>`);
                });
            });
        }
        $(document).ready(function() {
            $(".datepicker").datetimepicker({
                format: "Y-m-d",
                timepicker:false
            });
            $.datetimepicker.setLocale("es");
            $(".js-example-basic-single").select2();
            fill_areas();
            fill_modalidades();
            var table = $(".datatable").DataTable({
                "ajax": {
                    url: "' . $this->baseurl . INDEX . 'diplomados/loaddiplomados/",
                    "dataSrc": ""
                },
                "columns": [{
                    "data": "id"
                }, {
                    "data": "imagen",
                    "render": function (data) {
                        return "<a href=\"../includes/img/"+data+"\" target=\"_blank\"><img src=\"../includes/img/"+data+"\" style=\"width: 100px;\"></a>";
                    }
                }, {
                    "data": "titulo"
                }, {
                    "data": "descripcion",
                    "render": function (data) {
                        return `<div class="padre" style="width: 150px;">${data.substring(0, 150)}...</div>`;
                    }
                }, {
                    "data": "area"
                }, {
                    "data": "modalidad"
                },  {
                    "data": "estado",
                    "render": function(data){
                        if(data == 1){
                            return "<button id=\"btn_rem\" class=\"btn-danger btn-sm\" ><i class=\"fas fa-times\"></i></button>"
                        }else{
                            return "<button id=\"btn_add\" class=\"btn-success btn-sm\" ><i class=\"fas fa-check\"></i></button>"
                        }
                    },
                }, {
                    "defaultContent": `<span data-toggle="modal" data-target="#los_detalles" class="btn-sm btn-info" id="span_detalles"><i class="fa fa-search-plus"></i></span>`
                }, {
                    "defaultContent": "<button id=\"btn_editar\" data-toggle=\"modal\" data-target=\"#formulario\" class=\"btn-warning btn-sm\" ><i class=\"fas fa-pencil-alt\"></i></button>"
                }, {
                    "defaultContent": "<button id=\"btn_eliminar\" class=\"btn-danger btn-sm\"><i class=\"far fa-trash-alt\"></i></button>"
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
                    alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el Curso <strong>" + rowData["titulo"] + "</strong>?",
                    function() {
                        eliminar(rowData["id"]);
                        alertify.notify("Se elimino el Curso <strong>" + rowData["titulo"] + "</strong> correctamente.", "custom-black", 4, function() {});
                    },
                    function() {
                        alertify.notify("Se cancelo la <strong>eliminación</strong>.", "custom-black", 4, function() {});
                    }).set("labels", { ok: "Eliminar", cancel: "Cancelar" });
                } else {
                    alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el Curso <strong>" + data["titulo"] + "</strong>?",
                    function() {
                        eliminar(data["id"]);
                        alertify.notify("Se elimino el Curso <strong>" + data["titulo"] + "</strong> correctamente.", "custom-black", 4, function() {});
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
            $(".datatable tbody").on("click", "#span_detalles", function() {
                var data = table.row($(this).parents("tr")).data();
                if (data == undefined) {
                    var selected_row = $(this).parents("tr");
                    if (selected_row.hasClass("child")) {
                        selected_row = selected_row.prev();
                    }
                    var rowData = $(".datatable").DataTable().row(selected_row).data();
                    ver_detalles(rowData["id"]);
                } else {
                    ver_detalles(data["id"]);
                }
            });
            //abrir_modal("modaldiplomados", "<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Modificar diplomados");
        });
        function add(id){
            $.post("' . $this->baseurl . INDEX . 'diplomados/add_index", {
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
            $.post("' . $this->baseurl . INDEX . 'diplomados/rem_index", {
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
        function ver_detalles(id){
            $.post("' . $this->baseurl . INDEX . 'diplomados/ver_detalles", {
                id: id
            }, function(response){
                var obj = JSON.parse(response);
                
                CKEDITOR.instances.dirigido_a.setData(obj.dirigido_a);
                CKEDITOR.instances.metodologia.setData(obj.metodologia);
                CKEDITOR.instances.certificacion.setData(obj.certificacion);
                CKEDITOR.instances.ventajas.setData(obj.ventajas);
                CKEDITOR.instances.plan_estudios.setData(obj.plan_estudios);
                CKEDITOR.instances.competencias.setData(obj.competencias);

                $("#btn_finalizar_detalles").attr("onclick", "guardar_detalles("+id+");");
            });
        }
        function guardar_detalles(id){
            var dirigido_a = CKEDITOR.instances.dirigido_a.getData();
            var metodologia = CKEDITOR.instances.metodologia.getData();
            var certificacion = CKEDITOR.instances.certificacion.getData();
            var ventajas = CKEDITOR.instances.ventajas.getData();
            var plan_estudios = CKEDITOR.instances.plan_estudios.getData();
            var competencias = CKEDITOR.instances.competencias.getData();

            $.post("' . $this->baseurl . INDEX . 'diplomados/guardar_detalles", {
                id: id,
                dirigido_a: dirigido_a,
                metodologia: metodologia,
                certificacion: certificacion,
                ventajas: ventajas,
                plan_estudios: plan_estudios,
                competencias: competencias,
            }, function(response){
                var obj = JSON.parse(response);
                
                if(obj.Result == "OK"){
                    alert("Guardado Correctamente");
                    $("#cerrar_formulario_detalles").click();
                }else{
                    alert("Error");
                }
            });
        }
        function eliminar(id) {
            $.ajax({
                url: "' . $this->baseurl . INDEX . 'diplomados/eliminar",
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
        function nuevo_diplomado(){
            $("#exampleModalLabel").text("Nuevo Diplomado");
            $("#profile-img-tag").attr("src", "");
            $("#btn_finalizar").text("Guardar");
            $("#btn_finalizar").attr("onclick", "registrar_diplomado();");
            limpiar_formulario();
        }
        function limpiar_formulario(){
            $("#titulo").val("");
            $("#imagen").val("");
            CKEDITOR.instances.editor1.setData("");

            $("#btn_finalizar").text("Guardar");
        }
        function editar(id){
            $.post("' . $this->baseurl . INDEX . 'diplomados/editar", {
                id_curso: id
            }, function(response){
                var obj = JSON.parse(response);
                
                $("#titulo").val(obj.titulo);
                
                CKEDITOR.instances.editor1.setData(obj.descripcion);
                $("#profile-img-tag").attr("src", "../includes/img/" + obj.imagen);
                
                $("#id_area option[value="+obj.id_area+"]").prop("selected", true);
                $("#id_modalidad option[value="+obj.id_modalidad+"]").prop("selected", true);

                $("#btn_finalizar").text("Actualizar");
                $("#btn_finalizar").attr("onclick", "actualizar_diplomado("+obj.id+");");
            });
        }
            
        function registrar_diplomado(){
            var data = CKEDITOR.instances.editor1.getData();
            var file = _("imagen").files[0];
            var formdata = new FormData();
            formdata.append("imagen", file);

            formdata.append("titulo", $("#titulo").val());
            formdata.append("id_area", $("#id_area").val());
            formdata.append("id_modalidad", $("#id_modalidad").val());
            formdata.append("descripcion", data);

            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandler, false);
            ajax.addEventListener("load", completeHandler, false);
            ajax.addEventListener("error", errorHandler, false);
            ajax.addEventListener("abort", abortHandler, false);
            ajax.open("POST", "'.$this->baseurl . INDEX . 'diplomados/save");
            ajax.send(formdata);
        }
        function actualizar_diplomado(id){
            var data = CKEDITOR.instances.editor1.getData();
            var file = _("imagen").files[0];
            var formdata = new FormData();
            formdata.append("imagen", file);

            formdata.append("titulo", $("#titulo").val());
            formdata.append("id_area", $("#id_area").val());
            formdata.append("id_modalidad", $("#id_modalidad").val());
            formdata.append("descripcion", data);

            /*formdata.append("red_social", $("#red_social").val());
            formdata.append("enlace", $("#enlace").val());*/

            formdata.append("id", id);
            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandler, false);
            ajax.addEventListener("load", completeHandler, false);
            ajax.addEventListener("error", errorHandler, false);
            ajax.addEventListener("abort", abortHandler, false);
            ajax.open("POST", "'.$this->baseurl . INDEX . 'diplomados/editarBD");
            ajax.send(formdata);
        }
        </script>
        ';     
        return $r;
    }
}
?>
