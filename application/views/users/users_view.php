<!--Start Content-->
<div id="content" class="col-xs-12 col-sm-10">
	<div class="row">
		<div id="breadcrumb" class="col-md-12">
			<a href="#" class="show-sidebar"><i class="fa fa-bars"></i></a>
			<ol class="breadcrumb">
				<li><a href="<?php echo site_url('/home/'); ?>">Inicio</a></li>
				<li><a href="#">Usuarios</a></li>
			</ol>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<h3 class="page-header">Usuarios</h3>
			<br>
			<?php if ( ! empty($msg)){ echo "<p class='bg-success'>".$msg."</p>"; }?>
			<?php if ( ! empty($error)){ echo "<p class='bg-danger'>".$error."</p>"; }?>
			<br>
			
			<?php if (!empty($permisos['users_add'])){?>
				<a href="<?php echo site_url('/users/add/') ?>">
					<button class="btn btn-primary btn-label-left" type="button">
						<span><i class="fa fa-plus-circle"></i></span>
						Agregar Nuevo
					</button>
				</a>
			<?php }?>
		   		
	    	<?php if (!empty($permisos['users_add'])){?>
				<a href="<?php echo site_url('/users/roles/') ?>">
					<button class="btn btn-primary btn-label-left" type="button">
						<span><i class="fa fa-gears"></i></span>
						Administrar roles
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
						<span>Usuarios del sistema</span>
					</div>
					<div class="box-icons">
						<a class="collapse-link">
							<i class="fa fa-chevron-up"></i>
						</a>
						<a class="expand-link">
							<i class="fa fa-expand"></i>
						</a>
						<a class="close-link">
							<i class="fa fa-times"></i>
						</a>
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
								<th>N&uacute;mero</th>
								<th>Nombre</th>
								<th>Mail</th>
								<th>Ultimo acceso</th>
								<th>Estado</th>
								<th>Roles</th>
								<th>Acciones</th>
							</tr>	
						</thead>
						<tbody>
							<?php 
							foreach($users as $user) 
							{
								echo "<tr>";
									if (!empty($user['ciudad'])){
										echo "<td>".$user['ciudad']."</td>";
									}
									else
										echo "<td>TODOS</td>";
								    echo "<td>".$user['id']."</td>";
								    echo "<td>".strtoupper($user['username'])."</td>";
								    echo "<td>".strtoupper($user['mail'])."</td>";
								    echo "<td>".$user['last_login']."</td>";
								    echo "<td>";
								    	if ($user['wrongpass'] > 3)
								    		echo  anchor('/users/reset/'.$user['id'], 'BLOQUEADO', 'title="Desbloquear"');
										else
								    		echo "ACTIVO";
								    echo "</td>";
								    echo "<td>"; 
								   		if (!empty($user['roles']))
									   		foreach($user['roles'] as $rol) 
											{
												echo "<div> - ".strtoupper($rol)."</div>";
											}
								    echo "&nbsp;</td>";
								    echo "<td>";

									   
									    if (!empty($permisos['users_update'])){
									    	echo "<a href='".site_url('/users/update/'.$user['id'])."'>";
												echo "<i class='fa fa-lg  fa-pencil-square-o'></i></span>";
											echo "<a/>&nbsp;&nbsp;";
								    	}
								    	
										if (!empty($permisos['users_delete'])){
											echo "<a href='".site_url('/users/delete/'.$user['id'])."'>";
											echo "<i class='fa fa-lg fa-trash-o'></i></span>";
											echo "<a/>&nbsp;&nbsp;";
										}
									echo "</td>";
							    echo "</tr>";
							}
							?>
						</tbody>
					</table>
					<?php echo $this->pagination->create_links(); ?>
				</div>
			</div>
		</div>
	</div>
	
</div><!--End Content-->