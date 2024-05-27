<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<!--<script type="text/javascript" src="<?php echo base_url();?>assets/js/highcharts.js"></script>-->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/json2.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/modules/exporting.js"></script>
<script type="text/javascript">

	var chart;

	// Construye los graficos
	function buildCharts() {
		$('#datos').hide(); 
    	$('#salida').show(); 
		
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/siniestros/getStats",
			data: ({fd : $("#fd").val(), fh : $("#fh").val() }),
			success: function(datos){
				//alert(datos);
				var myJSONObject =  JSON.parse(datos);

				// Arreglo con datos para los graficos de barra
				var arregloBarra = new Array();
				for(var j=0; j<12; j++){
					var categorias='';
					for(var data in myJSONObject[j]) {
						categorias += data+', ';	
					}
					var serie='';
					for(var data in myJSONObject[j]) {
						serie += myJSONObject[j][data]+', ';	
					}
					arregloBarra[j] = {'categorias':categorias.substring(0, categorias.length-2), 'serie':serie.substring(0, serie.length-2)}
				}
				
				// Arreglo con datos para los graficos de torta
				var arregloTorta = new Array();
				for(var j=0; j<16; j++){
					var subarreglo = new Array();
					var i=0;
					for(var data in myJSONObject[j]) {
						subarreglo[i] = [data, myJSONObject[j][data]];	
						i++;
					}
					arregloTorta[j] = subarreglo;
				}
				
				//Creo 
				crearGraficoBarras2('container0',arregloBarra[0].categorias,arregloBarra[0].serie, arregloBarra[1].serie);
				crearGraficoTorta('container1',arregloTorta[2]);
				crearGraficoTorta('container2',arregloTorta[3]);
				crearGraficoBarras1('container3',arregloBarra[4].categorias,arregloBarra[4].serie);
				crearGraficoTorta('container4',arregloTorta[5]);
				crearGraficoTorta('container5',arregloTorta[6]);
				crearGraficoBarras1('container6',arregloBarra[7].categorias,arregloBarra[7].serie);
				crearGraficoTorta('container7',arregloTorta[8]);
				crearGraficoTorta('container8',arregloTorta[9]);
				crearGraficoTorta('container9',arregloTorta[10]);
				crearGraficoTorta('container10',arregloTorta[11]);
				crearGraficoTorta('container12',arregloTorta[13]);
				crearGraficoTorta('container13',arregloTorta[14]);
				$('#datos').show(); 
        		$('#salida').hide(); 
			}
		});
	}

	function crearGraficoBarras2(divId, categorias, serie1, serie2){
		serieArray = serie1.split(",");
		for(var j=0; j<serieArray.length; j++){
			serieArray[j]=parseInt(serieArray[j]);
			
		}
		serieArray2 = serie2.split(",");
		for(var j=0; j<serieArray2.length; j++){
			serieArray2[j]=parseInt(serieArray2[j]);
			
		}
		
		categoriaArray = categorias.split(",");
		chart = new Highcharts.Chart({
			chart: {
				renderTo: divId,
				defaultSeriesType: 'line'
			},
			title: {
				text: ''
			},
			subtitle: {
				text: ''
			},
			xAxis: {
				categories: categoriaArray
			},
			yAxis: {
				min: 0,
				title: {
					text: ''
				}
			},
			legend: {
				layout: 'vertical',
				backgroundColor: '#FFFFFF',
				align: 'left',
				verticalAlign: 'top',
				x: 100,
				y: 70,
				floating: true,
				shadow: true
			},
			tooltip: {
				formatter: function() {
					return ''+
						this.x +': '+ this.y +'';
				}
			},
			plotOptions: {
				column: {
					pointPadding: 0.2,
					borderWidth: 0
				}
			},
		    series: [{
				name: 'Siniestros',
				data: serieArray
		
			},
			{
				name: 'Implicados',
				data: serieArray2
		
			}]
		
		});
	}
	
	function crearGraficoBarras3(divId, categorias, serie1, serie2, serie3){
		serieArray = serie1.split(",");
		for(var j=0; j<serieArray.length; j++){
			serieArray[j]=parseInt(serieArray[j]);
			
		}
		serieArray2 = serie2.split(",");
		for(var j=0; j<serieArray2.length; j++){
			serieArray2[j]=parseInt(serieArray2[j]);
			
		}
		serieArray3 = serie3.split(",");
		for(var j=0; j<serieArray3.length; j++){
			serieArray3[j]=parseInt(serieArray3[j]);
			
		}
		categoriaArray = categorias.split(",");
		chart = new Highcharts.Chart({
			chart: {
				renderTo: divId,
				defaultSeriesType: 'column'
			},
			title: {
				text: ''
			},
			subtitle: {
				text: ''
			},
			xAxis: {
				categories: categoriaArray
			},
			yAxis: {
				min: 0,
				title: {
					text: ''
				}
			},
			legend: {
				layout: 'vertical',
				backgroundColor: '#FFFFFF',
				align: 'left',
				verticalAlign: 'top',
				x: 100,
				y: 70,
				floating: true,
				shadow: true
			},
			tooltip: {
				formatter: function() {
					return ''+
						this.x +': '+ this.y +'';
				}
			},
			plotOptions: {
				column: {
					pointPadding: 0.2,
					borderWidth: 0
				}
			},
		    series: [{
				name: 'Nuevas',
				data: serieArray
		
			},
			{
				name: 'Anulaciones',
				data: serieArray2
		
			},
			{
				name: 'Renovaciones',
				data: serieArray3
		
			}]
		
		});
	}
	
	function crearGraficoBarras4(divId, categorias, serie1, serie2, serie3){
		serieArray = serie1.split(",");
		for(var j=0; j<serieArray.length; j++){
			serieArray[j]=parseInt(serieArray[j]);
			
		}
		serieArray2 = serie2.split(",");
		for(var j=0; j<serieArray2.length; j++){
			serieArray2[j]=parseInt(serieArray2[j]);
			
		}
		serieArray3 = serie3.split(",");
		for(var j=0; j<serieArray3.length; j++){
			serieArray3[j]=parseInt(serieArray3[j]);
			
		}
		categoriaArray = categorias.split(",");
		chart = new Highcharts.Chart({
			chart: {
				renderTo: divId,
				defaultSeriesType: 'column'
			},
			title: {
				text: ''
			},
			subtitle: {
				text: ''
			},
			xAxis: {
				categories: categoriaArray
			},
			yAxis: {
				min: 0,
				title: {
					text: ''
				}
			},
			legend: {
				layout: 'vertical',
				backgroundColor: '#FFFFFF',
				align: 'left',
				verticalAlign: 'top',
				x: 100,
				y: 70,
				floating: true,
				shadow: true
			},
			tooltip: {
				formatter: function() {
					return ''+
						this.x +': '+ this.y +'';
				}
			},
			plotOptions: {
				column: {
					pointPadding: 0.2,
					borderWidth: 0
				}
			},
		    series: [{
				name: 'Metal',
				data: serieArray
		
			},
			{
				name: 'Nativa',
				data: serieArray2
		
			},
			{
				name: 'LPS',
				data: serieArray3
		
			}]
		
		});
	}
	
	function crearGraficoBarras1(divId, categorias, serie1){
		serieArray = serie1.split(",");
		for(var j=0; j<serieArray.length; j++){
			serieArray[j]=parseInt(serieArray[j]);
			
		}
		categoriaArray = categorias.split(",");
		chart = new Highcharts.Chart({
			chart: {
				renderTo: divId,
				defaultSeriesType: 'column'
			},
			title: {
				text: ''
			},
			subtitle: {
				text: ''
			},
			xAxis: {
				categories: categoriaArray
			},
			yAxis: {
				min: 0,
				title: {
					text: ''
				}
			},
			legend: {
				layout: 'vertical',
				backgroundColor: '#FFFFFF',
				align: 'left',
				verticalAlign: 'top',
				x: 100,
				y: 70,
				floating: true,
				shadow: true
			},
			tooltip: {
				formatter: function() {
					return ''+
						this.x +': '+ this.y +'';
				}
			},
			plotOptions: {
				column: {
					pointPadding: 0.2,
					borderWidth: 0
				}
			},
		    series: [{
				name: 'Siniestros',
				data: serieArray
		
			}]
		
		});
	}
	
	function crearGraficoTorta(divId, datos){
		chart = new Highcharts.Chart({
			chart: {
				renderTo: divId,
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false
			},
			title: {
				text: ''
			},
			tooltip: {
				formatter: function() {
					return '<b>'+ this.point.name +'</b>: '+ this.y +' %';
				}
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer'
					
				}
			},
		    series: [{
				type: 'pie',
				name: 'Browser share',
				data: datos
			}]
		});
	}

	// llamar a la function para generar los graficos
	$(document).ready(function() {
		buildCharts();			
	});
	
