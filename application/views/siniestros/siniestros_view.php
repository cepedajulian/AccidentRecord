<!--Start Content-->
<div id="content" class="col-xs-12 col-sm-10">
	<div class="row">
		<div id="breadcrumb" class="col-md-12">
			<a href="#" class="show-sidebar"><i class="fa fa-bars"></i></a>
			<ol class="breadcrumb">
				<li><a href="<?php echo site_url('/home/'); ?>">Inicio</a></li>
				<li>Siniestros</li>
			</ol>
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<h3 class="page-header">Siniestros</h3>
			<?php if ( ! empty($msg)){ echo "<p class='bg-success'>".$msg."</p>"; }?>
			<?php if ( ! empty($error)){ echo "<p class='bg-danger'>".$error."</p>"; }?>
		</div>
	</div>
	
	<div class="panel panel-default">
		<div class="panel-body">
			<form id="myForm" name="myForm">
				<fieldset>
					 <legend>&nbsp;&nbsp;Incluir:</legend> 
					 <i>(Si no selecciona se mostraran todos)</i><br><br>
				<div class="row">
					<div class="col-sm-1">
					</div>
					<div class="col-sm-3">
						<label for="id_ciudad">Municipio:</label>&nbsp;<br>
						<select id="id_ciudad" name="id_ciudad" class="selectpicker" multiple>
							<?php foreach($ciudades as $ciudad){?>
								<?php if (empty($id_ciudad)){?>
									<option  value="<?php echo $ciudad->id; ?>" <?php if($ciudad->id == $criteria['idc']) echo "selected=selected"; ?>>
										<?php echo $ciudad->ciudad; ?>
									</option>
								<?php }else{
									if ($id_ciudad==$ciudad->id){
										?>
										<option  value="<?php echo $ciudad->id;?>" selected="selected" disabled>
											<?php echo $ciudad->ciudad; ?>
										</option>
										<?php
									}
								}
							}?>
						</select>
					</div>
				
					<div class="col-sm-3">
						<label for="id_localidad">Localidad:&nbsp;</label><br>
						<select id="id_localidad" name="id_localidad" class="selectpicker" multiple>
							<?php foreach($localidades as $localidad){?>
								<option  value="<?php echo $localidad->id; ?>" <?php if($localidad->id == $criteria['idl']) echo "selected=selected"; ?>>
									<?php echo $localidad->localidad; ?>
								</option>
							<?php }?>
						</select>
					</div>
					
					<div class="col-sm-3">
						<label for="tipocalle">Tipo:</label>&nbsp;<br>
						<select id="tipocalle" name="tipocalle" class="selectpicker">
							<option value="x">No hay selección</option>
							<option value="URBANA">URBANA</option>
							<option value="RUTA">RUTA</option>
						</select>
					</div>
				</div>
				
				<br>
				
				<div class="row">
					<div class="col-sm-1">
					</div>
					<div class="col-sm-3">
						<label for="tipo">Participación de vehiculo:</label>&nbsp;<br>
						<select id="tipo" name="tipo" class="selectpicker" multiple>
							<?php foreach ($tipovehiculos as $tipovehiculo){ ?>
									<option value="<?php echo $tipovehiculo->tipovehiculo; ?>">
										<?php echo $tipovehiculo->tipovehiculo; ?>
									</option>
							<?php }?>	
						</select>
					</div>
					
					<div class="col-sm-3">
						<label for="tipoaccidente">Mecánica del Hecho:</label>&nbsp;<br>
						<select id="tipoaccidente" name="tipoaccidente" class="selectpicker" multiple>
							<?php foreach($tipoaccidentes as $ta){?>
									<option  value="<?php echo $ta->id; ?>" <?php if(!empty($criteria['tipoaccidente']) && $ta->id == $criteria['tipoaccidente']) echo "selected=selected"; ?>>
										<?php echo utf8_decode($ta->tipoaccidente); ?>
									</option>
							<?php }?>
						</select>
					</div>
				
					<div class="col-sm-3">
						<label for="lesion">Categoría:</label>&nbsp;<br>
						<select id="lesion" name="lesion" class="selectpicker" multiple>
							<option value="FALLECIDO">FALLECIDO</option>
							<option value="GRAVE">GRAVE</option>
							<option value="LEVE">LEVE</option>
							<option value="ILESO">ILESO</option>
						</select>
					</div>
				</div>
				
				<br>
				
				<div class="row">
					<div class="col-sm-1">
					</div>
					<div class="col-sm-2">
						<label for="fd">Fecha:&nbsp;</label>(Desde)<br>
						<input type="text" id="fd"  name="fd" class="form-control" value="" >
					</div>
					
					<div class="col-sm-1">
					</div>
					
					<div class="col-sm-2">
						<label for="fh">Fecha:&nbsp;</label>(Hasta)<br>
						<input type="text" id="fh"  name="fh" class="form-control" value="" >
					</div>
				</div>
				
				<br>
				
				<div class="row">
					<div class="col-sm-1">
					</div>
					<div class="col-sm-3">
						<label for="hora1">Horas&nbsp;</label>(Desde)<br>
						<select id="hora1" name="hora1" class="selectpicker" width: '100px'>
							<option value="x">No hay selección</option>
							<?php for ($i = 0; $i <= 23; $i++) { ?>
									<option value="<?php if($i<10){echo '0';}; echo $i;?>:00">
										<?php if($i<10){echo '0';}; echo $i;?>:00
									</option>
							<?php }?>
						</select>
					</div>
					<div class="col-sm-3">
						<label for="hora2">Horas&nbsp;</label>(Hasta)<br>
						<select id="hora2" name="hora2" class="selectpicker" width: '100px'>
							<option value="x">No hay selección</option>
							<?php for ($i = 0; $i <= 23; $i++) { ?>
									<option value="<?php if($i<10){echo '0';}; echo $i;?>:59">
										<?php if($i<10){echo '0';}; echo $i;?>:59
									</option>
							<?php }?>
						</select>
					</div>
				</div>
				</fieldset>
				<br>
				<fieldset>
					<legend>&nbsp;&nbsp;Filtrar implicados:</legend>
					<i>(Nivel máximo de lesión en el siniestro)</i><br><br>
				<div class="row">
					<div class="col-sm-2">
						<input type="radio" name="nml" value="x" checked>&nbsp;No Aplicar&nbsp;&nbsp;
					</div>
					<div class="col-sm-2">
						<input type="radio" name="nml" value="f">&nbsp;FALLECIDOs&nbsp;&nbsp;
					</div>
					<div class="col-sm-2">
						<input type="radio" name="nml" value="g">&nbsp;GRAVEs&nbsp;&nbsp;
					</div>
					<div class="col-sm-2">
						<input type="radio" name="nml" value="l">&nbsp;LEVEs&nbsp;&nbsp;
					</div>
					<div class="col-sm-2">
						<input type="radio" name="nml" value="i">&nbsp;ILESOs&nbsp;&nbsp;
					</div>
					<div class="col-sm-2">	
						<input type="radio" name="nml" value="s">&nbsp;(Sin Implicados)
					</div>
				</div>
				</fieldset>
				<br>
				
				<div class="row">
					<div class="col-sm-4">						
						<div style="width:100%;text-align:left;padding:10px">
							<a href="#" onclick="Buscar();">
								<button class="btn btn-primary btn-label-left" type="button">
									Buscar
								</button>
							</a>
							<a href="#" onclick="$('#formSiniestros').attr('action','<?php echo site_url("/siniestros/export")?>');$('#formSiniestros').submit()">
								<button class="btn btn-primary btn-label-left" type="button">
									Exportar
								</button>
							</a>
							<a href="<?php echo site_url('/siniestros/'); ?>">
								<button class="btn btn-primary btn-label-left" type="button">
									Limpiar
								</button>
							</a>
							<?php if (!empty($permisos['siniestros_add']) && !empty($id_ciudad)){?>
							&nbsp;&nbsp;&nbsp;&nbsp;
							<a href="<?php echo site_url('/siniestros/add/') ?>">
								<button class="btn btn-primary btn-label-left" type="button"><span><i class="fa fa-plus-circle"></i></span>Agregar Siniestro</button>
							</a>
							<?php }?>
						</div>
					</div>
				</div>
				<br>
				<br>
				<div class="row">
					<div class="col-sm-12">
						<div id="resultado_busqueda"></div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div><!--End Content-->
							
