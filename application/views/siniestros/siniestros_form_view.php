<?php error_reporting(0);?>
<!--Start Content-->
<div id="content" class="col-xs-12 col-sm-10">

	<div class="row">
		<div id="breadcrumb" class="col-md-12">
			<a href="#" class="show-sidebar"><i class="fa fa-bars"></i></a>
			<ol class="breadcrumb">
				<li><a href="<?php echo site_url('/home/'); ?>">Inicio</a></li>
				<li><a href="<?php echo site_url('/siniestros'); ?>">Siniestros</a></li>
				<li><a href="#">Datos del siniestro</a></li>
			</ol>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<h3 class="page-header">Datos del siniestro</h3>
			<BR>
			<?php  if (validation_errors()) echo "<div class='bg-danger'>".utf8_encode(validation_errors())."</div>"; ?>
			<br>
		</div>	
	</div>
	
	<?php echo form_open('siniestros/add', array('onsubmit' => 'return validateCalles()', 'id' => 'siniestrosForm', 'class'=> 'form-horizontal bootstrap-validator-form')); ?>
	<input type="hidden" value="1" name="sendform">
	<input type="hidden" value="0" name="cargar_victimas" id="cargar_victimas">
	<input type="hidden" value="0" name="cargar_vehiculos" id="cargar_vehiculos">
	<input type="hidden" value="<?php if (isset($siniestro)){echo $siniestro['id'];} ?>" name="id" id="id">
	<input type="hidden" class="form-control" id="latlng" name="latlng" value="<?php if (isset($siniestro)){echo $siniestro['latlng'];} ?>" />
	<input type="hidden" value="<?php echo $action;?>" name="action">
	
	<div class="row">	
		<div class="col-xs-12 col-sm-6">
			<div class="box">
				<div class="box-header">
					<div class="box-name">
						<i class="fa fa-folder-open-o"></i>
						<span>Datos del siniestro</span>
					</div>
					<div class="box-icons">
						<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
						<a class="expand-link"><i class="fa fa-expand"></i></a>
						
					</div>
					<div class="no-move"></div>
				</div>
				<div class="box-content no-padding">
					<br>
					<fieldset>
								
						<?php if (empty($id_ciudad)){?>
						<div class="form-group">
							<label class="col-sm-3 control-label">Municipio</label>
							<div class="col-sm-6">
								<select id="id_ciudad" name="id_ciudad">
									<?php foreach($ciudades as $ciudad){?>
									<option  value="<?php echo $ciudad->id; ?>" <?php if($ciudad->id == $siniestro['id_ciudad']) echo "selected=selected"; ?>>
										<?php echo $ciudad->ciudad; ?>
									</option>
									<?php }?>
								</select>
							</div>
						</div>
						<?php }?>
							
						<div class="form-group">
							<label class="col-sm-3 control-label">Localidad</label>
							<div class="col-sm-6">
								<select id="id_localidad" name="id_localidad" >
									<option value="">TODAS</opcion>	
									<?php foreach($localidades as $localidad){?>
									<option  value="<?php echo $localidad->id; ?>" <?php if($localidad->id == $siniestro['id_localidad']) echo "selected=selected"; ?>>
										<?php echo $localidad->localidad; ?>
									</option>
									<?php }?>
								</select>
							</div>
						</div>
										
						<div class="form-group has-feedback">
							<label class="col-sm-3 control-label">Fecha</label>
							<div class="col-sm-4">
								<input readonly="readonly" type="text" id="fecha" class="form-control" name="fecha" value="<?php if (isset($siniestro)){echo get_fecha($siniestro['fecha']);}else echo date('Y-m-d'); ?>" >
								<span class="fa fa-calendar txt-danger form-control-feedback"></span>
							</div>
						</div>
						<div class="form-group has-feedback">
							<label class="col-sm-3 control-label">Hora</label>
							<div class="col-sm-5">
								<input style="width:40px;float:left" type="text" id="hora" class="form-control" onKeyPress="return soloNumeros(event)" maxlength="2" name="hora" value="<?php if (isset($siniestro)){echo get_hora($siniestro['fecha']);}else echo ""; ?>" >
								<div style="float:left"> &nbsp;:&nbsp; </div>
								<input style="width:40px;float:left" type="text" id="min" class="form-control" onKeyPress="return soloNumeros(event)" maxlength="2" name="min" value="<?php if (isset($siniestro)){echo get_min($siniestro['fecha']);}else echo ""; ?>" >
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Tipo</label>
							<div class="col-sm-6">
								<select id="tipoaccidente" name="tipoaccidente">
									<?php foreach($tipoaccidentes as $ta){?>
									<option  value="<?php echo $ta->id; ?>" <?php if($ta->id == $siniestro['tipoaccidente']) echo "selected=selected"; ?>>
										<?php echo $ta->tipoaccidente; ?>
									</option>
									<?php }?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Tipo de Calzada</label>
							<div class="col-sm-4">
								<select id="tipocalzada" name="tipocalzada">
									<?php foreach($tipocalzadas as $tc){?>
									<option  value="<?php echo $tc->id; ?>" <?php if($tc->id == $siniestro['tipocalzada']) echo "selected=selected"; ?>>
										<?php echo $tc->tipocalzada; ?>
									</option>
									<?php }?>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label">&nbsp;</label>
							<div class="col-sm-4">
								<input type="radio" class="tipocalle" id="tipocalle1" name="tipocalle" value="URBANA" onclick="ubicacion2(this)" <?php if ($siniestro['tipocalle'] == "URBANA" || !isset($siniestro)) echo "checked=checked"; ?>> Calle &nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" class="tipocalle" id="tipocalle2" name="tipocalle" value="RUTA" onclick="ubicacion2(this)" <?php if ($siniestro['tipocalle'] == "RUTA") echo "checked=checked"; ?>> Ruta
							</div>
						</div>
						<div id="urbana">
							<div class="form-group">
								<label class="col-sm-3 control-label">Calle</label>
								<div class="col-sm-6">
									<select id="calle1" name="calle1"  >
										<option value=""></option>
										<?php foreach($calles as $calle){?>
										<option  value="<?php echo $calle->calle; ?>" <?php if($calle->calle == $siniestro['calle1']) echo "selected=selected"; ?> >
											<?php echo $calle->calle; ?>
										</option>
										<?php }?>
									</select>
									<span class="errorValidation" id="errorCalle1"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Esquina 1</label>
								<div class="col-sm-6">
									<select id="calle2" name="calle2">
										<option value=""></option>
										<?php foreach($calles as $calle){?>
										<option  value="<?php echo $calle->calle; ?>" <?php if($calle->calle == $siniestro['calle2']) echo "selected=selected"; ?>>
											<?php echo $calle->calle; ?>
										</option>
										<?php }?>
									</select>
									<span class="errorValidation" id="errorCalle2"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Esquina 2</label>
								<div class="col-sm-6">
									<select id="calle3" name="calle3">
										<option value=""></option>
										<?php foreach($calles as $calle){?>
										<option  value="<?php echo $calle->calle; ?>" <?php if($calle->calle == $siniestro['calle3']) echo "selected=selected"; ?>>
											<?php echo $calle->calle; ?>
										</option>
										<?php }?>
									</select>
									<span class="errorValidation" id="errorCalle3"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Altura Aproximada</label>
								<div class="col-sm-3">
									<input type="text" class="form-control" id="nro" name="nro" value="<?php if (isset($siniestro)){echo $siniestro['nro'];} ?>" />
								</div>
							</div>
						</div>

						<div id="ruta" style="display:none">
							<div class="form-group">
								<label class="col-sm-3 control-label">Ruta</label>
								<div class="col-sm-6">
									<select id="rutas" name="ruta" >
										<?php foreach($rutas as $ruta){?>
										<option  value="<?php echo $ruta->ruta; ?>" <?php if($ruta->ruta == $siniestro['calle1']) echo "selected=selected"; ?> >
											<?php echo $ruta->ruta; ?>
										</option>
										<?php }?>
									</select>
									<span class="errorValidation" id="errorCalle1"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">KM</label>
								<div class="col-sm-3">
									<input type="text" class="form-control" id="km" name="km" value="<?php if (isset($siniestro)){echo $siniestro['nro'];} ?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Ubicaci&oacute;n detallada</label>
								<div class="col-sm-8">
									<textarea class="form-control" id="ubicacion" name="ubicacion"  rows="4"><?php if (isset($siniestro)){echo $siniestro['ubicacion'];} ?></textarea>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Clima</label>
							<div class="col-sm-4">
								<select id="clima" name="clima">
									<?php foreach($climas as $clima){?>
									<option  value="<?php echo $clima->id; ?>" <?php if($clima->id == $siniestro['clima']) echo "selected=selected"; ?>>
										<?php echo $clima->clima; ?>
									</option>
									<?php }?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Visibilidad</label>
							<div class="col-sm-5">
								<select id="horario" name="horario">
									<?php foreach($horarios as $horario){?>
									<option  value="<?php echo $horario->id; ?>" <?php if($horario->id == $siniestro['hora']) echo "selected=selected"; ?>>
										<?php echo $horario->horario; ?>
									</option>
									<?php }?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Causa 1</label>
							<div class="col-sm-6">
								<select id="causa" name="causa">
									<?php foreach($causas as $causa){?>
									<option  value="<?php echo $causa->id; ?>" <?php if($causa->id == $siniestro['causa']) echo "selected=selected"; ?>>
										<?php echo $causa->causa; ?>
									</option>
									<?php }?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Causa 2</label>
							<div class="col-sm-6">
								<select id="causa2" name="causa2">
									<option value=""></value>
									<?php foreach($causas as $causa){?>
									<option  value="<?php echo $causa->id; ?>" <?php if($causa->id == $siniestro['causa2']) echo "selected=selected"; ?>>
										<?php echo $causa->causa; ?>
									</option>
									<?php }?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Causa 3</label>
							<div class="col-sm-6">
								<select id="causa3" name="causa3">
									<option value=""></value>
									<?php foreach($causas as $causa){?>
									<option  value="<?php echo $causa->id; ?>" <?php if($causa->id == $siniestro['causa3']) echo "selected=selected"; ?>>
										<?php echo $causa->causa; ?>
									</option>
									<?php }?>
								</select>
							</div>
						</div>
						<!--  div class="form-group">
							<label class="col-sm-3 control-label">Patentes asociadas</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="patentes" name="patentes" value="<?php if (isset($siniestro)){echo $siniestro['patentes'];} ?>" />
							</div>
							<img src="<?php echo base_url();?>assets/img/help.png" width="25px" alt="Si hay mas de una ingresarlas separadas por COMA." title="Si hay mas de una ingresarlas separadas por COMA.">
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Relevamiento</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="relevamiento" name="relevamiento" value="<?php if (isset($siniestro)){echo $siniestro['relevamiento'];} ?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Rastros</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="rastros" name="rastros" value="<?php if (isset($siniestro)){echo $siniestro['rastros'];} ?>" />
							</div>
						</div>-->
						<div class="form-group">
							<label class="col-sm-3 control-label">Fuerza</label>
							<div class="col-sm-6">
								<select id="fuerza" name="fuerza">
								<?php foreach ($fuerzas as $fuerza){ ?>
									<option value="<?php echo $fuerza->fuerza; ?>" <?php if (!empty($siniestro['fuerza']) && $fuerza->fuerza==$siniestro['fuerza']) echo "selected=selected"; ?> >
										<?php echo $fuerza->fuerza; ?>
									</option>
								<?php }?>	
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Descripci&oacute;n</label>
							<div class="col-sm-8">
								<textarea class="form-control" id="descripcion" name="descripcion"  rows="4"><?php if (isset($siniestro)){echo $siniestro['descripcion'];} ?></textarea>
							</div>
						</div>

					</fieldset>
					<br><br><br><br>
				</div>
			</div>
		</div>
		
		<div class="col-xs-12 col-sm-6">
			<div class="box">
				<div class="box-header">
					<div class="box-name">
						<i class="fa fa-folder-open-o"></i>
						<span>Geolocalizaci&oacute;n</span>
					</div>
					<div class="box-icons">
						<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
						<a class="expand-link"><i class="fa fa-expand"></i></a>
						
					</div>
					<div class="no-move"></div>
				</div>
				<div class="box-content no-padding">
					<div id="map"  style="width:100%; max-width:1000px;height:300px;"></div>
				</div>
			</div>
		</div>
		<div style="clear:both"></div>
		<div style="width:100%;text-align:center;padding:10px">
			<a href="#" onclick="$('#siniestrosForm').submit()">
				<button class="btn btn-primary btn-label-left" type="button">
					Guardar
				</button>
			</a>
			<a href="javascript:window.history.go(-1);">
				<button class="btn btn-primary btn-label-left" type="button">
					Cancelar
				</button>
			</a>
		</div>
		<?php echo form_close(); ?>
		
	</div>

