<!--Start Content-->
<div id="content" class="col-xs-12 col-sm-10">

	<div class="row">
		<div id="breadcrumb" class="col-md-12">
			<a href="#" class="show-sidebar"><i class="fa fa-bars"></i></a>
			<ol class="breadcrumb">
				<li><a href="<?php echo site_url('/home/'); ?>">Inicio</a></li>
				<li><a href="<?php echo site_url('/config/localidades/'); ?>">Localidades</a></li>
				<li><a href="#">Datos de la localidad</a></li>
			</ol>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<h3 class="page-header">Datos de la localidad</h3>
			<BR>
			<?php  if (validation_errors()) echo "<div class='bg-danger'>".utf8_encode(validation_errors())."</div>"; ?>
			<?php if ( ! empty($error)){ echo "<p class='bg-danger'>".$error."</p>"; }?>
			<br>
		</div>	
	</div>
	
	<?php echo form_open('config/clocalidades', array('id' => 'localidadesForm', 'class'=> 'form-horizontal bootstrap-validator-form', 'enctype'=> 'multipart/form-data')); ?>
	<input type="hidden" value="1" name="sendform">
	<input type="hidden" value="<?php if (isset($localidad)){echo $localidad['id'];} ?>" name="id" id="id">				
					
	<div class="row">	
	
		<div class="col-xs-12 col-sm-12">
			<div class="box">
				<div class="box-header">
					<div class="box-name">
						<i class="fa fa-folder-open-o"></i>
						<span>Datos de la localidad</span>
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
							<label class="col-sm-3 control-label">Municipio</label>
							<div class="col-sm-4">
								<input type="text" readonly="readonly" class="form-control" id="ciudad" value="<?php if (isset($ciudad)){echo $ciudad['ciudad'];} ?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Localidad</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" id="localidad" name="localidad" value="<?php if (isset($localidad)){echo $localidad['localidad'];} ?>" />
							</div>
						</div>
					</fieldset>	
					
					<br><br>
					<div style="width:100%;text-align:center;padding:10px">
						<a href="#" onclick="$('#localidadesForm').submit()">
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
				</div>
			</div>
		</div>
	</div>
	<?php echo form_close(); ?>

</div><!--End Content-->
