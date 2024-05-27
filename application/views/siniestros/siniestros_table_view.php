<table id="siniestrosTabla" name="siniestrosTabla" class="display compact" style="width:100%" cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">
	<thead>
       	<tr>
       		<th style='text-align:center'><i aria-hidden='true' title='Orden' alt='Orden'></i>&nbsp;&nbsp;#</th>
            <th style='text-align:center'><i class='fa fa-location-arrow' aria-hidden='true' title='Municipio' alt='Municipio'></i>&nbsp;&nbsp;Municipio</th>
           	<th style='text-align:center'><i class='fa fa-compass' aria-hidden='true' title='Localidad' alt='Localidad'></i>&nbsp;&nbsp;Localidad</th>
           	<th style='text-align:center'><i class='fa fa-calendar' aria-hidden='true' title='Fecha' alt='Fecha'></i>&nbsp;&nbsp;Fecha / Hora</th>
           	<th style='text-align:center'><i class='fa fa-compress' aria-hidden='true' title='Mecánica del Hecho' alt='Mecánica del Hecho'></i>&nbsp;&nbsp;Mecánica del Hecho</th>
           	<th style='text-align:center'><i class='fa fa-map-marker' aria-hidden='true' title='Lugar del Hecho' alt='Lugar del Hecho'></i>&nbsp;&nbsp;Lugar</th>
           	<th style='text-align:center'><i class='fa fa-truck' aria-hidden='true' title='Vehículos' alt='Vehículos'></i>&nbsp;&nbsp;Vehículos</th>
           	<th style='text-align:center'><i class='fa fa-ambulance' aria-hidden='true' title='Implicados' alt='Implicados'></i>&nbsp;&nbsp;Implicados<br>&nbsp;F&nbsp;|&nbsp;G&nbsp;|&nbsp;L&nbsp;|&nbsp;I&nbsp;</th>
           	<th style='text-align:center'><i class='fa fa-picture-o' aria-hidden='true' title='Cantidad de Imagenes' alt='Cant. Imagenes'></i>&nbsp;&nbsp;Imagenes</th>
           	<th style='text-align:center'><i class='fa fa-bars' aria-hidden='true' title='Acciones' alt='Acciones'></i>&nbsp;&nbsp;Acciones</th>
       	</tr>
   	</thead>
   	<p class="text-center">
   	<?php 
   	if($nml!='x'){echo "<b>Nivel máximo de lesión:</b>&nbsp;";}
   	if($nml=='f'){echo "Fallecidos.";}
   	if($nml=='g'){echo "Graves.";}
   	if($nml=='l'){echo "Leves.";}
   	if($nml=='i'){echo "Ilesos.";}
   	
	?>
	</p>
   	<tbody>
		<?php
		
		$i=0;
		foreach ($siniestrosEncontrados as $siniestro){
			
			switch ($nml) {
    			case 'x':
    				$i++;
    				tabla($i,$id_ciudad,$permisos,$siniestro);
        			break;
        			
    			case 'f':
    				if($siniestro->c_fatales>0){
    					$i++;
    					tabla($i,$id_ciudad,$permisos,$siniestro);
    				}
        			break;
        			
        		case 'g':
    				if($siniestro->c_fatales<1 and $siniestro->c_graves>0){
    					$i++;
    					tabla($i,$id_ciudad,$permisos,$siniestro);
    				}
        			break;
        		
        		case 'l':
    				if($siniestro->c_fatales<1 and $siniestro->c_graves<1 and $siniestro->c_leves>0){
    					$i++;
    					tabla($i,$id_ciudad,$permisos,$siniestro);
    				}
        			break;
        			
        		case 'i':
    				if($siniestro->c_fatales<1 and $siniestro->c_graves<1 and $siniestro->c_leves<1 and $siniestro->c_ilesos>0){
    					$i++;
    					tabla($i,$id_ciudad,$permisos,$siniestro);
    				}
        			break;
        			
        		case 's':
    				if($siniestro->c_fatales<1 and $siniestro->c_graves<1 and $siniestro->c_leves<1 and $siniestro->c_ilesos<1){
    					$i++;
    					tabla($i,$id_ciudad,$permisos,$siniestro);
    				}
        			break;
			}
		}
		?>
	</tbody>
</table>

