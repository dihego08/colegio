<?php
class html_grupos extends f{
    private $baseurl = "";

    function html_grupos(){
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
                    <div class="col-12 col-md-4">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Nuevo Grupo Academico
                        </h5>
                        <small>
                            <i class="fa fa-edit"></i> Aquí podrá Agregar y Modificar la información de los Grupos Academicos
                        </small>
                        <hr>
                        <div class="form-row">
                            <div class="col-md-12">
                                <label>Ciclo Academico</label>
                                <select class="form-control" id="id_ciclo">
                                    <option value="-1">--SELECCIONA--</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label>Grupo Academico</label>
                                <input type="text" class="form-control" id="grupo" name="grupo">
                            </div>
                            <div class="col-md-12 mt-3">
                                <span class="btn btn-success" style="width: 100%;" id="btn_funcion">Guardar</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-8">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Lista de Grupos Academicos
                        </h5>
                        <small>
                            <i class="fa fa-edit"></i> Aquí podrá ver toda la información de todos los Grupos Academicos
                        </small>
                        <hr>         
                        <div class="container">
                            <div class="row">
                                <div class="table-responsive" >
                                    <table  class="datatable table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Grupo</th>
                                                <th>Ciclo Academico</th>
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
                $(document).ready(function() {
                    llenar_ciclos();

                    $( ".datepicker" ).datetimepicker({
                        format: "Y-m-d",
                        timepicker:false
                    });
                    $.datetimepicker.setLocale(\'es\');

                    $("#btn_funcion").attr("onclick", "guardar_ciclo();");
                    limpiar_formulario();

                    var table = $(".datatable").DataTable({
                        "ajax": {
                            url: "' . $this->baseurl . INDEX . 'grupos/loadgrupos/",
                            "dataSrc": ""
                        },
                        "columns": [{
                            "data": "id"
                        },  {
                            "data": "grupo"
                        },  {
                            "data": "ciclo"
                        }, {
                            "defaultContent": "<button id=\"btn_editar\" data-toggle=\"modal\" style=\"display: block;\" data-target=\"#formulario\" class=\"btn btn-warning btn-sm w-100\" ><i class=\"fa fa-pencil\"></i></button> <button id=\"btn_eliminar\" class=\"btn btn-danger btn-sm w-100 mt-1\"><i class=\"fa fa-trash\" style=\"display: block;\"></i></button>"
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
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el Ciclo Academico <strong>" + rowData["ciclo"] + "</strong>?",
                            function() {
                                eliminar(rowData["id"]);
                                alertify.notify("Se elimino el Ciclo Academico <strong>" + rowData["ciclo"] + "</strong> correctamente.", "custom-black", 4, function() {});
                            },
                            function() {
                                alertify.notify("Se cancelo la <strong>eliminación</strong>.", "custom-black", 4, function() {});
                            }).set("labels", { ok: "Eliminar", cancel: "Cancelar" });
                        } else {
                            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el Ciclo Academico <strong>" + data["ciclo"] + "</strong>?",
                            function() {
                                eliminar(data["id"]);
                                alertify.notify("Se elimino el Ciclo Academico <strong>" + data["ciclo"] + "</strong> correctamente.", "custom-black", 4, function() {});
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
                        url: "' . $this->baseurl . INDEX . 'grupos/eliminar",
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
                    $("#id_ciclo").val("-1");
                    $("#grupo").val("");
                    
                    $("#btn_funcion").attr("onclick", "guardar_ciclo();");
                    $("#btn_funcion").text("Guardar");
                }
                function editar(id){
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'grupos/editar",
                        type: "POST",
                        dataType: "json",
                        data: {
                            "id": id,
                        },
                        success: function(data) {
                            $("#id_ciclo").val(data.id_ciclo);
                            $("#grupo").val(data.grupo);

                            $("#btn_funcion").text("Actualizar");
                            $("#btn_funcion").attr("onclick", "actualizar_ciclo("+id+");");
                        }
                    });
                }
                function guardar_ciclo(){
                    $.post("'. $this->baseurl . INDEX . 'grupos/save", {
                        id_ciclo: $("#id_ciclo").val(),
                        grupo: $("#grupo").val(),
                    }, function(response){
                        var obj = JSON.parse(response);
                        if(obj.Result == "OK"){
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            limpiar_formulario();
                            alertify.notify("<strong>Ciclo Academico</strong> agregado correctamente.", "custom-black", 3, function() {});
                        }else{
                            alertify.notify("<strong>Algo ha salido terriblemente mal</strong>.", "custom-black", 3, function() {});
                        }
                    });
                }
                function actualizar_ciclo(id){
                    $.post("'. $this->baseurl . INDEX . 'grupos/editarBD", {
                        id: id,
                        id_ciclo: $("#id_ciclo").val(),
                        grupo: $("#grupo").val(),
                    }, function(response){
                        var obj = JSON.parse(response);
                        if(obj.Result == "OK"){
                            limpiar_formulario();
                            table = $(".datatable").DataTable();
                            table.ajax.reload();
                            alertify.notify("<strong>Ciclo Academico</strong> modificado correctamente.", "custom-black", 3, function() {});
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
