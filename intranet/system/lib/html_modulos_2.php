<?php
    ini_set('upload_max_filesize', '1024M');
    ini_set('post_max_size', '1024M');
    ini_set('max_input_time', 3600);
    ini_set('max_execution_time', 3600);
class html_modulos_2 extends f{
    private $baseurl = "";

    function html_modulos_2(){
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
        .panel-group .panel {
            margin-bottom: 0;
            border-radius: 4px;
        }
        .panel-default {
            border-color: #ddd;
        }
        .panel {
            margin-bottom: 20px;
            background-color: #fff;
            border: 1px solid transparent;
            border-radius: 4px;
            -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);
            box-shadow: 0 1px 1px rgba(0,0,0,.05);
        }
        .panel-default > .panel-heading {
            color: #333;
            background-color: #f5f5f5;
            border-color: #ddd;
        }
        .panel-group .panel-heading {
            border-bottom: 0;
                border-bottom-color: currentcolor;
        }
        .panel-heading {
            padding: 10px 15px;
            border-bottom: 1px solid transparent;
            border-top-left-radius: 3px;
            border-top-right-radius: 3px;
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="w-100 text-right">
                <span style="margin-bottom: 10px;" class="btn btn-sm btn-success" data-toggle="modal" data-target="#formulario" id="btn_nuevo" onclick="nueva_malla();">Agregar Malla Curricular</span>
            </div>
            <div class="col-md-12">
                <hr>
                <h5 class=""><i class="fa fa-bars" aria-hidden="true"></i> Malla Curricular</h5>
                <small><i class="fa fa-edit"></i> Aquí podrá ver toda la información de la Malla Curricular Registrada</small>
                <hr>
                <div class="container" style="max-width: 100%;">
                    
                    <hr>
                    <div class="row mt-3">
                        <div class="col-12" id="div_malla">
                            <div class="panel-group" id="accordion">
                                
                            </div> 
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
                        <label>Titulo</label>
                        <input type="text" class="form-control" id="titulo">
                    </div>
                    <div class="form-group" style="width: 100%;">
                        <div id="editor" class="mt-2">
                            <label>Contenido</label>
                            <textarea name="editor1" id="editor1" rows="10" cols="80">
                            </textarea>
                        </div>
                        <script>
                            CKEDITOR.replace( "editor1" );
                        </script>
                        
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
            get_malla();
            //_("progressBar").value = 0;
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
        
        $(document).ready(function() {
            
            get_malla();
        });
        function get_malla(){
            $.post("' . $this->baseurl . INDEX . 'modulos_2/get_malla", function(response){
                var obj = JSON.parse(response);

                $("#accordion").empty();

                if(obj.length == 0){
                    $("#accordion").append(`<div class="alert alert-success">No hay malla curricular registrada.</div>`);
                }else{
                    $.each(obj, function(index, val){
                        $("#accordion").append(`
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse${val.id}">${val.modulo}</a>
                                    <span class="btn btn-sm btn-warning" onclick="editar(${val.id});" data-toggle="modal" data-target="#formulario">Editar</span>
                                </h4>

                            </div>
                            <div id="collapse${val.id}" class="panel-collapse collapse in">
                                <div class="panel-body">${val.descripcion}</div>
                                </div>
                            </div>
                        </div>`);
                    });
                }
            });
        }
        
        
        function eliminar(id) {
            $.ajax({
                url: "' . $this->baseurl . INDEX . 'malla/eliminar",
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
        function nueva_malla(){
            $("#exampleModalLabel").text("Modificar Malla Curricular");
            $("#profile-img-tag").attr("src", "");
            $("#btn_finalizar").text("Guardar");
            $("#btn_finalizar").attr("onclick", "registrar_malla();");
            limpiar_formulario();
        }
        function limpiar_formulario(){
            $("#titulo").val("");
            $("#imagen").val("");
            CKEDITOR.instances.editor1.setData("");

            $("#btn_finalizar").text("Guardar");
        }
        function editar(id){
            $.post("' . $this->baseurl . INDEX . 'modulos_2/editar", {
                id: id
            }, function(response){
                var obj = JSON.parse(response);

                CKEDITOR.instances.editor1.setData(obj.descripcion);
                $("#titulo").val(obj.modulo);

                $("#btn_finalizar").text("Actualizar");
                $("#btn_finalizar").attr("onclick", "actualizar_malla("+obj.id+");");
            });
        }
            
        function registrar_malla(){
            var data = CKEDITOR.instances.editor1.getData();
            var formdata = new FormData();
            formdata.append("descripcion", data);
            formdata.append("modulo", $("#titulo").val());

            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandler, false);
            ajax.addEventListener("load", completeHandler, false);
            ajax.addEventListener("error", errorHandler, false);
            ajax.addEventListener("abort", abortHandler, false);
            ajax.open("POST", "'.$this->baseurl . INDEX . 'modulos_2/save");
            ajax.send(formdata);
        }
        function actualizar_malla(id){
            var data = CKEDITOR.instances.editor1.getData();
            
            var formdata = new FormData();
            formdata.append("descripcion", data);
            formdata.append("modulo", $("#titulo").val());

            formdata.append("id", id);
            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandler, false);
            ajax.addEventListener("load", completeHandler, false);
            ajax.addEventListener("error", errorHandler, false);
            ajax.addEventListener("abort", abortHandler, false);
            ajax.open("POST", "'.$this->baseurl . INDEX . 'modulos_2/editarBD");
            ajax.send(formdata);
        }
        </script>
        ';     
        return $r;
    }
}
?>
