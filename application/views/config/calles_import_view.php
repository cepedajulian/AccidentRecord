<!--Start Content-->
<div id="content" class="col-xs-12 col-sm-10">

	<div class="row">
		<div id="breadcrumb" class="col-md-12">
			<a href="#" class="show-sidebar"><i class="fa fa-bars"></i></a>
			<ol class="breadcrumb">
				<li><a href="<?php echo site_url('/home/'); ?>">Inicio</a></li>
				<li><a href="<?php echo site_url('/config/calles/'); ?>">Calles</a></li>
				<li><a href="#">Importaci&oacute;n de Calles</a></li>
			</ol>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<h3 class="page-header">Importaci&oacute;n de Calles</h3>
			<BR>
			<?php  if (validation_errors()) echo "<div class='bg-danger'>".utf8_encode(validation_errors())."</div>"; ?>
			<br>
		</div>	
	</div>
	
	<?php echo form_open_multipart('config/importcalles', array('id' => 'callesForm', 'class'=> 'form-horizontal bootstrap-validator-form')); ?>
	<input type="hidden" value="1" name="sendform">
					
	<div class="row">	
		<div class="col-xs-12 col-sm-12">
			<div class="box">
				<div class="box-header">
					<div class="box-name">
						<i class="fa fa-folder-open-o"></i>
						<span>Carga de Calles</span>
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
							<label class="col-sm-3 control-label">Localidad</label>
							<div class="col-sm-4">
								<select id="id_localidad" name="id_localidad">
									<option value="">TODAS</option>
									<?php foreach($localidades as $localidad){?>
									<option  value="<?php echo $localidad->id; ?>" >
										<?php echo $localidad->localidad; ?>
									</option>
									<?php }?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<input type="hidden" value="1" name="sendform">
							<label class="col-sm-3 control-label">Seleccionar archivo de calles:</label>
							<div class="col-sm-8"> 
								<input name="userfile" type="file" style="float:left" /> 
								<img id="progress" style="float:left; display:none" src="<?php echo base_url();?>assets/img/progress.gif">
								<br /><br />
								<a href="#" onclick="$('#progress').css('display','block');$('#callesForm').submit()">
									<button class="btn btn-primary btn-label-left" type="button">
										Importar
									</button>
								</a>
							</div>
						</div>
					</fieldset>	
					<div style="padding:20px">
					<?php if (isset($procesados)){
						echo "<b>Cantidad de procesados:</b> ".$procesados."<br>";
						echo "<b>Cantidad de calles nuevas:</b> ".$agregados."<br>";
						echo "<b>Cantidad de calles actualizadas:</b> ".$actualizados."<br>";
						echo "<b>Cantidad de errores:</b> ".$errores."<br>";
					} ?>
					</div>
					<br><br>
					
				</div>
			</div>
		</div>
	</div>
	<?php echo form_close(); ?>

</div><!--End Content-->
<script src="<?php echo base_url();?>assets/plugins/select2/select2.js"></script>
<script src="<?php echo base_url();?>assets/plugins/bootstrapvalidator/bootstrapValidator.min.js"></script>
<script src="<?php echo base_url();?>assets/js/validations.js"></script>

<script type="text/javascript">
	function Select2Test(){
		$("#id_localidad").select2();
		
	}
	$(document).ready(function() {
		// Load example of form validation
		LoadBootstrapValidatorScript(FormValidator);
		// Load script of Select2 and run this
		LoadSelect2Script(Select2Test);
		WinMove();
	});
</script>
