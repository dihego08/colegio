<?php
    ini_set('upload_max_filesize', '1024M');
    ini_set('post_max_size', '1024M');
    ini_set('max_input_time', 3600);
    ini_set('max_execution_time', 3600);
class html_cursos extends f{
	private $baseurl = "";

	function html_cursos(){
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
        .bold{
            font-weight: bold;
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <span style="float: right; margin-bottom: 10px;" class="btn btn-sm btn-success" data-toggle="modal" data-target="#formulario" id="btn_nuevo" onclick="nuevo_curso();">Nuevo Curso</span>
                <h5 class=""><i class="fa fa-bars" aria-hidden="true"></i> Lista de cursos</h5>
                <small><i class="fa fa-edit"></i> Aquí podrá ver toda la información de todos los cursos</small>
                <hr>
                <div class="container" style="max-width: 100%;">
                    <div class="row mt-3">
                        <div class="table-responsive" >
                            <table  class="datatable table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Cod</th>
                                        <th></th>
                                        <th>Curso</th>
                                        <th>Profesor</th>
                                        <th>Ciclo</th>
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
    <div class="modal fade" id="formulario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 80%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">Registrar Bus</h3>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group" style="width: 100%;">
                            <div class="form-row">
                                <div class="col-md-4">
                                    <label class="bold">Curso</label>
                                    <input id="curso" class="form-control" name="curso" type="text"/>
                                </div>
                                <div class="col-md-4">
                                    <label class="bold">Codigo Curso</label>
                                    <input id="codigo" class="form-control" name="codigo" type="text"/>
                                </div>
                                <div class="col-md-4">
                                    <label class="bold">Profesor</label>
                                    <select id="id_profesor" name="id_profesor" class="form-control js-example-basic-single"></select>
                                </div>
                            </div>
                            <div class="form-row mt-2">
                                <div class="col-md-6">
                                    <label class="bold">Ciclo Academico</label><br>
                                    <select class="form-control" id="id_ciclo">
                                        <option value="-1">--SELECCIONA--</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="bold">Grupo</label><br>
                                    <select class="form-control" id="id_grupo">
                                    </select>
                                </div>
                            </div>
                            <div class="form-row mt-2">
                                <div class="col-md-12">
                                    <label class="w-100">Imagen</label>
                                    <label for="portada" style="font-weight: bold;">Seleccionar imagen
                                        <input id="portada" class="form-control" name="portada" type="file" style="display: none;"/>
                                    </label>
                                </div>
                                <img src="" id="profile-img-tag" width="200px" style="margin-left: auto;margin-right: auto;" />
                            </div>
                            <div class="grid"></div>
                            <div class="form-row mt-2 text-right">
                                <span class="btn btn-danger" type="button" data-dismiss="modal" id="cerrar_formulario_docente">
                                    Cancelar
                                </span>
                                <button class="btn btn-success ml-1" id="btn_finalizar">Guardar</button>
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>        
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/jquery.datetimepicker.full.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/build/jquery.datetimepicker.min.css" rel="stylesheet"/>
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
        $("#portada").change(function(){
            readURL(this);
        });
        function eliminar_docente(){
            $("#id_docente").val("");
        }
        function eliminar_docente_2(){
            $("#id_docente_2").val("");
        }
        function fill_docentes(){
            $.post("' . $this->baseurl . INDEX . 'profesores/loadprofesores/", function(response){
                var obj = JSON.parse(response);
                $.each(obj, function(index, val){
                    $("#id_profesor").append(`<option value="`+val.id+`">`+val.nombres+`</option>`);
                });
            });
        }
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
                $.each(obj, function(index, val){
                    if(val.id == id_grupo){
                        $("#id_grupo").append(`<option value="${val.id}" selected>${val.grupo}</option>`);
                    }else{
                        $("#id_grupo").append(`<option value="${val.id}">${val.grupo}</option>`);
                    }
                });
            });
        }

        $(document).ready(function() {

            $("#id_ciclo").on("change", function(){
                if($(this).val() == "-1" || $(this).val() == -1){
                }else{
                    llenar_grupos($(this).val());
                }
            });

            $(".datepicker").datetimepicker({
                format: "Y-m-d",
                timepicker:false
            });
            $.datetimepicker.setLocale("es");
            $(".js-example-basic-single").select2();
            fill_docentes();
            llenar_ciclos();
            var table = $(".datatable").DataTable({
                "ajax": {
                    url: "' . $this->baseurl . INDEX . 'cursos/loadcursos/",
                    "dataSrc": ""
                },
                "columns": [{
                    "data": "id"
                }, {
                    "data": "codigo"
                }, {
                    "data": "portada",
                    "render": function (data) {
                        return "<a href=\"system/controllers/uploads/"+data+"\" target=\"_blank\"><img src=\"system/controllers/uploads/"+data+"\" style=\"width: 75px; max-width: 100px;\"></a>";
                    }
                },{
                    "data": "curso"
                }, {
                    "data": "nombres"
                }, {
                    "data": "ciclo"
                }, {
                    "data": "grupo"
                }, {
                    "defaultContent": "<button id=\"btn_editar\" data-toggle=\"modal\" data-target=\"#formulario\" class=\"mb-1 w-100 btn btn-warning btn-sm\" style=\"display: block;\"><i class=\"fa fa-pencil\"></i></button>"+"<button id=\"btn_eliminar\" class=\"btn w-100 btn-danger btn-sm\" style=\"display: block;\"><i class=\"fa fa-trash\"></i></button>"
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
                    alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el Curso <strong>" + rowData["curso"] + "</strong>?",
                    function() {
                        eliminar(rowData["id"]);
                        alertify.notify("Se elimino el Curso <strong>" + rowData["curso"] + "</strong> correctamente.", "custom-black", 4, function() {});
                    },
                    function() {
                        alertify.notify("Se cancelo la <strong>eliminación</strong>.", "custom-black", 4, function() {});
                    }).set("labels", { ok: "Eliminar", cancel: "Cancelar" });
                } else {
                    alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el Curso <strong>" + data["curso"] + "</strong>?",
                    function() {
                        eliminar(data["id"]);
                        alertify.notify("Se elimino el Curso <strong>" + data["curso"] + "</strong> correctamente.", "custom-black", 4, function() {});
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
            $.post("' . $this->baseurl . INDEX . 'cursos/add_index", {
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
            $.post("' . $this->baseurl . INDEX . 'cursos/rem_index", {
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
        function eliminar(id) {
            $.ajax({
                url: "' . $this->baseurl . INDEX . 'cursos/eliminar",
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
        function nuevo_curso(){
            $("#exampleModalLabel").text("Nuevo Curso");
            $("#btn_finalizar").text("Guardar");
            $("#btn_finalizar").attr("onclick", "registrar_curso();");
            limpiar_formulario();
        }
        function limpiar_formulario(){
            $("#n_lecciones").val("");
            $("#duracion").val("");
            $("#titulo").val("");
            $("#precio").val("");
            $("#fecha_inicio").val("");
            $("#editor1").val("");
            $("#codigo").val("");

            $("#btn_finalizar").text("Guardar");
        }
        function editar(id){
            $.post("' . $this->baseurl . INDEX . 'cursos/editar", {
                id_curso: id
            }, function(response){
                var obj = JSON.parse(response);
                $("#curso").val(obj.curso);
                $("#codigo").val(obj.codigo);

                $("#profile-img-tag").attr("src", "system/controllers/uploads/" + obj.portada);
                
                $("#id_profesor option[value="+obj.id_profesor+"]").prop("selected", true);
                $("#id_ciclo option[value="+obj.id_ciclo+"]").prop("selected", true);
                llenar_grupos(obj.id_ciclo, obj.id_grupo);
                

                $("#btn_finalizar").text("Actualizar");
                $("#btn_finalizar").attr("onclick", "actualizar_curso("+obj.id+");");
            });
        }
        function registrar_curso(){
            var file_data = $("#portada").prop("files")[0];
            var form_data = new FormData();
            form_data.append("file1", file_data);
            form_data.append("curso", $("#curso").val());
            form_data.append("id_profesor", $("#id_profesor").val());
            form_data.append("id_ciclo", $("#id_ciclo").val());
            form_data.append("id_grupo", $("#id_grupo").val());
            form_data.append("codigo", $("#codigo").val());
            
            $(".grid").addClass("loading");
            
            $.ajax({
                url: "'. $this->baseurl . INDEX . 'cursos/save",
                dataType: "script",
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: "post",
                success: function(response){
                    table = $(".datatable").DataTable();
                    table.ajax.reload();
                    alertify.notify("<strong>Curso</strong> agregado correctamente.", "custom-black", 3, function() {});
                    $("#cerrar_formulario_docente").click();
                    $(".grid").removeClass("loading");
                },error: function() {
                    table = $(".datatable").DataTable();
                    table.ajax.reload();
                    alertify.notify("<strong>Curso</strong> agregado correctamente.", "custom-black", 3, function() {});
                    $("#cerrar_formulario_docente").click();
                    $(".grid").removeClass("loading");
                }
            });
        }
        function actualizar_curso(id){
            var file_data = $("#portada").prop("files")[0];
            var form_data = new FormData();
            form_data.append("file1", file_data);
            form_data.append("curso", $("#curso").val());
            form_data.append("id_profesor", $("#id_profesor").val());
            form_data.append("id_ciclo", $("#id_ciclo").val());
            form_data.append("id_grupo", $("#id_grupo").val());
            form_data.append("codigo", $("#codigo").val());

            form_data.append("id", id);
            
            $(".grid").addClass("loading");
            
            $.ajax({
                url: "'. $this->baseurl . INDEX . 'cursos/editarBD",
                dataType: "script",
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: "post",
                success: function(response){
                    table = $(".datatable").DataTable();
                    table.ajax.reload();
                    alertify.notify("<strong>Curso</strong> modificado correctamente.", "custom-black", 3, function() {});
                    $("#cerrar_formulario_docente").click();
                    $(".grid").removeClass("loading");
                },error: function() {
                    table = $(".datatable").DataTable();
                    table.ajax.reload();
                    alertify.notify("<strong>Curso</strong> modificado correctamente.", "custom-black", 3, function() {});
                    $("#cerrar_formulario_docente").click();
                    $(".grid").removeClass("loading");
                }
            });
        }
        $(function() {
            $("#form_modificar").on("submit", function(e) {
                e.preventDefault();
                var f = $(this);
                var metodo = f.attr("method");
                var url = f.attr("action");
                var formData = new FormData(this);
                formData.append("dato", "valor");
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
                        alertify.modalcursos().close();
                        alertify.notify("<strong>Curso</strong> modificada correctamente.", "custom-black", 3, function() {});
                        $("#id_grado option[value=0]").attr("selected", true);
                    },
                    error: function() {},
                });
            });
        });
        
        </script>
        <script type="text/javascript">
     
                  function selectedFile() {
                    var archivoSeleccionado = document.getElementById("myfile");
                    var file = archivoSeleccionado.files[0];
                    if (file) {
                        var fileSize = 0;
                        if (file.size > 1048576)
                            fileSize = (Math.round(file.size * 100 / 1048576) / 100).toString() + \' MB\';
                        else
                            fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + \' Kb\';
     
                        var divfileSize = document.getElementById(\'fileSize\');
                        var divfileType = document.getElementById(\'fileType\');
                        divfileSize.innerHTML = \'Tamaño: \' + fileSize;
                        divfileType.innerHTML = \'Tipo: \' + file.type;
     
                    }
                  }     
     
                function uploadFile(){
                    //var url = "http://localhost/ReadMoveWebServices/WSUploadFile.asmx?op=UploadFile";
                    var url = "'. $this->baseurl . INDEX . 'cursos/save";
                    var archivoSeleccionado = document.getElementById("myfile");
                    var file = archivoSeleccionado.files[0];
                    var fd = new FormData();
                    fd.append("archivo", file);
                    var xmlHTTP= new XMLHttpRequest();
                    //xmlHTTP.upload.addEventListener("loadstart", loadStartFunction, false);
                    xmlHTTP.upload.addEventListener("progress", progressFunction, false);
                    xmlHTTP.addEventListener("load", transferCompleteFunction, false);
                    xmlHTTP.addEventListener("error", uploadFailed, false);
                    xmlHTTP.addEventListener("abort", uploadCanceled, false);
                    xmlHTTP.open("POST", url, true);
                    //xmlHTTP.setRequestHeader(\'book_id\',\'10\');
                    xmlHTTP.send(fd);
                }       
     
                function progressFunction(evt){
                    var progressBar = document.getElementById("progressBar");
                    var percentageDiv = document.getElementById("percentageCalc");
                    if (evt.lengthComputable) {
                        progressBar.max = evt.total;
                        progressBar.value = evt.loaded;
                        percentageDiv.innerHTML = Math.round(evt.loaded / evt.total * 100) + "%";
                    }
                }
     
                function loadStartFunction(evt){
                    alert(\'Comenzando a subir el archivo\');
                }
                function transferCompleteFunction(evt){
                    alert(\'Transferencia completa\');
                    var progressBar = document.getElementById("progressBar");
                    var percentageDiv = document.getElementById("percentageCalc");
                    progressBar.value = 100;
                    percentageDiv.innerHTML = "100%";
                }   
     
                function uploadFailed(evt) {
                    console.log(evt);
                    alert("Hubo un error al subir el archivo.");
                }
     
                function uploadCanceled(evt) {
                    alert("La operación se canceló o la conexión fue interrunpida.");
                }
     
            </script>
        ';     
        return $r;
    }
}
?>
