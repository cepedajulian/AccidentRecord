<!--Start Content-->

<div id="content" class="col-xs-12 col-sm-10">

	<div class="row">
		<div id="breadcrumb" class="col-md-12">
			<ol class="breadcrumb">
				<li><a href="<?php echo site_url('/home/'); ?>">Inicio</a></li>
				<li><a href="<?php echo site_url('/users/index'); ?>">Usuarios</a></li>
				<li><a href="#">Datos del usuario</a></li>
			</ol>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<h3 class="page-header">Datos del usuario</h3>
			<BR>
			<?php
				$error =   $this->session->flashdata('error');
				if (!empty($error))
					echo "<p class='bg-danger'>".$error."</p>"; ?>
			<?php  if (validation_errors()) echo "<div class='bg-danger'>".utf8_encode(validation_errors())."</div>"; ?>
			<br>
		</div>	
	</div>
	
	<div class="row">	
		<div class="col-xs-12">
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
					<?php echo form_open('users/add', array('id' => 'usersForm', 'class'=> 'form-horizontal bootstrap-validator-form')); ?>
					<input type="hidden" value="1" name="sendform">
					<input type="hidden" value="<?php if (isset($user)){echo $user['id'];} ?>" name="id" id="id">
					<input type="hidden" value="<?php if (isset($user)){echo $user['last_login'];} ?>" name="last_login" id="last_login">
					<br>
					<fieldset>
						<?php if (empty($id_ciudad)){?>
						<div class="form-group">
							<label class="col-sm-3 control-label">Municipio</label>
							<div class="col-sm-4">
								<select id="id_ciudad" name="id_ciudad">
									<option value="">TODOS</option>
									<?php foreach($ciudades as $ciudad){?>
									<option  value="<?php echo $ciudad->id; ?>" <?php if($ciudad->id == $user['id_ciudad']) echo "selected=selected"; ?>>
										<?php echo $ciudad->ciudad; ?>
									</option>
									<?php }?>
								</select>
							</div>
						</div>
						<?php }?>
						<div class="form-group">
							<label class="col-sm-3 control-label">Nombre de usuario</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="username" name="username" value="<?php if (isset($user['username'])){echo $user['username'];} ?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Contrase&ntilde;a</label>
							<div class="col-sm-2">
								<input type="password" class="form-control" id="password" name="password" value="" />
							</div>
							<img src="<?php echo base_url();?>assets/img/help.png" width="25px" alt="Se recomienda usar m&aacute;s de 6 caracteres, usar May&uacute;sculas, min&uacute;sculas y n&uacute;meros" title="Se recomienda usar m&aacute;s de 6 caracteres, usar May&uacute;sculas, min&uacute;sculas y n&uacute;meros.">
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Repita la contrase&ntilde;a</label>
							<div class="col-sm-2">
								<input type="password" class="form-control" id="passconf" name="passconf" value="" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Email</label>
							<div class="col-sm-5">
								<input type="text" class="form-control" id="mail" name="mail"  value="<?php if (isset($user['mail'])){echo $user['mail'];} ?>" />
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label">Roles</label>
							<div class="col-sm-3">
								<?php
								if (!empty($roles))
									  foreach ($roles as $rol){?>
									    <div >
											<label>
												<input type="radio" name="roles" <?php if (isset($user) &&  !empty ($user['roles']) && in_array($rol->roleName, $user['roles'])) echo "checked='checked'" ?> value="<?php echo $rol->ID?>">
												<?php echo $rol->roleName?>
											</label>
										</div>
								<?php }?>
							</div>
						</div>
					</fieldset>
					<div style="width:100%;text-align:center;padding:10px">
						<a href="#" onclick="$('#usersForm').submit()">
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
			</div>
		</div>
	</div>

</div><!--End Content-->

<script src="<?php echo base_url();?>assets/plugins/select2/select2.js"></script>
<script src="<?php echo base_url();?>assets/plugins/bootstrapvalidator/bootstrapValidator.min.js"></script>
<script src="<?php echo base_url();?>assets/js/validations.js"></script>

<script type="text/javascript">


	function Select2Test(){
		$("#id_ciudad").select2();
		
	}
	$(document).ready(function() {
		// Load example of form validation
		LoadBootstrapValidatorScript(FormValidator);
		// Load script of Select2 and run this
		LoadSelect2Script(Select2Test);
		WinMove();
		
	});
	
</script>

