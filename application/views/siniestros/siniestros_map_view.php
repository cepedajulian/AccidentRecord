<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

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
	
	<div class="row">
		<div class="col-xs-12">
			<h3 class="page-header">Siniestros / Mapa</h3>
			<?php if ( ! empty($msg)){ echo "<p class='bg-success'>".$msg."</p>"; }?>
			<?php if ( ! empty($error)){ echo "<p class='bg-danger'>".$error."</p>"; }?>
		</div>
	</div>
	
	<div class="panel panel-default">
		<div class="panel-body">
			<form id="myForm" name="myForm">
				<div class="row">
					<div class="col-sm-2">
						<label for="id_ciudad">Municipio:</label>&nbsp;
						<select id="id_ciudad" name="id_ciudad" class="selectpicker" multiple>
							<?php foreach($ciudades as $ciudad){?>
								<?php if (empty($id_ciudad)){?>
									<option  value="<?php echo $ciudad->id; ?>" <?php if($ciudad->id == $criteria['idc']) echo "selected=selected"; ?>>
										<?php echo $ciudad->ciudad; ?>
									</option>
								<?php }else{
									if ($id_ciudad==$ciudad->id){
										?>
										<option  value="<?php echo $ciudad->id;?>" selected="selected" disabled>
											<?php echo $ciudad->ciudad; ?>
										</option>
										<?php
									}
								}
							}?>
						</select>
					</div>
						
					<div class="col-sm-2">
						<label for="id_localidad">Localidad:&nbsp;</label>
						<select id="id_localidad" name="id_localidad" class="selectpicker" multiple>
							<?php foreach($localidades as $localidad){?>
								<option  value="<?php echo $localidad->id; ?>" <?php if($localidad->id == $criteria['idl']) echo "selected=selected"; ?>>
									<?php echo $localidad->localidad; ?>
								</option>
							<?php }?>
						</select>
					</div>
						
					<div class="col-sm-2">
						<label for="tipoaccidente">Mecánica del Hecho:</label>&nbsp;
						<select id="tipoaccidente" name="tipoaccidente" class="selectpicker" multiple>
							<?php foreach($tipoaccidentes as $ta){?>
									<option  value="<?php echo $ta->id; ?>" <?php if(!empty($criteria['tipoaccidente']) && $ta->id == $criteria['tipoaccidente']) echo "selected=selected"; ?>>
										<?php echo utf8_decode($ta->tipoaccidente); ?>
									</option>
							<?php }?>
						</select>
					</div>
						
					<div class="col-sm-2">
						<label for="lesion">Categoría:</label>&nbsp;
						<select id="lesion" name="lesion" class="selectpicker" multiple>
							<?php foreach ($lesiones as $lesion){ ?>
									<option value="<?php echo $lesion->lesion; ?>">
										<?php echo $lesion->lesion; ?>
									</option>
							<?php }?>	
						</select>
					</div>
							
					<div class="col-sm-2">
						<label for="tipo">Participación de vehiculo:</label>&nbsp;
						<select id="tipo" name="tipo" class="selectpicker" multiple>
							<?php foreach ($tipovehiculos as $tipovehiculo){ ?>
									<option value="<?php echo $tipovehiculo->tipovehiculo; ?>">
										<?php echo $tipovehiculo->tipovehiculo; ?>
									</option>
							<?php }?>	
						</select>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-sm-2">
						<label for="fd">Fecha:&nbsp;</label>(Desde)
						<input type="text" id="fd"  name="fd" class="form-control" value="" >
					</div>
					
					<div class="col-sm-2">
						<label for="fh">Fecha:&nbsp;</label>(Hasta)
						<input type="text" id="fh"  name="fh" class="form-control" value="" >
					</div>
					
					<div class="col-sm-2">
						<label for="hora1">Horas&nbsp;</label>(Desde)
						<select id="hora1" name="hora1" class="selectpicker" width: '100px'>
							<option value="x">No hay selección</option>
							<?php for ($i = 0; $i <= 23; $i++) { ?>
									<option value="<?php if($i<10){echo '0';}; echo $i;?>:00">
										<?php if($i<10){echo '0';}; echo $i;?>:00
									</option>
							<?php }?>
						</select>
					</div>
					<div class="col-sm-2">
						<label for="hora2">Horas&nbsp;</label>(Hasta)
						<select id="hora2" name="hora2" class="selectpicker" width: '100px'>
							<option value="x">No hay selección</option>
							<?php for ($i = 0; $i <= 23; $i++) { ?>
									<option value="<?php if($i<10){echo '0';}; echo $i;?>:59">
										<?php if($i<10){echo '0';}; echo $i;?>:59
									</option>
							<?php }?>
						</select>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-sm-4">						
						<div style="width:100%;text-align:left;padding:10px">
							<a href="#" onclick="try{Buscar();}catch(mierror){alert('Error detectado: ' + mierror);}">
								<button class="btn btn-primary btn-label-left" type="button">
									Buscar
								</button>
							</a>
							
							<a href="<?php echo site_url('/siniestros/map'); ?>">
								<button class="btn btn-primary btn-label-left" type="button">
									Limpiar
								</button>
							</a>
						</div>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-sm-12">
						<div style="width:100%;text-align:left;padding:10px">
							<div id="map" style="width:100%; max-width:auto;height:400px;margin: auto;"></div>
							<br>Si no observa puntos en el mapa verifique si la protección de rastreo está habilitada!
							<div style="width:100%;text-align:left;padding:10px">
								Nivel de Agrupación :&nbsp;
									<select id="nummarkers" onchange="AgruparMarks();">
	          							<option value="1000">Mínimo</option>
          								<option value="500" selected="selected">Medio</option>          
          								<option value="1">Máximo</option>
        							</select>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div><!--End Content-->
		