</script>

<div id="content" class="col-xs-12 col-sm-10"> 
     
	<div class="row">
		<div id="breadcrumb" class="col-md-12">
			<a href="#" class="show-sidebar"><i class="fa fa-bars"></i></a>
			<ol class="breadcrumb">
				<li><a href="<?php echo site_url('/home/'); ?>">Inicio</a></li>
				<li><a href="<?php echo site_url('/siniestros'); ?>">Siniestros</a></li>
				<li><a href="#">Estad&iacute;sticas</a></li>
			</ol>
		</div>
	</div>  
        
	<!-- ********** FILTRO DE BUSQUEDA ****************** -->
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<div class="box-name ">
						<i class="fa fa-folder-open-o"></i>
						<span>Filtro de b&uacute;squeda</span>
					</div>
					<div class="box-icons">
						<a class="collapse-link" id="searchBoxLink"><i class="fa fa-chevron-up"></i></a>
						<a class="expand-link"><i class="fa fa-expand"></i></a>
						
					</div>
					<div class="no-move"></div>
				</div>
				<div class="box-content no-padding">
					<br>
					<?php echo form_open('siniestros/stats', array('id' => 'formSiniestrosStats', 'class'=> 'form-horizontal bootstrap-validator-form')); ?>
					<fieldset >
							<div class="form-group has-feedback"  >
								<label class="col-sm-1 control-label">Fecha:</label>
								<div class="col-sm-2">
									<input type="text" id="fd" class="form-control" name="fd" value="<?php if (isset($fd)){echo $fd;} ?>" >
									<span class="fa fa-calendar txt-danger form-control-feedback"></span>
								</div>
								<div class="col-sm-2">
									<input type="text" id="fh" class="form-control" name="fh" value="<?php if (isset($fh)){echo $fh;} ?>" >
									<span class="fa fa-calendar txt-danger form-control-feedback"></span>
								</div>
							</div>
					</fieldset>
					<div style="width:100%;text-align:left;padding:10px">
						<a href="#" onclick="$('#formSiniestrosStats').submit()">
							<button class="btn btn-primary btn-label-left" type="button">
								Buscar
							</button>
						</a>
						<a href="<?php echo site_url('/siniestros/stats'); ?>">
							<button class="btn btn-primary btn-label-left" type="button">
								Limpiar
							</button>
						</a>
					</div>
					<?php echo form_close(); ?>   
				</div>
			</div>
		</div>
	</div>
    
	<div class="row" id="salida">	<div class="col-xs-12 col-sm-12">Cargando, espere por favor... </div></div>

	<div class="row" id="datos">	
		<div class="col-xs-12 col-sm-12">
			<div class="box">
				<div class="box-header">
					<div class="box-name">
						<i class="fa fa-folder-open-o"></i>
						<span>Formulario de datos</span>
					</div>
					<div class="box-icons">
						<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
						<a class="expand-link"><i class="fa fa-expand"></i></a>
						
					</div>
					<div class="no-move"></div>
				</div>
				<div class="box-content no-padding">
					<br><br>
					<table style="width:100%" cellpadding="5" cellspacing="5">
						<tr>
							<td colspan="2">
								<div class="statTitle">Siniestros por mes</div>
								<div id="container1-1"><div id="container0" style="width: 100%; height: 300px; margin: 0 auto"></div></div>	
							</td>
						</tr>
						<tr>
							<td style="width:46%"> 
								<div class="statTitle">Siniestros por tipos</div>
								<div id="container1-1"><div id="container1" style="width: 100%; height: 250px; margin: 0 auto"></div></div>	
								
							</td>
							<td style="width:46%">
								<div class="statTitle">Implicados por edad</div>
								<div id="container1-1"><div id="container2" style="width: 100%; height:250px; margin: 0 auto"></div></div>				
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<div class="statTitle">Siniestros por calle</div>
								<div id="container1-1"><div id="container3" style="width: 100%; height: 300px; margin: 0 auto"></div></div>	
							</td>
						</tr>
						<tr>
							<td style="width:46%"> 
								<div class="statTitle">Siniestros por tipo de veh&iacute;culos</div>
								<div id="container1-1"><div id="container4" style="width: 100%; height: 250px; margin: 0 auto"></div></div>	
								
							</td>
							<td style="width:46%">
								<div class="statTitle">Implicados por lesiones</div>
								<div id="container1-1"><div id="container5" style="width: 100%; height:250px; margin: 0 auto"></div></div>				
							</td>
						</tr>
						<tr>
							<td style="width:46%"> 
								<div class="statTitle">Siniestros por horarios</div>
								<div id="container1-1"><div id="container6" style="width: 100%; height: 250px; margin: 0 auto"></div></div>	
							</td>
							<td style="width:46%">
								<div class="statTitle">Siniestros por causa</div>
								<div id="container1-1"><div id="container7" style="width: 100%; height: 250px; margin: 0 auto"></div></div>	
							</td>
						</tr>
						<tr>
							<td >
								<div class="statTitle">Siniestros por clima</div>
								<div id="container1-1"><div id="container10" style="width: 100%; height: 250px; margin: 0 auto"></div></div>	
							</td>
							<td style="width:46%">
								<div class="statTitle">Siniestros por tipo de calzada</div>
								<div id="container1-1"><div id="container9" style="width: 100%; height: 250px; margin: 0 auto"></div></div>	
							</td>
						</tr>
						<tr>
							<td style="width:46%"> 
								<div class="statTitle">Implicados por sexo</div>
								<div id="container1-1"><div id="container8" style="width: 100%; height: 250px; margin: 0 auto"></div></div>	
							</td>
							<td style="width:46%"> 
								<div class="statTitle">Uso del Casco</div>
								<div id="container1-1"><div id="container12" style="width: 100%; height: 250px; margin: 0 auto"></div></div>	
							</td>
						</tr>
						<tr>
							
							<td >
								<div class="statTitle">Uso del Cinturon</div>
								<div id="container1-1"><div id="container13" style="width: 100%; height: 250px; margin: 0 auto"></div></div>
							</td>
						</tr>
					</table>
					
				</div>
			</div>
		</div>
	</div>
	
</div>	
<script src="<?php echo base_url();?>assets/plugins/jquery/jquery-2.1.0.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#fd').datepicker({ dateFormat: "dd/mm/yy", altFormat: "yy-mm-dd",altField: "#fd" });
		$('#fh').datepicker({ dateFormat: "dd/mm/yy", altFormat: "yy-mm-dd",altField: "#fh" });

		$('#datos').hide(); 
        		
	});
</script>