<?php
// We change the headers of the page so that the browser will know what sort of file is dealing with. Also, we will tell the browser it has to treat the file as an attachment which cannot be cached.
 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=siniestros.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<table border="1" >
	<thead>
		<tr>
			<?php if (empty($id_ciudad)) echo "<th>Municipio</th>"?>
			<th>Localidad</th>
			<th>Fecha</th>
			<th>Hora</th>
			<th>Lugar</th>
			<th>Ruta o Calle</th>
			<th>Entre calle 1</th>
			<th>Entre calle 2</th>
			<th>Nro/km</th>
			<th>Detalle de ubicaci&oacute;n</th>
			<th>Mec&aacute;nica del Hecho</th>
			<th>Descripci&oacute;n</th>
			<th>Tipo de Calzada</th>
			<th>Clima</th>
			<th>Visibilidad:</th>
			<th>Causa 1</th>
			<th>Causa 2</th>
			<th>Causa 3</th>
			<th>Fuerza</th>
			<th>Implicados</th>
			<th>Implicados Fatales</th>
                        <th>Veh&iacute;culos</th>
		</tr>	
	</thead>
	<tbody>
		<?php
		if ($siniestros)
		{
			foreach($siniestros as $siniestro) 
			{
				echo "<tr>";
					if (empty($id_ciudad)) echo "<td>".utf8_decode($siniestro->ciudad)."</td>";
					echo "<td>".utf8_decode($siniestro->localidad)."</td>";
					echo "<td>".format_fecha($siniestro->fecha)."</td>";
					echo "<td>".format_hora($siniestro->fecha)."</td>";
					echo "<td>".utf8_decode($siniestro->tipocalle)."</td>";
					echo "<td>".utf8_decode($siniestro->calle1)."</td>";
					echo "<td>".utf8_decode($siniestro->calle2)."</td>";
					echo "<td>".utf8_decode($siniestro->calle3)."</td>";
					echo "<td>".$siniestro->nro."</td>";
					echo "<td>".utf8_decode($siniestro->ubicacion)."</td>";
					echo "<td>".utf8_decode($siniestro->tipo)."</td>";
					echo "<td>".utf8_decode($siniestro->descripcion)."</td>";
					echo "<td>".utf8_decode($siniestro->tipocalzada)."</td>";
					echo "<td>".utf8_decode($siniestro->clima)."</td>";
					echo "<td>".utf8_decode($siniestro->horario)."</td>";
					echo "<td>".utf8_decode($siniestro->causaTxt)."</td>";
					echo "<td>".utf8_decode($siniestro->causa2Txt)."</td>";
					echo "<td>".utf8_decode($siniestro->causa3Txt)."</td>";
					echo "<td>".utf8_decode($siniestro->fuerza)."</td>";
					echo "<td>".$siniestro->victimas."</td>";
					echo "<td>".$siniestro->victimas_fatales."</td>";
                                        echo "<td>".$siniestro->vehiculos."</td>";
			    echo "</tr>";
			}
		}
		else
		{
			echo "<tr><td colspan='13'>No se han encontrado resultados.</td></tr>";
		}
		?>
	</tbody>
</table>
					
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