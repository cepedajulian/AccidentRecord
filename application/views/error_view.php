<!--Start Content-->
<div id="content" class="col-xs-12 col-sm-10">
	<div class="row">
		<div id="breadcrumb" class="col-md-12">
			<a href="#" class="show-sidebar"><i class="fa fa-bars"></i></a>
			<ol class="breadcrumb">
				<li><a href="#">Inicio</a></li>
			</ol>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<h3 class="page-header">Home</h3>
			<br>
			<div id="page-wrap">
				<br>
				<div class='bg-danger'> <?php if ( ! empty($error)){ echo "<div class='error'>ERROR: ".$error."</div>"; }?></div>
				<br>
				<a href="#" onclick="history.back()">
					<button class="btn btn-primary btn-label-left" type="button">
						Volver
					</button>
				</a>
			</div>
			<br>
		</div>
	</div>
	
</div><!--End Content-->