</div><!--End Content-->

<?php
	function format_fecha($fecha){
		$date = new DateTime($fecha);
		return $date->format('d-m-Y');
	}
	function get_fecha($fecha){
		$date = new DateTime($fecha);
		return $date->format('Y-m-d');
	}
	function get_hora($fecha){
		$date = new DateTime($fecha);
		return $date->format('H');
	}
	function get_min($fecha){
		$date = new DateTime($fecha);
		return $date->format('i');
	}
?>

<script src="<?php echo base_url();?>assets/plugins/select2/select2.js"></script>
<script src="<?php echo base_url();?>assets/plugins/bootstrapvalidator/bootstrapValidator.min.js"></script>
<script src="<?php echo base_url();?>assets/js/validations.js"></script>

<script type="text/javascript">
	// Run Select2 on element
	function Select2Test(){
		$("#id_ciudad").select2();
		$("#id_localidad").select2();
		$("#tipoaccidente").select2();
		$("#victimas").select2();
		$("#calle1").select2();
		$("#calle2").select2();
		$("#calle3").select2();
		$("#tipocalzada").select2();
		$("#clima").select2();
		$("#horario").select2();
		$("#causa").select2();
		$("#causa2").select2();
		$("#causa3").select2();
		$("#fuerza").select2();
		$("#tipocalle").select2();
		$("#rutas").select2();
	}
	
	$(document).ready(function() {
		 $('#id_localidad').on('change',function(){
	        var id_localidad = $(this).val();
            $.ajax({
                type:'POST',
                url:'<?php echo site_url('/siniestros/ajaxGetCalles'); ?>',
                data:'id_localidad='+id_localidad,
                success:function(html){
                	
                    $('#calle1').html(html);
                    $('#calle2').html(html);
                    $('#calle3').html(html);
                    $('#calle1').select2("val", "");
                	$('#calle2').select2("val", "");
                	$('#calle3').select2("val", "");
                }
            }); 
	    });
		    
		<?php if ($siniestro['tipocalle'] == "URBANA" || !isset($siniestro)){ ?>
			$('#urbana').css('display','block');
			$('#ruta').css('display','none');
		<?php }else{?>
			$('#urbana').css('display','none');
			$('#ruta').css('display','block');
		<?php }?>
		$('#fecha').datepicker({ dateFormat: "dd/mm/yy", altFormat: "yy-mm-dd",altField: "#fecha" });
		// Load script of Select2 and run this
		LoadSelect2Script(Select2Test);
		// Load example of form validation
		LoadBootstrapValidatorScript(FormValidator);
		WinMove();
	});
