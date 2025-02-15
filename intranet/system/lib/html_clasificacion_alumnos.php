<?php
class html_clasificacion_alumnos extends f{
    private $baseurl = "";

    function html_clasificacion_alumnos(){
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
                    <div class="col-12 col-md-12">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Clasificación de Alumnos
                        </h5>
                        <small>
                            <i class="fa fa-edit"></i> Aquí podrá clasificar a los alumnos en base al promedio de notas de los 4 últimos rankings
                        </small>
                        <hr>         
                        <div class="container">
                            <div class="row">
                                <div class="col-12 form-row"  id="div_aulas">
                                    <table class="table table-hover table-striped " id="tabla-asignacion">
                                        <thead>
                                            <th>Alumno</th>
                                            <th>Promedio</th>
                                            <th>Aula</th>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <link href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css" />

            <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
            <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script>
            <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
            <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script>
            
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
            
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
                                alertify.notify("Se agrego el <strong>Aula</strong> correctamente.", "custom-black", 4, function() {})
                                limpiar_formulario();
                                $("#cerrar_formulario_aula").click();
                            };
                        },
                        error: function() {},
                    });
                });
                function guardar_aforo(id){
                    $.post("'. $this->baseurl . INDEX . 'aulas/guardaraforo", {
                        id: id,
                        aforo: $("#txt_aula_"+id).val()
                    }, function(response){
                        var obj = JSON.parse(response);
                        alertify.notify("<strong>Aula</strong> modificada correctamente.", "custom-black", 3, function() {});
                    });
                }
                function lista_aulas(){
                    $.post("'. $this->baseurl . INDEX . 'clasificacion_alumnos/loadaulas", function(response){
                        var obj = JSON.parse(response);
                        $.each(obj, function(index, val){
                            $("#tabla-asignacion").find("tbody").append(`<tr>
                                <td>${val.alumno}</td>
                                <td>${$.trim(val.promedio)}</td>
                                <td>${$.trim(val.aula)}</td>
                            </tr>`);
                        });

                        $("#tabla-asignacion").DataTable({
                            dom: "Bfrtip",
                            language: {
                                "url": "'.$this->baseurl.'includes/datatables/Spanish.json"
                            },
                            buttons: [
                                "excel"
                            ],
                            order: [[1, "desc"]]
                        });
                    });
                }
                $(document).ready(function() {
                    $( ".datepicker" ).datepicker();
                    $("#form_agregar input[name=nombre]").focus();
                    $("#form_agregar input[name=nombre]").keyup(function() {
                        var letras = $(this).val().substring(0, 4);
                        var numeros = $(this).val().length;
                        $("#form_agregar input[name=codinterno]").val(letras + numeros + "_fam");
                    });
                    lista_aulas();
                });
                function nuevo_aula(){
                    $("#exampleModalLabel").text("Nueva Aula");
                    $("#form_nuevo").attr("action", "'. $this->baseurl . INDEX . 'aulas/save");
                    $("#btn_finalizar").text("Guardar");
                    $("#btn_finalizar").removeAttr("onclick");
                    limpiar_formulario();
                    $("#alerta_pass").attr("hidden", "hidden");
                }
                function eliminar(id) {
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'aulas/eliminar",
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
                    $("#aula").val("");
                    $("#descripcion").val("");
                    $("#btn_finalizar").removeAttr("onclick");
                    $("#btn_finalizar").text("Guardar");
                }
                function editar(id){
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'aulas/editar",
                        type: "POST",
                        dataType: "json",
                        data: {
                            "id": id,
                        },
                        success: function(data) {
                            $("#aula").val(data[0].aula);
                            $("#descripcion").val(data[0].descripcion);
                            $("#btn_finalizar").text("Actualizar");
                            $("#btn_finalizar").attr("onclick", "actualizar_aula("+data[0].id+");");
                            $("#form_nuevo").attr("action", "'.$this->baseurl . INDEX . 'aulas/editarBD");
                            $("#exampleModalLabel").text("Editar Aula");
                            $("#alerta_pass").removeAttr("hidden");
                        }
                    });
                }
                $("#cerrar_formulario_aula").click(function(){
                    limpiar_formulario();
                });
                function actualizar_aula(id){
                    $("#form_nuevo").on("submit", function(e) {
                        e.preventDefault();
                        var f = $(this);
                        var metodo = f.attr("method");
                        var url = f.attr("action");
                        var formData = new FormData(this);
                        formData.append("id", id);
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
                                //alertify.modalcursos().close();
                                alertify.notify("<strong>Aula</strong> modificada correctamente.", "custom-black", 3, function() {});
                                $("#cerrar_formulario_aula").click();
                                alertify.closeAll();
                            },
                            error: function() {},
                        });
                    });
                }
            </script>';     
            return $r;
        }
    }
?>