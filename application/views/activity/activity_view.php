<!--Start Content-->
<div id="content" class="col-xs-12 col-sm-10">

	<div class="row">
		<div id="breadcrumb" class="col-md-12">
			<a href="#" class="show-sidebar"><i class="fa fa-bars"></i></a>
			<ol class="breadcrumb">
				<li><a href="<?php echo site_url('/home/'); ?>">Inicio</a></li>
				<li>Actividad de Usuarios</li>
			</ol>
		</div>
	</div>
	
	<?php $attributes = array('id' => 'formActivity');?>
	<?php echo form_open('activity/search',$attributes); ?>
	
	<div class="row">
		<div class="col-xs-12">
			<h3 class="page-header">Actividad de Usuarios</h3>
			<br>
			<?php if ( ! empty($msg)){ echo "<p class='bg-success'>".$msg."</p>"; }?>
			<?php if ( ! empty($error)){ echo "<p class='bg-danger'>".$error."</p>"; }?>
			<br>
			
			<?php if (!empty($permisos['activity_add'])){?>
				<a href="<?php echo site_url('/activity/add/') ?>">
					<button class="btn btn-primary btn-label-left" type="button">
						<span><i class="fa fa-plus-circle"></i></span>
						Agregar Nuevo
					</button>
				</a>
			<?php }?>
			<?php $this->load->view('templates/search', array("table"=>'activity')); ?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<div class="box-name">
						<i class="fa fa-folder-open-o"></i>
						<span>Registro de Actividades de Usuarios</span>
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
								<th>Hora</th>
								<th id="sort_table" class="sorting" onclick="ordenar('tabla')">M&oacute;dulo</th>
								<th>Descripci&oacute;n</th>
								<th id="sort_table" class="sorting" onclick="ordenar('id_user')">Usuario</th>
							</tr>	
						</thead>
						<tbody>
							<?php 
							foreach($activities as $activity) 
							{
								echo "<tr>";	
									echo "<td>".format_fecha($activity->fecha)."</td>";
									echo "<td>".format_hora($activity->fecha)."</td>";
									echo "<td>".ucwords($activity->tabla)."</td>";
								    echo "<td>";
								    	if ($activity->tabla == 'siniestros')
								   			echo "<a href='".site_url('siniestros/details/'.$activity->id_item)."'>".$activity->descripcion."</a>";
								    	else if ($activity->tabla == 'victimas')
								    		echo "<a href='".site_url('siniestros/updatevictimas/'.$activity->id_item)."'>".$activity->descripcion."</a>";
								    	else if ($activity->tabla == 'users')
								    		echo "<a href='".site_url('users/update/'.$activity->id_item)."'>".$activity->descripcion."</a>";
								    	else
								    		echo $activity->descripcion;
								    echo "</td>";
								    echo "<td>".$activity->username."</td>";
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
							
<?php
	function format_fecha($fecha){
		$date = new DateTime($fecha);
		return $date->format('d-m-Y');
	}
	function format_hora($fecha){
		$date = new DateTime($fecha);
		return $date->format('H:i');
	}
?>