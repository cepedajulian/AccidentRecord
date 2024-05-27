<html>

<head>
	<title>Siniestros</title>
	<!--<link rel="shortcut icon" href="<?php echo base_url();?>assets/img/favicon.ico" type="image/x-icon" />-->
	<link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/login.css" type="text/css" media="screen"/>
	

	<style type="text/css">
	    html, body {
	        height: 100%;
	        width: 100%;
	        padding: 0;
	        margin: 0;
	    }
	
	    #full-screen-background-image {
	        z-index: -999;
	        width: 100%;
	        height:100%;
	        position: fixed;
	        top: 0;
	        left: 0;
	    }
	</style>
	
</head>

<body style="background-color:#000; text-align:center;margin:0;padding:0">
	
	<br>
	<div style="width:80%;margin:auto" >
		<div style="clear:both"></div><br><br><br>
		<span style="color:#fff;font-size:38px">Siniestros</span><br><br>
		<span style="color:#555;font-size:22px">INICIAR SESION</span><br><br>
		
		<?php echo form_open('login/verify'); ?>
		<input class="form-control" type="text" style="width:235px" placeholder="Usuario" required="" id="username" name="username" value="admin1" autofocus><br><br>
		<input class="form-control" type="password" style="width:235px" placeholder="Contase&ntilde;a" required="" id="password" value="admin1" name="password"><br><br>
		
		<input type="image" onclick="document.forms[0].submit();" src="<?php echo base_url();?>assets/img/ingresar.png" width="120px">
		<?php echo form_close(); ?>  
		
		
		<div style="height:35px">
			<?php 
				if (validation_errors()){
					echo "<br><div class='error'>".validation_errors()."</div>"; 
				}
				if (isset($error)){
					echo "<br><div class='error'>$error</div>";
				}
			?>
		</div>
	</div>
</body>
</html>