<script src="<?php echo base_url();?>assets/js/modal.popup.js"></script>
<script src="<?php echo base_url();?>assets/plugins/select/bootstrap-select.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/select/i18n/defaults-es_ES.min.js"></script>

<script>
	var locations = [];
	var numMarkers  =500;
	var zoom 		=<?php echo $zoom; ?>;

	function format_fecha(var1){
		var1=var1.split("/");
		return var1[2]+'-'+var1[1]+'-'+var1[0];
	}
	
	function Buscar(){
		var filtro='';
		var primerGrupo=true;
		var	primerItem=true;
		
		if($("#id_ciudad :selected").length>0){;
			if(primerGrupo==true){
				filtro=filtro+'(';
			}else{
				filtro=filtro+' AND (';
			}
			
			primerGrupo=false;
			
			primerItem=true;
			$("#id_ciudad :selected").map(function(i, el) {
	    		if(primerItem==true){
    				filtro=filtro+" id_ciudad="+$(el).val();
				}else{
					filtro=filtro+" OR id_ciudad="+$(el).val();
				}
				
    			primerItem=false;
			});
			
			filtro=filtro+')';
		}
		
		if($("#id_localidad :selected").length>0){;
			if(primerGrupo==true){
				filtro=filtro+'(';
			}else{
				filtro=filtro+' AND (';
			}
			
			primerGrupo=false;
			
			primerItem=true;
			$("#id_localidad :selected").map(function(i, el) {
	    		if(primerItem==true){
    				filtro=filtro+" id_localidad="+$(el).val();
				}else{
					filtro=filtro+" OR id_localidad="+$(el).val();
				}
				
    			primerItem=false;
			});
		
			filtro=filtro+')';
		}
		
		
		if($("#tipoaccidente :selected").length>0){;
			if(primerGrupo==true){
				filtro=filtro+'(';
			}else{
				filtro=filtro+' AND (';
			}
			
			primerGrupo=false;
	
			primeroItem=true;
			$("#tipoaccidente :selected").map(function(i, el) {
	    		if(primeroItem==true){
    				filtro=filtro+ "tipoaccidente="+$(el).val();
				}else{
					filtro=filtro+" OR tipoaccidente="+$(el).val();
				}
    			primeroItem=false;
			});
			
			filtro=filtro+')';
		}
		
		if($("#lesion :selected").length>0){;
			if(primerGrupo==true){
				filtro=filtro+'(';
			}else{
				filtro=filtro+' AND (';
			}
			
			primerGrupo=false;
			
			primeroItem=true;
			$("#lesion :selected").map(function(i, el) {
    			if(primeroItem==true){
    				filtro=filtro+ "victimas.lesion='"+$(el).val()+"'";
				}else{
					filtro=filtro+" OR victimas.lesion='"+$(el).val()+"'";
				}
				
    			primeroItem=false;
			});
		
			filtro=filtro+')';
		}
		
		if($("#tipo :selected").length>0){;
			if(primerGrupo==true){
				filtro=filtro+'(';
			}else{
				filtro=filtro+' AND (';
			}
			
			primerGrupo=false;
			
			primeroItem=true;
			$("#tipo :selected").map(function(i, el) {
	    		if(primeroItem==true){
    				filtro=filtro+ "tipo='"+$(el).val()+"'";
				}else{
					filtro=filtro+" OR tipo='"+$(el).val()+"'";
				}
				
    			primeroItem=false;
			});
		
			filtro=filtro+')';
		}
		
		if($('#fd').val()!=''){
			if(primerGrupo==false){
				filtro=filtro+' AND ';
			}
				
			filtro=filtro+" fecha>='"+format_fecha($('#fd').val())+"'";
			primerGrupo=false;
		}
		
		if($('#fh').val()!=''){
			if(primerGrupo==false){
				filtro=filtro+' AND ';
			}
				
			filtro=filtro+" fecha<='"+format_fecha($('#fh').val())+"'";
			primerGrupo=false;
		}
		
		
		if($('#hora1').val()!='x'){
			if(primerGrupo==false){
				filtro=filtro+' AND ';
			}
				
			filtro=filtro+" TIME(fecha)>='"+$('#hora1').val()+"'";
			primerGrupo=false;
		}
		
		if($('#hora2').val()!='x'){
			if(primerGrupo==false){
				filtro=filtro+' AND ';
			}
				
			filtro=filtro+" TIME(fecha)<='"+$('#hora2').val()+"'";
			primerGrupo=false;
		}
		
		
		if(primerGrupo==false){
			filtro=filtro+' AND ';
		}
		
		filtro=filtro+'siniestros.borrado=0';
		primerGrupo=false;
		
		$("#map").html("<img src='<?php echo base_url();?>assets/img/loading.gif'/>");
		$.getJSON( './mapadibujar?filtro='+filtro, function(e,status,xhr){
			if(e.error==true){
				bootbox.alert({title: "Aviso", message: e.errormsg, backdrop: true});
			}else{
				locations = [];
				$.each(e.datos, function(i, dato){
					locations.push({
						lat:dato.lat,
						lng:dato.lng,
						info:dato.info,
						color:dato.color
					});
				});
				
				console.log(locations);
				initMap(numMarkers);
			}
		});
	}
	
	function AgruparMarks(){
		numMarkers = document.getElementById('nummarkers').value;
		//document.getElementById('map').innerHTML='';
		//zoom=parseInt(document.getElementById("zoom").value);
		initMap(numMarkers);		
	}
	
	$(document).ready(function() {
		$( "#fd" ).datepicker({ maxDate: new Date('<?php echo date('Y,m,d');?>') });
		$( "#fh" ).datepicker({ maxDate: new Date('<?php echo date('Y,m,d');?>') });
	});
	
	function initMap(numMarkers) {
		var mapDiv = document.getElementById("map");
		
		var map = new google.maps.Map(mapDiv, {
          zoom: zoom,         
          center: new google.maps.LatLng(<?php echo $latlng; ?>),
		  mapId: "DEMO_MAP_ID"
        });

		var infoWin = new google.maps.InfoWindow({
			content: "",
			disableAutoPan: true,
		});

		const markers = locations.map((position, i) => {
			//const label = labels[i % labels.length];
			const marker = new google.maps.Marker({
				position
			});

			// markers can only be keyboard focusable when they have click listeners
			// open info window when marker is clicked
			marker.addListener("click", () => {
				infoWin.setContent(location.info);
      			infoWin.open(map, marker);
			});

			return marker;
	}	);

		
        
    	//var markerCluster = new MarkerClusterer(map, markers,{imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m',minimumClusterSize:numMarkers});	

		const markerCluster = new markerClusterer.MarkerClusterer({ map, markers });


        document.getElementById("zoom").value= map.getZoom();
        document.getElementById("coords").value= map.getCenter();
	}
</script>

<script 
	src="https://unpkg.com/@googlemaps/markerclusterer/dist/index.min.js">
	defer
</script>

<script
	src="https://maps.googleapis.com/maps/api/js?key=...&callback=initMap&v=weekly">
	defer
</script>

<script>
	Buscar()
</script>