</script>

<script>
function soloNumeros(e){
	var key = window.Event ? e.which : e.keyCode
	return (key >= 48 && key <= 57)
}

function addVictima(){
	$.ajax({
		type: "POST",
		url: "<?php echo base_url();?>index.php/siniestros/ajaxVictimas", 
		data: {action: 'add',
			idSiniestro: $("#id").val(), 
			tipovehiculo: $("#tipovehiculo").val(), 
			edad: $("#edad").val(), 
			sexo: $("#sexo").val(), 
			cinturon: $("#cinturon").val(), 
			casco: $("#casco").val(),
			conductor: $("#conductor").val(),
			dni: $("#dni").val(),
			nombre: $("#nombre").val(),
			lesion: $("#lesion").val()
		},
		cache:false,
		success: 
		  function(data){
			$("#tablaVictimas").html(data);
		  }
	});
}

function delVictima($idVictima){
	$.ajax({
		type: "POST",
		url: "<?php echo base_url();?>index.php/siniestros/ajaxVictimas", 
		data: {action: 'del',
			idSiniestro: $("#id").val(), 
			idVictima: $idVictima , 
			edad: $("#edad").val(), 
			sexo: $("#sexo").val(), 
			cinturon: $("#cinturon").val(), 
			conductor: $("#conductor").val(), 
			casco: $("#casco").val(),
			dni: $("#dni").val(),
			lesion: $("#lesion").val()
		},
		cache:false,
		success: 
		  function(data){
			$("#tablaVictimas").html(data);
		  }
	});
}
function ubicacion2(elem){
	if (elem.value=="URBANA"){
		$('#urbana').css('display','block');
		$('#ruta').css('display','none');
		$("#calle2").removeAttr('disabled');
		$("#calle3").removeAttr('disabled');
		
	}
	else{
		$('#urbana').css('display','none');
		$("#calle2").attr('disabled','disabled');
		$("#calle3").attr('disabled','disabled');
		$('#ruta').css('display','block');
		$("#rutas").select2();
	}
}

