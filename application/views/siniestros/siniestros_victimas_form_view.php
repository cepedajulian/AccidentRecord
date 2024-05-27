<?php error_reporting(0);?>
<!--Start Content-->
<div id="content" class="col-xs-12 col-sm-10">

	<div class="row">
		<div id="breadcrumb" class="col-md-12">
			<a href="#" class="show-sidebar"><i class="fa fa-bars"></i></a>
			<ol class="breadcrumb">
				<li><a href="<?php echo site_url('/home/'); ?>">Inicio</a></li>
				<li><a href="<?php echo site_url('/siniestros'); ?>">Siniestros</a></li>
				<li><a href="#">Datos de la v&iacute;ctima</a></li>
			</ol>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<h3 class="page-header">Datos de la v&iacute;ctima</h3>
			<BR>
			<?php  if (validation_errors()) echo "<div class='bg-danger'>".utf8_encode(validation_errors())."</div>"; ?>
			<br>
		</div>	
	</div>
	
	<?php echo form_open('siniestros/addvictimas', array('id' => 'siniestrosForm', 'class'=> 'form-horizontal bootstrap-validator-form')); ?>
	<input type="hidden" value="1" name="sendform">
	<input type="hidden" name="idVictima" id="idVictima" value="<?php if (isset($victima)){echo $victima['id'];} ?>" >
	<input type="hidden" name="idSiniestro" id="idSiniestro" value="<?php echo $id_siniestro;?>" >
	<div class="row">	
		<div class="col-xs-12 col-sm-12">
			<div class="box">
				<div class="box-header">
					<div class="box-name">
						<i class="fa fa-folder-open-o"></i>
						<span>Datos de la victima</span>
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
						<div class="form-group">
							<label class="col-sm-3 control-label">DNI</label>
							<div class="col-sm-2">
								<input type="text" class="form-control" id="dni" name="dni" value="<?php if (isset($victima)){echo $victima['dni'];} ?>" onKeyPress="return soloNumeros(event)" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Nombre</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="nombre" name="nombre" value="<?php if (isset($victima)){echo $victima['nombre'];} ?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Sexo</label>
							<div class="col-sm-2">
								<select id="sexo" name="sexo">
									<option value="F" <?php if (isset($victima['sexo']) && "F"==$victima['sexo']) echo "selected=selected";?> >FEMENINO</option>
									<option value="M" <?php if (isset($victima['sexo']) && "M"==$victima['sexo']) echo "selected=selected";?> >MASCULINO</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Edad</label>
							<div class="col-sm-3">
								<select style="width:140px" id="edad" name="edad">
									<?php foreach ($edades as $edad){ 
										if($edad->edad=='XX-XX'){
											?>
											<option value="XX-XX" <?php if (isset($victima['edad']) && $edad->edad==$victima['edad']) echo "selected=selected"; ?>>
												SE IGNORA
											</option>
											<?php
										}else{
											?>
											<option value="<?php echo $edad->edad; ?>" <?php if (isset($victima['edad']) && $edad->edad==$victima['edad']) echo "selected=selected"; ?> >
												<?php echo "DE ".$edad->edad." A&Ntilde;OS";?>
											</option>
											<?php
										}																				
									}?>				
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Veh&iacute;culo asociado</label>
							<div class="col-sm-3">
								<select id="id_vehiculo" name="id_vehiculo">
									<option value="">Ninguno</option>
									<?php foreach ($vehiculos as $vehiculo){ 
										$patente = "";
										if (!empty($vehiculo->patente))
											$patente = "(".$vehiculo->patente.")";?>
										<option value="<?php echo $vehiculo->idVehiculo; ?>" <?php if (isset($victima['id_vehiculo']) && $vehiculo->idVehiculo==$victima['id_vehiculo']) echo "selected=selected"; ?> >
											<?php echo $vehiculo->marca." ".$vehiculo->modelo. " ".$patente; ?>
										</option>
									<?php }?>				
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Condici&oacute;n</label>
							<div class="col-sm-2">
								<select name="condicion"  id="condicion" >
									<option <?php if (isset($victima) && $victima['condicion'] == "CONDUCTOR") echo "selected=selected"; ?> value="CONDUCTOR">CONDUCTOR</option>
									<option <?php if (isset($victima) && $victima['condicion'] == "ACOMPA�ANTE") echo "selected=selected"; ?> value="<?php echo utf8_encode('ACOMPA�ANTE')?>">ACOMPA&Ntilde;ANTE</option>
									<option <?php if (isset($victima) && $victima['condicion'] == "PASAJERO") echo "selected=selected"; ?> value="PASAJERO">PASAJERO</option>
									<option <?php if (isset($victima) && $victima['condicion'] == "COLGADO") echo "selected=selected"; ?> value="COLGADO">COLGADO</option>
									<option <?php if (isset($victima) && $victima['condicion'] == "PEATON") echo "selected=selected"; ?> value="PEATON">PEATON</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Casco</label>
							<div class="col-sm-2">
										<select  name="casco" id="casco"> <!--class="selectRendodo"-->
											<option <?php if (isset($victima) && $victima['casco'] == 2) echo "selected=selected"; ?> value="2">N/A</option>
											<option <?php if (isset($victima) && $victima['casco'] == 0) echo "selected=selected"; ?> value="0">NO</option>
											<option <?php if (isset($victima) && $victima['casco'] == 1) echo "selected=selected"; ?> value="1">SI</option>
										</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Cituron</label>
							<div class="col-sm-2">
										<select name="cinturon" id="cinturon"> <!--class="selectRendodo"-->
											<option <?php if (isset($victima) && $victima['cinturon'] == 2) echo "selected=selected"; ?> value="2">N/A</option>
											<option <?php if (isset($victima) && $victima['cinturon'] == 0) echo "selected=selected"; ?> value="0">NO</option>
											<option <?php if (isset($victima) && $victima['cinturon'] == 1) echo "selected=selected"; ?> value="1">SI</option>
										</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label">Lesi&oacute;n</label>
							<div class="col-sm-4">
								<select style="width:150px" id="lesion" name="lesion">
									<?php foreach ($lesiones as $lesion){ ?>
									<option value="<?php echo $lesion->lesion; ?>" <?php if (isset($victima) && $victima['lesion'] == $lesion->lesion) echo "selected=selected"; ?>>
										<?php echo $lesion->lesion; ?>
									</option>
								<?php }?>	
								</select>
							</div>
						</div>
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
						
					</fieldset>
				</div>
			</div>
		</div>
		
		<?php echo form_close(); ?>
		
	</div>

</div><!--End Content-->

<script src="<?php echo base_url();?>assets/plugins/select2/select2.js"></script>
<script src="<?php echo base_url();?>assets/plugins/bootstrapvalidator/bootstrapValidator.min.js"></script>
<script src="<?php echo base_url();?>assets/js/validations.js"></script>

<script type="text/javascript">
	function soloNumeros(e){
		var key = window.Event ? e.which : e.keyCode
		return (key >= 48 && key <= 57)
	}
	
	function Select2Test(){
		$("#sexo").select2();
		$("#id_vehiculo").select2();
		$("#edad").select2();
		$("#lesion").select2();
		$("#patente").select2();
		$("#condicion").select2();
		$("#casco").select2();
		$("#cinturon").select2();
	}

	$(document).ready(function() {
		LoadSelect2Script(Select2Test);
		LoadBootstrapValidatorScript(FormValidator);
		WinMove();
	});
	
</script>