<?php
class html_conteo extends f{
    private $baseurl = "";

    function html_conteo(){
        $this->load()->lib_html("Table", false);
        $this->baseurl = BASEURL;
    }
    function container(){
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
                .oculta{
                    display: none;
                }
                .resaltar{
                    background-color: yellow;
                }
            </style>
            <div class="container-fluid" style="margin-top: 56px; max-width: 100%;">
                <div class="row">
                    <div class="form-row mb-4 w-100">
                        <div class="col-md-6">
                            <label>Fecha Desde</label>
                            <input type="text" class="form-control datepicker" id="fecha_desde" name="fecha_desde">
                        </div>
                        <div class="col-md-6">
                            <label>Fecha Hasta</label>
                            <input type="text" class="form-control datepicker" id="fecha_hasta" name="fecha_hasta">
                        </div>
                        <div class="col-md-12 mt-3">
                            <button class="btn btn-info w-100" onclick="cargar();">Cargar</button>
                        </div>
                    </div>
                    <div class="col-12 col-md-12">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Lista de Profesores y Cursos
                        </h5>
                        <small>
                            <i class="far fa-edit"></i> Aquí podrá ver el total de Alumnos registrados segun Curso
                        </small>
                        <hr>
                        <div class="col-md-12 mb-3">
                            <label>Filtro de Busqueda</label>
                            <input type="text" id="filtro_rapido" name="filtro_rapido" class="form-control" placeholder="Filtro Rápido">
                        </div>
                        <div class="container" style="max-width: 100%; overflow: hidden;">
                            <div class="row">
                                <div class="col-12" >
                                    <table  class="table table-striped table-bordered nowrap" style="width:100%" id="tabla_detalle">
                                        <thead>
                                            <tr>
                                                <th>Id Curso</th>
                                                <th>Profesor</th>
                                                <th>Curso</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                var id_curso = 0;
                $(document).ready(function() {
                    $( ".datepicker" ).datepicker({ dateFormat: "yy-mm-dd" });
                    $("#filtro_rapido").keyup(function(event){
                        //console.log(event);
                        if(!checkTeclaDel(event)){
                            if($(this).val().length >= 2){
                                filtrar($(this).val());
                            }
                        }
                        
                    });
                    function filtrar(cadena){
                        console.log(cadena);
                        $("#tabla_detalle tbody tr").each(function() {
                            $(this).removeClass(\'oculta\');
                            contenido_fila = $(this).find(\'td:eq(1)\').html();
                            exp = new RegExp(cadena, \'gi\');
                            coincidencias = contenido_fila.match(exp);
                            if (coincidencias != null) {
                                $(this).addClass(\'resaltar\');
                            }else{
                                $(this).addClass(\'oculta\');
                            }
                        });
                    }
                    function mostrarFilas(){
                        $("#tabla_detalle tbody tr").each(function() {
                            $(this).removeClass(\'oculta resaltar\');
                        });
                    }
                    function checkTeclaDel(e){
                        codigoAscci = (e.keyCode ? e.keyCode : e.which);
                        //console.log(codigoAscci);
                        if (codigoAscci == 8) {
                            if($("#filtro_rapido").val().length >= 2){
                                filtrar($("#filtro_rapido").val());
                            }else{
                                mostrarFilas();
                            }
                            return true;
                        }else{
                            return false;
                        }
                    }
                });
                function cargar(){
                    console.log(id_curso);
                    $.post("' . $this->baseurl . INDEX . 'conteo/loadconteo", {
                        id_curso: id_curso,
                        f_d: $("#fecha_desde").val(),
                        f_h: $("#fecha_hasta").val()
                    }, function(response){
                        var total = 0;
                        var obj = JSON.parse(response);
                        $("#tabla_detalle").find("tbody").empty();
                        $.each(obj, function(index, val){
                            total += parseInt(val.conteo);
                            $("#tabla_detalle").find("tbody").append(`<tr><td style="padding: .75rem;">`+val.id+`</td><td style="padding: .75rem;">`+val.profesor+`</td><td style="padding: .75rem;">`+val.titulo+`</td><td class="text-center" style="padding: .75rem;">`+val.conteo+`</td></tr>`);
                        });
                        $("#tabla_detalle").find("tbody").append(`<tr class="table-danger"><td colspan="3" style="padding: .75rem; text-align: right; font-weight: bold;">TOTAL</td><td class="text-center" style="padding: .75rem;">`+total+`</td></tr>`);
                    });
                }
                function ver_detalle(id){
                    $("#tabla_detalle").find("tbody").empty();
                    $.ajax({
                        url: "' . $this->baseurl . INDEX . 'clases/get_clases",
                        type: "POST",
                        dataType: "json",
                        data: {
                            "id_curso": id,
                        },
                        success: function(data) {
                            $.each(data.Records, function(index, val){
                                $("#tabla_detalle").find("tbody").append(`<tr><td style="padding: .75rem;">`+val.titulo+`</td><td class="text-center" style="padding: .75rem;"> - </td></tr>`);
                            });
                            
                        }
                    });
                }
            </script>';     
            return $r;
        }
    }
?>
