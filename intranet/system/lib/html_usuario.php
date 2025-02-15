<?php
class html_usuario extends f{
	private $baseurl = "";

	function html_usuario(){
		$this->load()->lib_html("Table", false);
		$this->baseurl = BASEURL;
	}
    function container(){
        $r='
        <script>function abrir_modal(b,a){alertify.dialog(b,function(){return{main:function(c){this.setContent(c);},setup:function(){return{focus:{element:function(){return this.elements.body.querySelector(this.get("selector"));
        },select:true},options:{basic:false,title:a,maximizable:false,resizable:false,padding:true,modal:true,transition:false,}};},settings:{selector:undefined}};
        });}</script>
        
        <div class="container-fluid">
   <div class="row">
      <div class="col-12 col-md-3">
        
         <h5 class=""><i class="fa fa-bars" aria-hidden="true"></i> Nuevos Usuarios</h5>
         <small><i class="far fa-edit"></i>Aquí podrá agregar usuarios</small>
            <hr>
         <form id="form_agregar" action="'. $this->baseurl . INDEX . 'usuario/save" method="post">

            
             <div class="form-group row">
               <label for="" class="col-4 ">Level</label>
               <div class="col-8">
                  <select class="form-control form-control-sm" name="level" required >
                     <option value="" selected>Seleccione</option>
                     <option value="0">Bloqueado</option>
                     <option value="1">Cajero</option>
                     <option value="3">Administrador</option>
                  </select>
               </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-4">Ubicación :</label>
                <div class="col-8">
                    <select class="form-control form-control-sm select2-single" name="ubicacion" >
                        <option value="" disabled selected>Seleccione una ubicacion</option>
        
                    </select>
                </div>
            </div>
            <div class="form-group row">
               <label for="" class="col-4 ">Nombres:</label>
               <div class="col-8">
                  <input class="form-control form-control-sm" type="text" name="fullname" placeholder="Ingrese nombres">
               </div>
            </div>

            
            <div class="form-group row">
               <label for="" class="col-4 ">Email:</label>
               <div class="col-8">
                  <input class="form-control form-control-sm" type="email" name="email" placeholder="Ingrese correo">
               </div>
            </div>

            <div class="form-group row">
               <label for="" class="col-4 ">Contraseña:</label>
               <div class="col-8">
                  <input id="contrasenia" class="form-control form-control-sm" type="password" name="passt" placeholder="Ingrese contraseña">
               </div>
            </div>
             <div class="form-group row">
               <label for="" class="col-4 ">Repetir Contraseña:</label>
               <div class="col-8">
                  <input id="contraseniarepetida" class="form-control form-control-sm" type="password" placeholder="Repetir contraseña">
               </div>
            </div>

            <div class="form-group row">
               <label for="" class="col-4 "></label>
               <div class="col-8">
                  <button class="btn btn-sm btn-dark">Agregar</button>
               </div>
            </div>
         </form>
      </div>
      <div class="col-12 col-md-9">
         <h5 class=""><i class="fa fa-bars" aria-hidden="true"></i> Lista de Usuarios</h5>
         <small><i class="far fa-edit"></i> Aquí podrá ver la informacion necesaria de los usuarios</small>
         
         <div class="container">
            <div class="row">
               <div class="col-12" >
<div class="row">
           </div>
                   <table  class="datatable table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                     <thead>
                        <tr>
                          <th>#</th>
                          <th>Nombre</th>
                          <th>Email </th>
                          <th>Level </th>
                          <th>Ubicación</th>
                          <th>Editar</th>
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
</div>


    </body>
</html>

         <form id="form_modificar" action="'. $this->baseurl . INDEX . 'usuario/editarBD" method="post">
            <input type="hidden" name="id">  
             <div class="form-group row">
               <label for="" class="col-4 ">Level</label>
               <div class="col-8">
                  <select class="form-control form-control-sm" name="level" required >
                     <option value="" selected>Seleccione</option>
                     <option value="0">Bloqueado</option>
                     <option value="1">Cajero</option>
                     <option value="3">Administrador</option>
                  </select>
               </div>
            </div>
            
            <div class="form-group row">
                <label for="" class="col-4">Ubicación :</label>
                <div class="col-8">
                    <select class="form-control form-control-sm select2-single" name="ubicacion" >
                        <option value="" disabled selected>Seleccione una ubicacion</option>
            
                    </select>
                </div>
            </div>
            
            <div class="form-group row">
               <label for="" class="col-4 ">Nombres:</label>
               <div class="col-8">
                  <input class="form-control form-control-sm" type="text" name="fullname" placeholder="Ingrese nombres">
               </div>
            </div>

            
            <div class="form-group row">
               <label for="" class="col-4 ">Email:</label>
               <div class="col-8">
                  <input class="form-control form-control-sm" type="email" name="email" placeholder="Ingrese correo">
               </div>
            </div>

            <div class="form-group row">
               <label for="" class="col-4 ">Contraseña:</label>
               <div class="col-8">
                  <input id="contrasenia" class="form-control form-control-sm" type="password" name="passt" placeholder="Ingrese contraseña">
               </div>
            </div>
             <div class="form-group row">
               <label for="" class="col-4 ">Repetir Contraseña:</label>
               <div class="col-8">
                  <input id="contraseniarepetida" class="form-control form-control-sm" type="password" placeholder="Repetir contraseña">
               </div>
            </div>

            <div class="form-group row">
               <label for="" class="col-4 "></label>
               <div class="col-8">
                  <button class="btn btn-sm btn-dark">Agregar</button>
               </div>
            </div>
         </form>
           
         <script>
         function ubicaciones() {
                $.ajax({
                    url: "' . $this->baseurl . INDEX . 'ubicacion/mostrar_select",
                    type: "POST",
                    dataType: "html",
                    success: function(data) {
                        $("select[name = ubicacion]").append(data);
                    }
                });
        }
            $(document).ready(function() {
    ubicaciones();
    $("#form_modificar").hide();
    
    
    $(".fechas_ui").change(function() {
        table.ajax.reload();
        totales_gastos();

    });
    var table = $(".datatable").DataTable({
        "ajax": {
            url: "' . $this->baseurl . INDEX . 'usuario/loadusuario/",
            "dataSrc": "",
            
        },
        "columns": [{
            "data": "id_user"
        }, {
            "data": "fullname"
        }, {
            "data": "email"
        }, {
            "data": "level"
        }, {
            "data": "ubicacion"
        }, {
            "defaultContent": "<button id=\"btn_editar\" class=\"btn btn-info btn-sm\" ><i class=\"fas fa-pencil-alt\"></i></button>"
        }, {
            "defaultContent": "<button id=\"btn_eliminar\" class=\"btn btn-danger btn-sm\"><i class=\"far fa-trash-alt\"></i></button>"
        }, ],
        "language": {
            "url": "'.$this->baseurl.'includes/datatables/Spanish.json"
        },
        "lengthMenu": [
            [10, 15, 20, -1],
            [10, 15, 20, "All"]
        ],

        dom: "<\"row\"<\"col-12 col-sm-12 col-md-6\"l><\"col-12 col-sm-12 col-md-6\"f>>rt<\"top\"B><\"col-12\"i>p",
        "order": [
            [0, "asc"]
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
            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el usuario <strong>" + rowData["fullname"] + "</strong>?",
                function() {
                    eliminar(rowData["id_user"]);
                    alertify.notify("Se elimino el usuario <strong>" + rowData["fullname"] + "</strong> correctamente.", "custom-black", 4, function() {});
                },
                function() {
                    alertify.notify("Se cancelo la <strong>eliminacion</strong>.", "custom-black", 4, function() {});
                }).set("labels", { ok: "Eliminar", cancel: "Cancelar" });
        } else {
            alertify.confirm("<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Eliminar", "¿Desea eliminar el usuario <strong>" + data["fullname"] + "</strong>?",
                function() {
                    eliminar(data["id_user"]);
                    alertify.notify("Se elimino el usuario <strong>" + data["fullname"] + "</strong> correctamente.", "custom-black", 4, function() {});
                },
                function() {
                    alertify.notify("Se cancelo la <strong>eliminaci贸n</strong>.", "custom-black", 4, function() {});
                }).set("labels", { ok: "Eliminar", cancel: "Cancelar" });
        }
    });
    abrir_modal("modalmodificar", "<i class=\"fa fa-bars\" aria-hidden=\"true\"></i> Modificar Usuario");
    $(".datatable tbody").on("click", "#btn_editar", function() {
        var data = table.row($(this).parents("tr")).data();
        if (data == undefined) {
            var selected_row = $(this).parents("tr");
            if (selected_row.hasClass("child")) {
                selected_row = selected_row.prev();
            }
            var rowData = $(".datatable").DataTable().row(selected_row).data();
            editar(rowData["id_user"]);
        } else {
            editar(data["id_user"]);
        }
    });
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
        var c1 = $("#contrasenia").val();
        var c2 = $("#contraseniarepetida").val();
        
        if(c1!=c2){
            alertify.notify("Ingrese contraseñas <strong>iguales</strong>.", "custom-black", 4, function() {});
            return;
        }
        
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
                if(data == 1){
                f[0].reset();
                $("#form_agregar input[name=fecha]").focus();
                table = $(".datatable").DataTable();
                table.ajax.reload();
                alertify.notify("Se agrego el <strong>Usuario</strong> correctamente.", "custom-black", 4, function() {})
                }else{
                    alertify.notify("El usuario <strong>ya existe</strong>.", "custom-black", 4, function() {})
                    f[0].reset();
                }
            },
            error: function() {},
        });
    });
});

function eliminar(id) {
    $.ajax({
        url: "' . $this->baseurl . INDEX . 'usuario/eliminar/",
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
    $("#form_modificar").show();
    alertify.modalmodificar($("#form_modificar")[0]);
    $.ajax({
        url: "' . $this->baseurl . INDEX . 'usuario/editar/",
        type: "POST",
        dataType: "json",
        data: {
            "id": id,
        },
        success: function(data) {
            var form = $("#form_modificar");
            form.find("input[name=id]").val(data[0].id_user);
            form.find("select[name=level]").val(data[0].level);
            form.find("select[name=ubicacion]").val(data[0].id_ubicacion);
            form.find("input[name=fullname]").val(data[0].fullname);
            form.find("input[name=email]").val(data[0].email);
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
        var c1 = $("#contrasenia").val();
        var c2 = $("#contraseniarepetida").val();
        
        if(c1!=c2){
            alertify.notify("Ingrese contraseñas <strong>iguales</strong>.", "custom-black", 4, function() {});
            return;
        }
        
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
                alertify.notify("<strong>Usuario</strong> modificado correctamente.", "custom-black", 3, function() {});
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
?>
