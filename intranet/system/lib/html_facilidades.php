<?php
class html_facilidades extends f
{
    private $baseurl = "";

    function html_facilidades()
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
                .service-content {
                    margin-top: 30px;
                }
                .service-icon {
                    height: 46px;
                    width: 90px;
                    margin-bottom: 50px;
                }
                .icon-pentagon {
                    display: inline-block;
                    height: 24px;
                    width: 40px;
                    position: relative;
                    color: #fff;
                    transition: all 0.3s ease 0s;
                }
                .icon-pentagon {
                    background: none repeat scroll 0 0 #ee3b24;
                }
                .service-icon::before {
                    border-left: 45px solid rgba(0, 0, 0, 0);
                    border-right: 45px solid rgba(0, 0, 0, 0);
                    top: -30px;
                }
                .icon-pentagon::before {
                    border-left: 20px solid rgba(0, 0, 0, 0);
                    border-right: 20px solid rgba(0, 0, 0, 0);
                    top: -10px;
                    content: "";
                    height: 0;
                    left: 0;
                    position: absolute;
                    width: 0;
                }
                .service-icon::before {
                    border-bottom: 30px solid #ee3b24;
                }
                .icon-pentagon::before {
                    border-bottom: 10px solid #ee3b24;
                }
                .service-icon::after {
                    border-left: 45px solid rgba(0, 0, 0, 0);
                    border-right: 45px solid rgba(0, 0, 0, 0);
                    bottom: -30px;
                }
                .icon-pentagon::after {
                    border-left: 20px solid rgba(0, 0, 0, 0);
                    border-right: 20px solid rgba(0, 0, 0, 0);
                    bottom: -10px;
                    content: "";
                    height: 0;
                    left: 0;
                    position: absolute;
                    width: 0;
                }
                .service-icon::after {
                    border-top: 30px solid #ee3b24;
                }
                .icon-pentagon::after {
                    border-top: 10px solid #ee3b24;
                }
                .service-content h3 {
                    font-size: 16px;
                }
            </style>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Opciones de "Facilidades"
                        </h5>
                        <small>
                            <i class="fa fa-edit"></i> Aquí podrá Modificar la información de las Facilidades
                        </small>
                        <hr>
                        <div class="form-row">
                            <div class="col-md">
                                <div class="service-content text-center">
                                    <span class="mb-3 service-icon "><img id="imagen_1" src="" class="w-50"></span>
                                    <h3 class="mb-0" id="titulo_1"></h3>
                                    <p class="mt-0" id="descripcion_1"></p>
                                    <span class="badge badge-warning" title="Editar" style="cursor: pointer;" data-toggle="modal" data-target="#formulario" onclick="editar(1);"><i class="fa fa-pencil"></i> Editar</span>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="service-content text-center">
                                    <span class="mb-3 service-icon "><img id="imagen_2" src="" class="w-50"></span>
                                    <h3 id="titulo_2" class="mb-0"></h3>
                                    <p id="descripcion_2" class="mt-0"></p>
                                    <span class="badge badge-warning" title="Editar" style="cursor: pointer;" data-toggle="modal" data-target="#formulario" onclick="editar(2);"><i class="fa fa-pencil"></i> Editar</span>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="service-content text-center">
                                    <span class="mb-3 service-icon "><img id="imagen_3" src="" class="w-50"></span>
                                    <h3 id="titulo_3" class="mb-0"></h3>
                                    <p id="descripcion_3" class="mt-0"></p>
                                    <span class="badge badge-warning" title="Editar" style="cursor: pointer;" data-toggle="modal" data-target="#formulario" onclick="editar(3);"><i class="fa fa-pencil"></i> Editar</span>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="service-content text-center">
                                    <span class="mb-3 service-icon "><img id="imagen_4" src="" class="w-50"></span>
                                    <h3 id="titulo_4" class="mb-0"></h3>
                                    <p id="descripcion_4" class="mt-0"></p>
                                    <span class="badge badge-warning" title="Editar" style="cursor: pointer;" data-toggle="modal" data-target="#formulario" onclick="editar(4);"><i class="fa fa-pencil"></i> Editar</span>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="service-content text-center">
                                    <span class="mb-3 service-icon "><img id="imagen_5" src="" class="w-50"></span>
                                    <h3 id="titulo_5" class="mb-0"></h3>
                                    <p id="descripcion_5" class="mt-0"></p>
                                    <span class="badge badge-warning" title="Editar" style="cursor: pointer;" data-toggle="modal" data-target="#formulario" onclick="editar(5);"><i class="fa fa-pencil"></i> Editar</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!----------------------------------------------------------------------->
            <div class="modal fade" id="formulario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document" style="max-width: 65%;">
                    <div class="modal-content" style="height: auto;">
                        <div class="modal-header" style="position: relative; padding-top: 0; padding-bottom: 0;">
                            <h3 class="modal-title mb-4 text-center" >Editar Facilidad</h3>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close" style="color: #313131;">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Imagen</label>
                                    <label for="imagen" style="font-weight: bold;">Seleccionar imagen
                                        <input id="imagen" class="form-control" name="imagen" type="file" style="display: none;"/>
                                    </label>
                                </div>
                                <div class="col-md-12 mt-2 text-center">
                                    <img class="mt-2" src="" id="profile-img-tag" width="200px" style="margin-left: auto;margin-right: auto;" />
                                </div>
                                <div class="col-md-12 mt-1">
                                    <label>Titulo</label>
                                    <input type="text" name="titulo" id="titulo" class="form-control">
                                </div>
                                <div class="col-md-12 mt-1">
                                    <label>Descripcion</label>
                                    <input type="text" name="descripcion" id="descripcion" class="form-control">
                                </div>
                                <div class="col-md-12 mt-3">
                                    <progress id="progressBar" class="mt-2" value="0" max="100" style="width:100%;"></progress>
                                    <p id="status"></p>
                                    <p id="loaded_n_total"></p>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <span class="btn btn-success" id="btn_funcion" onclick="guardar_examen();" style="width: 100%;">Guardar</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!----------------------------------------------------------------------->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/jquery.datetimepicker.full.min.js"></script>
            <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/build/jquery.datetimepicker.min.css" rel="stylesheet" />
            <script>
                function _(el){
                    return document.getElementById(el);
                }
                function uploadFile(){
                    var file = _("imagen").files[0];
                    // alert(file.name+" | "+file.size+" | "+file.type);
                    var formdata = new FormData();
                    formdata.append("imagen", file);
                    formdata.append("titulo", $("#titulo").val());
                    formdata.append("descripcion", $("#descripcion").val());
                    var ajax = new XMLHttpRequest();
                    ajax.upload.addEventListener("progress", progressHandler, false);
                    ajax.addEventListener("load", completeHandler, false);
                    ajax.addEventListener("error", errorHandler, false);
                    ajax.addEventListener("abort", abortHandler, false);
                    ajax.open("POST", "' . $this->baseurl . INDEX . 'facilidades/save/");
                    ajax.send(formdata);
                }
                function progressHandler(event){
                    _("loaded_n_total").innerHTML = "Uploaded "+event.loaded+" bytes of "+event.total;
                    var percent = (event.loaded / event.total) * 100;
                    _("progressBar").value = Math.round(percent);
                    //_("status").innerHTML = Math.round(percent)+"% uploaded... please wait";
                    table = $(".datatable").DataTable();
                    table.ajax.reload();
                }
                function completeHandler(event){
                    alertify.notify("<strong></strong> agregado correctamente.", "custom-black", 3, function() {});
                    _("progressBar").value = 0;
                    get_data();
                }
                function errorHandler(event){
                    _("status").innerHTML = "Upload Failed";
                }
                function abortHandler(event){
                    _("status").innerHTML = "Upload Aborted";
                }
            </script>
            <script>
                function get_data(){
                    $.post("' . $this->baseurl . INDEX . 'facilidades/loadfacilidades", function(response){
                        var obj = JSON.parse(response);

                        $.each(obj, function(index, val){
                            $("#imagen_"+ val.id).attr("src", "../web/"+val.imagen);
                            $("#titulo_"+ val.id).text(val.titulo);
                            $("#descripcion_"+ val.id).text(val.descripcion);
                        });
                    });
                }
                $(document).ready(function() {
                    get_data();
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

                    $("#btn_funcion").attr("onclick", "guardar_facilidad();");

                });
                function actualizar_facilidad(id){
                    var file = _("imagen").files[0];
                    // alert(file.name+" | "+file.size+" | "+file.type);
                    var formdata = new FormData();
                    formdata.append("imagen", file);
                    formdata.append("titulo", $("#titulo").val());
                    formdata.append("descripcion", $("#descripcion").val());
                    formdata.append("id", id);
                    var ajax = new XMLHttpRequest();
                    ajax.upload.addEventListener("progress", progressHandler, false);
                    ajax.addEventListener("load", completeHandler, false);
                    ajax.addEventListener("error", errorHandler, false);
                    ajax.addEventListener("abort", abortHandler, false);
                    ajax.open("POST", "'.$this->baseurl . INDEX . 'facilidades/save");
                    ajax.send(formdata);
                }
                function eliminar(id) {
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'precios/eliminar",
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
                    $("#descripcion").val("");

                    $("#profile-img-tag").attr("src", "");
                    
                    $("#btn_funcion").text("Guardar");
                    $("#btn_funcion").attr("onclick", "guardar_facilidad();");
                }
                function editar(id){
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'facilidades/editar",
                        type: "POST",
                        dataType: "json",
                        data: {
                            "id": id,
                        },
                        success: function(data) {
                            $("#titulo").val(data.titulo);
                            $("#descripcion").val(data.descripcion);

                            $("#profile-img-tag").attr("src", "../web/"+data.imagen);

                            $("#btn_funcion").text("Actualizar");
                            $("#btn_funcion").attr("onclick", "actualizar_facilidad("+id+");");
                        }
                    });
                }
            </script>';
        return $r;
    }
}
