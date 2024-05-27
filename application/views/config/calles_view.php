
<!--Start Content-->
<div id="content" class="col-xs-12 col-sm-10">

	<div class="row">
		<div id="breadcrumb" class="col-md-12">
			<a href="#" class="show-sidebar"><i class="fa fa-bars"></i></a>
			<ol class="breadcrumb">
				<li><a href="<?php echo site_url('/home/'); ?>">Inicio</a></li>
				<li>Calles</li>
			</ol>
		</div>
	</div>
	
	<?php echo form_open('config/searchCalles', array('id' => 'formCalles', 'class'=> 'form-horizontal bootstrap-validator-form')); ?>
	
	<div class="row">
		<div class="col-xs-12">
			<h3 class="page-header">Calles</h3>
			<br>
			<?php if ( ! empty($msg)){ echo "<p class='bg-success'>".$msg."</p>"; }?>
			<?php if ( ! empty($error)){ echo "<p class='bg-danger'>".$error."</p>"; }?>
			
			<?php if (!empty($this->session->flashdata('total'))){?>
				<?php echo "<p class='bg-success'><b>Total de registros procesados:</b> ". $this->session->flashdata('total');?>
				<?php echo "<br><b>Total de calles nuevas:</b> ". $this->session->flashdata('nuevas');?>
				<?php echo "<br><b>Total de calles repetidas:</b> ". $this->session->flashdata('repetidas')."</p><br>";?>
			<?php }?>
			
			<br>
			
			<?php if (!empty($permisos['config_ccalles'])){?>
				<a href="<?php echo site_url('/config/ccalles/') ?>">
					<button class="btn btn-primary btn-label-left" type="button">
						<span><i class="fa fa-plus-circle"></i></span>
						Agregar Calle
					</button>
				</a>
			<?php }?>
			
			<?php if (!empty($permisos['config_importcalles'])){?>
				<a href="<?php echo site_url('/config/importcalles/') ?>">
					<button class="btn btn-primary btn-label-left" type="button">
						<span><i class="fa fa-plus-circle"></i></span>
						Importar Calles
					</button>
				</a>
			<?php }?>
			
			<?php $this->load->view('templates/search', array("table"=>'calles')); ?>
		</div>
	</div>
	
	
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<div class="box-name">
						<i class="fa fa-folder-open-o"></i>
						<span>Registro de calles (<?php echo $total_rows; ?>)</span>
					</div>
					<div class="box-icons">
						<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
						<a class="expand-link"><i class="fa fa-expand"></i></a>
						
					</div>
					<div class="no-move"></div>
				</div>
				<div class="box-content no-padding">
					<table class="table table-bordered table-striped table-hover table-heading table-datatable" id="datatable-3">
						<thead>
							<tr>
								<?php if (empty($id_ciudad)){?>
									<th>Municipio</th>
								<?php }?>
								<th id="sort_calle" class="sorting" onclick="ordenar('calle')">Nombre</th>
								<th id="sort_localidad" class="sorting" onclick="ordenar('localidad')">Localidad</th>
								<th>Acciones</th>
							</tr>	
						</thead>
						<tbody>
							<?php 
							if ($total_rows == 0){
								echo "<tr>";
								echo "<td colspan='3'>No hay resultados para mostrar.</tr>";
								echo "</tr>";
							}
							foreach($calles as $calle) 
							{
								echo "<tr>";
									if (empty($id_ciudad)){
										echo "<td>".$calle->ciudad."</td>";
									}
								    echo "<td>".strtoupper($calle->calle)."</td>";
								    echo "<td>";
								    	if (empty($calle->localidad)) 
								    		echo strtoupper($calle->ciudad);
								    	else
								    		echo strtoupper($calle->localidad);
								    echo "</td>";
								    echo "<td width='120px' align='right'>";
									    if (!empty($permisos['config_ucalles'])){
									    	echo "<a href='".site_url('/config/ucalles/'.$calle->id)."' title='Edicion' alt='Edicion'>";
												echo "<i class='fa fa-lg  fa-pencil-square-o'></i></span>";
											echo "</a>&nbsp;&nbsp;";
								    	}
								    	
										if (!empty($permisos['config_dcalles'])){
											echo "<a href='".site_url('/config/dcalles/'.$calle->id)."' title='Borrar' alt='Borrar'>";
											echo "<i class='fa fa-lg fa-trash-o'></i></span>";
											echo "</a>&nbsp;&nbsp;";
										}
									echo "</td>";
							    echo "</tr>";
							}
							?>
						</tbody>
					</table>
				    <ul class="pagination"><?php echo $this->pagination->create_links(); ?></ul>
				 </div>
			</div>
		</div>
	</div>
	
	<?php echo form_close(); ?>   
	
</div><!--End Content-->
							
							
<script src="<?php echo base_url();?>assets/plugins/select2/select2.js"></script>
<script src="<?php echo base_url();?>assets/js/modal.popup.js"></script>		

<script>
	function Select2Test(){
		$("#t").select2();
	}
	$(document).ready(function() {
		LoadSelect2Script(Select2Test);
		$('#searchBoxLink').click();
		// Initialize datepicker
		$('#fd').datepicker({ dateFormat: "dd/mm/yy", altFormat: "yy-mm-dd",altField: "#fd" });
		$('#fh').datepicker({ dateFormat: "dd/mm/yy", altFormat: "yy-mm-dd",altField: "#fh" });
		$('#vd').datepicker({ dateFormat: "dd/mm/yy", altFormat: "yy-mm-dd",altField: "#vd" });
		$('#vh').datepicker({ dateFormat: "dd/mm/yy", altFormat: "yy-mm-dd",altField: "#vh" });
		
		//Change these values to style your modal popup
		var align = 'center';									//Valid values; left, right, center
		var top = 100; 											//Use an integer (in pixels)
		var width = 800; 										//Use an integer (in pixels)
		var padding = 10;										//Use an integer (in pixels)
		var backgroundColor = '#FFFFFF'; 						//Use any hex code
		var fadeOutTime = 300; 									//Use any integer, 0 = no fade
		var borderColor = '#333333'; 							//Use any hex code
		var borderWeight = 2; 									//Use an integer (in pixels)
		var borderRadius = 4; 									//Use an integer (in pixels)
		var disableColor = '#666666'; 							//Use any hex code
		var disableOpacity = 20; 								//Valid range 0-100
		var loadingImage = '<?php echo base_url();?>assets/img/loading.gif';		//Use relative path from this page
		
		//This method initialises the modal popup
	    $(".popupmodal").click(function() {
	    	window.open("<?php echo site_url('presupuestos/popupprint/'); ?>/"+this.id+"/"+$('#id_cliente').val(), "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=500, left=500, width=900, height=500");
	        //modalPopup(align, top, width, padding, disableColor, disableOpacity, backgroundColor, borderColor, borderWeight, borderRadius, fadeOutTime, "<?php echo site_url('presupuestos/popupprint/'); ?>/"+this.id+"/"+$('#id_cliente').val(), loadingImage);
	    });
	    
		//This method hides the popup when the escape key is pressed
		$(document).keyup(function(e) {
			if (e.keyCode == 27) {
				closePopup(fadeOutTime);
			}
		});
		
	});





	
</script>