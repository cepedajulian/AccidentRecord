<script src="<?php echo base_url();?>assets/js/ajaxfileupload.js"></script>
<script type="text/javascript">
$(function() {
    $('#upload_file').submit(function(e) {
        $.ajaxFileUpload({
            url             :'<?php echo base_url();?>/index.php/config/upload_file/<?php echo $id_ciudad;?>',
            secureuri       :false,
            fileElementId   :'userfile',
            dataType        : 'json',
            success : function (data, status)
            {
                if(data.status != 'error')
                {
                	$('#files').html('');
                    $('#files').html('<p><img width="180px" src="<?php echo base_url();?>/assets/img/logos/'+data.filename+'?t=<?php echo rand();?>"></p>');
                    $('#foto').val(data.filename);
                }
            }
        });
        return false;
    });
});

</script>
<!--Start Content-->
<div id="content" class="col-xs-12 col-sm-10">

	<div class="row">
		<div id="breadcrumb" class="col-md-12">
			<a href="#" class="show-sidebar"><i class="fa fa-bars"></i></a>
			<ol class="breadcrumb">
				<li><a href="<?php echo site_url('/home/'); ?>">Inicio</a></li>
				<li><a href="<?php echo site_url('/config/localidades/'); ?>">Configuraci&oacute;n</a></li>
				<li><a href="#">Configuraci&oacute;n general</a></li>
			</ol>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<h3 class="page-header">Configuraci&oacute;n general</h3>
			<BR>
			<?php  if (validation_errors()) echo "<div class='bg-danger'>".utf8_encode(validation_errors())."</div>"; ?>
			<?php if ( ! empty($msg)) echo "<p class='bg-success'>".$this->session->flashdata('msg')."</p>"; ?>
			<?php if ( ! empty($error)){ echo "<p class='bg-danger'>".$error."</p>"; }?>
			<br>
		</div>	
	</div>
	
	<?php echo form_open('config/index', array('id' => 'configForm', 'class'=> 'form-horizontal bootstrap-validator-form', 'enctype'=> 'multipart/form-data')); ?>
	<input type="hidden" value="1" name="sendform">
	<input type="hidden" value="" name="foto" id="foto">
	<input type="hidden"  name="id" id="id" value="<?php echo $id_ciudad; ?>" >
					
	<div class="row">	
	
		<div class="col-xs-12 col-sm-12">
			<div class="box">
				<div class="box-header">
					<div class="box-name">
						<i class="fa fa-folder-open-o"></i>
						<span>Datos del Municipio</span>
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
								<input type="text" readonly="readonly" class="form-control" nombre="ciudad" id="ciudad" value="<?php if (isset($ciudad)){echo $ciudad['ciudad'];} ?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Coordenadas</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" id="coordenadas" name="coordenadas" value="<?php if (isset($ciudad)){echo $ciudad['coordenadas'];} ?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Zoom</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" id="zoom" name="zoom" value="<?php if (isset($ciudad)){echo $ciudad['zoom'];} ?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Ancho del logo</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" id="logo_width" name="logo_width" value="<?php if (isset($ciudad)){echo $ciudad['logo_width'];} ?>" />
							</div>
						</div>
						<?php echo form_close(); ?>
						<div class="form-group">
							<form method="post" action="" id="upload_file">
						        <div class="form-group">
									<label class="col-sm-3 control-label" style="text-align:right;">Imagen</label>
									<div class="col-sm-3">
								        <input type="file" name="userfile" id="userfile" size="20" />
								        <input type="submit" name="submit" id="submit" value="Subir logo" />
								        <br><br>
								        * Solo es v&aacute;lido archivos .PNG
								        <br><br>
								        <div id="files" style="padding-left:20px">
							        		<img width="180px" src="<?php echo base_url();?>assets/img/logos/<?php echo $ciudad['id'];?>.png">
								        </div>
								    </div>
								</div>
						    </form>
			            </div>
					</fieldset>	
					
					<br><br>
					<div style="width:100%;text-align:center;padding:10px">
						<a href="#" onclick="$('#configForm').submit()">
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
</div><!--End Content-->
