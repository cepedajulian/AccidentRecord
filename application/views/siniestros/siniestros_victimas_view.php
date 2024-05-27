<!--Start Content-->
<div id="content" class="col-xs-12 col-sm-10">

	<div class="row">
		<div id="breadcrumb" class="col-md-12">
			<a href="#" class="show-sidebar"><i class="fa fa-bars"></i></a>
			<ol class="breadcrumb">
				<li><a href="<?php echo site_url('/home/'); ?>">Inicio</a></li>
				<li><a href="<?php echo site_url('/siniestros/'); ?>">Siniestros</a></li>
				<li>Implicados</li>
			</ol>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<h3 class="page-header">Implicados</h3>
			<br>
			<?php if ( ! empty($msg)){ echo "<p class='bg-success'>".$msg."</p>"; }?>
			<?php if ( ! empty($error)){ echo "<p class='bg-danger'>".$error."</p>"; }?>
			<br>
			<?php if (!empty($permisos['siniestros_addvictimas']) && !empty($user['id_ciudad'] )){?>
				<a href="<?php echo site_url('/siniestros/addvictimas/'.$id_siniestro) ?>">
					<button class="btn btn-primary btn-label-left" type="button">
						<span><i class="fa fa-plus-circle"></i></span>
						Agregar V&iacute;ctima
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
						<span>Registro de Implicados (<?php echo count($victimas); ?>)</span>
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
								<th>Condici&oacute;n</th>
								<th>Casco</th>
								<th>Cinturon</th>
								<th>Lesi&oacute;n</th>
								<th>Acciones</th>
							</tr>	
						</thead>
						<tbody>
							<?php 
							foreach($victimas as $victima) 
							{
								echo "<tr>";
									echo "<td>".$victima->dni."</td>";
								    echo "<td>".$victima->nombre."</td>";
								    echo "<td align='center'>".$victima->sexo."</td>";
								    echo "<td>ENTRE ".$victima->edad." A&Ntilde;OS</td>";
								    echo "<td>$victima->tipo</td>";
								    echo "<td>".$victima->condicion."</td>";
								    echo "<td align='center'>".getTextVal($victima->casco)."</td>";
								    echo "<td align='center'>".getTextVal($victima->cinturon)."</td>";
								    echo "<td>".$victima->lesion."</td>";
								    echo "<td width='100px' align='right'>";
							    
									    if (!empty($permisos['siniestros_updatevictimas']) && !empty($user['id_ciudad'] )){
									    	echo "<a href='".site_url('/siniestros/updatevictimas/'.$victima->idVictima)."'>";
												echo "<i class='fa fa-lg  fa-pencil-square-o'></i></span>";
											echo "<a/>&nbsp;&nbsp;";
								    	}
								    	
										if (!empty($permisos['siniestros_deletevictimas']) && !empty($user['id_ciudad'] )){
											echo "<a href='".site_url('/siniestros/deletevictimas/'.$victima->idVictima)."'>";
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