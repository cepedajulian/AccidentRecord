<!--Start Content-->
<div id="content" class="col-xs-12 col-sm-10" style="background-size:25%; background-attachment: fixed;background-position:right bottom;background-repeat:no-repeat; background-image: url(<?php echo base_url();?>assets/img/back1.png)">
	
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
			<h3 class="page-header">Bienvenido, <?php echo $username?></h3>
			<br>
			<!--  h1 style="font-family: 'Droid Sans', sans-serif;">Bienvenido, <?php echo $username?></h1>-->
			<br>
			<?php if ( ! empty($error)){ echo "<div class='bg-danger'>ERROR: ".$error."</div>"; }?>
		</div>
	</div>
	
	<br><br>
	
	<?php if (!empty($permisos['siniestros_index']) ){ ?>
	<div class="row">
		<div class="col-xs-4">
			<div class="box" style="min-width:320px">
				<div class="box-header">
					<div class="box-name ">
						<i class="fa fa-search"></i>
						<span>B&uacute;squeda R&aacute;pida</span>
					</div>
				</div>
				<div class="box-content no-padding" style="overflow:hidden;min-height:176px">
					<br>
					<fieldset >
						<?php echo form_open('home/search', array('id' => 'formHome', 'class'=> 'form-horizontal bootstrap-validator-form')); ?>
						<div class="form-group">
							<label class="col-sm-3 control-label">DNI</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="dni" name="dni"  />
							</div>
							<label class="col-sm-3 control-label">Patente</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="patente" name="patente"  />
							</div>
						</div>
						</form>
					</fieldset>
					<div style="width:100%;text-align:right;padding:10px">
						<a href="#" onclick="$('#formHome').submit()">
							<button class="btn btn-primary btn-label-left" type="button">
								<span><i class="fa fa-search"></i></span>
								Buscar
							</button>
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-4" style="min-width:350px">
			<div class="box">
				<div class="box-header">
					<div class="box-name ">
						<i class="fa fa-bar-chart-o"></i>
						<span>Res&uacute;men General</span>
					</div>
				</div>
				
				<div class="box-content no-padding" style="overflow:hidden;min-height:176px;">
					<br>
					<table style="line-height:30px;margin: auto auto auto auto;" border=1>
						<tr>
							<td align="center">&nbsp;<b>Tipo</b>&nbsp;</td>
							<td align="center">&nbsp;<b>Parciales</b>&nbsp;</td>
							<td align="center">&nbsp;<b>Total</b>&nbsp;</td>
						</tr>
						<tr>
							<td align="center">&nbsp;<b>Siniestros</b>&nbsp;</td>
							<td align="left">
								<?php
								
								$totalSiniestros=0;
								foreach ($totalSiniestrosPorAnio as $row) {
    								echo "&nbsp;&nbsp;<b>".$row->anio."</b>:&nbsp;". $row->cantidad."&nbsp;&nbsp;<br>";
    								$totalSiniestros=$totalSiniestros+$row->cantidad;
								}
								
								?>
							</td>
							<td align="right">&nbsp;<?php echo $totalSiniestros;?>&nbsp;</td>		
						</tr>
						<tr>
							<td align="center">&nbsp;<b>Implicados</b>&nbsp;<br>&nbsp;(No Fatales)&nbsp;</td>
							<td align="left">
								<?php
								
								$totalVictimas=0;
								foreach ($totalImplicadosPorAnio as $row) {
    								echo "&nbsp;&nbsp;<b>".$row->anio."</b>:&nbsp;". $row->cantidad."&nbsp;&nbsp;<br>";
    								$totalVictimas=$totalVictimas+$row->cantidad;
								}
								
								?>
							</td>
							<td align="right">&nbsp;<?php echo $totalVictimas;?>&nbsp;</td>
						</tr>
						<tr>
							<td align="center">&nbsp;<b>Implicados</b>&nbsp;<br>&nbsp;Fatales&nbsp;</td>
							<td align="left">
								<?php
								
								$totalVictimasFatales=0;
								foreach ($totalVictimasPorAnio as $row) {
    								echo "&nbsp;&nbsp;<b>".$row->anio."</b>:&nbsp;". $row->cantidad."&nbsp;&nbsp;<br>";
    								$totalVictimasFatales=$totalVictimasFatales+$row->cantidad;
								}
								
								?>
							</td>
							<td align="right">&nbsp;<?php echo $totalVictimasFatales;?>&nbsp;</td>
						</tr>
					</table>
					<br>
				</div>
			
			</div>
		</div>
	</div>
	<?php }?>
</div><!--End Content-->