<?php
    ini_set('upload_max_filesize', '1024M');
    ini_set('post_max_size', '1024M');
    ini_set('max_input_time', 3600);
    ini_set('max_execution_time', 3600);
class html_malla extends f{
	private $baseurl = "";

	function html_malla(){
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
                        <div class="w-100 text-right">
                            <span style="margin-bottom: 10px;" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#formulario" id="btn_nuevo" onclick="editar();">Editar Malla Curricular</span>
                        </div>
                        <div class="col-12" id="div_malla">
                            
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
                            <div id="editor" class="mt-2">
                                <label>Malla Curricular</label>
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
            $.post("' . $this->baseurl . INDEX . 'malla/get_malla", function(response){
                var obj = JSON.parse(response);

                $("#div_malla").empty();

                if(obj.length == 0){
                    $("#div_malla").append(`<div class="alert alert-success">No hay malla curricular registrada.</div>`);
                }else{
                    $("#div_malla").append(obj.malla);
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
        function editar(){
            $.post("' . $this->baseurl . INDEX . 'malla/editar", function(response){
                var obj = JSON.parse(response);

                CKEDITOR.instances.editor1.setData(obj.malla);

                $("#btn_finalizar").text("Actualizar");
                $("#btn_finalizar").attr("onclick", "actualizar_malla("+obj.id+");");
            });
        }
            
        function registrar_malla(){
            var data = CKEDITOR.instances.editor1.getData();
            var formdata = new FormData();
            formdata.append("malla", data);

            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandler, false);
            ajax.addEventListener("load", completeHandler, false);
            ajax.addEventListener("error", errorHandler, false);
            ajax.addEventListener("abort", abortHandler, false);
            ajax.open("POST", "'.$this->baseurl . INDEX . 'malla/save");
            ajax.send(formdata);
        }
        function actualizar_malla(id){
            var data = CKEDITOR.instances.editor1.getData();
            
            var formdata = new FormData();
            formdata.append("malla", data);

            formdata.append("id", id);
            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandler, false);
            ajax.addEventListener("load", completeHandler, false);
            ajax.addEventListener("error", errorHandler, false);
            ajax.addEventListener("abort", abortHandler, false);
            ajax.open("POST", "'.$this->baseurl . INDEX . 'malla/editarBD");
            ajax.send(formdata);
        }
        </script>
        ';     
        return $r;
    }
}
?>