function validateCalles(){
	$('#errorCalle1').html("");
	$('#errorCalle2').html("");
	$('#errorCalle3').html("");
	$('#errorRuta').html("");
	if ($('#tipocalle1').is(':checked')){
		if ($('#calle1').val() == '' ){
			$('#errorCalle1').html("Seleccione una calle.");
			return false; 
		}
		else if ($('#calle1').val() == $('#calle2').val()){
			$('#errorCalle2').html("La calles no pueden ser las mismas.");
			return false; 
		}
		else if ($('#calle2').val() == $('#calle3').val()){
			$('#errorCalle3').html("La calles no pueden ser las mismas.");
			return false;
		}
		else if ($('#calle1').val() == $('#calle3').val()){
			$('#errorCalle3').html("La calles no pueden ser las mismas.");
			return false; 
		}
		
	}
	if ($('#tipocalle2').is(':checked')){
		if ($('#rutas').val() == '' ){
			$('#errorRuta').html("Seleccione una ruta.");
			return false; 
		}
	}
	 
}
function iniciar2() {
	var mapOptions = {
	center: new google.maps.LatLng(<?php echo $latlng; ?>),
	zoom: 14,
	mapTypeId: google.maps.MapTypeId.ROADMAP};
	var map = new google.maps.Map(document.getElementById("map"),mapOptions);
	//marcador con la ubicaci�n de la Universidad
	i=0;
	<?php
		if ($siniestro['latlng'] == null || $siniestro['latlng'] == "")
			$siniestro['latlng'] = $latlng;
		$latlng = explode(',',$siniestro['latlng']);

	?>
		
		var marker = new google.maps.Marker({
        	position: new google.maps.LatLng(<?php echo $latlng[0]; ?>,<?php echo $latlng[1]; ?>),
        	title: '<?php echo '<b>Numero: </b>'.$siniestro['numero'].'<br><b>Descripcion: </b>'.$siniestro['descripcion']; ?>',
        	draggable: true,
        	map: map
        });
        
		//Dispara accion al dar un clic en el marcador          
		google.maps.event.addListener(marker, 'click',  function () {
			map.setZoom(16); //aumenta el zoom
		    map.setCenter(marker.getPosition());
		    var contentString = 'Ubicaci�n Actual';
		    var infowindow = new google.maps.InfoWindow({
		    	content: '<?php echo '<b>Fecha: </b>'.$siniestro['fecha'].'<br><b>Descripcion: </b>'.$siniestro['descripcion']; ?>'
		    });
		    infowindow.open(map,marker);
		});
		
		google.maps.event.addListener(marker, 'dragend', function (event) {
		    document.getElementById("latlng").value = this.getPosition().lat()+','+this.getPosition().lng();
		});



}            
</script>

<script src="https://maps.google.com/maps/api/js?key=...&sensor=false&callback=iniciar2" loading=async></script>