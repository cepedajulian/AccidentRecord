<?php
header('Content-Type: application/json');
$json_response			= new StdClass;
$json_response->error 	= false;

foreach ($siniestrosEncontrados as $siniestro){
	if (!empty($siniestro->latlng)){
		$latlng = explode(',',$siniestro->latlng);
		
		$descripcion = trim(preg_replace('/\s+/', ' ', $siniestro->descripcion))."<br><hr><b>Fecha:</b>&nbsp;&nbsp;". $siniestro->fecha."&nbsp;&nbsp;".$siniestro->tiempo." Hs:<br><b>Implicados</b><br>&nbsp;&nbsp;&nbsp;&nbsp;Fatales:&nbsp;&nbsp;".$siniestro->c_fatales."<br>&nbsp;&nbsp;&nbsp;&nbsp;Graves:&nbsp;&nbsp;".$siniestro->c_graves."<br>&nbsp;&nbsp;&nbsp;&nbsp;Leves:&nbsp;&nbsp;".$siniestro->c_leves."<br>&nbsp;&nbsp;&nbsp;&nbsp;Ilesos:&nbsp;&nbsp;".$siniestro->c_ilesos."<br><b>Tipo de accidente:</b>&nbsp;&nbsp;".$siniestro->tipoaccidente;
				    	                     
		if($siniestro->c_fatales>0){$color= "red";}else{$color= "green";}
		$lugar[]=[
			'lat'	=> floatval($latlng[0]),
			'lng'	=> floatval($latlng[1]),
			'info'	=> $descripcion,
			'color' => $color
		];

		$json_response->datos=$lugar;
	}
}
echo json_encode( $json_response );
?>