<script src="<?php echo base_url();?>assets/js/modal.popup.js"></script>
<script src="<?php echo base_url();?>assets/plugins/select/bootstrap-select.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/select/i18n/defaults-es_ES.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/DataTables2/datatables.min.js"></script>

<script type="text/javascript">
	function format_fecha(var1){
		var1=var1.split("/");
		return var1[2]+'-'+var1[1]+'-'+var1[0];
	}
	
	function Buscar(){
		var filtro='';
		var primerGrupo=true;
		var	primerItem=true;
		
		if($("#id_ciudad :selected").length>0){;
			if(primerGrupo==true){
				filtro=filtro+'(';
			}else{
				filtro=filtro+' AND (';
			}
			
			primerGrupo=false;
			
			primerItem=true;
			$("#id_ciudad :selected").map(function(i, el) {
	    		if(primerItem==true){
    				filtro=filtro+" id_ciudad="+$(el).val();
				}else{
					filtro=filtro+" OR id_ciudad="+$(el).val();
				}
				
    			primerItem=false;
			});
			
			filtro=filtro+')';
		}
		
		if($("#id_localidad :selected").length>0){;
			if(primerGrupo==true){
				filtro=filtro+'(';
			}else{
				filtro=filtro+' AND (';
			}
			
			primerGrupo=false;
			
			primerItem=true;
			$("#id_localidad :selected").map(function(i, el) {
	    		if(primerItem==true){
    				filtro=filtro+" id_localidad="+$(el).val();
				}else{
					filtro=filtro+" OR id_localidad="+$(el).val();
				}
				
    			primerItem=false;
			});
		
			filtro=filtro+')';
		}
		
		
		if($('#tipocalle').val()!='x'){
			if(primerGrupo==false){
				filtro=filtro+' AND ';
			}
				
			filtro=filtro+" tipocalle='"+$('#tipocalle option:selected').val()+"'";
			
			primerGrupo=false;
		}
		
		if($("#tipoaccidente :selected").length>0){;
			if(primerGrupo==true){
				filtro=filtro+'(';
			}else{
				filtro=filtro+' AND (';
			}
			
			primerGrupo=false;
	
			primeroItem=true;
			$("#tipoaccidente :selected").map(function(i, el) {
	    		if(primeroItem==true){
    				filtro=filtro+ "tipoaccidente="+$(el).val();
				}else{
					filtro=filtro+" OR tipoaccidente="+$(el).val();
				}
    			primeroItem=false;
			});
			
			filtro=filtro+')';
		}
		
		if($("#lesion :selected").length>0){;
			if(primerGrupo==true){
				filtro=filtro+'(';
			}else{
				filtro=filtro+' AND (';
			}
			
			primerGrupo=false;
			
			primeroItem=true;
			$("#lesion :selected").map(function(i, el) {
    			if(primeroItem==true){
    				filtro=filtro+ "victimas.lesion='"+$(el).val()+"'";
				}else{
					filtro=filtro+" OR victimas.lesion='"+$(el).val()+"'";
				}
				
    			primeroItem=false;
			});
		
			filtro=filtro+')';
		}
		
		if($("#tipo :selected").length>0){;
			if(primerGrupo==true){
				filtro=filtro+'(';
			}else{
				filtro=filtro+' AND (';
			}
			
			primerGrupo=false;
			
			primeroItem=true;
			$("#tipo :selected").map(function(i, el) {
	    		if(primeroItem==true){
    				filtro=filtro+ "tipo='"+$(el).val()+"'";
				}else{
					filtro=filtro+" OR tipo='"+$(el).val()+"'";
				}
				
    			primeroItem=false;
			});
		
			filtro=filtro+')';
		}
		
		if($('#fd').val()!=''){
			if(primerGrupo==false){
				filtro=filtro+' AND ';
			}
				
			filtro=filtro+" fecha>='"+format_fecha($('#fd').val())+"'";
			primerGrupo=false;
		}
		
		if($('#fh').val()!=''){
			if(primerGrupo==false){
				filtro=filtro+' AND ';
			}
				
			filtro=filtro+" fecha<='"+format_fecha($('#fh').val())+"'";
			primerGrupo=false;
		}
		
		
		if($('#hora1').val()!='x'){
			if(primerGrupo==false){
				filtro=filtro+' AND ';
			}
				
			filtro=filtro+" TIME(fecha)>='"+$('#hora1').val()+"'";
			primerGrupo=false;
		}
		
		if($('#hora2').val()!='x'){
			if(primerGrupo==false){
				filtro=filtro+' AND ';
			}
				
			filtro=filtro+" TIME(fecha)<='"+$('#hora2').val()+"'";
			primerGrupo=false;
		}
		
		
		if(primerGrupo==false){
			filtro=filtro+' AND ';
		}
		
		filtro=filtro+'siniestros.borrado=0';
		primerGrupo=false;
		
		//alert("OPCION EN DESARROLLO\n"+filtro);
		
		nml=$('input:radio[name=nml]:checked').val(); //nivel maximo de lesionado (filtro radio button)
		$("#resultado_busqueda").html("<img src='<?php echo base_url();?>assets/img/loading.gif'/>");
		$.get( './siniestros/buscar?filtro='+filtro+'&nml='+nml, function( data ){$( '#resultado_busqueda' ).html( data );});
	}
	
	$(document).ready(function() {
		$( "#fd" ).datepicker({ maxDate: new Date('<?php echo date('Y,m,d');?>') });
		$( "#fh" ).datepicker({ maxDate: new Date('<?php echo date('Y,m,d');?>') })
	});
	
	//acordion
	var acc = document.getElementsByClassName("accordion");
	var i;

	for (i = 0; i < acc.length; i++) {
  		acc[i].onclick = function() {
    		this.classList.toggle("active");
    		var panelColapse = this.nextElementSibling;
    		if (panelColapse.style.maxHeight){
	      		panelColapse.style.maxHeight = null;
    		} else {
	      		panelColapse.style.maxHeight = panelColapse.scrollHeight + "px";
    		}
  		}
	}
	//fin acordion
</script>