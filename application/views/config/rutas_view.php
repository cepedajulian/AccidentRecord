
<!--Start Content-->
<div id="content" class="col-xs-12 col-sm-10">

	<div class="row">
		<div id="breadcrumb" class="col-md-12">
			<a href="#" class="show-sidebar"><i class="fa fa-bars"></i></a>
			<ol class="breadcrumb">
				<li><a href="<?php echo site_url('/home/'); ?>">Inicio</a></li>
				<li>Rutas</li>
			</ol>
		</div>
	</div>
	
	<?php echo form_open('config/searchRutas', array('id' => 'formRutas', 'class'=> 'form-horizontal bootstrap-validator-form')); ?>
	
	<div class="row">
		<div class="col-xs-12">
			<h3 class="page-header">Rutas</h3>
			<br>
			<?php if ( ! empty($msg)){ echo "<p class='bg-success'>".$msg."</p>"; }?>
			<?php if ( ! empty($error)){ echo "<p class='bg-danger'>".$error."</p>"; }?>
			
			<?php if (!empty($this->session->flashdata('total'))){?>
				<?php echo "<p class='bg-success'><b>Total de registros procesados:</b> ". $this->session->flashdata('total');?>
				<?php echo "<br><b>Total de rutas nuevas:</b> ". $this->session->flashdata('nuevas');?>
				<?php echo "<br><b>Total de rutas repetidas:</b> ". $this->session->flashdata('repetidas')."</p><br>";?>
			<?php }?>
			
			<br>
			<?php if (!empty($permisos['config_crutas'])){?>
				<a href="<?php echo site_url('/config/crutas/') ?>">
					<button class="btn btn-primary btn-label-left" type="button">
						<span><i class="fa fa-plus-circle"></i></span>
						Agregar Ruta
					</button>
				</a>
			<?php }?>
			
			<?php if (!empty($permisos['config_importrutas'])){?>
				<a href="<?php echo site_url('/config/importrutas/') ?>">
					<button class="btn btn-primary btn-label-left" type="button">
						<span><i class="fa fa-plus-circle"></i></span>
						Importar Rutas
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
						<span>Registro de rutas (<?php echo count($rutas); ?>)</span>
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
								<th>Ruta</th>
								<th>Acciones</th>
							</tr>	
						</thead>
						<tbody>
							<?php 
							if (count($rutas) == 0){
								echo "<tr>";
								echo "<td colspan='3'>No hay resultados para mostrar.</tr>";
								echo "</tr>";
							}
							foreach($rutas as $ruta) 
							{
								echo "<tr>";
								    echo "<td>".strtoupper($ruta->ruta)."</td>";
								    echo "<td width='120px' align='right'>";
									    if (!empty($permisos['config_urutas'])){
									    	echo "<a href='".site_url('/config/urutas/'.$ruta->id)."' title='Edicion' alt='Edicion'>";
												echo "<i class='fa fa-lg  fa-pencil-square-o'></i></span>";
											echo "</a>&nbsp;&nbsp;";
								    	}
								    	
										if (!empty($permisos['config_drutas'])){
											echo "<a href='".site_url('/config/drutas/'.$ruta->id)."' title='Borrar' alt='Borrar'>";
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
							
			