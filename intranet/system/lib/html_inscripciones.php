<?php
class html_inscripciones extends f{
	private $baseurl = "";

	function html_inscripciones(){
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
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <span style="float: right; margin-bottom: 10px;" class="btn btn-sm btn-success" data-toggle="modal" data-target="#formulario" id="btn_nuevo" onclick="nuevo_alumno();">Nuevo Alumno</span>
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Lista de Alumnos
                        </h5>
                        <small>
                            <i class="far fa-edit"></i> Aquí podrá ver toda la información de todos los Alumnos
                        </small>
                        <hr>         
                        <div class="container" style="max-width: 100%;">
                            <div class="row">
                                <div class="table-responsive" >
                                    <table  class="datatable table dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>N° Doc.</th>
                                                <th>Nombres</th>
                                                <th>Apellidos</th>
                                                <th>Nacionalidad</th>
                                                <th>Celular</th>
                                                <th>Correo</th>
                                                <th>Tipo Est.</th>
                                                <th>Institución</th>
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
                    var table = $(".datatable").DataTable({
                        "ajax": {
                            url: "' . $this->baseurl . INDEX . 'inscripciones/loadinscripciones/",
                            "dataSrc": ""
                        },
                        "columns": [{
                            "data": "dni",
                        }, {
                            "data": "nombres"
                        }, {
                            "data": "apellidos"
                        }, {
                            "data": "nacionalidad"
                        }, {
                            "data": "celular"
                        }, {
                            "data": "correo"
                        }, {
                            "data": "tipo_estudiante"
                        },  {
                            "data": "institucion"
                        },],
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
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el Alumno <strong>" + rowData["apellidos"] + "</strong>?",
                            function() {
                                eliminar(rowData["id"]);
                                alertify.notify("Se elimino el Alumno <strong>" + rowData["apellidos"] + "</strong> correctamente.", "custom-black", 4, function() {});
                            },
                            function() {
                                alertify.notify("Se cancelo la <strong>eliminación</strong>.", "custom-black", 4, function() {});
                            }).set("labels", { ok: "Eliminar", cancel: "Cancelar" });
                        } else {
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el Alumno <strong>" + data["apellidos"] + "</strong>?",
                            function() {
                                eliminar(data["id"]);
                                alertify.notify("Se elimino el Alumno <strong>" + data["apellidos"] + "</strong> correctamente.", "custom-black", 4, function() {});
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
                function load_padres(){
                    $.get("' . $this->baseurl . INDEX . 'padres/loadpadres", function(response){
                        var obj = JSON.parse(response);
                        $.each(obj, function(index, val){
                            $("#padre_").append("<option value=" + val.id + ">" + val.apellidos + ", " + val.nombres + "</option>");
                        });
                    });
                }
                function nuevo_alumno(){
                    $("#exampleModalLabel").text("Nuevo Alumno");
                    //$("#form_nuevo").attr("action", "'. $this->baseurl . INDEX . 'alumnos/save");
                    $("#btn_finalizar").text("Guardar");
                    $("#btn_finalizar").attr("onclick", "guardar_alumno();");
                    limpiar_formulario();
                }
                function eliminar(id) {
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'alumnos/eliminar",
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
                    $("#dni").val("");
                    $("#nombres").val("");
                    $("#apellidos").val("");
                    $("#fecha_nacimiento").val("");
                    $("#telefono").val("");
                    $("#direccion").val("");
                    $("#correo").val("");
                    $("#id_padre").val("");
                    //$("#btn_finalizar").removeAttr("onclick");
                    $("#btn_finalizar").text("Guardar");
                }
                function editar(id){
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'alumnos/editar",
                        type: "POST",
                        dataType: "json",
                        data: {
                            "id": id,
                        },
                        success: function(data) {
                            $("#div_padre").empty();
                            $("#dni").val(data.dni);
                            $("#nombres").val(data.nombres);
                            $("#apellidos").val(data.apellidos);
                            $("#fecha_nacimiento").val(data.fecha_nacimiento);
                            $("#telefono").val(data.telefono);
                            $("#direccion").val(data.direccion);
                            $("#correo").val(data.correo);
                            $("#id_padre").val(data.id_padre);
                            $("#btn_finalizar").text("Actualizar");
                            
                            $("#profile-img-tag").attr("src", "system/controllers/uploads/" + data.foto);
                            
                            $("#btn_finalizar").attr("onclick", "actualizar_alumno("+data.id+");");
                            $("#form_nuevo").attr("action", "'.$this->baseurl . INDEX . 'alumnos/editarBD");
                            $("#exampleModalLabel").text("Editar Alumno");
                        }
                    });
                }
                $("#cerrar_formulario_docente").click(function(){
                    limpiar_formulario();
                });
                function guardar_alumno(){
                    var file_data = $("#foto").prop("files")[0];
                    var form_data = new FormData();
                    form_data.append("file1", file_data)
                    
                    form_data.append("dni", $("#dni").val())
                    form_data.append("nombres", $("#nombres").val())
                    form_data.append("apellidos", $("#apellidos").val())
                    form_data.append("telefono", $("#telefono").val())
                    form_data.append("fecha_nacimiento", $("#fecha_nacimiento").val())
                    form_data.append("direccion", $("#direccion").val())
                    form_data.append("correo", $("#correo").val())
                    form_data.append("usuario", $("#usuario").val())
                    form_data.append("pass", $("#pass").val())
                    $.ajax({
                        url: "'. $this->baseurl . INDEX . 'alumnos/save",
                        dataType: "script",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,                         // Setting the data attribute of ajax with file_data
                        type: "post",
                        success: function(response){
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            alertify.notify("<strong>Alumno</strong> agregado correctamente.", "custom-black", 3, function() {});
                            $("#cerrar_formulario_docente").click();
                        },error: function() {
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            alertify.notify("<strong>Alumno</strong> agregado correctamente.", "custom-black", 3, function() {});
                            $("#cerrar_formulario_docente").click();
                        }
                    });
                }
                function actualizar_alumno(id){
                    /*$.post("'.$this->baseurl . INDEX . 'alumnos/editarBD", {
                        dni: $("#dni").val(),
                        nombres: $("#nombres").val(), 
                        apellidos: $("#apellidos").val(), 
                        telefono: $("#telefono").val(), 
                        fecha_nacimiento: $("#fecha_nacimiento").val(), 
                        direccion: $("#direccion").val(), 
                        correo: $("#correo").val(),
                        id_padre: $("#id_padre").val(),
                        usuario: $("#usuario").val(),
                        pass: $("#pass").val(),
                        id: id 
                    }, function(response){
                        var obj = JSON.parse(response);
                        if(obj.Result == "OK"){
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            alertify.notify("<strong>Alumno</strong> Modificado correctamente.", "custom-black", 3, function() {});
                            $("#cerrar_formulario_docente").click();
                            $("#cerrar_alerta").click();
                        }else{
                            alertify.notify("<strong>Algo ha salido muy mal.</strong>", "custom-black", 3, function() {});
                        }
                    });*/
                    
                    var file_data = $("#foto").prop("files")[0];
                    var form_data = new FormData();
                    form_data.append("file1", file_data)
                    
                    form_data.append("dni", $("#dni").val())
                    form_data.append("nombres", $("#nombres").val())
                    form_data.append("apellidos", $("#apellidos").val())
                    form_data.append("telefono", $("#telefono").val())
                    form_data.append("fecha_nacimiento", $("#fecha_nacimiento").val())
                    form_data.append("direccion", $("#direccion").val())
                    form_data.append("correo", $("#correo").val())
                    form_data.append("usuario", $("#usuario").val())
                    form_data.append("pass", $("#pass").val())
                    form_data.append("id", id)
                    $.ajax({
                        url: "'.$this->baseurl . INDEX . 'alumnos/editarBD",
                        dataType: "script",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,                         // Setting the data attribute of ajax with file_data
                        type: "post",
                        success: function(response){
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            alertify.notify("<strong>Alumno</strong> modificado correctamente.", "custom-black", 3, function() {});
                            $("#cerrar_formulario_docente").click();
                        },error: function() {
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            alertify.notify("<strong>Alumno</strong> modificado correctamente.", "custom-black", 3, function() {});
                            $("#cerrar_formulario_docente").click();
                        }
                    });
                }
            </script>';     
            return $r;
        }
    }
?>
