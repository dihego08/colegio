<?php
class html_gastos extends f
{
    private $baseurl = "";

    function html_gastos()
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
                    <span style="float: right; margin-bottom: 10px;" class="btn btn-outline-success" data-toggle="modal" data-target="#formulario" id="btn_nuevo" onclick="nuevo();">Nuevo</span>
                    <h5 class=""><i class="fa fa-bars" aria-hidden="true"></i> Lista de Gastos</h5>
                    <small><i class="fa fa-edit"></i> Aquí podrá ver la informacion necesaria de los gastos</small>
         
                    <div class="container">
                        <div class="row">
                            <div class="col-12" >
                                <div class="table-responsive">
                                    <table  class="datatable table table-striped table-bordered dt-responsive nowrap" style="width:100%">
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
                                                <th>Categoria</th>
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
        </div>


            

            <!----------------------------------------------------------------------->
            <div class="modal fade" id="formulario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="max-width: 80%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLabel">Nueva Aula</h3>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group" style="width: 100%;">
                                <input type="hidden" name="id">
                                <div class="form-group row">
                                <label for="" class="col-4 ">Fecha:</label>
                                <div class="col-8">
                                    <input class="form-control form-control-sm fechas_ui" type="text" name="fecha" id="fecha" autocomplete="off" value="2019-08-27" readonly required>
                                </div>
                                </div>
                                <div class="form-group row">
                                <label for="" class="col-4 ">C. Total:</label>
                                <div class="col-8">
                                    <input class="form-control form-control-sm" type="number" name="costo_total" id="costo_total" placeholder="Ingrese la costo total" step="any">
                                </div>
                                </div>
                                
                                <div class="form-group row">
                                <label for="" class="col-4 ">Descripción:</label>
                                <div class="col-8">
                                    <input class="form-control form-control-sm" type="text" name="descripcion" id="descripcion" placeholder="Ingrese la Descripción">
                                </div>
                                </div>
                    
                                <div class="form-group row">
                                <label for="" class="col-4 ">Categoría:</label>
                                <div class="col-8">
                                    <select class="form-control form-control-sm" name="categoria" id="categoria" required>
                                        <option value="" selected>Seleccione Categoria</option>
                                        <option value="Prestamos de Gerencia">Prestamos de Gerencia</option>
                                        <option value="Pago de Servicios">Pago de Servicios</option>
                                        <option value="Pago a Proveedores">Pago a Proveedores</option>
                                        <option value="Compra de Productos">Compra de Productos</option>
                                        <option value="Gastos de Colaboradores">Gastos de Colaboradores</option>
                                        <option value="Gastos Varios">Gastos Varios</option>
                                        <option value="Compras Varias">Compras Varias</option>
                                    </select>
                    
                                </div>
                                </div>
                                <div class="form-group row">
                                <label for="" class="col-4 ">Documento:</label>
                                <div class="col-8">
                                    <select class="form-control form-control-sm" name="documento" id="documento" required>
                                        <option value="" selected>Seleccione</option>
                                        <option value="Boleta">Boleta</option>
                                        <option value="Factura">Factura</option>
                                        <option value="Nota de credito">Nota de Credito</option>
                                        <option value="Nota de credito">Nota de Credito</option>
                                        <option value="Ticket">Ticket</option>
                                        <option value="Recibo de servicios publicos">Recibo de S. P.</option>
                                        <option value="Documentos Bancarios y de seguro">Documentos Bancarios y de seguro</option>
                                        <option value="Recibo de Caja">Recibo de Caja</option>
                                    </select>
                                </div>
                                </div>
                                <div class="form-group row">
                                <label for="" class="col-4 ">Serie:</label>
                                <div class="col-8">
                                    <input class="form-control form-control-sm" type="text" name="serie" id="serie" placeholder="Ingrese serie">
                                </div>
                                </div>
                                <div class="form-group row">
                                <label for="" class="col-4 ">Correlativo:</label>
                                <div class="col-8">
                                    <input class="form-control form-control-sm" type="number" name="correlativo" id="correlativo" placeholder="Ingrese el correlativo">
                                </div>
                                </div>
                    
                                <div class="form-group row">
                                <label for="" class="col-4 ">Proveedor:</label>
                                <div class="col-8">
                                    <select class="form-control form-control-sm" name="proveedor" id="proveedor" >
                    
                                    </select>
                                </div>
                                </div>
                                
                                <div class="form-group row">
                                <label for="" class="col-4 ">Nota:</label>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm" name="nota" id="nota">
                                </div>
                                </div>
                                
                                <div class="form-group row">
                                <label for="" class="col-4 "></label>
                                <div class="col-8">
                                    <button class="btn btn-sm btn-dark" id="btn_utilizar">Modificar</button>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>
            <!----------------------------------------------------------------------->
         <script>
    $(document).ready(function() {
    
    $("#form_modificar").hide();
    
    listar_proveedores();
    //listar_usuarios();
    
    $(".fechas_ui").change(function() {
        table.ajax.reload();
        totales_gastos();

    });
    var table = $(".datatable").DataTable({
        "ajax": {
            url: "' . $this->baseurl . INDEX . 'gastos/loadgastos/",
            "dataSrc": "",
            
        },
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
        }, {
            "data": "categoria"
        }, {
            "defaultContent": "<button data-toggle=\"modal\" data-target=\"#formulario\" id=\"btn_editar\" class=\"btn btn-outline-warning btn-sm d-block\" ><i class=\"fa fa-pencil\"></i></button>"+"<button id=\"btn_eliminar\" class=\"btn btn-outline-danger btn-sm mt-1 d-block\"><i class=\"fa fa-trash\"></i></button>"
        }, ],
        "language": {
            "url": "' . $this->baseurl . 'includes/datatables/Spanish.json"
        },
        "lengthMenu": [
            [10, 15, 20, -1],
            [10, 15, 20, "All"]
        ],

        dom: "<\"row\"<\"col-12 col-sm-12 col-md-6\"l><\"col-12 col-sm-12 col-md-6\"f>>rt<\"top\"B><\"col-12\"i>p",
        "order": [
            [0, "desc"]
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
            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el gasto <strong>" + rowData["id"] + "</strong>?",
                function() {
                    eliminar(rowData["id"]);
                    alertify.notify("Se elimino el gasto <strong>" + rowData["id"] + "</strong> correctamente.", "custom-black", 4, function() {});
                },
                function() {
                    alertify.notify("Se cancelo la <strong>eliminaci贸n</strong>.", "custom-black", 4, function() {});
                }).set("labels", { ok: "Eliminar", cancel: "Cancelar" });
        } else {
            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "Desea eliminar el gasto <strong>" + data["id"] + "</strong>?",
                function() {
                    eliminar(data["id"]);
                    alertify.notify("Se elimino el gasto <strong>" + data["id"] + "</strong> correctamente.", "custom-black", 4, function() {});
                },
                function() {
                    alertify.notify("Se cancelo la <strong>eliminaci贸n</strong>.", "custom-black", 4, function() {});
                }).set("labels", { ok: "Eliminar", cancel: "Cancelar" });
        }
    });
    abrir_modal("modalmodificar", "<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Modificar Gasto");
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
    totales_gastos();
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
