<!--Start Content-->
<div id="content" class="col-xs-12 col-sm-10">

	<div class="row">
		<div id="breadcrumb" class="col-md-12">
			<ol class="breadcrumb">
				<li><a href="<?php echo site_url('/home/'); ?>">Inicio</a></li>
				<li><a href="<?php echo site_url('/users/index'); ?>">Usuarios</a></li>
				<li><a href="#">Permisos del usuario</a></li>
			</ol>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<h3 class="page-header">Permisos del Usuario</h3>
			<BR>
			<?php if ( ! empty($msg)){ echo "<div class='msg'>".$msg."</div>"; }?>
			<?php if ( ! empty($error)){ echo "<div class='error'>".$error."</div>"; }?>
			<br>
		</div>	
	</div>
	
	<div class="row">	
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<div class="box-name">
						<i class="fa fa-folder-open-o"></i>
						<span>Formulario de permisos</span>
					</div>
					<div class="box-icons">
						<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
						<a class="expand-link"><i class="fa fa-expand"></i></a>
						
					</div>
					<div class="no-move"></div>
				</div>
				<div class="box-content no-padding">
					<?php echo form_open('users/permisos/'.$user['id'], array('id' => 'permisosForm')); ?>
					<input type="hidden" value="1" name="sendform">
					<table class="table table-bordered table-striped table-hover table-heading table-datatable" id="datatable-3">
						<thead>
							<tr>
								<th>M&oacute;dulo</th>
								<th>Nombre</th>
								<th>Permiso</th>
							</tr>	
						</thead>
						<tbody>
						
						<?php 
						foreach($permisos as $permiso) 
						{
							echo "<tr>";
							    echo "<td>".$permiso->seccion."</td>";
							    echo "<td>".$permiso->permName."</td>";
							    echo "<td><input type='checkbox' value='".$permiso->ID."' "; if (isset($permisos_activos[$permiso->permKey]) && $permisos_activos[$permiso->permKey]==1  ) echo "checked='checked'"; echo "name='permisosArray[]'> </td>";
							echo "</tr>";
						}
						?>
						</tbody>
					</table>
					<div style="width:100%;text-align:center;padding:10px">
						<a href="#" onclick="$('#permisosForm').submit()">
							<button class="btn btn-primary btn-label-left" type="button">
								Grabar permisos
							</button>
						</a>
						<a href="#" onclick="$('#permisosForm').submit()">
							<button class="btn btn-primary btn-label-left" type="button">
								Cancelar
							</button>
						</a>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>

</div><!--End Content-->

