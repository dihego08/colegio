<?php
    
class html_informe extends f{
    private $baseurl = "";

    function html_informe(){
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
                .bold{
                    font-weight: bold;
                }
                @media print {
                    .hideprint {
                        visibility: hidden;
                    }
                    .main-panel {
                        width: 100% !important;
                    }
                }
            </style>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Seleccionar Alumno
                        </h5>
                        <small>
                            <i class="fa fa-edit"></i> Seleccionar Alumno para cargar el reporte de asistencias y notas.
                        </small>
                        <div class="form-row">
                            <div class="col-md-6">
                                <label>Alumno</label>
                                <select class="form-control mt-2 mb-1" id="id_alumno">
                                    <option value="-1">--SELECCIONAR--</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Fecha Desde</label>
                                <input type="text" class="form-control datepicker" id="fecha_desde">
                            </div>
                            <div class="col-md-12 mt-3">
                                <button class="btn btn-primary w-100 hideprint" onclick="realizar_busqueda();">Ver Asistencias</button>
                            </div>
                        </div>
                        
                        <hr>         
                        <div class="container">
                            <!--<button class="btn btn-info hideprint" onclick="window.print()">Imprimir</button>-->
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="tabla-notas-informe" class="datatable table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Alumno</th>
                                                <th>Examen</th>
                                                <th>Fecha</th>
                                                <th>Puntaje</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                                <div class="col-md-12">
                                    <div id="calendar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <link rel="stylesheet" href="system/lib/style_cal.css">
            <script type="text/javascript" src="system/lib/calendarize.js"></script>
            <script>
                function llenar_alumnos(){
                    $.post("' . $this->baseurl . INDEX . 'alumnos/get_alumnos/", function(response){
                        var obj = JSON.parse(response);

                        $.each(obj, function(index, val){
                            $("#id_alumno").append(`<option value="${val.id}">${val.nombres} ${val.apellidos}</option>`);
                        });
                    });
                }
                function dateRange(startDate, endDate) {
                    var start      = startDate.split("-");
                    var end        = endDate.split("-");
                    var startYear  = parseInt(start[0]);
                    var endYear    = parseInt(end[0]);
                    var dates      = [];

                    for(var i = startYear; i <= endYear; i++) {
                        var endMonth = i != endYear ? 11 : parseInt(end[1]) - 1;
                        var startMon = i === startYear ? parseInt(start[1])-1 : 0;
                        for(var j = startMon; j <= endMonth; j = j > 12 ? j % 12 || 11 : j+1) {
                            var month = j+1;
                            var displayMonth = month < 10 ? "0"+month : month;
                            //dates.push([i, displayMonth, "01"].join("-"));
                            //new Date();
                            //console.log(displayMonth);
                            $("#m_"+(month - 1)).removeAttr("hidden");
                        }
                    }
                    return dates;
                }
                function realizar_busqueda(){
                    var t = $("#fecha_desde").val().split("-");
                    var d = new Date(t[0], t[1], 0);
                    console.log($("#fecha_desde").val()+"-1");
                    console.log($("#fecha_desde").val()+"-"+d.getDate());
                    dateRange($("#fecha_desde").val()+"-1", $("#fecha_desde").val()+"-"+d.getDate())
                	$(".day").removeClass("table-success");
                	$(".day").removeClass("table-danger");
                	$(".day").find("span").remove();
                    $(".month").attr("hidden", "hidden");

                    dateRange($("#fecha_desde").val()+"-1", $("#fecha_desde").val()+"-"+d.getDate());

                    $.get("' . $this->baseurl . INDEX . 'informe/loadnotas/",{
                        id_alumno: $("#id_alumno").val(),
                        fecha_desde: $("#fecha_desde").val(),
                        fecha_hasta: $("#fecha_hasta").val(),
                    }, function(response){
                        var obj = JSON.parse(response);
                        var now = new Date();
						var daysOfYear = [];
						for (var d = new Date($("#fecha_desde").val()); d <= new Date($("#fecha_hasta").val()); d.setDate(d.getDate() + 1)) {
						    $("#"+new Date(d).getFullYear()+"-"+String(parseInt(new Date(d).getMonth() + 1)).padStart(2, "0")+"-"+String(new Date(d).getDate()).padStart(2, "0")).addClass("table-danger");
						    $("#"+new Date(d).getFullYear()+"-"+String(parseInt(new Date(d).getMonth() + 1)).padStart(2, "0")+"-"+String(new Date(d).getDate()).padStart(2, "0")).append(`
						    	<span class="badge badge-danger">FALTA</span>
						    `);
						}

                        $.each(obj.asistencias_1, function(index, val){
                            $("#"+val.fecha).find("span").remove();
                            $("#"+val.fecha).append(`
                                <span class="badge badge-info">${val.hora == null ? "": "Plat. " + val.hora}</span>
                                <span class="badge badge-info">${val.hora_2 == null ? "":"Plat. " + val.hora_2}</span>
                            `);
                            $("#"+val.fecha).addClass("table-success");
                            $("#"+val.fecha).removeClass("table-danger");

                            $("#"+val.fecha+" p").first().addClass("mb-0");
                        });

                        $.each(obj.asistencias_2, function(index, val){

                            if($("#"+val.fecha).attr("class") == "day past table-success"){
                                $("#"+val.fecha).append(`
                                    <span class="badge badge-dark">${val.hora == null ? "": "Pres. " + val.hora}</span>
                                `);
                            }else{
                                if($("#"+val.fecha).find("span").text() == "FALTA"){
                                    $("#"+val.fecha).find("span").remove();
                                }

                                $("#"+val.fecha).append(`
                                    <span class="badge badge-dark">${val.hora == null ? "": "Pres. " + val.hora}</span>
                                `);

                                $("#"+val.fecha).addClass("table-success");
                                $("#"+val.fecha).removeClass("table-danger");

                                $("#"+val.fecha+" p").first().addClass("mb-0");
                            }
                            
                            
                        });
                        $("#tabla-notas-informe").find("tbody").empty();
                        $.each(obj.notas, function(index, val){
                            var f = val.fecha_examen.split(" ");
                            $("#tabla-notas-informe").find("tbody").append(`<tr>
                            <td>${val.alumno}</td>
                            <td>${val.identificador}</td>
                            <td>${f[0]}</td>
                            <td>${val.examen}</td>
                        </tr>`);
                        });
                    });
                }
                $(document).ready(function() {
                    var $calendar = document.getElementById("calendar");
                    var currentYear = new Date().getFullYear();
                    var calendarize = new Calendarize();
                    calendarize.buildYearCalendar($calendar, currentYear);

                    $( ".datepicker" ).datetimepicker({
                        format: "Y-m",
                        timepicker:false,
                        daypicker:false
                    });
                    $.datetimepicker.setLocale(\'es\');
                    llenar_alumnos();
                    
                    $("#id_alumno").select2();
                });
            </script>';     
            return $r;
        }
    }
?>
