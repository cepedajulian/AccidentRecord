<!--Start Content-->
<div id="content" class="col-xs-12 col-sm-10">

	<div class="row">
		<div id="breadcrumb" class="col-md-12">
			<a href="#" class="show-sidebar"><i class="fa fa-bars"></i></a>
			<ol class="breadcrumb">
				<li><a href="<?php echo site_url('/home/'); ?>">Inicio</a></li>
				<li>Siniestros</li>
			</ol>
		</div>
	</div>
	
	<?php echo form_open('siniestros/heatmap', array('id' => 'formSiniestros', 'class'=> 'form-horizontal bootstrap-validator-form')); ?>
	
	<div class="row">
		<div class="col-xs-12">
			<h3 class="page-header">Siniestros</h3>
			<br>
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
					<fieldset >
					
						<?php if (empty($id_ciudad)){?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Municipio</label>
							<div class="col-sm-4">
								<select id="id_ciudad" name="id_ciudad">
									<option value="">(Todas)</option>
									<?php foreach($ciudades as $ciudad){?>
									<option  value="<?php echo $ciudad->id; ?>" <?php if($ciudad->id == $criteria['id_ciudad']) echo "selected=selected"; ?>>
										<?php echo $ciudad->ciudad; ?>
									</option>
									<?php }?>
								</select>
							</div>
						</div>
						<?php }?>
						<div style="clear:both"></div>
						
						<div class="form-group has-feedback"  >
							<label class="col-sm-2 control-label">Tipo de siniestro</label>
							<div class="col-sm-4">
								<select id="tipoaccidente" name="tipoaccidente">
									<option value="">(Todos)</option>
									<?php foreach ($tipoaccidentes as $tipoaccidente){ ?>
									<option value="<?php echo $tipoaccidente->id; ?>" <?php if (!empty($criteria['tipoaccidente']) && $tipoaccidente->id==$criteria['tipoaccidente']) echo "selected=selected"; ?> >
										<?php echo utf8_decode($tipoaccidente->tipoaccidente); ?>
									</option>
								<?php }?>	
								</select>
							</div>
						</div>
						<div style="clear:both"></div>
						
						<div class="form-group has-feedback"  >
							<label class="col-sm-2 control-label">Fecha:</label>
							<div class="col-sm-2">
								<input type="text" id="fecha_desde" class="form-control" name="fecha_desde" value="<?php if (isset($criteria['fd'])){echo $criteria['fd'];} ?>" >
								<span class="fa fa-calendar txt-danger form-control-feedback"></span>
							</div>
							<div class="col-sm-2">
								<input type="text" id="fecha_hasta" class="form-control" name="fecha_hasta" value="<?php if (isset($criteria['fh'])){echo $criteria['fh'];} ?>" >
								<span class="fa fa-calendar txt-danger form-control-feedback"></span>
							</div>
						</div>
						

					</fieldset>
					<div style="width:100%;text-align:left;padding:20px">
						<a href="#" onclick="$('#formSiniestros').submit()">
							<button class="btn btn-primary btn-label-left" type="button">
								Buscar
							</button>
						</a>
						<a href="<?php echo site_url('/siniestros/'); ?>">
							<button class="btn btn-primary btn-label-left" type="button">
								Limpiar
							</button>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- ********** FIN FILTRO DE BUSQUEDA ****************** -->	
	
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<div class="box-name">
						<i class="fa fa-folder-open-o"></i>
						<span>Registro de Siniestros (<?php echo count($siniestros);?>)</span>
					</div>
					<div class="box-icons">
						<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
						<a class="expand-link"><i class="fa fa-expand"></i></a>
						
					</div>
					<div class="no-move"></div>
				</div>
				<div class="box-content no-padding">
					<div style="width:100%;text-align:left;padding:20px" id='nn'>
						
						<a href="#" onclick="alert('No disponible en demo')">
							<button class="btn btn-primary btn-label-left" type="button">
								Imprimir
							</button>
						</a>
						
						<a href="#" onclick="alert('No disponible en demo')">
							<button class="btn btn-primary btn-label-left" type="button">
								Descargar
							</button>
						</a>
						
					</div>
					<div style="width:100%;text-align:left;padding:20px">
						<div id="map"  style="width:100%; max-width:auto;height:460px;margin: auto;"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<?php echo form_close(); ?>   
	
</div><!--End Content-->
							
<script src="<?php echo base_url();?>assets/plugins/select2/select2.js"></script>
<script>
	function Select2Test(){
		$("#tipoaccidente").select2();
		$("#id_ciudad").select2();
	}
	$(document).ready(function() {
		LoadSelect2Script(Select2Test);
		// Initialize datepicker
		$('#fecha_desde').datepicker({ dateFormat: "dd/mm/yy", altFormat: "yy-mm-dd",altField: "#fecha_desde" });
		$('#fecha_hasta').datepicker({ dateFormat: "dd/mm/yy", altFormat: "yy-mm-dd",altField: "#fecha_hasta" });
	});
</script>

<script>

	var map, heatmap;

	function initMap() {
	  map = new google.maps.Map(document.getElementById('map'), {
		zoom: <?php echo $zoom; ?>,
		center: {lat: <?php echo $lat; ?>, lng: <?php echo $lng; ?>},
		mapTypeId: google.maps.MapTypeId.MAP
	  });

	  heatmap = new google.maps.visualization.HeatmapLayer({
		data: getPoints(),
		map: map
	  });
	}

	function toggleHeatmap() {
	  heatmap.setMap(heatmap.getMap() ? null : map);
	}

	function changeGradient() {
	  var gradient = [
		'rgba(0, 255, 255, 0)',
		'rgba(0, 255, 255, 1)',
		'rgba(0, 191, 255, 1)',
		'rgba(0, 127, 255, 1)',
		'rgba(0, 63, 255, 1)',
		'rgba(0, 0, 255, 1)',
		'rgba(0, 0, 223, 1)',
		'rgba(0, 0, 191, 1)',
		'rgba(0, 0, 159, 1)',
		'rgba(0, 0, 127, 1)',
		'rgba(63, 0, 91, 1)',
		'rgba(127, 0, 63, 1)',
		'rgba(191, 0, 31, 1)',
		'rgba(255, 0, 0, 1)'
	  ]
	  heatmap.set('gradient', heatmap.get('gradient') ? null : gradient);
	}

	function changeRadius() {
	  heatmap.set('radius', heatmap.get('radius') ? null : 20);
	}

	function changeOpacity() {
	  heatmap.set('opacity', heatmap.get('opacity') ? null : 0.2);
	}

	function getPoints() {
	  return [
		<?php foreach ($siniestros as $siniestro){
			if (!empty($siniestro->latlng)){?>
				new google.maps.LatLng(<?php echo $siniestro->latlng; ?>),
		<?php }} ?>
	  ];
	}
</script>

<script async defer
	src="https://maps.googleapis.com/maps/api/js?key=...&callback&libraries=visualization&callback=initMap" loading=async>
</script>
	