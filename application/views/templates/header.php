<!DOCTYPE html>
<html lang="en">
	<head>
		<?php 
			header('Content-Type: text/html; charset=UTF-8');
			ini_set('default_charset', 'utf-8');
		?>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
		<title>Siniestros</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="<?php echo base_url();?>assets/plugins/bootstrap/bootstrap.css" rel="stylesheet">
		<link href="<?php echo base_url();?>assets/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet">
		<link href="<?php echo base_url();?>assets/css/font-awesome.css" rel="stylesheet">
		<link href='https://fonts.googleapis.com/css?family=Righteous' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
		<link href="<?php echo base_url();?>assets/plugins/fancybox/jquery.fancybox.css" rel="stylesheet">
		<link href="<?php echo base_url();?>assets/plugins/fullcalendar/fullcalendar.css" rel="stylesheet">
		<link href="<?php echo base_url();?>assets/plugins/xcharts/xcharts.min.css" rel="stylesheet">
		<link href="<?php echo base_url();?>assets/plugins/select2/select2.css" rel="stylesheet">
		<!-- select -->
		<link href="<?php echo base_url();?>assets/plugins/select/bootstrap-select.min.css" rel="stylesheet">
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
		<!-- FIN select -->
		
		<!-- DataTable2 -->
		<link href="<?php echo base_url();?>assets/plugins/DataTables2/datatables.min.css" rel="stylesheet">
		<!-- FIN DataTable2 -->

		<link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet">
		<link href="<?php echo base_url();?>assets/css/jac.css" rel="stylesheet">
		<script src="<?php echo base_url();?>assets/plugins/jquery/jquery-2.1.0.min.js"></script>
		<script src="<?php echo base_url();?>assets/plugins/jquery-ui/jquery-ui.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="<?php echo base_url();?>assets/plugins/bootstrap/bootstrap.min.js"></script>
		<script src="<?php echo base_url();?>assets/plugins/justified-gallery/jquery.justifiedgallery.min.js"></script>
		<script src="<?php echo base_url();?>assets/plugins/tinymce/tinymce.min.js"></script>
		<script src="<?php echo base_url();?>assets/plugins/tinymce/jquery.tinymce.min.js"></script>
		<!-- All functions for this theme + document.ready processing -->
		<script src="<?php echo base_url();?>assets/js/devoops.js"></script>
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
	</head>
<body>
	<!--Start Header-->
	<div id="screensaver">
		<canvas id="canvas"></canvas>
		<i class="fa fa-lock" id="screen_unlock"></i>
	</div>
	
	<div id="modalbox">
		<div class="devoops-modal">
			<div class="devoops-modal-header">
				<div class="modal-header-name">
					<span>Basic table</span>
				</div>
				<div class="box-icons">
					<a class="close-link">
						<i class="fa fa-times"></i>
					</a>
				</div>
			</div>
			<div class="devoops-modal-inner">
			</div>
			<div class="devoops-modal-bottom">
			</div>
		</div>
	</div>
	
	<header class="navbar">
		<div class="container-fluid expanded-panel">
			<div class="row">
			
				<div id="top-panel" class="col-xs-12 col-sm-10" style="width:100%">
					<div class="row" style="padding-top:5px" >
						<div class="col-xs-8 col-sm-8"><?php 
							$user = $this->session->userdata('logged_user'); 
							if (!empty($user['logo_width']))
								$logo_width = $user['logo_width'];
							else
								$logo_width = "200";
							if (!empty($user['id_ciudad'])){ ?>
								<img class="logo_ciudad" <?php echo "width='".$logo_width."px'";?> style="float:left;margin-top:0px" src="<?php echo base_url();?>assets/img/logos/<?php echo $user['id_ciudad'].".png";?>"   >
							<?php 
							}?>
						</div>
						<div class="col-xs-4 col-sm-4 top-panel-right">
							<ul class="nav navbar-nav pull-right panel-menu">
								<li class="dropdown">
									<a href="#" class="dropdown-toggle account" data-toggle="dropdown">
										<div class="avatar">
											<img src="<?php echo base_url();?>assets/img/avatar.png" class="img-rounded" alt="avatar" />
										</div>
										<i class="fa fa-angle-down pull-right"></i>
										<div class="user-mini pull-right">
											<span class="welcome">Bienvenido,</span>
											<span>
												<?php 
												 	$user = $this->session->userdata('logged_user'); 
												 	echo $user['username']. "&nbsp;&nbsp";
												 ?>
											</span>
										</div>
									</a>
									<ul class="dropdown-menu">
										<li>
											<span class="hidden-sm text"><i class="fa fa-cog"></i>&nbsp;<?php echo anchor('/users/account', 'Mi cuenta', 'title="Mi cuenta"');?></span>
										</li>
										<li>
											<span class="hidden-sm text"><i class="fa fa-power-off"></i>&nbsp;<?php echo anchor('/login/logout', 'Cerrar Sesi&oacute;n', 'title="Cerrar Sesi&oacute;n"');?></span>
										</li>
				 					</ul>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
	
	<!--Start Container-->
	<div id="main" class="container-fluid">
		<div class="row">
			<?php $this->load->view('templates/menu'); ?>