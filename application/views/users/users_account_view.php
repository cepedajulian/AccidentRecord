<!--Start Content-->
<div id="content" class="col-xs-12 col-sm-10">

	<div class="row">
		<div id="breadcrumb" class="col-md-12">
			<ol class="breadcrumb">
				<li><a href="<?php echo site_url('/home/'); ?>">Inicio</a></li>
				<li><a href="#">Mi Cuenta</a></li>
			</ol>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<h3 class="page-header">Cuenta de usuario</h3>
			<BR>
			<?php  if (!empty($error)) echo "<div class='bg-danger'>".$error."</div>"; ?>
			<br>
		</div>	
	</div>
	
	<div class="row">	
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<div class="box-name">
						<i class="fa fa-folder-open-o"></i>
						<span>Datos de la cuenta</span>
					</div>
					<div class="box-icons">
						<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
						<a class="expand-link"><i class="fa fa-expand"></i></a>
						
					</div>
					<div class="no-move"></div>
				</div>
				<div class="box-content no-padding">
					<?php echo form_open('users/account', array('id' => 'usersForm', 'class'=> 'form-horizontal bootstrap-validator-form')); ?>
					<input type="hidden" value="1" name="sendform">
					<input type="hidden" value="<?php if (isset($user)){echo $user['id'];} ?>" name="id" id="id">
					<br>
					<fieldset>
						<div class="form-group">
							<label class="col-sm-3 control-label">Nombre</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" id="username" name="username" value="<?php if (isset($user)){echo $user['username'];} ?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Contrase&ntilde;a actual</label>
							<div class="col-sm-3">
								<input type="password" class="form-control" id="password_old" name="password_old" value="" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Contrase&ntilde;a nueva</label>
							<div class="col-sm-3">
								<input type="password" class="form-control" id="password" name="password" value="" />
							</div>
							<img src="<?php echo base_url();?>assets/img/help.png" width="25px" alt="Se recomienda usar m&aacute;s de 6 caracteres, usar May&uacute;sculas, min&uacute;sculas y n&uacute;meros" title="Se recomienda usar m&aacute;s de 6 caracteres, usar May&uacute;sculas, min&uacute;sculas y n&uacute;meros.">
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Repita la contrase&ntilde;a</label>
							<div class="col-sm-3">
								<input type="password" class="form-control" id="passconf" name="passconf" value="" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Email</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" id="mail" name="mail"  value="<?php if (isset($user)){echo $user['mail'];} ?>" />
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

<script src="<?php echo base_url();?>assets/plugins/bootstrapvalidator/bootstrapValidator.min.js"></script>
<script src="<?php echo base_url();?>assets/js/validations.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		// Load example of form validation
		LoadBootstrapValidatorScript(FormValidator);
		WinMove();
	});
</script>

