<!--Start Content-->
<div id="content" class="col-xs-12 col-sm-10">

	<div class="row">
		<div id="breadcrumb" class="col-md-12">
			<a href="#" class="show-sidebar"><i class="fa fa-bars"></i></a>
			<ol class="breadcrumb">
				<li><a href="<?php echo site_url('/home/'); ?>">Inicio</a></li>
				<li><a href="<?php echo site_url('/config/funcionarios/'); ?>">Funcionarios</a></li>
				<li><a href="#">Datos del Funcionario</a></li>
			</ol>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<h3 class="page-header">Datos del funcionario</h3>
			<BR>
			<?php  if (validation_errors()) echo "<div class='bg-danger'>".utf8_encode(validation_errors())."</div>"; ?>
			<br>
		</div>	
	</div>
	
	<?php echo form_open('config/cfuncionarios', array('id' => 'funcionariosForm', 'class'=> 'form-horizontal bootstrap-validator-form', 'enctype'=> 'multipart/form-data')); ?>
	<input type="hidden" value="1" name="sendform">
	<input type="hidden" value="" name="foto" id="foto">
	<input type="hidden" value="<?php if (isset($funcionario)){echo $funcionario['id'];} ?>" name="id" id="id">				
					
	<div class="row">	
	
		<div class="col-xs-12 col-sm-12">
			<div class="box">
				<div class="box-header">
					<div class="box-name">
						<i class="fa fa-folder-open-o"></i>
						<span>Datos de la persona</span>
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
							<div class="col-sm-4">
								<select id="id_ciudad" name="id_ciudad">
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
							<label class="col-sm-3 control-label">Nombre</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" id="funcionario" name="funcionario" value="<?php if (isset($funcionario)){echo $funcionario['funcionario'];} ?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Email</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" id="email" name="email"  value="<?php if (isset($funcionario)){echo $funcionario['email'];} ?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Celular</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="celular" name="celular"  value="<?php if (isset($funcionario)){echo $funcionario['celular'];} ?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Organismo</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="organismo" name="organismo"  value="<?php if (isset($funcionario)){echo $funcionario['organismo'];} ?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Cargo</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="cargo" name="cargo"  value="<?php if (isset($funcionario)){echo $funcionario['cargo'];} ?>" />
							</div>
						</div>
					</fieldset>	
					
					<br><br>
					<div style="width:100%;text-align:center;padding:10px">
						<a href="#" onclick="$('#funcionariosForm').submit()">
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
<script src="<?php echo base_url();?>assets/js/ajaxfileupload.js"></script>
<script type="text/javascript">
$(function() {
	
    $('#upload_file').submit(function(e) {
        e.preventDefault();
        $.ajaxFileUpload({
            url             :'<?php echo base_url();?>/index.php/config/upload_file',
            secureuri       :false,
            fileElementId   :'userfile',
            dataType        : 'json',
            success : function (data, status)
            {
                if(data.status != 'error')
                {
                    $('#files').html('<p><img width="120px" src="<?php echo base_url();?>/files/funcionarios/'+data.filename+'"></p>');
                    $('#foto').val(data.filename);
                }
            }
        });
        return false;
    });
});


</script>
<script src="<?php echo base_url();?>assets/plugins/select2/select2.js"></script>
<script src="<?php echo base_url();?>assets/plugins/bootstrapvalidator/bootstrapValidator.min.js"></script>
<script src="<?php echo base_url();?>assets/js/validations.js"></script>
<script type="text/javascript">

	function existeDNI(elem){
		$.ajax({
	        type: "POST",
	        url: "<?php echo base_url();?>index.php/config/existeDNI", 
	        data: {dni: elem.value },
	        cache:false,
	        success: 
	             function(data){
		        	if (data == "1"){
						$("#dni").val("");
						$("#errorDNI").css("display","block");
	        	  	}
	     		}
	     });
	}
	function Select2Test(){
		$("#id_ciudad").select2();
		
	}

	$(document).ready(function() {
		// Load script of Select2 and run this
		LoadSelect2Script(Select2Test);
		// Load example of form validation
		LoadBootstrapValidatorScript(FormValidator);
		WinMove();
	});
	//Preview de la imagen subida.
	/*function readURL(input) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();

	        reader.onload = function (e) {
	            $('#blah').attr('src', e.target.result);
	        }
	        $('.foto').css("display", "none");
	        reader.readAsDataURL(input.files[0]);
	    }
	}*/
</script>