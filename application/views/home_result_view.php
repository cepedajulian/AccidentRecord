
<!--Start Content-->
<div id="content" class="col-xs-12 col-sm-10">
	
	<div class="row">
		<div id="breadcrumb" class="col-md-12">
			<a href="#" class="show-sidebar"><i class="fa fa-bars"></i></a>
			<ol class="breadcrumb">
				<li><a href="#">Inicio</a></li>
			</ol>
		</div>
	</div>
	<h4>Informaci&oacute;n relacioanada a:</h4>
	<?php if (!empty($patente)){?>
		<h3>Patente: <?php echo $patente; ?></h3>
	<?php }if (!empty($dni)){?>
		<h3>DNI: <?php echo $dni; ?></h3>
	<?php } ?>
	<br>


	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<div class="box-name">
						<i class="fa fa-folder-open-o"></i>
						<span>Registro de Siniestros (<?php echo count($siniestros); ?>)</span>
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
								<th id="sort_fecha" class="sorting" onclick="ordenar('fecha')">Fecha</th>
								<th id="sort_tipoaccidente" class="sorting" onclick="ordenar('tipoaccidente')">Tipo de Accidente</th>
								<th id="sort_lugar" class="sorting" onclick="ordenar('lugar')">Lugar</th>
								<th id="sort_victimas" class="sorting" onclick="ordenar('victimas')">Victimas</th>
								<th>Acciones</th>
							</tr>	
						</thead>
						<tbody>
							<?php 
							foreach($siniestros as $siniestro) 
							{
								echo "<tr>";
									echo "<td>".$siniestro->fecha."</td>";
								    echo "<td>".utf8_decode($siniestro->tipo)."</td>";
								    echo "<td>";
								    	
								    	if (empty($siniestro->nro))
								    		$nro = "";
								    	else
								    		$nro = "";
								    	
								    	if (!empty($siniestro->calle3))
								    		echo utf8_decode($siniestro->calle1).' '.$nro .'(entre: '.utf8_decode($siniestro->calle2).' y '.utf8_decode($siniestro->calle3).')';
								    	else
								    		echo utf8_decode($siniestro->calle1).' '.$nro .'(esquina: '.utf8_decode($siniestro->calle2).')';
								    echo "</td>";
								    echo "<td style='text-align:center'>".$siniestro->victimas."</td>";

								    echo "<td width='100px' align='right'>";
							    
									    if (!empty($permisos['siniestros_details'])){
									    	echo "<a href='".site_url('/siniestros/details/'.$siniestro->id)."'>";
									    	echo "<i class='fa fa-lg  fa-list-alt' title='Detalles' alt='Detalles' ></i></span>";
									    	echo "<a/>&nbsp;&nbsp;";
									    }	
								    
									    if (!empty($permisos['siniestros_victimas'])){
									    	echo "<a href='".site_url('/siniestros/victimas/'.$siniestro->id)."'>";
									    	echo "<i class='fa fa-lg  fa fa-user-md' title='Victimas' alt='Victimas'></i></span>";
									    	echo "<a/>&nbsp;&nbsp;";
									    }
										
									echo "</td>";
							    echo "</tr>";
							}
							?>
						</tbody>
					</table>
				 </div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<div class="box-name">
						<i class="fa fa-folder-open-o"></i>
						<span>Registro de V&iacute;ctimas (<?php echo count($victimas); ?>)</span>
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
								<th>DNI</th>
								<th>Nombre</th>
								<th>Sexo</th>
								<th>Edad</th>
								<th>Veh&iacute;culo</th>
								<th>Casco</th>
								<th>Cinturon</th>
								<th>Conductor</th>
								<th>Lesi&oacute;n</th>
							</tr>	
						</thead>
						<tbody>
							<?php 
							foreach($victimas as $victima) 
							{
								echo "<tr>";
									echo "<td>".$victima->dni."</td>";
								    echo "<td>".utf8_decode($victima->nombre)."</td>";
								    echo "<td align='center'>".$victima->sexo."</td>";
								    echo "<td>".$victima->edad."</td>";
								    echo "<td>".$victima->tipovehiculo."</td>";
								    echo "<td align='center'>".getTextVal($victima->casco)."</td>";
								    echo "<td align='center'>".getTextVal($victima->cinturon)."</td>";
								    echo "<td align='center'>".getTextVal($victima->conductor)."</td>";
								    echo "<td>".utf8_decode($victima->lesion)."</td>";
							    echo "</tr>";
							}
							?>
						</tbody>
					</table>
				 </div>
			</div>
		</div>
	</div>
	
	
	
</div><!--End Content-->
<?php 
function getTextVal($val){
	if (empty($val))
		return "NO";
	else if ($val == 1)
		return "SI";
	else 
		return "N/A";	
}
?>							
							
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

	function notificar(){
		$('#formLicencias').attr("action","licencias/notificar");
		$('#formLicencias').submit();
	}

	function selectAllCb(source) {
	  checkboxes = document.getElementsByName('notificaciones[]');
	  for(var i=0, n=checkboxes.length;i<n;i++) {
	    checkboxes[i].checked = source.checked;
	  }
	}

	
</script>