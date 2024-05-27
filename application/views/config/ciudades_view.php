
<!--Start Content-->
<div id="content" class="col-xs-12 col-sm-10">

	<div class="row">
		<div id="breadcrumb" class="col-md-12">
			<a href="#" class="show-sidebar"><i class="fa fa-bars"></i></a>
			<ol class="breadcrumb">
				<li><a href="<?php echo site_url('/home/'); ?>">Inicio</a></li>
				<li>Municipios</li>
			</ol>
		</div>
	</div>
	
	<?php echo form_open('config/searchCiudades', array('id' => 'formCiudades', 'class'=> 'form-horizontal bootstrap-validator-form')); ?>
	
	<div class="row">
		<div class="col-xs-12">
			<h3 class="page-header">Municipios</h3>
			<br>
			<?php if ( ! empty($msg)){ echo "<p class='bg-success'>".$msg."</p>"; }?>
			<?php if ( ! empty($error)){ echo "<p class='bg-danger'>".$error."</p>"; }?>
			
			<?php if (!empty($this->session->flashdata('total'))){?>
				<?php echo "<p class='bg-success'><b>Total de registros procesados:</b> ". $this->session->flashdata('total');?>
				<?php echo "<br><b>Total de ciudades nuevas:</b> ". $this->session->flashdata('nuevas');?>
				<?php echo "<br><b>Total de ciudades repetidas:</b> ". $this->session->flashdata('repetidas')."</p><br>";?>
			<?php }?>
			
			<br>
			
			<?php if (!empty($permisos['config_cciudades'])){?>
				<a href="<?php echo site_url('/config/cciudades/') ?>">
					<button class="btn btn-primary btn-label-left" type="button">
						<span><i class="fa fa-plus-circle"></i></span>
						Agregar Municipio
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
						<span>Registro de Municipios (<?php echo count($ciudades); ?>)</span>
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
								<th>Municipio</th>
								<th>Coordenadas</th>
								<th>Zoom</th>
								<th>Ancho del Logo</th>
								<th>Acciones</th>
							</tr>	
						</thead>
						<tbody>
							<?php 
							if (count($ciudades) == 0){
								echo "<tr>";
								echo "<td colspan='3'>No hay resultados para mostrar.</tr>";
								echo "</tr>";
							}
							foreach($ciudades as $ciudad) 
							{
								echo "<tr>";
									echo "<td>".strtoupper($ciudad->ciudad)."</td>";
								    echo "<td>".strtoupper($ciudad->coordenadas)."</td>";
								    echo "<td>".strtoupper($ciudad->zoom)."</td>";
								    echo "<td>".strtoupper($ciudad->logo_width)."</td>";
								    echo "<td width='120px' align='right'>";
									    if (!empty($permisos['config_uciudades'])){
									    	echo "<a href='".site_url('/config/uciudades/'.$ciudad->id)."' title='Edicion' alt='Edicion'>";
												echo "<i class='fa fa-lg  fa-pencil-square-o'></i></span>";
											echo "</a>&nbsp;&nbsp;";
								    	}
								    	
										if (!empty($permisos['config_dciudades'])){
											echo "<a href='".site_url('/config/dciudades/'.$ciudad->id)."' title='Borrar' alt='Borrar'>";
											echo "<i class='fa fa-lg fa-trash-o'></i></span>";
											echo "</a>&nbsp;&nbsp;";
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
	
	<?php echo form_close(); ?>   
	
</div><!--End Content-->