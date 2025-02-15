<?php
class html_ingresos_gastos extends f
{
    private $baseurl = "";

    function html_ingresos_gastos()
    {
        $this->load()->lib_html("Table", false);
        $this->baseurl = BASEURL;
    }
    function container()
    {
        $r = '
        <script>function abrir_modal(b,a){alertify.dialog(b,function(){return{main:function(c){this.setContent(c);},setup:function(){return{focus:{element:function(){return this.elements.body.querySelector(this.get("selector"));
        },select:true},options:{basic:false,title:a,maximizable:false,resizable:false,padding:true,modal:true,transition:false,}};},settings:{selector:undefined}};
        });}</script>
        
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-12">
                    <h5 class=""><i class="fa fa-bars" aria-hidden="true"></i> Lista de Gastos e Ingresos</h5>
                    <small><i class="fa fa-edit"></i> Aquí podrá ver la informacion necesaria de los gastos e ingresos</small>
         
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Seleccionar Rango de Fechas</label>
                                <div class="form-row">
                                    <div class="col-md-6" >
                                        <input type="text" class="form-control datepicker" id="fecha_desde" value="'.date("Y-m-01").'">
                                    </div>
                                    <div class="col-md-6" >
                                        <input type="text" class="form-control datepicker" id="fecha_hasta" value="'.date("Y-m-t").'">
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <span class="btn btn-outline-success" id="btn-filtrar">Filtrar</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 text-center form-row">
                                <div class="col-md-6" id="div-ingresos"></div>
                                <div class="col-md-6" id="div-gastos"></div>
                            </div>
                            <hr class="w-100">
                            <div class="col-md-6" >
                            <h4 class="">Lista de Ingresos</h4>
                                <div class="table-responsive">
                                <table  class="datatable table dt-responsive nowrap table-ingresos" style="width:100%">
                                <thead>
                                    <tr>
                                    <th>Fecha</th>    
                                    <th>Alumno</th>
                                    <th>M. Pagado</th>
                                    <th>Concepto</th>
                                    <th>Mes</th>
                                    </tr>
                                </thead>
                            </table>
                                </div>
                            </div>
                            <div class="col-md-6">
                            <h4 class="">Lista de Pagos</h4>
                                <div class="table-responsive">
                                <table  class="datatable table table-striped table-bordered dt-responsive nowrap  table-gastos" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Fecha</th>
                                        <th>Documento</th>
                                        <th>Costo Total S/.</th>
                                        <th>Serie</th>
                                        <th>Correlativo</th>
                                        <th>Proveedor</th>
                                        <th>Descripción</th>
                                    </tr>
                                </thead>
                            </table>
                                </div>
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
         function filtrar(){

         }
    $(document).ready(function() {
        $( ".datepicker" ).datetimepicker({
            format: "Y-m-d",
            timepicker:false
        });
        var meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        $.datetimepicker.setLocale(\'es\');
    $("#form_modificar").hide();
    
    listar_proveedores();
    //listar_usuarios();
    
    $(".fechas_ui").change(function() {
        table.ajax.reload();
        totales_gastos();

    });
    $("#btn-filtrar").on("click", function(){
        table.ajax.reload();
        table2.ajax.reload();
    });
    
    var table = $(".table-gastos").DataTable({
        "ajax": {
            url: "' . $this->baseurl . INDEX . 'gastos/loadgastos_2/",
            data: function (d) {
                d.fecha_desde = $("#fecha_desde").val();
                d.fecha_hasta = $("#fecha_hasta").val();
            },
            "dataSrc": ""
        },
        dom: "Bfrtip",
        "columns": [{
            "data": "id"
        }, {
            "data": "fecha"
        }, {
            "data": "documento"
        }, {
            "data": "costo_total"
        },  {
            "data": "serie"
        },{
            "data": "correlativo"
        }, {
            "data": "proveedor"
        }, {
            "data": "descripcion"
        }, ],
        "language": {
            "url": "' . $this->baseurl . 'includes/datatables/Spanish.json"
        },
        "lengthMenu": [
            [10, 15, 20, -1],
            [10, 15, 20, "All"]
        ],
        buttons: [
            "excel"
        ],

        dom: "<\"row\"<\"col-12 col-sm-12 col-md-6\"l><\"col-12 col-sm-12 col-md-6\"f>>rt<\"top\"B><\"col-12\"i>p",
        "order": [
            [0, "desc"]
        ],
        "footerCallback": function (row, data, start, end, display) {                
            //Get data here 
            // console.log(data);
            //Do whatever you want. Example:
            var totalAmount = 0;
            for (var i = 0; i < data.length; i++) {
                // console.log(data[i].monto);
                totalAmount += parseFloat(data[i].costo_total);
            }
            console.log("EL TOTAL "+totalAmount);
            $("#div-gastos").empty();
            $("#div-gastos").append(`<span class="badge badge-danger" style="font-size: 16px;">INGRESOS: S/ ${parseFloat(totalAmount).toFixed(2)}</span>`);
        }
    });

    var total_ingresos
    var table2 = $(".table-ingresos").DataTable({
        "ajax": {
            url: "' . $this->baseurl . INDEX . 'pagos_2/loadpagos_2/",
            data: function (d) {
                d.fecha_desde = $("#fecha_desde").val();
                d.fecha_hasta = $("#fecha_hasta").val();
            },
            "dataSrc": ""
        },
        dom: "Bfrtip",
        order: [[ 0, "desc" ]],
        "columns": [{
            "data": "fecha"
        },{
            "data": "alumno"
        },  {
            "data": "monto",
            "render": function(data){
                total_ingresos += data;
                return `<span class="badge badge-success">S/ ${data}</span>`
            }
        }, {
            "data": "concepto",
            "render": function(data){
                return `<span class="" style="white-space: break-spaces;">${$.trim(data)}</span>`
            }
        }, {
            "data": "mes",
            "render": function(data){
                if(data > 0){
                    return `<span class="badge badge-danger">${meses[parseInt(data - 1)]}</span>`
                }else{
                    return ``;
                }
            }
        }, ],
        "language": {
            "url": "' . $this->baseurl . 'includes/datatables/Spanish.json"
        },
        buttons: [
            "excel"
        ],
        "lengthMenu": [
            [10, 15, 20, -1],
            [10, 15, 20, "All"]
        ],
        "footerCallback": function (row, data, start, end, display) {                
            //Get data here 
            // console.log(data);
            //Do whatever you want. Example:
            var totalAmount = 0;
            for (var i = 0; i < data.length; i++) {
                // console.log(data[i].monto);
                totalAmount += parseFloat(data[i].monto);
            }
            console.log("EL TOTAL "+totalAmount);
            $("#div-ingresos").empty();
            $("#div-ingresos").append(`<span class="badge badge-success" style="font-size: 16px;">INGRESOS: S/ ${parseFloat(totalAmount).toFixed(2)}</span>`);
        }
    });
    // console.log("EL TOTAL " + total_ingresos);
});


function listar_proveedores() {
    $.ajax({
        url: "' . $this->baseurl . INDEX . 'gastos/mostrar_proveedores/",
        success: function(data) {
            $("select[name=proveedor]").html(data);
        },
    });
}

function listar_usuarios() {
    $.ajax({
        url: "../Gastos/mostrar_empleados",
        success: function(data) {
            $("select[name=aprobado]").html(data);
        },
    });
}
$(function() {
    $("#form_agregar").on("submit", function(e) {
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
            success: function(data) {

                f[0].reset();
                $("#form_agregar input[name=fecha]").focus();
                table = $(".datatable").DataTable();
                table.ajax.reload();
                alertify.notify("Se agrego el <strong>Gasto</strong> correctamente.", "custom-black", 4, function() {})

            },
            error: function() {},
        });
    });
});

function eliminar(id) {
    $.ajax({
        url: "' . $this->baseurl . INDEX . 'gastos/eliminar/",
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

function editar(id) {
    // $("#form_modificar").show();
    // alertify.modalmodificar($("#form_modificar")[0]);
    $.ajax({
        url: "' . $this->baseurl . INDEX . 'gastos/editar/",
        type: "POST",
        dataType: "json",
        data: {
            "id": id,
        },
        success: function(data) {
            $("#fecha").val(data[0].fecha);
            $("#impuesto").val(data[0].impuesto);
            $("#costo_total").val(data[0].costo_total);
            $("#porcentaje_impuesto").val(data[0].porcentaje_impuesto);
            $("#descripcion").val(data[0].descripcion);
            $("#categoria").val(data[0].categoria);
            $("#documento").val(data[0].documento);
            $("#serie").val(data[0].serie);
            $("#correlativo").val(data[0].correlativo);
            $("#proveedor").val(data[0].proveedor);
            $("#nota").val(data[0].nota);

            $("#btn_utilizar").text("Modificar");
            $("#btn_utilizar").attr("onclick", "actualizar("+id+");");
        }
    });
}
function nuevo(){
	$("#form_editar").modal("show");
	$("#btn_utilizar").text("Guardar");
	$("#btn_utilizar").attr("onclick", "guardar();");
}
function guardar(){
    $.ajax({
        url: "' . $this->baseurl . INDEX . 'gastos/save/",
        type: "POST",
        dataType: "json",
        data: {
            fecha: $("#fecha").val(),
            costo_total: $("#costo_total").val(),
            porcentaje_impuesto: $("#porcentaje_impuesto").val(),
            descripcion: $("#descripcion").val(),
            categoria: $("#categoria").val(),
            documento: $("#documento").val(),
            serie: $("#serie").val(),
            correlativo: $("#correlativo").val(),
            proveedor: $("#proveedor").val(),
            nota: $("#nota").val(),
        },
        success: function(data) {
            $("#form_editar").modal("hide");
			alertify.notify("Se agrego el <strong>Gasto</strong> correctamente.", "custom-black", 4, function() {})
			table = $(".datatable").DataTable();
            table.ajax.reload();
        }
    });
}
function actualizar(id){
    $.ajax({
        url: "' . $this->baseurl . INDEX . 'gastos/editarBD/",
        type: "POST",
        dataType: "json",
        data: {
            id: id,
            fecha: $("#fecha").val(),
            costo_total: $("#costo_total").val(),
            porcentaje_impuesto: $("#porcentaje_impuesto").val(),
            descripcion: $("#descripcion").val(),
            categoria: $("#categoria").val(),
            documento: $("#documento").val(),
            serie: $("#serie").val(),
            correlativo: $("#correlativo").val(),
            proveedor: $("#proveedor").val(),
            nota: $("#nota").val(),
        },
        success: function(data) {
            $("#form_editar").modal("hide");
			alertify.notify("Se agrego el <strong>Gasto</strong> correctamente.", "custom-black", 4, function() {})
			table = $(".datatable").DataTable();
            table.ajax.reload();
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
                alertify.modalmodificar().close();
                alertify.notify("<strong>Gasto</strong> modificada correctamente.", "custom-black", 3, function() {});
            },
            error: function() {},
        });
    });
});

function totales_gastos() {

    fechainicio = $("input[name=fecha_inicio]").val();
    fechafinal = $("input[name=fecha_final").val();
    table = $(".datatable").DataTable();
    $.ajax({
        url: "../Gastos/mostrar_totales",
        type: "GET",
        data: {
            "fecha_inicio": fechainicio,
            "fecha_final": fechafinal,
        },
        dataType: "json",

        success: function(data) {
            table.row.add({
                "id": "[]",
                "fecha": "<strong>COSTO TOTAL :</strong>",
                "impuesto": "<strong>" + data.costo_total + "</strong>",
                "costo_total": "",
                "costo": "",
                "porcentaje_impuesto": "",
                "descripcion": "",
                "usuario": "",
                "razon": "",
                "categoria": "",
                "documento": "",
                "correlativo": "",
                "numero": "",
                "proveedor": "",
                "aprobado": "",
                "nota": "",
                "retiro": "",
                "condicion": "",
                "defaultContent": "",
                "defaultContent": "",


            }).draw();
            table.row.add({
                "id": "[]",
                "fecha": "<strong>Costo :</strong>",
                "impuesto": "<strong>" + data.costo + "</strong>",
                "costo_total": "",
                "costo": "",
                "porcentaje_impuesto": "",
                "descripcion": "",
                "usuario": "",
                "razon": "",
                "categoria": "",
                "documento": "",
                "correlativo": "",
                "numero": "",
                "proveedor": "",
                "aprobado": "",
                "nota": "",
                "retiro": "",
                "condicion": "",
                "defaultContent": "",
                "defaultContent": "",


            }).draw();


        }
    });
}

         </script>
         
         ';
        return $r;
    }
}
