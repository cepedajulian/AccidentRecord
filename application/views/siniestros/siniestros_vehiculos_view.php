<!--Start Content-->
<div id="content" class="col-xs-12 col-sm-10">

	<div class="row">
		<div id="breadcrumb" class="col-md-12">
			<a href="#" class="show-sidebar"><i class="fa fa-bars"></i></a>
			<ol class="breadcrumb">
				<li><a href="<?php echo site_url('/home/'); ?>">Inicio</a></li>
				<li><a href="<?php echo site_url('/siniestros/'); ?>">Siniestros</a></li>
				<li>Veh&iacute;culos</li>
			</ol>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<h3 class="page-header">Veh&iacute;culos</h3>
			<br>
			<?php if ( ! empty($msg)){ echo "<p class='bg-success'>".$msg."</p>"; }?>
			<?php if ( ! empty($error)){ echo "<p class='bg-danger'>".$error."</p>"; }?>
			<br>
			<?php if (!empty($permisos['siniestros_addvehiculo']) && !empty($user['id_ciudad'] )){?>
				<a href="<?php echo site_url('/siniestros/addvehiculo/'.$id_siniestro) ?>">
					<button class="btn btn-primary btn-label-left" type="button">
						<span><i class="fa fa-plus-circle"></i></span>
						Agregar Veh&iacute;culo
					</button>
				</a>
			<?php }?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<div class="box-name">
						<i class="fa fa-folder-open-o"></i>
						<span>Registro de Veh&iacute;culos (<?php echo count($vehiculos); ?>)</span>
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
								<th>Tipo</th>
								<th>Marca</th>
								<th>Modelo</th>
								<th>A&ntilde;o</th>
								<th>Color</th>
								<th>Seguro</th>
								<th>VTV</th>
								<th>Acciones</th>
							</tr>	
						</thead>
						<tbody>
							<?php 
							foreach($vehiculos as $vehiculo) 
							{
								echo "<tr>";
									echo "<td>".$vehiculo->tipo."</td>";
								    echo "<td>".$vehiculo->marca."</td>";
								    echo "<td>".$vehiculo->modelo."</td>";
								    echo "<td>".$vehiculo->anio."</td>";
								    echo "<td>".$vehiculo->color."</td>";
								    echo "<td>".$vehiculo->seguro."</td>";
								    echo "<td>".$vehiculo->vtv."</td>";
								    echo "<td width='100px' align='right'>";
							    
									    if (!empty($permisos['siniestros_updatevehiculo'])&& !empty($user['id_ciudad'] )){
									    	echo "<a href='".site_url('/siniestros/updatevehiculo/'.$vehiculo->idVehiculo)."'>";
												echo "<i class='fa fa-lg  fa-pencil-square-o'></i></span>";
											echo "<a/>&nbsp;&nbsp;";
								    	}
								    	
										if (!empty($permisos['siniestros_deletevehiculo'])&& !empty($user['id_ciudad'] )){
											echo "<a href='".site_url('/siniestros/deletevehiculo/'.$vehiculo->idVehiculo)."'>";
											echo "<i class='fa fa-lg fa-trash-o'></i></span>";
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