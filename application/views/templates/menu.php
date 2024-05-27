<?php 
$userLogged = $this->session->userdata('logged_user');
$permisos = $userLogged['permisos'];
if (!isset($section)){
	$section = "";
}
?>
<div id="sidebar-left" class="col-xs-2 col-sm-2">
	<ul class="nav main-menu">
		<li>
			<?php echo anchor('/home', '<i class="fa fa-dashboard"></i> Inicio', 'title="Usuarios"');?>
		</li>
			
		<?php if (!empty($permisos['siniestros_index'])){ ?>
		<li class="dropdown">
			<a href="#" <?php if ($section=='SINIESTROS'){?> class="dropdown-toggle active-parent active" <?php }else{ ?> class="dropdown-toggle" <?php }?>>
				<i class="fa fa-ambulance"></i>
				 <span class="hidden-xs">Siniestros</span>
			</a>
			<ul class="dropdown-menu" <?php if ($section=='SINIESTROS'){?> style="display:block" <?php }else{?> style="display:none"<?php }?>>
				<li><?php if (!empty($permisos['siniestros_index'])){echo anchor('/siniestros', 'Ver siniestros', 'title="siniestros"');}?></li>
				<li><?php if (!empty($permisos['siniestros_add']) && !empty($userLogged['id_ciudad'])){echo anchor('/siniestros/add', 'Agregar nuevo', 'title="Agregar nuevo"');}?></li>
				<li><?php if (true){echo anchor('/siniestros/add', 'Agregar nuevo', 'title="Agregar nuevo"');}?></li>
				<li><?php if (!empty($permisos['siniestros_imprimir'])){echo anchor('/siniestros/imprimir', 'Imprimir', 'title="Imprimir"');}?></li>
				<li><?php if (!empty($permisos['siniestros_map'])){echo anchor('/siniestros/map', 'Mapa', 'title="Mapa"');}?></li>
				<li><?php if (!empty($permisos['siniestros_heatmap'])){echo anchor('/siniestros/heatmap', 'Mapa de calor', 'title="Mapa de calor"');}?></li>
				<li><?php if (!empty($permisos['siniestros_stats'])){echo anchor('/siniestros/stats', 'Estad&iacute;sticas', 'title="Estad&iacute;sticas"');}?></li>
			</ul>
		</li>
		<?php }?>

		<?php if (!empty($permisos['config_ciudades']) || 
				  !empty($permisos['config_index']) ||
				  !empty($permisos['config_funcionarios']) ||
				  !empty($permisos['config_calles']) ||
				  !empty($permisos['config_rutas']) ||
			      !empty($permisos['config_localidades']) ||
				  !empty($permisos['activity_index'])){ ?>
		<li class="dropdown">
			<a href="#" <?php if ($section=='ADMINISTRACION'){?> class="dropdown-toggle active-parent active" <?php }else{ ?> class="dropdown-toggle" <?php }?>>
				<i class="fa fa-paperclip"></i>
				 <span class="hidden-xs">Administraci&oacute;n</span>
			</a>
			<ul class="dropdown-menu" <?php if ($section=='ADMINISTRACION'){?> style="display:block" <?php }else{?> style="display:none"<?php }?>>
				<li><?php if (!empty($permisos['config_ciudades']) && empty($userLogged['id_ciudad'])){echo anchor('/config/ciudades', 'Municipios', 'title="Municipios"');}?></li>
				<li><?php if (!empty($permisos['config_index']) && !empty($userLogged['id_ciudad'])){echo anchor('/config/config', 'Configuraci&oacute;n', 'title="Configuraci&oacute;n"');}?></li>
				<li><?php if (!empty($permisos['config_funcionarios'])){echo anchor('/config/funcionarios', 'Funcionarios', 'title="Administrar Funcionarios"');}?></li>
				<li><?php if (!empty($permisos['config_calles']) && !empty($userLogged['id_ciudad'])){echo anchor('/config/calles', 'Calles', 'title="Administrar Calles"');}?></li>
				<li><?php if (!empty($permisos['config_rutas'])){echo anchor('/config/rutas', 'Rutas', 'title="Administrar Rutas"');}?></li>
				<li><?php if (!empty($permisos['config_localidades']) && !empty($userLogged['id_ciudad'])){echo anchor('/config/localidades', 'Localidades', 'title="Administrar Localidades"');}?></li>
				<li><?php if (!empty($permisos['activity_index'])){echo anchor('/activity', 'Actividad de Usuarios', 'title="Actividad de Usuarios"');}?></li>
			</ul>
		</li>
		<?php }?>

		<?php  if (!empty($permisos['users_index'])){ ?>
		<li class="dropdown">
			<a href="#" <?php if ($section=='USUARIOS'){?> class="dropdown-toggle active-parent active" <?php }else{ ?> class="dropdown-toggle" <?php }?>>
				<i class="fa fa-group"></i>
				<span class="hidden-xs">Usuarios y Permisos</span>
			</a>
			<ul class="dropdown-menu" <?php if ($section=='USUARIOS'){?> style="display:block" <?php }else{?> style="display:none"<?php }?>>
				<li><?php if (!empty($permisos['users_index'])){echo anchor('/users', 'Usuarios', 'title="Usuarios"');}?></li>
				<li><?php if (!empty($permisos['users_roles'])){echo anchor('/users/roles', 'Roles', 'title="Roles"');}?></li>
			</ul>
		</li>
		<?php }?>
	</ul>
</div>