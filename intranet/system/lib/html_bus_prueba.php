<?php
class html_bus_prueba extends f{
	private $baseurl = "";

	function html_bus_prueba(){
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
                fieldset {
                    border: 1px solid #ddd !important;
                    margin: 0;
                    xmin-width: 0;
                    padding: 10px;       
                    position: relative;
                    border-radius:4px;
                    background-color:#f5f5f5;
                    padding-left:10px!important;
                }   
                legend{
                    font-size:14px;
                    font-weight:bold;
                    margin-bottom: 0px; 
                    width: 35%; 
                    border: 1px solid #ddd;
                    border-radius: 4px; 
                    padding: 5px 5px 5px 10px; 
                    background-color: #ffffff;
                }
                .td_a{
                    width: 50px;
                    height: 50px;
                }
                .td_a > span{
                    width: 100%;
                    height: 100%;
                }
            </style>
            <div class="container-fluid" style="margin-top: 56px;">
                <div class="row">
                    <div class="col-12 col-md-12">
                        <h5 class="">
                            <i class="fa fa-bars" aria-hidden="true"></i> Venta de Boletos
                        </h5>
                        <hr>         
                        <div class="container" style="max-width: 100%;">
                            <div class="row col-md-12">
                                <div class="row col-md-10">
                                    <div class="col-md-2">
                                        <label>Origen</label>
                                        <select class="form-control">
                                            <option>Arequipa</option>
                                            <option>Lima</option>
                                            <option>Ica</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Parada</label>
                                        <select class="form-control">
                                            <option>-</option>
                                            <option>Lima</option>
                                            <option>Ica</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Destino</label>
                                        <select class="form-control">
                                            <option>Arequipa</option>
                                            <option>Lima</option>
                                            <option>Ica</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>F. y H. Salida</label>
                                        <input type="text" class="form-control datepicker">
                                    </div>
                                    <!--<div class="col-md-2">
                                        <label>F. Salida</label>
                                        <input type="text" class="form-control datepicker">
                                    </div>
                                    <div class="col-md-2">
                                        <label>H. Salida</label>
                                        <input type="text" class="form-control datetimepicker">
                                    </div>-->
                                    <div class="col-md-2">
                                        <label>Precio</label>
                                        <input type="text" class="form-control" value="30">
                                    </div>
                                </div>
                                <div class="row col-md-2">
                                    <button class="btn btn-info">+</button>
                                    <button class="btn btn-info">-</button>
                                </div>
                            </div>
                            <hr>
                            <div class="row col-md-12" style="margin-top: 25px;">
                                <div class="col-md-8">
                                    <label>Piso</label>
                                    <select class="form-control">
                                        <option value="0">Piso 1</option>
                                        <option value="1">Piso 2</option>
                                    </select>
                                    <h3 style="margin-top: 10px; margin-bottom: 10px;">Detalle de Asientos - Piso 1</h3>
                                    <table calss="table" style="margin-top: 15px;" id="tabla_asientos">
                                        <tr>
                                            <td class="td_a"><span class="btn btn-success btn-sm">3</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">7</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">11</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">15</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">19</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">23</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">27</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">31</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">35</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">39</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">43</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">47</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">51</span></td>
                                        </tr>
                                        <tr>
                                            <td class="td_a"><span class="btn btn-success btn-sm">4</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">8</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">12</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">16</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">20</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">24</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">28</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">32</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">36</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">40</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">44</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">48</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">52</span></td>
                                        </tr>
                                        <tr>
                                            <td class="td_a"><span class="btn btn-success btn-sm">  </span></td>
                                        </tr>
                                        <tr>
                                            <td class="td_a"><span class="btn btn-success btn-sm">2</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">6</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">10</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">14</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">18</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">22</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">26</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">30</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">34</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">38</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">42</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">46</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">50</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">54</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">58</span></td>
                                        </tr>
                                        <tr>
                                            <td class="td_a"><span class="btn btn-success btn-sm">1</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">5</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">9</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">13</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">17</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">21</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">25</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">29</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">33</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">37</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">41</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">45</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">49</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">53</span></td>
                                            <td class="td_a"><span class="btn btn-success btn-sm">55</span></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-4">
                                    <fieldset style="margin-top: 10px;">
                                        <legend>
                                            Datos Pasajero
                                        </legend>
                                        <label>DNI</label>
                                        <input type="text" class="form-control">
                                        <label>NOMBRE</label>
                                        <input type="text" class="form-control">
                                    </fieldset>
                                    <fieldset style="margin-top: 10px;">
                                        <legend>
                                            Datos Vehiculo
                                        </legend>
                                        <label>Modelo</label>
                                        <input type="text" class="form-control">
                                        <label>Asientos</label>
                                        <input type="text" class="form-control">
                                        <label>Modelo</label>
                                        <input type="text" class="form-control">
                                    </fieldset>
                                    <fieldset style="margin-top: 10px; text-align: center;">
                                        <legend style="white-space: nowrap; width: auto;">
                                            Imprimir Manifiesto
                                        </legend>
                                        <button class="btn btn-secondary"><i class="fa fa-print"></i></button>
                                    </fieldset>
                                </div>
                            </div>
                            <hr>
                            <div class="row col-md-12" style="margin-top: 25px;">
                                <button class="btn btn-primary" style="margin-right: 10px; margin-left: auto;">Guardar</button>
                                <button class="btn btn-danger">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/jquery.datetimepicker.full.min.js"></script>
            <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/build/jquery.datetimepicker.min.css" rel="stylesheet"/>
            <script>
                $(document).ready(function() {
                    $(".datepicker").datetimepicker({
                        format: "Y-m-d H:00",
                        //timepicker:false
                    });
                    $(".datetimepicker").datetimepicker({
                        timeFormat: "HH:mm:ss",
                        datepicker:false
                    });
                    $.datetimepicker.setLocale("es");
                });
            </script>';     
            return $r;
        }
    }
?>
