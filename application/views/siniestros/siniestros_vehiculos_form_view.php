<?php error_reporting(0);?>
<!--Start Content-->
<div id="content" class="col-xs-12 col-sm-10">

	<div class="row">
		<div id="breadcrumb" class="col-md-12">
			<a href="#" class="show-sidebar"><i class="fa fa-bars"></i></a>
			<ol class="breadcrumb">
				<li><a href="<?php echo site_url('/home/'); ?>">Inicio</a></li>
				<li><a href="<?php echo site_url('/siniestros'); ?>">Siniestros</a></li>
				<li><a href="#">Datos del veh&iacute;culo</a></li>
			</ol>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<h3 class="page-header">Datos de la veh&iacute;culo</h3>
			<BR>
			<?php  if (validation_errors()) echo "<div class='bg-danger'>".utf8_encode(validation_errors())."</div>"; ?>
			<br>
		</div>	
	</div>
	
	<?php echo form_open('siniestros/addvehiculo', array('id' => 'siniestrosForm', 'class'=> 'form-horizontal bootstrap-validator-form')); ?>
	<input type="hidden" value="1" name="sendform">
	<input type="hidden" name="idVehiculo" id="idVehiculo" value="<?php echo $vehiculo['id'];?>" >
	<input type="hidden" name="idSiniestro" id="idSiniestro" value="<?php echo $id_siniestro;?>" >
	<div class="row">	
		<div class="col-xs-12 col-sm-12">
			<div class="box">
				<div class="box-header">
					<div class="box-name">
						<i class="fa fa-folder-open-o"></i>
						<span>Datos del veh&iacute;culo</span>
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
							<label class="col-sm-3 control-label">Tipo de veh&iacute;culo</label>
							<div class="col-sm-3">
								<select id="tipo" name="tipo">
									<?php foreach ($tipovehiculos as $tipovehiculo){ ?>
									<option value="<?php echo $tipovehiculo->tipovehiculo; ?>" <?php if ($tipovehiculo->tipovehiculo == $vehiculo['tipo']) echo "selected=selected";?> >
										<?php echo $tipovehiculo->tipovehiculo; ?>
									</option>
								<?php }?>	
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Marca</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="marca" name="marca" value="<?php if (isset($vehiculo)){echo $vehiculo['marca'];} ?>"  />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Modelo</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="modelo" name="modelo" value="<?php if (isset($vehiculo)){echo $vehiculo['modelo'];} ?>"  />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">A&ntilde;o</label>
							<div class="col-sm-2">
								<input type="text" class="form-control" id="anio" name="anio" value="<?php if (isset($vehiculo)){echo $vehiculo['anio'];} ?>"  />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Patente</label>
							<div class="col-sm-2">
								<input type="text" class="form-control" id="patente" name="patente" value="<?php if (isset($vehiculo)){echo $vehiculo['patente'];} ?>" onKeyPress="return soloNumeros(event)" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Color</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="color" name="color" value="<?php if (isset($vehiculo)){echo $vehiculo['color'];} ?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Seguro</label>
							<div class="col-sm-2">
								<select name="seguro"  id="seguro" >
									<option value=""></option>
									<option <?php if (isset($vehiculo) && $vehiculo['seguro'] == "VIGENTE") echo "selected=selected"; ?> value="VIGENTE">VIGENTE</option>
									<option <?php if (isset($vehiculo) && $vehiculo['seguro'] == "NO POSEE") echo "selected=selected"; ?> value="NO POSEE">NO POSEE</option>
									<option <?php if (isset($vehiculo) && $vehiculo['seguro'] == "VENCIDO") echo "selected=selected"; ?> value="VENCIDO">VENCIDO</option>
									<option <?php if (isset($vehiculo) && $vehiculo['seguro'] == "NO CORRESPONDE") echo "selected=selected"; ?> value="NO CORRESPONDE">NO CORRESPONDE</option>
									<option <?php if (isset($vehiculo) && $vehiculo['seguro'] == "SE IGNORA") echo "selected=selected"; ?> value="SE IGNORA">SE IGNORA</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">VTV</label>
							<div class="col-sm-2">
								<select name="vtv"  id="vtv" >
									<option value=""></option>
									<option <?php if (isset($vehiculo) && $vehiculo['vtv'] == "VIGENTE") echo "selected=selected"; ?> value="VIGENTE">VIGENTE</option>
									<option <?php if (isset($vehiculo) && $vehiculo['vtv'] == "NO POSEE") echo "selected=selected"; ?> value="NO POSEE">NO POSEE</option>
									<option <?php if (isset($vehiculo) && $vehiculo['vtv'] == "VENCIDO") echo "selected=selected"; ?> value="VENCIDO">VENCIDO</option>
									<option <?php if (isset($vehiculo) && $vehiculo['vtv'] == "NO CORRESPONDE") echo "selected=selected"; ?> value="NO CORRESPONDE">NO CORRESPONDE</option>
									<option <?php if (isset($vehiculo) && $vehiculo['vtv'] == "SE IGNORA") echo "selected=selected"; ?> value="SE IGNORA">SE IGNORA</option>
								</select>
							</div>
						</div>
						
						<div style="width:100%;text-align:center;padding:10px">
							<a href="#" onclick="$('#siniestrosForm').submit()">
								<button class="btn btn-primary btn-label-left" type="button">
									Guardar
								</button>
								<a href="javascript:window.history.go(-1);">
									<button class="btn btn-primary btn-label-left" type="button">
										Cancelar
									</button>
								</a>
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

	function soloNumeros(e) {
	    key = e.keyCode || e.which;
	    tecla = String.fromCharCode(key).toLowerCase();
	    letras = " 12345678890áéíóúabcdefghijklmnñopqrstuvwxyz";
	    especiales = [];
	
	    tecla_especial = false
	    for(var i in especiales) {
	        if(key == especiales[i]) {
	            tecla_especial = true;
	            break;
	        }
	    }
	
	    if(letras.indexOf(tecla) == -1 && !tecla_especial)
	        return false;
	}

	function Select2Test(){
		$("#tipo").select2();
		$("#seguro").select2();
		$("#vtv").select2();

	}
	$(document).ready(function() {
		LoadSelect2Script(Select2Test);
		LoadBootstrapValidatorScript(FormValidator);
		WinMove();
	});
	
</script>

