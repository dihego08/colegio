<?php
class html_postulaciones extends f{
	private $baseurl = "";

	function html_postulaciones(){
		$this->load()->lib_html("Table", false);
		$this->baseurl = BASEURL;
	}
    function container(){
        $r = '<div class="container-fluid" style="margin-top: 56px;">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Lista de Postulaciones
                        </h5>
                        <small>
                            <i class="far fa-edit"></i> Aquí podrá ver la información de todas las Postulaciones
                        </small>
                        <hr>         
                        <div class="container" style="max-width: 100%;">
                            <div class="row">
                                <div class="col-12" >
                                    <table  class="datatable table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Nombres</th>
                                                <th>Celular</th>
                                                <th>Correo</th>
                                                <th>Nacionalidad</th>
                                                <th>Video</th>
                                                <th>Temas</th>
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
                            url: "' . $this->baseurl . INDEX . 'postulaciones/loadpostulaciones/",
                            "dataSrc": ""
                        },
                        "columns": [{
                            "data": "id"
                        }, {
                            "data": "nombres"
                        }, {
                            "data": "celular"
                        }, {
                            "data": "correo"
                        }, {
                            "data": "nacionalidad"
                        }, {
                            "data": "video",
                            "render": function(data){
                                return "<a href=\""+data+"\" target=\"_blank\">"+data+"</a>"
                            }
                        }, {
                            "data": "temas"
                        }, ],
                        "language": {
                            "url": "'.$this->baseurl.'includes/datatables/Spanish.json"
                        },
                        "lengthMenu": [
                            [10, 15, 20, -1],
                            [10, 15, 20, "All"]
                        ]
                    });
                });
            </script>';     
            return $r;
        }
    }
?>