<?php
function tabla($i,$id_ciudad,$permisos,$siniestro){
			echo "<tr>";
				echo "<td style='cursor: pointer;' title='ID Interno:&nbsp;".$siniestro->id."' alt='ID Interno:&nbsp;".$siniestro->id."'";
					if (!empty($permisos['siniestros_details'])){
						?> onclick="window.location='./siniestros/details/<?php echo $siniestro->id;?>';"><?php
					}
				echo "$i</td>";
				//echo "<td></td>";
				//--------------------------------------------------------------------------------------
				
				echo "<td style='cursor: pointer;' title='ID Interno:&nbsp;".$siniestro->id."' alt='ID Interno:&nbsp;".$siniestro->id."'";
					if (!empty($permisos['siniestros_details'])){
						?> onclick="window.location='./siniestros/details/<?php echo $siniestro->id;?>';"><?php
					}
				echo "$siniestro->ciudad</td>";
				
				//--------------------------------------------------------------------------------------
				
				echo "<td style='cursor: pointer;' title='ID Interno:&nbsp;".$siniestro->id."' alt='ID Interno:&nbsp;".$siniestro->id."'";
					if (!empty($permisos['siniestros_details'])){
						?> onclick="window.location='./siniestros/details/<?php echo $siniestro->id;?>';"><?php
					}
				echo "$siniestro->localidad</td>";
				
				//--------------------------------------------------------------------------------------

				echo "<td style='cursor: pointer;' title='ID Interno:&nbsp;".$siniestro->id."' alt='ID Interno:&nbsp;".$siniestro->id."'";
					if (!empty($permisos['siniestros_details'])){
						?> onclick="window.location='./siniestros/details/<?php echo $siniestro->id;?>';"><?php
					}
				echo "$siniestro->fecha"."&nbsp;".$siniestro->tiempo."</td>";
				
				//--------------------------------------------------------------------------------------
				
				echo "<td style='cursor: pointer;' title='ID Interno:&nbsp;".$siniestro->id."' alt='ID Interno:&nbsp;".$siniestro->id."'";
					if (!empty($permisos['siniestros_details'])){
						?> onclick="window.location='./siniestros/details/<?php echo $siniestro->id;?>';"><?php
					}
				echo "$siniestro->tipoaccidente</td>";
				
				//--------------------------------------------------------------------------------------
				
				echo "<td style='cursor: pointer;' title='ID Interno:&nbsp;".$siniestro->id."' alt='ID Interno:&nbsp;".$siniestro->id."'";
					if (!empty($permisos['siniestros_details'])){
						?> onclick="window.location='./siniestros/details/<?php echo $siniestro->id;?>';"><?php
					}
				echo "$siniestro->lugar :<br>";
				
				if (empty($siniestro->nro))
					$nro = "";
				else
					$nro = $siniestro->nro;
						    	
				   	if (!empty($siniestro->calle3))
				   		echo $siniestro->calle1.' '.$nro .' (entre: '.$siniestro->calle2.' y '.$siniestro->calle3.')';
				   	else if (!empty($siniestro->calle2))
				   		echo $siniestro->calle1.' '.$nro .' (esquina: '.$siniestro->calle2.')';
				   	else
				 		echo $siniestro->calle1.' '.$nro;
				
				echo "</td>";
				
				//--------------------------------------------------------------------------------------
				
				echo "<td style='text-align:center;cursor: pointer;'";
					if (!empty($permisos['siniestros_vehiculos'])){
						?> onclick="window.location='./siniestros/vehiculos/<?php echo $siniestro->id;?>';" <?php
					}
					echo "title='Vehículos' alt='Vehículos'>";
					if($siniestro->c_vehiculos>0){echo "<b>(".$siniestro->c_vehiculos.")</b>";}else{echo "<span title='Sin datos' alt='Sin datos'></span>";};
				echo "</td>";
				
				//--------------------------------------------------------------------------------------
				
				echo "<td style='text-align:center;cursor: pointer;'";
					if (!empty($permisos['siniestros_victimas'] and ($siniestro->c_fatales>0 or $siniestro->c_graves>0  or $siniestro->c_leves>0  or $siniestro->c_ilesos>0))){
						?> onclick="window.location='./siniestros/victimas/<?php echo $siniestro->id;?>';"> <?php
					}
				
					//--------------------------------------------------------------------------------------
				
					echo "<span ";
					if($siniestro->c_fatales>0){
						echo "style='color:red;' title='Fatales' alt='Fatales'>&nbsp;<b>($siniestro->c_fatales)</b>&nbsp;";
					}else{
						echo "title='Sin Implicados Fatales' alt='Sin Implicados Fatales'>&nbsp;&nbsp;-&nbsp;&nbsp;";
					};
					echo "</span>|";
					
					echo "<span ";
					if($siniestro->c_graves>0){
						echo "style='color:green;' title='graves' alt='gravess'>&nbsp;<b>($siniestro->c_graves)</b>&nbsp;";
					}else{
						echo "title='Sin Implicados graves' alt='Sin Implicados graves'>&nbsp;&nbsp;-&nbsp;&nbsp;";
					};
					echo "</span>|";
					
					echo "<span ";
					if($siniestro->c_leves>0){
						echo "style='color:green;' title='leves' alt='leves'>&nbsp;<b>($siniestro->c_leves)</b>&nbsp;";
					}else{
						echo "title='Sin Implicados leves' alt='Sin Implicados leves'>&nbsp;&nbsp;-&nbsp;&nbsp;";
					};
					echo "</span>|";
					
					echo "<span ";
					if($siniestro->c_ilesos>0){
						echo "style='color:green;' title='ilesos' alt='ilesoss'>&nbsp;<b>($siniestro->c_ilesos)</b>&nbsp;";
					}else{
						echo "title='Sin Implicados ilesos' alt='Sin Implicados ilesos'>&nbsp;&nbsp;-&nbsp;&nbsp;";
					};
					echo "</span>";
					
				echo "</td>";
				
				//--------------------------------------------------------------------------------------
					
				echo "<td style='text-align:center;";
					if (!empty($permisos['siniestros_fotos'] and $siniestro->c_imagenes>0)){
						?> cursor: pointer;' onclick="window.location='./siniestros/fotos/<?php echo $siniestro->id;?>';" <?php
					}
					if($siniestro->c_imagenes>0){echo "'><span title='Imagenes' alt='Imagenes'><b>(".$siniestro->c_imagenes.")</b></span>";}else{echo "'><span title='Sin imagenes' alt='Sin imagenes'>-</span>";};
				echo "</td>";
					
				echo "<td width='120px' align='center'>";
					//--------------------------------------------------------------------------------------
					if (!empty($permisos['siniestros_details'])){
						echo "&nbsp;<a href='./siniestros/details/$siniestro->id'><i class='fa fa-list-alt' aria-hidden='true' title='Detalles' alt='Detalles'></i></a>&nbsp;";
					}else{
						echo "&nbsp;<i class='fa fa-list-alt' aria-hidden='true' title='Detalles' alt='Detalles'></i>&nbsp;";
					}
					
					//--------------------------------------------------------------------------------------
					
					if (!empty($permisos['siniestros_update']) && !empty($id_ciudad) ){
						echo "&nbsp;<a href='./siniestros/update/$siniestro->id'><i class='fa fa-pencil-square-o' aria-hidden='true'  title='Editar' alt='Editar'></i></a>&nbsp;";
					}else{
						echo "&nbsp;<i class='fa fa-pencil-square-o' aria-hidden='true'  title='Editar' alt='Editar'></i>&nbsp;";
					}
					
					//--------------------------------------------------------------------------------------
					
					if (!empty($permisos['siniestros_delete']) && !empty($id_ciudad) ){
						echo "<a class='borrarLink' href='./siniestros/delete/$siniestro->id'><i class='fa fa-trash-o' aria-hidden='true' title='Borrar' alt='Borrar'></i></a>";
					}else{
						echo "<i class='fa fa-trash-o' aria-hidden='true' title='Borrar' alt='Borrar'></i>";
					}
				echo "</td>";
			
			echo "</tr>";	
}
?>

<script type="text/javascript">

	$(document).ready( function () {
	    
	    $('a.borrarLink').click(function() {
			var a = this;
			bootbox.confirm({
				title: "Por favor seleccione",
				message: "¿Seguro que desea borrar este siniestro?",
				backdrop: true,
				buttons: {
					cancel: {
						label: '<i class="fa fa-times"></i> Cancelar',
						className: 'btn-danger'
					},
					confirm: {
						label: '<i class="fa fa-check"></i> Confirmar',
						className: 'btn-success'
					}
				},
				callback: function (result) {
					if(result==true){
						$.get( a, function( data ){Buscar();});
					}	
				}
			});
			
			return false;
		});
		
		$('#siniestrosTabla').DataTable( {
			"language": {
            "url": "<?php echo base_url();?>assets/plugins/DataTables2/spanish.json"
        },
			scrollY:        '50vh',
        scrollCollapse: true,
        paging:         false,
			stateSave: true,
			buttons: [
        'pdf'
    ]
		} );
	});
</script>