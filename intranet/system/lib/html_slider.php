<?php
class html_slider extends f{
    private $baseurl = "";

    function html_slider(){
        $this->load()->lib_html("Table", false);
        $this->baseurl = BASEURL;
    }
    function container(){
        $r = '<script>
                function abrir_modal(b,a){alertify.dialog(b,function(){return{main:function(c){this.setContent(c);},setup:function(){return{focus:{element:function(){return this.elements.body.querySelector(this.get("selector"));
                },select:true},options:{basic:false,title:a,maximizable:false,resizable:false,padding:true,modal:true,transition:false,}};},settings:{selector:undefined}};
                });}
            </script>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Nueva Slider
                        </h5>
                        <small>
                            <i class="fa fa-edit"></i> Aquí podrá ver agregar un Slider
                        </small>
                        <hr>
                        <div class="col-md-12">
                            <label>Imagen</label>
                            <input type="file" name="file1" id="file1" class="form-control">
                            <div class="w-100 text-center mt-3">
                                <img src="" id="profile-img-tag" width="200px" style="margin-left: auto;margin-right: auto;" />
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <progress id="progressBar" class="mt-2" value="0" max="100" style="width:100%;"></progress>
                            <p id="status"></p>
                            <p id="loaded_n_total"></p>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success" id="btn_finalizar">Guardar</button>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Listado de Sliders
                        </h5>
                        <small>
                            <i class="far fa-edit"></i> Aquí podrá ver toda la información de los Sliders
                        </small>
                        <hr>         
                        <div class="container">
                            <div class="row">
                                <div class="col-12" >
                                    <table  class="datatable table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Imagen</th>
                                                <th>Estado</th>
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
                function _(el){
                    return document.getElementById(el);
                }
                function uploadFile(){
                    var file = _("file1").files[0];
                    var formdata = new FormData();
                    formdata.append("file1", file);
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
                    $("#cerrar_formulario_aula").click();
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
                    function readURL(input) {
                        if (input.files && input.files[0]) {
                            var reader = new FileReader();
                            reader.onload = function (e) {
                                $("#profile-img-tag").attr("src", e.target.result);
                            }
                            reader.readAsDataURL(input.files[0]);
                        }
                    }
                    $("#file1").change(function(){
                        readURL(this);
                    });
                    $("#btn_finalizar").attr("onclick", "guardar_info();");
                    var table = $(".datatable").DataTable({
                        "ajax": {
                            url: "' . $this->baseurl . INDEX . 'slider/loadslider/",
                            "dataSrc": ""
                        },
                        "columns": [{
                            "data": "id"
                        },  {
                            "data": "imagen",
                            "render": function(data){
                                return "<img src=\"../img/"+data+"\" class=\"w-100\">"
                            }
                        },{
                            "data": "estado",
                            "render": function(data){
                                if(data == 1){
                                    return "<button id=\"btn_rem\" class=\"btn btn-danger btn-sm\" ><i class=\"fa fa-times\"></i></button>"
                                }else{
                                    return "<button id=\"btn_add\" class=\"btn btn-success btn-sm\" ><i class=\"fa fa-check\"></i></button>"
                                }
                            },
                        },  {
                            "defaultContent": "<button id=\"btn_eliminar\" class=\"btn btn-danger btn-sm\"><i class=\"fa fa-trash\"></i></button>"
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
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el Slider?",
                            function() {
                                eliminar(rowData["id"]);
                                alertify.notify("Se elimino el Slider correctamente.", "custom-black", 4, function() {});
                            },
                            function() {
                                alertify.notify("Se cancelo la <strong>eliminación</strong>.", "custom-black", 4, function() {});
                            }).set("labels", { ok: "Eliminar", cancel: "Cancelar" });
                        } else {
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el Slider?",
                            function() {
                                eliminar(data["id"]);
                                alertify.notify("Se elimino el Slider correctamente.", "custom-black", 4, function() {});
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
                    $.post("' . $this->baseurl . INDEX . 'slider/add_index", {
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
                    $.post("' . $this->baseurl . INDEX . 'slider/rem_index", {
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
                function nuevo_aula(){
                    $("#exampleModalLabel").text("Nuevo");
                    $("#btn_finalizar").text("Guardar");
                    $("#btn_finalizar").attr("onclick", "guardar_info();");
                    limpiar_formulario();
                }
                function eliminar(id) {
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'slider/eliminar",
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
                    $("#file1").val("");
                    
                    $("#btn_finalizar").text("Guardar");
                }
                function editar(id){
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'slider/editar",
                        type: "POST",
                        dataType: "json",
                        data: {
                            "id": id,
                        },
                        success: function(data) {
                            $("#enlace").val(data.enlace);
                            $("#red_social option[value="+data.red_social+"]").attr("selected", true);


                            $("#btn_finalizar").text("Actualizar");
                            $("#btn_finalizar").attr("onclick", "actualizar_info("+data.id+");");
                            $("#exampleModalLabel").text("Editar");
                            $("#alerta_pass").removeAttr("hidden");
                        }
                    });
                }
                $("#cerrar_formulario_aula").click(function(){
                    limpiar_formulario();
                });
                function guardar_info(){
                    var file = _("file1").files[0];
                    var formdata = new FormData();
                    formdata.append("file1", file);

                    var ajax = new XMLHttpRequest();
                    ajax.upload.addEventListener("progress", progressHandler, false);
                    ajax.addEventListener("load", completeHandler, false);
                    ajax.addEventListener("error", errorHandler, false);
                    ajax.addEventListener("abort", abortHandler, false);
                    ajax.open("POST", "'.$this->baseurl . INDEX . 'slider/save");
                    ajax.send(formdata);
                }
                function actualizar_info(id){
                    var file = _("file1").files[0];
                    var formdata = new FormData();
                    formdata.append("file1", file);

                    formdata.append("red_social", $("#red_social").val());
                    formdata.append("enlace", $("#enlace").val());

                    formdata.append("id", id);
                    var ajax = new XMLHttpRequest();
                    ajax.upload.addEventListener("progress", progressHandler, false);
                    ajax.addEventListener("load", completeHandler, false);
                    ajax.addEventListener("error", errorHandler, false);
                    ajax.addEventListener("abort", abortHandler, false);
                    ajax.open("POST", "'.$this->baseurl . INDEX . 'slider/editarBD");
                    ajax.send(formdata);
                }
            </script>';     
            return $r;
        }
    }
?>
